<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12">
				<v-card-actions> <h3><strong> Catálogo de Monedas</strong></h3></v-card-actions><v-divider></v-divider>
				
				<!-- <v-row>
					<v-col class="d-flex" cols="12" sm="6" lg="3">
			      <v-select
			        label="Sucursal"
			        placeholder ="Sucursales"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
		    </v-row> -->

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
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="usuarios"
			      :search="search"
			      fixed-header
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="orange darken-4" icon dark ><v-icon> chrome_reader_mode </v-icon></v-btn> <!-- Cotizacion -->
			    		<v-btn  class="blue darken-4" icon dark><v-icon  > directions_run  </v-icon></v-btn>     <!-- Seguimiento -->
			    		<v-btn  class="green darken-4" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="700px" >	
		    	<v-card>
		    		<ControlMonedas :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>

  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlMonedas  from '@/views/Catalogos/Monedas/ControlMonedas.vue'

	export default {
		components: {
			ControlMonedas
		},
		data () {
				return {
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers:[
						{ text: '#'  					 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre'			 , align: 'left'  , value: 'nombre' },
						{ text: 'Correo   '		 , align: 'left'  , value: 'correo' },
						{ text: 'Nivel'				 , align: 'left'  , value: 'nivel' 	},
						{ text: 'Sucursal'		 , align: 'left'  , value: 'nomsuc' },
						{ text: 'Ver Detalle'  , align: 'right' , value: 'action', sortable: false },
					],
					usuarios:[{ id: 1, nombre:'Edgar Tamez', correo:'edgar.t@gamaetiquetas.com', nivel:'Administrador', nomsuc:'GAMA 1'}]

				}
			},

			methods:{
				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				}
			}
	}
</script>
