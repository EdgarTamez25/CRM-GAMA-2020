<template>
    

    <v-row>
      <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
        <strong> {{alerta.text}} </strong>
        <template v-slot:action="{ attrs }">
          <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
        </template>
      </v-snackbar>
      <!-- //! TITULO DE LA PAGINA -->
      <v-col class="text-center">
        <v-card-text class="font-weight-black text-h6">
          GENERADOR DE ORDENES DE TRABAJO
        </v-card-text>
      </v-col>

      <!-- //! TABLA DE INFORMACION DE LA SOLICITUD -->
      <v-col cols="12 py-0">
        <v-card outlined>
          <v-simple-table dense >
            <template v-slot:default>
              <tbody >
                <tr>
                  <td class="font-weight-black">SOLICITUD</td>
                  <td class="subtitle-1"  align="left"> {{ solicitud.id }}</td>
                </tr>
                <tr >
                  <td class="font-weight-black">CLIENTE</td>
                  <td class="subtitle-1"  align="left"> {{ solicitud.nomcli }}</td>
                </tr>
                <tr>
                  <td class="font-weight-black">RESPONSABLE</td>
                  <td class="subtitle-1">{{ solicitud.nomusuario }}</td>
                </tr>
                
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
       
      </v-col>

      <v-col cols="12" sm="6" md="5">
        <v-text-field v-model="oc" hide-details dense filled placeholder="Orden de trabajo" label="Orden de compra"></v-text-field>
      </v-col>

      <v-col cols="12">
        <v-simple-table dense>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left green white--text"> PRODUCTO </th>
                <th class="text-left green white--text"> CANTIDAD </th>
                <th class="text-left green white--text"> CONCEPTO </th>
                <th class="text-left green white--text"> URGENCIA </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,i) in Detalle" :key="i" >
                <td class="font-weight-black" width="150px" >  {{ item.codigo }}  </td>
                <td width="150px">{{ item.cantidad }}</td>
                <td > 
                  <v-select
                    v-model="item.concepto" :items="conceptos" item-text="nombre" item-value="id" color="celeste" 
                    dense hide-details  placeholder="Concepto" return-object 
                  ></v-select> 
                </td>
                <td > 
                  <span class="mt-1 pa-1">
                    <v-select
                      v-model="item.urgencia" :items="urgencias" item-text="nombre" item-value="id" color="celeste" 
                      dense hide-details  placeholder="Urgencia" return-object solo
                    ></v-select> 
                  </span>
                  <span class="mt-1 pa-1" >
                    <v-textarea
                      v-model ="item.razon"  label="Razon de la urgencia" rows="1" hide-details dense  
                    ></v-textarea>
                  </span>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>

      <v-footer absolute fixed>
        <v-btn color="error" dark outlined @click="$emit('modal',false)"  > CANCELAR</v-btn>
        <v-spacer></v-spacer>
        <v-btn dark color="celeste" @click="validaInformacion()" :disabled="overlay ? true : false" >
          Generar O.T 
        </v-btn> 
      </v-footer>

      <v-dialog v-model="alertaGenerarOT" persistent max-width="500">
        <v-card >
          <v-card-title class="subtitle-1 font-weight-black" style="word-break:normal;" > SE GENERARA LA ORDEN DE TRABAJO CON LA INFORMACIÓN ACTUAL  </v-card-title>
          <v-card-subtitle class=" mt-1 subtitle-2 font-weight-black">¿ ESTA SEGURO DE QUERER CONTINUAR ?</v-card-subtitle>
          <v-divider class="my-0 py-3" ></v-divider>
          <v-card-subtitle align="center" class="red--text font-weight-bold "> NO SE PODRAN EFECTUAR CAMBIOS POSTERIORES </v-card-subtitle>
          <v-divider class="my-0 py-2 " ></v-divider>
          <v-card-actions>
            <v-spacer/>
            <v-btn dark outlined color="gris" @click="alertaGenerarOT = false">Regresar</v-btn>
            <v-btn dark color="error" @click="PrepararObjecto()"  >Continuar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>


    	<overlay v-if="overlay"/>
      
    </v-row>
  <!-- </v-main> -->
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
	import metodos         from '@/mixins/metodos.js';
  import overlay         from '@/components/overlay.vue'
  export default {
    components:{
      overlay,
    },
    mixins:[metodos],
    props:[
      'solicitud',
      'detallesol',
      'generarOT'
    ],
    data (){
      return {
        Detalle:[],
        urgencias:[{id:1, nombre:'NORMAL'},{id:2, nombre:'URGENTE'},{ id:3, nombre:'PRIORIDAD'}],
        conceptos: [{id:1, nombre:'PRODUCCION'}, {id:2, nombre:'STOCK'}],
        oc:'',

        alertaGenerarOT: false,
        overlay: false,
        alerta: { 
          activo: false,
          text: '',
          color: 'error',
        }
      }
    },


    created(){
      this.init()
    },

    computed:{
      ...mapGetters('Login' ,['getdatosUsuario']), 
    },


    methods: {  
      init(){
        this.Detalle = [];
        for(let i=0; i<this.detallesol.length; i++){
          this.Detalle.push( {
              id           : this.detallesol[i].id,
              id_solicitud : this.detallesol[i].id_solicitud,
              id_depto     : this.detallesol[i].id_depto,
              id_producto  : this.detallesol[i].id_producto,
              nombre       : this.detallesol[i].nombre, 
              codigo       : this.detallesol[i].codigo,
              descripcion  : this.detallesol[i].descripcion,
              tipo_prod    : this.detallesol[i].tipo_prod,
              cantidad     : this.detallesol[i].cantidad,
              estatus      : this.detallesol[i].estatus,
              concepto     : null,
              urgencia     : null,
              razon        : ''
          })
        }
      },

      validaInformacion(){
        for(let item of this.Detalle){
          if(!item.concepto){
            this.alerta = { activo: true, text:`Aun no seleccionas el concepto para el producto ${ item.codigo }. `, color:'error'};
            return
          }
          if(!item.urgencia){
            this.alerta = { activo: true, text:`Aun no seleccionas la urgencia del producto ${ item.codigo }.`, color:'error'};
            return;
          }

          if(item.urgencia.id != 1){
            if(!item.razon){
              this.alerta = { activo: true, text:`Debes añadir la razon de la urgencia para el producto ${ item.codigo }.`, color:'error'};
              return;
            }
          }
        }
        this.alertaGenerarOT = true;
        // this.PrepararObjecto()
      },

      PrepararObjecto(){
        this.alertaGenerarOT = false;  this.overlay = true
        const ot = new Object({
          id_solicitante : this.solicitud.id_usuario,
          id_cliente     : this.solicitud.id_cliente,
          id_solicitud   : this.solicitud.id,
          oc             : this.oc ? this.oc : '',
          fecha          : this.traerFechaActual(),
          hora           : this.traerHoraActual(),
          id_creador     : this.getdatosUsuario.id,
          detalle        : this.Detalle
        });

        // console.log('OT', ot)
        this.$http.post('crear.orden.trabajo', ot).then( response =>{
            this.alerta = { activo: true, text: response.bodyText, color:'green'};
            // let that = this; setTimeout(() => { that.$emit('modal',false)}, 2000);
			    	this.$router.push({ name:'solicitudes' }) 
        }).catch(error =>{
            this.alerta = { activo: true, text: error.bodyText, color:'error'};
        }).finally(()=>{
          this.overlay = false
        })
      }

    },
  }
</script>