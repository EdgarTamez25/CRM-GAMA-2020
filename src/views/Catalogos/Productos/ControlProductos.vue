<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>
				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo producto':'Editar producto' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" lg="4" >
						<v-text-field
							append-icon="settings_ethernet"
							label="Codigo"
							placeholder="Codig del producto"
							hide-details
							dense
							clearable
							v-model ="codigo"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="8" >
						<v-text-field
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del producto"
							hide-details
							dense
							clearable
							v-model ="nombre"
						></v-text-field>
					</v-col>

					<v-col cols="12" >
						<v-textarea
							outlined
							label="Descripción"
							placeholder="Escriba la descripción del producto..."
							rows="3"
							hide-details
							dense
							v-model ="descripcion"
						></v-textarea>
					</v-col>

					<v-col cols="12" lg="6" >
						<v-text-field
							append-icon=""
							label="Cantidad"
							placeholder="Cantidad"
							hide-details
							dense
							clearable
							v-model ="cantidad"
							type="number"
						></v-text-field>
					</v-col>

					<!-- <v-col cols="12" lg="6">
						<v-select
							:items="['Materia Prima','Producto Final']"
							label="Tipo de Producto"
							placeholder="Tipo de producto"
							append-icon="category"
							dense
							hide-details
							clearable
							v-model="tipo_producto"
						></v-select>
					</v-col> -->

					<v-col cols="12" lg="6">
						<v-select
							:items="unidades"
							label="Unidades"
							placeholder="Unidad"
							append-icon="square_foot"
							dense
							hide-details
							clearable
							v-model="Unidad"
						></v-select>
					</v-col>

						<v-col cols="12" lg="6">
						<v-select
							:items="lineas"
							label="Lineas"
							placeholder="Linea"
							append-icon="style"
							hide-details
							clearable
							v-model="Linea"
							dense
						></v-select>
					</v-col>
<!-- 
					<v-col cols="12" lg="6" >
						<v-file-input
							label="Imagen"
							prepend-icon="mdi-camera"
							hide-details
							dense
							v-model="foto"
						></v-file-input>
					</v-col> -->

					<v-col cols="12" >
						<v-textarea
							filled
							label="Observaciones"
							placeholder="Observaciones del producto..."
							rows="2"
							hide-details
							dense
							v-model ="obs"
						></v-textarea>
					</v-col>

				</v-row>

				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="param === 1">
             Confirmar  
          </v-btn>
					<v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-else>
             Actualizar  
          </v-btn>

          <v-dialog v-model="dialog" hide-overlay persistent width="300">
            <v-card color="blue darken-4" dark >
              <v-card-text> <th style="font-size:17px;" align="center">{{ textDialog }}</th>
                <br>
                <v-progress-linear indeterminate color="white" class="mb-0" persistent></v-progress-linear>
              </v-card-text>
            </v-card>
          </v-dialog>

					<v-dialog v-model="Correcto" hide-overlay persistent width="350">
            <v-card color="success"  dark class="pa-3">
							<h3><strong>{{ textCorrecto }} </strong></h3>
            </v-card>
						
          </v-dialog>
				</v-card-actions>

			</v-col>
		</v-row>
	</v-container>
	
</template>

<script>
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex'
	
	export default {
		mixins:[SelectMixin],
	  components: {
		},
		props:[
			'param',
			'edit',
	  ],
	  data () {
			return {
				// VARIABLES PRINCIPALES
				codigo       : '',
				nombre		   : '',
				descripcion  : '',
				foto         : '',
				tipo_producto: '',
				obs          : '',
				cantidad     : 0 , 

				// SELECTORES
				id_linea  : 0,
				linea     : [],
				lineas    : [],
				Linea     : '',

				id_proveedor  : 0,
				proveedor     : [],
				proveedores   : [],
				Proveedor     : '',

				id_unidad  : 0,
				unidad     : [],
				unidades   : [],
				Unidad     : '',
				
				// ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',
			}
		},
		
		created(){
			this.consultarLineas() 			//MANDO A CONSULTAR SUCURSALES A MIXINS
			this.consultarProveedores() //MANDO A CONSULTAR PROVEEDORES A MIXINS
			this.consultarUnidades() 		//MANDO A CONSULTAR UNIDADES A MIXINS
			this.validarModoVista() 	  // VALIDO EL MODO DE LA VISTA

		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
			...mapGetters('Productos',['getProductos']),
		},

		watch:{
			edit: function(){
				this.validarModoVista();
			},

			foto: function(){
				console.log('foto', this.foto)
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			...mapActions('Productos',['consultaProductos']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					console.log('edit', this.edit)
					this.codigo 				= this.edit.codigo
					this.nombre 				= this.edit.nombre
					this.descripcion 	  = this.edit.descripcion
					this.id_linea       = this.edit.id_linea
					this.Linea 					= this.edit.nomlin
					this.tipo_producto  = this.edit.tipo_producto === 1 ? 'Materia Prima' :'Producto Final'
					this.id_proveedor   = this.edit.id_proveedor
					this.Proveedor 			= this.edit.nomprov
					this.id_unidad      = this.edit.id_unidad
					this.Unidad         = this.edit.nomunidad
					this.cantidad       = this.edit.cantidad
					this.obs       			= this.edit.obs
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.codigo)	 { this.snackbar = true; this.text="No puedes omitir el CODIGO DEL PRODUCTO"   ; return }
				if(!this.nombre)	 { this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL USUARIO"   ; return }
				if(!this.cantidad) { this.snackbar = true; this.text="No puedes omitir la CANTIDAD"   ; return }
				if(!this.Unidad)	 { this.snackbar = true; this.text="No puedes omitir la UNIDAD"   ; return }


				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { codigo      : this.codigo,
													nombre	    : this.nombre,
													descripcion	: this.descripcion,
													id_linea 		: this.id_linea,
													id_proveedor: this.id_proveedor,
													id_unidad	  : this.id_unidad,
													cantidad    : this.cantidad,
													// tipo_producto: this.tipo_producto === 'Materia Prima'? 1: 2,
													tipo_producto: 1,
													obs         : this.obs ? this.obs : '',
													foto        : '',
													estatus     : 1
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearProducto(payload): this.ActualizarProducto(payload);
			},

			CrearProducto(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('productos', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarProducto(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('productos/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaProductos() //ACTUALIZAR CONSULTA DE CLIENTES
			},

			limpiarCampos(){
				this.codigo    			= '';
				this.nombre    			= '';
				this.descripcion  	= '',
				this.Linea     			= '',
				this.tipo_producto  = '',
				this.Proveedor		  = '';
				this.Unidad 		    = '';
				this.cantidad       = 0 ;
				this.obs  					= '';
			}
		}
	}
</script>