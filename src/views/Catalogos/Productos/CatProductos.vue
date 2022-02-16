<template>
  <!-- <v-container> -->
  <v-content class="pa-0 ma-3">

  	<v-row class="justify-center">
			<v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
				<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
			</v-snackbar>

  		<v-col cols="12" >
				<v-card-actions class="font-weight-black headline"> PRODUCTOS </v-card-actions>

				<v-card class="mt-3" outlined>
				<!-- <v-card-actions> <h3><strong>PRODUCTOS</strong></h3></v-card-actions> -->

					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar producto"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" @click="abrirModal(1)" dark>Agregar  </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaProductos" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getProductosAll"
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
			    	<template v-slot:item.action="{ item }"  > 
			    		<v-btn  class="orange darken-1 ma-1" icon dark @click="MuestraPrecios(item)"><v-icon> attach_money </v-icon></v-btn> 
			    		<v-btn  class="celeste ma-1" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> 
				    </template>

						<template v-slot:item.tipo_producto="{ item }" > 
							{{ item.tipo_producto === 1 ? 'Materia Prima': 'Producto Final' }}
				    </template>

						<template v-slot:item.nomprov="{ item }" > 
							<span :class="item.nomprov != 'Sin proveedor'? 'black--text': 'red--text'"> {{  item.nomprov  }} </span>
						</template>

						<template v-slot:item.precio="{ item }" > 
							<span :class="item.precio != 0 ? 'black--text': 'red--text'"> {{  item.precio  }} </span>
						</template>

			    </v-data-table>
			  </v-card>
				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>

					<!-- {{ tamanioPantalla }} -->
				 <v-dialog persistent v-model="dialog" width="700px" >	
					<v-card class="pt-0 pa-4">
		    		<ControlProductos :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
			

			<!-- PRECIOS-->
			<v-dialog v-model="precioActivo" fullscreen hide-overlay transition="dialog-bottom-transition">
				<v-card>
					<!-- CABEZERA -->
					<v-toolbar dark color="celeste">
          	<!-- <v-toolbar-title> <strong> {{ artSeleccionado }} </strong> </v-toolbar-title> -->
          	<v-spacer></v-spacer>
						<v-toolbar-items>
							<v-btn icon dark @click="precioActivo = false">
								<v-icon>mdi-close</v-icon>
							</v-btn>
						</v-toolbar-items>
        	</v-toolbar>
					<!--TABLA -->
					<v-col cols="12" v-if="precioActivo">
						<v-card-actions> <h3><strong> Precios del {{ nomproducto }}</strong></h3></v-card-actions>

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
								<v-btn small class="celeste" dark @click="abrirModalPrecios(1)">Agregar </v-btn>
							</v-card-actions>

							<v-data-table
								:headers="headers_precios"
								:items="getPreciosxId"
								:search="search"
								fixed-header
								height="550px"
								hide-default-footer
								:loading ="Loading_precios"
								loading-text="Cargando... Por favor espere."
								disable-pagination
							>
								<template v-slot:item.action="{ item }" > 
									<v-btn  class="celeste" icon dark @click="abrirModalPrecios(2, item)"><v-icon> create </v-icon></v-btn> 
								</template>

								<template v-slot:item.predeterminado="{ item }" > 
									<v-btn 
										small 
										dark 
										:color="item.predeterminado === 1? 'green darken-4': 'red darken-4'" 
										@click="predeterminado(item)"
									> 
										{{ item.predeterminado === 1? 'Si': 'No'}}
									</v-btn>  
								</template>

								<template v-slot:item.tipo_producto="{ item }" > 
									{{ item.tipo_producto === 1 ? 'Materia Prima': 'Producto Final' }} 
								</template>

							</v-data-table>
						</v-card>

						<v-dialog persistent v-model="ModalPrecios" width="850px" >	
							<v-card class="pt-0 pa-4">
								<ControlPrecios2 
									:param2="param2" 
									:edit2="edit2" 
									:id_art="id_art" 
									:nomproducto ="nomproducto"
									@modal2="ModalPrecios = $event" 
								/>
							</v-card>
						</v-dialog>

					</v-col>
				</v-card>
			</v-dialog>

  	</v-row>
  </v-content>
  <!-- </v-container> -->
</template>

<script>
	import ControlProductos from '@/views/Catalogos/Productos/ControlProductos.vue'
	// import ControlPrecios   from '@/views/Administracion/Precios/ControlPrecios.vue';
	import ControlPrecios2   from '@/views/Administracion/Precios/ControlPrecios2.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlProductos,
			// ControlPrecios
			ControlPrecios2,
		
		},
		data () {
				return {
					page: 1,
					pageCount: 0,
					itemsPerPage: 200,
					// ALERTAS
					snackbar: false,
					text		: '',
					color		: 'success',
					//PRODUCTOS
					search: '',    
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  		   , align: 'left'  , value: 'id'		  },
						{ text: 'Codigo'   , align: 'left'  , value: 'codigo' },
						{ text: 'Nombre'   , align: 'left'  , value: 'nombre' },
						{ text: 'Proveedor', align: 'left'  , value: 'nomprov' },
						{ text: 'Precio'   , align: 'left'  , value: 'precio' },
						{ text: 'Linea'		 , align: 'left'  , value: 'nomlin' 	},
						{ text: 'Tipo'     , align: 'left'  , value: 'tipo_producto' },
						{ text: ' '        , align: 'right' , value: 'action', sortable: false },
					],
					// PRECIOS
					id_art : 0,
					nomproducto : '',
					ModalPrecios : false,
					precioActivo: false,
					param2: 0,
					edit2: '',
					headers_precios:[
						{ text: '#'  			 				, align: 'left'  , value: 'id'		  },
						{ text: 'Codigo'	 				, align: 'left'  , value: 'codigo' },
						{ text: 'Proveedor'   		, align: 'left'  , value: 'nomprov' },
						{ text: 'Precio'   				, align: 'left'  , value: 'total' },
						{ text: 'Tipo de precio'  , align: 'left'  , value: 'nomtipo_precio' },
						{ text: 'Moneda'		 			, align: 'left'  , value: 'cod_moneda' 	},
						{ text: 'Predeterminado'  , align: 'center'  , value: 'predeterminado' },
						{ text: ' '        				, align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaProductos()// CONSULTAR PRODUCTOS A VUEX
			},

			computed:{
				...mapGetters('Productos',['Loading','getProductosAll']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
				...mapGetters('Precios'	 ,['Loading_precios','getPreciosxId']), // IMPORTANDO USO DE VUEX - PRECIOS (GETTERS)

				tamanioPantalla () {
					console.log(this.$vuetify.breakpoint)
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
				...mapActions('Productos',['consultaProductos']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
				...mapActions('Precios',['consultaPreciosxId']), // IMPORTANDO USO DE VUEX - PRECIOS(ACCIONES)

				abrirModal(action, items){ //NUEVO / EDITAR PRODUCTO 
					this.param = action; // MANDO EL MODO DE LA VISTA 
					this.edit = items;   // MANDA LA INFORMACION DEL PRODUCTO SELECCIONADO
					this.dialog = true;  // ABRE LA MODAL PARA CREAR / EDITAR PRECIOS
				},

				abrirModalPrecios(action, items){ //NUEVO /EDITAR PRECIO
					this.param2 = action;   //MANDO EL MODO DE LA VISTA 
					this.edit2  = items ;    // MANDA LA INFORMACION DEL PRECIO SELECCIONADO
					this.ModalPrecios = true;  //ABRE LA MODAL PARA CREAR / EDITAR PRECIOS
				},

				MuestraPrecios(item){ // ABRE LA MODAL DE PRECIOS POR PROVEEDOR
					this.id_art  			= item.id;     //GUARDA EL ID DEL PRODUCTO SELECCIONADO
					this.nomproducto 	= item.nombre; // GUARDA EL NOMBRE DLE ARTICULO SELECCIONADO
					this.precioActivo = true;              // ABRE LA MODAL DE PRECIOS POR PROVEEDOR
					this.consultaPreciosxId(item.id);      // MANDA A CONSULTAR LOS PRECIOS POR EL ID DEL ART
				},

				predeterminado(item){
					const payload ={ id_precio: parseInt(item.id), id_producto: parseInt(item.id_producto) }
					this.$http.post('predeterminado', payload).then((response)=>{
						this.snackbar = true; this.text = response.body; 
						this.consultaPreciosxId(item.id_producto)
					})
				}
			}
	}
</script>
