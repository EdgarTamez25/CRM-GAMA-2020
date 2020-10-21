<template>
  <v-content class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >

				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>
			

				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="mt-3" outlined >
				<v-card-actions class="font-weight-black headline pa-4"> COMPROMISOS </v-card-actions>

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
							<span> {{  moment(item.fecha).format('LL') }} </span>
						</template>

			    </v-data-table>
			  </v-card>

				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
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
  </v-content>
</template>

<script>
	import ControlCompromiso  from '@/views/Compromisos/ControlCompromiso.vue';
	// import ControldeFases  from '@/views/Compromisos/controldeFases.vue';
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		mixins:[SelectMixin],
		components: {
			ControlCompromiso,
			// ControldeFases
		},
		data () {
			return {
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
						{ text: '#'   		, align: 'left'	 , value: 'id' },
						{ text: 'Responsable'   		, align: 'left'	 , value: 'nomvend' },
						{ text: 'Tipo'							, align: 'left'	 , value: 'tipo' },
						{ text: 'Categoria'					, align: 'left'	 , value: 'nomcatego' },
						{ text: 'Cliente'					  , align: 'left'	 , value: 'nomcli' },
						{ text: 'Fecha'							, align: 'left'	 , value: 'fecha' },
						{ text: 'Hora'							, align: 'left'	 , value: 'hora' },

						{ text: '', value: 'action' , sortable: false },

				],

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
		},

		computed:{
			...mapGetters('Compromisos'  ,['getCompromisos','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
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
			...mapActions('Compromisos'  ,['consultaCompromisos']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			NuevoCompromiso(modoVista, data){
				console.log('modoVista', modoVista);
				console.log('data', data);

				this.modoVista = modoVista;
				this.data = data;
				this.compromisoModal = true;
			},

			abreModal(item ){
				this.id_compromiso=item.id;
				this.confirmaModal=true;
			},

	
		}
	}
</script>
