<template>
  <v-container class="ma-3">
  	<v-row class="justify-center">
  		<v-col cols="12" lg="6">
				<v-card-actions class="font-weight-black headline"> CARTERAS </v-card-actions>
				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar carteras"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaCarteras"><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getCarteras"
			      :search="search"
			      fixed-header
				  	height="500px"
				  	hide-default-footer
						disable-pagination
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="600px" >	
		    	<v-card>
		    		<ControlCarteras :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlCarteras  from '@/views/Catalogos/Carteras/ControlCarteras.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlCarteras
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
				this.consultaCarteras() // CONSULTAR Carteras A VUEX
			},

			computed:{
				...mapGetters('Carteras' ,['getCarteras']), // IMPORTANDO USO DE VUEX - Carteras (GETTERS)
			},

			methods:{
				...mapActions('Carteras'  ,['consultaCarteras']), // IMPORTANDO USO DE VUEX - Carteras(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
