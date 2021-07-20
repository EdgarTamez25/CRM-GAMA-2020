<template>
  <v-main class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >

				 <v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
						<strong> {{alerta.text}} </strong>
						<template v-slot:action="{ attrs }">
							<v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
						</template>
					</v-snackbar>
				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="mt-3" outlined >
					 <v-row class="pa-1 py-0">

						<v-col cols="12" sm="8" md=4>
							<v-card-actions class="font-weight-black headline py-0 mt-1 " > DESARROLLO DE PROYECTOS </v-card-actions>
						</v-col>

            <v-col cols="6" sm="4" md="2">
							<v-select
                v-model="departamento" :items="departamentos" item-text="nombre" item-value="id"  dense
                hide-details  placeholder="Departamentos " return-object outlined 
              ></v-select> 
						</v-col>

						<v-col cols="6" sm="4" md="2">
							<v-select
                v-model="estatus" :items="Estatus" item-text="nombre" item-value="id"  dense
                hide-details  placeholder="Estatus " return-object outlined append-icon="mdi-circle-slice-5"
              ></v-select> 
						</v-col>

						<v-col cols="6" sm="4" md="2" >
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

						<v-col cols="6" sm="4" md="2"  >
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
							filled dense
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <!-- <v-btn small class="celeste" dark @click="NuevoCompromiso(1)">Agregar </v-btn> -->
						<v-btn small  dark color="green" @click="ImprimirExcel()"> <v-icon >mdi-microsoft-excel </v-icon> </v-btn>
			      <v-btn  class="gris" icon dark @click="init()" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
			    <v-data-table
			      :headers="headers"
			      :items="getSolicitudesDDD"
						item-key="id_key"
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
						<template v-slot:item.tipo="{ item }"  >
							<span class="celeste--text caption"  v-if="item.tipo === 1"> Solicitud de Pedido </span>
							<span class="celeste--text caption"  v-if="item.tipo === 2"> Solicitud de Cotización </span>
						</template>

						<template v-slot:item.nomcli = "{ item }"  >
							<span class="caption" > {{  item.nomcli }} </span>
						</template>
						<template v-slot:item.nomvend = "{ item }"  >
							<span class="caption"> {{  item.nomvend }} </span>
						</template>
						<template v-slot:item.fecha="{ item }">
							<span class="caption"> {{  moment(item.fecha).format('LL') }} </span>
						</template>
						<template v-slot:item.tipo_prod="{ item }">
							<span class="font-weight-black rosa--text caption"     v-if="item.tipo_prod === 1"> Producto Existente </span>
							<span class="font-weight-black celeste--text caption"  v-if="item.tipo_prod === 2"> Nuevo Producto </span>
						</template>	
						<template v-slot:item.codigo="{ item }">
							<span class="font-weight-black caption "> {{ item.codigo }}</span>
						</template>
						<template v-slot:item.cantidad="{ item}">
							<span class="font-weight-black caption "> {{ item.cantidad }}</span>
						</template>

						<template v-slot:item.encargado ="{ item }">
							<v-btn small  text color="indigo" 
										 v-if="item.id_encargado != null" 
										 @click="EncargadoModal= true,DatosEncargado=item"
										 :disabled="estatus.id !=4? false:true"> 
								{{ item.encargado }}
							</v-btn>
							<v-btn small dark text color="red" v-else 
										@click="EncargadoModal= true,DatosEncargado=item"
							      :disabled="estatus.id !=4? false:true"> Asignar </v-btn>
						</template>

						<template v-slot:item.action="{ item }" v-if="estatus.id !=4">
			    		<v-btn  color="green" class="ma-1"  small dark  @click="verTareaAsignada(item)" v-if=" item.id_encargado !=null">
								<v-icon> mdi-eye </v-icon>
							</v-btn> 
							<v-btn text small color="error" class="mx-1 mt-1" 
											@click="modalCancelar = true; partidaAEditar= item">
								<v-icon>mdi-close-thick</v-icon> 
							</v-btn>
			    	</template>
			    </v-data-table>
			  </v-card>

				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
  		</v-col>
  	</v-row>


		<v-dialog v-model="resultados" width="500px" persistent>
			<v-card class="pa-4">
				<resultadosActividad
				 :informacion='informacion' 
				 @modal="resultados = $event"
				/>
			</v-card>
		</v-dialog>

		<v-dialog v-model="EncargadoModal" persistent width="500">
			<v-card class="pa-1">
				<v-card-text class="font-weight-black headline pa-3 mt-1" align="center" v-if="!DatosEncargado.id_encargado" >QUIERO ATENDER ESTA SOLICITUD  </v-card-text>
				<v-card-text v-else align="left" class="font-weight-black headline pa-3 mt-1">
						ACTUALMENTE EL USUARIO <span class="green--text">  {{ DatosEncargado.encargado }} </span>  ATIENDE ESTA SOLICITUD.
				</v-card-text>
				<v-card-subtitle class="font-weight-black subtitle-1" align="center" v-if="DatosEncargado.id_encargado && getdatosUsuario.id != DatosEncargado.id_encargado"  >
					¿DESEA ASIGNARSE ESTA SOLICITUD?
				</v-card-subtitle>
				<v-card-actions>
					<v-btn outlined color="error" class="ma-1"  dark  @click="EncargadoModal = false" > {{ !DatosEncargado.id_encargado ? 'NO,QUIERO':'CANCELAR'}} </v-btn>
					<v-spacer></v-spacer>
					<v-btn color="celeste" class="ma-1"  dark v-if="!DatosEncargado.id_encargado" @click="actualizaEncargado(1)"> SI,QUIERO </v-btn>
					<v-btn color="celeste" class="ma-1" small dark v-if="DatosEncargado.id_encargado && getdatosUsuario.id != DatosEncargado.id_encargado" @click="actualizaEncargado(2)"> 
						 SI, ASIGNAR 
					</v-btn>
				</v-card-actions>
			</v-card>	
		</v-dialog>

		<v-dialog v-model="Correcto" hide-overlay persistent width="350">
			<v-card :color="colorCorrecto" dark class="pa-3">
				<v-card-text class="font-weight-black headline pa-3 white--text" align="center">
					{{ textCorrecto }}
				</v-card-text>
			</v-card>
		</v-dialog>

		<v-dialog v-model="modalCancelar" persistent max-width="500">
			<v-card >
				<v-card-title class="subtitle-1 font-weight-black"> LA SOLICITUD SE CANCELARA  </v-card-title>
				<v-card-subtitle class="subtitle-2 font-weight-black">¿ ESTA SEGURO DE QUERER CONTINUAR ?</v-card-subtitle>
				<v-divider class="my-0 py-3" ></v-divider>
				<v-card-subtitle align="center" class="red--text font-weight-bold "> SE CANCELARA DE FORMA DEFINITIVA </v-card-subtitle>
				<v-divider class="my-0 py-2 " ></v-divider>
				<v-card-actions>
					<v-spacer/>
					<v-btn dark outlined color="gris" @click="modalCancelar = false">Regresar</v-btn>
					<v-btn dark color="error" @click="cancelarMovimiento()"  >Continuar</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
		
		<overlay v-if="overlay"/>
  </v-main>
</template>

<script>
	var moment = require('moment'); moment.locale('es') /// inciar Moment 
	import {mapGetters, mapActions} from 'vuex';
	import  SelectMixin 					from '@/mixins/SelectMixin.js';
	import  ExcelExport 					from '@/mixins/ExcelExport.js';
  import  overlay    					  from '@/components/overlay.vue'
  import  resultadosActividad   from '@/views/Solicitudes/resultadosActividad.vue'

	export default {
		mixins:[SelectMixin,ExcelExport],
		components: {
			overlay,
			resultadosActividad
		},
		data () {
			return {
				titulo:'DESARROLLO DE PROYECTOS',
				page: 1,
        pageCount: 0,
				itemsPerPage: 20,
				search: '',
				Vista :'',
				headers: [
            // { text: ''          , align: 'left'	 , value: 'tipo' },
						{ text: 'Cliente'	  , align: 'left'	 , value: 'nomcli' },
						{ text: 'Vendedor'	, align: 'left'	 , value: 'nomvend' },
						{ text: 'Fecha'		  , align: 'left'	 , value: 'fecha' },
						{ text: 'Tipo'		  , align: 'left'	 , value: 'tipo_prod' },
						{ text: 'Producto'  , align: 'left'	 , value: 'codigo' },
						{ text: 'Encargado' , align: 'center'	 , value: 'encargado' },
						{ text: '',  align: 'right', value: 'action' , sortable: false },
				],

				estatus: {  id: 1, nombre:'Pendiente'},
				Estatus:[ { id: 1, nombre:'Pendiente'},
									{ id: 2, nombre:'Finalizado' },
									{ id: 3, nombre:'Autorizado'},
									{ id: 4, nombre:'Cancelado'},

                ],
        departamento: { id:1, nombre:'DESARROLLO'},
        departamentos:[{ id: 1, nombre:'DESARROLLO'}, 
                { id: 2, nombre:'DIGITAL'   }, 
                { id: 3, nombre:'DISEÑO'    }   
							],
				
				tipos:['Producto Existente','Modificación de Producto','Nuevo Producto'],

				fecha1: moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
				fechamodal1:false,
				fecha2: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
				fechamodal2:false,

				alerta: { 
					activo: false,
					text: '',
					color: 'error',
				},


				Historial: false,
				dialog: false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',
				// nextMonthLastDay: moment().add(1, 'months').endOf('month').format("YYYY-MM-DD"),
				actualiza       : false,
				anchoModal      : 500,
				solicitarModal  : false, 
				activaFormulario: 0 ,
				tablaModificar  :  false,
				productoExistente : false,
				parametros      : '',
				modoVista       : 1,
				modalDDD				: true,

				EncargadoModal  : false, 
				DatosEncargado  : [],

				resultados : false,
				informacion: {},

				overlay : false,
				Correcto: false,
				colorCorrecto : 'error',
				textCorrecto  : '',
				modalCancelar:false,
				partidaAEditar: {},

			}
		},

		created(){
			// this.$store.watch(
      //   (state, getters) => state.Solicitudes.solicitudesddd, (newValue, oldValue) => {
      //     clearInterval(actualizar);
      //   },
      // );

			if(this.Parametros2.estatus != undefined){
				this.estatus = { id: this.Parametros2.estatus};
				this.fecha1  = this.Parametros2.fecha1
				this.fecha2  = this.Parametros2.fecha2
				this.depto   = { id: this.Parametros2.id_depto }
			}

			this.init();
			// var actualizar  = setInterval(() => { this.consultaAutomaticaDDD() }, 5000);
		},

		watch:{
			actualiza(){
        this.init();
      },
			estatus(){
				this.init();
			},

			fecha1(){
				this.init();
			},

			fecha2(){
				this.init();
			},

			departamento(){
				this.init();
			}
		},

		computed:{
			...mapGetters('Solicitudes'  ,['getSolicitudesDDD','Loading','Parametros2']), // IMPORTANDO USO DE VUEX - (GETTERS)
			...mapGetters('Login' ,['getLogeado','getdatosUsuario']), 

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
			...mapActions('Solicitudes'  ,['consultaSolicitudesDDD','guardaParametrosConsulta','consultaAutomaticaDDD']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			init(){
				const payload = new Object({
					estatus : this.estatus.id,
					fecha1  : this.fecha1,
					fecha2  : this.fecha2,
					id_depto: this.departamento.id
				});

				this.guardaParametrosConsulta(payload);
				this.consultaSolicitudesDDD()
			},

			verTareaAsignada(item){
				this.resultados =true;
				this.informacion = item;
			},
		
			verSolicitud(item){
				this.$router.push({ name:'detsolicitud' , params:{ solicitud: item }}) 
			},

			actualizaEncargado(){
				const payload = { id: this.DatosEncargado.id, id_encargado: this.getdatosUsuario.id }
				this.EncargadoModal = false; this.overlay = true;
				this.$http.post('actualiza.encargado', payload).then( response =>{
					this.textCorrecto = response.bodyText; 
					this.colorCorrecto = 'green';
					this.Correcto = true; 
					this.init()
				}).catch( error =>{
					this.textCorrecto = error.bodyText; 
					this.colorCorrecto = 'red';
				}).finally( ()=>{ 
					var me = this; this.overlay = false;
					setTimeout(()=>{ me.Correcto = false }, 1500)
			 })
			},

			cancelarMovimiento(){
				this.modalCancelar=false; this.overlay = true; 

        const payload = new Object({
					id          : this.partidaAEditar.id,
					id_det_sol  : this.partidaAEditar.id_det_sol,
					id_solicitud: this.partidaAEditar.id_solicitud,
					estatus     : 4
				});
        
				// ESTA FUNCION CAEE EN EL CONTROLADOR DE REGISTROS DE ACTIVIDAD
				this.$http.post('actualiza.estatus.resultado', payload ).then( response =>{
					this.alerta = { activo: true, text: response.bodyText , color:'green'}
					this.init();
				}).catch( error =>{
					this.alerta = { activo: true, text: error.bodyText, color:'error '}
				}).finally(()=>{
					this.overlay = false;
				})
			},

			ImprimirExcel(){
				if(!this.getSolicitudesDDD.length){
					this.alerta.snackbar = true; this.alerta.text="No hay información que exportar"; this.alerta.color="red darken-4";
					return
				}

				let tHeaders=[], tValores= [], tInformacion = [];
				let theaders = [{ text: "Solicitud"			  , value:"id_solicitud" },
												{ text: "Cliente"         , value:"nomcli"},
												{ text: "Solicitante"     , value:"nomvend"},
												{ text: "Fecha"           , value:"fecha"},
												{ text: "Hora"            , value:"hora"},
												{ text: "Tipo Producto"   , value:"tipo_prod"},
												{ text: "Producto"        , value:"codigo"},
												{ text: "Encargado"       , value:"encargado"},
												{ text: "Estatus"         , value:"estatus"},
											 ]

				for(let j =0;j< theaders.length; j++){
					tHeaders.push(theaders[j].text);
					tValores.push(theaders[j].value);
				}

				for(let x=0;x<this.getSolicitudesDDD.length;x++){
					tInformacion.push({ id_solicitud: this.getSolicitudesDDD[x].id_solicitud,
															nomcli      : this.getSolicitudesDDD[x].nomcli,
															nomvend     : this.getSolicitudesDDD[x].nomvend,
															fecha 			: this.getSolicitudesDDD[x].fecha,
															hora        : this.getSolicitudesDDD[x].hora,
															tipo_prod   : this.tipos[this.getSolicitudesDDD[x].tipo_prod-1],
															codigo      :	this.getSolicitudesDDD[x].codigo,
															cantidad    : this.getSolicitudesDDD[x].cantidad,
															nomencargado: this.getSolicitudesDDD[x].nomencargado,
															estatus     : this.Estatus[ this.getSolicitudesDDD[x].estatus-1].nombre })
				}

				this.titulo = this.titulo +'_'+ this.departamento.nombre +'_'+this.estatus.nombre +"_"+ this.fecha1 +"-"+ this.fecha2;
				this.manejarDescarga(this.titulo ,tHeaders,tValores,tInformacion)
			},
	
		}
	}
</script>
