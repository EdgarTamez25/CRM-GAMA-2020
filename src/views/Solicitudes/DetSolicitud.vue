<template>
  <v-main class="pa-0 ma-3">

    <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
      <strong> {{alerta.text}} </strong>
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
      </template>
    </v-snackbar>
	
    <v-row justify="center">
      <v-col cols="12" lg="9" xl="8" >
        <v-card class="pa-4" outlined>
          <v-row >

            <v-col cols="12" class="text-right">
              <v-card-actions class="py-0">
                <v-btn text onClick="history.go(-1); return false;"> <v-icon large>mdi-arrow-left-thick</v-icon> </v-btn>  <v-spacer></v-spacer>
                <span class="overline font-weight-black py-0" >N° solicitud: {{ solicitud.id }} </span>
              </v-card-actions>
            </v-col>

            <v-col cols="12"  md="7"  xl="6" >
              <v-card outlined>
                <v-simple-table dense >
                  <template v-slot:default>
                    <tbody >
                      <tr >
                        <td class="font-weight-black">CLIENTE</td>
                        <td class="subtitle-1"  align="left"> {{ solicitud.nomcli }}</td>
                      </tr>
                      <tr>
                        <td class="font-weight-black">RESPONSABLE</td>
                        <td class="subtitle-1">{{ solicitud.nomusuario }}</td>
                      </tr>
                      <tr>
                        <td class="font-weight-black">FECHA Y HORA</td>
                        <td class="subtitle-1">
                        {{  moment(solicitud.fecha + ' '  + solicitud.hora).format('llll') }}
                         
                        </td>
                      </tr>
                      <tr>
                        <td class="font-weight-black">NOTA</td>
                        <td class="subtitle-1"> {{ solicitud.nota }}</td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-card>
            </v-col>
            <v-col cols="12"  md="5" xl="6" >
              <v-btn block color="gris" outlined @click="modalCancelar = true; accion=1"     dark 
                     v-if="solicitud.estatus != 4 && solicitud.procesado != 1">CANCELAR SOLICITUD 
              </v-btn>
              <v-btn block color="celeste"       @click="validaTipoProducto(1)" class="mt-2" dark 
                     v-if="solicitud.estatus != 4 && solicitud.procesado != 1">AGREGAR PRODUCTO 
              </v-btn>
              <v-btn block color="red darken-4"                                              dark 
                     v-if="solicitud.estatus == 4 && solicitud.procesado != 1">SOLICITUD CANCELADA  
              </v-btn>
              <v-btn block color="rosa"          @click="validaGeneracionOT()"  class="mt-2" dark 
                     v-if="solicitud.procesado != 1 && getDetalle.length "> GENERAR ORDEN DE TRABAJO 
              </v-btn>
            </v-col>
            
            <v-col cols="12" class="py-0"/>
            <v-col cols="12">
              <v-card outlined>

                <v-container style="height: 400px;" v-if="Loading">
                  <loading/>
                </v-container>

                <v-simple-table v-if="!Loading">
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left green white--text"> TIPO </th>
                        <th class="text-left green white--text"> PRODUCTO </th>
                        <th class="text-left green white--text"> CANTIDAD </th>
                        <th class="text-left green white--text"> UNIDAD </th>
                        <th class="text-left green white--text"> DEPTO </th>
                        <th class="text-left green white--text"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item,i) in getDetalle" :key="i" class="font-weight-black">
                        <td class=" rosa--text"    v-if="item.tipo_prod ===1"> Producto Existente</td>
                        <td class=" orange--text"  v-if="item.tipo_prod ===2"> Modificación</td>
                        <td class=" celeste--text" v-if="item.tipo_prod ===3"> Nuevo Producto</td>
                        <td >{{ item.codigo }}  </td>
                        <td >{{ item.cantidad | currency(0) }}</td>
                        <td >{{ item.unidad }}</td>
                        <td >{{ nombres_deptos[item.id_depto-1] }}</td>
                        <td align="right">
                          <!-- MOSTRAR BOTON SI YA SE LEASIGNO UNA ACCION O SI ES UN PRODUCTO EXISTENTE -->
                          <template v-if ="solicitud.estatus != 4 && item.estatus != 4 && solicitud.procesado != 1">
                            <!-- {{ item.estatus }} -->
                            <!-- <v-btn outlined rounded small color="green" class="mx-1 mt-1 " 
                                  v-if="item.estatus > 0 || item.tipo_prod != 2"
                                  @click="generarSolicitudADeptos(item)"
                            >   
                              <v-icon>mdi-file-send</v-icon> 
                            </v-btn> -->

                            <v-btn text small color="celeste" class="mx-1 mt-1" dark  @click="validaTipoProducto(2,item)">   
                              <v-icon>mdi-eye</v-icon> 
                            </v-btn>
                          
                            <v-btn text small color="error" class="mx-1 mt-1" 
                                  @click="modalCancelar = true; accion=2; partidaAEditar= item">
                              <v-icon>mdi-close-thick</v-icon> 
                            </v-btn>
                          </template>

                          <template v-if="solicitud.estatus === 4 || item.estatus === 4 ">
                            <v-btn text small color="error" class="mx-1 mt-1" >SOLICITUD CANCELADA </v-btn>
                          </template>
                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-card>
            </v-col>

            <!-- AGREGAR O EDITAR PRODUCTO -->
            <v-dialog v-model="crudSolicitud" persistent max-width="700">
              <v-card class="pa-3">
                <v-card-actions>
                  <v-card-text class="text-h6 font-weight-black pa-0">
                      {{ modoVista === 1 ?'AGREGAR PRODUCTO':'EDITAR PRODUCTO'}}
                  </v-card-text>
                  <v-spacer></v-spacer>
                  <v-btn color="error" fab small  @click="crudSolicitud = false" >
                    <v-icon>clear</v-icon>
                  </v-btn>
                </v-card-actions>

                <v-row class="mt-4">
            
                  <v-col cols="12" sm="6"  >
                    <v-select
                      v-model="depto" :items="deptos" item-text="nombre" item-value="id" filled color="celeste" 
                      dense hide-details  label="Departamentos" return-object placeholder ="Departamentos"  
                    ></v-select>
                  </v-col>

                  <v-col cols="12" sm="6" class="" >
                    <v-select
                      v-model="tproducto" :items="tproductos" item-text="nombre" item-value="id" filled color="celeste" 
                      dense hide-details label="Tipo de producto" return-object 
                    ></v-select>
                  </v-col>
              
                  <!-- //! REFERENCIA DEL PRODUCTO  -->
                  <v-col cols="12" sm="6">
                    <v-autocomplete
                      :items="productosxcliente" v-model="producto" item-text="codigo" item-value="id" label="Productos" 
                      dense filled hide-details color="celeste" append-icon="person" return-object :disabled="depto.id != null ? false: true"
                    ></v-autocomplete>
                  </v-col>
                  <!-- //! CANTIDAD  -->
                  <v-col cols="12" sm="6" >
                    <v-text-field 
                      v-model="cantidad" hide-details dense label="Cantidad de material" type="number"
                      filled color="celeste" placeholder="Cantidad de material"
                    />
                    <span class="font-weight-black mx-3" v-if="cantidad"> 
                      {{ cantidad | currency(0) }}  
                    </span>
                  </v-col>

                  <v-col cols="12" class="my-3"/>

                  <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
                  <v-footer  absolute>
                    <v-spacer></v-spacer>
                    <v-btn color="success"   @click="validaInfoProducto()"> {{ modoVista ===1 ?'Guardar':'Actualizar' }} Información </v-btn>
                  </v-footer>
                </v-row>

              </v-card>
            </v-dialog>

            <v-dialog v-model="enviarDeptosModal" persistent :width="600">
              <v-card class="pa-3">
                <enviarADeptos 
                  :informacion="informacion" 
                  :actualiza ="actualiza"
                  :solicitud="solicitud"
                  @modal="enviarDeptosModal = $event"
                  @put="actualiza = $event" 
                  />
              </v-card>
            </v-dialog>

            <v-dialog v-model="modalCancelar" persistent max-width="500">
              <v-card >
                <v-card-title class="subtitle-1 font-weight-black" v-if="accion===1"> LA SOLICITUD SE CANCELARA  </v-card-title>
                <v-card-title class="subtitle-1 font-weight-black" v-else> LA PARTIDA SE CANCELARA  </v-card-title>
                <v-card-subtitle class="subtitle-2 font-weight-black">¿ ESTA SEGURO DE QUERER CONTINUAR ?</v-card-subtitle>
                <v-divider class="my-0 py-3" ></v-divider>
                <v-card-subtitle align="center" class="red--text font-weight-bold "> SE CANCELARA DE FORMA DEFINITIVA </v-card-subtitle>
                <v-divider class="my-0 py-2 " ></v-divider>
                <v-card-actions>
                  <v-spacer/>
                  <v-btn dark outlined color="gris" @click="modalCancelar = false">Regresar</v-btn>
                  <v-btn dark color="error" @click="cancelarSolicitud()" v-if="accion===1" >Continuar</v-btn>
                  <v-btn dark color="error" @click="cancelarPartida()" v-else>Continuar</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

          </v-row>
        </v-card>


        <v-dialog v-model="generarOT" width="900px" persistent transition="dialog-bottom-transition">
          <v-card class="pa-3" >
            <generadorOT
              :solicitud="solicitud"
              :detallesol="getDetalle"
              :generarOT="generarOT"
              @modal="generarOT = $event"
            />
          </v-card>
        </v-dialog>

        <v-dialog v-model="Correcto" hide-overlay persistent width="350">
          <v-card color="success"  dark class="pa-3">
            <h3><strong>{{ textCorrecto }} </strong></h3>
          </v-card>
        </v-dialog>

      </v-col>
    </v-row>

  	<overlay v-if="overlay"/>

  </v-main>
</template>

<script>
  import Vue from 'vue'
  import {mapGetters, mapActions} from 'vuex';
	import metodos         from '@/mixins/metodos.js';
  import loading         from '@/components/loading.vue'
  import overlay         from '@/components/overlay.vue'
  import enviarADeptos   from '@/components/enviarADeptos.vue'
  import generadorOT    from '@/views/OT/generador_OT.vue'

  var accounting = require("accounting");
  Vue.filter('currency', (val, dec) => { return accounting.formatMoney(val, '', dec) });


  export default {
    mixins:[metodos],
    components:{
      loading,
      overlay,
      enviarADeptos,
      generadorOT
    },
    data:()=>({
      solicitud       : [],
      Vista           :'',
      anchoModal      : 500,
      solicitarModal  : false,
      crudSolicitud   : false,
      
      activaFormulario: 0 ,
      tablaModificar  :  false,
      parametros      : '',
      modoVista       : 1,
      idProdAEditar : null,
      id_det_prod: null,

			modalDDD        : false,

      tproducto    : { id:1, nombre: 'Producto Existente'},
      tproductos   : [{ id:1, nombre:'Producto Existente'}, 
                      { id:2, nombre:'Modificación de producto'},
                      { id:3, nombre:'Nuevo Producto'}
                     ],
      productosxcliente: [],
      producto: { id: null, nombre: ''},
      cantidad     : '',

      depto           : { id:null, nombre:''},
      deptos          : [],
			nombres_deptos  : [],


      actualiza       : false,

      informacion       :{},   // objeto para el envio de sol a deptos
      enviarDeptosModal : false, // modal para enviar a deptos

      modalCancelar:false,
      accion: 0,
      partidaAEditar:{},

      generarOT: false,

      Correcto      : false,
      textCorrecto  : '',
      overlay: false,
      alerta: { 
        activo: false,
        text: '',
        color: 'error',
      }

    }),

    computed:{
      ...mapGetters('Solicitudes'  ,['getDetalle','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
    },

    created(){
      if(!this.$route.params.solicitud){  window.history.go(-1); } // SI NO OBTENGO LA INFORMACION 
      this.solicitud = this.$route.params.solicitud;
      this.init();
    },

    watch:{
			actualiza: function(){
        this.init();
      },

      depto: function(){
        const payload = new Object();
              payload.id_depto = this.depto.id;
              payload.id_cliente = this.solicitud.id_cliente;

        this.productosxcliente = [];
        this.consultaProdxClientexDepto( payload).then( response =>{ 
          // console.log('PRODUCTOS POR CLIENTE', response);
          this.productosxcliente = response
          // this.producto = { id: this.idProdAEditar };
          this.alerta = { activo: true, 
                          text:  response.length > 1? `Se encontraron ${response.length} productos`:
                                                      `Se encontró ${response.length} producto` , 
                          color: 'success'
                        }
        }).catch( error =>{
          this.alerta = { activo: true, text: error, color: 'error'} 
        })

      }
      
		},

    methods:{
      ...mapActions('Solicitudes'  ,['agregaProducto','actualizarProductoSol','consultaDetalle']), // IMPORTANDO USO DE VUEX (ACCIONES)

      async init(){
        this.consultaDetalle(this.solicitud.id);
        this.nombres_deptos = await this.consulta_deptos_productos();
        this.deptos         = await this.consultaDepartamentos();

      },

      validaInfoProducto(){
        if(!this.depto.id)    { this.alerta = { activo: true, text: "OLVIDASTE SELECCIONAR EL DEPARTAMENTO"     , color: 'green'}; return };
        if(!this.tproducto.id){ this.alerta = { activo: true, text: "OLVIDASTE SELECCIONAR EL TIPO DE PRODUCTO" , color: 'green'}; return };
        if(!this.producto.id) { this.alerta = { activo: true, text: "OLVIDASTE LA FICHA TECNICA"                , color: 'green'}; return };
        if(!this.cantidad)    { this.alerta = { activo: true, text: "OLVIDASTE LA CANTIDAD DE MATERIAL"         , color: 'green'}; return };
        this.PrepararProducto();
      },

      PrepararProducto(){
        this.overlay = true; this.crudSolicitud = false
        const payload = new Object();
              payload.id_solicitud = this.solicitud.id;
              payload.id_depto     = this.depto.id;
              payload.id_producto  = this.producto.id;
              payload.tipo_prod    = this.tproducto.id;
              payload.cantidad     = this.cantidad;
              payload.id_unidad    = 1 //this.unidad.id
        this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
      },
    
      Crear(payload){
        this.$http.post('agregar.producto.solicitud', payload).then(response=>{
          this.TerminarProceso(response.bodyText)
				}).catch((error)=>{
					this.alerta = { activo: true, text: error.bodyText, color:'error'}
          console.log('error',error)
				}).finally(()=>{ 
          this.overlay = false; this.crudSolicitud = true
        })

      },

      Actualizar(payload){
        this.$http.put('actualiza.producto.solicitud/'+ this.id_det_prod, payload).then( response =>{
          this.TerminarProceso(response.bodyText)
        }).catch( error =>{
          this.alerta = { activo: true, text: error.bodyText, color:'error'}
          console.log('error',error)
        }).finally(()=>{ 
          this.overlay = false; this.crudSolicitud = true
        })
      },

      TerminarProceso(mensaje){
        var that = this ;
        this.Correcto = true ; this.textCorrecto = mensaje;
        setTimeout(()=>{ that.crudSolicitud = false; this.Correcto = false }, 1000);
        this.consultaDetalle(this.solicitud.id)
        this.limpiarCampos();  //LIMPIAR FORMULARIO
      },
      
      validaTipoProducto(modo, item = {} ){
          if(modo ===2){
            this.id_det_prod   = item.id;
            this.idProdAEditar = item.id_producto;
            this.depto         = { id: item.id_depto};
            this.tproducto     = { id: item.tipo_prod};
            this.cantidad      =  item.cantidad;
            this.producto      = { id: this.idProdAEditar };
          }else{
            this.limpiarCampos();
          }
          this.modoVista     = modo;
          this.crudSolicitud = true 
      },

      // modifProd(item){
      //   // console.log('item', item)
      //   this.anchoModal       = 700;     // ASIGNAR EL ANCHO DE LA MODAL
      //   this.modoVista        = 4;       // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
      //   this.Vista            = 'SOLICITUDES'
      //   this.parametros       = item;    // ASIGNAR LOS PARAMETROS A MANDAR
      //   this.activaFormulario = item.dx; // FORMULARIO QUE SE MOSTRARA
      //   this.tablaModificar   = false;   // HABILITAR TABLA DE MODIFICACIONES
      //   this.depto = { id: item.dx }
      //   this.solicitarModal   = true;    // ABRIR MODAL
      // },

      cancelarSolicitud(){
 
        this.modalCancelar=false; this.overlay = true; 
        const payload = new Object();
              payload.id_solicitud = this.solicitud.id
              payload.estatus      = 4 
              // payload.id_det_sol   =
              // payload.id_solicitud = 
        
        this.$http.post('valida.cancelacion.sol', payload).then( response =>{
          this.alerta = { activo: true, text: response.bodyText, color: 'green'} 
          this.init()     
          let that = this;
          setTimeout(()=>{ that.$router.push({ name:'solicitudes' })  }, 1000);
        }).catch(error =>{
          this.alerta = { activo: true, text: error.bodyText, color: 'error'} 
        }).finally(()=>{  
          this.overlay = false; 
        })
      },
      cancelarPartida(){
        this.modalCancelar=false; this.overlay = true; 
        const payload = new Object();
              payload.estatus      = 4
              payload.id           = this.partidaAEditar.id
              payload.id_det_sol   = this.partidaAEditar.id
              payload.id_solicitud = this.partidaAEditar.id_solicitud

        this.$http.post('valida.cancelacion.partida', payload).then( response =>{
          this.alerta = { activo: true, text: response.bodyText, color: 'green'} 
          this.init()     
        }).catch(error =>{
          this.alerta = { activo: true, text: error.bodyText, color: 'error'} 
        }).finally(()=>{  
          this.overlay = false; 
        })
      },
      generarSolicitudADeptos(item){
        if(this.solicitud.estatus === 4){
          this.alerta.color = "red darken-4"; this.alerta.activo = true; 
          this.alerta.text = "Es imposible mover el producto ya que la solicitud está cancelada.";
          return;
        }
        // console.log('item', item);
        this.informacion = item;
        this.enviarDeptosModal = true;

      },

      validaGeneracionOT(){
        for(let i=0; i< this.getDetalle.length; i++){
          if(this.getDetalle[i].estatus === 2 ){
            this.alerta = { activo: true, text:`El producto ${this.getDetalle[i].codigo} está aun pendiente.`, color: 'error'};
            return;
          }
        }

        this.generarOT = true;

      },
      
      limpiarCampos(){
        this.cantidad  = '';
        this.tproducto = { id:null, nombre:''};
        this.producto  = { id:null, nombre:''};
      },
      
    }
  }
</script>