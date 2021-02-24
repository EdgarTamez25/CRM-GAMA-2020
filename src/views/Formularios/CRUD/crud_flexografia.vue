<template>
  <!-- <v-main class="pa-0"> -->
    <v-row justify="center">
      <v-col cols="12" align="center"> 
        <v-snackbar v-model="snackbar" multi-line :timeout="2000" top color="error"> {{text}}
          <template v-slot:action="{ attrs }">
            <v-btn color="white" text @click="snackbar = false" v-bind="attrs"> Cerrar </v-btn>
          </template>
        </v-snackbar>

        <v-form ref="form" > 
          <v-row >
            <v-col cols="12" class="my-0 py-0" >
              <v-select
                v-model="tproducto" :items="tproductos" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details label="Tipo de producto" return-object :disabled="modoVista===2 || modoVista=== 4?true:false"
              ></v-select>
            </v-col>
            <!-- //! TITULO - CARACTERISTICAS -->
            <v-card-text class="font-weight-black mt-2 py-0 text-body-1">{{ titulo }} </v-card-text>
             
            <!-- //! REFERENCIA DEL PRODUCTO  -->
            <v-col cols="12" sm="6">
              <v-text-field 
                v-model="referencia" hide-details dense label="Código de Parte" 
                filled color="celeste" class=" font-weight-black" 
              />
            </v-col>
            <!-- //! CANTIDAD  -->
            <v-col cols="12" sm="6" >
              <v-text-field 
                v-model="cantidad" hide-details dense label="Cantidad" 
                filled color="celeste" placeholder="Cantidad de material"
              />
            </v-col>
             <!-- // !SELETOR DE MATERIALES  -->
            <v-col cols="12" sm="6" class="text-right my-0 py-1" v-if="ACTIVACAMPO">
              <v-autocomplete
                :items="materiales" v-model="material" item-text="nombre" item-value="id" label="Materiales" 
                dense outlined hide-details return-object color="celeste" 
              ></v-autocomplete>
            </v-col>

             <!-- // !INPUT PARA PANTONE  -->
            <v-col cols="9" sm="4" class="text-right my-0 py-1"  v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="pantone" label="Pantone " placeholder="Pantone" 
                outlined dense hide-details  
              ></v-text-field>
            </v-col>
             <!-- // !BOTON DE AGREGAR PANTONE  -->
            <v-col cols="3" sm="2" class="text-right my-0 py-1"  v-if="ACTIVACAMPO">
              <v-btn color="celeste" dark @click="agregarPantone()" > <v-icon>add</v-icon> </v-btn>
            </v-col>
             <!-- // !CHIPS DE PANTONES   -->
            <v-col cols="12" class="my-0 py-0 text-left" >
              <v-chip v-for="(item, i) in pantones" :key="i"
                class="ma-2" close color="rosa" outlined dark  @click:close="eliminaPanton(i)">
                {{ item }}
              </v-chip>
            </v-col>
             <!-- // !SELECTOR DE ACABADOS    -->
            <v-col cols="12" sm="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-select
                v-model="acabado" :items="acabados" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details label="Acabados" return-object multiple :menu-props="{ maxHeight: '400' }"
              ></v-select>
            </v-col>
            <v-card-text class="font-weight-black pa-1" v-if="ACTIVACAMPO">PRESENTACIÓN</v-card-text>

             <!-- // !ETIQUETA POR ROLLO    -->
            <v-col cols="12" sm="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="etqxrollo" hide-details dense label="Etiqueta por rollo" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !MEDIDA DE NUCLEO   -->
            <v-col cols="12" sm="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="med_nucleo" hide-details dense label="Medida del Nucleo" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !ETIQUETA POR PASO   -->
            <v-col cols="12" sm="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="etqxpaso" hide-details dense label="Etiqueta al paso" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !MEDIDA DE DESARROLLO   -->
            <v-col cols="12" sm="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="med_desarrollo" hide-details dense label="Medida de desarrollo" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !MEDIDA DE EJE   -->
            <v-col cols="12" sm="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="med_eje" hide-details dense label="Medida de eje" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // ! ANCHO DE ETIQUETA   -->
            <v-col cols="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="ancho" hide-details dense label="Ancho" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // ! LARGO DE ETIQUETA   -->
            <v-col cols="6" md="4" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="largo" hide-details dense label="Largo" 
                outlined color="celeste" 
              />
            </v-col>
          </v-row>
        </v-form>
      </v-col>
      <!-- // !CICLO PARA MOSTRAR IMAGENES DE ORIENTACION     -->
      <v-col cols="4" sm="3"  v-for="(item,i) in orientacion" :key="i" class=" my-0 py-1" v-if="ACTIVACAMPO">
        <v-card   outlined @click="evaluaCheck(item.id)">
          <v-img height="100px" contain :src="item.img" ></v-img>
          <v-checkbox 
            v-model="item.activo"
            color="celeste" 
            hide-details 
            class="my-0 py-0"
          ></v-checkbox>
        </v-card>
      </v-col>

      <v-col cols="12" class="my-3"/>

      <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
      <v-footer  absolute>
        <v-spacer></v-spacer>
        <v-btn color="error" outlined @click="$emit('modal',false)"  class="ma-1">Cancelar </v-btn>
        <v-btn color="success"   @click="validaInformacion()">Guardar </v-btn>
      </v-footer>

		  <overlay v-if="overlay"/>

      <v-dialog v-model="Correcto" hide-overlay persistent width="350">
        <v-card color="success"  dark class="pa-3">
          <h3><strong>{{ textCorrecto }} </strong></h3>
        </v-card>
      </v-dialog>
    </v-row>
  <!-- </v-main> -->
</template>

<script>
	import  metodos from '@/mixins/metodos.js';
	import {mapGetters, mapActions} from 'vuex';
	import overlay     from '@/components/overlay.vue'
  
  export default {
    mixins:[metodos],
    props:[
			'modoVista',
      'parametros',
      'solicitud',
      'depto_id',
    ],
    components: {
			overlay,
		},
    data: () => ({
      titulo         : 'CARACTERÍSTICAS',
      valid          : true,
      tproducto    : { id:1, nombre: 'Producto Existente'},
      tproductos   : [{ id:1, nombre:'Producto Existente'}, 
                      { id:2, nombre:'Modificación de producto'},
                      { id:3, nombre:'Nuevo Producto'}
                     ],
      id_consecutivo: null, // id de partida para modo agregar desde compromiso
      id_partida   : null , // identificador de partida que recibo
      id_caracter  : null,  // identificador de caracteristicas que consulto
      cantidad     : '',
      material     : { id:null, nombre:''},
      materiales   : [],
			referencia   : '',
      acabado      : [],
      acabados     : [],
      pantone      : '',
      pantones     : [],
      motivo       : '',
      checkActivo  : 0,
      orientacion:[ { id:1 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/1.svg' },
                    { id:2 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/2.svg' },
                    { id:3 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/3.svg' },
                    { id:4 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/4.svg' },
                    { id:5 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/5.svg' },
                    { id:6 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/6.svg' },
                    { id:7 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/7.svg' },
                    { id:8 ,activo: false, img:'http://producciongama.com:8080/IMAGENES/ico-flexo/8.svg' },
                  ],
      etqxrollo     : '',
      med_nucleo    : '',
      etqxpaso      : '',
      med_desarrollo: '',
      med_eje       : '',
      ancho         : '',
      largo         : '',
      acabadosAEliminar:[],
      pantonesAEliminar:[],
      conceptosAEliminar:[],

      // AVISOS
      snackbar      : false,
      text          : '',
      // dialog        : false,
      // textDialog    : "Guardando Información",
      Correcto      : false,
      textCorrecto  : '',
      overlay       : false
    }),

    created(){ 
      this.validarModoVista() ;
    },
    computed:{ 
      ...mapGetters('Solicitudes',['consecutivo']),  
      ACTIVACAMPO(){ //! ESTA FUNCION SIRVE PARA VISUALIZAR EL FORMULARIO 
        return this.tproducto.id === 1 ?  false: true ;
      }
    },
    watch:{ 
      depto_id(){  this.validarModoVista(); } , // !SE ESCUCHAN LOS CAMBIOS DE DEPARTAMENTO
      parametros(){ this.validarModoVista(); } , //! SE ESCUCHAN LOS CMABIOS DEL PROP PARAMETROS
    }, 

    methods:{
      ...mapActions('Solicitudes'  ,['agregaProducto','actualizaProducto','consultaDetalle']), // IMPORTANDO USO DE VUEX (ACCIONES)
      evaluaCheck(id){ //! BUSCO LA ORIENTACION SELECCIONADA
        for(let i=0; i< this.orientacion.length;i++){ // !SI NO ES EL CHECK QUE SELECCIONO LO DEVUELVO A FALSO. 
          id != this.orientacion[i].id? this.orientacion[i].activo=false: this.orientacion[i].activo=true;
        }
        this.checkActivo = id; //! GUARDO EL CHECK-ACTIVO 
      },

      agregarPantone(){ 
        // var esHexadecimal = false;
        // if( esHexadecimal = this.esHexadecimal(this.pantone) ){
          this.pantones.push(this.pantone);
          this.pantone = '';
        // }
      },

      esHexadecimal(pantone){ return /^#[0-9A-F]+$/i.test(pantone); },
      eliminaPanton(i){ this.pantones.splice(i,1); },

      validarModoVista(){
        console.log('ENTRO', this.solicitud) 
        this.limpiarCampos();
        this.consultaMateriales(this.depto_id);
        this.consultaAcabados(this.depto_id);

        if(this.modoVista === 1 || this.modoVista === 3){this.limpiarCampos() };

				if(this.modoVista === 2 ){
          // console.log('parametros', this.parametros)
          // ASIGNAR VALORES AL FORMULARIO
          this.id_consecutivo = this.parametros.id
          this.tproducto    = { id: this.parametros.tproductos };
          this.cantidad     = this.parametros.cantidad
          this.referencia   = this.parametros.referencia;
          this.material     = { id: this.parametros.id_material};
          this.tproducto    = { id: this.parametros.tproducto};
          this.pantones     = this.parametros.pantones;
          this.acabado      = this.parametros.acabados ;
          this.checkActivo  = this.id_orientacion
          this.evaluaCheck(this.parametros.id_orientacion)
          this.etqxrollo     =  this.parametros.etqxrollo
          this.med_nucleo    =  this.parametros.med_nucleo
          this.etqxpaso      =  this.parametros.etqxpaso
          this.med_desarrollo=  this.parametros.med_desarrollo
          this.med_eje       =  this.parametros.med_eje
          this.ancho         =  this.parametros.ancho
          this.largo         =  this.parametros.largo
        } 
        if(this.modoVista === 4){
          this.id_partida = this.parametros.id,
          this.tproducto  = { id: this.parametros.tipo_prod };
          this.cantidad   = this.parametros.cantidad;
          this.referencia = this.parametros.ft;
          if(this.parametros.tipo_prod === 3){ this.consultaCaracteristicas(); };
          if(this.parametros.tipo_prod === 2){ this.consultaModificaciones(); };
        }
      },

      consultaCaracteristicas(){
        this.$http.post('caracteristicas', this.parametros).then(response =>{
          this.id_caracter        = response.body.id
          this.material          = { id: response.body.id_material};
          this.acabado           = response.body.acabados ;
          this.checkActivo       = this.id_orientacion
          this.evaluaCheck(response.body.id_orientacion)
          this.etqxrollo         = response.body.etqxrollo
          this.med_nucleo        = response.body.med_nucleo
          this.etqxpaso          = response.body.etqxpaso
          this.med_desarrollo    = response.body.med_desarrollo
          this.med_eje           = response.body.med_eje
          this.ancho             = response.body.ancho
          this.largo             = response.body.largo
          this.pantones          = response.body.pantones.map( item =>{ return item.pantone});
          this.acabadosAEliminar = response.body.acabados;
          this.pantonesAEliminar = response.body.pantones;
        }).catch( error =>{
          console.log('err', error)
        } )
      },

      consultaModificaciones(){
        this.$http.get('modificaciones/'+ this.parametros.id).then(res =>{
          this.conceptosAEliminar  = []; let acabados = [], pantones =[]; 
          for(let i=0; i< res.body.length; i++){
            this.conceptosAEliminar.push(res.body[i].id);
            res.body[i].concepto === 'Material'            ? this.material       = { id: parseInt(res.body[i].valor)}: '';
            res.body[i].concepto === 'Etiqueta por Rollo'  ? this.etqxrollo      = res.body[i].valor: ''
            res.body[i].concepto === 'Medida del nucleo'   ? this.med_nucleo     = res.body[i].valor: ''     
            res.body[i].concepto === 'Etiqueta al paso'    ? this.etqxpaso       = res.body[i].valor: ''      
            res.body[i].concepto === 'Medida de desarrollo'? this.med_desarrollo = res.body[i].valor: '' 
            res.body[i].concepto === 'Medida del eje'      ? this.med_eje        = res.body[i].valor: '' 
            res.body[i].concepto === 'Ancho'               ? this.ancho          = res.body[i].valor: ''
            res.body[i].concepto === 'Largo'               ? this.largo          = res.body[i].valor: ''
            res.body[i].concepto === 'Orientacion'         ? this.checkActivo    = parseInt(res.body[i].valor): '';
            res.body[i].concepto === 'Orientacion'         ? this.evaluaCheck(res.body[i].valor)   : '';
            if(res.body[i].concepto === 'Pantone' ){ pantones.push( res.body[i].valor) }
            if(res.body[i].concepto === 'Acabado' ){ acabados.push({id: parseInt(res.body[i].valor)})}
          }
            this.pantones = pantones; this.acabado  = acabados;
        }).catch(error =>{
          console.log('error', error)
        })
      },

      validaInformacion(){
        if(this.tproducto.id === 3 ) {
          if(!this.referencia)     { this.snackbar=true; this.text ="OLVIDASTE LA FICHA TECNICA"             ; return };
          if(!this.cantidad)       { this.snackbar=true; this.text ="OLVIDASTE LA CANTIDAD DEL MATERIAL"     ; return };
          if(!this.material.id)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL"          ; return };
          if(!this.acabado.length) { this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN ACABADO"      ; return };
          if(!this.etqxrollo)      { this.snackbar=true; this.text ="DEBES AGREGAR LA ETIQUETA POR ROLLO"    ; return };
          if(!this.med_nucleo)     { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DE NUCLEO"      ; return };
          if(!this.etqxpaso)       { this.snackbar=true; this.text ="DEBES AGREGAR LA ETIQUETA POR PASO"     ; return };
          if(!this.med_desarrollo) { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DEL DESARROLLO" ; return };
          if(!this.med_eje)        { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DEL EJE"        ; return };
          if(!this.ancho)          { this.snackbar=true; this.text ="DEBES AGREGAR EL ANCHO"                 ; return };
          if(!this.largo)          { this.snackbar=true; this.text ="DEBES AGREGAR EL LARGO"                 ; return };
          // if(!this.pantones.length){ this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN PANTONE"      ; return };
          if(!this.checkActivo)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UNA ORIENTACIÓN"      ; return };
        }else if(this.tproducto.id === 1 || this.tproducto.id === 2 ){
          if(!this.referencia)     { this.snackbar=true; this.text ="OLVIDASTE LA FICHA TECNICA"             ; return };
          if(!this.cantidad)       { this.snackbar=true; this.text ="OLVIDASTE LA CANTIDAD DEL MATERIAL"     ; return };
        }
        this.PrepararPeticion();
      },

      PrepararPeticion(){
        let payload = {}, id = null, id_sol = null;

      //  if(this.modoVista === 1 )  { id = this.consecutivo  ; id_sol = null };
      //  if(this.modoVista === 2 )  { id = this.id_consecutivo  ; id_sol = this.parametros.id_solicitud };
      //  if(this.modoVista === 3 )  { id = this.consecutivo  ; id_sol = this.parametros.id  };
      //  if(this.modoVista === 4 )  { id = this.parametros.id; id_sol = this.parametros.id_solicitud };
      
       if(this.tproducto.id === 1){ //! FORMO ARRAY SI ES PRODUCTO EXISTENTE
          payload = { 
                      id_solicitud    : this.solicitud.id,
                      dx        : 1,
                      referencia: this.referencia,
                      tproducto : this.tproducto.id,
                      cantidad  : this.cantidad,
                    }
       } 
        
       if(this.tproducto.id === 2 || this.tproducto.id === 3){ //! FORMO ARRAY SI ES UNA MODIFICACION DE PRODUCTO
          payload ={ 
                    id_solicitud   : this.solicitud.id,
                    dx             : 1,
                    referencia     : this.referencia,
                    id_material    : this.material.id ? this.material.id : null,
                    pantones       : this.pantones.length? this.pantones:[],
                    acabados       : this.acabado.length? this.acabado : [],
                    id_orientacion : this.checkActivo,
                    etqxrollo      : this.etqxrollo? this.etqxrollo : '',
                    med_nucleo     : this.med_nucleo? this.med_nucleo : '',
                    etqxpaso       : this.etqxpaso? this.etqxpaso : '',
                    med_desarrollo : this.med_desarrollo ? this.med_desarrollo : '',
                    med_eje        : this.med_eje ? this.med_eje: '',
                    ancho          : this.ancho ? this.ancho :'',
                    largo          : this.largo ? this.largo :'',
                    tproducto      : this.tproducto.id,
                    cantidad       : this.cantidad,
                    xmodificar     : this.tproducto.id === 2 ? this.objetoxModificar(): '',
                    // conceptosAEliminar: this.conceptosAEliminar,
                    // pantonesAEliminar : this.pantonesAEliminar,
                    // acabadosAEliminar : this.acabadosAEliminar
                  }
       }

        // console.log('AGREGAR PRODUCTO', payload);
       // VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
       if(this.modoVista === 1){ this.Crear(payload)      }; // CREAR PRODUCTO EN VUEX
       if(this.modoVista === 2){ this.Actualizar(payload) }; // ACTUALIZAR PRODUCTO EN VUEX
       if(this.modoVista === 3){ this.Añadir_Producto(payload)     }; // 
       if(this.modoVista === 4){ this.Actualizar_Producto(payload) };

      },

      Crear(payload){
        this.overlay = true;
        // console.log('crear producto', payload)
        this.agregaProducto(payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se agrego a la lista"); }
        }).finally(()=>{ 
          this.overlay = false
        })
      },

      Añadir_Producto(payload){
         this.overlay = true;
         this.$http.post('anadir.producto.sol', payload).then(response =>{
          //  console.log('respuesta s', response.body)
           this.TerminarProceso(response.bodyText);
         }).catch(error =>{
           console.log('error', error)
         }).finally(()=>{
           this.overlay = false;
         })
      },

      Actualizar(payload){
        this.overlay = true;
        // console.log('actualizar producto', payload)
        this.actualizaProducto(payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se modifico correctamente"); }
        }).finally(()=>{ 
          this.overlay = false
        })
      },

      Actualizar_Producto(payload){
        // console.log('actualiza', payload)
      this.overlay = true;
       this.$http.post('actualiza.producto',payload).then( res =>{
          if(res){ this.TerminarProceso(res.bodyText); }
        }).finally(()=>{ 
          this.overlay = false
        })
      },

			TerminarProceso(mensaje){
        var me = this ;
        this.Correcto = true ; this.textCorrecto = mensaje;
        setTimeout(()=>{ me.$emit('modal',false); me.$emit('put',!this.actualiza)}, 2000);
        this.consultaDetalle(this.solicitud.id)
        this.limpiarCampos();  //LIMPIAR FORMULARIO
      },

      limpiarCampos(){
        this.referencia     = '';
        this.material       = { id:null, nombre:''};
        this.cantidad       = '';
        this.tproducto      = { id:1 };
        this.pantone        = '';
        this.pantones       = []
        this.acabado        = [];
        this.checkActivo    = 0;
        this.evaluaCheck(0);
        this.etqxrollo      = '';
        this.med_nucleo     = '';
        this.etqxpaso       = '';
        this.med_desarrollo = '';
        this.med_eje        = '';
        this.ancho          = '';
        this.largo          = '';

      },

      objetoxModificar(){
        let id = null, id_sol = null;
        // if(this.modoVista === 1 )  { id = this.consecutivo  ; id_sol = null };
        // if(this.modoVista === 2 )  { id = this.consecutivo  ; id_sol = this.parametros.id_solicitud };
        // if(this.modoVista === 3 )  { id = this.consecutivo  ; id_sol = this.parametros.id  };
        // if(this.modoVista === 4 )  { id = this.parametros.id; id_sol = this.parametros.id_solicitud };

        let payload = { id: id,
                        id_solicitud: this.solicitud.id,
                        dx: 1,
                        referencia     : this.referencia,
                        tproducto      : this.tproducto.id,
                        cantidad       : this.cantidad,
                        xmodificar     : this.agregaConceptos(),
                      }
                      // SE TIENE QUE METER A UN ARRAY EL OBJ DE CONCEPTO Y VALOR
        return payload;
      },

      agregaConceptos(){
        let arrayTemp = [];
        this.material.id     ? arrayTemp.push( { tipo:1 , concepto:'Material'             , valor: this.material.id    }): '';
        this.pantones.length ? arrayTemp.push( { tipo:2 , concepto:'Pantone'              , valor: this.pantones       }): ''; 
        this.acabado.length  ? arrayTemp.push( { tipo:2 , concepto:'Acabado'              , valor: this.formarObject(this.acabado) }): '';
        this.checkActivo     ? arrayTemp.push( { tipo:1 , concepto:'Orientacion'          , valor: this.checkActivo    }): '';
        this.etqxrollo       ? arrayTemp.push( { tipo:1 , concepto:'Etiqueta por Rollo'   , valor: this.etqxrollo      }): '';
        this.med_nucleo      ? arrayTemp.push( { tipo:1 , concepto:'Medida del nucleo'    , valor: this.med_nucleo     }): '';
        this.etqxpaso        ? arrayTemp.push( { tipo:1 , concepto:'Etiqueta al paso'     , valor: this.etqxpaso       }): '';
        this.med_desarrollo  ? arrayTemp.push( { tipo:1 , concepto:'Medida de desarrollo' , valor: this.med_desarrollo }): '';
        this.med_eje         ? arrayTemp.push( { tipo:1 , concepto:'Medida del eje'       , valor: this.med_eje        }): '';
        this.ancho           ? arrayTemp.push( { tipo:1 , concepto:'Ancho'                , valor: this.ancho          }): '';
        this.largo           ? arrayTemp.push( { tipo:1 , concepto:'Largo'                , valor: this.largo          }): '';
        return arrayTemp;
      },

      formarObject(items){
        let arrayTemp = [];
        for(let i=0; i< items.length;i++){
          arrayTemp.push(items[i].id)
        }

        return arrayTemp;
      }

  
    }
  }
</script>


