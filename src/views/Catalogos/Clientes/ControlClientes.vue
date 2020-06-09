<template>
	<v-content class="pa-0">
		<v-row justify="center" no-gutters>
			<v-col cols="12">
				
				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Cliente':'Editar Cliente' }}  </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" >
						<v-text-field
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del cliente"
							hide-details
							dense
							filled
							clearable
							v-model="nombre"
						></v-text-field>
					</v-col>

					<v-col cols="12">
						<v-text-field
							append-icon="domain"
							label="Razon Social"
							placeholder="Razon Social"
							hide-details
							dense
							filled
							clearable
							v-model="razon_social"
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="person_pin_circle"
							label="Dirección"
							placeholder="Dirección"
							hide-details
							dense
							filled
							clearable
							v-model="direccion"
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-select
							:items="zonas"
							item-text="nombre"
							item-value="id"
							return-object
							label="Zona"
							placeholder="Zona del cliente"
							append-icon="pin_drop"
							dense
							filled
							hide-details
							v-model="zona"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6">
						<v-select
							:items="['Nacional','Internacional']"
							label="Tipo de Cliente"
							placeholder="Tipo de cliente"
							append-icon="gps_fixed"
							dense
							filled
							hide-details
							v-model="tipo_cliente"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6">
						<v-select
							:items="niveles"
							item-value="id"
							item-text="nombre"
							label="Nivel del cliente"
							placeholder="Tipo de cliente"
							append-icon="how_to_reg"
							dense
							filled
							hide-details
							v-model="nivel"
							return-object
						></v-select>
					</v-col>
					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="recent_actors"
							label="RFC"
							placeholder="RFC perteneciente al cliente"
							hide-details
							dense
							filled
							clearable
							v-model="rfc"
						></v-text-field>
					</v-col>
					<v-col cols="12" sm="6">
						<v-select
							:items="carteras"
							item-text ="nombre"
							item-value ="id"
							return-object
							label="Carteras"
							placeholder="Cartera al que pertenece el cliente"
							append-icon="folder_shared"
							dense
							filled
							hide-details
							clearable
							v-model="cartera"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="phone"
							label="Telefono 1"
							placeholder="Número de contacto 1"
							hide-details
							dense
							filled
							clearable
							v-model="tel1"
							type="number"
						></v-text-field>
					</v-col>
					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="phone"
							label="Telefono 2"
							placeholder="Número de contacto 2"
							hide-details
							dense
							filled
							clearable
							v-model="tel2"
							type="number"
						></v-text-field>
					</v-col>
					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="email"
							label="Email"
							placeholder="Correo de contacto"
							hide-details
							dense
							filled
							clearable
							v-model="contacto"
						></v-text-field>
					</v-col>
					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="insert_drive_file"
							label="Dias limite de factura"
							placeholder="Días limite de factura"
							hide-details
							dense
							filled
							clearable
							v-model="diasFact"
							type="number"
						></v-text-field>
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
	</v-content >
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
				titleModal: 'Clientes',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				// VARIABLES PRINCIPALES
				nombre			: '',
				tipo_cliente: '',
				rfc					:	'',
				cartera     : '',
				nivel       : {id:null, nombre:''},
				niveles     : [{id:1 , nombre:'A'},{id:2,nombre:'AA'},{id:3,nombre:'AAA'}],
				razon_social: '',
				direccion   : '',
				tel1        : '',
				tel2        : '',
				contacto    : '',
				diasFact    : 0 ,
			
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				// SELECTORES
				zona				: {id:null , nombre:''},  //Array completo
				zonas				: [],  //Solo nombres 
				cartera     : {id:null,nombre:''},
				carteras    : [],
				}
		},

		created(){
			this.consultarZonas() //MANDO A CONSULTAR ZONAS A MIXINS
			this.consultarCarteras() //MANDO A CONSULTAR CARTERAS A MIXINS
			this.validarModoVista() // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			...mapGetters('Clientes'  ,['getClientes']),
		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
			...mapActions('Clientes'  ,['consultaClientes']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 			= this.edit.nombre;
					this.direccion    = this.edit.direccion;
					this.razon_social = this.edit.razon_social;
					this.Zonas 				= this.edit.nomzona; 
					this.tipo_cliente = this.edit.tipo_cliente === 1? 'Nacional':'Internacional'
					this.rfc        	= this.edit.rfc;
					this.cartera      = { id:this.edit.id_cartera, nombre: this.nomcartera };
					this.zona         = { id:this.edit.id_zona   , nombre: this.edit.nomzona };
					this.nivel 				= this.niveles[this.edit.nivel];
					this.tel1 				= this.edit.tel1;
					this.tel2 				= this.edit.tel2;
					this.contacto     = this.edit.contacto;
					this.diasFact     = this.edit.diasfact
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	  	{ this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL CLIENTE"   ; return }
				if(!this.razon_social){ this.snackbar = true; this.text="No puedes omitir la RAZON SOCIAL"; return }
				if(!this.zona.id)	  	{ this.snackbar = true; this.text="No puedes omitir la ZONA" ; return }
				if(!this.tipo_cliente){ this.snackbar = true; this.text="No puedes omitir el TIPO DE CLIENTE"; return }
				if(!this.nivel)				{ this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				if(!this.rfc)	        { this.snackbar = true; this.text="No puedes omitir el RFC"	; return }
				if(!this.tel1)	      { this.snackbar = true; this.text="Debes de ingresar al menos un telefono"	; return }
				if(!this.diasFact)	  { this.snackbar = true; this.text="No puedes omitir los DIAS LIMITES DE FACTURACIÓN"	; return }
				this.PrepararPeticion() // MANDO A FORMAR EL OBJETO PARA GUARDAR
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { nombre			: this.nombre,
													direccion   : this.direccion,
													id_zona			: this.zona.id,
													tipo_cliente: this.tipo_cliente === 'Nacional'? 1:2,
													rfc					: this.rfc,
													id_cartera	: this.cartera.id,
													fuente      : 1 ,
													nivel       : this.nivel.id,
													razon_social: this.razon_social,
													tel1				: this.tel1,
													tel2				: this.tel2,
													contacto		: this.contacto,
													diasfact		: this.diasFact,
													estatus     : 1
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearCliente(payload): this.ActualizarCliente(payload);
			},

			CrearCliente(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('cliente', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				}).catch(err =>{
					console.log('err',err)
				})
			},

			ActualizarCliente(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('cliente/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;

				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaClientes() //ACTUALIZAR CONSULTA DE CLIENTES
			},

			limpiarCampos(){
				this.nombre = '';
				this.direccion = '',
				this.tipo_cliente = '';
				this.nivel = '';
				this.razon_social = '';
				this.rfc = '';
				this.nivel = {id:null,nombre:''};
				this.zona = {id:null,nombre:''};
				this.cartera = {id:null,nombre:''};
				this.tel1 = '';
				this.tel2 = '';
				this.contacto = '';
				this.diasFact = 0;
			}
		}
	}
</script>