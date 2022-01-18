<template>
  <v-main class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >

				<v-snackbar v-model="alerta.snackbar" :vertical="alerta.vertical" top right :color="alerta.color" class="subtitle-1" > 
					{{ alerta.text }} 
						<v-btn dark text  @click="alerta.snackbar = false">
							Cerrar
						</v-btn>
				</v-snackbar>

				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="mt-3" outlined >
					<v-row class="pa-1 py-0">

						<v-col cols="12" sm="6" md="8">
							<v-card-actions class="font-weight-black headline py-0 mt-1 " > COMPROMISOS </v-card-actions>
						</v-col>

						<v-col cols="6" sm="3" md="2">
							<v-dialog ref="fecha1" v-model="fechamodal1" :return-value.sync="fecha1" persistent width="290px">
								<template v-slot:activator="{ on }">
									<v-text-field
										v-model="fecha1" label="Fecha Inicio" append-icon="event" readonly v-on="on"
										 dense hide-details color="celeste" outlined
									></v-text-field>
								</template>
								<v-date-picker v-model="fecha1" locale="es-es" color="rosa"  scrollable>
									<v-spacer></v-spacer>
									<v-btn text small color="gris" @click="fechamodal1 = false">Cancelar</v-btn>
									<v-btn dark small color="rosa" @click="$refs.fecha1.save(fecha1)">OK</v-btn>
								</v-date-picker>
							</v-dialog>
						</v-col>

						<v-col cols="6" sm="3" md="2" >
							<v-dialog ref="fecha2" v-model="fechamodal2" :return-value.sync="fecha2" persistent width="290px">
								<template v-slot:activator="{ on }">
									<v-text-field
										v-model="fecha2" label="Fecha fin" append-icon="event" readonly v-on="on"
									  dense hide-details color="celeste" outlined
									></v-text-field>
								</template>
								<v-date-picker v-model="fecha2" locale="es-es" color="rosa"  scrollable>
									<v-spacer></v-spacer>
									<v-btn text small color="gris" @click="fechamodal2 = false">Cancelar</v-btn>
									<v-btn dark small color="rosa" @click="$refs.fecha2.save(fecha2)">OK</v-btn>
								</v-date-picker>
							</v-dialog>
						</v-col>

						<v-col cols="12" sm="8" class="py-0">
							<v-text-field
								v-model="search"
								append-icon="search"
								label="Buscar compromiso"
								single-line
								hide-details
								filled dense
							></v-text-field>
						</v-col>

						<v-col cols="12" sm="4" class="py-0">
							<v-card-actions class="">
								<v-spacer></v-spacer>
								<v-btn  dark color="green" @click="ImprimirExcel()"> <v-icon >mdi-microsoft-excel </v-icon> </v-btn>
								<v-btn  class="celeste" dark @click="NuevoCompromiso(1)">Agregar </v-btn>
								<v-btn  class="gris" icon dark @click="consultaCompromisos" ><v-icon>refresh</v-icon> </v-btn>
							</v-card-actions>
						</v-col>


					</v-row> 

					
					
			    <v-data-table
			      :headers="headers"
			      :items="getCompromisos"
			      :search="search"
			      fixed-header
				 		:height="tamanioPantalla"
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
						hide-default-footer
						:page.sync="page"
      			:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"
						dense
			    >
						<template v-slot:item.tipo="{ item }" > 
							<v-btn :color="item.tipo ===1?'rosa':'celeste'" class="font-weight-black" text small > 
								{{ item.tipo === 1? 'CLIENTE': 'PROSPECTO'}} 
							</v-btn>
						</template>
					
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  :color="item.tipo ===1?'rosa':'celeste'" class="ma-1"  small dark  @click="NuevoCompromiso(2,item)">
								<v-icon> create </v-icon>
							</v-btn> 
			    	</template>

						<template v-slot:item.hora="{ item }">
							{{ item.hora >='12:00'? item.hora +' '+'pm': item.hora+ ' '+'am' }}
						</template>
					

						<template v-slot:item.fecha="{ item }">
							<span v-if="item.fecha < fechaActual" class="error--text">
								{{  moment(item.fecha).format('LL') }} 
							</span>
							<span v-if="item.fecha === fechaActual" class="green--text">
								{{  moment(item.fecha).format('LL') }} 
							</span>
							<span v-if="item.fecha > fechaActual" class="orange--text">
								{{  moment(item.fecha).format('LL') }} 
							</span>
						</template>

						<template v-slot:item.cumplimiento="{ item }" > 
							<v-btn class="font-weight-black" dark small
										 color="orange darken-4" 
										 @click="abrirResultado(item)"
										 v-if="item.cumplimiento === 1 && item.obs_usuario " > 
								Resultados
							</v-btn>
						</template>

			    </v-data-table>
			  </v-card>

				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>

				<v-dialog v-model="verResultado" width="500px">
					<v-card class="pa-3">
						<v-card-title> RESULTADO DEL COMPROMISO {{ resultados.id_solicitud }} </v-card-title>
						<v-card-actions class="py-0">
							<v-card-subtitle>Fecha Cierre: <br> {{  moment(resultados.fecha).format('LL') }} </v-card-subtitle> 
							<v-spacer></v-spacer>
							<v-card-subtitle>Hora Cierre: <br> {{ resultados.hora >='12:00'? resultados.hora +' '+'pm': resultados.hora+ ' '+'am' }}</v-card-subtitle>
						</v-card-actions>
						<v-card-text> {{ resultados.obs }} </v-card-text>
						<v-card-actions>
							<v-btn small dark block color="gris" @click="verResultado = false">Cerrar</v-btn> 
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- CONTROLADOR DEL COMPROMISO  -->
				<v-dialog persistent v-model="compromisoModal" width="700px" >	
		    	<v-card class="pa-3">
		    		<ControlCompromiso :modoVista="modoVista" :data="data" @modal="compromisoModal = $event" />
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
							<br><v-progress-linear indeterminate color="white" class="mb-0" persistent></v-progress-linear>
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
  </v-main>
</template>

<script>
	var moment = require('moment'); moment.locale('es') /// inciar Moment 
	import ControlCompromiso  from '@/views/Compromisos/ControlCompromiso.vue';
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import  ExcelExport from '@/mixins/ExcelExport.js';

	import {mapGetters, mapActions} from 'vuex';

	export default {
		mixins:[ExcelExport,SelectMixin],
		components: {
			ControlCompromiso,
		},
		data () {
			return {
				titulo: 'Compromisos',

				page: 1,
        pageCount: 0,
				itemsPerPage: 20,
				search: '',

				dialog: false,
				modoVista: 0,
				data:'',
				resumen:[],
				confirmaModal:false,
				obscierre:'',
				id_compromiso:null,
				headers: [
						// { text: '#'   		, align: 'left'	 , value: 'id' },
						{ text: 'Responsable'   		, align: 'left'	 , value: 'nomvend' },
						{ text: 'Tipo'							, align: 'left'	 , value: 'tipo' },
						{ text: 'Categoria'					, align: 'left'	 , value: 'nomcatego' },
						{ text: 'Cliente'					  , align: 'left'	 , value: 'nomcli' },
						{ text: 'Fecha'							, align: 'left'	 , value: 'fecha' },
						{ text: 'Hora'							, align: 'left'	 , value: 'hora' },
						{ text: 'Cumplimiento'			, value: 'cumplimiento'},

						{ text: '', value: 'action' , sortable: false },
				],
				verResultado: false, 
				resultados: {},
				fechaActual:'',
				fecha1: '',
				fechamodal1:false,
				fecha2: '',
				fechamodal2:false,

				mesAnteriorPrimerDia : moment().subtract(1,'months').startOf('month').format("YYYY-MM-DD"),
				mesActualUltimoDia   : moment().subtract('months').endOf('months').format("YYYY-MM-DD"),

				modal: false,
				compromisoModal: false,
				fases: false,

				alerta: { 
					snackbar: false,
					text: '',
					color: 'error',
					vertical: true
				},
				Historial: false,
				dialog: false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				DatosExcel:[]
		
			}
		},

		created(){
			this.fecha1 = this.mesAnteriorPrimerDia;
			this.fecha2 = this.mesActualUltimoDia;
			this.init()

		},

		watch:{
			fecha1(){
				this.init();
			},

			fecha2(){
				this.init();
			},
		},

		computed:{
			...mapGetters('Compromisos'  ,['getCompromisos','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			tamanioPantalla () {
				switch (this.$vuetify.breakpoint.name) {
					case 'xs':
					 return 'auto';
						// return this.$vuetify.breakpoint.height -300
					break;
					case 'sm': 
						return this.$vuetify.breakpoint.height -300
					break;
					case 'md':
						return this.$vuetify.breakpoint.height -300
					break;
					case 'lg':
						return this.$vuetify.breakpoint.height -300
					break;
					case 'xl':
						return this.$vuetify.breakpoint.height -300
					break;
				}
			},
		},

		methods:{
			...mapActions('Compromisos'  ,['consultaCompromisos','guardarParametros']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			init(){
				this.fechaActual = this.traerFechaActual();
				const parametros = new Object();
							parametros.fecha1 = this.fecha1;
							parametros.fecha2 = this.fecha2;
				this.guardarParametros(parametros);
				this.consultaCompromisos() 
			},

			NuevoCompromiso(modoVista, data){
				this.modoVista = modoVista;
				this.data = data;
				this.compromisoModal = true;
			},

			abreModal(item ){
				this.id_compromiso=item.id;
				this.confirmaModal=true;
			},

			abrirResultado(item){
				this.resultados = { obs: item.obs_usuario,
														id_solicitud: item.id,
														fecha: item.fecha_cierre,
														hora: item.hora_cierre };
				this.verResultado = true;
			},

			ImprimirExcel(){
				if(!this.getCompromisos.length){
					this.alerta.snackbar = true; this.alerta.text="No hay información que exportar"; this.alerta.color="red darken-4";
					return
				}

				let tHeaders=[], tValores= [];
				let theaders = [
												{ text: 'Id'   						, value: 'id' },
												{ text: 'Responsable'   	, value: 'nomvend' },
												{ text: 'Tipo'						, value: 'nomtipo' },
												{ text: 'Categoria'				, value: 'nomcatego' },
												{ text: 'Cliente'					, value: 'nomcli' },
												{ text: 'Fecha'						, value: 'fecha' },
												{ text: 'Hora'						, value: 'hora' },
												{ text: 'Fecha Cierre'	  , value: 'fecha_cierre' },
												{ text: 'Hora Cierre'			, value: 'hora_cierre' },
												{ text: 'Confirmacíon'		, value: 'confirma_cita'},
												{ text: 'Cumplimiento'		, value: 'cumplimiento'},
												{ text: 'Creador'			    , value: 'creador' },
												{ text: 'Resultados'			, value: 'obs_usuario' }
											]

				for(let j =0;j< theaders.length; j++){
					tHeaders.push(theaders[j].text);
					tValores.push(theaders[j].value);
				}

				let tInformacion = this.ModificaInfo(this.getCompromisos);
				this.titulo = this.titulo + " " + this.fecha1 + "-"+this.fecha2;
				this.manejarDescarga(this.titulo,tHeaders,tValores,tInformacion)
			},


			ModificaInfo(data){
				let tInformacion = [];
				for(let i=0; i<data.length; i++){
					tInformacion.push({ id					 : data[i].id,
															nomvend      : data[i].nomvend,
															nomtipo      : data[i].tipo ===1 ? "CLIENTE": "PROSPECTO",
															nomcatego    : data[i].nomcatego,
															nomcli       : data[i].nomcli,
															fecha        : data[i].fecha,
															hora         : data[i].hora,
															fecha_cierre : data[i].fecha_cierre,
															hora_cierre  : data[i].hora_cierre,
															confirma_cita: data[i].confirma_cita === 1? "CITA CONFIRMADA" : "POR CONFIRMAR",
															cumplimiento : data[i].cumplimiento  === 1? "REALIZADO" : "PENDIENTE",
															creador      : data[i].creador,
															obs_usuario  : data[i].obs_usuario
														})
				}
				return tInformacion;
			}
	
		}
	}
</script>
