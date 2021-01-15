<template>
  <v-row>
    <v-col v-if="!Loading">
      <v-snackbar v-model="snackbar" multi-line top right color="error" class="font-weight-black subtitle-1"> {{ text }}
        <template v-slot:action="{ attrs }">
          <v-btn dark text v-bind="attrs" @click="snackbar = false"> Cerrar</v-btn>
        </template>
      </v-snackbar>

      <v-card-actions >
        <!-- <v-card-text class="font-weight-black headline " > -->
          <!-- {{ parametros.ft }} -->
          <!-- {{ parametros }} -->
        <!-- </v-card-text> -->

         <v-simple-table dense>
          <template v-slot:default>
            <tbody>
              <tr><td>Solicitud</td> <td>{{ parametros.id_solicitud }} </td></tr>
              <tr><td>Cliente  </td> <td>{{ parametros.nomcli }}       </td></tr>
              <tr><td>Vendedor </td> <td>{{ parametros.nomvend }}      </td></tr>
              <tr><td>Tipo  </td> 
                <td class="font-weight-black rosa--text" v-if="parametros.tipo_prod === 1"> Producto Existente </td>
                <td class="font-weight-black orange--text" v-if="parametros.tipo_prod === 2"> Modificación </td>
                <td class="font-weight-black celeste--text" v-if="parametros.tipo_prod === 3"> Nuevo Producto </td>
              </tr>
              <tr><td class="font-weight-black">Referencia </td> <td class="font-weight-black">{{ parametros.ft }}</td></tr>
              <tr><td class="font-weight-black">Cantidad   </td> <td class="font-weight-black">{{ parametros.cantidad }}</td></tr>
            </tbody>
          </template>
        </v-simple-table>

      </v-card-actions>



      

      <div class="mt-12" ></div>
     
      <v-footer absolute class="pa-3" >
        <v-btn color="error" outlined small @click="$emit('modal',false)" >Cancelar </v-btn>
        <v-spacer></v-spacer>
        <v-btn color="rosa"    class="mx-1" dark small @click="realizadoFinalizado = true, modo= 1" 
                v-if="modalDDD && parametros.estatus_key === 1"> Realizado 
        </v-btn>
        <v-btn color="celeste" class="mx-1" dark small @click="realizadoFinalizado = true, modo= 2" 
               v-if="modalDDD && parametros.estatus_key !=3"> Finalizar 
        </v-btn>
        <v-btn color="success" small  @click="validaInformacion()" v-if="!modalDDD">Guardar información </v-btn>
      </v-footer>

      <v-dialog v-model="realizadoFinalizado" width="450px">
        <v-card class="pa-1">
          <v-card-text class="pa-4 font-weight-black subtitle-1" >
            <span v-if="modo===1"> LA SOLICITUD SE QUEDARA PENDIENTE DE AUTORIZAR POR EL CLIENTE </span>
            <span v-else> LA SOLICITUD SE TOMARA COMO REALIZADA Y AUTORIZADA </span>
          </v-card-text>
          <v-card-subtitle class="font-weight-black" align="center">
            ¿ ESTAS SEGURO DE CONTINUAR ?
          </v-card-subtitle>
          <v-card-actions>
            <v-btn color="error" small @click="realizadoFinalizado = false">Cancelar</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="celeste" dark small @click="PrepararMovimiento()">Continuar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog v-model="Correcto" hide-overlay persistent width="350">
        <v-card :color="colorCorrecto" dark class="pa-3">
          <v-card-text class="font-weight-black headline pa-3 white--text" align="center">
            {{ textCorrecto }}
          </v-card-text>
        </v-card>
      </v-dialog>

    </v-col>


    <!-- OVERLAY -->
    <overlay v-if="overlay"/>
    <!-- LOADING -->
    <v-container style="height: 400px;" v-if="Loading">
      <loading/>
    </v-container>

  </v-row>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import loading     from '@/components/loading.vue'
  import overlay     from '@/components/overlay.vue'
  import metodos     from '@/mixins/metodos.js'

  export default {
    mixins:[metodos],
    components:{
      loading,
      overlay
    },
    props:[
			'modoVista',
      'parametros',
      'actualiza',
      'modalDDD'
	  ],
    data:()=> ({
      Loading: true,
      
      snackbar     : false,
      text         : '',
      Correcto     : false,
      colorCorrecto : '',
      textCorrecto : 'La información se guardo correctamente',
      overlay      : false,
      modo         : 0,

      realizadoFinalizado: false,
    }),  
    computed:{
      // ...mapGetters('Solicitudes'  ,['getModificaciones']), // IMPORTANDO USO DE VUEX  (GETTERS)
			...mapGetters('Login' ,['getLogeado','getdatosUsuario']), 
    },
    created(){
      this.init()
    },

    watch:{
			parametros: function(){
        this.init();
      },
      
		},

    methods:{
      // ...mapActions('Solicitudes'  ,['consultaModificaciones','actualizaModificaciones','consultaDetalle']), // IMPORTANDO USO DE VUEX - 
      
      init(){
        this.Loading = false;
      },

      PrepararMovimiento(){
        this.realizadoFinalizado = false;
        const payload = { id_key: this.parametros.id_key, 
                          responsable2: this.getdatosUsuario.id, 
                          estatus: this.modo === 1? 2:3,
                          id_solicitud: this.parametros.id_solicitud,
                          id: this.parametros.id,
                          px: this.parametros.px
                        }
                        
        this.procesarMovimiento(payload);
      },

      procesarMovimiento(payload){
        this.overlay = true; 
        this.$http.post('procesa.movimiento', payload).then(response =>{
          this.overlay  = false; this.colorCorrecto = 'green';
          this.Correcto = true; this.textCorrecto = response.bodyText; 
          this.Terminar(200)
        }).catch( error =>{
          this.overlay = false; this.colorCorrecto = 'error'; this.textCorrecto = error.bodyText;
          this.Terminar(500)
        })
      },

      Terminar(status){
        var me = this;
        status === 200? setTimeout(function(){ me.$emit('modal',false); me.$emit('put', this.actualiza = !this.actualiza)}, 1500):
                        setTimeout(function(){ me.Correcto = false    }, 1500)
        
      },
      
    }
  }
</script>