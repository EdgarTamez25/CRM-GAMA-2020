<template>
	<v-container class="pa-0">
		<v-row class="justify-center">
			<v-col cols="12">

				<v-card-actions> <h3><strong> Compromisos</strong></h3></v-card-actions><v-divider></v-divider>
				
				<v-row>
					<v-col class="d-flex" cols="12" sm="6" lg="4">
			      <v-select
			        label="Responsable"
			        placeholder ="Vendedor responsable"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
			    <v-col class="d-flex" cols="12" sm="6" lg="3">
			      <v-select
			        label="Tipo de compromiso"
			        placeholder ="Compromiso ah asignar"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
			    <v-spacer></v-spacer>
			    <v-col cols="12" sm="6" md="2">
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
			          ></v-text-field>
			        </template>
			        <v-date-picker v-model="date" locale="es-es" color="blue darken-4" scrollable>
			          <v-spacer></v-spacer>
			          <v-btn text color="error" @click="modal = false">Cancel</v-btn>
			          <v-btn dark color="primary" @click="$refs.dialog.save(date)">OK</v-btn>
			        </v-date-picker>
			      </v-dialog>
			    </v-col>
			    <v-col cols="12" sm="6" md="2">
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
			          ></v-text-field>
			        </template>
			        <v-date-picker v-model="date" locale="es-es" color="blue darken-4" scrollable>
			          <v-spacer></v-spacer>
			          <v-btn text color="error" @click="modal = false">Cancel</v-btn>
			          <v-btn dark color="blue darken-4" @click="$refs.dialog.save(date)">OK</v-btn>
			        </v-date-picker>
			      </v-dialog>
			    </v-col>
		    </v-row>

		    <v-dialog persistent v-model="dialog" width="800" >	
		    	<v-card>
		    		<NuevoCompromiso :dialog="dialog" @modal="dialog = $event" />
		    	</v-card>
		    </v-dialog>

				<v-card class="elevation-10" >
					<v-card-actions>
			      <v-text-field
			        v-model="search"
			        append-icon="search"
			        label="Buscar"
			        single-line
			        hide-details
			      ></v-text-field>
			      <v-spacer></v-spacer>
			      <v-btn small class="success" @click="dialog= true">Agregar </v-btn>
			    </v-card-actions>
				
			    <v-data-table
			      :headers="headers"
			      :items="compromisos"
			      :search="search"
			      fixed-header
			    >
			    	<template v-slot:item.action="{ item }" >
			    <!-- 		<v-btn small class="orange darken-4" dark class=>Cotizar</v-btn>
			    		<v-btn small class="blue darken-4" dark>Seguimiento</v-btn> -->
				      <v-icon  class="mr-2"> chrome_reader_mode </v-icon>
				      <v-icon  > directions_run  </v-icon>
				    </template>

			    </v-data-table>
			  </v-card>
			</v-col>
		</v-row>
	</v-container>
</template>
	
<script>
import NuevoCompromiso  from '@/views/Compromisos/NuevoCompromiso'

export default {
  components: {
  	NuevoCompromiso
  },
  data() {
      return {
      	search: '',
        headers: [
          { text: 'Responsable', align: 'left', value: 'nombre' },
        //   { text: 'Contacto', value: 'contacto',  },
          { text: 'Tipo de Compromiso', value: 'tcompromiso' },
          { text: 'Compromiso', value: 'f_compromiso' },
          { text: 'Comentario', value: 'comentario_1' },
          { text: 'Cumplimiento', value: 'f_cumplimiento' },
          { text: 'Comentario Final', value: 'comentario_2' },
          { text: 'Folio', value: 'folio' },
          { text: 'Estatus', value: 'estatus' },
          { text: '', value: 'action', sortable: false },

        ],

        compromisos: [{ nombre: 'Edgar Tamez', 
      								  contacto: '811-025-345',
      								  tcompromiso: 'llamar de negociación',
      									f_compromiso: '26/02/2020',
      									comentario_1: 'No recibio la llamada.',
      									f_cumplimiento: '',
      								 	comentario_2: '',
      								 	folio: 'ET001',
      								 	estatus: 'Prospecto',
      							}],

        date: new Date().toISOString().substr(0, 10),
	      menu: false,
	      modal: false,
	      menu2: false,
	      dialog: false,
      }

    },
}
</script>