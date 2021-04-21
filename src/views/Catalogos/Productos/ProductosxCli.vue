<template>
  <v-main class="pa-0 ma-3">
  	<v-row class="justify-center">
      <v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
        <v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
      </v-snackbar>

  		<v-col cols="12" >
				<v-card class="mt-3" outlined>

           <v-row class="pa-1 py-0">
						<v-col cols="12" sm="6">
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > PRODUCTOS POR CLIENTES </v-card-actions>
						</v-col>
						<v-col cols="12" sm="6" class="text-right">  <!-- VENDEDORES -->
							<v-autocomplete
								:items="getClientesProductos" v-model="cliente" item-text="nombre" tem-value="id" label="Clientes" 
								dense outlined hide-details color="celeste" append-icon="mdi-account-search" return-object clearable
							></v-autocomplete>
						</v-col>
           </v-row>

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
			      <v-btn small class="gris" icon dark @click="productosxCliente()" v-if="cliente.id"><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>

			    <v-data-table
			      :headers="headers"
			      :items="getProductosxCli"
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
			    	<!-- <template v-slot:item.estatus="{ item }"  > 
			    		<v-btn color="success" class="ma-1" text small dark @click="" v-if="item.estatus === 1">
								<v-icon> mdi-check-bold </v-icon>
							</v-btn> 
								<v-btn color="error" class="ma-1" text small dark @click="" v-else>
								<v-icon> mdi-alert-circle-outline </v-icon>
							</v-btn>
				    </template> -->
						<template v-slot:item.dx="{ item }"  > 
			    		<span class="font-weight-black ">{{ deptos[item.dx-1].nombre  }}</span>
				    </template>
						<template v-slot:item.codigo="{ item }"  > 
			    		<span class="font-weight-black rosa--text">{{ item.codigo  }}</span>
				    </template>
						<template v-slot:item.action="{ item }"  > 
			    		<v-btn class="celeste ma-1" icon dark @click="abrirModal(3, item)"><v-icon> mdi-pencil </v-icon></v-btn> 
				    </template>

			    </v-data-table>
			  </v-card>
				<!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="page" :length="pageCount"></v-pagination>
				</div>
  		</v-col>

			{{ getProductosxCli}}


			<v-dialog v-model="controlProductoModal" persistent width="700px">
				<v-card class="pa-3">
					<controlProductoxCli 
						:modoVista="modoVista" 
						:data="data" 
						:Vista="Vista"
						@modal="controlProductoModal = $event"/>
				</v-card>
			</v-dialog>

  	</v-row>
  </v-main>
  <!-- </v-container> -->
</template>

<script>
	import controlProductoxCli from '@/views/Catalogos/Productos/controlProductoxCli.vue'
	import {mapGetters, mapActions} from 'vuex';
  // import { object } from '@amcharts/amcharts4/core';
	import  metodos from '@/mixins/metodos.js';
	export default {
		mixins:[metodos],
		components: {
			controlProductoxCli,
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
					controlProductoModal: false,
					modoVista: 0,
					Vista: '',
					data:'',
					headers:[
						{ text: 'Departamento'    , align: 'left'  , value: 'dx' },
						{ text: 'Codigo'   , align: 'left'  , value: 'codigo' },
						{ text: 'Nombre'   , align: 'left'  , value: 'nombre' },
						{ text: 'Desc '    , align: 'left'  , value: 'descripcion' },
						// { text: 'estatus'  , align: 'center'  , value: 'estatus' },
						{ text: ' '        , align: 'right' , value: 'action', sortable: false },
					],
					cliente: { id:null, nombre:'' },
					deptos:[],
				}
			},

			created(){
        // this.consultaProductos()// CONSULTAR PRODUCTOS A VUEX
        this.consultaClienteProductos();
				this.consultaDepartamentos();
			},

			computed:{
        ...mapGetters('ProductosxCliente' ,['Loading','getProductosxCli']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
				...mapGetters('Clientes'  ,['getClientesProductos']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
        
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

			watch:{
				cliente(){
					if(this.cliente){ this.productosxCliente() }
				}
			},

			methods:{
				...mapActions('ProductosxCliente',['consultaProductosxCliente']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
				...mapActions('Clientes'  ,['consultaClienteProductos']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
        

        productosxCliente(){
          this.consultaProductosxCliente(this.cliente.id);
				},

				abrirModal(modoVista, data){ //NUEVO / EDITAR PRODUCTO 
					const payload = new Object();	payload.id_cliente = this.cliente.id ? this.cliente.id: 0 ;
					this.modoVista = modoVista;
					this.data = data? data: payload;
					this.Vista    = 'PRODUCTOS';
					this.controlProductoModal = true;
				},
			}
	}
</script>
