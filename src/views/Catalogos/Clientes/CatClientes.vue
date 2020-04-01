<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions> <h3><strong> Catálogo de Clientes</strong></h3></v-card-actions>

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
			      <v-btn small class="success" @click="abrirModal(1)">Agregar </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getClientes"
			      :search="search"
			      fixed-header
				  height="500px"
				  hide-default-footer
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<!-- <v-btn  class="orange darken-4" icon dark ><v-icon> chrome_reader_mode </v-icon></v-btn> Cotizacion -->
			    		<!-- <v-btn  class="blue darken-4" icon dark><v-icon  > directions_run  </v-icon></v-btn>     Seguimiento -->
			    		<v-btn  class="green darken-4" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="700px" >	
		    	<v-card>
		    		<ControlClientes :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
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
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  					 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'			 , align: 'left'  , value: 'nombre' },
						{ text: 'Razon Social' , align: 'left'  , value: 'razon_social' },
						{ text: 'RFC'				    , align: 'left' , value: 'rfc' 	},
						// { text: 'CURP'		      , align: 'left' , value: 'curp' },
						{ text: 'Ver Detalle'  , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaClientes() // CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Clientes'  ,['getClientes']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			},

			methods:{
				...mapActions('Clientes'  ,['consultaClientes']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
