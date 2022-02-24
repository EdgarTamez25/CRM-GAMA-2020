<template>
 <v-main class="pa-3 ">
		<v-row no-gutters justify="center">
			
			<v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
				<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
			</v-snackbar>

  		<v-col cols="12" >
				<v-card outlined >
					<v-row>
						<v-col cols="12" md="6" >
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > PROSPECTOS </v-card-actions>
						</v-col>
						
					</v-row>

					<v-card-actions class="py-0">
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar prospectos"
			        hide-details
							filled
							dense
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn  class="celeste" dark @click="abrirModal(1)">
							Nuevo
						</v-btn>
			      <v-btn  class="gris" icon dark @click="consultaProspectos()" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>

						<!--disable-pagination -->
			    <v-data-table
			      :headers="headers"
			      :items="getProspectos"
			      :search="search"
			      fixed-header
						:height="tamanioPantalla"
						hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... por favor espere."
						:page.sync="page"
      			:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"

			    >
						<template v-slot:item.action="{ item }" > 
			    		<!-- <v-btn  class="rosa ma-1" icon dark @click="validaAccion(item)"><v-icon> people </v-icon></v-btn>  -->
			    		<v-btn class="rosa ma-1"    icon dark @click="abrirModalCliente(item)"><v-icon> people </v-icon></v-btn> 
			    		<v-btn class="celeste ma-1" icon dark @click="abrirModal(2, item)"    ><v-icon> create </v-icon></v-btn> 
				    </template>

			    </v-data-table>
			  </v-card>

				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>

				 <v-dialog persistent v-model="dialog" width="700px" >	
		    	<v-card class="pa-5">
		    		<ControlProspectos 
							:param="param" 
							:edit="edit" 
							@modal="dialog = $event" 
						/>
		    	</v-card>
		    </v-dialog>

				<!-- PROCESO PARA ELIMINAR  -->
				<!-- <v-dialog v-model="pasarACliente" persistent max-width="400" > 
					<v-card color="rosa">
						<v-card-text class="pa-4 headline white--text ">
							¿Quiere pasar esté <span class="font-weight-black "> prospecto</span>  a 
																 <span class="font-weight-black"> cliente </span>?
						</v-card-text>
						<v-card-actions >
							<v-btn color="green" block dark small @click="convertirEnCliente">
								Pasar solo a cliente
							</v-btn>
						</v-card-actions>
						<v-card-actions >
							<v-btn color="celeste" block dark small @click="abrirModalCliente">
								Completar datos de cliente
							</v-btn>
						</v-card-actions>

						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="gris" dark small @click="pasarACliente = false">Cancelar</v-btn>
						</v-card-actions>

					</v-card>
				</v-dialog>  -->
				<!-- FIN DEL PROCESO PARA ELIMINAR  -->

				<v-dialog persistent v-model="clienteModal" width="700px" >	
		    	<v-card class="pa-5">
		    		<ControlClientes :param="param" :edit="edit" @modal="clienteModal = $event" />
		    	</v-card>
		    </v-dialog>

  		</v-col>
  	</v-row>
  </v-main>
</template>

<script>
	import ControlProspectos  from '@/views/Catalogos/Prospectos/ControlProspectos.vue';
	import ControlClientes  from '@/views/Catalogos/Clientes/ControlClientes.vue';
	import {mapGetters, mapActions} from 'vuex';
	export default {
		components: {
			ControlProspectos,
			ControlClientes
		},
		data () {
				return {
					page: 1,
					pageCount: 0,
					itemsPerPage: 200,

					search: '',
					movie:'data',
					dialog: false,
					clienteModal: false,
					pasarACliente:false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  		   , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'	 , align: 'left'  , value: 'nombre' },
						{ text: 'Telefono' , align: 'left'  , value: 'tel1' },
						{ text: 'Contacto' , align: 'left'  , value: 'contacto' },
						{ text: 'Responsable' , align: 'left'  , value: 'nomvend' },
						{ text: ''  , align: 'right' , value: 'action', sortable: false },
					],

					prospecto:{},
					// ALERTAS
					snackbar: false,
					text		: '',
					color		: 'celeste',
				}
			},

			created(){
				this.consultaProspectos() // CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Prospectos'  ,['Loading','getProspectos']), // IMPORTANDO USO DE VUEX - Prospectos (GETTERS)
				...mapGetters('Usuarios'    ,['getUsuarios']), // IMPORTANDO USO DE VUEX - Prospectos (GETTERS)
				tamanioPantalla () {
					// console.log(this.$vuetify.breakpoint)
					switch (this.$vuetify.breakpoint.name) {
						case 'xs':
							return 'auto';
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
				...mapActions('Prospectos'  ,['consultaProspectos']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				abrirModalCliente(prospecto){
					this.prospecto = prospecto;
					// this.pasarACliente = false;
					this.param = 3;
					this.edit = this.prospecto;
					this.clienteModal = true;
				},

				// validaAccion(prospecto){
				// 	this.prospecto = prospecto;
				// 	this.pasarACliente = true;
				// },

				convertirEnCliente(){
					const payload = { id : this.prospecto.id, prospecto: 0 };
												
					this.$http.post('pasar.cliente',payload).then(response =>{
						this.pasarACliente = false
						this.snackbar = true ; this.text = response.body;
						this.consultaProspectos()
					}).catch(err =>{
						console.log('err', err)
					})
				}
				
			}
	}
</script>
