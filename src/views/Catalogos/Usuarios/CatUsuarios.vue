<template>
  <v-content class="pa-0">
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions class="font-weight-black headline"> CATÁLOGO DE USUARIOS </v-card-actions>


				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar usuarios"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" @click="abrirModal(1)" dark>Agregar  </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaUsuarios" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getUsuarios"
			      :search="search"
			      fixed-header
				    height="500px"
				    hide-default-footer
						:loading ="Loading"
						disable-pagination
						loading-text="Cargando... Por favor espere."
			    >
						<template v-slot:item.nivel="{ item }">
							 {{ niveles[item.nivel-1].nombre  }} 
						</template>

			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="700px" >	
					<v-card class="pt-0 pa-4">
		    		<ControlUsuario :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-content class="pa-0">
</template>

<script>
	import ControlUsuario  from '@/views/Catalogos/Usuarios/ControlUsuario.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlUsuario
		},
		data () {
				return {
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  			 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'	 , align: 'left'  , value: 'nombre' },
						{ text: 'Correo'   , align: 'left'  , value: 'correo' },
						{ text: 'Nivel'		 , align: 'left'  , value: 'nivel' 	},
						{ text: 'Sucursal' , align: 'left'  , value: 'nomsuc' },
						{ text: ' '        , align: 'right' , value: 'action', sortable: false },
					],
					niveles: [{ id:1, nombre:'Administrador'},
										{ id:2, nombre:'Supervisor'},
										{ id:3, nombre:'Vendedor'},
										{ id:4, nombre:'Chofer'}
									]
				}
			},


			created(){
				this.consultaUsuarios()// CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Usuarios' ,['Loading','getUsuarios']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			},

			methods:{
				...mapActions('Usuarios'  ,['consultaUsuarios']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				
				
			}
	}
</script>
