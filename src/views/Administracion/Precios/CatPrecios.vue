<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions> <h3><strong> Catálogo de Precios</strong></h3></v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar Precio"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="success" @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="red darken.4" icon dark @click="consultaPrecios"><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getPrecios"
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
					
			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="1000px" >	
		    	<v-card>
		    		<ControlPrecios :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlPrecios  from '@/views/Administracion/Precios/ControlPrecios.vue';

	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlPrecios
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
						{ text: 'CURP'		     , align: 'left'  , value: 'curp' },
						{ text: 'Tipo Proveedor', align: 'left'  , value: 'tipo_prov' },

						{ text: ''  					 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaPrecios() // CONSULTAR PRECIOS A VUEX
			},

			computed:{
				...mapGetters('Precios',['Loading','getPrecios']), // IMPORTANDO USO DE VUEX - PRECIOS (GETTERS)
			},

			methods:{
				...mapActions('Precios'  ,['consultaPrecios']), // IMPORTANDO USO DE VUEX - PRECIOS(ACCIONES)

				abrirModal(action, items){
					this.param 	= action;
					this.edit 	= items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
