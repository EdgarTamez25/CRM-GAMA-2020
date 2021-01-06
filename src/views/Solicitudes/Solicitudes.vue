<template>
  <v-content class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >

				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>
				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="mt-3" outlined >
					<v-row class="pa-1 py-0">

						<v-col cols="12" sm="8" md="6">
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > SOLICITUDES DE PEDIDO </v-card-actions>
						</v-col>

							<v-col cols="12" sm="4" md="2">
							<v-select
                  v-model="estatus" :items="Estatus" item-text="nombre" item-value="id"  dense
                   hide-details  placeholder="Estatus " return-object outlined append-icon="mdi-circle-slice-5"
                ></v-select> 
						</v-col>

						<v-col cols="6" md="2" > <!-- FECHA DE COMPROMISO -->
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

						<v-col cols="6" md="2"  > <!-- FECHA DE COMPROMISO -->
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
					
					</v-row>

					<v-card-actions class="py-0 my-0">
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar solicitud"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <!-- <v-btn small class="celeste" dark @click="NuevoCompromiso(1)">Agregar </v-btn> -->
						<v-btn small  dark color="green" @click="ImprimirExcel()"> <v-icon >mdi-microsoft-excel </v-icon> </v-btn>
			      <v-btn  class="gris" icon dark @click="consultaSolicitudes()" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
					
			    <v-data-table
			      :headers="headers"
			      :items="getSolicitudes"
			      :search="search"
			      fixed-header
						hide-default-footer
				 		:height="tamanioPantalla"
						:loading ="Loading"
						:page.sync="page"
      			:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"
						dense
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  color="green" class="ma-1"  small dark  @click="verSolicitud(item)">
								<v-icon> mdi-eye </v-icon>
							</v-btn> 
			    	</template>

						<template v-slot:item.hora="{ item }">
							{{ item.hora >='12:00'? item.hora +' '+'pm': item.hora+ ' '+'am' }}
						</template>

						<template v-slot:item.fecha="{ item }">
							<span> {{  moment(item.fecha).format('LL') }} </span>
						</template>

						<template v-slot:item.nota="{ item }" >
							<v-btn color="blue"  dark small @click="abrirNota(item.nota)" v-if="item.nota"> ver nota </v-btn>
							<v-btn outlined small v-else> sin nota </v-btn>

						
						</template>
			    </v-data-table>
			  </v-card>

					<v-dialog v-model="verNota"  hide-overlay width="500px">
						<v-card	 class="pa-2" outlined>
							<v-card-text class="font-weight-black  pa-2 subtitle-1" > {{ nota }} </v-card-text>
							<v-card-text align="right" class="py-0">
								<v-btn  outlined small color="red" @click="verNota = false"> Cerrar </v-btn>
							</v-card-text>
						</v-card>
					</v-dialog>


				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
		
  		</v-col>
  	</v-row>
  </v-content>
</template>

<script>
	var moment = require('moment'); moment.locale('es') /// inciar Moment 
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import  ExcelExport from '@/mixins/ExcelExport.js';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		mixins:[ExcelExport,SelectMixin],
		components: {
		},
		data () {
			return {
				titulo: 'Solicitudes',
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
						{ text: '#'   				, align: 'left'	 , value: 'id' },
            { text: 'Responsable' , align: 'left'	 , value: 'nomusuario' },
						{ text: 'Cliente'			, align: 'left'	 , value: 'nomcli' },
						{ text: 'Fecha'			  , align: 'left'	 , value: 'fecha' },
						{ text: 'Hora'		   	, align: 'left'	 , value: 'hora' },
						{ text: 'Nota'			  , align: 'left'	 , value: 'nota' },
						{ text: '', value: 'action' , sortable: false },
				],
				nota: '',
				verNota: false,
				modal: false,
				compromisoModal: false,
				fases: false,

				estatus: {  id: 1, nombre:'Pendiente'},
				Estatus:[ { id: 1, nombre:'Pendiente'},
									{ id: 2, nombre:'Asignado' },
									{ id: 3, nombre:'Terminado'},
									{ id: 4, nombre:'Cancelado'}
								],
				fecha1: '',
				fechamodal1:false,
				fecha2: '',
				fechamodal2:false,

				snackbar: false,
				text		: '',
				color		: 'error',
				Historial: false,
				dialog: false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				mesAnteriorPrimerDia : moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
				mesActualUltimoDia: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
				// nextMonthLastDay: moment().add(1, 'months').endOf('month').format("YYYY-MM-DD"),
			}
		},

		created(){
			this.fecha1 = this.mesAnteriorPrimerDia;
			this.fecha2 = this.mesActualUltimoDia;
			this.init();
		},

		watch:{
			estatus(){
				this.init();
			},

			fecha1(){
				this.init();
			},

			fecha2(){
				this.init();
			}
		},

		computed:{
			...mapGetters('Solicitudes'  ,['getSolicitudes','Loading']), // IMPORTANDO USO DE VUEX - (GETTERS)
			tamanioPantalla () {
				switch (this.$vuetify.breakpoint.name) {
					case 'xs':
						return this.$vuetify.breakpoint.height -300
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
			...mapActions('Solicitudes'  ,['consultaSolicitudes','guardaParametrosConsulta']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			init(){
				const payload = { estatus: this.estatus.id,
													fecha1 : this.fecha1,
													fecha2 : this.fecha2,
												}
					this.guardaParametrosConsulta(payload);
					this.consultaSolicitudes()
			},

			abrirNota(nota){
				this.nota = nota;
				this.verNota = true;
			},	

			verSolicitud(item){
				this.$router.push({ name:'detsolicitud' , params:{ solicitud: item }}) 
			},

			ImprimirExcel(){
				let tHeaders=[], tValores= [];
				for(let j =0;j< this.headers.length; j++){
					tHeaders.push(this.headers[j].text);
					tValores.push(this.headers[j].value);
				}
				let tInformacion = this.getSolicitudes
				this.titulo = this.titulo +'_'+ this.estatus.nombre +"_"+ this.fecha1 +"-"+ this.fecha2;
				this.manejarDescarga(this.titulo ,tHeaders,tValores,tInformacion)
			},

	
		}
	}
</script>
