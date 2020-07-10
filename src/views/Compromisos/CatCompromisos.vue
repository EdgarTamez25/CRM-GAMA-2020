<template>
  <v-content class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >
				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>
			
				<v-card-actions class="font-weight-black headline"> COMPROMISOS </v-card-actions>

				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar compromiso"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="NuevoCompromiso(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaCompromisos" ><v-icon>refresh</v-icon> </v-btn>

			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getCompromisos"
			      :search="search"
			      fixed-header
				 		height="500px"
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
						hide-default-footer
						disable-pagination
			    >
						<template v-slot:item.tipo_compromiso="{ item }" > {{ item.tipo_compromiso === 1? 'Interno': 'Externo'}}</template>
						<template v-slot:item.fase_venta="{ item }" >
							<span v-if="item.fase_venta === 1" class="font-weight-bold celeste--text"> {{ fase_ventas[0] }} </span>
							<span v-if="item.fase_venta === 2" class="font-weight-bold orange--text">  {{ fase_ventas[1] }} </span>
							<span v-if="item.fase_venta === 3" class="font-weight-bold blue--text">    {{ fase_ventas[2] }} </span>
							<span v-if="item.fase_venta === 4" class="font-weight-bold orange--text">  {{ fase_ventas[3] }} </span>
							<span v-if="item.fase_venta === 5" class="font-weight-bold morado--text">  {{ fase_ventas[4] }} </span>
							<span v-if="item.fase_venta === 6" class="font-weight-bold morado--text">  {{ fase_ventas[5] }} </span>
							<span v-if="item.fase_venta === 7" class="font-weight-bold red--text">     {{ fase_ventas[6] }} </span>
							<span v-if="item.fase_venta === 8" class="font-weight-bold green--text">   {{ fase_ventas[7] }} </span>
						</template>

			    	<template v-slot:item.action="{ item }" > <!-- AGREGAR UN COMPROMISO  -->
			    		<v-btn color="celeste" class="ma-1" fab small dark  
								v-if="item.fase_venta === 1" 
								@click="NuevoCompromiso(2,item)"
							>
								<v-icon> create </v-icon>
							</v-btn> 

							<!-- VER HISTORIAL DEL COMPROMISO  -->
			    		<v-btn color="green"  class="ma-1" fab small dark 
								v-if=" item.fase_venta === 8" 
								@click="verResumen(item.id)"
							>
								<v-icon> visibility </v-icon>
							</v-btn> 

							<!-- POR COTIZAR Y RECOTIZAR  -->
			    		<v-btn color="orange"  class="ma-1" fab small dark  
								v-if="item.fase_venta === 2 || item.fase_venta === 4" 
								@click="abrirModalFases(item.fase_venta,item)"
							>
								<v-icon> attach_money </v-icon>
							</v-btn> 
							<!-- PRODUCCION * ENTREGAR * RECHAZADO  -->
			    		<v-btn color="morado"  class="ma-1" fab small dark  
								v-if="item.fase_venta === 5 || item.fase_venta === 7  || item.fase_venta === 6"
								@click="abrirModalFases(item.fase_venta,item)"
							>
								<v-icon> local_shipping </v-icon>
							</v-btn> 
							
			    		<v-btn color="red " class="ma-1" fab small dark  v-if="item.fase_venta === 7"
								@click="abreModal(item)"
							>
								<v-icon> highlight_off </v-icon>
							</v-btn> 
				    </template>

			    </v-data-table>
			  </v-card>

				<!-- CONTROLADOR DEL COMPROMISO  -->
				<v-dialog persistent v-model="compromisoModal" width="700px" >	
		    	<v-card>
		    		<ControlCompromiso :param="param" :edit="edit" @modal="compromisoModal = $event" />
		    	</v-card>
		    </v-dialog>

				<!-- CONTROLADOR DE FASES  -->
				<v-dialog persistent v-model="fases" width="500px" >	
		    	<v-card>
		    		<ControldeFases :param="param" :edit="edit" @modal="fases = $event" />
		    	</v-card>
		    </v-dialog>

				<!-- HISTORIAL DEL COMPROMISO -->
				<v-dialog persistent v-model="Historial" width="650px" >	
		    	<v-card class="pa-0">
						<v-card-actions class="rosa white--text">
							<v-card-title  >Fases del compromiso</v-card-title>
							<v-spacer></v-spacer>
							<v-btn color="white" small @click="Historial=false" text><v-icon>clear</v-icon></v-btn>
						</v-card-actions>

						<v-data-table
							:headers="hfases"
							:items="resumen"
							:single-expand="singleExpand"
							:expanded.sync="expanded"
							item-key="id"
							show-expand
							hide-default-header
							hide-default-footer
							disable-pagination
						>
							<template v-slot:item.fase_venta="{ item }">
								<span class="font-weight-bold text-left"> {{ fase_ventas[item.fase_venta-1] }} 
										<span v-if="item.fase_venta === 8" class="overline	"> 
											({{ item.aceptado===1?'Entregado':'Sin entregar'}}) 
										</span>
								</span>
							</template>

							<template v-slot:item.hora="{ item }">
								{{ item.hora >='12:00'? item.hora +' '+'pm': item.hora+ ' '+'am' }}
							</template>

							<template v-slot:expanded-item="{ headers, item }" >
								<td class="celeste white--text " :colspan="headers.length" v-if="item.obscierre">{{ item.obscierre }} </td>
							</template>

							<template v-slot:item.actions="{ item }" >
								<v-btn icon small color="red"><v-icon color="red" v-if="item.obscierre">priority_high</v-icon></v-btn>
							</template>

						</v-data-table>
		    	</v-card>
		    </v-dialog>

				<!-- CONFIRMACION DE PROCESO  -->
				<v-dialog v-model="confirmaModal" persistent max-width="400" > 
					<v-card color="red darken-4" dark>
						<v-card-title class="">
						El proyecto se cerrara para siempre.
						</v-card-title>
						<v-card-text class="my-1">
							<v-textarea
								v-model="obscierre" label="Razon de cierre." hide-details outlined
								placeholder="Escriba por que se cierra el proyecto..." color="white"
							></v-textarea>
						</v-card-text>
						<v-card-subtitle>
							¿Esta seguro de continuar?
						</v-card-subtitle>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="white" text small @click="confirmaModal=false">Cancelar</v-btn>

							<v-btn color="gris" small @click="cerrarProyecto()">Continuar cierre</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog> <!-- CONFIRMACION DE PROCESO  -->

				<!-- PROCESO PARA GUARDAR -->
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
				<!-- FIN PROCESO PARA GUARDAR -->

  		</v-col>
  	</v-row>
  </v-content>
</template>

<script>
	import ControlCompromiso  from '@/views/Compromisos/ControlCompromiso.vue';
	import ControldeFases  from '@/views/Compromisos/controldeFases.vue';
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex';
	var moment = require('moment'); 
	export default {
		mixins:[SelectMixin],
		components: {
			ControlCompromiso,
			ControldeFases
		},
		data () {
			return {
				expanded: [],
        singleExpand: false,
				search: '',
				dialog: false,
				param: 0,
				edit:'',
				resumen:[],
				confirmaModal:false,
				obscierre:'',
				id_compromiso:null,
				hfases: [	{ text: 'fase venta'  , align: 'left'	 , value: 'fase_venta' },
									{ text: 'fecha'   		, align: 'left'	 , value: 'fecha' },
									{ text: 'hora'   		  , align: 'left'	 , value: 'hora' },
									{ text: ''						, value: 'data-table-expand' },
									{ text: ''						, value: 'actions' }

								],
				headers: [
						{ text: '#'   		, align: 'left'	 , value: 'id' },
						{ text: 'Responsable'   		, align: 'left'	 , value: 'nomvend' },
						{ text: 'Tipo'							, align: 'left'	 , value: 'tipo_compromiso' },
						{ text: 'Categoria'					, align: 'left'	 , value: 'nomcatego' },
						{ text: 'Cliente'					  , align: 'left'	 , value: 'nomcli' },
						{ text: 'Fecha'							, align: 'left'	 , value: 'fecha' },
						{ text: 'Hora'							, align: 'left'	 , value: 'hora' },
						{ text: 'Fase de Venta'			, align: 'left'	 , value: 'fase_venta' },
						{ text: '', value: 'action' , sortable: false },

				],
				fase_ventas:['Prospecto','Por Cotizar','Cotizado','Recotizar','Producción','Por Entregar','Entrega Rechazada','Proyecto Cerrado'],
				date: new Date().toISOString().substr(0, 10),
				modal: false,
				compromisoModal: false,
				fases: false,

				snackbar: false,
				text		: '',
				color		: 'error',
				Historial: false,
				dialog: false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',
		
			}
		},

		created(){
			this.consultaCompromisos() // CONSULTAR CLIENTES A VUEX
			moment.locale('es'); /// inciar Moment
		},

		computed:{
			...mapGetters('Compromisos'  ,['getCompromisos','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
		},

		methods:{
			...mapActions('Compromisos'  ,['consultaCompromisos']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			NuevoCompromiso(action, items){
				this.param = action;
				this.edit = items;
				this.compromisoModal = true;
			},

			abrirModalFases(action, items){
				this.param = action;
				this.edit = items;
				this.fases = true;
			},

			abreModal(item ){
				this.id_compromiso=item.id;
				this.confirmaModal=true;
			},

			verResumen(id){
				this.$http.get('ver.resumen/'+id).then(response =>{
					this.resumen = [];
					for(let i =0;i< response.body.length;i++){
						this.resumen.push({ fase_venta: response.body[i].fase_venta,
																fecha			: moment(response.body[i].fecha).format('LL'),
																hora 			: response.body[i].hora,
																aceptado	: response.body[i].aceptado,
																id: response.body[i].id,
																obscierre : response.body[i].obscierre
															})
					}
					this.Historial = true
				}).catch(err =>{
					console.log('err', err)
				})
			},

			cerrarProyecto(){
				if(!this.obscierre){ this.snackbar=true; this.text="Debes de capturar la razon del cierre."; return };

				const payload = { id :this.id_compromiso,
													fecha: this.traerFechaActual(),
													hora: this.traerHoraActual(),
													fase_venta : 8,
													aceptado: 0,
													obscierre: this.obscierre,
													numorden:'',
													}


				this.confirmaModal = false; this.dialog = true ; 
				setTimeout(() => (this.dialog = false), 2000)
			
				this.$http.post('fase.venta', payload).then(response =>{
					this.TerminarProceso(response.body);					
				}).catch(error =>{
					console.log('error', error)
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(() => (this.Correcto = false), 2000)
				this.consultaCompromisos() //ACTUALIZAR CONSULTA DE CLIENTES
			},
		}
	}
</script>
