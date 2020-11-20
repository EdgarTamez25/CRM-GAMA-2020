<template>
  <v-row>
    <v-col v-if="!Loading">
      <v-snackbar v-model="snackbar" multi-line top right color="error"> {{ text }}
        <template v-slot:action="{ attrs }">
          <v-btn dark text v-bind="attrs" @click="snackbar = false"> Cerrar</v-btn>
        </template>
      </v-snackbar>

      <v-card-actions >
        <div class="font-weight-black subtitle-1 py-0" v-for="(item, i) in deptos" :key="i">
          <span v-if="parametros.dx === item.id"> {{ item.nombre }}</span>
        </div>
        <v-spacer></v-spacer>
        <div class="font-weight-black py-0 rosa--text">
           {{ parametros.ft }}
        </div>
      </v-card-actions>
      <v-divider></v-divider>
      <v-simple-table  >
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left  black--text"> CARACTERISTICA </th>
              <th class="text-left  black--text"> CONCEPTO </th>
              <th class="text-left  black--text"> ACCION </th>
              <th class="text-left  black--text"> REMPLAZO </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,i) in getModificaciones" :key="i" v>
              <td class="font-weight-black">{{ item.concepto }}</td>

              <td class="font-weight-black"  > 
                <div v-if="parametros.dx === 1">
                  <img :src="item.valor" width="80px" v-if="item.concepto ==='Orientacion'" /> 
                  <v-btn :color="item.valor" dark small rounded v-if="item.concepto ==='Pantone'">{{ item.valor }}</v-btn>
                  <div v-if="item.concepto != 'Orientacion' && item.concepto != 'Pantone'">  {{ item.valor }} </div>
                </div>

                <div v-if="parametros.dx ===3">
                  <v-btn :color="item.valor" dark small rounded v-if="item.concepto ==='Pantone'">{{ item.valor }}</v-btn>
                  <div v-else>  {{ item.valor }} </div>
                </div>
              </td>

              <td  width="150px">
                 <v-select
                  v-model="item.accion" :items="acciones" item-text="nombre" item-value="id"  
                  dense hide-details  placeholder="Acciones" return-object 
                ></v-select> 
              </td>

              <td 
                v-if="item.accion && item.concepto === 'Orientacion' ||
                      item.accion && item.concepto === 'Material'    ||
                      item.accion && item.concepto === 'Acabado'     ||
                      item.accion && item.concepto === 'Material Secundario' "
              >
                
                <div v-if="item.concepto === 'Orientacion'">
                  <v-btn color="error" text small  
                         @click="muestraOrientacion(item)" 
                         :disabled="item.accion.id != 1? true: false"
                         v-if="!item.valor2">Agregar Orientación 
                  </v-btn>
                  <v-img height="80px" contain :src="item.valor2.img" @click="muestraOrientacion(item)" v-else ></v-img> 
                </div>

                <div v-if="item.concepto === 'Material'" class="mt-2" >
                  <v-select
                    v-model="item.valor2" :items="materiales" item-text="nombre" item-value="id"  
                    dense hide-details  label="Material" return-object 
                    :disabled="item.accion.id != 1? true: false"
                  ></v-select> 
                </div>

                <div v-if="item.concepto === 'Acabado'" class="mt-2">
                  <v-select
                    v-model="item.valor2" :items="acabados" item-text="nombre" item-value="id"  
                    dense hide-details  label="Acabado" return-object 
                    :disabled="item.accion.id != 1? true: false"
                  ></v-select> 
                </div>

                <div v-if="item.concepto === 'Material Secundario'" class="mt-2">
                  <v-select
                    v-model="item.valor2" :items="materiales2" item-text="nombre" item-value="id"  
                    dense hide-details  label="Material Secundario" return-object 
                    :disabled="item.accion.id != 1? true: false"
                  ></v-select> 
                </div>
              </td>

              <td v-else>
                <div v-if="item.accion" class="mt-2">
                  <v-textarea
                    v-model="item.valor2" label="Remplazar por..." rows="1" :disabled="item.accion.id != 1? true: false"
                  ></v-textarea>
                </div>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>

      <div class="mt-12" ></div>
      <v-footer absolute class="pa-3" >
        <v-btn color="error" outlined small @click="$emit('modal',false)" >Cancelar </v-btn>
        <v-spacer></v-spacer>
        <v-btn color="green" dark small   @click="FormaArrayActualizar()"  >Guardar Información </v-btn>
      </v-footer>

      <!-- MODAL PARA MOSTRAR ORIENTACIONES -->
      <v-bottom-sheet v-model="sheet" persistent hide-overlay >
        <v-sheet class="text-center" height="auto">
          <v-btn class="mt-6" text color="error" @click="sheet = !sheet" > Cerrar </v-btn>
          <v-row justify="center" class="pa-1">
            <v-col cols="3" sm="3" lg="1" v-for="(items,i) in orientaciones" :key="i" class=" my-0 py-1" >
              <v-card   outlined @click="evaluaCheck(items)">
                <v-img height="100px" contain :src="items.img" ></v-img>
                <v-checkbox 
                  v-model="items.activo"
                  color="celeste" 
                  hide-details 
                  class="my-0 py-0"
                ></v-checkbox>
              </v-card>
            </v-col>
            <v-col cols="12" class="text-right">
            </v-col>
          </v-row>
        </v-sheet>
      </v-bottom-sheet>

      <v-dialog v-model="Correcto" hide-overlay persistent width="350">
        <v-card :color="colorCorrecto" dark class="pa-3">
          <v-card-text class="font-weight-black headline pa-3 white--text" align="center">
            {{ textCorrecto }}
          </v-card-text>
          <!-- <h3><strong>{{ textCorrecto }} </strong></h3> -->
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
      'depto_id',
      'actualiza'
	  ],
    data:()=> ({
      id_seleccionado: 0,
      sheet: false,

      Loading: true,
      deptos: [],
      material     : { id:null, nombre:''},
      materiales   : [],
      materiales2  : [],
      acabado      : [],
      acabados     : [],
      acciones     : [{ id:1, nombre:'Remplazar'},{ id:2, nombre:'Agregar'},{ id:3, nombre:'Eliminar'}],
      checkActivo  : 0,
      orientaciones: [],
      flexo:[ { id:1 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/1.svg' },
                    { id:2 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/2.svg' },
                    { id:3 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/3.svg' },
                    { id:4 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/4.svg' },
                    { id:5 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/5.svg' },
                    { id:6 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/6.svg' },
                    { id:7 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/7.svg' },
                    { id:8 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/8.svg' },
                  ],
      snackbar     : false,
      text         : '',
      Correcto     : false,
      colorCorrecto : '',
      textCorrecto : 'La información se guardo correctamente',
      overlay      : false,

    }),  
    computed:{
      ...mapGetters('Solicitudes'  ,['getModificaciones']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)

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
      ...mapActions('Solicitudes'  ,['consultaModificaciones','actualizaModificaciones']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
      
      init(){
        this.Loading = true;

        this.consultaDepartamentos()
        this.consultaMateriales(this.depto_id).then( response1 =>{
          this.consultaAcabados(this.depto_id).then( response3 =>{
            this.consultaModificaciones(this.parametros.id).then(response =>{
              for(let i=0; i<this.getModificaciones.length; i++){
                if(this.getModificaciones[i].concepto === 'Material'){
                  var pos = i;
                  for(let x=0;x<this.materiales.length; x++){
                    if(this.materiales[x].id === parseInt(this.getModificaciones[pos].valor)){
                      this.getModificaciones[pos].valor  = this.materiales[x].nombre
                    }
                  }
                }

                if(this.getModificaciones[i].concepto === 'Material Secundario'){
                  var pos2 = i;
                  for(let y=0;y<this.materiales2.length; y++){
                    if(this.materiales2[y].id === parseInt(this.getModificaciones[pos2].valor)){
                      this.getModificaciones[pos2].valor  = this.materiales2[y].nombre
                    }
                  }  
                }

                if(this.getModificaciones[i].concepto === 'Acabado'){
                  for(let z=0;z<this.acabados.length; z++){
                    if(this.acabados[z].id === parseInt(this.getModificaciones[i].valor)){
                      this.getModificaciones[i].valor  = this.acabados[z].nombre
                    }
                  }
                }
                if(this.getModificaciones[i].concepto === 'Orientacion' ){
                  this.getModificaciones[i].valor =  this.flexo[parseInt(this.getModificaciones[i].valor)-1].img;
                }
              
              }
            }).catch(error =>{
              console.log('error modif', error)
            }).finally( ()=> this.Loading = false )
          });
        });
      },

      muestraOrientacion(item){ //! BUSCO LA ORIENTACION SELECCIONADA
        this.id_seleccionado = item.id
        this.orientaciones = this.flexo;
        this.sheet = true;
      },

      evaluaCheck(items){
        for(let i=0; i< this.orientaciones.length;i++){ // !SI NO ES EL CHECK QUE SELECCIONO LO DEVUELVO A FALSO. 
          items.id != this.orientaciones[i].id? this.orientaciones[i].activo=false: this.orientaciones[i].activo=true;
        }
        for(let j=0; j<this.getModificaciones.length;j++){
          if(this.getModificaciones[j].id === this.id_seleccionado){
            this.getModificaciones[j].valor2 = items
          }
        }
        this.checkActivo = items.id; //! GUARDO EL CHECK-ACTIVO 
      },

      FormaArrayActualizar(){
        this.overlay= true; let arrayTemp = [];
        for(let i=0; i<this.getModificaciones.length;i++){
          if(this.getModificaciones[i].accion){
            if(this.getModificaciones[i].accion.id === 1){
              arrayTemp.push({ id: this.getModificaciones[i].id,
                                accion: this.getModificaciones[i].accion.id,
                                valor2: typeof this.getModificaciones[i].valor2 === 'object' ? 
                                        this.getModificaciones[i].valor2.id:this.getModificaciones[i].valor2 
                              });
            }else{
              arrayTemp.push({  id: this.getModificaciones[i].id,
                                accion: this.getModificaciones[i].accion.id,
                                valor2: '',
                              });
            }
          }
        } 
        console.log('arrayTemp', arrayTemp)
        this.actualizaModif(arrayTemp)

      },

      actualizaModif(data){
        console.log('data', data)
        console.log('tipo dato', typeof data);
        const payload = { data }

        this.$http.post('actualiza.modif', payload).then(response =>{
          this.overlay  = false; this.colorCorrecto = 'green';
          this.Correcto = true; this.textCorrecto = response.bodyText;
          this.Terminar(200)
        }).catch( error =>{
          this.overlay = false; this.colorCorrecto = 'error';
          this.Correcto = true; this.textCorrecto = error.bodyText
          this.Terminar(500)
        })
      },

      Terminar(status){
        var me = this;
        status === 200? setTimeout(function(){ me.$emit('modal',false); me.$emit('put', !this.actualiza)}, 1500):
                        setTimeout(function(){ me.Correcto = false    }, 1500)
        
      }
      
    }
  }
</script>