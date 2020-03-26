<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>
				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Usuario':'Editar Usuario' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" lg="8">
						<v-text-field
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del usuario"
							hide-details
							dense
							clearable
							v-model ="nombre"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="4" class="text-right">
						<v-avatar size="90px" tile  v-if="foto"> 
							<v-img :src="foto" aspect-ratio="10" contain max-height="200px" min-height="200px" ></v-img>
						</v-avatar>

						<v-avatar size="90px" v-else> 
							<v-img src="persona.jpg" aspect-ratio="10" contain max-height="200px" min-height="200px" ></v-img>
						</v-avatar>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="email"
							label="Correo"
							placeholder="Correo electronico"
							hide-details
							dense
							clearable
							v-model="correo"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="['Administrador','Supervisor','Vendedor']"
							label="Nivel"
							placeholder="Nivel de acceso"
							append-icon="show_chart"
							dense
							hide-details
							clearable
							v-model="nivel"
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="sucursales"
							label="Sucursal"
							placeholder="Sucursal"
							append-icon="store"
							dense
							hide-details
							clearable
							v-model="Sucursal"
						></v-select>
					</v-col>

					<template v-if="param === 1">
						<v-col cols="12" lg="6"/>
						<v-col cols="12" lg="6">
							<v-text-field
								v-model="password"
								:append-icon="show1 ? 'visibility_off' : 'visibility'"
								:type="show1 ? 'text' : 'password'"
								placeholder="Contraseña de usuario"
								filled
								label="Contraseña"
								dense
								clearable
								hide-details
								@click:append="show1 = !show1"
							></v-text-field>
						</v-col>

						<v-col cols="12" lg="6">
							<v-text-field
								v-model="password2"
								:append-icon="show2 ? 'visibility_off' : 'visibility'"
								:type="show2 ? 'text' : 'password'"
								label=" Confirmar "
								placeholder="Confirmar Contraseña "
								filled
								clearable
								dense
								hide-details
								@click:append="show2 = !show2"
							></v-text-field>
						</v-col>
					</template>

					<v-col cols="12" lg="6"  v-show="param === 2" class="text-right pa-4">
						<v-btn small rounded color="blue darken-4" dark  @click="cambiaPassword = !cambiaPassword" v-if="cambiaPassword"> Cambiar Contraseña	</v-btn>
						<v-btn small rounded color="error" dark @click="cambiaPassword = !cambiaPassword" v-else > Cancelar </v-btn>
					</v-col>
					<!-- <v-card-actions class="mx-3" v-show="param === 2">
						<v-spacer></v-spacer>
						<v-btn small rounded color="blue darken-4" dark  @click="cambiaPassword = !cambiaPassword" v-if="cambiaPassword"> Cambiar Contraseña	</v-btn>
						<v-btn small rounded color="error" dark @click="cambiaPassword = !cambiaPassword" v-else > Cancelar </v-btn>
					</v-card-actions> -->

					<template v-if="!cambiaPassword">
						<v-col cols="12" lg="6">
							<v-text-field
								v-model="password"
								:append-icon="show1 ? 'visibility_off' : 'visibility'"
								:type="show1 ? 'text' : 'password'"
								placeholder="Contraseña de usuario"
								label="Contraseña"
								filled
								dense
								clearable
								hide-details
								@click:append="show1 = !show1"
							></v-text-field>
						</v-col>
						<v-col cols="12" lg="6">
							<v-text-field
								v-model="password2"
								:append-icon="show2 ? 'visibility_off' : 'visibility'"
								:type="show2 ? 'text' : 'password'"
								label=" Confirmar Contraseña"
								placeholder="Confirmar Contraseña "
								filled
								clearable
								dense
								hide-details
								@click:append="show2 = !show2"
							></v-text-field>
						</v-col>
					</template>
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
				titleModal: 'Usuario',
				// VARIABLES PARA CONTRASEÑA
				cambiaPassword: true,
				password			:'',
				password2			:'',
				PasswordAEdit	:'',
				PasswordActual: '',
				show1					: true,
				show2					: true,
				// VARIABLES PRINCIPALES
				nombre		: '',
				correo		: '',
				nivel 		: '',
				foto      : '',
				// SELECTORES
				id_sucursal  : 0,
				sucursal     : [],
				sucursales   : [],
				Sucursal     : '',
				
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
			this.consultarSucursales() //MANDO A CONSULTAR SUCURSALES A MIXINS
			this.validarModoVista() // VALIDO EL MODO DE LA VISTA

		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			...mapGetters('Usuarios'  ,['getUsuarios']),

		},

		watch:{
			edit: function(){
				this.cambiaPassword= true
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
			...mapActions('Usuarios'  ,['consultaUsuarios']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 				= this.edit.nombre
					this.correo 				= this.edit.correo
					this.PasswordActual = this.edit.password
					this.Sucursal 			= this.edit.nomsuc
					this.foto 					= this.edit.foto
					
					if(this.edit.nivel === 1){
						this.nivel = 'Administrador'
					}else if(this.edit.nivel === 2){
						this.nivel = 'Supervisor'
					}else{
						this.nivel = ''
					}

				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	 { this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL USUARIO"   ; return }
				if(!this.correo)	 { this.snackbar = true; this.text="No puedes omitir el CORREO" ; return }
				if(!this.nivel)    { this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				if(!this.Sucursal) { this.snackbar = true; this.text="No puedes omitir la SUCURSAL"; return }

				if(this.param === 1){
					if(!this.password) { this.snackbar = true; this.text="No puedes omitir la Contraseña"; return }
					if(this.password.localeCompare(this.password2) ){
						this.snackbar = true; this.text="Las contraseñas no coinciden"; return
					}
					var md5 = require('md5');
					this.PasswordAEdit = md5(this.password)
					this.PrepararPeticion()
				}
				
				if(this.param === 2){
					if(!this.cambiaPassword){
						// COMPARO LAS CONTRASEÑAS => TIENEN QUE SER IGUAL
						if(this.password.localeCompare(this.password2) ){
							this.snackbar = true ; this.text = "Las contraseñas no coinciden"
							return
						}else if(this.password){
							// ASIGNO LA NUEVA CONTRASEÑA A VARIABLE PARA GRABAR
							var md5 = require('md5');
							this.PasswordAEdit = md5(this.password)
							this.PrepararPeticion()
						}
					}else{
						// SI NO SE MODIFICO LA CONTRASEÑA CONSERVO LA ACTUAL
						this.PasswordAEdit = this.PasswordActual
						this.PrepararPeticion()
					}
				}
			},

			PrepararPeticion(){
				var nivel = 0;
				if(this.nivel === 'Administrador'){
					nivel = 1;
				}else if(this.nivel === 'Supervisor'){
					nivel = 2;
				}else{
					nivel = 3;
				}

				// FORMAR ARRAY A MANDAR
				const payload = { nombre	    : this.nombre,
													correo	    : this.correo,
													password		: this.PasswordAEdit,
													nivel       : nivel,
													id_sucursal	: this.id_sucursal,
													foto        : '',
													estatus: 1 
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearUsuario(payload): this.ActualizarUsuario(payload);
			},

			CrearUsuario(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('usuarios', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarUsuario(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('usuarios/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaUsuarios() //ACTUALIZAR CONSULTA DE CLIENTES
			},

			limpiarCampos(){
				this.nombre    = '';
				this.correo    = '',
				this.nivel     = '',
				this.password  = '',
				this.password2 = '';
				this.foto 		 = '';
				this.Sucursal  = '';
			}
		}
	}
</script>