<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12" >
				
				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ tituloVista }} </strong>  </h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider></v-divider>
				<v-row>
					<v-col cols="12" v-if="param!=5"> <!-- Responsables TEXT -->
						<v-text-field v-model="responsable" label="Responsable"	hide-details dense outlined append-icon="person"></v-text-field>
					</v-col>
					<v-col cols="12"> <!-- CLIENTE -->
						<v-text-field v-model="cliente" label="Cliente" hide-details dense outlined append-icon="people_alt" ></v-text-field>
					</v-col>
					<v-col cols="12"  > <!-- COMENARIO -->
						<v-textarea v-model ="obs" filled label="Solicitud" rows="2" hide-details dense ></v-textarea>
					</v-col>
					<v-col cols="12" v-if="param === 4" > <!-- COMENARIO -->
					<v-textarea v-model ="razonRecotiza" filled label="¿Por qué?" rows="2" hide-details dense ></v-textarea>
				</v-col>
				</v-row>

				<v-card-text class="text-center subtitle-1 font-weight-bold " v-if="param===5"> Número de Orden: {{ Numero_Orden }}  </v-card-text>

				<v-row v-if="param===5 || param === 6 || param === 7">
					<v-col cols="12" sm="8" >  <!-- CHOFERES AUTOCOMPLETE -->
						<v-autocomplete
							:items="choferes" v-model="chofer" item-text="nombre" label="Choferes" return-object
							dense outlined hide-details  append-icon="airport_shuttle" 
						></v-autocomplete>
					</v-col>

					<v-col cols="12" sm="4" > <!-- CLIENTE -->
						<v-text-field v-model="numfac" label="Núm Factura" hide-details dense outlined append-icon="format_list_numbered_rtl" ></v-text-field>
					</v-col>

					<v-col cols="12" sm="6" > <!-- FECHA DE INICIO -->
						<v-dialog ref="fecha_compromiso" v-model="fechamodal" :return-value.sync="fecha" persistent width="290px">
							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="fecha" label="Fecha de entrega" append-icon="event" readonly v-on="on"
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

					<v-col cols="12" sm="6" > <!-- HORA DEL INICIO -->
						<v-dialog ref="hora_compromiso" v-model="horamodal" :return-value.sync="hora" persistent width="290px" >

							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="hora" label="Hora de entrega" append-icon="access_time" readonly v-on="on"
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

					<v-col cols="12"  v-if="param === 7"> <!-- COMENARIO -->
						<v-textarea v-model ="razonRechazo" filled label="¿Por qué?" rows="2" hide-details dense ></v-textarea>
					</v-col>
				</v-row>

				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="orange" 
						 v-if="param === 2 || param === 4"
						 @click="ConfirmaModal=true"
					>
					{{ param === 2?'PASAR A COTIZADO':'PASAR A RECOTIZAR '}}

					</v-btn>
					<v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="morado" 
						 v-if="param === 5 || edit.fase_venta === 6 || edit.fase_venta === 7 "
						 @click="validarEntrega"
					>
						{{  entregar }}
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

					<v-dialog v-model="ConfirmaModal" persistent max-width="400" > <!-- PROCESO PARA ELIMINAR  -->
            <v-card>
              <v-col cols="12"  class="pa-4">
                <strong v-if="param===2 || param===4">Estas apunto de pasar el proyecto a fase: Cotizado.¿ Quieres seguir ?</strong>
                <strong v-if="param===5 || param===7">El proyecto se pasara a entregar. ¿ Quieres seguir ?</strong>
              </v-col>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="gris"   text small @click="ConfirmaModal = false">Cancelar</v-btn>
                <v-btn color="rosa" dark small @click="pasarACotizado" v-if="param===2 || param===4">Seguir </v-btn>
                <v-btn color="rosa" dark small @click="pasarAEntregar" v-if="param===5 || param===7">Seguir </v-btn>

              </v-card-actions>
            </v-card>
          </v-dialog> <!-- FIN DEL PROCESO PARA ELIMINAR  -->
						<!-- {{ edit }} -->
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
				tituloVista: '',
				id_compromiso: null,
				responsable: '',
				cliente: '',
				obs: '',
				numfac:'',
				Numero_Orden: '',
				razonRechazo:'',
				razonRecotiza:'',
				entregar: 'Entregar Producto',
				// FECHA
				fecha						: this.traerFechaActual(),
				fechamodal 			: false,
				fecha_compromiso: false,

				// HORA
				hora 					 : this.traerHoraActual(),
        horamodal			 : false,
				hora_compromiso: false,

				// ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',
				ConfirmaModal: false,

				// AUTOCOMPLETE	
				vendedores : [],
				vend	 : {id:null, nombre:''},
				choferes:[],
				chofer: { id:null, nombre:''},
			}
		},
		
		created(){
			this.consultaChofer()
			this.validarModoVista() 	  // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
			...mapGetters('Productos',['getProductos']),
		},

		watch:{
			edit: function(){
				this.limpiarCampos()
				this.consultaChofer()
				this.consultar_Vendedores()
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
			...mapActions('Compromisos',['consultaCompromisos']),

			validarModoVista(){
				this.id_compromiso = this.edit.id
				this.responsable   = this.edit.nomvend;
				this.cliente       = this.edit.nomcli;
				this.obs 				   = this.edit.obs_usuario;

				switch (this.param) {
					case 1:
						this.tituloVista = "Detalle de compromiso";
						break;
					case 2:
						this.tituloVista = "Proyecto por cotizar";
						break;
					case 4:
						this.tituloVista = "Proyecto por recotizar";
						this.consultaRecotización()
						break;
					case 5:
						this.tituloVista = "Proyecto en producción";
						break;
					case 6:
						this.tituloVista = "Proyecto por entregar";
						this.consultaEntrega()
						break;
					case 7:
						this.tituloVista = "Entrega Rechazada";
						this.consultaEntrega()
						break;
				}

				// if(this.param === 1){
				// 	this.tituloVista = "Detalle de compromiso";
				// }else if(this.param === 2){
				// 	this.tituloVista = "Proyecto por cotizar";
				// }else 
				// if(this.param === 5 ){
				// 	// this.tituloVista = "Proyecto por entregar";
				// 	if(this.edit.fase_venta === 6){ this.consultaEntrega() }
				// 	if(this.edit.fase_venta === 7){ this.consultaEntrega() }

				// }

				// this.$http.get('numero.orden/'+ this.id_compromiso).then(response =>{
				// 	this.Numero_Orden = response.body[0].numorden
				// }).catch(error =>{
				// 	console.log('error', error)
				// })

			},

			consultaEntrega(){
				const payload ={ id: this.edit.id , estatus: this.edit.fase_venta === 6 ? 0:2 }

				this.$http.post('entrega.id', payload).then(response =>{
					// console.log('entregas id', response.body)
					this.chofer = { id: response.body[0].id_chofer, nombre: response.body[0].nombre }
					this.numfac = response.body[0].numfac;
					this.fecha = response.body[0].fecha_entrega; 
					this.hora = response.body[0].hora_entrega;
					this.razonRechazo = response.body[response.body.length-1].obs;
					this.edit.fase_venta === 7 ? this.entregar = 'Reprogramar Entrega': this.entregar = this.entregar;
				}).catch(err =>{
					console.log('err', err)
				})
			},
			consultaRecotización(){
				const payload = { id_compromiso: this.id_compromiso , fase_venta: 4 }
				this.$http.post('recotización',payload).then(response =>{
					// console.log('RECOTIZACION',response.body)
					var len = response.body.length
					this.razonRecotiza = response.body[(response.body.length -1)].obscierre;
				}).catch(err =>{
					console.log('err', err)
				})
			},

			pasarACotizado(){
				const payload = { id :this.id_compromiso,
													fecha: this.traerFechaActual(),
													hora: this.traerHoraActual(),
													fase_venta :3,
													numorden: '',
													aceptado: 0,
													obscierre:''
													}

				this.ConfirmaModal = false; this.dialog = true 
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.post('fase.venta', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				}).catch(error =>{
					console.log('error',error)
				})

			},

			validarEntrega(){
				var fa = this.traerFechaActual() + " " + this.traerHoraActual();
				var fe = this.fecha + " " + this.hora;
				if(!this.chofer.id){this.snackbar=true;this.text="Debes asignar la entrega a un chofer";return}
				if(!this.numfac)   {this.snackbar=true;this.text="Debes especificar el número de factura";return}
				if(fa>=fe)          {this.snackbar=true;this.text="La FECHA y HORA de entrega no pueden ser menores a la actual.";return}
				this.ConfirmaModal=true;
			},

			pasarAEntregar(){
				const payload = { id :this.id_compromiso,
													id_chofer: this.chofer.id,
													numfac: this.numfac,
													fecha: this.traerFechaActual(),
													hora: this.traerHoraActual(),
													fecha_entrega: this.fecha,
													hora_entrega: this.hora,
													fase_venta :6,
													numorden: this.Numero_Orden,
													aceptado: 0
													}

				this.ConfirmaModal = false;
				this.dialog = true ; this.textDialog ="Guardando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.post('entrega.producto', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				}).catch(error =>{
					console.log('error',error)
				})

			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				// this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaCompromisos() //ACTUALIZAR CONSULTA DE CLIENTES
			},

			limpiarCampos(){
				this.razonRechazo ='';
				this.chofer = { id:null, nombre:''};
				this.numfac = ''
			}
		}
	}
</script>