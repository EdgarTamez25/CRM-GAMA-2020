<template>
	<v-content class="pa-0">
		<v-row justify="center" no-gutters>
			<v-col cols="12">
				
				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo prospecto':'Editar prospecto' }}  </strong></h3> 
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
							placeholder="Nivel del cliente"
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
							append-icon="phone"
							label="Telefono "
							placeholder="Telefono"
							hide-details
							dense
							filled
							clearable
							v-model.number="tel1"
							type="number"
						></v-text-field>
					</v-col>
					
					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="contact_mail"
							label="Contacto"
							placeholder="Contacto"
							hide-details
							dense
							filled
							clearable
							v-model="contacto"
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
	// import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex'
	export default {
		// mixins:[SelectMixin],
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
				tipo_cliente: '',
				nivel       : {id:null, nombre:''},
				niveles     : [{id:1 , nombre:'A'},{id:2,nombre:'AA'},{id:3,nombre:'AAA'}],
				tel1        : '',
				contacto    : '',
			
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				
				}
		},

		created(){
			this.validarModoVista() // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			...mapGetters('Prospectos'  ,['Loading','getProspectos']), // IMPORTANDO USO DE VUEX - Prospectos (GETTERS)
			...mapGetters('Usuarios'    ,['getUsuarios']), // IMPORTANDO USO DE VUEX - Prospectos (GETTERS)
		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			...mapActions('Prospectos'  ,['consultaProspectos']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 			= this.edit.nombre;
					this.tipo_cliente = this.edit.tipo_cliente === 1? 'Nacional':'Internacional'
					this.nivel 				= this.niveles[this.edit.nivel -1];
					this.tel1 				= this.edit.tel1;
					this.contacto     = this.edit.contacto;
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	  	{ this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL CLIENTE"   ; return }
				if(!this.tipo_cliente){ this.snackbar = true; this.text="No puedes omitir el TIPO DE CLIENTE"; return }
				if(!this.nivel)				{ this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				if(!this.tel1)	      { this.snackbar = true; this.text="Debes de ingresar al menos un telefono"	; return }
				this.PrepararPeticion() // MANDO A FORMAR EL OBJETO PARA GUARDAR
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { fuente : 1,
												  nombre			: this.nombre,
													tipo_cliente: this.tipo_cliente === 'Nacional'? 1:2,
													nivel       : this.nivel.id,
													tel1				: this.tel1,
													contacto		: this.contacto,
													prospecto   : 1,
													estatus     : 1
													// ubicacion   :''
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.Crear(payload): this.Actualizar(payload);
			},

			Crear(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('add.prospecto', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				}).catch(err =>{
					console.log('err',err)
				})
			},

			Actualizar(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('update.prospecto/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;

				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaProspectos(this.getUsuarios.id) //ACTUALIZAR CONSULTA DE CLIENTES
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