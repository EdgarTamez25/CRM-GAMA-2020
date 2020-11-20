<template>
  <v-content class="pa-0 ma-3">
  	<v-row class="justify-center" no-gutters>
  		<v-col cols="12" >

				<v-snackbar v-model="snackbar" :timeout="1000" top :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>
				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="mt-3" outlined >
				<v-card-actions class="font-weight-black headline  py-0 mt-1"> SOLICITUDES DE PEDIDO </v-card-actions>

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
							<v-btn color="blue" rounded dark small @click="abrirNota(item.nota)" v-if="item.nota"> ver nota </v-btn>
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
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		mixins:[SelectMixin],
		components: {
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
			this.consultaSolicitudes() // CONSULTAR CLIENTES A VUEX
		},

		computed:{
			...mapGetters('Solicitudes'  ,['getSolicitudes','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
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
			...mapActions('Solicitudes'  ,['consultaSolicitudes']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			abrirNota(nota){
				this.nota = nota;
				this.verNota = true;
			},	

			verSolicitud(item){
				this.$router.push({ name:'detsolicitud' , params:{ solicitud: item }}) 
			},

	
		}
	}
</script>
