<template>
  <v-row class="fill-height" align-content="center" justify="center" >
     <v-snackbar v-model="snackbar" multi-line :timeout="2000" top right color="error" class="font-weight-black subtitle-1"> 
       {{text}}
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text @click="snackbar = false" v-bind="attrs"> Cerrar </v-btn>
      </template>
    </v-snackbar>
    <!-- LOADING -->
    <v-container style="height: 400px;" v-if="Loading">
      <loading/>
    </v-container>

    <!-- OVERLAY -->
    <overlay v-if="overlay"/>

    <v-col cols="12" v-if="!Loading && informacion.tipo_prod === 1 && informacion.estatus === 3 && !getMovimientos.length">
      <v-card flat>
        <v-card-text class="font-weight-black text-center headline">
          PRODUCTO VALIDADO POR CALL - CENTER
        </v-card-text>
      </v-card>
      <v-col class="mt-5"></v-col>

      <v-footer absolute v-if="!Loading">
        <v-btn color="error" dark small outlined @click="$emit('modal',false)"> CANCELAR</v-btn>
      </v-footer>
    </v-col>

    <v-col cols="12" v-else>
      <v-col cols="12" class="font-weight-black text-center headline" v-if="!Loading">
        ENVÍO DE SOLICITUDES
      </v-col>

      <v-col  cols="12" v-if="!Loading && Modo === 1">
        <v-select
          v-model="depto" :items="deptos" item-text="nombre" item-value="id" filled  color="celeste" 
          label="MANDAR A " return-object multiple chips hide-details class="font-weight-black" 
        ></v-select>
      </v-col>

      <v-col  cols="12" v-if="!Loading && Modo === 1 && !getMovimientos.length && informacion.tipo_prod === 1">
        <v-btn  color="rosa" outlined block @click="validarFinalizacion = true"> VALIDAR PARTIDA </v-btn>  
      </v-col>

      <v-col  cols="12" v-if="!Loading && agregaOtro ">
        <v-select
          v-model="depto" :items="deptos" item-text="nombre" item-value="id" filled  color="celeste" 
          label="MANDAR A " return-object multiple chips hide-details class="font-weight-black" 
        ></v-select>
      </v-col>
    
      <v-col cols="12" v-if="!Loading" class="py-0">
        <v-card class="my-1" outlined style="border-color: #0096cb;" height="auto" v-for="(item, i) in getMovimientos" :key="i">
          <v-row class="d-flex flex-no-wrap justify-space-between">
            <v-col>
              <v-card-text class="font-weight-black subtitle-1 "> 
                {{ deptos[item.id_depto-1 ].nombre }} 
              </v-card-text>
            </v-col>
            <v-col>
              <v-card-text :class="['subtitle-1','font-weight-black','text-center']">
                <span v-if="item.estatus === 1"> ASIGNADO  </span>
                <span v-if="item.estatus === 2"> REALIZADO</span>
                <span v-if="item.estatus === 3"> TERMINADO </span>
                <span v-if="item.estatus === 4"> CANCELADO </span>
              </v-card-text>
            </v-col>
            <v-col>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" dark fab small v-if="item.estatus === 1 && item.id_encargado === null"   
                      @click="validaDelete(item)"> 
                  <v-icon>mdi-close</v-icon> 
                </v-btn>
                <v-btn color="gris" dark fab small v-if="item.estatus === 1 && item.id_encargado != null"> 
                  <v-icon>mdi-account-alert</v-icon> 
                </v-btn>
                <v-btn color="orange" dark fab small v-if="item.estatus === 2"  > 
                  <v-icon>mdi-account-arrow-right</v-icon> 
                </v-btn>
                <v-btn color="green" dark fab small v-if="item.estatus === 3"  > 
                  <v-icon>mdi-account-check</v-icon> 
                </v-btn>
                <v-btn color="error" dark fab small v-if="item.estatus === 4"  > 
                  <v-icon>mdi-account-cancel</v-icon> 
                </v-btn>
              </v-card-actions>
            </v-col>
          </v-row>
        </v-card>
      </v-col>

      <v-col class="mt-5"></v-col>

      <v-footer absolute v-if="!Loading">
        <v-btn color="error" dark small outlined @click="$emit('modal',false)"> CANCELAR</v-btn>
        <v-spacer></v-spacer>
        <v-btn dark color="celeste" small @click="validaEnvio()" v-if="agregaOtro || !agregaOtro && Modo === 1 ">
        Envíar Solicitud
        </v-btn>
        <v-btn dark color="celeste" small @click="actualizaSolicitud()" v-if="!agregaOtro && Modo === 2">
          Actualizar Solicitud
        </v-btn>
      </v-footer>

    </v-col >


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

    <v-dialog v-model="validarFinalizacion" persistent width="400" >
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
    </v-dialog>

    

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
      'actualiza'
    ],
    data: () => ({
      Modo: 0,
      agregaOtro: false, 
      depto:[],
      deptos:[{ id: 1, nombre:'DESARROLLO'}, 
              { id: 2, nombre:'DIGITAL'   }, 
              { id: 3, nombre:'DISEÑO'    },
              { id: 4, nombre:'CANCELADO'    },

                 
            ],

      overlay : false,
      Correcto: false,
      textCorrecto: '',
      colorCorrecto: 'green',

      snackbar:false,
      text: '',

      EliminaRegistro: false,
      elementoAEliminar: {},

      validarFinalizacion: false,


    }),

    created(){
      this.init();
    },

    computed:{
      ...mapGetters('Movimientos'  ,['getMovimientos','Loading']), // IMPORTANDO USO DE VUEX - (GETTERS)
      ...mapGetters('Login' ,['getdatosUsuario']), 
    },

    watch:{
      informacion(){
        this.init();
      },
    },

    methods:{
        ...mapActions('Movimientos'  ,['consultaMovimientos','insertaMovimientos','deleteEnvio']), 
       ...mapActions('Solicitudes'  ,['consultaDetalle']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

      init(){
        const payload = { px: this.informacion.tipo_prod,
                          id_px: this.informacion.id,
                        }
        this.consultaMovimientos(payload).then( response => {
          this.depto = [];
          if(response){
            // for(let i=0;i<this.getMovimientos.length; i++ ){
            //   this.depto.push({ id: this.getMovimientos[i].id_depto })
            // }
            this.Modo = 2; this.agregaOtro = false;
          }else{
            this.Modo = 1; this.agregaOtro = false;
          }
        });
      },

      validaEnvio(){
        if(!this.depto.length ){
          this.snackbar = true; this.text="Debe seleccionar al menos 1 departamento."; return;
        }

        if(this.Modo === 2){
          var errores = 0
          for(let i=0; i< this.getMovimientos.length; i++ ){
           for(let j=0; j< this.depto.length; j++){
             if(this.getMovimientos[i].id_depto === this.depto[j].id){
               errores++
             }
           }
          }

          if(errores === 0){
            this.enviarSolicitud()
          }else{
            this.snackbar = true; this.text="No se pueden repetir los envíos de solicitudes."; return;
          }
        }

        if(this.Modo === 1 ){
          this.enviarSolicitud()
        }
      },

      enviarSolicitud(){
        this.overlay = true;
        const payload = { id: this.informacion.id,
                          id_solicitud: this.informacion.id_solicitud,
                          id_px: this.informacion.id,
                          px: this.informacion.tipo_prod,
                          fecha:  this.traerFechaActual(),
                          hora: this.traerHoraActual(),
                          deptos: this.depto,
                          id_usuario: this.getdatosUsuario.id,
                          estatus: 2
                        }
        
        this.insertaMovimientos(payload).then(response =>{
          this.Terminar(response)
          this.init();
          this.consultaDetalle(this.informacion.id_solicitud);
        }).catch(error =>{
          this.Terminar(error)
        })
      },

      actualizaSolicitud(){
        this.agregaOtro = true;
      },

      finalizaProdExist(){
        this.validarFinalizacion = false; this.overlay = true;
        const payload = new Object();
              payload.id           = this.informacion.id;
              payload.id_solicitud = this.informacion.id_solicitud
              payload.estatus     = 3;
        
        this.$http.post('finaliza.prodexit', payload).then(response =>{
          this.Terminar(response)
          this.init(); var me = this;
          setTimeout(()=>{ me.$emit('modal',false); me.$emit('put', this.actualiza = !this.actualiza)}, 1500)
        }).catch(error => { console.log('error', error )})
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
                                    id_solicitud: item.id_solicitud, // id de solicitud 
                                    px: item.px, // identidificador de tabla
                                    id: this.informacion.id,
                                    estatus: estatus // estatus para actualizar
                                   }
        // console.log('elementoAEliminar', this.elementoAEliminar);
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
				})
      
      },

      Terminar(res){
        res.status === 200 ? this.colorCorrecto = 'green' : this.colorCorrecto = 'error';
        res.status === 200 ? this.textCorrecto = res.bodyText : this.textCorrecto = 'Ocurrio un error, intentelo de nuevo';
        this.overlay = false; this.Correcto = true;
        setTimeout(()=>{ this.Correcto = false}, 2000)
      }
    }

  }
</script>

