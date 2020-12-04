<template>
  <v-row>
    <v-col v-if="!Loading">
      <v-snackbar v-model="snackbar" multi-line top right color="error" class="font-weight-black subtitle-1"> {{ text }}
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
                      item.accion && item.concepto === 'Material Secundario' ||
                      item.accion && item.concepto === 'Estructura'"
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

                <div v-if="item.concepto === 'Estructura'" class="mt-2">
                  <v-select
                     v-model="item.valor2" :items="estructuras" item-text="nombre" item-value="id"  
                    dense hide-details label="Estructuras" return-object  
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
        <v-btn color="rosa"    class="mx-1" dark small @click="realizadoFinalizado = true, modo= 1" 
                v-if="modalDDD && parametros.estatus_key === 1"> Realizado 
        </v-btn>
        <v-btn color="celeste" class="mx-1" dark small @click="realizadoFinalizado = true, modo= 2" 
               v-if="modalDDD && parametros.estatus_key !=3"> Finalizar 
        </v-btn>
        <v-btn color="success" small  @click="validaInformacion()" v-if="!modalDDD">Guardar información </v-btn>
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
      'depto_id',
      'actualiza',
      'modalDDD'
	  ],
    data:()=> ({
      id_seleccionado: 0,
      sheet: false,
      Loading: true,
      deptos: [],
      material     : { id:null, nombre:''},
      materiales   : [],
      materiales2  : [],
      estructuras   :[],
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

      modo: 0,
      realizadoFinalizado: false,

    }),  
    computed:{
      ...mapGetters('Solicitudes'  ,['getModificaciones']), // IMPORTANDO USO DE VUEX  (GETTERS)
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
      ...mapActions('Solicitudes'  ,['consultaModificaciones','actualizaModificaciones','consultaDetalle']), // IMPORTANDO USO DE VUEX - 
      
      init(){
        this.Loading = true;

        this.consultaDepartamentos();  //! CONSULTA DEPARTAMENTOS
        this.consultaEstructuras();
        this.consultaMateriales(this.depto_id).then( response1 =>{ //!CONSULTA MATERIALES
          this.consultaAcabados(this.depto_id).then( response3 =>{ //!CONSULTA ACABADOS
            this.consultaModificaciones(this.parametros.id).then(response =>{ //! CONSULTA LAS MODIFICACIONES QUE SE CARGARON
              //! SE GENERA UN CICLO PARA ASIGNAR VALOR A MOSTAR DE LOS VALORES QUE RECIBO COMO "id"; 
              //! MODIFICO EL REGISTRO EN LA POSICION "i" QUE VAYA ENCONTRANDO SEGUN LAS CONDICIONES
              for(let i=0; i<this.getModificaciones.length; i++){ 
               
                if(this.getModificaciones[i].concepto === 'Material'){
                  var pos = i;
                  for(let x=0;x<this.materiales.length; x++){
                    if(this.materiales[x].id === parseInt(this.getModificaciones[pos].valor)){
                      this.getModificaciones[pos].valor  = this.materiales[x].nombre
                    }
                    if(this.materiales[x].id === parseInt(this.getModificaciones[pos].valor2)){
                      this.getModificaciones[pos].valor2 = { id: this.materiales[x].id }
                    }
                  }
                }
                if(this.getModificaciones[i].concepto === 'Material Secundario'){ 
                  var pos2 = i;
                  for(let y=0;y<this.materiales2.length; y++){
                    if(this.materiales2[y].id === parseInt(this.getModificaciones[pos2].valor)){
                      this.getModificaciones[pos2].valor  = this.materiales2[y].nombre
                    }
                    if(this.materiales2[y].id === parseInt(this.getModificaciones[pos2].valor2)){
                      this.getModificaciones[pos2].valor2 = { id: this.materiales2[y].id }
                    }
                  }  
                }
                if(this.getModificaciones[i].concepto === 'Acabado'){
                  for(let z=0;z<this.acabados.length; z++){
                    if(this.acabados[z].id === parseInt(this.getModificaciones[i].valor)){
                      this.getModificaciones[i].valor  = this.acabados[z].nombre
                    }
                    if(this.acabados[z].id === parseInt(this.getModificaciones[i].valor2)){
                      this.getModificaciones[i].valor2 = { id: this.acabados[z].id }
                    }
                  }
                }

                if(this.getModificaciones[i].concepto === 'Estructura'){
                   for(let w=0;w<this.estructuras.length; w++){
                    if(this.estructuras[w].id === parseInt(this.getModificaciones[i].valor)){
                      this.getModificaciones[i].valor  = this.estructuras[w].nombre
                    }
                    if(this.estructuras[w].id === parseInt(this.getModificaciones[i].valor2)){
                      this.getModificaciones[i].valor2 = { id: this.estructuras[w].id }
                    }
                  }
                }

                if(this.getModificaciones[i].concepto === 'Orientacion' ){
                  this.getModificaciones[i].valor  =  this.flexo[parseInt(this.getModificaciones[i].valor)-1].img;
                  if(this.getModificaciones[i].valor2){
                    this.getModificaciones[i].valor2 =  { id: parseInt(this.getModificaciones[i].valor2),
                                                      img: this.flexo[parseInt(this.getModificaciones[i].valor2)-1].img
                                                    };
                  }
                }

                if(this.getModificaciones[i].accion === 1 || this.getModificaciones[i].accion === 2 || this.getModificaciones[i].accion === 3 ){
                  this.getModificaciones[i].accion = this.acciones[this.getModificaciones[i].accion-1]
                }
                
              }
            }).catch(error =>{
              // console.log('error modif', error)
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

      validaInformacion(){
        this.overlay= true; let errores1 = 0, errores2 = 0;
        for(let x=0; x<this.getModificaciones.length;x++){
          if(this.getModificaciones[x].accion){         // VALIDAR SI ACCION ESTA SELECCIONADA
            if(this.getModificaciones[x].accion.id === 1){ // VALIDAR SI ACCION ES IGUAL A 1
              // console.log('valor2', this.getModificaciones[x].valor2)
              if(this.getModificaciones[x].valor2 === null){     // VALIDAR SI EL VALOR 2 ESTA LLENO
                errores2 ++;
              }
            }
          }else{  // SI ACCION NO ESTA SELECCIONADA ENTONCES AUMENTO ERRORES
            errores1 ++;
          }
        }
        if(errores1>0){ this.snackbar=true; this.text="Debes seleccionar una acción " ;this.overlay=false; return }
        if(errores2>0){ this.snackbar=true; this.text="Olvidaste indicar el remplazo ";this.overlay=false; return }

        this.FormaArrayActualizar()
      },

      FormaArrayActualizar(){
        let arrayTemp = [];
        for(let i=0; i<this.getModificaciones.length;i++){
          if(this.getModificaciones[i].accion.id === 1){

            arrayTemp.push({ id: this.getModificaciones[i].id,
                              accion: this.getModificaciones[i].accion.id,
                              valor2: typeof this.getModificaciones[i].valor2 === 'object' ? 
                                      this.getModificaciones[i].valor2.id:this.getModificaciones[i].valor2 
                            });

          }else{
            arrayTemp.push({  id: this.getModificaciones[i].id,
                              accion: this.getModificaciones[i].accion.id,
                              valor2: ''
                            });
          }
        } 
        // console.log('arrayTemp', arrayTemp)
        this.actualizaModif(arrayTemp)

      },

      actualizaModif(data){
        const payload = { id: this.parametros.id, estatus: 1, data }
        // console.log('payload', payload)
        this.$http.post('actualiza.modif', payload).then(response =>{
          this.overlay  = false; this.colorCorrecto = 'green';
          this.Correcto = true; this.textCorrecto = response.bodyText;
          this.consultaDetalle(this.parametros.id_solicitud)
          this.Terminar(200)
        }).catch( error =>{
          this.overlay = false; this.colorCorrecto = 'error';
          this.Correcto = true; this.textCorrecto = error.bodyText
          this.Terminar(500)
        })
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