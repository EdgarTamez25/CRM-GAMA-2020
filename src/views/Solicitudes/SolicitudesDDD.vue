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
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <!-- <v-btn small class="celeste" dark @click="NuevoCompromiso(1)">Agregar </v-btn> -->
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
						class="letraData"
			    >
						<template v-slot:item.id_solicitud="{ item }"  >
							<span style="font-size:12px"> {{  item.id_solicitud }} </span>
						</template>
						<template v-slot:item.nomcli = "{ item }"  >
							<span style="font-size:12px"> {{  item.nomcli }} </span>
						</template>
						<template v-slot:item.nomvend = "{ item }"  >
							<span style="font-size:12px"> {{  item.nomvend }} </span>
						</template>
						<template v-slot:item.fecha="{ item }">
							<span  style="font-size:12px"> {{  moment(item.fecha).format('LL') }} </span>
						</template>
						<template v-slot:item.tipo_prod="{ item }">
							<span class="font-weight-black rosa--text"    style="font-size:12px" v-if="item.tipo_prod === 1"> Producto Existente </span>
							<span class="font-weight-black orange--text"  style="font-size:12px" v-if="item.tipo_prod === 2"> Modificación </span>
							<span class="font-weight-black celeste--text" style="font-size:12px" v-if="item.tipo_prod === 3"> Nuevo Producto </span>
						</template>	
						<template v-slot:item.ft="{ item }">
							<span style="font-size:12px" class="font-weight-black text-h6 "> {{ item.ft }}</span>
						</template>
						<template v-slot:item.cantidad="{ item}">
							<span style="font-size:12px" class="font-weight-black text-h6 "> {{ item.cantidad }}</span>
						</template>

						<template v-slot:item.encargado ="{ item }">
							<v-btn small dark text color="indigo" v-if="item.id_encargado != null" @click="EncargadoModal= true,DatosEncargado=item"> 
								{{ item.encargado }}
							</v-btn>
							<v-btn small dark text color="red" v-else @click="EncargadoModal= true,DatosEncargado=item"> Asignar </v-btn>
						</template>

						<template v-slot:item.action="{ item }" >
			    		<v-btn  color="green" class="ma-1"  small dark  @click="validaTipoProducto(item)" v-if=" item.id_encargado !=null">
								<v-icon> mdi-eye </v-icon>
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

		<v-dialog v-model="EncargadoModal" persistent width="500">
			<v-card class="pa-1">
				<v-card-text class="font-weight-black subtitle-1 pa-3 mt-1" align="center" v-if="!DatosEncargado.id_encargado" >QUIERO ATENDER ESTA SOLICITUD  </v-card-text>
				<v-card-text v-else align="left" class="font-weight-black subtitle-1 pa-3 mt-1">
						ACTUALMENTE EL USUARIO <span class="green--text">  {{ DatosEncargado.nomencargado }} </span>  ATIENDE ESTA SOLICITUD.
				</v-card-text>
				<v-card-subtitle class="font-weight-black subtitle-1" align="center" v-if="DatosEncargado.id_encargado && getdatosUsuario.id != DatosEncargado.id_encargado"  >
					¿DESEA ASIGNARSE ESTA SOLICITUD?
				</v-card-subtitle>
				<v-card-actions>
					<v-btn outlined color="error" class="ma-1"  small dark  @click="EncargadoModal = false" > {{ !DatosEncargado.id_encargado ? 'NO QUIERO':'CANCELAR'}} </v-btn>
					<v-spacer></v-spacer>
					<v-btn color="celeste" class="ma-1" small dark v-if="!DatosEncargado.id_encargado" @click="actualizaEncargado(1)"> SI QUIERO </v-btn>
					<v-btn color="celeste" class="ma-1" small dark v-if="DatosEncargado.id_encargado && getdatosUsuario.id != DatosEncargado.id_encargado" @click="actualizaEncargado(2)"> 
						 SI, ASIGNAR 
					</v-btn>
				</v-card-actions>
			</v-card>	
		</v-dialog>
		
		<v-dialog v-model="solicitarModal" persistent :width="anchoModal" height="200" >
			<v-card class="pa-4 ">
				<prodExistente
					:modalDDD="modalDDD"
					:modoVista="modoVista"
					:parametros="parametros"
					:actualiza ="actualiza"
					@modal="solicitarModal = $event" 
					@put="actualiza = $event" 
					v-if="productoExistente"
				/>
				<modificaciones
          :modalDDD="modalDDD"
					:depto_id="depto.id" 
					:modoVista="modoVista"
					:parametros="parametros"
					:actualiza ="actualiza"
					@modal="solicitarModal = $event" 
					@put="actualiza = $event" 
					v-if="tablaModificar"
				/>
				<flexografia
          :modalDDD="modalDDD"
					:depto_id="depto.id" 
					:modoVista="modoVista"
					:Vista="Vista"
					:parametros="parametros"
					:actualiza ="actualiza"
					@modal="solicitarModal = $event" 
					@put="actualiza = $event" 
					v-if="activaFormulario===1"
				/>
				<digital    
          :modalDDD="modalDDD"
					:depto_id="depto.id" 
					:modoVista="modoVista"
					:Vista="Vista"
					:parametros="parametros"
					:actualiza ="actualiza"
					@modal="solicitarModal = $event" 
					@put="actualiza = $event" 
					v-if="activaFormulario===3"
				/>
			</v-card>
		</v-dialog>

		<v-dialog v-model="Correcto" hide-overlay persistent width="350">
			<v-card :color="colorCorrecto" dark class="pa-3">
				<v-card-text class="font-weight-black headline pa-3 white--text" align="center">
					{{ textCorrecto }}
				</v-card-text>
			</v-card>
		</v-dialog>
		
		<overlay v-if="overlay"/>
  </v-content>
</template>

<script>
	var moment = require('moment'); moment.locale('es') /// inciar Moment 
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex';
  import modificaciones from '@/views/Formularios/modificaciones.vue'
  import flexografia    from '@/views/Formularios/flexografia.vue'
  import digital        from '@/views/Formularios/digital.vue'
  import enviarADeptos  from '@/components/enviarADeptos.vue'
	import prodExistente  from '@/views/Formularios/prodExistente.vue'
  import overlay     from '@/components/overlay.vue'
	

	export default {
		mixins:[SelectMixin],
		components: {
      modificaciones,
      flexografia,
      digital,
			enviarADeptos,
			prodExistente,
			overlay
		},
		data () {
			return {
				page: 1,
        pageCount: 0,
				itemsPerPage: 20,
				search: '',
				Vista :'',
				headers: [
            // { text: '#'   			, align: 'left'	 , value: 'id_key' },
            { text: '#Sol' , align: 'left'	 , value: 'id_solicitud' },
						{ text: 'Cliente'	  , align: 'left'	 , value: 'nomcli' },
						{ text: 'Vendedor'	, align: 'left'	 , value: 'nomvend' },
						{ text: 'Fecha'		  , align: 'left'	 , value: 'fecha' },
						{ text: 'Tipo'		  , align: 'left'	 , value: 'tipo_prod' },
						{ text: 'Ref'				, align: 'left'	 , value: 'ft' },
						{ text: 'Cantidad'  , align: 'left'	 , value: 'cantidad' },
						{ text: 'Encargado' , align: 'center'	 , value: 'encargado' },

						{ text: '', value: 'action' , sortable: false },
				],

				estatus: {  id: 1, nombre:'Pendiente'},
				Estatus:[ { id: 1, nombre:'Pendiente'},
									{ id: 2, nombre:'Realizado' },
									{ id: 3, nombre:'Terminado'}
                ],
        departamento: { id:1, nombre:'DESARROLLO'},
        departamentos:[{ id: 1, nombre:'DESARROLLO'}, 
                { id: 2, nombre:'DIGITAL'   }, 
                { id: 3, nombre:'DISEÑO'    }   
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

				overlay : false,
				Correcto: false,
				colorCorrecto : 'error',
				textCorrecto  : ''

			}
		},

		created(){
			this.fecha1 = this.mesAnteriorPrimerDia;
			this.fecha2 = this.mesActualUltimoDia;
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
			...mapGetters('Solicitudes'  ,['getSolicitudesDDD','Loading']), // IMPORTANDO USO DE VUEX - (GETTERS)
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
			...mapActions('Solicitudes'  ,['consultaSolicitudesDDD','guardaParametrosConsulta']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			init(){
				const payload = { estatus: this.estatus.id,
													fecha1 : this.fecha1,
													fecha2 : this.fecha2,
													id_depto: this.departamento.id
												}
				
				this.guardaParametrosConsulta(payload);
				this.consultaSolicitudesDDD()
			},

			validaTipoProducto(item){
        switch (item.tipo_prod) {
					case 1:
						this.anchoModal        = 500;   // ASIGNAR EL ANCHO DE LA MODAL
						this.modoVista         = 2;     // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
						this.Vista             ='SOLICITUDESDDD';
            this.parametros        = item;  // ASIGNAR LOS PARAMETROS A MANDAR
            this.activaFormulario  = 0 ;    // FORMULARIO QUE SE MOSTRARA
						this.tablaModificar    = false;  // HABILITAR TABLA DE MODIFICACIONES
            this.productoExistente = true;  // HABILITAR TABLA DE MODIFICACIONES
            this.solicitarModal   = true;  // ABRIR MODAL 

						break;
          case 2:
            this.anchoModal       = 800;   // ASIGNAR EL ANCHO DE LA MODAL
						this.modoVista        = 2;     // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
						this.Vista             ='SOLICITUDESDDD';
            this.parametros       = item;  // ASIGNAR LOS PARAMETROS A MANDAR
            this.activaFormulario = 0 ;    // FORMULARIO QUE SE MOSTRARA
            this.tablaModificar   = true;  // HABILITAR TABLA DE MODIFICACIONES
            this.depto = { id: item.dx }
            this.solicitarModal   = true;  // ABRIR MODAL 
            break;

          case 3:
            this.anchoModal       = 700;     // ASIGNAR EL ANCHO DE LA MODAL
						this.modoVista        = 2;       // ASIGNAR EL MODO DE LA MODAL ( EDITAR )
						this.Vista             ='SOLICITUDESDDD';
            this.parametros       = item;    // ASIGNAR LOS PARAMETROS A MANDAR
            this.activaFormulario = item.dx; // FORMULARIO QUE SE MOSTRARA
            this.tablaModificar   = false;   // HABILITAR TABLA DE MODIFICACIONES
            this.depto = { id: item.dx }
            this.solicitarModal   = true;    // ABRIR MODAL
            break;
        }
			},
		
			verSolicitud(item){
				this.$router.push({ name:'detsolicitud' , params:{ solicitud: item }}) 
			},

			actualizaEncargado(modo){
				const payload = { id: this.DatosEncargado.id_key, id_encargado: this.getdatosUsuario.id }
				this.EncargadoModal = false; this.overlay = true;

				this.$http.post('actualiza.encargado', payload).then( response =>{
					this.textCorrecto = response.bodyText; this.colorCorrecto = 'green';
					this.Correcto = true; this.init()
				}).catch( error =>{
					this.textCorrecto = error.bodyText; this.colorCorrecto = 'red';
				}).finally( ()=>{ 
					var me = this; this.overlay = false;
					setTimeout(()=>{ me.Correcto = false }, 1500)
			 })
			},
	
		}
	}
</script>


<style  scoped>
	.letraData{
		font-size: 10px; 
	}
</style>