<template>
  <v-container class="pa-0 ">
  	<v-row justify="center">
  		<v-col cols="12" lg="8">
				<v-card-actions class="font-weight-black headline"> ZONAS </v-card-actions>
				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar zona"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaZonas"><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getZonas"
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

				 <v-dialog persistent v-model="dialog" width="400px" >	
		    	<v-card>
		    		<ControlZonas :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlZonas  from '@/views/Catalogos/Zonas/ControlZonas.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlZonas
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
						{ text: 'Ciudad' , align: 'left'  , value: 'nomciudad' },
						{ text: 'Estado' , align: 'left'  , value: 'nomestado' 	},
						{ text: ' '  		 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaZonas() // CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Zonas'  ,['getZonas']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			},

			methods:{
				...mapActions('Zonas'  ,['consultaZonas']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
