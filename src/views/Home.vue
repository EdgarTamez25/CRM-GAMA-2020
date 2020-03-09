<template>
  <v-container>
  	<v-row class="justify-center">
  		<v-col cols="12">
  			<v-card class="pa-2 elevation-10">
  				
  				<v-card-actions>
  					<h2><strong>Checkout Pendientes</strong></h2>
  				</v-card-actions>
  				<v-divider></v-divider>

  				<v-alert icon="policy" v-ripple prominent text type="orange" class="mt-4" v-if="pendientes.length === 0">
				     NO HAY QUE REGISTROS QUE MOSTRAS...
				  </v-alert>

  				<v-card flat v-if="pendientes.length">
				    <v-card-title>
				      <v-text-field
				        v-model="search"
				        append-icon="search"
				        label="Buscar"
				        single-line
				        hide-details
				      ></v-text-field>
				    </v-card-title>
				    <v-data-table
				      :headers="headers"
				      :items="pendientes"
				      :search="search"
				      fixed-header
				    ></v-data-table>
				  </v-card>

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
          { text: '#', align: 'left', value: 'id' },
          { text: 'Cliente', value: 'name' },
          { text: 'Fecha', value: 'date' },
        ],

        pendientes: [    
          
        ],
      }
    },
}
</script>
