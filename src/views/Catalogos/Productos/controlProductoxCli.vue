<template>
  <v-main class="pa-0 ma-3">
    <v-row>
      
      <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
        <strong> {{alerta.texto}} </strong>
        <template v-slot:action="{ attrs }">
          <v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
        </template>
      </v-snackbar>


      <v-col cols="9" sm="10" align="left">
        <v-card-text class="font-weight-black headline  py-0 mt-1 " > {{ modoVista === 1 ? 'NUEVO PRODUCTO': 'EDITAR PRODUCTOS'}} </v-card-text>
      </v-col>
       <v-col cols="3" sm="2" align="right">
        <v-btn color="error"  @click="$emit('modal',false)" outlined><v-icon>clear</v-icon></v-btn>
      </v-col>

      <v-col cols="12" >
        <v-autocomplete
          :items="clientes" v-model="cliente" item-text="nombre" tem-value="id" label="Clientes" 
          dense filled hide-details color="celeste" append-icon="person" return-object clearable
          :disabled="modoVista === 3? true:false"
        ></v-autocomplete>
      </v-col>

      <v-col cols="12" sm="6">
        <v-text-field
          v-model="nombre" label="Nombre" placeholder="Nombre del producto"
          hide-details dense filled clearable
        ></v-text-field>
      </v-col>

      <v-col cols="12" sm="6">
        <v-text-field
          v-model="codigo" label="Codigo" placeholder="Codigo de producto"
          hide-details dense filled clearable
        ></v-text-field>
      </v-col>

      <v-col cols="12" >
        <v-textarea
          v-model="descripcion" label="Descripción del producto" filled hide-details dense  clearable rows="2"
        ></v-textarea>
      </v-col>

      <v-col cols="12" sm="3">
        <v-text-field
          v-model.number="revision" label="Revision" placeholder="Revision" 
          hide-details dense filled clearable type="number"
        ></v-text-field>
      </v-col>

      <v-col cols="9">
        <v-text-field
          v-model="url" label="URL" placeholder="Direccion de ficha" 
          hide-details dense filled clearable 
        ></v-text-field>
      </v-col>
      

      <v-col cols="12" > 
        <v-select
						v-model="depto" :items="deptos" item-text="nombre" item-value="id" outlined color="celeste" 
						dense hide-details  label="Departamentos" return-object placeholder ="Departamentos" :disabled="modoVista === 3? true:false"
				></v-select>
      </v-col> 

      <flexografia
        :modalDDD="modalDDD"
        :depto_id="depto.id" 
        :modoVista="modoVista"
        :Vista="Vista"
        :parametros="data"
        @modal="caracteristicasModal = $event" 
        @detalle="detalle = $event"
        v-if="activaFormulario===1"
        class="pa-3 py-0"
      />
      <digital    
        :modalDDD="modalDDD"
        :depto_id="depto.id" 
        :modoVista="modoVista"
        :Vista="Vista"
        :parametros="data"
        @modal="caracteristicasModal = $event" 
        @detalle="detalle = $event"
        v-if="activaFormulario===3"
        class="pa-3 py-0"

      />

      <v-col cols="12" v-if="alertaFormulario">
        <v-alert outlined type="error">
          Que onda maaaann, lo sentimos este formulario no esta disponible :c 
        </v-alert>
      </v-col>
      

      <v-col cols="12" class="text-right" >
        <v-btn color="green" dark  @click="validarInfomracion()">{{ modoVista === 1 ? 'CREAR PRODUCTO': 'ACTUAIZAR PRODUCTO' }}</v-btn>
      </v-col>

      <!-- MODULOS PARA FINALIZAR PROCESOS -->
      <v-dialog v-model="Correcto" hide-overlay persistent width="350">
        <v-card :color="colorCorrecto" dark class="pa-3">
          <v-card-text class="font-weight-black headline pa-3 white--text" align="center">
            {{ textCorrecto }}
          </v-card-text>
        </v-card>
      </v-dialog>
		
		<overlay v-if="overlay"/>

    </v-row>
  </v-main>
</template>

<script>
  // import  SelectMixin from '@/mixins/SelectMixin.js';
	import  metodos from '@/mixins/metodos.js';
  import {mapGetters, mapActions} from 'vuex'
  import overlay        from '@/components/overlay.vue'
  import flexografia    from '@/views/Formularios/flexografia.vue'
  import digital        from '@/views/Formularios/digital.vue'

	export default {
		mixins:[metodos],
	  components: {
      overlay,
      flexografia,
      digital
      
		},
		props:[
			'modoVista',
      'data',
      'modalDDD',
      'Vista'
	  ],
	  data () {
			return {
        nombre          : '',
        codigo          : '',
        descripcion     : '',
        revision        : 0,
        url             : '', 
				fecha						: '',
				// AUTOCOMPLETE
				clientes	: [],
        cliente		: {id:null, nombre:''},

        deptos    : [],
        depto     : { id:null, nombre:''}, 

        detalle: [],
        caracteristicasModal: false,
        activaFormulario: 0,
        // ALERTAS
        overlay: false,
				alerta: { activo: false, texto:'', color:'error' },
        
				Correcto    : false,
        textCorrecto: '',
        colorCorrecto:'green',
        alertaFormulario: false
			}
		},
		
		created(){
			this.validarModoVista() 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
      // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('ProductosxCliente' ,['Loading','getProductosxCli']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('Login'    ,['getdatosUsuario']), 

      GUARDAR_PRODUCTO(){
        return Object.keys(this.detalle).length > 0 ? true: false;
      }
		},

		watch:{ 
      data(){ 
        this.validarModoVista(); 	
      },

      depto(){
          this.activaFormulario = null;
          this.alertaFormulario = false;

        if(this.depto.id === 1){
          this.activaFormulario = this.depto.id;
        }else if(this.depto.id != null){
          this.alertaFormulario = true;
        }
      },
    },

		methods:{
      ...mapActions('ProductosxCliente',['consultaProductosxCliente']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
      

			validarModoVista(){
        this.consultaDepartamentos();
        this.consultar_Clientes().then(res =>{
          if(this.modoVista === 3){
            // ASIGNAR VALORES AL FORMULARIO
            this.nombre      = this.data.nombre;
            this.codigo      = this.data.codigo;
            this.descripcion = this.data.descripcion;
            this.revision    = this.data.revision;
            this.fecha       = this.data.fecha;
            this.url         = this.data.url;
            this.depto       = { id: this.data.dx }
            let clienteACargar = res.filter( item => { 
              if(this.data.id_cliente === item.id){ 
                const cliente = new Object();
                      cliente.id = item.id; cliente.nombre = item.nombre
                      return cliente; 
              } 
            })  
              this.cliente = clienteACargar[0];

          }else{
            this.limpiarCampos()
          }
        });
			},

			validarInfomracion(){
				if(!this.cliente.id){ this.alerta   = { activo: true, texto:'NO PUEDES OMITIR EL CLIENTE'                   , color:'error' }; return }
				if(!this.codigo)	  { this.alerta   = { activo: true, texto:'NO PUEDES OMITIR EL CÓDIGO'                    , color:'error' }; return }
				if(this.revision < 0) { this.alerta = { activo: true, texto:'LA REVISIÓN NO PUEDE SER MENOR A CERO'         , color:'error' }; return }
        if(!this.url)			  { this.alerta   = { activo: true, texto:'DEBES AGREGAR LA DIRECCION DE LA FICHA TECNICA', color:'error' }; return }
        if(!this.depto.id)	{ this.alerta   = { activo: true, texto:'DEBES SELECCIONAR UN DEPARTAMENTO'             , color:'error' }; return }
        if(this.depto.id === 1 && !this.detalle )   {this.alerta   = { activo: true, texto:'NO HAZ GUARDADO LAS CARACTERISTICAS DEL PRODUCTO', color:'error' }; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
        // FORMAR ARRAY A MANDAR
        const producto = new Object();
              producto.id_cliente  = this.cliente.id;
              producto.nombre      = this.nombre;
              producto.codigo      = this.codigo;
              producto.descripcion = this.descripcion;
              producto.revision    = this.revision;
              producto.url         = this.url;
              producto.dx          = this.depto.id;
              producto.detalle     = this.detalle ? this.detalle : [];
              producto.fecha       = this.traerFechaActual();
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.modoVista === 1 ? this.Crear(producto): this.Actualizar(producto);
			},

			Crear(producto){
        this.overlay = true ; 
        
				this.$http.post('crear.producto.cliente', producto).then((response)=>{
					this.TerminarProceso(response.bodyText);					
				}).catch(error =>{
					this.mostrarError(error.bodyText)
				}).finally(() => this.overlay = false) 
			},

			Actualizar(producto){
				this.overlay = true ; 
				this.$http.put('actualiza.producto.cliente/'+ this.data.id, producto).then((response)=>{
					this.TerminarProceso(response.bodyText);					
				}).catch(error =>{
					this.mostrarError(error.bodyText)
				}).finally(() => this.overlay = false)
			},
	
			TerminarProceso(mensaje){
        var that = this ;	this.overlay = false; 
        this.Correcto = true ; this.textCorrecto = mensaje;
        setTimeout(() => { that.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
        this.consultaProductosxCliente(this.data.id_cliente) //ACTUALIZAR CONSULTA DE CLIENTES
        
			},

			limpiarCampos(){
				this.vendedor  = { id: null, nombre:''};
				this.categoria = { id: null, nombre:''};
				// this.cliente   = { id: null, nombre:''};
				this.fecha 		 = new Date().toISOString().substr(0, 10); 
				this.hora      = ''; 
				this.obs       = ''; 
        this.tipo      = '';
        this.nombre    = '';
        this.codigo    = '';
        this.descripcion = '';
        this.revision    = 0;
        this.url         = '';
        this.depto       = { id: null, nombre:''};
        this.detalle     = [];
        this.cliente     = {id:null , nombre:''}
			},

			mostrarError(mensaje){
        this.alerta   = { activo: true, texto: mensaje , color:'error' }
			}
		}
	}
</script>