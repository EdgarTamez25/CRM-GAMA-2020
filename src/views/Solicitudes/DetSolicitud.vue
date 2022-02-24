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
                        <th class="text-left green white--text"> DEPTO / LINEA </th>
                        <th class="text-left green white--text"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item,i) in getDetalle" :key="i" class="font-weight-black">
                        <td v-if="item.tproducto === 1"> Producción</td>
                        <td v-if="item.tproducto === 2"> Comercialización</td>
                        <td >{{ item.codigo }}  </td>
                        <td >{{ item.cantidad | currency(0) }}</td>
                        <td >{{ item.unidad }}</td>
                        <td v-if="item.tproducto == 1"> {{ nombres_deptos[item.id_depto-1] }}  </td>
                        <td v-if="item.tproducto == 2"> {{ item.nomlin }} </td>
                     
                        <td align="right">
                          <!-- MOSTRAR BOTON SI YA SE LEASIGNO UNA ACCION O SI ES UN PRODUCTO EXISTENTE -->
                          <template v-if ="solicitud.estatus != 4 && item.estatus != 4 && solicitud.procesado != 1">
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
          </v-row>
        </v-card>
      </v-col>
    </v-row>

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
          <v-col cols="12" sm="6" class="" >
            <v-select
              v-model="tproducto" :items="tproductos" item-text="nombre" item-value="id" filled 
              dense hide-details label="Tipo de producto" return-object 
            ></v-select>
          </v-col>

          <v-col cols="12" sm="6" v-if="tproducto.id == 1">
            <v-autocomplete
              v-model="depto" :items="deptos" item-text="nombre" item-value="id" @change="consultar_productos_deptos()" 
              dense filled hide-details label="Departamentos"  return-object  placeholder ="Departamentos"
            ></v-autocomplete>
          </v-col>

          <v-col cols="12" sm="6" v-if="tproducto.id == 2">
            <v-autocomplete
              v-model="linea" :items="lineas" item-text="nombre" item-value="id" @change="consultar_productos_lineas()" 
              dense filled hide-details label="Lineas"  return-object  placeholder ="Lineas"
            ></v-autocomplete>
          </v-col>
      
          <!-- //! REFERENCIA DEL PRODUCTO  -->
          <v-col cols="12" sm="6" >
             <v-autocomplete
              v-model="producto"
              :items="productosxcliente"
              filled
              dense
              label="Productos"
              item-text="codigo"
              item-value="id"
              return-object
              hide-details
              :disabled="productosxcliente.length? false:true"
            >
              <template v-slot:item="data">
                <template>
                  <v-list-item-content>
                    <v-list-item-title class="font-weight-black" v-html="data.item.codigo"></v-list-item-title>
                    <v-list-item-subtitle >{{ data.item.nombre ? data.item.nombre: 'Producto sin nombre'}}</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </template>
            </v-autocomplete>
          </v-col>

          <!-- //! CANTIDAD  -->
          <v-col cols="12" sm="6" >
            <v-text-field 
              v-model="cantidad" hide-details dense label="Cantidad de material" type="number"
              filled  placeholder="Cantidad de material"
            />
            <span class="font-weight-black mx-3" v-if="cantidad"> 
              {{ cantidad | currency(0) }}  
            </span>
          </v-col>

          <!-- //! MONEDA  -->
          <v-col cols="12" sm="6" class="" >
            <v-select
              v-model="moneda" :items="monedas" item-text="nombre" item-value="id" filled 
              dense hide-details label="Moneda" return-object 
            ></v-select>
          </v-col>

         
          <!-- //! PRECIO  -->
          <v-col cols="12" sm="6" >
            <v-text-field 
              v-model="precio" hide-details dense label="Precio" type="number"
              filled  placeholder="Precio"
            />
          </v-col>

          <v-col cols="12" class="my-3"/>
          <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
          <v-footer  absolute>
            <v-spacer></v-spacer>
            <v-btn 
              color="success"  
              :disabled="!VALIDAR_CAMPOS"
              @click="PrepararProducto()"
            > 
              {{ modoVista ===1 ?'Guardar':'Actualizar' }} Información 
            </v-btn>
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

  	<overlay v-if="overlay"/>
  </v-main>
</template>

<script>
  var accounting = require("accounting");
  import {mapGetters, mapActions} from 'vuex';
	import metodos         from '@/mixins/metodos.js';
  import loading         from '@/components/loading.vue'
  import overlay         from '@/components/overlay.vue'
  import enviarADeptos   from '@/components/enviarADeptos.vue'
  import generadorOT     from '@/views/OT/generador_OT.vue'

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

      // MODAL DE REGISTRO
      tproducto    : { id:1, nombre: 'Producción'},
      tproductos   : [{ id:1, nombre:'Producción'}, 
                      { id:2, nombre:'Comercialización'},
                      // { id:3, nombre:'Nuevo Producto'}
                     ],
      productosxcliente: [],
      producto: { id: null, nombre: ''},
      cantidad     : 0,

      depto           : { id:null, nombre:''},
      deptos          : [],
			nombres_deptos  : [],

      linea: { id: null, nombre:''},
      lineas: [],
      moneda:{ id: 1, nombre:'MXN'},
      monedas:[{ id:1, nombre:'MXN'},
               { id:2, nombre:'USD'}
              ],
      precio: 0,
      

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

    filters:{
      currency(val, dec){
         return accounting.formatMoney(val, '', dec);
      }
    },
    
    computed:{
      ...mapGetters('Solicitudes'  ,['getDetalle','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS);
      ...mapGetters('TipoCambio' ,['tipo_cambio_hoy']), 

      VALIDAR_CAMPOS(){
        return this.tproducto.id  != null && 
               this.producto.id != null &&
               this.cantidad    != ''&&
               this.cantidad    != 0 &&
               this.moneda.id   != null &&
               this.precio      != 0 &&
               this.precio      != '';
      },
    },

    created(){
      if(!this.$route.params.solicitud){  window.history.go(-1); } // SI NO OBTENGO LA INFORMACION 
      this.solicitud = this.$route.params.solicitud;
      this.init();
    },

    watch:{
			actualiza(){
        this.init();
      },
		},

    methods:{
      ...mapActions('Solicitudes'  ,['agregaProducto','actualizarProductoSol','consultaDetalle']), // IMPORTANDO USO DE VUEX (ACCIONES)

      async init(){
        this.consultaDetalle(this.solicitud.id);
        this.nombres_deptos = await this.consulta_deptos_productos();
        this.deptos         = await this.consultaDepartamentos();
        this.lineas         = await this.consultar_lineas();
      },

      PrepararProducto(){
        // VALIDACION PARA EL TIPO DE CAMBIO.
        if (!this.tipo_cambio_hoy) {
          this.alerta = { activo: true, text:'Aun no asignas el tipo de cambio.', color:'error'};
          return;
        }
        // this.overlay = true; 
        // this.crudSolicitud = false;
        let precio_peso = 0 , precio_dolar = 0;
        let tipo_de_cambio = 21;

        if(this.tipo_cambio_hoy.cambio){ 
          
          if(this.moneda.id  == 1){
            // TRANSFORMAR A DOLARES.
            precio_dolar = (this.precio / this.tipo_cambio_hoy.cambio).toFixed(2);
            precio_peso = this.precio;
          }

          if(this.moneda.id  == 2){
            // TRANSFORMAR A PESO.
            precio_dolar = this.precio ;
            precio_peso = this.precio * this.tipo_cambio_hoy.cambio;
          }

        }else{
          this.overlay = false;
          this.alerta = { activo: true, texto: "No se ha registrado el tipo de cambio hoy."};
          return;
        }

        const payload = {
          id_solicitud: this.solicitud.id,
          tproducto   : this.tproducto.id,
          id_depto    : this.depto.id,
          id_linea    : this.linea.id,
          id_producto : this.producto.id,
          cantidad    : this.cantidad,
          id_moneda   : this.moneda.id,
          MXN         : precio_peso,
          USD         : precio_dolar,
          id_unidad   : 1, //this.unidad.id
          tipo_cambio : this.tipo_cambio_hoy.cambio
        }
        this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
      },
    
      Crear(payload){
        this.$http.post('agregar.producto.solicitud', payload).then(response=>{
          this.TerminarProceso(response.bodyText)
				}).catch((error)=>{
					this.alerta = { activo: true, text: error.bodyText, color:'error'}
          // console.log('error',error)
				}).finally(()=>{ 
          this.overlay = false; this.crudSolicitud = true
        })

      },

      Actualizar(payload){
        this.$http.put('actualiza.producto.solicitud/'+ this.id_det_prod, payload).then( response =>{
          this.TerminarProceso(response.bodyText)
        }).catch( error =>{
          this.alerta = { activo: true, text: error.bodyText, color:'error'}
          // console.log('error',error)
        }).finally(()=>{ 
          this.overlay = false; this.crudSolicitud = true
        })
      },

      TerminarProceso(mensaje){
        var that = this ;
        this.Correcto = true ; 
        this.textCorrecto = mensaje;

        setTimeout(()=>{ that.crudSolicitud = false; this.Correcto = false }, 1000);
        this.consultaDetalle(this.solicitud.id)
        this.limpiarCampos();  //LIMPIAR FORMULARIO
      },
      
      async validaTipoProducto(modo, item = {} ){
          if(modo ===2){
            this.id_det_prod   = item.id;
            this.idProdAEditar = item.id_producto;

            this.tproducto     = { id: item.tproducto };
            this.depto         = { id: item.id_depto };
            this.linea         = { id: item.id_linea };
            this.cantidad      =  item.cantidad;
            this.moneda        = { id: item.id_moneda };
            this.precio        = item.id_moneda == 1 ? item.MXN : item.USD
            
            if(this.tproducto.id == 1){
              await this.consultar_productos_deptos();
            }else{
              await this.consultar_productos_lineas();
            }
            this.producto      = { id: item.id_producto };

          }else{
            this.limpiarCampos();
          }
          this.modoVista     = modo;
          this.crudSolicitud = true 
      },
  
      cancelarSolicitud(){
        this.modalCancelar=false; 
        this.overlay = true; 

        const payload = { 
          id_solicitud: this.solicitud.id,
          estatus: 4 
        };
        
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
        this.modalCancelar=false; 
        this.overlay = true; 
        const payload = { 
          id          : this.partidaAEditar.id,
          id_solicitud: this.partidaAEditar.id_solicitud,
          id_det_sol  : this.partidaAEditar.id,
          estatus     : 4
        };

        this.$http.post('valida.cancelacion.partida', payload).then( response =>{
          this.alerta = { activo: true, text: response.bodyText, color: 'green'} 
          this.init()     
        }).catch(error =>{
          this.alerta = { activo: true, text: error.bodyText, color: 'error'} 
        }).finally(()=>{  
          this.overlay = false; 
        })
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

      consultar_productos_lineas(){
        if(this.linea.id == null){ return};
        this.consultaProdxLinea(this.linea.id).then( response =>{
          this.productosxcliente = response;
          this.depto = { id:null, nombre:''};
        }).catch( error =>{
          this.alerta = { activo: true, text: error, color:'error'};
        })
      },

      consultar_productos_deptos(){
        if(this.depto.id == null){ return };
        const payload = { 
          id_depto: this.depto.id,
          id_cliente: this.solicitud.id_cliente
        }           
        this.productosxcliente = [];
        this.consultaProdxClientexDepto( payload).then( response =>{ 
          this.productosxcliente = response
          this.linea = { id:null, nombre:''};
        }).catch( error =>{
          this.alerta = { activo: true, text: error, color: 'error'} 
        })
      },

        // validaInfoProducto(){
      //   // if(!this.depto.id)    { this.alerta = { activo: true, text: "OLVIDASTE SELECCIONAR EL DEPARTAMENTO"     , color: 'green'}; return };
      //   // if(!this.tproducto.id){ this.alerta = { activo: true, text: "OLVIDASTE SELECCIONAR EL TIPO DE PRODUCTO" , color: 'green'}; return };
      //   // if(!this.producto.id) { this.alerta = { activo: true, text: "OLVIDASTE LA FICHA TECNICA"                , color: 'green'}; return };
      //   // if(!this.cantidad)    { this.alerta = { activo: true, text: "OLVIDASTE LA CANTIDAD DE MATERIAL"         , color: 'green'}; return };
      //   // this.PrepararProducto();
      // },

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

      
    }
  }
</script>