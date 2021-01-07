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
					<!-- NOMBRE DEL PROVEEDOR -->
					<v-col cols="12" >
						<v-text-field
							v-model="nombre" label="Nombre" placeholder="Nombre del proveedor" append-icon="person"
							hide-details dense filled
						></v-text-field>
					</v-col>
					<!-- NOMBRE DEL RA<ON SOCIAL -->
					<v-col cols="12" >
						<v-text-field
							v-model="razon_social" label="Razon Social" placeholder="Razon Social" append-icon="domain"
							hide-details 	dense filled
						></v-text-field>
					</v-col>
					<!-- DIRECCION -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="direccion" label="Dirección" placeholder="Dirección" append-icon="person_pin_circle"
							hide-details dense filled
						></v-text-field>
					</v-col>
					<!-- CIUDAD -->
					<v-col cols="12" sm="6">
						<v-autocomplete
							:items="ciudades" v-model="ciudad" item-text="nombre" item-value="id" label="Ciudades" placeholder="Ciudad"
							dense filled hide-details return-object color="celeste" append-icon="location_city"
						></v-autocomplete>
					</v-col>
					<!-- CODIGO POSTAL -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="cp" label="Código Postal" placeholder="C.P." append-icon="where_to_vote"
							hide-details dense filled type="number"
						></v-text-field>
					</v-col>
					<!-- TIPO DE PROVEEDOR -->
					<v-col cols="12" sm="6">
						<v-select
							v-model="tipo_prov" :items="['Nacional','Internacional']"
							label="Tipo de Proveedor" placeholder="Tipo de proveedor" append-icon="gps_fixed" 
							dense filled hide-details
						></v-select>
					</v-col>
					<!-- RFC DEL PROVEEDOR -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="rfc" label="RFC" placeholder="RFC perteneciente al cliente" append-icon="nfc"
							hide-details dense filled
						></v-text-field>
					</v-col>
					<v-col cols="12" sm="6" />
					<!--  TELEFONO 1 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="tel1" label="Telefono 1" placeholder="Número de contacto 1" append-icon="phone"
							hide-details dense outlined type="number"
						></v-text-field>
					</v-col>
					<!-- EXTENCION 1 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="ext1" label="Extención 1" placeholder="Extención 1" append-icon="settings_phone"
							hide-details dense outlined type="number"
						></v-text-field>
					</v-col>
					<!--  TELEFONO 2 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="tel2" label="Telefono 2" placeholder="Número de contacto 2" append-icon="phone"
							hide-details dense outlined type="number"
						></v-text-field>
					</v-col>
					<!-- EXTENCION 2 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="ext2" label="Extención 2" placeholder="Extención 2" append-icon="settings_phone"
							hide-details dense outlined Type="number"
						></v-text-field>
					</v-col>
					<!--  CONTACTO 1 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="contacto" label="Contacto 1" Placeholder="Contacto 1" append-icon="email"
							hide-details dense outlined
						></v-text-field>
					</v-col>
					<!--  CONTACTO 2 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="contacto2" label="Contacto 2" placeholder="Contacto 2" append-icon="email"
							hide-details dense outlined
						></v-text-field>
					</v-col>
					<!-- <v-col cols="12" sm="5">
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
					</v-col> -->
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
				cp          : '',
				tel1        : '',
				ext1				: '',
				tel2        : '',
				ext2				: '',
				contacto    : '',
				contacto2    : '',
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				
				zona				: {id:null , nombre:''},  //Array completo
				zonas				: [],  //Solo nombres 
				ciudad     : {id:null,nombre:''},
				ciudades    : [],
			}
		},

		created(){
			this.consultarZonas() //MANDO A CONSULTAR ZONAS A MIXINS
			this.consultarCiudades()
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
					this.nombre 			= this.edit.nombre;
					this.direccion    = this.edit.direccion;
					this.razon_social = this.edit.razon_social;
					this.zona         = { id:this.edit.id_zona , nombre: this.edit.nomzona };
					this.tipo_prov    = this.edit.tipo_prov === 1? 'Nacional':'Internacional'
					this.ciudad       = { id:this.edit.id_ciudad , nombre: this.edit.ciudad };
					this.rfc        	= this.edit.rfc;
					this.tel1         = this.edit.tel1;
					this.ext1 				= this.edit.ext1;
					this.tel2 				= this.edit.tel2;
					this.ext2 				= this.edit.ext2;
					this.cp    				= this.edit.cp;
					this.contacto     = this.edit.contacto;
					this.contacto2    = this.edit.contacto2;
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	  	{ this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL CLIENTE"   ; return }
				// if(!this.zona.id)	  	{ this.snackbar = true; this.text="No puedes omitir la ZONA" ; return }
				if(!this.razon_social){ this.snackbar = true; this.text="No puedes omitir la RAZON SOCIAL"; return }
				if(!this.direccion)	  { this.snackbar = true; this.text="No puedes omitir la DIRECCIÓN"   ; return }
				if(!this.ciudad.id)	  { this.snackbar = true; this.text="No puedes omitir la CIUDAD"   ; return }
				if(!this.cp)	  { this.snackbar = true; this.text="No puedes omitir el Codigo Postal"   ; return }
				if(!this.tipo_prov)   { this.snackbar = true; this.text="No puedes omitir el TIPO DE PROVEEDOR"; return }
				if(!this.tel1)	      { this.snackbar = true; this.text="Debes de ingresar al menos un telefono"	; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { nombre			: this.nombre,
													direccion   : this.direccion,
													id_ciudad   : this.ciudad.id,
													cp 					: this.cp,
													// id_zona	    : this.zona.id,
													id_zona	    : 0,
													tipo_prov 	: this.tipo_prov === 'Nacional'? 1:2,
													rfc					: this.rfc,
													razon_social: this.razon_social,
													tel1        : this.tel1,
													ext1        : this.ext1,
													tel2        : this.tel2,
													ext2        : this.ext2,
													contacto    : this.contacto,
													contacto2    : this.contacto2,
													estatus     : 1
												}
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
				this.zona 				= {id:null,nombre:''};
				this.ciudad 			= {id:null,nombre:''};
				this.cp 					= '';
				this.tel1 				= '';
				this.ext1					= '';
				this.tel2 				= '';
				this.ext2					= '';
				this.contacto 		= '';
				this.contacto2 		= '';


			}
		}
	}
</script>