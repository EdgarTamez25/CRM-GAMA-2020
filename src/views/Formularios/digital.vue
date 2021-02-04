<template>
    <v-row justify="center">
      <!-- OVERLAY -->
      <overlay v-if="overlay"/>
      <!-- LOADING -->
      <v-container style="height: 400px;" v-if="Loading">
        <loading/>
      </v-container>


      <v-col cols="12" align="center"> 
        <v-snackbar v-model="snackbar" multi-line :timeout="2000" top :color="color" class="font-weight-black subtitle-1"> {{text}}
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text @click="snackbar = false" v-bind="attrs"> Cerrar </v-btn>
          </template>
        </v-snackbar>

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
            
            <v-col cols="12" v-if=" !Loading && Vista === 'PRODUCTOS' && getDatosDigital != null">
             <v-btn color="rosa" dark block small @click="pegarInfo()"> PEGAR INFORMACIÓN </v-btn> 
            </v-col>

            <v-col cols="12" v-if=" !Loading && Vista === 'SOLICITUDES'">
             <v-btn color="rosa" dark block small @click="copiarInfo()"> COPIAR INFORMACIÓN </v-btn> 
            </v-col>

             <!-- //! REFERENCIA DEL PRODUCTO  -->
            <v-col cols="12" sm="6" v-if="!Loading && modoVista === 2">
              <v-text-field 
                v-model="referencia" hide-details dense label="REFERENCIA" 
                filled color="celeste" class=" font-weight-black" 
              />
            </v-col>
            <!-- //! CANTIDAD  -->
            <v-col cols="12" sm="6" v-if="!Loading && modoVista === 2">
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

      <v-col cols="12" class="my-3"  v-if="!Loading && modoVista === 2"/>
      <v-col cols="12" class="text-right" v-if="modoVista===1 || modoVista === 3">
        <v-btn color="celeste" outlined small @click="validaEmit()" >
          {{ modoVista === 1? "Agregar Caracteristicas": "Agregar Modificaciones" }}
        </v-btn>
      </v-col>

      <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
      <v-footer  absolute v-if="!Loading && modoVista === 2">
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
    </v-row>
  <!-- </v-main> -->
</template>

<script>
	import  metodos                 from '@/mixins/metodos.js';
	import {mapGetters, mapActions} from 'vuex';
  import ControlCompromisoVue     from '../Compromisos/ControlCompromiso.vue';
  import loading     from '@/components/loading.vue'
  import overlay     from '@/components/overlay.vue'

  
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
      'modalDDD',
      'actualiza',
      'Vista'
	  ],
    data: () => ({
      Loading        : true,
      titulo         : 'IMPRESIÓN DIGITAL',
      tipo_producto  : '',
      tproducto    : { id:1, nombre: 'Producto Existente'},
      tproductos   : [{ id:1, nombre:'Producto Existente'}, 
                      { id:2, nombre:'Modificación de producto'},
                      { id:3, nombre:'Nuevo Producto'}],
      id_producto  : null,
      cantidad     : '',
      material     : { id:null, nombre:''},
      materiales   : [],
      material2    : { id:null, nombre:''},
      materiales2  : [],
			referencia   : '',
      acabado      : [],
      acabados     : [],
      acabadosAEliminar:[],
      pantonesAEliminar :[],
      pantone      : '',
      pantones     : [],
      estructuras  : [],
      estructura   : { id:null, nombre:''},
      grosor       : '',
      motivo       : '',

      ancho         : '',
      largo         : '',
      // AVISOS
      snackbar     : false,
      text         : '',
      color        : 'green',
      Correcto     : false,
      colorCorrecto : 'green',
      textCorrecto : 'La información se guardo correctamente',
      overlay      : false,

      modo: 0,
      realizadoFinalizado: false,
    }),

    created(){ 
      this.validarModoVista() ;
    },
    computed:{ 
      ...mapGetters('Solicitudes',['consecutivo', 'getDatosDigital']),  
			...mapGetters('Login' ,['getLogeado','getdatosUsuario']), 

      ACTIVACAMPO(){
        return this.tproducto.id === 1 ?  false: true ;
      }
    },
    watch:{ 
      depto_id(){  this.validarModoVista(); } ,
      parametros(){ this.validarModoVista(); } ,
    }, 

    methods:{
      ...mapActions('Solicitudes'  ,['agregaProducto','actualizaProducto','copiarInfoDeSolicitud']), // IMPORTANDO USO DE VUEX (ACCIONES)

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
       
        if(this.modoVista === 2){

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
        } 

        if(this.modoVista === 3){
          this.$http.post('caracteristicas', this.parametros).then(response =>{
            this.id_producto  = response.body.id;
            this.tproducto    = { id: 2 } // solo se pone para que se habilite el formulario
            this.material     = { id: response.body.id_material  };
            this.material2    = { id: response.body.det_sobre};
            this.ancho        = response.body.ancho;
            this.largo        = response.body.largo;
            this.estructura   = { id: parseInt(response.body.estructura)};
            this.grosor       = response.body.grosor;
            this.acabado      = response.body.acabados;
            this.pantonesAEliminar = response.body.pantones;
            this.acabadosAEliminar = response.body.acabados;
            this.pantones     = response.body.pantones.map( item =>{ return item.pantone});
          }).catch( error =>{
            console.log('error digital', error)
          }).finally(()=>{
            this.Loading = false;
          })
        }
        
        if(this.modoVista === 1 ){ this.limpiarCampos(); }
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

      // SOLO SE USA PARA LA CREACION Y ACTUALIZACION DE LOS PRODUCTOS
      validaEmit(){
        if(!this.material.id)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL"            ; return };
        if(!this.material2.id)   { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL SECUNDARIO" ; return };
        if(!this.acabado.length) { this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN ACABADO"      ; return };
        if(!this.ancho)          { this.snackbar=true; this.text ="DEBES AGREGAR EL ANCHO"                 ; return };
        if(!this.largo)          { this.snackbar=true; this.text ="DEBES AGREGAR EL LARGO"                 ; return };
        if(!this.pantones.length){ this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN PANTONE"      ; return };

        const detalle = new Object();
        detalle.id             = this.id_producto;
        detalle.id_material    = this.material.id;
        detalle.id_material2   = this.material2.id;
        detalle.acabados       = this.acabado;
        detalle.acabadosAEliminar = this.acabadosAEliminar;
        detalle.pantonesAEliminar = this.pantonesAEliminar;
        detalle.pantones       = this.pantones;
        detalle.ancho          = this.ancho;
        detalle.largo          = this.largo;
        detalle.estructura     = this.estructura.id ? this.estructura.id: '';
        detalle.grosor         = this.grosor ? this.grosor : '';
        detalle.dx             = 3;

        this.snackbar = true; this.text ="Las caracteristicas se guardaron correctamente"; this.color ="green";
        this.$emit('detalle',detalle); // EMITIR DETALLE A CONTROL PRODUCTOS

      },

      PrepararPeticion(){
        this.overlay = true; let payload = {};
        if(this.tproducto.id === 1){ //! FORMO ARRAY SI ES PRODUCTO EXISTENTE
          payload = { id        : this.modoVista ===1 ? this.consecutivo: this.parametros.id,
                      dx        : 3,
                      referencia: this.referencia,
                      tproducto : this.tproducto.id,
                      cantidad  : this.cantidad,
                      id_dx     : this.modoVista === 2? this.parametros.id_dx: '' 

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
                      xmodificar     : this.tproducto.id === 2? this.objetoxModificar(): '',
                      id_dx     : this.modoVista === 2? this.parametros.id_dx: '' 

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
        this.actualizaProducto( payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se modifico correctamente"); }
        }).catch( error =>{
          console.log('putprod',error)
        }).finally(()=>{ 
          this.overlay = false
        })
      },

			TerminarProceso(mensaje){
         var me = this ;
        this.Correcto = true ; this.textCorrecto = mensaje;
        setTimeout(function(){ me.Correcto = false }, 2000);
         // setTimeout(function(){ me.$emit('modal',false)}, 2000);
        // this.limpiarCampos();  //LIMPIAR FORMULARIO
      },

      limpiarCampos(){
        this.referencia   = '';
        this.material     = { id:null, nombre:''};
        this.material2    = { id:null, nombre:''};
        this.estructura   = { id:null, nombre:''};
        this.tproducto    =  this.modoVista != 1 ? { id:1 }: { id:2};
        this.cantidad     = '';
        this.pantone      = '';
        this.pantones     = []
        this.acabado      = [];
        this.ancho        = '';
        this.largo        = '';
        this.grosor       = '';
        this.Loading = false;
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

      copiarInfo(){
        const payload = new Object();
              payload.material       = this.material;
              payload.material2      = this.material2;
              payload.ancho          = this.ancho;
              payload.largo          = this.largo;
              payload.estructura     = this.estructura;
              payload.grosor         = this.grosor;
              payload.acabados       = this.acabado;
              payload.pantones       = this.pantones;
              payload.dx             = 3

        this.copiarInfoDeSolicitud(payload);
        this.snackbar = true; this.text = "La información se copio correctamente."; this.color ="green";
      },

      pegarInfo(){
        this.material       =  this.getDatosDigital.material
        this.material2      =  this.getDatosDigital.material2
        this.ancho          =  this.getDatosDigital.ancho
        this.largo          =  this.getDatosDigital.largo
        this.estructura     =  this.getDatosDigital.estructura;
        this.grosor         =  this.getDatosDigital.grosor;
        this.acabado        =  this.getDatosDigital.acabados;
        this.pantones       = this.getDatosDigital.pantones; 
        this.snackbar = true; this.text = "La información se ha pegado correctamente."; this.color ="green";
      }
    }
  }
</script>
