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
					 <!-- SUCURSALES -->
					<!-- <v-col cols="12" sm="6" >
						<v-select
							:items="sucursales" v-model="Sucursal" label="Sucursal" placeholder ="Sucursal" 
							dense outlined hide-details color="celeste" append-icon="domain"
						></v-select>
					</v-col> -->
					<v-col cols="12" sm="6" >  <!-- VENDEDORES -->
						<v-autocomplete
							:items="vendedores" v-model="vendedor" item-text="nombre" label="Responsable" 
							dense outlined hide-details color="celeste" append-icon="persons"
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="6" > 
						<v-select
							:items="['Externo']" v-model="tipo_compromiso" label="Tipo de compromiso" 
							 placeholder ="Tipo de compromiso" outlined dense hide-details append-icon="home_work"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6" > 
						<v-select
							:items="categorias" item-text="nombre" v-model="Categoria" label="Categoria"  
							 placeholder ="Categorias" outlined dense hide-details append-icon="ballot"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6" > <!-- CLIENTE -->
						<v-autocomplete
							:items="clientes" v-model="cliente" item-text="nombre" label="Clientes" 
							dense outlined hide-details color="celeste" append-icon="people"
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

					<v-col cols="12" sm="6"> <!-- FECHA DE FIN -->
						<v-dialog ref="fechaFin" v-model="fechaFinmodal" :return-value.sync="fecha_fin" persistent width="290px">
							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="fecha_fin" label="Fecha de finalización" append-icon="event" readonly v-on="on"
									outlined dense hide-details color="celeste"
								></v-text-field>
							</template>
							<v-date-picker v-model="fecha_fin" locale="es-es" color="rosa"  scrollable>
								<v-spacer></v-spacer>
								<v-btn text small color="gris" @click="fechaFinmodal = false">Cancelar</v-btn>
								<v-btn dark small color="rosa" @click="$refs.fechaFin.save(fecha_fin)">OK</v-btn>
							</v-date-picker>
						</v-dialog>
					</v-col>

					<v-col cols="12" sm="6"> <!-- HORA DEL FIN -->
						<v-dialog ref="horaFin" v-model="horaFinmodal" :return-value.sync="hora_fin" persistent width="290px" >

							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="hora_fin" label="Hora de finalización" append-icon="access_time" readonly v-on="on"
									outlined dense hide-details color="celeste"
								></v-text-field>
							</template>

							<v-time-picker v-if="horaFinmodal" locale="es-es" color="rosa" v-model="hora_fin" full-width 	>
								<v-spacer></v-spacer>
								<v-btn small text color="gris" @click="horaFinmodal = false">Cancel</v-btn>
								<v-btn small dark color="rosa" @click="$refs.horaFin.save(hora_fin)">OK</v-btn>
							</v-time-picker>
						</v-dialog>
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
				comentario 		 : '',
				// FECHA
				fecha						: new Date().toISOString().substr(0, 10),
				fechamodal 			: false,
				fecha_compromiso: false,
				fechaFin		  : false,
				fechaFinmodal : false,
				fecha_fin			: '',
				// HORA
				hora 					 : null,
        horamodal			 : false,
				hora_compromiso: false,
				horaFin			: false,
        horaFinmodal: false,
				hora_fin    : null,
				
				// AUTOCOMPLETE
				id_vendedor: null,
				vendedores : [],
				vendedor	 : '',
				id_cliente: null,
				clientes	: [],
				cliente		: '',
				// SELECTORES
				id_sucursal  : null,
				sucursal     : [],
				sucursales   : [],
				Sucursal     : '',
				id_categoria : null,
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
			this.consultar_Vendedores()
			this.consultar_Categorias()
			this.consultar_Clientes()
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
			...mapGetters('Productos',['getProductos']),
     ...mapGetters('Login' ,['getdatosUsuario']), 

		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			...mapActions('Compromisos',['consultaCompromisos']),

			validarModoVista(){
				if(this.param === 2){
					// console.log('entro a editar', this.edit)
					// ASIGNAR VALORES AL FORMULARIO
					this.id_vendedor 		= this.edit.id_vendedor
					this.vendedor 			= this.edit.nomvend
					this.id_categoria   = this.edit.id_categoria
					this.Categoria 	    = this.edit.nomcatego
					this.id_cliente 		= this.edit.id_cliente
					this.cliente        = this.edit.nomcli
					this.fecha 					= this.edit.fecha
					this.hora           = this.edit.hora
					this.fecha_fin			= this.edit.fecha_fin 
					this.hora_fin       = this.edit.hora_fin
					this.comentario     = this.edit.comentarios
					this.tipo_compromiso = this.edit.tipo_compromiso === 1? 'Interno': 'Externo'
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				var fi = this.fecha + " " + this.hora; 
				var ff = this.fecha_fin + " " + this.hora_fin;

				if(!this.vendedor)	 			{ this.snackbar = true; this.text="No puedes omitir el VENDEDOR"   					 ; return }
				// if(!this.tipo_compromiso)	{ this.snackbar = true; this.text="No puedes omitir el TIPO DE COMPROMISO"   ; return }
				// if(!this.Categoria)				{ this.snackbar = true; this.text="No puedes omitir la CATEGORIA"   				 ; return }
				if(!this.fecha)						{ this.snackbar = true; this.text="No puedes omitir la FECHA"   						 ; return }
				if(!this.hora)						{ this.snackbar = true; this.text="No puedes omitir la HORA"   							 ; return }
				if(!this.fecha_fin)				{ this.snackbar = true; this.text="No puedes omitir la FECHA FINAL" 				 ; return }
				if(!this.hora_fin)				{ this.snackbar = true; this.text="No puedes omitir la HORA FINAL"  			   ; return }
				if(fi > ff){ this.snackbar=true; this.text="La FECHA y HORA FINAL no puede ser menor a la INICIAL"		 ; return}

				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				var tipocompromiso = this.tipo_compromiso === 'Interno' ? 1 : 2;

				const payload = { id_vendedor 		: this.id_vendedor,
													tipo_compromiso	: tipocompromiso,
													id_categoria		: this.id_categoria,
													id_cliente 		  : this.id_cliente,
													fecha						: this.fecha,
													hora	  				: this.hora,
													comentarios     : this.comentario ? this.comentario : "",
													id_usuario      : this.getdatosUsuario.id, // USUARIO QUE CREA EL REGISTRO
													fase_venta      : 1,
													estatus     		: 1,
													cumplimiento    : 0,
													fecha_fin    		: this.fecha_fin,
													hora_fin    		: this.hora_fin,
													fechaActual     : this.traerFechaActual(),
													horaActual      : this.traerHoraActual(),
													numorden				: '',
													aceptado				: 0,
													obscierre				:''
												}

				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.Crear(payload): this.Actualizar(payload);
			},

			Crear(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('addcompromiso', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			Actualizar(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('putcompromiso/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaCompromisos() //ACTUALIZAR CONSULTA DE CLIENTES
			},

			limpiarCampos(){
				this.id_vendedor 		= ''; 
				this.vendedor 			= ''; 
				this.id_categoria   = ''; 
				this.Categoria 	    = ''; 
				this.id_cliente 		= ''; 
				this.cliente        = ''; 
				this.fecha 					= new Date().toISOString().substr(0, 10); 
				this.fechaFin				= '', 
				this.hora           = ''; 
				this.horaFin         = ''; 
				this.comentario      = ''; 
				this.tipo_compromiso = '';
			}
		}
	}
</script>