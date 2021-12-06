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

      <v-col cols="12" class="" v-if="Loading">
        <loading/>
      </v-col>

      <template v-else>
        <v-col cols="12" sm="6">
          <v-autocomplete
            v-model="editarItem.cliente" :items="clientes" item-text="nombre" item-value="id" label="Clientes" 
            dense filled hide-details color="celeste" return-object clearable
            :disabled="modoVista === 3? true:false"
          ></v-autocomplete>
        </v-col>

        <v-col cols="12" sm="6">
          <v-text-field
            v-model="editarItem.nombre" label="Nombre" placeholder="Nombre del producto"
            hide-details dense filled clearable
          ></v-text-field>
        </v-col>

        <v-col cols="12" sm="6">
          <v-text-field
            v-model="editarItem.codigo" label="Codigo" placeholder="Codigo de producto"
            hide-details dense filled clearable
          ></v-text-field>
        </v-col>

        <v-col cols="12" sm="6">
          <v-autocomplete
            v-model="editarItem.unidad" :items="unidades"  item-text="nombre" item-value="id" label="Unidad" 
            dense filled hide-details color="celeste" return-object clearable 
          ></v-autocomplete>
        </v-col>

        <v-col cols="12" >
          <v-textarea
            v-model="editarItem.descripcion" label="Descripción del producto" filled hide-details dense  clearable rows="2"
          ></v-textarea>
        </v-col>

        <v-col cols="12" sm="3">
          <v-text-field
            v-model.number="editarItem.revision" label="Revision" placeholder="Revision" 
            hide-details dense filled clearable type="number"
          ></v-text-field>
        </v-col>

        <v-col cols="9">
          <v-text-field
            v-model="editarItem.url" label="URL" placeholder="Direccion de ficha" 
            hide-details dense filled clearable 
          ></v-text-field>
        </v-col>
        

        <v-col cols="12" > 
          <v-select
              v-model="editarItem.depto" :items="deptos" item-text="nombre" item-value="id" outlined color="celeste" 
              dense hide-details  label="Departamentos" return-object placeholder ="Departamentos" :disabled="modoVista === 3? true:false"
          ></v-select>
        </v-col> 

        <v-col cols="12" class="text-right" >
          <v-btn color="green" dark  @click="validarInfomracion()">{{ modoVista === 1 ? 'CREAR PRODUCTO': 'ACTUAIZAR PRODUCTO' }}</v-btn>
        </v-col>
      </template>


		<overlay v-if="overlay"/>

    </v-row>
  </v-main>
</template>

<script>
	import  metodos from '@/mixins/metodos.js';
  import {mapGetters, mapActions} from 'vuex'
  import overlay from '@/components/overlay.vue'
  import loading from '@/components/loading.vue'

	export default {
		mixins:[metodos],
	  components: {
      overlay,
      loading
		},
		props:[
			'modoVista',
      'parametros',
      'modalDDD',
      'Vista'
	  ],
	  data () {
			return {
        defaultItem:{
          nombre : '',
          codigo : '',
          descripcion: '',
          revision: 0,
          url: '', 
          fecha: new Date().toISOString().substr(0, 10),
          depto  : { id: null, nombre:''},
          cliente: { id:null , nombre:''},
          unidad : { id:null , nombre:''}
        },
        editarItem:{},

				// AUTOCOMPLETE
				clientes	: [],
        deptos    : [],
        unidades  :[],
        detalle: [],

        // ALERTAS
        overlay: false,
        Loading: false,
				alerta: { activo: false, texto:'', color:'error' },
        alertaFormulario: false
			}
		},
		
		async created(){
      this.clientes = await this.consultar_Clientes();
      this.deptos   = await this.consultaDepartamentos();
      this.unidades = await this.consulta_unidades();
			this.validarModoVista() 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
      // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('ProductosxCliente' ,['Loading','getProductosxCli']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
      ...mapGetters('Login'    ,['getdatosUsuario']), 

      // GUARDAR_PRODUCTO(){
      //   return Object.keys(this.detalle).length > 0 ? true: false;
      // }
		},

		watch:{ 
      parametros(){ 
        this.Loading = true;
        this.validarModoVista(); 
      },
    },

		methods:{
      ...mapActions('ProductosxCliente',['consultaProductosxCliente']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
      
			async validarModoVista(){
        if(this.modoVista === 3){
            // ASIGNAR VALORES AL FORMULARIO
            this.editarItem = { 
              ...this.parametros,
              depto  : { id: this.parametros.dx },
              cliente: { id: this.parametros.id_cliente},
              unidad : { id: this.parametros.id_unidad }
            }
            this.Loading = false;
        }else{
          this.limpiarCampos();
          this.Loading = false;
        }


			},

			validarInfomracion(){
				if(!this.editarItem.cliente.id) { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL CLIENTE' , color:'error' }; return }
				if(!this.editarItem.codigo)	    { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL CÓDIGO'  , color:'error' }; return }
				if(!this.editarItem.unidad.id)	{ this.alerta = { activo: true, texto:'NO PUEDES OMITIR LA UNIDAD'  , color:'error' }; return }
        if(!this.editarItem.url)			  { this.alerta = { activo: true, texto:'DEBES AGREGAR LA DIRECCION DE LA FICHA TECNICA', color:'error' }; return }
        if(!this.editarItem.depto.id)	  { this.alerta = { activo: true, texto:'DEBES SELECCIONAR UN DEPARTAMENTO'             , color:'error' }; return }
        // if(this.depto.id === 1 && !this.detalle )   {this.alerta   = { activo: true, texto:'NO HAZ GUARDADO LAS CARACTERISTICAS DEL PRODUCTO', color:'error' }; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
        // FORMAR ARRAY A MANDAR
        const producto = { 
          id_cliente : this.editarItem.cliente.id,
          nombre     : this.editarItem.nombre ? this.editarItem.nombre: '',
          codigo     : this.editarItem.codigo ? this.editarItem.codigo: '',
          id_unidad  : this.editarItem.unidad.id,
          descripcion: this.editarItem.descripcion ? this.editarItem.descripcion : '',
          revision   : this.editarItem.revision ? this.editarItem.revision : 0,
          url        : this.editarItem.url ? this.editarItem.url : '',
          dx         : this.editarItem.depto.id,
          detalle    : this.detalle ? this.detalle : [],
          id_usuario : this.getdatosUsuario.id
        };

        console.log('producto', producto);
              
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.modoVista === 1 ? this.Crear(producto): this.Actualizar(producto);
			},

			Crear(producto){
        this.overlay = true ; 
				this.$http.post('crear.producto.cliente', producto).then((response)=>{
          this.alerta = { activo: true, texto: response.bodyText , color:'success' };
					this.TerminarProceso();					
				}).catch(error =>{
				  this.alerta = { activo: true, texto: error.bodyText , color:'error' };
				}).finally(() => this.overlay = false) 
			},

			Actualizar(producto){
				this.overlay = true ; 
				this.$http.put('actualiza.producto.cliente/'+ this.parametros.id, producto).then((response)=>{
          this.alerta = { activo: true, texto: response.bodyText , color:'success' };
					this.TerminarProceso();					
				}).catch(error =>{
          this.alerta = { activo: true, texto: error.bodyText , color:'error' };
				}).finally(() => this.overlay = false)
			},
	
			TerminarProceso(){
        var that = this ;
				this.limpiarCampos();  
        this.consultaProductosxCliente(this.parametros.id_cliente) 
        setTimeout(() => { that.$emit('modal',false)}, 2000);
        
			},

			limpiarCampos(){
        this.editarItem = this.defaultItem; 
			},
		}
	}
</script>