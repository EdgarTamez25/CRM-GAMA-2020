<template>
  <v-main class="pa-0 ma-3">
     <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
        <strong> {{alerta.text}} </strong>
        <template v-slot:action="{ attrs }">
          <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
        </template>
      </v-snackbar>

    <v-row justify="center">
      <v-col cols="12" lg="9" xl="8">
        <v-card class="pa-2" flat>
          <v-row >
            <v-col cols="12" class="text-right">
              <v-card-actions class="py-0">
                <v-btn text onClick="history.go(-1); return false;"> <v-icon large>mdi-arrow-left-thick</v-icon> </v-btn>  <v-spacer></v-spacer>
                <span class="overline font-weight-black py-0" >N° solicitud: {{ solicitud.id }} </span>
              </v-card-actions>
            </v-col>

            <v-col cols="12" sm="8" md="7"  xl="6" >
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
                          {{ solicitud.fecha}} ** {{ solicitud.hora >='12:00'? solicitud.hora +' '+'pm': solicitud.hora+ ' '+'am' }}
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
            <v-col cols="12" sm="4" md="5" xl="6" >
              <v-btn block color="gris" outlined @click="modalCancelar = true; accion=1" dark v-if="solicitud.estatus != 4">CANCELAR SOLICITUD </v-btn>
              <v-btn block color="celeste" @click="agregarProducto(1,[])" class="mt-2" dark v-if="solicitud.estatus != 4">AGREGAR PRODUCTO </v-btn>
              <v-btn block color="red darken-4" dark v-else>SOLICITUD CANCELADA  </v-btn>
            </v-col>
            <!-- {{ getDetalle }} -->
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
                        <th class="text-left green white--text"> REFERENCIA </th>
                        <th class="text-left green white--text"> CANTIDAD </th>
                        <th class="text-left green white--text"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item,i) in getDetalle" :key="i" >

                        <td class="font-weight-black rosa--text"    v-if="item.tipo_prod ===1"> Producto Existente</td>
                        <td class="font-weight-black orange--text"  v-if="item.tipo_prod ===2"> Modificación</td>
                        <td class="font-weight-black celeste--text" v-if="item.tipo_prod ===3"> Nuevo Producto</td>

                        <td class="font-weight-black">{{ item.ft }}</td>
                        <td class="font-weight-black">{{ item.cantidad }}</td>
                        <td align="right">
                          <!-- MOSTRAR BOTON SI YA SE LEASIGNO UNA ACCION O SI ES UN PRODUCTO EXISTENTE -->
                        <template v-if ="solicitud.estatus != 4 && item.estatus != 4">
                          <v-btn outlined rounded small color="green" class="mx-1 mt-1 " 
                                 v-if="item.estatus > 0 || item.tipo_prod != 2"
                                 @click="MandarDeptoModal(item)"
                          >   
                            <v-icon>mdi-file-send</v-icon> 
                          </v-btn>

                           <v-btn outlined rounded small color="celeste" class="mx-1 mt-1" dark 
                                  v-if="item.estatus == 0 && item.tipo_prod === 2"  
                                  @click="validaTipoProducto(item)">   
                            <v-icon>mdi-eye</v-icon> 
                          </v-btn>
                          <v-btn text small color="celeste" class="mx-1 mt-1" dark v-else  @click="validaTipoProducto(item)">   
                            <v-icon>mdi-eye</v-icon> 
                          </v-btn>

                          <v-btn text small color="rosa" class="mx-1 mt-1" v-if="item.tipo_prod === 2" @click="modifProd(item)">   
                            <v-icon>create</v-icon> 
                          </v-btn>
                          <!-- <v-btn text small c class="mx-1 mt-1"  disabled v-else > <v-icon>mdi-eye</v-icon></v-btn> -->

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

            <v-dialog v-model="crudSolicitud" persistent max-width="700">
              <v-card class="pa-4 ">
                <v-card-text class=" subtitle-1 font-weight-black pa-0 " align="center">AGREGAR PRODUCTO</v-card-text>

                <v-row class="mt-4">
                  <v-col cols="12" sm="6" v-if="modoVista === 1 || modoVista === 3">
                    <v-select
                        v-model="depto" :items="deptos" item-text="nombre" item-value="id" outlined color="celeste" 
                        dense hide-details  label="Departamentos" return-object placeholder ="Departamentos"
                    ></v-select>
                  </v-col>

                  <v-col cols="12" sm="6"  v-else>
                    <v-select
                      v-model="depto" :items="deptos" item-text="nombre" item-value="id" outlined color="celeste" 
                      dense hide-details  label="Departamentos" return-object placeholder ="Departamentos" disabled 
                    ></v-select>
                  </v-col>

                  <v-col cols="12" sm="6" class="" >
                    <v-select
                      v-model="tproducto" :items="tproductos" item-text="nombre" item-value="id" outlined color="celeste" 
                      dense hide-details label="Tipo de producto" return-object :disabled="modoVista===2 || modoVista=== 4?true:false"
                    ></v-select>
                  </v-col>
              
                  <!-- //! REFERENCIA DEL PRODUCTO  -->
                  <v-col cols="12" sm="6">
                    <v-autocomplete
                      :items="productosxcliente" v-model="producto" item-text="codigo" tem-value="id" label="Productos" 
                      dense filled hide-details color="celeste" append-icon="person" return-object clearable
                    ></v-autocomplete>
                  </v-col>
                  <!-- //! CANTIDAD  -->
                  <v-col cols="12" sm="6" >
                    <v-text-field 
                      v-model="cantidad" hide-details dense label="Cantidad" 
                      filled color="celeste" placeholder="Cantidad de material"
                    />
                  </v-col>

                   <v-col cols="12" class="my-3"/>

                  <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
                  <v-footer  absolute>
                    <v-btn color="error" outlined @click="crudSolicitud = false"  class="ma-1">Cancelar </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="success"   @click="validaInformacion()">Guardar </v-btn>
                  </v-footer>

                </v-row>
               
                   
                
                
              
                <!-- <crudflexografia 
                  :depto_id="depto.id" 
                  :modoVista="modoVista"
                  :parametros="parametros"
                  :solicitud="solicitud"
                  @modal="crudSolicitud = $event" 
                /> -->
              </v-card>
            </v-dialog>
    
             <!--// !ESTE ES EL BUENO ECHALE GANAS PARA ENTENDERLE TE QUIERO MUCHO  -->
            <!-- <v-dialog v-model="solicitarModal" persistent :width="anchoModal" height="200" >
              <v-card class="pa-4 ">
                <modificaciones
                  :modalDDD="modalDDD"
                  :depto_id="depto.id" 
                  :modoVista="modoVista"
                  :Vista="Vista"
                  :parametros="parametros"
                  :actualiza ="actualiza"
                  @modal="solicitarModal = $event" 
                  @put="actualiza = $event" 
                  v-if="tablaModificar"
                />
                <flexografia 
                  :modalDDD="modalDDD"
                  :depto_id="depto.id" 
                  :modoVista="modoVista"
                  :Vista="Vista"
                  :parametros="parametros"
                  :actualiza ="actualiza"
                  @modal="solicitarModal = $event" 
                  @put="actualiza = $event" 
                  v-if="activaFormulario===1"
                />
                <digital     
                  :modalDDD="modalDDD"
                  :depto_id="depto.id" 
                  :modoVista="modoVista"
                  :Vista="Vista"
                  :parametros="parametros"
                  :actualiza ="actualiza"
                  @modal="solicitarModal = $event" 
                  @put="actualiza = $event" 
                  v-if="activaFormulario===3"
                />
              </v-card>
            </v-dialog> -->


            <v-dialog v-model="enviarDeptosModal" persistent :width="550">
              <v-card class="pa-3">
                <enviarADeptos 
                  :informacion="informacion" 
                  :actualiza ="actualiza"
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


		        <overlay v-if="overlay"/>

          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-main>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
	import metodos         from '@/mixins/metodos.js';
  import loading         from '@/components/loading.vue'
  import overlay         from '@/components/overlay.vue'
  import modificaciones  from '@/views/Formularios/modificaciones.vue'
  // import flexografia     from '@/views/Formularios/flexografia.vue'
  // import crudflexografia from '@/views/Formularios/CRUD/crud_flexografia.vue'
  // import digital         from '@/views/Formularios/digital.vue'
  import enviarADeptos   from '@/components/enviarADeptos.vue'

  export default {
    mixins:[metodos],
    components:{
      loading,
      overlay,
      modificaciones,
      // flexografia,
      // crudflexografia,
      // digital,
      enviarADeptos
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

      actualiza       : false,

      informacion       :{},
      enviarDeptosModal : false,

      modalCancelar:false,
      accion: 0,
      partidaAEditar:{},
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
          this. productosxcliente = response
        }).catch( error =>{
          this.alerta = { activo: true, text: error, color: 'error'} 
        })
      }
      
		},

    methods:{
      ...mapActions('Solicitudes'  ,['consultaDetalle']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

      init(){
        this.consultaDetalle(this.solicitud.id);
        this.consultaDepartamentos();
      },
      
      validaTipoProducto(item = []){
        switch (item.tipo_prod) {
          case 1:
            this.anchoModal       = 700;     // ASIGNAR EL ANCHO DE LA MODAL
            this.modoVista        = 2;       // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
            this.Vista            = 'SOLICITUDES'
            this.parametros       = item;    // ASIGNAR LOS PARAMETROS A MANDAR
            this.activaFormulario = item.dx; // FORMULARIO QUE SE MOSTRARA
            this.tablaModificar   = false;   // HABILITAR TABLA DE MODIFICACIONES
            this.depto = { id: item.dx }
            this.solicitarModal   = true;    // ABRIR MODAL
            break;

          case 2:
            this.anchoModal       = 800;   // ASIGNAR EL ANCHO DE LA MODAL
            this.modoVista        = 2;     // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
            this.Vista            = 'SOLICITUDES'
            this.parametros       = item;  // ASIGNAR LOS PARAMETROS A MANDAR
            this.activaFormulario = 0 ;    // FORMULARIO QUE SE MOSTRARA
            this.tablaModificar   = true;  // HABILITAR TABLA DE MODIFICACIONES
            this.depto = { id: item.dx }
            this.solicitarModal   = true;  // ABRIR MODAL 
            break;

          case 3:
            this.anchoModal       = 700;     // ASIGNAR EL ANCHO DE LA MODAL
            this.modoVista        = 2;       // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
            this.Vista            = 'SOLICITUDES'
            this.parametros       = item;    // ASIGNAR LOS PARAMETROS A MANDAR
            this.activaFormulario = item.dx; // FORMULARIO QUE SE MOSTRARA
            this.tablaModificar   = false;   // HABILITAR TABLA DE MODIFICACIONES
            this.depto = { id: item.dx }
            this.solicitarModal   = true;    // ABRIR MODAL
            break;
        }
      },

      modifProd(item){
        // console.log('item', item)
        this.anchoModal       = 700;     // ASIGNAR EL ANCHO DE LA MODAL
        this.modoVista        = 4;       // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
        this.Vista            = 'SOLICITUDES'
        this.parametros       = item;    // ASIGNAR LOS PARAMETROS A MANDAR
        this.activaFormulario = item.dx; // FORMULARIO QUE SE MOSTRARA
        this.tablaModificar   = false;   // HABILITAR TABLA DE MODIFICACIONES
        this.depto = { id: item.dx }
        this.solicitarModal   = true;    // ABRIR MODAL
      },
      cancelarSolicitud(){
        this.modalCancelar=false; this.overlay = true; 
        const payload = new Object();
              payload.id_solicitud = this.solicitud.id
              payload.estatus      = 4 
        
        this.$http.post('valida.cancelacion', payload).then( response =>{
          // this.alerta.activo = true; this.alerta.text = response.bodyText; this.alerta.color="green";    
          this.alerta = { activo: true, text: response.bodyText, color: 'green'} 
          this.init()     
        }).catch(error =>{
          // this.alerta.activo = true; this.alerta.text = error.bodyText; this.alerta.color="red darken-4";       
          this.alerta = { activo: true, text: error.bodyText, color: 'error'} 

        }).finally(()=>{  
          this.overlay = false; 
        })
      },

      cancelarPartida(){
        this.modalCancelar=false; this.overlay = true; 
        const payload = new Object();
              payload.id_solicitud = this.solicitud.id
              payload.estatus      = 4
              payload.id           = this.partidaAEditar.id
              payload.tipo_prod    = this.partidaAEditar.tipo_prod
        
        console.log('partida', payload)
        
        this.$http.post('valida.cancelacion.partida', payload).then( response =>{
          // this.alerta.activo = true; this.alerta.text = response.bodyText; this.alerta.color="green";  
          this.alerta = { activo: true, text: response.bodyText, color: 'green'} 
          this.init()     
        }).catch(error =>{
          // this.alerta.activo = true; this.alerta.text = error.bodyText; this.alerta.color="red darken-4";   
          this.alerta = { activo: true, text: error.bodyText, color: 'error'} 

        }).finally(()=>{  
          this.overlay = false; 
        })
      },


      MandarDeptoModal(item){
        // if(this.solicitud.estatus === 4){
        //   this.alerta.color = "red darken-4"; this.alerta.activo = true; 
        //   this.alerta.text = "Es imposible mover el producto ya que la solicitud está cancelada.";
        //   return;
        // }
        this.informacion = item;
        this.enviarDeptosModal = true;

      },

      agregarProducto(modoVista, items = []){
        this.anchoModal       = 700;     // ASIGNAR EL ANCHO DE LA MODAL
        this.modoVista        = modoVista;       // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
        this.parametros       = items;    // ASIGNAR LOS PARAMETROS A MANDAR
        // this.depto            = { id: 1 }
        this.crudSolicitud   = true;    // ABRIR MODAL
      }
      
    }
  }
</script>