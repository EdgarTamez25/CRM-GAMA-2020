<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12"  lg="8">
				<v-card-actions> <h3><strong> Catálogo de Monedas</strong></h3></v-card-actions>

				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar monedas"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaMonedas"><v-icon>refresh</v-icon> </v-btn>

			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getMonedas"
			      :search="search"
			      fixed-header
				  	height="500px"
				  	hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
			    >
			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>
						
						<template v-slot:item.predeterminado="{ item }" > 
			    		<v-btn 
								small 
								dark 
								:color="item.predeterminado === 1? 'green darken-4': 'red darken-4'" 
								@click="predeterminado(item.id)"
							> 
								{{ item.predeterminado === 1? 'Si': 'No'}}
							</v-btn> 
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="600px" >	
		    	<v-card>
		    		<ControlMonedas :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>
  		</v-col>
  	</v-row>
  </v-container>
</template>

<script>
	import ControlMonedas  from '@/views/Catalogos/Monedas/ControlMonedas.vue';
	import {mapGetters, mapActions} from 'vuex';

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
						{ text: '#'  		 , align: 'left'  , value: 'id'		  },
						{ text: 'Nombre' , align: 'left'  , value: 'nombre' },
						{ text: 'Codigo' , align: 'left'  , value: 'codigo' },
						{ text: 'Tipo de cambio' , align: 'left'  , value: 'tipo_cambio' },
						{ text: 'predeterminado' , align: 'center' , value: 'predeterminado', sortable: false },
						{ text: ' '  		 , align: 'right' , value: 'action', sortable: false },
					],
				}
			},

			created(){
				this.consultaMonedas() // CONSULTAR Carteras A VUEX
			},

			computed:{
				...mapGetters('Monedas' ,['getMonedas','Loading']), // IMPORTANDO USO DE VUEX - Monedas (GETTERS)
			},

			methods:{
				...mapActions('Monedas'  ,['consultaMonedas','ActualizaMoneda']), // IMPORTANDO USO DE VUEX - Carteras(ACCIONES)

				predeterminado(id){
					this.$http.put('predeterminado/'+ id).then((response)=>{
						// console.log('response monedas', response.body)
						this.consultaMonedas()
						this.ActualizaMoneda()
					})
				},

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},
			}
	}
</script>
