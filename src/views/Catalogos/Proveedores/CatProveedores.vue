<template>
  <v-content class="pa-0 ma-3">
  	<v-row justify="center">
  		<v-col cols="12">
				<v-card-actions class="font-weight-black headline"> PROVEEDORES </v-card-actions>
				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar Proveedor"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaProveedores"><v-icon>refresh</v-icon> </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getProveedores"
			      :search="search"
						dense
			      fixed-header
						height="500px"
						hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
						:page.sync="page"
      			:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

						<template v-slot:item.tipo_prov="{ item }" > 
							 {{  item.tipo_prov === 1 ? 'NACIONAL':'INTERNACIONAL'}} 

				    </template>

						<!-- <template v-slot:item.direccion="{ item }" > 
							 {{ item.direccion +', '+item.cp +', '+item.ciudad+', '+item.estado+', '+ item.pais}} 
				    </template> -->

						<template v-slot:item.estatus="{ item }" > 
			    		<v-btn  class="green" icon dark  v-if="item.estatus==='1'" @click="cambiaEstatus(item)">
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

				 <v-dialog persistent v-model="dialog" width="600px">	
		    	<v-card  class="pa-5">
		    		<ControlProveedor :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>

  		</v-col>
  	</v-row>
  </v-content>
</template>

<script>
	import ControlProveedor  from '@/views/Catalogos/Proveedores/ControlProveedor.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlProveedor
		},
		data () {
				return {
					page: 0,
					pageCount: 0,
					itemsPerPage: 100,
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  					 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'			 , align: 'left'  , value: 'nombre' },
						{ text: 'Razon Social' , align: 'left'  , value: 'razon_social' },
						{ text: 'Dirección' 	 , align: 'left'  , value: 'direccion' },
						{ text: 'Ciudad ' 		 , align: 'left'  , value: 'ciudad' },
						{ text: 'Estado ' 		 , align: 'left'  , value: 'estado' },
						{ text: 'Pais ' 		   , align: 'left'  , value: 'pais' },
						{ text: 'C.P. ' 		   , align: 'left'  , value: 'cp' },
						{ text: 'RFC'				   , align: 'left'  , value: 'rfc' 	},
						{ text: 'Tipo Proveedor', align: 'left'  , value: 'tipo_prov' },
						{ text: 'Estatus'				, align: 'left'  , value: 'estatus' },
						{ text: ''  					 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaProveedores() // CONSULTAR PROVEEDORES A VUEX
			},

			computed:{
				...mapGetters('Proveedores',['Loading','getProveedores']), // IMPORTANDO USO DE VUEX - PROVEEDORES (GETTERS)
			},

			methods:{
				...mapActions('Proveedores'  ,['consultaProveedores']), // IMPORTANDO USO DE VUEX - PROVEEDORES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				cambiaEstatus(data){
					const payload = { id: data.id, estatus: data.estatus === '1'? 0:1};
					this.$http.post('cambia.estatus.p',payload).then((res)=>{
						this.consultaProveedores();
					}).catch((err)=>{
						console.log('err', err)
					})
				}
				
				
			}
	}
</script>
