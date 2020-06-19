<template>
  <v-content class="pa-0">
  	<v-row class="justify-center">
  		<v-col cols="12" sm="10">
				<v-card-actions class="font-weight-black headline"> CATÁLOGO DE CLIENTES </v-card-actions>

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
						height="500px"
						hide-default-footer
						:loading ="Loading"
						disable-pagination
						loading-text="Cargando... Por favor espere."
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> 
				    </template>

			    </v-data-table>
			  </v-card>

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
					search: '',
					movie:'data',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  					 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'			 , align: 'left'  , value: 'nombre' },
						{ text: 'Razon Social' , align: 'left'  , value: 'razon_social' },
						{ text: 'RFC'				    , align: 'left' , value: 'rfc' 	},
						{ text: ''  , align: 'right' , value: 'action', sortable: false },
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
					var movie = 'Parasite'
				},
				
			}
	}
</script>
