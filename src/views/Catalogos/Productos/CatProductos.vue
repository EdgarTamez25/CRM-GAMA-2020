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
			    	<template v-slot:item.action="{ item }"  > 
			    		<v-btn  class="orange darken-1 ma-1" icon dark @click="MuestraPrecios(item)"><v-icon> attach_money </v-icon></v-btn> 
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
			

			<!-- -------PRECIOS------ -->
			<v-dialog v-model="precioActivo" fullscreen hide-overlay transition="dialog-bottom-transition">
				<v-card>
					<!-- CABEZERA -->
					<v-toolbar dark color="cyan darken-4">
          	<!-- <v-toolbar-title> <strong> {{ artSeleccionado }} </strong> </v-toolbar-title> -->
          	<v-spacer></v-spacer>
						<v-toolbar-items>
							<v-btn icon dark @click="precioActivo = false">
								<v-icon>mdi-close</v-icon>
							</v-btn>
						</v-toolbar-items>
        	</v-toolbar>
					<!-- ----TABLA -->
					<v-col cols="12" v-if="precioActivo">
						<v-card-actions> <h3><strong> Precios del {{ artSeleccionado }}</strong></h3></v-card-actions>

						<v-card class="  mt-3" >
							<v-card-actions>
								<v-text-field
									v-model="search"
									append-icon="search"
									label="Buscar "
									single-line
									hide-details
								></v-text-field>
								<v-spacer></v-spacer>
								<v-btn small class="success" @click="abrirModalPrecios(1)">Agregar </v-btn>
							</v-card-actions>
						
							<v-data-table
								:headers="headers_precios"
								:items="getPreciosxId"
								:search="search"
								fixed-header
								height="500px"
								hide-default-footer
								:loading ="Loading_precios"
								loading-text="Cargando... Por favor espere."
							>
								<template v-slot:item.action="{ item }" > 
									<v-btn  class="green darken-4" icon dark @click="abrirModalPrecios(2, item)"><v-icon> create </v-icon></v-btn> 
								</template>

								<template v-slot:item.tipo_producto="{ item }" > 
									{{ item.tipo_producto === 1 ? 'Materia Prima': 'Producto Final' }}
								</template>

							</v-data-table>
						</v-card>

						<v-dialog persistent v-model="ModalPrecios" width="850px" >	
							<v-card class="pt-0 pa-4">
								<ControlPrecios :param2="param2" :edit2="edit2" @modal2="ModalPrecios = $event" />
							</v-card>
						</v-dialog>

					</v-col>
				</v-card>

			</v-dialog>

  	</v-row>
  </v-container>
</template>

<script>
	import ControlProductos from '@/views/Catalogos/Productos/ControlProductos.vue'
	import ControlPrecios   from '@/views/Administracion/Precios/ControlPrecios.vue';

	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlProductos,
			ControlPrecios
		},
		data () {
				return {
					
					//PRODUCTOS
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
					// PRECIOS
					artSeleccionado: '',
					ModalPrecios : false,
					precioActivo: false,
					param2: 0,
					edit2: '',
					headers_precios:[
						{ text: '#'  			 				, align: 'left'  , value: 'id'		  },
						{ text: 'Codigo'	 				, align: 'left'  , value: 'codigo' },
						{ text: 'Proveedor'   		, align: 'left'  , value: 'nombre' },
						{ text: 'Tipo de precio'  , align: 'left'  , value: 'nomunidad' },
						{ text: 'Moneda'		 			, align: 'left'  , value: 'nomlin' 	},
						{ text: 'Estatus'     		, align: 'left'  , value: 'tipo_producto' },
						{ text: ' '        				, align: 'right' , value: 'action', sortable: false },
					],
				}
			},


			created(){
				this.consultaProductos()// CONSULTAR PRODUCTOS A VUEX
			},

			computed:{
				...mapGetters('Productos',['Loading','getProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
				...mapGetters('Precios'	 ,['Loading_precios','getPreciosxId']), // IMPORTANDO USO DE VUEX - PRECIOS (GETTERS)
			},

			methods:{
				...mapActions('Productos',['consultaProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
				...mapActions('Precios',['consultaPreciosxId']), // IMPORTANDO USO DE VUEX - PRECIOS(ACCIONES)

				abrirModal(action, items){ //NUEVO / EDITAR PRODUCTO 
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				abrirModalPrecios(action, items){ //NUEVO /EDITAR PRECIO
					console.log('recibo', action)
					this.param2 = action;
					this.edit2  = items;
					this.ModalPrecios = true;
				},

				MuestraPrecios(item){ // PRECIOS-PROVEEDOR
					this.artSeleccionado = item.nombre;
					this.precioActivo = true;
					this.consultaPreciosxId();

				}	

				
				
			}
	}
</script>
