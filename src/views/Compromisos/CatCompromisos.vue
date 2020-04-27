<template>
  <!-- <v-container> -->
  <v-content class="pa-0">

  	<v-row class="justify-center">
  		<v-col cols="12" sm="11">

				<v-row>
					<v-col cols="12" sm="6" md="3"> <!-- TITULO DE LA VISTA -->
						<h3><strong> COMPROMISOS </strong></h3>
					</v-col>
				</v-row>

				<!--		<v-row>
					<v-col cols="12" sm="6" md="3" lg="3"> <!-- FECHA DE COMPROMISO
						<v-dialog
							ref="dialog"
							v-model="modal"
							:return-value.sync="date"
							persistent
							width="290px"
						>
							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="date"
									label="Fecha de compromiso"
									append-icon="event"
									readonly
									v-on="on"
									outlined 
									dense
									hide-details
									color="celeste"
								></v-text-field>
							</template>
							<v-date-picker v-model="date" locale="es-es" class="rosa" scrollable>
								<v-spacer></v-spacer>
								<v-btn text color="gris" @click="modal = false">Cancelar</v-btn>
								<v-btn dark color="celeste" @click="$refs.dialog.save(date)">OK</v-btn>
							</v-date-picker>
						</v-dialog>
					</v-col>

					<v-col cols="12" sm="6" md="3" lg="3"> <!-- FECHA DE CUMPLIMIENTO 
						<v-dialog
							ref="dialog"
							v-model="modal"
							:return-value.sync="date"
							persistent
							width="290px"
						>
							<template v-slot:activator="{ on }">
								<v-text-field
									v-model="date"
									label="Fecha de cumplimiento"
									append-icon="event"
									readonly
									v-on="on"
									outlined 
									dense
									hide-details
									color="celeste"
								></v-text-field>
							</template>
							<v-date-picker v-model="date" locale="es-es" color="rosa" scrollable>
								<v-spacer></v-spacer>
								<v-btn text color="gris" @click="modal = false">Cancelar</v-btn>
								<v-btn dark color="celeste" @click="$refs.dialog.save(date)">OK</v-btn>
							</v-date-picker>
						</v-dialog>
					</v-col>
					
					<v-col class="d-flex" cols="12" sm="6" lg="6">
						<v-autocomplete
							:items="states"
							:filter="customFilter"
							color="celeste"
							item-text="name"
							label="Responsable"
							outlined
							hide-details
							dense
						></v-autocomplete>
					</v-col>
				
		    </v-row> -->

				<!-- CATALOGO DE COMPROMISOS -->
				<v-card class="elevation-10 mt-3" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar compromiso"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="celeste" dark @click="abrirModal(1)">Agregar </v-btn>
			      <v-btn small class="gris" icon dark @click="consultaCompromisos" ><v-icon>refresh</v-icon> </v-btn>

			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="getCompromisos"
			      :search="search"
			      fixed-header
				 		height="500px"
				  	hide-default-footer
						:loading ="Loading"
						loading-text="Cargando... Por favor espere."
			    >

						<template v-slot:item.tipo_compromiso="{ item }" > 
			    		{{ item.tipo_compromiso === 1? 'Interno': 'Externo'}}
				    </template>

						<template v-slot:item.cumplimiento="{ item }" >  
			    			{{ item.cumplimiento === 0? 'Sin realizar': 'Cumplido'}} 
				    </template>

			    	<template v-slot:item.action="{ item }" > 
			    		<v-btn  class="celeste" icon dark @click="abrirModal(2, item)"><v-icon> create </v-icon></v-btn> <!-- Editar -->
				    </template>

			    </v-data-table>
			  </v-card>

				 <v-dialog persistent v-model="dialog" width="700px" >	
		    	<v-card>
		    		<ControlCompromiso :param="param" :edit="edit" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>

  		</v-col>
  	</v-row>
  </v-content>
  <!-- </v-container> -->
</template>

<script>
	import ControlCompromiso  from '@/views/Compromisos/ControlCompromiso.vue';
	import {mapGetters, mapActions} from 'vuex';

	export default {
		components: {
			ControlCompromiso
		},
		data () {
				return {
					search: '',
					dialog: false,
					param: 0,
					edit:'',
					headers: [
							{ text: 'Vendedor'					, align: 'left'	 , value: 'nomvend' },
							{ text: 'Tipo'							, align: 'left'	 , value: 'tipo_compromiso' },
							{ text: 'Categoria'					, align: 'left'	 , value: 'nomcatego' },
							{ text: 'Cliente'					  , align: 'left'	 , value: 'nomcli' },
							{ text: 'Fecha'							, align: 'left'	 , value: 'fecha' },
							{ text: 'Hora'							, align: 'left'	 , value: 'hora' },
							// { text: 'Comentario'				, align: 'left'	 , value: 'comentarios' },
							{ text: 'Cumplimiento'			, align: 'left'	 , value: 'cumplimiento' },
							{ text: '', value: 'action' , sortable: false },

					],

					states: [
          { name: 'Florida', abbr: 'FL', id: 1 },
          { name: 'Georgia', abbr: 'GA', id: 2 },
          { name: 'Nebraska', abbr: 'NE', id: 3 },
          { name: 'California', abbr: 'CA', id: 4 },
          { name: 'New York', abbr: 'NY', id: 5 },
        ],

					date: new Date().toISOString().substr(0, 10),
					menu: false,
					modal: false,
					menu2: false,
					dialog: false,
			
				}
			},

			created(){
				this.consultaCompromisos() // CONSULTAR CLIENTES A VUEX
			},

			computed:{
				...mapGetters('Compromisos'  ,['getCompromisos','Loading']), // IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			},

			methods:{
				...mapActions('Compromisos'  ,['consultaCompromisos']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

				abrirModal(action, items){
					this.param = action;
					this.edit = items;
					this.dialog = true;
				},

				customFilter (item, queryText, itemText) {
        const textOne = item.name.toLowerCase()
        const textTwo = item.abbr.toLowerCase()
        const searchText = queryText.toLowerCase()

        return textOne.indexOf(searchText) > -1 ||
          textTwo.indexOf(searchText) > -1
      	},
				save () {
					this.isEditing = !this.isEditing
					this.hasSaved = true
				},
				
			}
	}
</script>
