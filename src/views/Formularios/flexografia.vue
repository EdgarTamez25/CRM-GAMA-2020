<template>
  <!-- <v-main class="pa-0"> -->
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
        <v-form ref="form"> 
          <v-row >
            <!-- //! TITULO - CARACTERISTICAS -->
            <v-card-text class="font-weight-black pa-1 headline" v-if="!Loading">{{ tipo_producto }} </v-card-text>
            <v-card-text class="font-weight-black pa-1 subtitle-1" v-if="!Loading">{{ titulo }}</v-card-text>

            <v-col cols="12" v-if=" !Loading && Vista === 'PRODUCTOS' && getDatosFlexo != null">
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
             <!-- // !SELETOR DE MATERIALES  -->
            <v-col cols="12" sm="6" v-if="ACTIVACAMPO">
              <v-select
                v-model="material" :items="materiales" item-text="nombre" item-value="id" outlined color="celeste"
                dense hide-details label="Materiales" return-object placeholder="Materiales" 
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
                <v-col cols="3" class="text-right my-0 py-0" v-if="ACTIVACAMPO">
                  <v-btn color="celeste" dark @click="agregarPantone()" > <v-icon>add</v-icon> </v-btn>
                </v-col>
                <!-- // !CHIPS DE PANTONES   -->
                <v-col cols="12" class="my-0 py-0 text-left">
                  <v-chip v-for="(item, i) in pantones" :key="i"
                    class="ma-2" close :color="item" dark  @click:close="eliminaPanton(i)">
                    {{ item }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-col>
             <!-- // !SELECTOR DE ACABADOS    -->
            <v-col cols="12" v-if="ACTIVACAMPO">
              <v-select
                v-model="acabado" :items="acabados" item-text="nombre" item-value="id" outlined color="celeste" 
                dense hide-details label="Acabados" return-object multiple :menu-props="{ maxHeight: '400' }"
              ></v-select>
            </v-col>
            <v-card-text class="font-weight-black pa-1 subtitle-1" v-if="ACTIVACAMPO">PRESENTACIÓN</v-card-text>

             <!-- // !ETIQUETA POR ROLLO    -->
            <v-col cols="12" sm="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="etqxrollo" hide-details dense label="Etiqueta por rollo" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !MEDIDA DE NUCLEO   -->
            <v-col cols="12" sm="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="med_nucleo" hide-details dense label="Medida del Nucleo" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !ETIQUETA POR PASO   -->
            <v-col cols="12" sm="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="etqxpaso" hide-details dense label="Etiqueta al paso" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !MEDIDA DE DESARROLLO   -->
            <v-col cols="12" sm="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="med_desarrollo" hide-details dense label="Medida de desarrollo" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // !MEDIDA DE EJE   -->
            <v-col cols="12" sm="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="med_eje" hide-details dense label="Medida de eje" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // ! ANCHO DE ETIQUETA   -->
            <v-col cols="6" class="my-0 py-1" v-if="ACTIVACAMPO">
              <v-text-field 
                v-model="ancho" hide-details dense label="Ancho" 
                outlined color="celeste" 
              />
            </v-col>
             <!-- // ! LARGO DE ETIQUETA   -->
            <v-col cols="6" class="my-0 py-1" v-if="ACTIVACAMPO">
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

      <v-col cols="12" class="my-3"  v-if="!Loading && modoVista === 2"/>
      <v-col cols="12" class="text-right" v-if="modoVista===1 || modoVista === 3">
        <v-btn color="celeste" outlined small @click="validaEmit()" >
          {{ modoVista === 1? "Agregar Caracteristicas": "Agregar Modificaciones" }}
        </v-btn>
      </v-col>

      <!-- //!CONTENEDOR DE CIERRE Y PROCESOS -->
      <v-footer  absolute v-if="!Loading && modoVista === 2" >
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
	import  metodos from '@/mixins/metodos.js';
	import {mapGetters, mapActions} from 'vuex';
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
      titulo         : 'FLEXOGRAFÍA',
      tipo_producto  : '',
      valid          : true,
      id_producto  : null,
      tproducto    : { id:1, nombre: 'Producto Existente'},
      tproductos   : [{ id:1, nombre:'Producto Existente'}, 
                      { id:2, nombre:'Modificación de producto'},
                      { id:3, nombre:'Nuevo Producto'}
                     ],
      cantidad     : '',
      material     : { id:null, nombre:''},
      materiales   : [],
			referencia   : '',
      acabado      : [],
      acabados     : [],
      acabadosAEliminar: [],
      pantonesAEliminar: [],
      pantone      : '',
      pantones     : [],
      motivo       : '',
      checkActivo  : 0,
      orientacion:[ { id:1 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/1.svg' },
                    { id:2 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/2.svg' },
                    { id:3 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/3.svg' },
                    { id:4 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/4.svg' },
                    { id:5 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/5.svg' },
                    { id:6 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/6.svg' },
                    { id:7 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/7.svg' },
                    { id:8 ,activo: false, img:'http://producciongama.com:8080/CRM-GAMA-2020/imagenes/ico-flexo/8.svg' },
                  ],
      etqxrollo     : '',
      med_nucleo    : '',
      etqxpaso      : '',
      med_desarrollo: '',
      med_eje       : '',
      ancho         : '',
      largo         : '',
      // AVISOS
      snackbar     : false,
      text         : '',
      color        : 'error',
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
      ...mapGetters('Solicitudes',['consecutivo', 'getDatosFlexo']),  
			...mapGetters('Login' ,['getLogeado','getdatosUsuario']), 

      ACTIVACAMPO(){ //! ESTA FUNCION SIRVE PARA VISUALIZAR EL FORMULARIO 
        return this.tproducto.id === 1 ?  false: true ;
      }
    },
    watch:{ 
      depto_id(){  this.validarModoVista(); } , // !SE ESCUCHAN LOS CAMBIOS DE DEPARTAMENTO
      parametros(){ this.validarModoVista();  } , //! SE ESCUCHAN LOS CMABIOS DEL PROP PARAMETROS
    }, 

    methods:{
      ...mapActions('Solicitudes'  ,['agregaProducto','actualizaProducto','copiarInfoDeSolicitud']), // IMPORTANDO USO DE VUEX (ACCIONES)
      
      validarModoVista(){ 
        this.consultaMateriales(this.depto_id);
        this.consultaAcabados(this.depto_id);
        if(this.modoVista === 2){

          this.$http.post('caracteristicas', this.parametros).then(response =>{
            this.tproducto    = { id: parseInt(this.parametros.tipo_prod) },
            this.tipo_producto = this.tproductos[parseInt(this.parametros.tipo_prod) - 1].nombre.toUpperCase();
            this.cantidad     = this.parametros.cantidad
            this.referencia   = this.parametros.ft;
            this.material     = { id: response.body.id_material};
            this.checkActivo  = response.body.id_orientacion
            this.evaluaCheck(response.body.id_orientacion)
            this.etqxrollo     =  response.body.etqxrollo
            this.med_nucleo    =  response.body.med_nucleo
            this.etqxpaso      =  response.body.etqxpaso
            this.med_desarrollo=  response.body.med_desarrollo
            this.med_eje       =  response.body.med_eje
            this.ancho         =  response.body.ancho
            this.largo         =  response.body.largo
            this.acabado      = response.body.acabados;
            this.pantones     = response.body.pantones.map( item =>{ return item.pantone});
          }).catch( error =>{
            console.log('error flexo', error)
          }).finally(()=>{
            this.Loading = false;
          })

        }else if(this.modoVista === 3){

          this.$http.post('caracteristicas', this.parametros).then(response =>{
            this.id_producto  = response.body.id;
            this.tproducto    = { id: 2 },  // solo se pone para que se habilite el formulario
            this.material     = { id: response.body.id_material};
            this.checkActivo  = response.body.id_orientacion
            this.evaluaCheck(response.body.id_orientacion)
            this.etqxrollo     =  response.body.etqxrollo
            this.med_nucleo    =  response.body.med_nucleo
            this.etqxpaso      =  response.body.etqxpaso
            this.med_desarrollo=  response.body.med_desarrollo
            this.med_eje       =  response.body.med_eje
            this.ancho         =  response.body.ancho
            this.largo         =  response.body.largo
            this.acabado       = response.body.acabados;
            this.acabadosAEliminar = response.body.acabados;
            this.pantonesAEliminar = response.body.pantones;
            this.pantones      = response.body.pantones.map( item =>{ return item.pantone});
          }).catch( error =>{
            // console.log('error flexo', error)
          }).finally(()=>{
            this.Loading = false;
          })

        }else{
          this.limpiarCampos();
        }
      },

      validaInformacion(){
        if(this.tproducto.id === 3) {
          if(!this.referencia){ this.snackbar=true; this.text ="OLVIDASTE LA FICHA TECNICA"         ; return };
          if(!this.cantidad  ){ this.snackbar=true; this.text ="OLVIDASTE LA CANTIDAD DEL MATERIAL" ; return };
          if(!this.material.id)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL"          ; return };
          if(!this.acabado.length) { this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN ACABADO"      ; return };
          if(!this.etqxrollo)      { this.snackbar=true; this.text ="DEBES AGREGAR LA ETIQUETA POR ROLLO"    ; return };
          if(!this.med_nucleo)     { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DE NUCLEO"      ; return };
          if(!this.etqxpaso)       { this.snackbar=true; this.text ="DEBES AGREGAR LA ETIQUETA POR PASO"     ; return };
          if(!this.med_desarrollo) { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DEL DESARROLLO" ; return };
          if(!this.med_eje)        { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DEL EJE"        ; return };
          if(!this.ancho)          { this.snackbar=true; this.text ="DEBES AGREGAR EL ANCHO"                 ; return };
          if(!this.largo)          { this.snackbar=true; this.text ="DEBES AGREGAR EL LARGO"                 ; return };
          if(!this.pantones.length){ this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN PANTONE"      ; return };
          if(!this.checkActivo)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UNA ORIENTACIÓN"      ; return };
        }else if(this.tproducto.id === 1 || this.tproducto.id === 2 ){
          if(!this.referencia)     { this.snackbar=true; this.text ="OLVIDASTE LA FICHA TECNICA"             ; return };
          if(!this.cantidad)       { this.snackbar=true; this.text ="OLVIDASTE LA CANTIDAD DEL MATERIAL"     ; return };
        }
        this.PrepararPeticion();
      },

      // SOLO SE USA PARA LA CREACION Y ACTUALIZACION DE LOS PRODUCTOS
      validaEmit(){
        if(!this.material.id)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UN MATERIAL"          ; return };
        if(!this.acabado.length) { this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN ACABADO"      ; return };
        if(!this.etqxrollo)      { this.snackbar=true; this.text ="DEBES AGREGAR LA ETIQUETA POR ROLLO"    ; return };
        if(!this.med_nucleo)     { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DE NUCLEO"      ; return };
        if(!this.etqxpaso)       { this.snackbar=true; this.text ="DEBES AGREGAR LA ETIQUETA POR PASO"     ; return };
        if(!this.med_desarrollo) { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DEL DESARROLLO" ; return };
        if(!this.med_eje)        { this.snackbar=true; this.text ="DEBES AGREGAR LA MEDIDA DEL EJE"        ; return };
        if(!this.ancho)          { this.snackbar=true; this.text ="DEBES AGREGAR EL ANCHO"                 ; return };
        if(!this.largo)          { this.snackbar=true; this.text ="DEBES AGREGAR EL LARGO"                 ; return };
        if(!this.pantones.length){ this.snackbar=true; this.text ="DEBES AGREGAR AL MENOS UN PANTONE"      ; return };
        if(!this.checkActivo)    { this.snackbar=true; this.text ="DEBES SELECCIONAR UNA ORIENTACIÓN"      ; return };

        const detalle = new Object();
        detalle.id             = this.id_producto;
        detalle.id_material    = this.material.id;
        detalle.acabados       = this.acabado;
        detalle.acabadosAEliminar = this.acabadosAEliminar;
        detalle.pantones       = this.pantones;
        detalle.pantonesAEliminar = this.pantonesAEliminar;
        detalle.etqxrollo      = this.etqxrollo;
        detalle.med_nucleo     = this.med_nucleo;
        detalle.etqxpaso       = this.etqxpaso;
        detalle.med_desarrollo = this.med_desarrollo;
        detalle.med_eje        = this.med_eje;
        detalle.ancho          = this.ancho;
        detalle.largo          = this.largo;
        detalle.id_orientacion = this.checkActivo;
        detalle.dx             = 1;

        this.snackbar = true; this.text ="Las caracteristicas se guardaron correctamente"; this.color ="green";
        this.$emit('detalle',detalle); // EMITIR DETALLE A CONTROL PRODUCTOS

      },

      PrepararPeticion(){
        this.overlay = true; let payload = {};
        if(this.tproducto.id === 1){ //! FORMO ARRAY SI ES PRODUCTO EXISTENTE
          payload = { id        : this.modoVista ===1 ? this.consecutivo: this.parametros.id,
                      dx        : 1,
                      referencia: this.referencia,
                      tproducto : this.tproducto.id,
                      cantidad  : this.cantidad,
                      id_dx     : this.modoVista === 2? this.parametros.id_dx: '' 
                    }
        }else if(this.tproducto.id === 2 || this.tproducto.id === 3){ //! FORMO ARRAY SI ES UNA MODIFICACION DE PRODUCTO
          payload ={  id             : this.modoVista === 1? this.consecutivo: this.parametros.id,
                      dx             : 1,
                      referencia     : this.referencia,
                      id_material    : this.material.id,
                      pantones       : this.pantones,
                      acabados       : this.acabado,
                      id_orientacion : this.checkActivo,
                      etqxrollo      : this.etqxrollo,
                      med_nucleo     : this.med_nucleo,
                      etqxpaso       : this.etqxpaso,
                      med_desarrollo : this.med_desarrollo,
                      med_eje        : this.med_eje,
                      ancho          : this.ancho,
                      largo          : this.largo,
                      tproducto      : this.tproducto.id,
                      cantidad       : this.cantidad,
                      xmodificar     : this.tproducto.id === 2? this.objetoxModificar(): '',
                      id_dx          : this.modoVista === 2? this.parametros.id_dx: '' 

                    }
        }
        // VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
      },

      Crear(payload){
        this.agregaProducto(payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se agrego a la lista"); }
        }).finally(()=>{ 
          this.overlay = false
        })
      },

      Actualizar(payload){
        this.actualizaProducto( payload).then( res =>{
          if(res){ this.TerminarProceso("El producto se modifico correctamente"); }
        }).catch( error =>{
          console.log('putprod')
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
        this.referencia     = '';
        this.material       = { id:null, nombre:''};
        this.cantidad       = '';
        this.tproducto      =  this.modoVista != 1 ? { id:1 }: { id:2}; // solo se pone para que se habilite el formulario
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
        this.Loading = false;
      },

      evaluaCheck(id){ //! BUSCO LA ORIENTACION SELECCIONADA
        for(let i=0; i< this.orientacion.length;i++){ // !SI NO ES EL CHECK QUE SELECCIONO LO DEVUELVO A FALSO. 
          id != this.orientacion[i].id? this.orientacion[i].activo=false: this.orientacion[i].activo=true;
        }
        this.checkActivo = id; //! GUARDO EL CHECK-ACTIVO 
      },

      agregarPantone(){ 
        var esHexadecimal = false;
        if( esHexadecimal = this.esHexadecimal(this.pantone) ){
          this.pantones.push(this.pantone);
          this.pantone = '';
        }
      },

      esHexadecimal(pantone){ return /^#[0-9A-F]+$/i.test(pantone); },

      eliminaPanton(i){ this.pantones.splice(i,1); },

      objetoxModificar(){
        let payload = { id: this.modoVista ===1 ? this.consecutivo: this.parametros.id,
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
        this.material.id     ? arrayTemp.push( { tipo:1 , concepto:'Material'   ,valor: this.material.id    }): '';
        this.pantones.length ? arrayTemp.push( { tipo:2 , concepto:'Pantone'      ,valor: this.pantones       }): ''; 
        this.acabado.length  ? arrayTemp.push( { tipo:2 , concepto:'Acabado'      ,valor: this.formarObject(this.acabado) }): '';
        this.checkActivo     ? arrayTemp.push( { tipo:1 , concepto:'Orientacion',valor: this.checkActivo    }): '';
        this.etqxrollo       ? arrayTemp.push( { tipo:1 , concepto:'Etiqueta por rollo'     ,valor: this.etqxrollo      }): '';
        this.med_nucleo      ? arrayTemp.push( { tipo:1 , concepto:'Medida del nucleo'    ,valor: this.med_nucleo     }): '';
        this.etqxpaso        ? arrayTemp.push( { tipo:1 , concepto:'Etiqueta al paso'      ,valor: this.etqxpaso       }): '';
        this.med_desarrollo  ? arrayTemp.push( { tipo:1 , concepto:'Medida de desarrollo',valor: this.med_desarrollo }): '';
        this.med_eje         ? arrayTemp.push( { tipo:1 , concepto:'Medida del eje'       ,valor: this.med_eje        }): '';
        this.ancho           ? arrayTemp.push( { tipo:1 , concepto:'Ancho'         ,valor: this.ancho          }): '';
        this.largo           ? arrayTemp.push( { tipo:1 , concepto:'Largo'         ,valor: this.largo          }): '';

        return arrayTemp;
      },

      formarObject(items){
        let arrayTemp = [];
        for(let i=0; i< items.length;i++){
          arrayTemp.push(items[i].id)
        }

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
          // console.log('response', response.body)
          this.overlay  = false; this.colorCorrecto = 'green';
          this.Correcto = true; this.textCorrecto = response.bodyText; 
          this.Terminar(200)
        }).catch( error =>{
          console.log('error DDD', error)
          this.overlay = false; this.colorCorrecto = 'error'; this.textCorrecto = error.bodyText;
          this.Terminar(500)
        })
      },

      Terminar(status){
        var me = this;
        status === 200? setTimeout(()=> { me.$emit('modal',false); me.$emit('put', this.actualiza = !this.actualiza)}, 1500):
                        setTimeout(()=> { me.Correcto = false    }, 1500)
        
      },

      copiarInfo(){
        const payload = new Object();
              payload.material       = this.material;
              payload.pantones       = this.pantones;
              payload.acabados       = this.acabado;
              payload.etqxrollo      = this.etqxrollo;
              payload.med_nucleo     = this.med_nucleo;
              payload.etqxpaso       = this.etqxpaso;
              payload.med_desarrollo = this.med_desarrollo;
              payload.med_eje        = this.med_eje;
              payload.ancho          = this.ancho;
              payload.largo          = this.largo;
              payload.checkActivo    = this.checkActivo;
              payload.dx             = 1

        this.copiarInfoDeSolicitud(payload);
        this.snackbar = true; this.text = "La información se copio correctamente."; this.color ="green";
      },

      pegarInfo(){
        this.material       =  this.getDatosFlexo.material
        this.acabado        =  this.getDatosFlexo.acabados;
        this.etqxrollo      =  this.getDatosFlexo.etqxrollo
        this.med_nucleo     =  this.getDatosFlexo.med_nucleo
        this.etqxpaso       =  this.getDatosFlexo.etqxpaso
        this.med_desarrollo =  this.getDatosFlexo.med_desarrollo
        this.med_eje        =  this.getDatosFlexo.med_eje
        this.ancho          =  this.getDatosFlexo.ancho
        this.largo          =  this.getDatosFlexo.largo
        this.checkActivo    = this.getDatosFlexo.checkActivo
        this.evaluaCheck(this.getDatosFlexo.checkActivo)
        this.pantones       = this.getDatosFlexo.pantones; 
        this.snackbar = true; this.text = "La información se ha pegado correctamente."; this.color ="green";

      }
      

    }
  }
</script>


