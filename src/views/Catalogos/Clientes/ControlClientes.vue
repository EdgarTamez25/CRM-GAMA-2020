<template>
	<v-content class="pa-0">
		<v-row justify="center" no-gutters>
			<v-col cols="12">
				
				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 2 || param ===3 ? 'Editar Cliente':'Nuevo Cliente' }}  </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<!-- NOMBRE DEL CLIENTE -->
					<v-col cols="12" >
						<v-text-field
							v-model="nombre" label="Nombre" placeholder="Nombre del cliente" append-icon="person"
							hide-details dense filled
						></v-text-field>
					</v-col>
					<!-- RAZON SOCIAL -->
					<v-col cols="12">
						<v-text-field
							v-model="razon_social" label="Razon Social" placeholder="Razon Social" append-icon="domain"
							hide-details dense filled 
						></v-text-field>
					</v-col>
					<!-- DIRECCION DEL CLIENTE -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="direccion" label="Dirección" placeholder="Calle #000, Colonia" append-icon="person_pin_circle"
							hide-details dense filled
						></v-text-field>
					</v-col>
					<!--  CIUDADES -->
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

					<!-- <v-col cols="12" sm="6">
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

					<!-- TIPO DE CLIENTE -->
					<v-col cols="12" sm="6">
						<v-select
							v-model="tipo_cliente" :items="['Nacional','Internacional']" label="Tipo de Cliente" placeholder="Tipo de cliente"
							append-icon="gps_fixed" dense filled hide-details
						></v-select>
					</v-col>
					<!-- NIVEL DEL CLIENTE -->
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
					<!-- RFC DEL CLIENTE -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="rfc" label="RFC" placeholder="RFC perteneciente al cliente" append-icon="recent_actors"
							hide-details 	dense filled
						></v-text-field>
					</v-col>
					<!--  DIAS DE FACTURACION -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="diasFact" label="Dias limite de factura" placeholder="Días limite de factura"	append-icon="insert_drive_file"
							hide-details dense filled	type="number"
						></v-text-field>
					</v-col>
					
					<v-col cols="12" sm="6" />
					<!-- <v-col cols="12" sm="6">
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
							v-model="cartera"
						></v-select>
					</v-col> -->

					<!-- TELEFONO 1 DEL CLIENTE -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="tel1" label="Telefono 1" placeholder="Número de contacto 1" append-icon="phone"
							hide-details dense 	outlined type="number"
						></v-text-field>
					</v-col>
					<!-- EXTENCION 1 -->
					<v-col cols="12" sm="6">
						<v-text-field
							v-model="ext1" label="Extención 1" placeholder="Extención 1" append-icon="settings_phone"
							hide-details dense outlined type="number"
						></v-text-field>
					</v-col>
					<!-- TELEFONO 2 -->
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
				</v-row>

				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="param === 1">
             Confirmar  
          </v-btn>
					<v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-else>
             {{ param === 2 ?'Actualizar':'Pasar a cliente'}}  
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
				cp          : '',
				tel1        : '',
				ext1        : '',
				tel2        : '',
				ext2				: '',
				contacto    : '',
				contacto2    : '',
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
				ciudad     : {id:null,nombre:''},
				ciudades    : [],
				}
		},

		created(){
			this.consultarZonas() //MANDO A CONSULTAR ZONAS A MIXINS
			this.consultarCarteras() //MANDO A CONSULTAR CARTERAS A MIXINS
			this.consultarCiudades()
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
			...mapActions('Clientes'    ,['consultaClientes']),
			...mapActions('Prospectos'  ,['consultaProspectos']),

			validarModoVista(){
				if(this.param === 2 || this.param == 3){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 			= this.edit.nombre;
					this.direccion    = this.edit.direccion;
					this.cp    = this.edit.cp;
					this.razon_social = this.edit.razon_social;
					this.Zonas 				= this.edit.nomzona; 
					this.tipo_cliente = this.edit.tipo_cliente === 1? 'Nacional':'Internacional'
					this.rfc        	= this.edit.rfc;
					this.cartera      = { id:this.edit.id_cartera, nombre: this.nomcartera };
					this.zona         = { id:this.edit.id_zona   , nombre: this.edit.nomzona };
					this.ciudad       = { id:this.edit.id_ciudad , nombre: this.edit.ciudad };
					this.nivel 				= this.niveles[this.edit.nivel -1];
					this.tel1 				= this.edit.tel1;
					this.ext1 				= this.edit.ext1;
					this.tel2 				= this.edit.tel2;
					this.ext2 				= this.edit.ext2;
					this.contacto     = this.edit.contacto;
					this.contacto2    = this.edit.contacto2;
					this.diasFact     = this.edit.diasfact
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	  	{ this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL CLIENTE"   ; return }
				if(!this.direccion)	  { this.snackbar = true; this.text="No puedes omitir la DIRECCIÓN"   ; return }
				if(!this.ciudad.id)	  { this.snackbar = true; this.text="No puedes omitir la CIUDAD"   ; return }
				if(!this.cp)	  { this.snackbar = true; this.text="No puedes omitir el Codigo Postal"   ; return }
				// if(!this.razon_social){ this.snackbar = true; this.text="No puedes omitir la RAZON SOCIAL"; return }
				// if(!this.zona.id)	  	{ this.snackbar = true; this.text="No puedes omitir la ZONA" ; return }
				if(!this.tipo_cliente){ this.snackbar = true; this.text="No puedes omitir el TIPO DE CLIENTE"; return }
				if(!this.nivel.id)	  { this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				if(!this.rfc)	        { this.snackbar = true; this.text="No puedes omitir el RFC"	; return }
				if(!this.tel1)	      { this.snackbar = true; this.text="Debes de ingresar al menos un telefono"	; return }
				// if(!this.diasFact)	  { this.snackbar = true; this.text="No puedes omitir los DIAS LIMITES DE FACTURACIÓN"	; return }
				this.PrepararPeticion() // MANDO A FORMAR EL OBJETO PARA GUARDAR
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { nombre			: this.nombre,
													direccion   : this.direccion,
													id_ciudad   : this.ciudad.id,
													cp    			: this.cp,
													id_zona			: this.zona.id,
													tipo_cliente: this.tipo_cliente === 'Nacional'? 1:2,
													rfc					: this.rfc,
													id_cartera	: this.cartera.id,
													fuente      : 1 ,
													nivel       : this.nivel.id,
													razon_social: this.razon_social,
													tel1				: this.tel1,
													ext1				: this.ext1,
													tel2				: this.tel2,
													ext2				: this.ext2,
													contacto		: this.contacto,
													contacto2		: this.contacto2,
													diasfact		: this.diasFact,
													estatus     : 1,
													prospecto   : 0
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearCliente(payload): this.ActualizarCliente(payload);
			},

			CrearCliente(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; setTimeout(() => (this.dialog = false), 2000)
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
				this.consultaClientes();
				this.consultaProspectos() //ACTUALIZAR CONSULTA DE CLIENTES
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
				this.ciudad = {id:null,nombre:''};
				this.cp 	= '';
				this.tel1 = '';
				this.ext1 = '';
				this.tel2 = '';
				this.ext2 = '';
				this.contacto = '';
				this.contacto2 = '';
				this.diasFact = 0;
			}
		}
	}
</script>