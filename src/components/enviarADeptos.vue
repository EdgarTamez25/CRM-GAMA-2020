<template>
  <v-row  align-content="center" justify="center" >
    <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
      <strong> {{alerta.text}} </strong>
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
      </template>
    </v-snackbar>
    <!-- LOADING -->
    <!-- <v-container style="height: 400px;" v-if="Loading">
      <loading/>
    </v-container> -->
    <v-tabs color="rosa" centered icons-and-text v-model="tab">
      <v-tabs-slider></v-tabs-slider>
      <v-tab href="#tab-1" > {{ Modo ===1?  'Solicitar':'Editar Solicitud'}} </v-tab>
      <v-tab href="#tab-2">  Seguimiento   </v-tab>
    </v-tabs>

     <v-tabs-items v-model="tab">
      <v-tab-item value="tab-1">
        <v-row class="pa-4">
          <v-col cols="12"  >
            <v-autocomplete
              :items="productosxcliente" v-model="producto" item-text="codigo" item-value="id" label="Productos" 
              dense filled hide-details color="celeste" append-icon="person" return-object disabled
            ></v-autocomplete>
          </v-col>

          <v-col cols="12" sm="6">
            <v-select
              v-model="tproducto" :items="tproductos" item-text="nombre" item-value="id" filled color="celeste" 
              dense hide-details label="Tipo de producto" return-object disabled
            ></v-select>
          </v-col>

          <v-col  cols="12" sm="6" >
            <v-select
              v-model="depto" :items="deptos" item-text="nombre" item-value="id" filled  color="celeste" 
              label="MANDAR A " return-object  dense hide-details class="font-weight-black" 
            ></v-select>
          </v-col>

          <v-col cols="12">
            <v-textarea
              v-model="descripcion" prepend-inner-icon="mdi-comment" label="¿ Qué se tiene que hacer ?" rows="3" outlined
            ></v-textarea>
          </v-col>
        </v-row>

        <v-footer absolute>
          <v-btn color="error" dark outlined @click="$emit('modal',false)"  v-if="Modo === 1"> CANCELAR</v-btn>
          <v-btn color="error" dark outlined @click="regresaModo1()" v-else> Regresar</v-btn>

          <v-spacer></v-spacer>
          <v-btn dark color="celeste" @click="validaInformacion()" v-if="Modo === 1">
            Envíar Solicitud
          </v-btn>
          <v-btn dark color="celeste" @click="validaInformacion()" v-if="Modo === 2">
            Actualizar Solicitud 
          </v-btn>
        </v-footer>

         
      </v-tab-item>
      <v-tab-item value="tab-2" class="pa-4 ma-1" >

        <v-row >
          <v-col cols="12" v-if="!getMovimientos.length" class="pa-4">
            <v-alert outlined type="warning" transition="scale-transition">
              <v-row align="center">
                <v-col class="grow">
                   Actualmente no se encuentran movimientos realizados de esté producto.
                </v-col>
                <v-col class="shrink">
                  <v-btn class="" fab small dark color="celeste"  @click="init()"> <v-icon>refresh</v-icon></v-btn >
                </v-col>
              </v-row>
            </v-alert>
          </v-col>
          <v-card  width="550px" v-else>
            <v-list two-line subheader >
              <v-list-item v-for="(item , i) in getMovimientos" :key="i" link  @dblclick="verDetalle(item)">
                <v-list-item-content >
                  <v-list-item-title    class="font-weight-black caption">DEPARTAMENTO  </v-list-item-title>
                  <v-list-item-subtitle class="font-weight-black caption">{{ deptos[item.id_depto-1].nombre }}  </v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-content >
                  <v-list-item-title    class="font-weight-black caption">ESTATUS  </v-list-item-title>
                  <v-list-item-subtitle class="font-weight-black caption" v-if="item.estatus === 1"> ASIGNADO </v-list-item-subtitle>
                  <v-list-item-subtitle class="font-weight-black caption" v-if="item.estatus === 2"> FINALIZADO </v-list-item-subtitle>
                  <v-list-item-subtitle class="font-weight-black caption" v-if="item.estatus === 3"> AUTORIZADO </v-list-item-subtitle>
                  <v-list-item-subtitle class="font-weight-black caption" v-if="item.estatus === 4"> CANCELADO </v-list-item-subtitle>
                </v-list-item-content>
              
                <v-list-item-action>
                  <v-btn color="error" dark fab x-small v-if="item.estatus === 1 && item.id_encargado === null"   
                        @click="validaDelete(item)"> 
                    <v-icon>mdi-delete</v-icon> 
                  </v-btn>
                  <v-btn color="gris" dark fab x-small v-if="item.estatus === 1 && item.id_encargado != null"> 
                    <v-icon>mdi-account-alert</v-icon> 
                  </v-btn>
                  <v-btn color="orange" dark fab x-small v-if="item.estatus === 2"  > 
                    <v-icon>mdi-account-arrow-right</v-icon> 
                  </v-btn>
                  <v-btn color="green" dark fab x-small v-if="item.estatus === 3"  > 
                    <v-icon>mdi-account-check</v-icon> 
                  </v-btn>
                  <v-btn color="error" dark fab x-small v-if="item.estatus === 4"  > 
                    <v-icon>mdi-account-cancel</v-icon> 
                  </v-btn>
                </v-list-item-action>
              </v-list-item>
            </v-list>


          </v-card>
          <!-- <v-col class=""> -->
          <!-- </v-col> -->
        </v-row>
        <v-row  v-if="getMovimientos.length">
          <v-card class="mt-2" width="550px" flat>
            <v-btn class="" outlined color="celeste" dark block small @click="init()"> Actualizar Estatus</v-btn >
          </v-card> 
        </v-row>
        
      </v-tab-item>
    </v-tabs-items>

      
    <v-dialog v-model="Correcto" hide-overlay persistent width="350">
      <v-card :color="colorCorrecto" dark class="pa-3">
        <v-card-text class="font-weight-black headline pa-3 white--text" align="center">
          {{ textCorrecto }}
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="EliminaRegistro" persistent width="400" >
      <v-card class="pa-3" color="red darken-4">
        <v-card-text class="font-weight-black subtitle-1 white--text" align="justify" >
         ¿ ESTAS SEGURO DE QUERER ELIMINAR EL REGISTRO ?
        </v-card-text>
        <v-card-actions>
          <v-btn color="white" dark small outlined @click="EliminaRegistro = false"> CANCELAR</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="celeste" dark small  @click="eliminaRegistro()"> Confirmar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- <v-dialog v-model="validarFinalizacion" persistent width="400" >
      <v-card class="pa-3" color="orange darken-4">
        <v-card-text class="font-weight-black subtitle-1 white--text" align="justify" >
         ¿ ESTAS SEGURO DE QUERER VALIDAR EL REGISTRO ?
        </v-card-text>
        <v-card-actions>
          <v-btn color="white" dark small outlined @click="validarFinalizacion = false"> CANCELAR</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="celeste" dark small  @click="finalizaProdExist()"> Confirmar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> -->

     <!-- OVERLAY -->
    <overlay v-if="overlay"/>

  </v-row>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import loading from '@/components/loading.vue'
  import overlay from '@/components/overlay.vue'
	import SelectMixin from '@/mixins/SelectMixin.js';

  export default {
		mixins:[SelectMixin],
    components:{
      loading,
      overlay
    },
    props:[
      'informacion',
      'actualiza',
      'solicitud'
    ],
    data: () => ({
      tab: null,
      Modo: 1,
      idAEditar: null,
      agregaOtro: false, 
      depto:{id: null, nombre:''},
      deptos:[{ id: 1, nombre:'DESARROLLO'}, 
              { id: 2, nombre:'DIGITAL'   }, 
              { id: 3, nombre:'DISEÑO'    },
              // { id: 4, nombre:'CANCELADO' },
            ],

      productosxcliente: [],
      producto: { id: null, nombre: ''},
      tproducto    : { id:1, nombre: 'Producto Existente'},
      tproductos   : [{ id:1, nombre:'Producto Existente'}, 
                      { id:2, nombre:'Modificación de producto'},
                      { id:3, nombre:'Nuevo Producto'}
                     ],
      descripcion:'',

      overlay : false,
      Correcto: false,
      textCorrecto: '',
      colorCorrecto: 'green',

      alerta: { 
        activo: false,
        text: '',
        color: 'error',
      },

      EliminaRegistro: false,
      elementoAEliminar: {},
      validarFinalizacion: false,
    }),

    created(){
      this.consultaProdxCli(this.solicitud.id_cliente);
      this.llenaCamposDefault();
      this.init();
    },

    computed:{
      ...mapGetters('Movimientos'  ,['getMovimientos','Loading']), // IMPORTANDO USO DE VUEX - (GETTERS)
      ...mapGetters('Login' ,['getdatosUsuario']), 
    },

    watch:{
      informacion(){
        this.llenaCamposDefault()
        this.init();
      },
    },

    methods:{
       ...mapActions('Movimientos'  ,['consultaMovimientos','insertaMovimientos','deleteEnvio','ActualizaMovimientos']), 
       ...mapActions('Solicitudes'  ,['consultaDetalle']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

      init(){
        this.consultaMovimientos(this.informacion.id);
      },

      llenaCamposDefault(){
        this.producto  = { id: this.informacion.id_producto}
        this.tproducto = { id: this.informacion.tipo_prod}
      },

      validaInformacion(){
        if(!this.depto.id ){
          this.alerta = { activo: true, text: 'Debe seleccionar un departamento.', color: 'error'} ; return;
        }
        if(!this.descripcion){
          this.alerta = { activo: true, text: 'Debe agregar la tarea ah realizar', color: 'error'} ; return;
        }

        if(!this.validaMovimRepetidos()){
          this.alerta = { activo: true, text: 'Este producto ya tiene una solicitud en el departamento', color: 'error'} ; return;
        }
        
        this.PrepararDatos()
      },

      validaMovimRepetidos(){
        if(!this.getMovimientos.length){  console.log('retornare true'); return true };

        for(let i=0; i<this.getMovimientos.length;i++){
          console.log('ENTRE AL PRIMER CICLO', i)
          if(this.Modo === 1){
            console.log(`comparo ${ this.depto.id} con ${ this.getMovimientos[i].id_depto}`);
            if( this.depto.id === this.getMovimientos[i].id_depto ){
              console.log('SON IGUALES EN  MODO 1');
              return false;
            }
          }

          if(this.Modo === 2){
            console.log(`comparo2 -  ${ this.getMovimientos[i].id } con2 -  ${ this.idAEditar}`);
            console.log(`comparo3 -  ${ this.depto.id } con3 -  ${ this.getMovimientos[i].id_depto}`);
            if( this.getMovimientos[i].id != this.idAEditar && this.depto.id === this.getMovimientos[i].id_depto ){
              return false;
            }
          }
          
        }
        return true;
      },

      PrepararDatos(){
        this.overlay = true;
        const payload = new Object();
              payload.id_det_sol = this.informacion.id;
              payload.id_solicitud = this.informacion.id_solicitud;
              payload.fecha        = this.traerFechaActual();
              payload.hora         = this.traerHoraActual();
              payload.id_depto     = this.depto.id;
              payload.id_creador   = this.getdatosUsuario.id;
              payload.estatus      = 2;
              payload.descripcion  = this.descripcion;
              payload.idAEditar    = this.idAEditar

        this.Modo === 1 ? this.enviarSolicitud(payload): this.actualizaEnvioSol(payload);

      },

      enviarSolicitud(payload){
        this.insertaMovimientos(payload).then(response =>{
          this.Terminar(response)
          this.init();
          this.consultaDetalle(this.informacion.id_solicitud);
          this.tab = 'tab-2'
          this.limpiarCampos();
        }).catch(error =>{
          this.Terminar(error)
        }).finally(()=>{
          this.overlay = false;
        })
      },

      actualizaEnvioSol(payload){
        this.ActualizaMovimientos(payload).then(response =>{
          this.Terminar(response)
          this.init();
          this.consultaDetalle(this.informacion.id_solicitud);
          this.tab = 'tab-2'
          this.limpiarCampos();
        }).catch(error =>{
          this.Terminar(error)
        }).finally(()=>{
          this.overlay = false;
        })
      },

      verDetalle(item){
        if(item.estatus === 1){
          this.depto = { id: item.id_depto };
          this.descripcion = item.descripcion;
          this.Modo = 2
          this.tab = 'tab-1'
          this.idAEditar = item.id
        }
      },

      regresaModo1(){
        this.depto = { id: null };
        this.descripcion = '';
        this.Modo = 1
        this.tab = 'tab-2'
        this.idAEditar = null

      },

      actualizaSolicitud(){
        this.agregaOtro = true;
      },

      validaDelete(item){
        let estatus = 0, cero =0, uno=0, dos=0, tres=0;
        for(let i =0; i<this.getMovimientos.length; i++){
          if(this.getMovimientos[i].id != item.id){
            if(this.getMovimientos[i].estatus === 0){ cero++; };
            if(this.getMovimientos[i].estatus === 1){ uno++;  };
            if(this.getMovimientos[i].estatus === 2){ dos++;  };
            if(this.getMovimientos[i].estatus === 3){ tres++; };
          }
        }
        if(cero > 0){ estatus = 1; }
        else if(uno > 0) { estatus = 1; }
        else if(dos > 0) { estatus = 2; }
        else if(tres > 0){ estatus = 3; };

        this.elementoAEliminar = {  id_delete: item.id, // id para eliminar
                                    id_solicitud: this.informacion.id_solicitud, // id de solicitud 
                                    id_det_sol: item.id_det_sol,
                                   }
        this.EliminaRegistro = true
      },

      eliminaRegistro(){
        this.EliminaRegistro = false; this.overlay = true;
        this.$http.post('elimina.movimiento', this.elementoAEliminar).then(response=>{
          this.Terminar(response)
          this.init();
          this.consultaDetalle(this.informacion.id_solicitud);
				}).catch((error)=>{
					this.Terminar(error)
           console.log('err delete', err) 
				}).finally(()=>{
          this.overlay = false;
        })
      
      },

      Terminar(res){
        res.status === 200 ? this.colorCorrecto = 'green' : this.colorCorrecto = 'error';
        res.status === 200 ? this.textCorrecto = res.bodyText : this.textCorrecto = 'Ocurrio un error, intentelo de nuevo';
        this.Correcto = true; setTimeout(()=>{ this.Correcto = false}, 2000)
      },

      limpiarCampos(){
        this.depto = { id: null, nombre:''};
        this.descripcion = ''
      }
    }

  }
</script>

