<template>
  <v-content class="pa-0 ma-3">
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions class="font-weight-black headline"> USUARIOS </v-card-actions>


				<v-card class="mt-3" outlined>
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
				    :height="tamanioPantalla"
				    hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
						:page.sync="page"
      			:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"
						dense
			    >
						<template v-slot:item.nivel="{ item }">
							 {{ niveles[item.nivel-1].nombre  }} 
						</template>

			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

						<template v-slot:item.estatus="{ item }" > 
			    		<v-btn  class="green" icon dark  v-if="item.estatus===1" @click="cambiaEstatus(item)">
								<v-icon> person </v-icon>
							</v-btn> 
							<v-btn  class="error" icon dark v-else @click="cambiaEstatus(item)">
								<v-icon> mdi-account-off </v-icon>
							</v-btn> 
				    </template>

			    </v-data-table>
			  </v-card>
				
				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>

				 <v-dialog persistent v-model="dialog" width="700px" >	
					<v-card class="pt-0 pa-4">
		    		<ControlUsuario :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-content >
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
				page: 1,
				pageCount: 0,
				itemsPerPage: 20,
				search: '',
				dialog: false,
				param: 0,
				edit:'',
			
				headers:[
					{ text: 'N°'  		 , align: 'left'  , value: 'id'		  },
					{ text: 'Nombre'	 , align: 'left'  , value: 'nombre' },
					{ text: 'Usuario'	 , align: 'left'  , value: 'usuario' },
					{ text: 'Correo'   , align: 'left'  , value: 'correo' },
					{ text: 'Nivel'		 , align: 'left'  , value: 'nivel' 	},
					{ text: 'Sucursal' , align: 'left'  , value: 'nomsuc' },
					{ text: 'Depto' , align: 'left'  , value: 'nomdepto' },
					{ text: 'Puesto' , align: 'left'  , value: 'nompuesto' },
					{ text: 'Estatus'  , align: 'left'  , value: 'estatus'},
					{ text: ' '        , align: 'right' , value: 'action', sortable: false },
				],
				niveles: [{ id:1, nombre:'Administrador'},
									{ id:2, nombre:'Supervisor'},
									{ id:3, nombre:'Vendedor'},
									{ id:4, nombre:'Chofer'},
									{ id:5, nombre:'Almacén'},
									{ id:6, nombre:'Ventas'},
									{ id:7, nombre:'Servicio al Cliente'},
									{ id:8, nombre:'Sin seleccionar'},
									{ id:9, nombre:'Desarrollo de Proyectos'},

								],
			}
		},

		created(){
			this.consultaUsuarios()// CONSULTAR CLIENTES A VUEX
		},

		computed:{
			...mapGetters('Usuarios' ,['Loading','getUsuarios']), // IMPORTANDO USO DE VUEX  (GETTERS)
			tamanioPantalla () {
				switch (this.$vuetify.breakpoint.name) {
					case 'xs':
						return this.$vuetify.breakpoint.height -300
					break;
					case 'sm': 
						return this.$vuetify.breakpoint.height -300
					break;
					case 'md':
						return this.$vuetify.breakpoint.height -300
					break;
					case 'lg':
						return this.$vuetify.breakpoint.height -300
					break;
					case 'xl':
						return this.$vuetify.breakpoint.height -300
					break;
				}
			},
		},

		methods:{
			...mapActions('Usuarios'  ,['consultaUsuarios']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

			abrirModal(action, items){
				this.param = action;
				this.edit = items;
				this.dialog = true;
			},

			cambiaEstatus(data){
				const payload = { id: data.id, estatus: !data.estatus };
				this.$http.post('estatus.user',payload).then((res)=>{
					console.log('cambio estatus', res.body)
					this.consultaUsuarios();
				}).catch((err)=>{
					console.log('err', err)
				})
			}

			
			
		}
	}
</script>
