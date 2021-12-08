<template>
  <v-main class="pa-0 py-0 ma-3">
		<v-row justify="center">

			<v-snackbar v-model="alerta.activo" multi-line vertical top right :color="alerta.color" > 
				<strong> {{alerta.texto}} </strong>
				<template v-slot:action="{ attrs }">
					<v-btn color="white" text @click="alerta.activo = false" v-bind="attrs"> Cerrar </v-btn>
				</template>
			</v-snackbar>

			<v-col cols="12">
				<v-card outlined class="pa-3">
					<v-row class=" py-0">
						<v-col cols="12"  md="6" >
							<v-card-actions class="font-weight-black headline  py-0 mt-1 " > ORDENES DE TRABAJO </v-card-actions>
						</v-col>

						<v-col cols="12" sm="4" md="2"> <!-- ESTATUS ACTIVO -->
							<v-select
								v-model="estatus" :items="Estatus" item-text="nombre" item-value="id"  dense
								hide-details  placeholder="Estatus " return-object outlined append-icon="mdi-circle-slice-5"
							></v-select> 
						</v-col>

						<v-col cols="6" sm="4" md="2" > <!-- FECHA DE INICIO -->
							<v-dialog ref="fecha1" v-model="fechamodal1" :return-value.sync="fecha1" persistent width="290px">
								<template v-slot:activator="{ on }">
									<v-text-field
										v-model="fecha1" label="Fecha Inicio" append-icon="event" readonly v-on="on"
										dense hide-details color="celeste" outlined
									></v-text-field>
								</template>
								<v-date-picker v-model="fecha1" locale="es-es" color="rosa"  scrollable>
									<v-spacer></v-spacer>
									<v-btn text small color="gris" @click="fechamodal1 = false">Cancelar</v-btn>
									<v-btn dark small color="rosa" @click="$refs.fecha1.save(fecha1)">OK</v-btn>
								</v-date-picker>
							</v-dialog>
						</v-col>

						<v-col cols="6" sm="4" md="2"  > <!-- FECHA DE FIN -->
							<v-dialog ref="fecha2" v-model="fechamodal2" :return-value.sync="fecha2" persistent width="290px">
								<template v-slot:activator="{ on }">
									<v-text-field
										v-model="fecha2" label="Fecha fin" append-icon="event" readonly v-on="on"
										dense hide-details color="celeste" outlined
									></v-text-field>
								</template>
								<v-date-picker v-model="fecha2" locale="es-es" color="rosa"  scrollable>
									<v-spacer></v-spacer>
									<v-btn text small color="gris" @click="fechamodal2 = false">Cancelar</v-btn>
									<v-btn dark small color="rosa" @click="$refs.fecha2.save(fecha2)">OK</v-btn>
								</v-date-picker>
							</v-dialog>
						</v-col>
						
						<v-col cols="12" >
							<v-card-actions>
								<v-text-field
									v-model="search"
									append-icon="search"
									label="Buscar"
									hide-details
									filled dense
								></v-text-field>
								<v-spacer></v-spacer>
								<!--<v-btn  dark color="green" @click="ImprimirExcel()"> <v-icon >mdi-microsoft-excel </v-icon> </v-btn> -->
								<!--<v-btn color="primary" dark  @click="altaOT = !altaOT"> Nueva O.T </v-btn> -->
								<v-btn  class="gris" icon dark @click="initialize()" ><v-icon>refresh</v-icon> </v-btn>
							</v-card-actions>
						</v-col>
					</v-row>

					<v-data-table
						:headers="headers"
						:items="getOT"
						:search="search"
						:height="tamanioPantalla"
						fixed-header
						hide-default-footer
						:page.sync="page"
						:items-per-page="itemsPerPage"
						@page-count="pageCount = $event"
						dense
						:loading="Loading"
					 > 
						<template v-slot:top>
							<v-dialog v-model="dialogDelete" max-width="500px">
								<v-card class="pa-1" dark>
									<v-card-title class="subtitle-1 font-weight-black" > ¿ Estas seguro de querer eliminar el registro número {{ editedItem.id  }} ?</v-card-title>
									<v-card-text  class="subtitle-1 font-weight-bold text-center warning--text"> Una vez eliminado no se podra recuperar</v-card-text>
									<v-divider class="verde"></v-divider>
									<v-card-actions>
										<v-btn color="warning darken-1"   @click="closeDelete">Cancelar</v-btn>
										<v-spacer></v-spacer>
										<v-btn color="green darken-1" text dark @click="deleteItemConfirm">Sí, Seguro</v-btn>
									</v-card-actions>
								</v-card>
							</v-dialog>
						</template>

						<template v-slot:item.oc="{ item }">
							{{ item.oc ? item.oc : 'SIN O.C.'}}
						</template>

						<template v-slot:item.hora="{ item }">
							{{ item.hora >='12:00'? item.hora +' '+'pm': item.hora+ ' '+'am' }}
						</template>

						<template v-slot:item.fecha="{ item }">
							<span> {{  moment(item.fecha).format('LL') }} </span>
						</template>

						<template v-slot:item.solicitud = "{ item }">
							<span v-if="item.id_solicitud "> {{ item.id_solicitud }} </span>
							<span v-else> S/REFERENCIA </span>
						</template>

						
						
						<template v-slot:item.estatus="{ item }">
							<v-card-actions> 
								<v-spacer></v-spacer>
									<v-checkbox v-model="item.estatus" color="success" @click="cambiarEstatus(item)" ></v-checkbox>
							</v-card-actions>
						</template>

						<template v-slot:item.action="{ item }">
							<v-btn class="ma-1" small color="success" @click="editItem(item)">
							<v-icon > mdi-pencil </v-icon>
							</v-btn>
							<v-btn class="ma-1" small color="error" @click="deleteItem(item)">
							<v-icon> mdi-delete </v-icon>
							</v-btn>
						</template>
					
					</v-data-table>
					
				</v-card>
				<!-- PAGINACION -->
					<div class="text-center pt-2">
						<v-pagination v-model="page" :length="pageCount"></v-pagination>
					</div>
			</v-col>

			<v-dialog persistent v-model="dialog" width="800px" transition="dialog-bottom-transition">	
				<v-card class="pa-3">
					<controlOT 
						:modoVista="modoVista" 
						:parametros="parametros" 
						@modal="dialog = $event" 
					/>
				</v-card>
			</v-dialog>

			<v-dialog persistent v-model="altaOT" width="800px" transition="dialog-bottom-transition">	
				<v-card class="pa-3">
					<altaOT 
						:modoVista="modoVista" 
						:parametros="parametros" 
						@modal="altaOT = $event" 
					/>
				</v-card>
			</v-dialog>


		</v-row>
	</v-main>
</template>

<script>
	var moment = require('moment'); moment.locale('es') /// inciar Moment 
  import {mapGetters, mapActions} from 'vuex';
  import  metodos  from '@/mixins/metodos.js';
	import controlOT from '@/views/OT/controlOT.vue';
	import altaOT    from '@/views/OT/altaOT.vue';


  export default {
    mixins:[metodos],
		components: {
			controlOT,
			altaOT
		},
    data: () => ({
			search: '',
      page: 0,
      pageCount: 0,
      itemsPerPage: 100,

			altaOT: false,
      dialog: false,
      dialogDelete: false,

      atencion_integral: [],
      headers: [
				{ text: 'N° de Orden' , align: 'start' , value: 'id' },
				{ text: 'Cliente'			, align: 'left'	 , value: 'nomcli' },
				{ text: 'O.C.'			  , align: 'left'	 , value: 'oc' },
				{ text: 'Fecha'			  , align: 'left'	 , value: 'fecha' },
				{ text: '# Solicitud'	, align: 'left'	 , value: 'solicitud' },
			  { text: 'Solicitante'	, align: 'left'	 , value: 'solicitante' },
				{ text: '' 						, align: 'right' , value: 'action' , sortable: false },
			],

      editedIndex: -1,
      editedItem: {},
      defaultItem: {
        id: null,
        nombre: null,
        cantidad: null,
        ciclo: {id:null , nombre:''},
      },
      ciclo_escolar: [],
      alerta: { activo: false, texto:'', color:'error' },

			estatus: {  id: 1, nombre:'Pendiente'},
			Estatus:[ 
				{ id: 1, nombre:'Pendiente'},
				{ id: 3, nombre:'Terminado'},
				{ id: 2, nombre:'Cancelado'}
			],

			modoVista: 1, 
			parametros: {},

			fecha1:moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"), 
			fechamodal1:false,
			fecha2: moment().subtract('months').endOf('months').format("YYYY-MM-DD"),
			fechamodal2:false,


    }),

    computed: {
			...mapGetters('OT'    ,['getOT','Loading','Parametros']), // IMPORTANDO USO DE VUEX - (GETTERS)
      ...mapGetters('Login' ,['getdatosUsuario']),

      formTitle () {
        return this.editedIndex === -1 ? 'Nueva atención ' : 'Editar atención '
      },
      tamanioPantalla () {
        switch (this.$vuetify.breakpoint.name) {
          case 'xs': return 'auto' ;break;
          case 'sm': return this.$vuetify.breakpoint.height -340;break;
          case 'md': return this.$vuetify.breakpoint.height -340;break;
          case 'lg': return this.$vuetify.breakpoint.height -340;break;
          case 'xl': return this.$vuetify.breakpoint.height -340;break;
        }
      },
    },

    watch: {
			altaOT(val){
        val || this.close();
			},
      dialog (val) {
        val || this.close();
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
			fecha1(){
				this.initialize();
			},
			fecha2(){
				this.initialize();
			},
			depto(){
				this.initialize()
			},
			estatus(){
				this.initialize()
			},
    },

    created () {
			
			if(!this.Parametros){
				this.estatus  = { id: this.Parametros.estatus };
				this.fecha1   = this.Parametros.fecha1;
				this.fecha2   = this.Parametros.fecha2;
			}

      this.initialize();
    },

    methods: {
			...mapActions('OT'  ,['consultaOT']), // IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)

      initialize () {
        const parametros = {
					fecha1 : this.fecha1,
					fecha2 : this.fecha2,
					estatus: this.estatus.id,
			  }
        this.consultaOT(parametros);
      },

      editItem(item) {
        // this.editedIndex = this.atencion_integral.indexOf(item);
				this.modoVista = 2;
				this.parametros = item;
        // this.editedIndex = item.id;

        // this.editedItem = { 
        //   id    : item.id,
        //   nombre: item.nombre,
        //   cantidad: item.cantidad,
        //   ciclo : { id: item.id_ciclo_escolar },
        // };
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = item.id;
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true;
      },

      deleteItemConfirm () {
        this.$http.delete('elimina.atencion.integral/' + this.editedIndex).then( response =>{
          this.alerta = { activo: true, texto: response.body.message , color:'blue' };
          this.initialize();
          this.closeDelete();
        }).catch( error =>{ 
          console.log('error actualiza atencion integral', error)
        }).finally(() => {});

      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
					this.modoVista = 1;
					this.parametros = new Object();
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      validate_new_data(){
        if(!this.editedItem.nombre)      { this.alerta = { activo: true, texto:'No puedes omitir el campo Nombre'  , color:'error'}; return; };
        if(!this.editedItem.cantidad)    { this.alerta = { activo: true, texto:'No puedes omitir el campo Cantidad', color:'error'}; return; };
        if(!this.editedItem.ciclo)       { this.alerta = { activo: true, texto:'No puedes omitir el campo ciclo'   , color:'error'}; return; };
        this.save();
      },

      save () {
        const payload = new Object({
          nombre           : this.editedItem.nombre,
          cantidad         : this.editedItem.cantidad,
          id_ciclo_escolar : this.editedItem.ciclo.id,
        });
        
        if (this.editedIndex > -1) {
          this.$http.put('actualiza.atencion.integral/' + this.editedIndex, payload).then( response =>{
            this.initialize();
            this.alerta = { activo: true, texto: response.body.message, color:'blue' };
          }).catch( error =>{ 
            console.log('error actualiza atencion integral', error)
          }).finally(() => {});

        } else {
          this.$http.post('agrega.atencion.integral', payload).then( response =>{
            this.initialize();
            this.alerta = { activo: true, texto: response.body.message, color:'blue' };
          }).catch( error =>{ 
            console.log('error agregar atencion', error)
          }).finally(() => {});

          // this.atencion_integral.push(this.editedItem)
        }

        this.close()
      },

      cambiarEstatus(item){
        console.log('item', item)
        this.$http.put('actualiza.estatus.atencion.integral/' + item.id, item).then( response =>{
          // this.alerta = { activo: true, texto: response.body.message , color:'blue' };
          // this.initialize();
        }).catch( error =>{ 
          console.log('error actualiza atencion integral', error)
        }).finally(() => {})
      },

      limpiar_campos(){
        this.editedItem = { };
      },

			ImprimirExcel(){
				if(!this.getOT.length){
					this.alerta.snackbar = true; this.alerta.text="No hay información que exportar"; this.alerta.color="red darken-4";
					return
				}
				let tHeaders=[], tValores= [];
				let theaders = [{ text: "Id"					    , value:"id" },
												{ text: "Solicitante"     , value:"solicitante"},
												{ text: "Cliente"         , value:"nomcli"},
												{ text: "Orden de Compra" , value:"oc"},
												{ text: "Solicitud"       , value:"id_solicitud"},
												{ text: "Fecha"           , value:"fecha"},
												{ text: "Hora"            , value:"hora"},
											 ]

				for(let j =0;j< theaders.length; j++){
					tHeaders.push(theaders[j].text);
					tValores.push(theaders[j].value);
				}
				let tInformacion = this.getOT
				this.titulo = this.titulo +'_'+ this.depto.nombre +"_"+ this.fecha1 +"-"+ this.fecha2;
				this.manejarDescarga(this.titulo ,tHeaders,tValores,tInformacion)
			},
    },
  }
</script>