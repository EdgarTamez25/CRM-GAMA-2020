<template>
	<v-container>
		<v-row>
			<v-col cols="12">

				<v-card-actions> <h3><strong> Pendientes </strong></h3></v-card-actions><v-divider></v-divider>

				<v-col class="d-flex" cols="12" sm="6" >
		      <v-select
		        :items="items"
		        label="Vendedor"
		        placeholder ="Nombre del vendedor"
		        dense
		        outlined 
		        hide-details
		      ></v-select>
		    </v-col>

		    <v-card >
			      <v-card-actions>
				      <v-text-field
				        v-model="search"
				        append-icon="search"
				        label="Buscar"
				        single-line
				        hide-details
				      ></v-text-field>
				      <v-spacer></v-spacer>
				      <v-btn small class="success" @click="dialog= true">Nuevo</v-btn>
				    </v-card-actions>

			    <v-data-table
			      :headers="headers"
			      :items="pendientes"
			      :search="search"
			      fixed-header
			      
			    >
			    	<template v-slot:item.action="{ item }">
				      <v-icon small class="mr-2"> edit </v-icon>
				      <v-icon small > delete </v-icon>
				    </template>

			    </v-data-table>
			  </v-card>

			</v-col>
		</v-row>
	</v-container>
</template>

<script>
	export default {
	  components: {
	  },
	  data () {
	      return {
	      	search: '',
	        headers: [
	          { text: '#'				, value: 'id' , align: 'left'},
	          { text: 'Cliente'	, value: 'name' },
	          { text: 'Concepto', value: 'date' },
	          { text: 'Estatus' , value: 'date' },
	          { text: 'Actions', value: 'action', sortable: false },

	        ],

	        pendientes: [],
	      }
	    },
	}
</script>