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
						<v-col cols="12"  md="6" >
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > ORDENES DE TRABAJO </v-card-actions>
						</v-col>

						<v-col cols="12" sm="4" md="2">
							<v-select
                v-model="estatus" :items="Estatus" item-text="nombre" item-value="id"  dense
                 hide-details  placeholder="Estatus " return-object outlined append-icon="mdi-circle-slice-5"
              ></v-select> 
						</v-col>

						<!-- <v-col cols="12" sm="4" md="2">
							<v-select
									v-model="depto" :items="deptos" item-text="nombre" item-value="id" outlined color="celeste"  
									dense hide-details  label="Departamentos" return-object placeholder ="Departamentos"  
							></v-select>
						</v-col> -->

						<v-col cols="6" sm="4" md="2" > <!-- FECHA DE COMPROMISO -->
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

						<v-col cols="6" sm="4" md="2"  > <!-- FECHA DE COMPROMISO -->
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

					<v-card-actions >
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar orden de trabajo"
			        single-line
			        hide-details
							filled dense
			      ></v-text-field>
			      <v-spacer></v-spacer>
						<v-btn small  dark color="green" @click="ImprimirExcel()"> <v-icon >mdi-microsoft-excel </v-icon> </v-btn>
			      <!-- <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn> -->
			      <v-btn  class="gris" icon dark @click="init()" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
			    <v-data-table
			      :headers="headers"
			      :items="getOT"
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
							<v-btn  color="rosa " class="ma-1"  small dark  @click="abrirModal(2,item)">
								<v-icon> mdi-pencil </v-icon>
							</v-btn> 
			    	</template>

						<template v-slot:item.oc="{ item }">
							{{ item.oc ? item.oc : 'SIN O.C.'}}
						</template>

						<template v-slot:item.hora="{ item }">
							{{ item.hora >='12:00'? item.hora +' '+'pm': item.hora+ ' '+'am' }}
						</template>

						<template v-slot:item.fecha="{ item }">
							<span> {{  moment(item.fecha).format('LL') }} </span>
						</template>
					
			    </v-data-table>
			  </v-card>

				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
		
				<v-dialog persistent v-model="otModal" width="700px" >	
		    	<v-card class="pa-3">
		    		<controlOT :modoVista="modoVista" :parametros="parametros" @modal="otModal = $event" />
		    	</v-card>
		    </v-dialog>

  		</v-col>
  	</v-row>
  </v-main>
</template>

<script>
	var moment = require('moment'); moment.locale('es') /// inciar Moment 
	import  metodos from '@/mixins/metodos.js';
	import  ExcelExport from '@/mixins/ExcelExport.js';
	import {mapGetters, mapActions} from 'vuex';
	import controlOT from '@/views/OT/controlOT.vue';

	export default {
		mixins:[ExcelExport,metodos],
		components: {
			controlOT
		},
		data () {
			return {
				titulo: 'Ordenes de trabajo',
				page: 1,
        pageCount: 0,
				itemsPerPage: 20,
				search: '',
				
        otModal: false,
				parametros: [],
				modoVista : 0, 
				
				headers: [
					{ text: 'N° de Orden' , align: 'start' , value: 'id' },
						{ text: 'Cliente'			, align: 'left'	 , value: 'nomcli' },
						{ text: 'O.C.'			  , align: 'left'	 , value: 'oc' },
						{ text: 'Fecha'			  , align: 'left'	 , value: 'fecha' },
					{ text: '# Solicitud'	, align: 'left'	 , value: 'id_solicitud' },
						{ text: 'Solicitante'	, align: 'left'	 , value: 'solicitante' },

						{ text: '' 						, align: 'right' , value: 'action' , sortable: false },
        ],

				depto : { id:1, nombre:'FLEXOGRAFÍA'},
				deptos: [{ id:1, nombre:'FLEXOGRAFÍA'}],	
				estatus: {  id: 1, nombre:'Pendiente'},
				Estatus:[ { id: 1, nombre:'Pendiente'},
									{ id: 3, nombre:'Terminado'},
									{ id: 2, nombre:'Cancelado'},	
				],	
				
				fecha1:moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"), 
				fechamodal1:false,
				fecha2: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
				fechamodal2:false,

				alerta: { 
					snackbar: false,
					text: '',
					color: 'error',
					vertical: true
				},
        
				Correcto   : false,
        textCorrecto: '',
        colorCorrecto: 'green',

				mesAnteriorPrimerDia : moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
				mesActualUltimoDia: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
				// nextMonthLastDay: moment().add(1, 'months').endOf('month').format("YYYY-MM-DD"),
			}
		},

		created(){
			// console.log('Parametros',this.Parametros)
			if(this.Parametros != undefined){
				this.estatus  = { id: this.Parametros.estatus };
				this.depto    = { id: this.Parametros.id_depto };
				this.fecha1   = this.Parametros.fecha1;
				this.fecha2   = this.Parametros.fecha2;
			}

			// this.fecha1 = this.mesAnteriorPrimerDia;
			// this.fecha2 = this.mesActualUltimoDia;
			this.init();
		},

		watch:{
			fecha1(){
				this.init();
			},

			fecha2(){
				this.init();
			},

			depto(){
				this.init()
			},
			estatus(){
				this.init()
			},

		},

		computed:{
			...mapGetters('OT'    ,['getOT','Loading','Parametros']), // IMPORTANDO USO DE VUEX - (GETTERS)
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
			...mapActions('OT'  ,['consultaOT','guardaParametrosConsulta']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			init(){
        // this.consultaDepartamentos();
				const parametros = new Object();
							// parametros.id_depto    = this.depto.id;
							// parametros.id_sucursal = this.getdatosUsuario.id_sucursal;
							parametros.fecha1      = this.fecha1;
							parametros.fecha2      = this.fecha2;
							parametros.estatus     = this.estatus.id;
        // this.guardaParametrosConsulta(parametros);
        this.consultaOT(parametros);
			},

			abrirModal(modoVista, item){
        this.modoVista  = modoVista;
				this.parametros = item? item : '';
				this.otModal = true;
			},

			irDetalleOt(modoVista, item){
        const payload = new Object();
        payload.modoVista  = modoVista;
				payload.parametros = item? item : '';

				this.$router.push({ name:'detalle-ot' , params:{ detalle: payload }}) 
			},

			ImprimirExcel(){
				if(!this.getOT.length){
					this.alerta.snackbar = true; this.alerta.text="No hay información que exportar"; this.alerta.color="red darken-4";
					return
				}
				let tHeaders=[], tValores= [];
				let theaders = [{ text: "Id"					    , value:"id" },
												{ text: "Solicitante"     , value:"solicitante"},
												{ text: "Cliente"         , value:"nomcli"},
												{ text: "Orden de Compra" , value:"oc"},
												{ text: "Solicitud"       , value:"id_solicitud"},
												{ text: "Fecha"           , value:"fecha"},
												{ text: "Hora"            , value:"hora"},
											 ]

				for(let j =0;j< theaders.length; j++){
					tHeaders.push(theaders[j].text);
					tValores.push(theaders[j].value);
				}
				let tInformacion = this.getOT
				this.titulo = this.titulo +'_'+ this.depto.nombre +"_"+ this.fecha1 +"-"+ this.fecha2;
				this.manejarDescarga(this.titulo ,tHeaders,tValores,tInformacion)
			},
	
		}
	}
</script>
