<template>
  <v-row class="pa-4" >
    
    <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
      <strong> {{alerta.text}} </strong>
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
      </template>
    </v-snackbar>

    <!-- //! TITULO DE LA PAGINA -->
    <v-col cols="12" class="py-0">
      <v-card-actions class="pa-0" >
        <v-card-text class="font-weight-black text-h6">
          GENERADOR DE ORDENES DE TRABAJO
        </v-card-text>
        <v-spacer></v-spacer>
        <v-btn color="error"  @click="$emit('modal',false)" ><v-icon>clear</v-icon></v-btn>
      </v-card-actions>
    </v-col>

    <!-- //! TABLA DE INFORMACION DE LA SOLICITUD -->
    <v-col cols="12"  sm="7"  class="text-left">
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

    <v-col cols="12" sm="5"  class="">
      <v-text-field v-model="oc" hide-details dense filled placeholder="Orden de compra" label="Orden de compra"></v-text-field>
    </v-col>

    <v-col cols="12">
      <v-simple-table dense>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left rosa white--text"> PRODUCTO </th>
              <th class="text-left rosa white--text"> CANTIDAD </th>
              <th class="text-left rosa white--text"> UNIDAD </th>
              <!-- <th class="text-left rosa white--text"> CONCEPTO </th> -->
               <th class="text-left rosa white--text"> F.ENTREGA </th> 
              <th class="text-left rosa white--text"> ESTATUS </th> 
              <th class="text-left rosa white--text">  </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,i) in Detalle" :key="i" >
              <td width="0px" >
               <v-btn text class="font-weight-black"> {{ item.codigo }}  </v-btn>   
              </td>
              <td width="100px" >{{ item.cantidad | currency(0) }}</td>
              <td width="100px" > {{ item.unidad }} </td>
              <!-- <td > 
                <span v-if="item.concepto" > {{ item.concepto.nombre }} </span>
                <span v-else > SIN CONCEPTO </span>
              </td> -->
              <td>
                <span v-if="item.fecha" > {{ moment(item.fecha).format('LL') }} </span>
                <span v-else> SIN FECHA </span>
              </td>
              <td > 
                <v-btn fab text small color="success" v-if="item.urgencia"> 
                  <v-icon large> mdi-check-bold </v-icon> 
                </v-btn>
                <v-btn fab text small color="error" v-else> 
                  <v-icon large> mdi-alert-octagon-outline </v-icon> 
                </v-btn>
              </td> 
              <td class="pa-2"> 
                <v-btn fab small color="celeste" dark 
                  @click="abrir_detalle_partida(item)"
                > 
                  <v-icon> mdi-pencil </v-icon>  
                </v-btn> 
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-col>

    <v-col class="mt-5"/>

    <v-footer absolute fixed>
      <v-spacer></v-spacer>
      <v-btn dark color="success" @click="alertaGenerarOT = true" :disabled="GENERAR_OT" >
        Generar Orden de trabajo 
      </v-btn> 
    </v-footer>

    <v-dialog v-model="alertaGenerarOT" persistent max-width="500">
      <v-card >
        <v-card-title class="subtitle-1 font-weight-black" style="word-break:normal;"> 
          SE GENERARA LA ORDEN DE TRABAJO CON LA INFORMACIÓN ACTUAL  
        </v-card-title>
        <v-card-subtitle class=" mt-1 subtitle-2 font-weight-black">
          ¿ ESTA SEGURO DE QUERER CONTINUAR ?
        </v-card-subtitle>
        <v-divider class="my-0 py-3" ></v-divider>
        <v-card-subtitle align="center" class="red--text font-weight-bold "> 
          NO SE PODRAN EFECTUAR CAMBIOS POSTERIORES 
        </v-card-subtitle>
        <v-divider class="my-0 py-2 " ></v-divider>
        <v-card-actions>
          <v-spacer/>
          <v-btn dark outlined color="gris" @click="alertaGenerarOT = false">Regresar</v-btn>
          <v-btn dark color="error" @click="PrepararObjecto()"  >Continuar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="detalleModal" width="450px" persistent>
      <v-card class="pa-4">
        <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
          <strong> {{alerta.text}} </strong>
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
          </template>
        </v-snackbar>

        <v-card-text class="font-weight-black text-h6 text-center "> DETALLE DE LA PARTIDA </v-card-text>

        <v-row>
          <!--
            <v-col cols="12">
              <v-select
                v-model="editDetalle.concepto" :items="conceptos" item-text="nombre" item-value="id" color="celeste" 
                outlined dense hide-details  placeholder="Concepto" return-object 
              ></v-select>
            </v-col>
          -->
          <v-col cols="12" sm="6"> 
            <v-text-field 
              v-model="editDetalle.fecha" label="Fecha de entrega" 
              outlined dense hide-details color="rosa" type="date"
            ></v-text-field> 
          </v-col>

          <v-col cols="12" sm="6">
            <v-select
              v-model="editDetalle.urgencia" :items="urgencias" item-text="nombre" item-value="id" color="celeste" 
              dense hide-details placeholder="Urgencia" return-object outlined
            ></v-select>
          </v-col>

          <v-col cols="12" v-if="editDetalle.urgencia && editDetalle.urgencia.id != 1">
            <v-textarea
              v-model="editDetalle.razon" 
              label="Razon"
              placeholder="Escribe la razon de tu urgencia." 
              rows="1" 
              hide-details dense filled
            ></v-textarea>
          </v-col>

          <v-col cols="12" >
            <v-textarea
              v-model="editDetalle.comentarios" 
              label="Comentarios" 
              placeholder="Escribe tus comentarios aqui..."
              rows="4"
              hide-details dense outlined
            ></v-textarea>
          </v-col>

        </v-row>

        <div class="mt-10"> </div>
        <v-footer absolute fixed>
          <v-btn  text color="error" @click="detalleModal = false">Cancelar</v-btn>
            <v-spacer></v-spacer>
          <v-btn  dark color="celeste" @click="validar_detalle_partida()" :disabled="overlay ? true : false" >
            Guardar
          </v-btn> 
        </v-footer>

      </v-card>
    </v-dialog>

    <overlay v-if="overlay"/>
    
  </v-row>
</template>

<script>
  import Vue from 'vue'
  import {mapGetters, mapActions} from 'vuex';
	import metodos         from '@/mixins/metodos.js';
  import overlay         from '@/components/overlay.vue'
   var accounting = require("accounting");
  Vue.filter('currency', (val, dec) => { return accounting.formatMoney(val, '', dec) });

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

        concepto:'',
        urgencia: '',
        razon:'',


        alertaGenerarOT: false,
        overlay: false,
        alerta: { 
          activo: false,
          text: '',
          color: 'error',
        },

        fecha: '',
        menu: false,

        detalleModal: false,
        editedIndex: -1,
        editDetalle : {
          id: null,
          concepto: { id: 1, nombre: 'PRODUCCION' },
          fecha: '',
          urgencia: { id:null, nombre: '' },
          razon: '',
          comentarios: '',
        }
      }
    },

    created(){
      this.init()
    },

    watch:{
      detallesol(){
        this.init();
      }
    },

    computed:{
      ...mapGetters('Login' ,['getdatosUsuario']), 

      GENERAR_OT(){
        for(let i = 0 ; i < this.Detalle.length; i++){
          if(!this.Detalle[i].listo){  return true; }
        }
        return false;
      }
    },

    methods: {  
      init(){
        // console.log('detallesol', this.detallesol)
        this.Detalle = []; this.fecha = this.traerFechaActual();
        for(let i=0; i<this.detallesol.length; i++){
          if(this.detallesol[i].estatus != 4){ 
            this.Detalle.push({ 
              ...this.detallesol[i], 
              concepto     : { id: 1, nombre:'PRODUCCIÓN'},
              urgencia     : null,
              razon        : '',
              comentarios  : '',
              fecha        : this.traerFechaActual(),
              listo        : false 
            })
          }
          
        }
      },

      PrepararObjecto(){
        this.alertaGenerarOT = false;  this.overlay = true
        const ot = {
          id_cliente     : this.solicitud.id_cliente,
          id_solicitante : this.solicitud.id_usuario,
          id_solicitud   : this.solicitud.id,
          oc             : this.oc ? this.oc : '',
          fecha          : this.traerFechaActual(),
          hora           : this.traerHoraActual(),
          id_creador     : this.getdatosUsuario.id,
          detalle        : this.Detalle,
          fecha_procesado: this.traerFechaActual() + ' ' + this.traerHoraActual(),
          sistema        : 'CRM-GAMA'
        };
        // console.log('OT', ot);
        // return 
        this.$http.post('crear.orden.trabajo', ot).then( response =>{
            this.alerta = { activo: true, text: response.bodyText, color:'green'};
            let that = this; setTimeout(() => { that.$router.push({ name:'solicitudes' })}, 1500);
			    	// this.$router.push({ name:'solicitudes' });
        }).catch(error =>{
            this.alerta = { activo: true, text: error.bodyText, color:'error'};
        }).finally(()=>{
          this.overlay = false
        })
      },

      editItem (item) {
        
      },

      abrir_detalle_partida(item){
        this.editedIndex = this.Detalle.indexOf(item)
        this.editDetalle = Object.assign({}, item)
        this.detalleModal = true
      },

      validar_detalle_partida(){
        
        if(!this.editDetalle.urgencia){
          this.alerta = { activo: true, text:`Aun no seleccionas la urgencia del producto ${ this.editDetalle.codigo }.`, color:'error'};
          return;
        }
        if(this.editDetalle.urgencia.id != 1){
          if(!this.editDetalle.razon){
            this.alerta = { activo: true, text:`Debes añadir la razon de la urgencia para el producto ${ this.editDetalle.codigo }.`, color:'error'};
            return;
          }
        }
        if( this.editDetalle.fecha < this.traerFechaActual()){
          this.alerta = { activo: true, text:`La fecha del producto ${this.editDetalle.codigo} no puede ser anterior a la actual.`, color:'error'};
          return;
        }

        this.editDetalle.listo = true;
        this.guardar_detalle_partida();
      },

      guardar_detalle_partida(){
        Object.assign(this.Detalle[this.editedIndex], this.editDetalle)
        this.detalleModal = false;
      }

    },
  }
</script>