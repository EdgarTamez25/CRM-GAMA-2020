<template>
	<v-container>
		<v-row class="justify-center">
			<v-col cols="12">
				<v-card-actions class="pa-0" >
					<h3> <strong> Nuevo Compromiso </strong></h3> 
					<v-spacer></v-spacer>
    			<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
    		</v-card-actions>
    		<v-divider class="ma-2"></v-divider>

				<v-row>
					<v-col class="d-flex" cols="12" sm="6" >
			      <v-select
			        :items="items"
			        label="Tipo de Compromiso"
			        placeholder ="Compromiso ah asignar"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>	
			    <v-col class="d-flex" cols="12" sm="6">
			      <v-select
			        :items="items"
			        label="Responsable"
			        placeholder ="Vendedor responsable"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
			    <v-col class="d-flex" cols="12" lg="12">
			      <v-select
			        :items="items"
			        label="Cliente"
			        placeholder ="Nombre del cliente"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>	
			     <v-col class="d-flex" cols="12" sm="6" >
			      <v-select
			        :items="items"
			        label="Contacto"
			        placeholder ="Contacto del cliente"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
			     <v-col class="d-flex" cols="12" sm="6" >
			      <v-select
			        :items="items"
			        label="Direccion"
			        placeholder ="Direccion del cliente"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
			     <v-col class="d-flex" cols="12" sm="6" >
			      <v-select
			        :items="items"
			        label="Proyecto"
			        placeholder ="Proyecto ah trabajar"
			        dense
			        outlined 
			        hide-details
			      ></v-select>
			    </v-col>
				</v-row>

				<v-card-actions>
						<v-spacer></v-spacer>
			    	<v-btn color="success" >Guardar</v-btn>
			    	<!-- <v-btn color="error" @click="$emit('modal',false)">Cancelar</v-btn> -->
			  </v-card-actions>
			</v-col>
		</v-row>	
	</v-container>
</template>

<script>
	export default {
	  components: {
	  },
	  props:[
	  	'dialog'
	  ],

	  data () {
	      return {

	      	selectores: [ { label:'Tipo de compromiso', items:[1,2,3],  placeholder: "Compromiso ah asignar"  ,value:''}, 
	      								{ label:'Responsable'				, items:[324,2,8],  placeholder: "Vendedor Responsable" ,value:''},
	      								{ label:'Tipo de compromiso', items:[1,342,3],  placeholder: "Compromiso ah asignar" },
	      								{ label:'Tipo de compromiso', items:[1,2,3],  placeholder: "Compromiso ah asignar" },
	      								{ label:'Tipo de compromiso', items:[1,2,3],  placeholder: "Compromiso ah asignar" },
	      							],
	      	modal: this.dialog,
	      }
	    },

	    methods:{
	    
	    }
	}
</script>