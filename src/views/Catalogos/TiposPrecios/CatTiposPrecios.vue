<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12" lg="6">
				<v-card-actions> <h3><strong> Catálogo de tipos de Precios</strong></h3></v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar Tipos de Precios"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="success" @click="abrirModal(1)">Agregar </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getTiposPrecios"
			      :search="search"
			      fixed-header
				  	height="500px"
				  	hide-default-footer
						disable-pagination
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="green darken-4" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="600px" >	
		    	<v-card>
		    		<ControlTiposPrecios :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlTiposPrecios  from '@/views/Catalogos/TiposPrecios/ControlTiposPrecios.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlTiposPrecios
		},
		data () {
				return {
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  		 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre' , align: 'left'  , value: 'nombre' },
						{ text: ' '  		 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaTiposPrecios() // CONSULTAR Tipos de Precios A VUEX
			},

			computed:{
				...mapGetters('TiposPrecios' ,['getTiposPrecios']), // IMPORTANDO USO DE VUEX - TiposPrecios (GETTERS)
			},

			methods:{
				...mapActions('TiposPrecios'  ,['consultaTiposPrecios']), // IMPORTANDO USO DE VUEX - TiposPrecios		(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
