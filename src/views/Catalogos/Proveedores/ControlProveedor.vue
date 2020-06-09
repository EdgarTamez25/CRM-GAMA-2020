<template>
	<v-content class="pa-0">
		<v-row justify="center" no-gutters>
			<v-col cols="12">

				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Proveedor':'Editar Proveedor' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" >
						<v-text-field
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del proveedor"
							hide-details
							dense
							filled
							clearable
							v-model="nombre"
						></v-text-field>
					</v-col>

					<v-col cols="12" >
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

					<v-col cols="12" sm="3">
						<v-text-field
							append-icon="phone"
							label="Telefono 1"
							placeholder="Número de contacto 1"
							hide-details
							dense
							filled
							v-model="tel1"
							type="number"
						></v-text-field>
					</v-col>
					<v-col cols="12" sm="3">
						<v-text-field
							append-icon="phone"
							label="Telefono 2"
							placeholder="Número de contacto 2"
							hide-details
							dense
							filled
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

					<v-col cols="12" sm="5">
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

					<v-col cols="12" sm="7">
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

					<v-col cols="12" sm="5">
						<v-select
							:items="['Nacional','Internacional']"
							label="Tipo de Proveedor"
							placeholder="Tipo de proveedor"
							append-icon="gps_fixed"
							dense
							filled
							hide-details
							v-model="tipo_prov"
						></v-select>
					</v-col>

					<v-col cols="12" sm="7">
						<v-text-field
							append-icon="nfc"
							label="RFC"
							placeholder="RFC perteneciente al cliente"
							hide-details
							dense
							filled
							clearable
							v-model="rfc"
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
	</v-content>
	
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
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				// VARIABLES PRINCIPALES
				nombre			: '',
				tipo_prov: '',
				rfc					:	'',
				curp				: '',
				cartera     : '',
				razon_social: '',
				direccion   : '',
				tel1        : '',
				tel2        : '',
				contacto    : '',
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				
				zona				: {id:null , nombre:''},  //Array completo
				zonas				: [],  //Solo nombres 
			}
		},

		created(){
			this.consultarZonas() //MANDO A CONSULTAR ZONAS A MIXINS
			this.validarModoVista() // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PROVEEDORES (GETTERS)
			...mapGetters('Proveedores',['getProveedores']),
		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PROVEEDORES(ACCIONES)
			...mapActions('Proveedores'  ,['consultaProveedores']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					console.log('edit', this.edit)
					this.nombre 			= this.edit.nombre;
					this.direccion    = this.edit.direccion;
					this.razon_social = this.edit.razon_social;
					this.zona         = { id:this.edit.id_zona , nombre: this.edit.nomzona };
					this.tipo_prov    = this.edit.tipo_prov === 1? 'Nacional':'Internacional'
					this.rfc        	= this.edit.rfc;
					this.tel1         = this.edit.tel1;
					this.tel2  				= this.edit.tel2;
					this.contacto     = this.edit.contacto;
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	  	{ this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL CLIENTE"   ; return }
				if(!this.zona.id)	  	{ this.snackbar = true; this.text="No puedes omitir la ZONA" ; return }
				if(!this.tipo_prov)   { this.snackbar = true; this.text="No puedes omitir el TIPO DE PROVEEDOR"; return }
				if(!this.razon_social){ this.snackbar = true; this.text="No puedes omitir la RAZON SOCIAL"; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { nombre			: this.nombre,
													direccion   : this.direccion,
													id_zona	    : this.zona.id,
													tipo_prov 	: this.tipo_prov === 'Nacional'? 1:2,
													rfc					: this.rfc,
													razon_social: this.razon_social,
													tel1        : this.tel1,
													tel2        : this.tel2,
													contacto    : this.contacto,
													estatus     : 1
												}
												console.log('add provedores', payload)
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearProveedor(payload): this.ActualizarProveedor(payload);
			},

			CrearProveedor(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('proveedores', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarProveedor(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('proveedores/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;

				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaProveedores() //ACTUALIZAR CONSULTA DE PROVEEDORES
			},

			limpiarCampos(){
				this.nombre 			= '';
				this.direccion 		= '';
				this.tipo_prov 		= '';
				this.razon_social = '';
				this.rfc 					= '';
				this.curp 				='';
				this.zona = {id:null,nombre:''};
				this.tel1 = '';
				this.tel2 = '';
				this.contacto = '';

			}
		}
	}
</script>