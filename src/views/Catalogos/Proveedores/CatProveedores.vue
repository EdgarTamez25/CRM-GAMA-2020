<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions> <h3><strong> Catálogo de Proveedores</strong></h3></v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar Proveedor"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="success" @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="red darken.4" icon dark @click="consultaProveedores"><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getProveedores"
			      :search="search"
			      fixed-header
						height="500px"
						hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="green darken-4" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>
						<template v-slot:item.tipo_prov="{ item }" > 
							 {{  item.tipo_prov === 1 ? 'NACIONAL':'INTERNACIONAL'}} 
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="700px" >	
		    	<v-card>
		    		<ControlProveedor :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlProveedor  from '@/views/Catalogos/Proveedores/ControlProveedor.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlProveedor
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
						{ text: 'RFC'				   , align: 'left'  , value: 'rfc' 	},
						// { text: 'CURP'		     , align: 'left'  , value: 'curp' },
						{ text: 'Tipo Proveedor', align: 'left'  , value: 'tipo_prov' },

						{ text: ''  					 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaProveedores() // CONSULTAR PROVEEDORES A VUEX
			},

			computed:{
				...mapGetters('Proveedores',['Loading','getProveedores']), // IMPORTANDO USO DE VUEX - PROVEEDORES (GETTERS)
			},

			methods:{
				...mapActions('Proveedores'  ,['consultaProveedores']), // IMPORTANDO USO DE VUEX - PROVEEDORES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
