<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions> <h3><strong> Catálogo de Productos</strong></h3></v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar producto"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="success" @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="red darken.4" icon dark @click="consultaProductos" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getProductos"
			      :search="search"
			      fixed-header
				    height="500px"
				    hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="green darken-4" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> 
				    </template>

						<template v-slot:item.tipo_producto="{ item }" > 
							{{ item.tipo_producto === 1 ? 'Materia Prima': 'Producto Final' }}
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="700px" >	
					<v-card class="pt-0 pa-4">
		    		<ControlProductos :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlProductos  from '@/views/Catalogos/Productos/ControlProductos.vue'
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlProductos
		},
		data () {
				return {
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  			 , align: 'left'  , value: 'id'		  },
						{ text: 'Codigo'	 , align: 'left'  , value: 'codigo' },
						{ text: 'Nombre'   , align: 'left'  , value: 'nombre' },
						{ text: 'Unidad'   , align: 'left'  , value: 'nomunidad' },
						{ text: 'Linea'		 , align: 'left'  , value: 'nomlin' 	},
						{ text: 'Tipo'     , align: 'left'  , value: 'tipo_producto' },
						{ text: 'Proveedor', align: 'left'  , value: 'nomprov' },
						{ text: ' '        , align: 'right' , value: 'action', sortable: false },
					],
				}
			},


			created(){
				this.consultaProductos()// CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Productos',['Loading','getProductos']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			},

			methods:{
				...mapActions('Productos',['consultaProductos']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
