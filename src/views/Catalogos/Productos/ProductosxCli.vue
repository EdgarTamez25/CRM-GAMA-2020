<template>
  <v-content class="pa-0 ma-3">
  	<v-row class="justify-center">
      <v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
        <v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
      </v-snackbar>

      <v-col cols="12" md="4">
        <v-card class="mt-3" outlined> 
          <v-row class="pa-1 py-0">
						<v-col cols="12" >
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > CLIENTES </v-card-actions>
						</v-col>
           </v-row>

          <v-card-actions>
			      <v-text-field v-model="searchCli" append-icon="search" label="Buscar cliente" single-line hide-details></v-text-field>
			    </v-card-actions>

          <v-data-table
			      :headers="hClientes"
			      :items="getClientes"
			      :search="searchCli"
			      fixed-header
						:height="tamanioPantalla"
						hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
						:page.sync="pageCli"
      			:items-per-page="itemsPerPageCli"
						@page-count="pageCliCount = $event"
						dense
			    >
            <template v-slot:item.action="{ item }"  > 
			    		<v-btn outlined small dark class="celeste ma-1" @click="productosxCliente(item)"><v-icon> mdi-eye </v-icon></v-btn> 
				    </template>
			    </v-data-table>
        </v-card>
        <!-- PAGINACION -->
				<div class="text-center pt-2">
					<v-pagination v-model="pageCli" :length="pageCliCount"></v-pagination>
				</div>
      </v-col>

  		<v-col cols="12" md="8" >
				<v-card class="mt-3" outlined>
           <v-row class="pa-1 py-0">
						<v-col cols="12">
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > PRODUCTOS POR CLIENTES </v-card-actions>
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
			      <v-btn small class="gris" icon dark @click="consultaProductos" ><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getProductosxCli"
			      :search="search"
			      fixed-header
				    :height="tamanioPantalla"
				    hide-default-footer
						:loading ="LoadingPxC"
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

  		</v-col>
  	</v-row>
  </v-content>
  <!-- </v-container> -->
</template>

<script>
	// import ControlProductos from '@/views/Catalogos/Productos/ControlProductos.vue'
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			// ControlProductos,
			// ControlPrecios
			// ControlPrecios2,
		
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
          pageCli: 1,
          pageCliCount: 0,
          itemsPerPageCli: 400,
          searchCli : '',
          hClientes:[
            { text: '', align:'left', value:'id'},
            { text: '', align:'left', value:'nombre'},
          	{ text: ' '        , align: 'right' , value: 'action', sortable: false },
          ]
					
				}
			},

			created(){
        // this.consultaProductos()// CONSULTAR PRODUCTOS A VUEX
        this.consultaClientes()
			},

			computed:{
        ...mapGetters('ProductosxCliente' ,['LoadingPxC','getProductosxCli']), // IMPORTANDO USO DE VUEX - PRODUCTOS (GETTERS)
				...mapGetters('Clientes'  ,['Loading','getClientes']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
        
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
				...mapActions('ProductosxCliente',['consultaProductosxCliente']), // IMPORTANDO USO DE VUEX - PRODUCTOS(ACCIONES)
				...mapActions('Clientes'  ,['consultaClientes']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
        

        productosxCliente(item){
          this.consultaProductosxCliente(item.id);
        },


				abrirModal(action, items){ //NUEVO / EDITAR PRODUCTO 
					this.param = action; // MANDO EL MODO DE LA VISTA 
					this.edit = items;   // MANDA LA INFORMACION DEL PRODUCTO SELECCIONADO
					this.dialog = true;  // ABRE LA MODAL PARA CREAR / EDITAR PRECIOS
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
