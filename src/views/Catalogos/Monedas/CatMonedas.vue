<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12" lg="6">
				<v-card-actions> <h3><strong> Catálogo de Monedas</strong></h3></v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar monedas"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="success" @click="abrirModal(1)">Agregar </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getMonedas"
			      :search="search"
			      fixed-header
				  	height="500px"
				  	hide-default-footer
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="green darken-4" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="600px" >	
		    	<v-card>
		    		<ControlMonedas :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlMonedas  from '@/views/Catalogos/Monedas/ControlMonedas.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlMonedas
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
						{ text: 'Codigo' , align: 'left'  , value: 'codigo' },
						{ text: 'Tipo de cambio' , align: 'left'  , value: 'tipo_cambio' },
						{ text: ' '  		 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaMonedas() // CONSULTAR Carteras A VUEX
			},

			computed:{
				...mapGetters('Monedas' ,['getMonedas']), // IMPORTANDO USO DE VUEX - Monedas (GETTERS)
			},

			methods:{
				...mapActions('Monedas'  ,['consultaMonedas']), // IMPORTANDO USO DE VUEX - Carteras(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
