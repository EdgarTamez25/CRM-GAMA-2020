<template>
    <v-row justify="center">
      <!-- <v-col v-if="Loading">
        <v-container style="height: 400px;" >
          <loading/>
        </v-container>
      </v-col> -->
      <v-col cols="12" align="center"> 
        <v-snackbar v-model="snackbar" multi-line :timeout="2000" top color="error"> {{text}}
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text @click="snackbar = false" v-bind="attrs"> Cerrar </v-btn>
          </template>
        </v-snackbar>

        <v-container style="height: 400px;" v-if="Loading">
          <loading/>
        </v-container>

        <v-form ref="form"  > 
          <v-row >
            <!-- <v-col cols="12"  >
              <v-select
                v-model="tproducto" :items="tproductos" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details label="Tipo de producto" return-object  :disabled="modoVista===2?true:false"
              ></v-select>
            </v-col> -->
            <v-card-text class="font-weight-black pa-1 headline" v-if="!Loading">{{ tipo_producto }}</v-card-text>
            <v-card-text class="font-weight-black pa-1 subtitle-1" v-if="!Loading">{{ titulo }}</v-card-text>
             
             <!-- //! REFERENCIA DEL PRODUCTO  -->
            <v-col cols="12" sm="6" v-if="!Loading">
              <v-text-field 
                v-model="referencia" hide-details dense label="REFERENCIA" 
                filled color="celeste" class=" font-weight-black" 
              />
            </v-col>
            <!-- //! CANTIDAD  -->
            <v-col cols="12" sm="6" v-if="!Loading">
              <v-text-field 
                v-model="cantidad" hide-details dense label="Cantidad" 
                filled color="celeste" placeholder="Cantidad de material"
              />
            </v-col>
             <!-- // ! SELETOR  MATERIALES  -->
            <v-col cols="12" sm="6"  v-if="ACTIVACAMPO">
              <v-select
                v-model="material" :items="materiales" item-text="nombre" item-value="id" outlined color="celeste"
                dense hide-details label="Materiales" return-object placeholder="Materiales"
              ></v-select> 
            </v-col>
             <!-- // ! SELETOR SOBRE QUE MATERIALES  -->
             <v-col cols="12" sm="6"   v-if="ACTIVACAMPO">
              <v-select
                v-model="material2" :items="materiales2" item-text="nombre" item-value="id" outlined color="celeste"
                dense hide-details label="Material Secundario" return-object placeholder="Material Secundario" 
              ></v-select> 
            </v-col>

            <v-col cols="12" sm="6">
              <v-row>
                 <!-- // !INPUT PARA PANTONE  -->
                <v-col cols="8"  align="center" class="my-0 py-0" v-if="ACTIVACAMPO">
                  <v-text-field 
                    v-model="pantone" label="Pantone " placeholder="Pantone" 
                    outlined dense hide-details  
                  ></v-text-field>
                </v-col>
                <!-- // !BOTON DE AGREGAR PANTONE  -->
                <v-col cols="2" class="text-right my-0 py-0" v-if="ACTIVACAMPO">
                  <v-btn  color="celeste" dark @click="agregarPantone()" > <v-icon>add</v-icon> </v-btn>
                </v-col>


                <!-- // !CHIPS DE PANTONES   -->
                <v-col cols="12" class="my-0 py-0 text-left" v-if="ACTIVACAMPO">
                  <v-chip v-for="(item, i) in pantones" :key="i"
                    class="ma-2" dark close :color="item" @click:close="eliminaPanton(i)">
                    {{ item }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-col>

             <!-- // !SELECTOR DE ACABADOS    -->
            <v-col cols="12" sm="6" v-if="ACTIVACAMPO">
              <v-select
                v-model="acabado" :items="acabados" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details label="Acabados" return-object multiple :menu-props="{ maxHeight: '400' }"
              ></v-select>
            </v-col>

            <!-- {{ acabado }} -->
             <!-- // ! ANCHO DE ETIQUETA   -->
            <v-col cols="6" sm="4"  v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="ancho" hide-details dense label="Ancho" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // ! LARGO DE ETIQUETA   -->
            <v-col cols="6" sm="4"  v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="largo" hide-details dense label="Largo" 
                outlined color="celeste" 
              />
            </v-col>
            <!-- // ! GROSOR   -->
            <v-col cols="12" sm="4"  v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="grosor" hide-details dense label="Grosor" 
                outlined color="celeste" 
              />
            </v-col>
            <!-- // ! ESTRUCTURA   -->
            <v-col cols="12" sm="8" v-if="ACTIVACAMPO" >
              <v-select
                v-model="estructura" :items="estructuras" item-text="nombre" item-value="id" outlined clearable
                dense hide-details label="Estructuras" return-object  color="celeste" 
              ></v-select>
            </v-col>

          </v-row>
        </v-form>
      </v-col>

      <v-col cols="12" class="my-3"/>

      <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
      <v-footer  absolute>
        <v-spacer></v-spacer>
        <v-btn color="error" outlined small  @click="$emit('modal',false)"  class="ma-1">Cancelar </v-btn>
        <!-- <v-btn color="success" small  @click="validaInformacion()">Guardar </v-btn> -->
      </v-footer>

      <v-dialog v-model="dialog" hide-overlay persistent width="300">
        <v-card color="blue darken-4" dark >
          <v-card-text> <th style="font-size:17px;" align="center">{{ textDialog }}</th>
            <br><v-progress-linear indeterminate color="white" class="mb-0" persistent></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>

      <v-dialog v-model="Correcto" hide-overlay persistent width="350">
        <v-card color="success"  dark class="pa-3">
          <h3><strong>{{ textCorrecto }} </strong></h3>
        </v-card>
      </v-dialog>
    </v-row>
  <!-- </v-main> -->
</template>

<script>
	import  metodos                 from '@/mixins/metodos.js';
	import {mapGetters, mapActions} from 'vuex';
  import ControlCompromisoVue     from '../Compromisos/ControlCompromiso.vue';
  import loading     from '@/components/loading.vue'
  
  export default {
    mixins:[metodos],
    components:{
      loading
    },
    props:[
			'modoVista',
      'parametros',
      'depto_id',
	  ],
    data: () => ({
      Loading        : true,
      titulo         : 'IMPRESIÓN DIGITAL',
      tipo_producto  : '',
      tproducto    : { id:1, nombre: 'Producto Existente'},
      tproductos   : [{ id:1, nombre:'Producto Existente'}, 
                      { id:2, nombre:'Modificación de producto'},
                      { id:3, nombre:'Nuevo Producto'}],
      cantidad     : '',
      material     : { id:null, nombre:''},
      materiales   : [],
      material2    : { id:null, nombre:''},
      materiales2  : [],
			referencia   : '',
      acabado      : [],
      acabados     : [],
      pantone      : '',
      pantones     : [],
      estructuras  : [],
      estructura   : { id:null, nombre:''},
      grosor       : '',
      motivo       : '',

      ancho         : '',
      largo         : '',
      // AVISOS
      snackbar      : false,
      text          : '',
      dialog        : false,
      textDialog    : "Guardando Información",
      color         :'error',
      Correcto      : false,
      textCorrecto  : '',
    }),

    created(){ 
      this.validarModoVista() ;
    },
    computed:{ 
      ...mapGetters('Solicitudes',['consecutivo']),  
      ACTIVACAMPO(){
        return this.tproducto.id === 1 ?  false: true ;
      }
    },
    watch:{ 
      depto_id(){  this.validarModoVista(); } ,
      parametros(){ this.validarModoVista(); } ,
    }, 

    methods:{
      ...mapActions('Solicitudes'  ,['agregaProducto','actualizaProducto']), // IMPORTANDO USO DE VUEX (ACCIONES)

      agregarPantone(){
        var esHexadecimal = false;
        if( esHexadecimal = this.esHexadecimal(this.pantone) ){
          this.pantones.push(this.pantone);
          this.pantone = '';
        }
      },

      esHexadecimal(pantone){ return /^#[0-9A-F]+$/i.test(pantone); },

      eliminaPanton(i){ this.pantones.splice(i,1); },

      validarModoVista(){ 
        this.consultaMateriales(this.depto_id);  // TRAER MATERIALES ASIGNADOS AL DEPARTAMENTO
        this.consultaAcabados(this.depto_id);    // TRAER ACABADOS ASIGNADOS AL DEPARTAMENTO
        this.consultaEstructuras();              // TRAER ESTRUCTURAS.

        this.$http.post('caracteristicas', this.parametros).then(response =>{
          this.tproducto    = { id: parseInt(this.parametros.tipo_prod) },
          this.tipo_producto = this.tproductos[parseInt(this.parametros.tipo_prod) - 1].nombre.toUpperCase();
          this.cantidad     = this.parametros.cantidad
          this.referencia   = this.parametros.ft;
          this.material     = { id: response.body.id_material  };
          this.material2    = { id: response.body.det_sobre    };
          this.ancho        = response.body.ancho;
          this.largo        = response.body.largo;
          this.estructura   = { id: response.body.estructura};
          this.grosor       = response.body.grosor;
          this.acabado      = response.body.acabados;
          this.pantones     = response.body.pantones.map( item =>{ return item.pantone});
        }).catch( error =>{
          console.log('error digital', error)
        }).finally(()=>{
          this.Loading = false;
        })

      },

      validaInformacion(){
        if(this.tproducto.id === 3) {
          if(!this.referencia)     { this.snackbar=true; this.text ="OLVIDASTE LA FICHA TECNICA"               ; return };
          if(!this.cantidad)       { this.snackbar=true; this.text ="OLVIDASTE LA CANTIDAD DEL MATERIAL"       ; return };
          if(!this.material.id)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL"            ; return };
          if(!this.material2.id)   { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL SECUNDARIO" ; return };
          if(!this.pantones.length){ this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN PANTONE"        ; return };
          if(!this.acabado.length) { this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN ACABADO"        ; return };
          if(!this.ancho)          { this.snackbar=true; this.text ="DEBES AGREGAR EL ANCHO"                   ; return };
          if(!this.largo)          { this.snackbar=true; this.text ="DEBES AGREGAR EL LARGO"                   ; return };
        }else if(this.tproducto.id === 1 || this.tproducto === 2){
          if(!this.referencia)     { this.snackbar=true; this.text ="OLVIDASTE LA FICHA TECNICA"               ; return };
          if(!this.cantidad)       { this.snackbar=true; this.text ="OLVIDASTE LA CANTIDAD DEL MATERIAL"       ; return };
        }
        this.PrepararPeticion();
      },

      PrepararPeticion(){
        let payload = {};
        if(this.tproducto.id === 1){ //! FORMO ARRAY SI ES PRODUCTO EXISTENTE
          payload = { id        : this.modoVista ===1 ? this.consecutivo: this.parametros.id,
                      dx        : 3,
                      referencia: this.referencia,
                      tproducto : this.tproducto.id,
                      cantidad  : this.cantidad
                    }
        }else if(this.tproducto.id === 2 || this.tproducto.id === 3){ //! FORMO ARRAY SI ES UNA MODIFICACION DE PRODUCTO
          payload ={  id             : this.modoVista === 1? this.consecutivo: this.parametros.id,
                      dx             : 3,
                      referencia     : this.referencia,
                      id_material    : this.material.id,
                      id_material2   : this.material2.id,
                      pantones       : this.pantones,
                      acabados       : this.acabado,
                      grosor         : this.grosor,
                      ancho          : this.ancho,
                      largo          : this.largo,
                      estructura     : this.estructura.id,
                      tproducto      : this.tproducto.id,
                      cantidad       : this.cantidad,
                      xmodificar     : this.tproducto.id === 2? this.objetoxModificar(): ''
                    }
        }
        
        // VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
      },

      Crear(payload){
        this.dialog = true ; 
        this.agregaProducto(payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se agrego a la lista"); }
        }).finally(()=>{ 
          this.dialog = false
        })
      },

      Actualizar(payload){
        this.dialog = true ;
        this.actualizaProducto(payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se modifico correctamente"); }
        }).finally(()=>{ 
          this.dialog = false
        })
      },

			TerminarProceso(mensaje){
        var me = this ;
        this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
        setTimeout(function(){ me.$emit('modal',false)}, 2000);
        this.limpiarCampos();  //LIMPIAR FORMULARIO
      },

      limpiarCampos(){
        this.referencia   = '';
        this.material     = { id:null, nombre:''};
        this.material2    = { id:null, nombre:''};
        this.estructura   = { id:null, nombre:''};
        this.tproducto    = { id:1};
        this.cantidad     = '';
        this.pantone      = '';
        this.pantones     = []
        this.acabado      = [];
        this.ancho        = '';
        this.largo        = '';
        this.grosor       = ''
      },

      objetoxModificar(){
        let payload = {  id: this.modoVista ===1 ? this.consecutivo: this.parametros.id,
                        dx: 3,
                        referencia     : this.referencia,
                        tproducto      : this.tproducto.id,
                        xmodificar     : this.agregaConceptos(),
                      }
        return payload;
      },

      agregaConceptos(){
        let arrayTemp = [];

        this.material.id     ? arrayTemp.push( { tipo:1 ,concepto:'id_material'   , valor: this.material.id    }): '';  
        this.material2.id    ? arrayTemp.push( { tipo:1 ,concepto:'id_material2'  , valor: this.material2.id   }): ''; 
        this.pantones.length ? arrayTemp.push( { tipo:2 ,concepto:'pantones'      , valor: this.pantones       }): ''; 
        this.acabado.length  ? arrayTemp.push( { tipo:2 ,concepto:'acabados'      , valor: this.acabado        }): '';
        this.grosor          ? arrayTemp.push( { tipo:1 ,concepto:'grosor'        , valor: this.grosor         }): ''; 
        this.ancho           ? arrayTemp.push( { tipo:1 ,concepto:'ancho'         , valor: this.ancho          }): ''; 
        this.largo           ? arrayTemp.push( { tipo:1 ,concepto:'largo'         , valor: this.largo          }): ''; 
        this.estructura.id   ? arrayTemp.push( { tipo:1 ,concepto:'estructura'    , valor: this.estructura.id  }): '';

        return arrayTemp;
      }

    }
  }
</script>
