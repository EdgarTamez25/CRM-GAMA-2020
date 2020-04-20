<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Compromiso':'Editar Compromiso' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>

				<v-row>

					<v-col cols="12" sm="6" > <!-- SUCURSALES -->
						<v-select
							v-model="Sucursal" label="Sucursal" placeholder ="Sucursal" 
							dense outlined hide-details color="celeste" append-icon="domain"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6" >  <!-- VENDEDORES -->
						<v-autocomplete
							:items="vendedores" v-model="vendedor" item-text="name" label="Vendedor" 
							dense outlined hide-details color="celeste" append-icon="persons"
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6" > <!-- TIPO DE COMPROMISOS -->
						<v-select
							:items="['Interno','Externo']" v-model="tipo_compromiso" label="Tipo de compromiso" 
							 placeholder ="Tipo de compromiso" outlined dense hide-details append-icon="home_work"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6" > <!-- CATEGORIA -->
						<v-select
							:items="categorias" v-model="Categoria" label="Categoria"  
							 placeholder ="Categorias" outlined dense hide-details append-icon="ballot"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6"> <!-- FECHA DE COMPROMISO -->
						<v-dialog ref="fecha_compromiso" v-model="fechamodal" :return-value.sync="fecha" persistent width="290px">
							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="fecha" label="Fecha de compromiso" append-icon="event" readonly v-on="on"
									outlined dense hide-details color="celeste"
								></v-text-field>
							</template>
							<v-date-picker v-model="fecha" locale="es-es" color="rosa"  scrollable>
								<v-spacer></v-spacer>
								<v-btn text small color="gris" @click="fechamodal = false">Cancelar</v-btn>
								<v-btn dark small color="rosa" @click="$refs.fecha_compromiso.save(fecha)">OK</v-btn>
							</v-date-picker>
						</v-dialog>
					</v-col>

					<v-col cols="11" sm="6"> <!-- HORA DEL COMPROMISO -->
						<v-dialog ref="hora_compromiso" v-model="horamodal" :return-value.sync="hora" persistent width="290px" >

							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="hora" label="Hora del compromiso" append-icon="access_time" readonly v-on="on"
									outlined dense hide-details color="celeste"
								></v-text-field>
							</template>

							<v-time-picker v-if="horamodal" locale="es-es" color="rosa" v-model="hora" full-width 	>
								<v-spacer></v-spacer>
								<v-btn small text color="gris" @click="horamodal = false">Cancel</v-btn>
								<v-btn small dark color="rosa" @click="$refs.hora_compromiso.save(hora)">OK</v-btn>
							</v-time-picker>
						</v-dialog>
					</v-col>

					<v-col cols="12" sm="6" > <!-- CLIENTE -->
						<v-autocomplete
							:items="clientes" v-model="cliente" item-text="name" label="Clientes" 
							dense outlined hide-details color="celeste" append-icon="people"
						></v-autocomplete>
					</v-col>

					<v-col cols="12"  > <!-- COMENARIO -->
						<v-textarea
							v-model ="comentario" filled label="Comentario" placeholder="Agregar un comentario..."
							rows="2" hide-details dense
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
				tipo_compromiso: 'Externo',
				comentario: '',

				// FECHA
				fecha: new Date().toISOString().substr(0, 10),
				menu: false,
				fechamodal: false,
				fecha_compromiso: false,

				// HORA
				hora: null,
        menu2: false,
        horamodal: false,
				hora_compromiso: false,
				
				// AUTOCOMPLETE
				vendedores: [],
				vendedor	: '',
				clientes	: [],
				cliente		: '',

				// SELECTORES
				id_sucursal  : null,
				sucursal     : [],
				sucursales   : [],
				Sucursal     : '',

				id_categoria : null,
				categoria    : [],
				categorias   : [],
				Categoria    : '',
				
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
			this.validarModoVista() 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
			...mapGetters('Productos',['getProductos']),
		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			...mapActions('Productos',['consultaProductos']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
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
					this.obs       			= this.edit.obs
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.codigo)	 { this.snackbar = true; this.text="No puedes omitir el CODIGO DEL PRODUCTO"   ; return }
				if(!this.nombre)	 { this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL USUARIO"   ; return }

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
													tipo_producto: this.tipo_producto === 'Materia Prima'? 1: 2,
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
				this.obs  					= '';
			}
		}
	}
</script>