<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="snackbar" :color="color" top multi-line right > <b>{{ text }}</b> </v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ modoVista === 1? 'Nuevo Compromiso':'Editar Compromiso' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>

				<v-row>
					<v-col cols="12" sm="12" >  <!-- VENDEDORES -->
						<v-autocomplete
							:items="vendedores" v-model="vendedor" item-text="nombre" tem-value="id" label="Responsable" 
							dense outlined hide-details color="celeste" append-icon="persons" return-object
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6" > 
						<v-select
							 v-model="tipo" :items="tipos" item-text="nombre" item-value="id" outlined
							dense hide-details  label="Tipo de compromiso" return-object placeholder ="Tipo de compromiso"
						></v-select>
					</v-col> 

					<v-col cols="12" sm="6" > 
						<v-select
							v-model="categoria" :items="categorias" item-text="nombre" item-value="id" label="Categoria"  
							 placeholder ="Categorias" outlined dense hide-details append-icon="ballot" return-object
						></v-select>
					</v-col>

					<v-col cols="12" > <!-- CLIENTE -->
						<v-autocomplete
							:items="clientes" v-model="cliente" item-text="nombre" item-value="id" label="Clientes" 
							dense outlined hide-details color="celeste" append-icon="people" return-object
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6"> <!-- FECHA DE INICIO -->
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

					<v-col cols="12" sm="6"> <!-- HORA DEL INICIO -->
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

					<v-col cols="12"  > <!-- COMENARIO -->
						<v-textarea
							v-model ="obs" filled label="Comentario" placeholder="Agregar un comentario ..."
							rows="2" hide-details dense
						></v-textarea>
					</v-col>

				</v-row>

				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="modoVista === 1">
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
import { concat } from '@amcharts/amcharts4/.internal/core/utils/Iterator';
	
	export default {
		mixins:[SelectMixin],
	  components: {
		},
		props:[
			'modoVista',
			'data',
	  ],
	  data () {
			return {
				// VARIABLES PRINCIPALES
				tipo: {id:null, nombre:''},
				tipos:[{id:1, nombre:'Cliente'},{id:2, nombre:'Prospectos'}],
				obs 		 : '',
				// FECHA
				fecha						: new Date().toISOString().substr(0, 10),
				fechamodal 			: false,
				fecha_compromiso: false,
				
				// HORA
				hora 					 : null,
        horamodal			 : false,
				hora_compromiso: false,
				
				// AUTOCOMPLETE
				vendedores : [],
				vendedor	 : {id:null, nombre:''},

				clientes	: [],
				cliente		: {id:null, nombre:''},
				// SELECTORES
				categoria    : { id:null, nombre:''},
				categorias   : [],
				// ALERTAS
				snackbar    : false,
				text		    : '',
				color		    : 'error',
				dialog      : false,
				textDialog  :'',
				Correcto    : false,
				textCorrecto: '',
			}
		},
		
		created(){
			this.validarModoVista() 	  // VALIDO EL MODO DE LA VISTA
			this.consultar_Vendedores()
			this.consultar_Categorias()
			this.consultar_Clientes()
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
			...mapGetters('Productos',['getProductos']),
      ...mapGetters('Login'    ,['getdatosUsuario']), 
		},

		watch:{ data: function(){ this.validarModoVista(); 	} },

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			...mapActions('Compromisos',['consultaCompromisos']),

			validarModoVista(){
				if(this.modoVista === 2){
					console.log('entro a editar', this.data)
					// ASIGNAR VALORES AL FORMULARIO
					this.vendedor    = { id: this.data.id_vendedor , nombre: this.data.nomvend }
					this.tipo        = { id: this.data.tipo        , nombre: this.tipos[this.data.tipo-1].nombre}
					this.categoria   = { id: this.data.id_categoria, nombre: this.data.nomcatego }
					this.cliente     = { id: this.data.id_cliente  , nombre: this.nomcli}
					this.fecha 			 = this.data.fecha
					this.hora        = this.data.hora
					this.obs     	   = this.data.obs
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				var fi = this.fecha + " " + this.hora;  // fecha de compromiso
				var ff = this.traerFechaActual()+ " " + this.traerHoraActual(); // fecha actual
				if(!this.vendedor.id)	 	{ this.snackbar = true; this.text="No puedes omitir el VENDEDOR"   					 ; return }
				if(!this.tipo.id)				{ this.snackbar = true; this.text="No puedes omitir el TIPO DE COMPROMISO"   ; return }
				if(!this.categoria.id)	{ this.snackbar = true; this.text="No puedes omitir la CATEGORIA"   				 ; return }
				if(!this.fecha)					{ this.snackbar = true; this.text="No puedes omitir la FECHA"   						 ; return }
				if(!this.hora)					{ this.snackbar = true; this.text="No puedes omitir la HORA"   							 ; return }
				if(fi < ff)							{ this.snackbar=true; this.text="La FECHA y HORA NO PUEDEN SER MENORES A LA ACTUAL."		 ; return}
				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { id_vendedor 		: this.vendedor.id,
													tipo						: this.tipo.id,
													id_categoria		: this.categoria.id,
													id_cliente 		  : this.cliente.id,
													fecha			      : this.fecha,
													hora			      : this.hora,
													obs     				: this.obs ? this.obs : "",
													fuente      	  : this.getdatosUsuario.id, // USUARIO QUE CREA EL REGISTRO
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.modoVista === 1 ? this.Crear(payload): this.Actualizar(payload);
			},

			Crear(payload){
				this.dialog = true ; this.textDialog =  "Guardando Información";
				this.$http.post('addcompromiso', payload).then((response)=>{
					this.TerminarProceso(response.bodyText);					
				}).catch(error =>{
					this.mostrarError(error.bodyText)
				}).finally(() => this.dialog = false) 
			},

			Actualizar(payload){
				this.dialog = true ; this.textDialog ="Actualizando Información"
				this.$http.put('putcompromiso/'+ this.data.id, payload).then((response)=>{
					this.TerminarProceso(response.bodyText);					
				}).catch(error =>{
					this.mostrarError(error.bodyText)
				}).finally(() => this.dialog = false)
			},
	
			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaCompromisos() //ACTUALIZAR CONSULTA DE CLIENTES
			},

			limpiarCampos(){
				this.vendedor  = { id: null, nombre:''};
				this.categoria = { id: null, nombre:''};
				this.cliente   = { id: null, nombre:''};
				this.fecha 		 = new Date().toISOString().substr(0, 10); 
				this.hora      = ''; 
				this.obs       = ''; 
				this.tipo      = '';
			},

			mostrarError(mensaje){
				this.snackbar=true; this.text=mensaje;
			}
		}
	}
</script>