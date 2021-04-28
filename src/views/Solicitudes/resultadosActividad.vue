<template>
  <v-row  align-content="center" justify="center" >
    <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
      <strong> {{alerta.text}} </strong>
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
      </template>
    </v-snackbar>
     <v-tabs color="rosa" centered icons-and-text v-model="tab">
      <v-tabs-slider></v-tabs-slider>
      <v-tab href="#tab-1" > Solicitud </v-tab>
      <v-tab href="#tab-2">  Resultados   </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab" class="my-3">
      <v-tab-item value="tab-1">
          <v-card width="450px" outlined>
            <v-simple-table dense >
              <template v-slot:default>
                <tbody >
                  <tr >
                    <td class="font-weight-black">SOLICITUD</td>
                    <td  align="left"> {{ informacion.id_solicitud  }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">CLIENTE</td>
                    <td>{{ informacion.nomcli }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">TIPO</td>
                    <td v-if="informacion.tipo_prod === 1 "> Producto Existente </td>
                    <td v-if="informacion.tipo_prod === 2 "> Modificación  </td>
                    <td v-if="informacion.tipo_prod === 3 "> Nuevo Producto  </td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">PRODUCTO</td>
                    <td> {{ informacion.codigo }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-black">FECHA</td>
                    <td> {{ informacion.fecha }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card>
          <v-card class="mt-3">
            <v-textarea
              v-model="informacion.descripcion" prepend-inner-icon="mdi-comment" label="Se te solicita" rows="4" outlined disabled
            ></v-textarea>
          </v-card>
      </v-tab-item>

      <v-tab-item value="tab-2">
        <v-row justify="center" >
          <v-col cols="11" class="py-1" v-if="informacion.estatus === 1">
            <v-textarea
              v-model="resultado_actividad"  label="Tarea realizada" rows="3" outlined hide-details="" 
            ></v-textarea> 
          </v-col>
          <v-col cols="11" class="py-0 text-right" v-if="informacion.estatus === 1">
            <v-btn color="rosa" dark small @click="AgregarResultado()"> Agregar Resultado</v-btn>
          </v-col>

          <v-col cols="11" v-if="!getResultados.length" >
            <v-alert outlined type="warning" transition="scale-transition">
              Actualmente no se encontrarion resultados realizados de está solicitud.
            </v-alert>
          </v-col>

          <v-card  width="450px" v-else class="my-8">
            <v-list two-line subheader >
              <v-list-item v-for="(item , i) in getResultados" :key="i" link >
                <v-list-item-content >
                  <v-list-item-title    class="font-weight-black caption">RESULTADO - {{ item.fecha}}  </v-list-item-title>
                  <v-card-text class="pa-0 text-justify"> {{ item.resultado }} </v-card-text>
                </v-list-item-content>
              
                <v-list-item-action>
                  <v-btn color="error" dark fab x-small 
                        v-if="item.estatus === 1"   
                        @click="itemAEliminar = item ; EliminaRegistro= true "> 
                    <v-icon>mdi-delete</v-icon> 
                  </v-btn>
                  <v-btn color="green" dark fab x-small  v-else> 
                    <v-icon>mdi-account-check</v-icon> 
                  </v-btn>
                </v-list-item-action>
              </v-list-item>
            </v-list>
          </v-card>
        </v-row>
      </v-tab-item>
    </v-tabs-items>

    <v-dialog v-model="EliminaRegistro" persistent max-width="450">
      <v-card >
        <v-card-title class="subtitle-1 font-weight-black" > EL REGISTRO SE ELIMINARA   </v-card-title>
        <v-card-subtitle class="subtitle-2 font-weight-black">¿ ESTA SEGURO DE QUERER CONTINUAR ?</v-card-subtitle>
        <v-divider class="my-0 py-3" ></v-divider>
        <v-card-subtitle align="center" class="red--text font-weight-bold "> SE ELIMINARA DE FORMA DEFINITIVA </v-card-subtitle>
        <v-divider class="my-0 py-2 " ></v-divider>
        <v-card-actions>
          <v-spacer/>
          <v-btn dark outlined color="gris" @click="EliminaRegistro = false">Regresar</v-btn>
          <v-btn dark color="error" @click="eliminaRegistro()" >Continuar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-footer absolute>
      <v-btn color="error" dark outlined @click="$emit('modal',false)"> CANCELAR</v-btn>
      <v-spacer></v-spacer>
      <v-btn dark color="celeste" @click="finalizarSolicitud()"  v-if="informacion.estatus === 1" >
        Finalizar Solicitud
      </v-btn>
    </v-footer>

    <overlay v-if="overlay"/>


  </v-row>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
	  import metodos from '@/mixins/metodos.js';
    import overlay from '@/components/overlay.vue'
    
    export default {
      components:{
        overlay
      },
      mixins:[metodos],

      props:[
        'informacion'
      ],
      data:()=>({
        tab: null,
        descripcion:'',
        resultado_actividad: '',
        itemAEliminar: {},
        
        EliminaRegistro: false,
        overlay: false,
        alerta: { 
          activo: false,
          text: '',
          color: 'error',
        },
      }),

      created(){
      // this.consultaProdxCli(this.solicitud.id_cliente);
      // this.llenaCamposDefault();
        this.init();
      },

      computed:{
        ...mapGetters('Movimientos'  ,['getResultados','Loading']), // IMPORTANDO USO DE VUEX - (GETTERS)
        ...mapGetters('Login' ,['getdatosUsuario']), 
      },

      methods:{
        ...mapActions('Movimientos'  ,['agregarResultado','consultaResultados','eliminarResultado']), 
        ...mapActions('Solicitudes'  ,['consultaSolicitudesDDD']),

        init(){
          this.consultaResultados(this.informacion.id);
        },

        AgregarResultado(){
          if(!this.resultado_actividad){ this.alerta = { activo: true, text: 'Debes agregar un resultado.' , color:'error '}; return;  }
          this.overlay = true;
          const payload = new Object();
                payload.id_movim_sol = this.informacion.id;
                payload.resultado    = this.resultado_actividad;
                payload.fecha        = this.traerFechaActual();
                payload.hora         = this.traerHoraActual();
                payload.id_creador   = this.getdatosUsuario.id;

          this.agregarResultado(payload).then( response =>{
            this.alerta = { activo: true, text: response , color:'green '}
            this.resultado_actividad = '';
            this.init();
          }).catch( error =>{
            this.alerta = { activo: true, text: error , color:'error '}
          }).finally(()=>{
            this.overlay = false
          })
        },

        eliminaRegistro(){
            this.EliminaRegistro = false; this.overlay = true;
            this.eliminarResultado(this.itemAEliminar.id).then(response=>{
              this.alerta = { activo: true, text: response , color:'green '}
              this.init();
            }).catch((error)=>{
              this.alerta = { activo: true, text: error , color:'error '}
              console.log('err delete', err) 
            }).finally(()=>{
              this.overlay = false;
            })
        },

        finalizarSolicitud(){
          if(!this.getResultados.length){ this.alerta = { activo: true, text: 'Debes agregar al menos un resultado.' , color:'error '}; return; };

          this.overlay = true;
          const payload = new Object();
                payload.id = this.informacion.id;
                payload.estatus = 2
                payload.id_det_sol = this.informacion.id_det_sol
                payload.id_solicitud = this.informacion.id_solicitud

        // ESTA FUNCION CAEE EN EL CONTROLADOR DE REGISTROS DE ACTIVIDAD
          this.$http.post('actualiza.estatus.resultado', payload ).then( response =>{
            // console.log('response', response.bodyText)
            this.alerta = { activo: true, text: response.bodyText , color:'green'}
            this.consultaSolicitudesDDD();
            let me = this;
            setTimeout(() => {  me.$emit('modal',false) }, 2000);
          }).catch( error =>{
            this.alerta = { activo: true, text: error.bodyText    , color:'error '}
            // this.activarAlerta(error.bodyText, 500);
          }).finally(()=>{
            this.overlay = false;
          })

        },
        
      }

    }
  </script>
    