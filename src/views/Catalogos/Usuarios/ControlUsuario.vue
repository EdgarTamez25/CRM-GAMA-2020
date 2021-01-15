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
				<!-- <v-form> -->
				<v-row>
					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del empleado"
							hide-details
							dense
							clearable
							v-model ="nombre"
							outlined
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="android"
							label="Usuario"
							placeholder="Usuario "
							hide-details
							dense
							clearable
							v-model ="usuario"
							outlined
						></v-text-field>
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
							outlined
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							v-model="nivel"
							:items="niveles"
							item-text="nombre" 
							item-value="id"
							label="Nivel"
							placeholder="Nivel de acceso"
							append-icon="show_chart"
							dense
							hide-details
							return-object
							outlined
						></v-select>
					</v-col>

					<v-col cols="12" lg="6"> 
						<v-select
							:items="sucursales"
							item-text="nombre"
							item-value="id"
							label="Sucursal"
							placeholder="Sucursal"
							append-icon="store"
							dense
							hide-details
							clearable
							v-model="sucursal"
							outlined
							return-object
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-autocomplete
							:items="departamentos" v-model="departamento" item-text="nombre" item-value="id" label="Departamento" 
							dense outlined hide-details return-object color="celeste" append-icon="folder_shared"
						></v-autocomplete>
					</v-col>

					<v-col cols="12" lg="6">
						<v-autocomplete
							:items="puestos" v-model="puesto" item-text="nombre" item-value="id" label="Puesto" 
							dense outlined hide-details return-object color="celeste" append-icon="mdi-account-tie"
						></v-autocomplete>
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

					<v-col cols="12"   v-show="param === 2" class="text-right pa-4"> <!-- BOTON PARA MOSTRAR CONTRASEÑAS -->
						<v-btn small block rounded color="celeste" dark  @click="cambiaPassword = !cambiaPassword" v-if="cambiaPassword"> Cambiar Contraseña	</v-btn>
						<v-btn small block rounded color="gris" dark @click="cambiaPassword = !cambiaPassword" v-else > Cancelar </v-btn>
					</v-col>

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
					
					<v-dialog v-model="borrarModal" persistent max-width="400" v-if="param === 2"> <!-- PROCESO PARA ELIMINAR  -->
            <template v-slot:activator="{ on }" >
              <v-btn small outlined color="red darken-4" dark v-on="on">Eliminar</v-btn>
            </template>
            <v-card>
              <v-col cols="12"  class="pa-4">
                <strong >¿ ESTAS SEGURO DE ELIMINAR A ESTÉ USUARIO ?</strong>
              </v-col>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1"   text small @click="borrarModal = false">Cancelar</v-btn>
                <v-btn color="green darken-1" dark small @click="borrar">Eliminar </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog> <!-- FIN DEL PROCESO PARA ELIMINAR  -->

					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="param === 1">
             Confirmar  
          </v-btn>
					<v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-else>
             Actualizar  
          </v-btn>

          <v-dialog v-model="dialog" hide-overlay persistent width="300"> <!-- PROCESO DE ESPERA -->
            <v-card :color="colorDialog" dark >
              <v-card-text> <th style="font-size:17px;" align="center">{{ textDialog }}</th>
                <br>
                <v-progress-linear indeterminate color="white" class="mb-0" persistent></v-progress-linear>
              </v-card-text>
            </v-card>
          </v-dialog>

					<v-dialog v-model="Correcto" hide-overlay persistent width="350"> <!-- PROCESO CORRECTO -->
            <v-card :color="colorCorrecto"  dark class="pa-3">
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
				id_usuario:  null,
				nombre		: '',
				correo		: '',
				nivel 		: {id:null, nombre:''},
				niveles: [{ id:1, nombre:'Administrador'},
									{ id:2, nombre:'Supervisor'},
									{ id:3, nombre:'Vendedor'},
									{ id:4, nombre:'Chofer'},
									{ id:5, nombre:'Almacén'},
									{ id:6, nombre:'Ventas'},
									{ id:7, nombre:'Servicio al Cliente'},
									{ id:8, nombre:'Sin seleccionar'},
									{ id:9, nombre:'Desarrollo de Proyectos'},

								],

				// SELECTORES
				sucursal     : { id:null, nombre: ''},
				sucursales   : [],
				departamentos:[],
				departamento: { id:null, nombre: ''},
				puestos:[],
				puesto: {id:null, nombre:''},
				
				// ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				colorCorrecto: 'green',
				textCorrecto: '',
				colorDialog: 'blue darken-4',
				// BOTON DE BORRAR
				borrarModal: false
			}
		},
		
		created(){
			this.consultarSucursales(); //MANDO A CONSULTAR SUCURSALES A MIXINS
			this.consultaPuestos();   
			this.consultaDeptos();
			this.validarModoVista(); 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			...mapGetters('Usuarios'  ,['getUsuarios']),
		},

		watch:{
			edit: function(){
				this.cambiaPassword= true
				this.validarModoVista();
			},
		},

		methods:{
			// IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
			...mapActions('Usuarios'  ,['consultaUsuarios']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.id_usuario     = this.edit.id
					this.nombre 				= this.edit.nombre
					this.correo 				= this.edit.correo
					this.PasswordActual = this.edit.password
					this.sucursal     = { id: this.edit.id_sucursal, nombre: this.edit.nomsuc}
					this.Sucursal 			= this.edit.nomsuc
					this.foto 					= ''
					this.usuario        = this.edit.usuario
					this.nivel          = { id    : this.niveles[this.edit.nivel-1].id , 
																	nombre: this.niveles[this.edit.nivel-1].nombre
																}
					this.departamento   = { id:this.edit.id_depto, nombre: this.edit.nomdepto };
					this.puesto 				= { id:this.edit.id_puesto, nombre: this.edit.nompuesto };

				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	 { this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL EMPLEADO"   ; return }
				if(!this.usuario)	 { this.snackbar = true; this.text="No puedes omitir el USUARIO"   ; return }
				if(!this.correo)	 { this.snackbar = true; this.text="No puedes omitir el CORREO" ; return }
				if(!this.nivel.id || this.nivel.id === 8)    { this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				// if(this.nivel.id === 7)    { this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				if(!this.sucursal.id) { this.snackbar = true; this.text="No puedes omitir la SUCURSAL"; return }

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
				// FORMAR ARRAY A MANDAR
        let formData = new FormData(); // creamos una variable tipo FormData
				formData.append('file', this.file);

				const payload = { nombre	    : this.nombre,
													correo	    : this.correo,
													password		: this.PasswordAEdit,
													nivel       : this.nivel.id,
													id_sucursal	: this.sucursal.id,
													usuario     : this.usuario.toUpperCase(),
													foto       : '',
													id_depto    : this.departamento.id,
													id_puesto   : this.puesto.id,
													estatus: 1 
												}
											// console.log('pay', payload)
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearUsuario(payload): this.ActualizarUsuario(payload);
			},

			CrearUsuario(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('usuarios', payload).then((response)=>{
					
					if(response.body.error){ 
						this.MensajeError(response.body.mensaje)
						return;
					}

					this.TerminarProceso(response.body);					
				}).catch(error =>{
					console.log('error',error)
				})
			},

			ActualizarUsuario(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información" ; this.colorDialog ="blue darken-4"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('usuarios/'+ this.edit.id, payload).then((response)=>{
					if(response.body.error){ 
						this.MensajeError(response.body.mensaje)
						return;
					}
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog 			  = false  ; this.Correcto 		 = true; 
				this.colorCorrecto	= "green"; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaUsuarios() //ACTUALIZAR CONSULTA DE USUARIOS
			},

			MensajeError(mensaje){
				this.dialog			  	= false	; this.Correcto 		= true ; 
				this.colorCorrecto	="red"	; this.textCorrecto = mensaje;
				setTimeout(() => (this.Correcto = false), 2000)
			},

			borrar(){
				this.borrarModal = false; // DESACTIVA LA ALERTA 
				this.dialog = true ; // ACTIVA EL MODAL DE ESPERA 
				this.textDialog = "Eliminando usuario" ; // LO QUE VA DECIR 
				 this.colorDialog="red darken-4";   // COLOR DE LA MODAL
				setTimeout(() => (this.dialog = false), 2000) // LO QUE VA DURAR LA MODAL ABIERTA
				
				var me = this
				this.$http.delete('usuarios/'+ this.id_usuario).then((response)=>{
					this.TerminarProceso(response.body);
				})
			},

			limpiarCampos(){
				this.nombre    = '';
				this.correo    = '',
				this.nivel     = '',
				this.password  = '',
				this.password2 = '';
				this.foto 		 = '';
				this.sucursal  =  { id:null, nombre: '' };
				this.usuario  = '';
				this.departamento   = { id:null, nombre: '' };
				this.puesto 				= { id:null, nombre: '' };
			}
		}
	}
</script>