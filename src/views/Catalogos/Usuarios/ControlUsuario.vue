<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
					<strong> {{alerta.texto}} </strong>
					<template v-slot:action="{ attrs }">
						<v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
					</template>
				</v-snackbar>
				
				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'NUEVO USUARIO':'EDITAR USUARIO' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" fab small @click="$emit('modal',false)" ><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<!-- <v-divider class="ma-2"></v-divider> -->
				<!-- <v-form> -->
				<v-row>

					<v-col cols="12" >
						<v-text-field
							v-model ="nombre"
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del empleado"
							hide-details
							dense
							clearable
							filled
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							v-model="empleado"
							label="# Empleado"
							placeholder="# Empleado"
							hide-details
							dense
							clearable
							filled
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							v-model ="usuario"
							append-icon="android"
							label="Usuario"
							placeholder="Usuario "
							hide-details
							dense
							clearable
							filled
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							v-model="correo"
							append-icon="email" 
							label="Correo"
							placeholder="Correo electronico"
							hide-details
							dense
							clearable
							filled
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6"> 
						<v-autocomplete
							v-model="sucursal" :items="sucursales"  item-text="nombre" item-value="id" label="Sucursales" 
							dense filled hide-details return-object color="celeste" append-icon="folder_shared"
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6">
						<v-autocomplete
							v-model="departamento" :items="departamentos" item-text="nombre" item-value="id" label="Departamento" 
							dense filled hide-details return-object color="celeste" append-icon="folder_shared"
							:disabled="sucursal.id? false: true"
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6" >
						<v-autocomplete
							:items="puestos" v-model="puesto" item-text="nombre" item-value="id" label="Puesto" 
							dense filled hide-details return-object color="celeste" append-icon="mdi-account-tie"
							:disabled="departamento.id? false: true" 
						></v-autocomplete>
					</v-col>

					<!-- ACCESOS A SISTEMA -->
					<v-col cols="12">
						<v-divider class="rosa"></v-divider>
						<v-row>
							<v-col cols="12" sm="6" >
								<v-autocomplete
									:items="sistemas" v-model="sistema" item-text="nombre" item-value="id" label="Sistemas" 
									dense filled hide-details return-object color="celeste" append-icon="smi-desktop-classic"
								></v-autocomplete>
							</v-col>

							<v-col cols="12" sm="6">
								<v-autocomplete
									:items="nivelesxsistema" v-model="nivel" item-text="nombre" item-value="id" label="Niveles" 
									dense filled hide-details return-object color="celeste" append-icon="show_chart"
								></v-autocomplete>
							</v-col>

							<v-col cols="12" sm="6" offset-sm="6" class="py-0 text-right" v-if="!editarAcceso">
								<v-btn block color="celeste" dark @click="sistemaUsuario(modo=1)"> Agregar acceso <v-icon>add</v-icon>  </v-btn>
							</v-col>
						</v-row>
					</v-col>

					

					<v-col  cols="6"   class="py-0" v-if="editarAcceso">
						<v-btn small block  color="error" dark @click="editarAcceso= false"> Cancelar <v-icon right>mdi-close</v-icon> </v-btn>
					</v-col>
					<v-col  cols="6"   class="py-0" v-if="editarAcceso">
						<v-btn small block color="celeste" dark @click="sistemaUsuario(modo=2)"> Editar acceso <v-icon>add</v-icon>  </v-btn>
						<!-- <v-btn small block  color="celeste" dark @click="actualizaAcceso(item)"> Editar <v-icon right>edit</v-icon>  </v-btn> -->
					</v-col>

					<v-col cols="12">
						<v-card outlined >
							<v-simple-table fixed-header  v-if="getSistemasUsuario.length">
								<template v-slot:default>
									<thead>
										<tr> 
												<th class="text-left"> SISTEMA </th>
												<th class="text-left"> NIVEL    </th>
												<th class="text-left"> ACCION   </th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="item in getSistemasUsuario" :key="item.id">
											<td>{{ item.nomsistema }}</td>
											<td>{{ item.nomnivel }}</td>
											<td> 
												<v-btn small text color="success" @click="ediarAcceso(item)"> <v-icon> edit </v-icon>  </v-btn> 
												<v-btn small text color="error"   @click="eliminar_sistema_usuario(item.id)"> <v-icon> delete </v-icon>  </v-btn> 
											</td>
										</tr>
									</tbody>
									
								</template>
							</v-simple-table>
							<v-card-text v-if="!getSistemasUsuario.length"> No ha agregado ningun elemento.</v-card-text>
						</v-card>
					</v-col>
					


					<template v-if="param === 1">
						<!-- <v-col cols="12" sm="6"/> -->
						<v-col cols="12" sm="6">
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

						<v-col cols="12" sm="6">
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

					<v-col cols="12" sm="6" offset-sm="6" v-show="param === 2" class="text-right pa-4"> <!-- BOTON PARA MOSTRAR CONTRASEÑAS -->
						<v-btn small block  color="rosa" dark  @click="cambiaPassword = !cambiaPassword" v-if="cambiaPassword"> Cambiar Contraseña	</v-btn>
						<v-btn small block  color="gris" dark @click="cambiaPassword = !cambiaPassword" v-else > Cancelar </v-btn>
					</v-col>

					<template v-if="!cambiaPassword">
						<v-col cols="12" sm="6">
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
						<v-col cols="12" sm="6">
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
				
				<div class="mt-5"></div>
				<v-footer absolute >		
					<v-spacer></v-spacer>
					 <v-btn  :disabled="overlay" persistent :loading="overlay" dark center class="white--text" color="success" @click="validaInfo" v-if="param === 1">
             Guardar Información 
          </v-btn>
					<v-btn  :disabled="overlay" persistent :loading="overlay" dark center class="white--text" color="success" @click="validaInfo" v-else>
             Actualizar  
          </v-btn>
				</v-footer>
			</v-col>
		</v-row>
		<overlay v-if="overlay"/>
		<!-- <v-dialog v-model="borrarModal" persistent max-width="400" v-if="param === 2"> 
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
				</v-dialog>  -->
	</v-container>
	
</template>

<script>
	import {mapGetters, mapActions} from 'vuex'
	import  metodos     from '@/mixins/metodos.js';
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import overlay      from '@/components/overlay.vue'
	var md5 = require('md5'); 
	
	export default {
		mixins:[SelectMixin, metodos ],
	  components: {
			overlay,
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
				empleado: null,
				nombre		: '',
				correo		: '',
				nivel 		: {id:null, nombre:''},
				niveles   :[],
				nivelesxsistema: [],

				idAEditar: null,
				accesosAEdit:{},
				editarAcceso: false,
				accesosAEditar:[],

				sistema: { id: null, nombre:'' },
				sistemas:[],

				// SELECTORES
				sucursal     : { id:null, nombre: ''},
				sucursales   : [],
				departamentos:[],
				departamento: { id:null, nombre: ''},
				puesto: {id:null, nombre:''},
				puestos:[],
				
				// ALERTAS
        alerta: { activo: false, texto:'', color:'error', vertical:true },
				overlay    : false,
				correcto   : true,
				// BOTON DE BORRAR
				borrarModal: false,
			}
		},
		
		created(){
			this.consultarSucursales(); //MANDO A CONSULTAR SUCURSALES A MIXINS
			// this.consultaPuestos();   
			// this.consultaDeptos();
			this.consultaNiveles();
			this.consultaSistemas();
			this.validarModoVista(); 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
      ...mapGetters('Login' ,['getdatosUsuario']), 
			...mapGetters('Usuarios'  ,['getUsuarios','getSistemasUsuario','SistemasUsuarioAEdit']),
		},

		watch:{
			edit(){
				this.cambiaPassword= true
				this.validarModoVista();
			},

			sistema(){
				if(this.sistema.id != null){
					this.traerNivelxSistema(this.sistema.id, this.niveles);
				}
			},

			async sucursal(){
				// console.log("SUCURSALES");
				this.departamentos = await this.consultar_deptos_por_suc(this.sucursal.id);
				
			},

			async departamento(){
				// console.log("DEPTOS");
				this.puestos = await this.consultar_puestos_por_depto(this.departamento.id);

			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
			...mapActions('Usuarios'  ,['consultaUsuarios',
																	'agregar_sistema_usuario',
																	'editar_sistema_usuario',
																	'eliminar_sistema_usuario',
																	'limpiar_sistema_usuario',
																	'accesos_usuario_consulta',
																]),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
  				this.empleado 		  = this.edit.empleado;
					this.id_usuario     = this.edit.id;
					this.nombre 				= this.edit.nombre;
					this.usuario        = this.edit.usuario;
					this.correo 				= this.edit.correo;
					this.PasswordActual = this.edit.password; 
					this.sucursal       = { id:this.edit.id_sucursal  };
					this.departamento   = { id:this.edit.id_depto     };
					this.puesto 				= { id:this.edit.id_puesto    };
					this.accesos_usuario_consulta(this.edit.id).then( response =>{
						this.accesosAEdit = response.map( item => { return item.id	})
					});
					// this.accesosAEditar = this.getSistemasUsuario 
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	    { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL NOMBRE DEL EMPLEADO' , color:'error'} ; return };
				if(!this.empleado)    { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL NÚMERO DE EMPLEADO'  , color:'error'} ; return };
				if(!this.usuario)	    { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL NOMBRE DE USUARIO'   , color:'error'} ; return };
				if(!this.correo)	    { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL CORREO ELECTRONIO'   , color:'error'} ; return };
				if(!this.sucursal.id) { this.alerta = { activo: true, texto:'NO PUEDES OMITIR LA SUCURSAL'  				  , color:'error'} ; return };
				if(!this.departamento.id) { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL DEPARTAMENTO'	  , color:'error'} ; return };
				if(!this.puesto.id)   { this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL PUESTO'  				    , color:'error'} ; return };


				if(this.param === 1){ // SE EJECUTA SI ESTA LA VISTA EN MODO "CREAR" => 1
					if(!this.password) { this.alerta = { activo: true, texto:'NO PUEDES OMITIR LA CONTRASEÑA' , color:'error'} ; return }
					if(this.password.localeCompare(this.password2) ){
						this.alerta = { activo: true, texto:'LAS CONTRASEÑAS NO COINCIDEN' , color:'error'}; return;
					}
					this.PasswordAEdit = md5(this.password)
					this.PrepararPeticion()
				}
				
				if(this.param === 2){ // SE EJECUTA SI ESTA LA VISTA EN MODO "EDITAR" => 2
					if(!this.cambiaPassword){
						if(this.password.localeCompare(this.password2) ){ // COMPARO LAS CONTRASEÑAS => TIENEN QUE SER IGUAL
							this.alerta = { activo: true, texto:'LAS CONTRASEÑAS NO COINCIDEN' , color:'error'}; return;
						}else if(this.password){
							this.PasswordAEdit = md5(this.password) // ASIGNO LA NUEVA CONTRASEÑA A VARIABLE PARA GRABAR
							this.PrepararPeticion() // MANDO A PREPARAR EL OBJETO.
						}
					}else{
						this.PasswordAEdit = this.PasswordActual // SI NO SE MODIFICO LA CONTRASEÑA CONSERVO LA ACTUAL
						this.PrepararPeticion() // MANDO A PREPARAR EL OBJETO.
					}
				}
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = new Object();
							payload.empleado     = this.empleado;
							payload.nombre       = this.nombre;
							payload.usuario      = this.usuario.toUpperCase();
							payload.correo       = this.correo;
							payload.id_sucursal  = this.sucursal.id;
							payload.id_depto     = this.departamento.id;
							payload.id_puesto    = this.puesto.id;
							payload.password     = this.PasswordAEdit;
							payload.accesosAEdit = this.accesosAEdit;
							payload.accesos      = this.getSistemasUsuario;

				// console.log('pay', payload)
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearUsuario(payload): this.ActualizarUsuario(payload);
			},

			CrearUsuario(payload){
				this.overlay = true;								
				this.$http.post('usuarios', payload).then((response)=>{  // MANDO A INSERTAR CLIENTE
					 this.alerta = { activo: true, texto: response.bodyText , color:'success'}
					this.TerminarProceso();					
				}).catch(error =>{
					console.log('error',error)
					 this.alerta = { activo: true, texto: error.bodyText , color:'error'}
				}).finally(()=>{ this.overlay = false })
			},

			ActualizarUsuario(payload){
				this.overlay = true;								
				this.$http.put('usuarios/'+ this.edit.id, payload).then((response)=>{
					this.alerta = { activo: true, texto: response.bodyText , color:'success'}
					this.TerminarProceso();						
				}).catch(error =>{
					console.log('error',error)
					 this.alerta = { activo: true, texto: error.bodyText , color:'error'}
				}).finally(()=>{ this.overlay = false })
			},

			TerminarProceso(){
				let that = this;
				// setTimeout(() => { that.correcto = false    }, 2000);
				setTimeout(() => { that.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaUsuarios() //ACTUALIZAR CONSULTA DE USUARIOS
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

			sistemaUsuario(modo){
				if(!this.sistema.id){ this.alerta = { activo: true, texto:'Olvidaste seleccionar un sistema', color:'error', vertical:true  }; return } ;
				if(!this.nivel.id)  { this.alerta = { activo: true, texto:'Olvidaste seleccionar un nivel', color:'error', vertical:true    }; return } ;
				
				if(this.validaSistemaUsuario(this.sistema.id, modo)){
						this.alerta = { activo: true, texto:'Este sistema ya se encuentra en la lista.', color:'error', vertical:true }; 
						return; 
				}
				
				switch (modo) {
					case 1:
						// console.log('modo', modo)
						const data1 = new Object();
									data1.id_sistema =  this.sistema.id;
									data1.nomsistema =  this.sistema.nombre;
									data1.id_nivel   =  this.nivel.id;
									data1.nomnivel   =  this.nivel.nombre;

						this.agregar_sistema_usuario(data1).then( response =>{
							this.sistema = { id: null, nombre:'' }; this.nivel   = { id: null, nombre:'' };
							this.alerta  = { activo: true, texto: response , color:'success', vertical:true   }
						});
						break;

					case 2:
						// console.log('modo', modo)
						const data2 = new Object();
									data2.id         =  this.accesosAEdit.id;
									data2.id_sistema =  this.sistema.id;
									data2.nomsistema =  this.sistema.nombre;
									data2.id_nivel   =  this.nivel.id;
									data2.nomnivel   =  this.nivel.nombre;

						this.editar_sistema_usuario(data2).then( response =>{
							this.sistema = { id: null, nombre:'' }; this.nivel = { id: null, nombre:'' }; this.editarAcceso = false;
							this.alerta = { activo: true, texto: response , color:'success', vertical:true   }
						});
						break;
				}
				// this.accesos.push({ sistema: this.sistema.id , nivel: this.nivel.id })
			},

			validaSistemaUsuario(id, modo){
				let error = false;
				if(modo === 1){
					for(let i = 0; i< this.getSistemasUsuario.length;i++){
						if(this.getSistemasUsuario[i].id_sistema === id){
							error = true;
						}
					}
				}

				if(modo === 2){
					for(let i = 0; i< this.getSistemasUsuario.length;i++){
						if(this.getSistemasUsuario[i].id_sistema === id && this.getSistemasUsuario[i].id != this.idAEditar){
							error = true;
						}
					}
				}
				
				return error;
				
			},

			ediarAcceso(item){
				console.log('item', item)
				this.accesosAEdit = item;
				this.idAEditar    = item.id
				this.sistema  = { id:item.id_sistema, nombre:item.nomsistema }
				this.nivel    = { id:item.id_nivel  , nombre: item.nomnivel }
				this.editarAcceso = true;
			},

			limpiarCampos(){
				this.empleado  = null;
				this.nombre    = '';
				this.usuario   = '';
				this.correo    = '',
				this.nivel     = { id:null, nombre: '' };
				this.sistema   = { id:null, nombre: '' };
				this.password  = '';
				this.password2 = '';
				this.sucursal  =  { id:null, nombre: '' };
				this.departamento   = { id:null, nombre: '' };
				this.puesto 				= { id:null, nombre: '' };
				this.limpiar_sistema_usuario();
			}
		}
	}
</script>