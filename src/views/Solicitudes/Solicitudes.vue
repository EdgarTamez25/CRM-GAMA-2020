<template>
  <v-main class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >

				<v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
					<strong> {{alerta.texto}} </strong>
					<template v-slot:action="{ attrs }">
						<v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
					</template>
				</v-snackbar>
				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="mt-3 pa-3" outlined  >
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

					<v-row class="pa-1">
						<v-col cols="12" sm="6" class="py-0 my-0">
							<v-text-field
								v-model="search"
								append-icon="search"
								label="Buscar solicitud"
								single-line
								hide-details
								filled dense
							></v-text-field>
						</v-col>

						<v-col cols="12" sm="6" class="py-0 my-0  text-right">
							<v-btn small class="ma-1" dark color="green" @click="ImprimirExcel()"> <v-icon >mdi-microsoft-excel </v-icon> </v-btn>
			      	<v-btn small class=" ma-1 celeste" dark      @click="nuevaSol.modalSolicitud = true">Agregar </v-btn>
			      	<v-btn small class=" ma-1 gris" icon dark    @click="init()" ><v-icon>refresh</v-icon> </v-btn>
						</v-col>
					</v-row>
					
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
							<span v-if="item.fecha < fecha_actual"   class="red--text">    {{  moment(item.fecha).format('LL') }} </span>
							<span v-if="item.fecha === fecha_actual" class="orange--text"> {{  moment(item.fecha).format('LL') }} </span>
							<span v-if="item.fecha > fecha_actual"   class="green--text">  {{  moment(item.fecha).format('LL') }} </span>
						</template>

						<template v-slot:item.nota="{ item }" >
							<!-- <v-btn color="blue"  dark small @click="abrirNota(item)" v-if="item.nota"> ver nota </v-btn>
							<v-btn outlined small v-else> sin nota </v-btn> -->
							<span class="font-weight-bold caption blue--text text-justify" v-if="item.nota"> {{ item.nota }} </span> 
							<span class="font-weight-bold caption blue--text text-justify" v-else> {{ item.nota }} </span> 
						</template>
			    </v-data-table>
			  </v-card>

		    <overlay v-if="overlay"/>

				<v-dialog v-model="verNota"  hide-overlay width="500px">
					<v-card	 class="pa-3" outlined>
						<v-card-text class="pa-2 py-0 subtitle-1" > 
							<span> SOLICITUD: {{ nota.id }}  </span>
						</v-card-text>
						<v-card-text class="pa-2 py-0 subtitle-1" > 
							<span> CLIENTE  : {{ nota.nomcli }}  </span>
						</v-card-text>
						<v-divider class="my-3"></v-divider>
						<v-card-subtitle class="font-weight-black  pa-2 py-0 subtitle-2">
							{{ nota.nota }}
						</v-card-subtitle>
						<v-card-actions align="right" class="mt-6 py-0">
							<v-btn block outlined small color="red" @click="verNota = false"> Cerrar </v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<v-dialog v-model="nuevaSol.modalSolicitud" persistent width="500px">
					<v-card class="pa-2">
						<v-card-text class="font-weight-black  pa-2 subtitle-1" >SOLICITUD </v-card-text>

						<v-col cols="12" > <!-- CLIENTE -->
							<v-autocomplete
								:items="clientes" v-model="cliente" item-text="nombre" item-value="id" label="Clientes" 
								dense outlined hide-details color="celeste" append-icon="people" return-object
							></v-autocomplete>
						</v-col>
						<v-col cols="12" >  <!-- VENDEDORES -->
							<v-autocomplete
								:items="vendedores" v-model="vendedor" item-text="nombre" tem-value="id" label="Responsable" 
								dense outlined hide-details color="celeste" append-icon="persons" return-object
							></v-autocomplete>
						</v-col>

						<v-col cols="12">
							<v-textarea
								v-model="comentario" label="Nota"	rows="4" outlined placeholder="Escribe aquí tus comentarios..." >
							</v-textarea>
						</v-col>

						<v-card-actions>
							<v-btn outlined small color="error" @click="nuevaSol.modalSolicitud = false">Cancelar</v-btn>
							<v-spacer></v-spacer>
							<v-btn v-if="nuevaSol.modo === 1" small color="success" @click="Preparar_Objeto()">Crear Solicitud</v-btn>
							<v-btn v-if="nuevaSol.modo === 2" small color="success" @click="Preparar_Objeto()">Actualizar Solicitud</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>


				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
		
  		</v-col>
  	</v-row>
  </v-main>
</template>

<script>

	var moment = require('moment'); moment.locale('es') /// inciar Moment 
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import  ExcelExport from '@/mixins/ExcelExport.js';
	import {mapGetters, mapActions} from 'vuex';
  import overlay         from '@/components/overlay.vue'


	export default {
		mixins:[ExcelExport,SelectMixin],
		components: {
      overlay,
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
									{ id: 3, nombre:'Finalizado'},
									{ id: 4, nombre:'Cancelado'}
								],
				fecha1: moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
				fechamodal1:false,
				fecha2: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
				fechamodal2:false,
				fecha_actual: '',
				nuevaSol: { modalSolicitud: false, 
										modo: 1,
									},
				clientes	: [],
				cliente		: {id:null, nombre:''},
				vendedores : [],
				vendedor	 : {id:null, nombre:''},

				comentario: '',
				overlay   : false,


				alerta: { activo: false, texto:'', color:'error' },

				dialog: false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				// mesAnteriorPrimerDia : moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
				// mesActualUltimoDia: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
				// nextMonthLastDay: moment().add(1, 'months').endOf('month').format("YYYY-MM-DD"),
			}
		},

		created(){
			this.fecha_actual = this.traerFechaActual();
			
			if(this.Parametros.estatus != undefined){
				this.estatus = { id: this.Parametros.estatus};
				this.fecha1  = this.Parametros.fecha1
				this.fecha2  = this.Parametros.fecha2
			}
			this.consultar_Clientes();
			this.consultar_Vendedores()

			this.init();
			// var actualizar  = setInterval(() => { this.consultaAutomatica() }, 10000);
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
			...mapGetters('Solicitudes'  ,['getSolicitudes','Loading','Parametros']), // IMPORTANDO USO DE VUEX - (GETTERS)
      ...mapGetters('Login' ,['getdatosUsuario']), 

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
			...mapActions('Solicitudes'  ,['consultaSolicitudes','guardaParametrosConsulta','consultaAutomatica']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			init(){
				const payload = new Object();
							payload.fecha1  = this.fecha1;
							payload.fecha2  = this.fecha2;
							payload.estatus = this.estatus.id;
					// this.guardaParametrosConsulta(payload);
					this.consultaSolicitudes(payload)
			},

			Preparar_Objeto(){

				if(!this.cliente.id){ 
					this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL CLIENTE', color:'error' }; return;
				}
				if(!this.vendedor.id){ 
					this.alerta = { activo: true, texto:'NO PUEDES OMITIR EL RESPONSABLE', color:'error' }; return;
				}
				this.overlay = true; this.nuevaSol.modalSolicitud = false;

				const payload = new Object()
							payload.id_cliente = this.cliente.id
							payload.id_usuario = this.vendedor.id
							payload.fecha      = this.traerFechaActual();
							payload.hora       = this.traerHoraActual();
							payload.nota       = this.comentario ? this.comentario : '';
				
				this.$http.post('crear.nueva.solicitud', payload).then( response =>{
					this.alerta = { activo: true, texto:response.bodyText, color:'green' };
					this.init();
				}).catch( error =>{
					this.alerta = { activo: true, texto:error.bodyText, color:'error' };
				}).finally( ()=> { 
					this.overlay = false;
				})

			},

			abrirNota(nota){
				this.nota = nota
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
