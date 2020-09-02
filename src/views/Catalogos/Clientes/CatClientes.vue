<template>
  <v-content class="pa-0 ma-3">
  	<v-row justify="center">
  		<v-col cols="12" >
				<v-card-actions class="font-weight-black headline"> CLIENTES </v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar cliente"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaClientes" ><v-icon>refresh</v-icon> </v-btn>

			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getClientes"
			      :search="search"
			      fixed-header
						height="550px"
						hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
						:page.sync="page"
      			:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"
						dense
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> 
				    </template>

						<template v-slot:item.estatus="{ item }" > 
			    		
			    		<v-btn  class="green" icon dark  v-if="item.estatus===1" @click="cambiaEstatus(item)">
								<v-icon> person </v-icon>
							</v-btn> 
							<v-btn  class="error" icon dark v-else @click="cambiaEstatus(item)">
								<v-icon> mdi-account-off </v-icon>
							</v-btn> 
				    </template>
			    </v-data-table>

			  </v-card>
				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
				
				 <v-dialog persistent v-model="dialog" width="700px" >	
		    	<v-card class="pa-5">
		    		<ControlClientes :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-content>
</template>

<script>
	import ControlClientes  from '@/views/Catalogos/Clientes/ControlClientes.vue';
	import {mapGetters, mapActions} from 'vuex';
	export default {
		components: {
			ControlClientes
		},
		data () {
				return {
					page: 0,
					pageCount: 0,
					itemsPerPage: 100,
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  					 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'	 , align: 'left'  , value: 'nombre' },
						{ text: 'Dirección', align: 'left'  , value: 'direccion' },
						{ text: 'Ciudad' 	 , align: 'left'  , value: 'ciudad' },
						{ text: 'Estado' 	 , align: 'left'  , value: 'estado' },
						{ text: 'CP' 	     , align: 'left'  , value: 'cp' },
						{ text: 'RFC'			 , align: 'left'  , value: 'rfc' 	},
						// { text: 'Tel 1'				 , align: 'left'  , value: 'tel1' 	},
						// { text: 'Contacto'		 , align: 'left'  , value: 'contacto' 	},
						{ text: 'estatus'	 , align: 'left'  , value: 'estatus' 	},
						{ text: ''  			 , align: 'right' , value: 'action', sortable: false },

					],
				}
			},

			created(){
				this.consultaClientes() // CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Clientes'  ,['Loading','getClientes']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			},

			methods:{
				...mapActions('Clientes'  ,['consultaClientes']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},
				
				cambiaEstatus(data){
					const payload = { id: data.id, estatus: !data.estatus };
					this.$http.post('cambia.estatus',payload).then((res)=>{
						this.consultaClientes();
					}).catch((err)=>{
						console.log('err', err)
					})
				}
			}
	}
</script>
