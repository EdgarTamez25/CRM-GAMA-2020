<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12">

				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Cliente':'Editar Cliente' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="person"
							label="Nombre"
							placeholder="Nombre del cliente"
							hide-details
							dense
							clearable
							v-model="nombre"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="domain"
							label="Razon Social"
							placeholder="Razon Social"
							hide-details
							dense
							clearable
							v-model="razon_social"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="zonas"
							label="Zona"
							placeholder="Zona del cliente"
							append-icon="pin_drop"
							dense
							hide-details
							v-model="Zonas"
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:disabled="!Zonas"
							:items="subzonas"
							label="Sub Zona"
							placeholder="Sub zona del cliente"
							append-icon="person_pin_circle"
							dense
							hide-details
							v-model="SubZona"
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="['Nacional','Internacional']"
							label="Tipo de Cliente"
							placeholder="Tipo de cliente"
							append-icon="gps_fixed"
							dense
							hide-details
							v-model="tipo_cliente"
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="['A','AA','AAA']"
							label="Nivel del cliente"
							placeholder="Tipo de cliente"
							append-icon="how_to_reg"
							dense
							hide-details
							v-model="nivel"
						></v-select>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="email"
							label="RFC"
							placeholder="RFC perteneciente al cliente"
							hide-details
							dense
							clearable
							v-model="rfc"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="email"
							label="CURP"
							placeholder="Numero correspondiente al CURP"
							hide-details
							dense
							clearable
							v-model="curp"
						></v-text-field>
					</v-col>

					<v-col cols="12" lg="6">
						<v-select
							:items="carteras"
							label="Carteras"
							placeholder="Cartera al que pertenece el cliente"
							append-icon="folder_shared"
							dense
							hide-details
							clearable
							v-model="Cartera"
						></v-select>
					</v-col>
	
				</v-row>
				
				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="param === 1">
             Confirmar  
          </v-btn>
					<v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-else>
             Actualizar  
          </v-btn>

          <v-dialog v-model="dialog" hide-overlay persistent width="300">
            <v-card color="blue darken-4" dark >
              <v-card-text> <th style="font-size:17px;" align="center">{{ textDialog }}</th>
                <br>
                <v-progress-linear indeterminate color="white" class="mb-0" persistent></v-progress-linear>
              </v-card-text>
            </v-card>
          </v-dialog>

					<v-dialog v-model="Correcto" hide-overlay persistent width="350">
            <v-card color="success"  dark class="pa-3">
							<h3><strong>{{ textCorrecto }} </strong></h3>
            </v-card>
						
          </v-dialog>
				</v-card-actions>

				<v-layout row wrap>
        <!-- BOTON PARA CONFIRMAR -->
        <v-flex xs6 text-right class="pa-3 mt-0">
         
        </v-flex>
      </v-layout>

			</v-col>
		</v-row>
	</v-container>
	
</template>

<script>
	import  SelectMixin from '@/mixins/SelectMixin.js';
	import {mapGetters, mapActions} from 'vuex'
	export default {
		mixins:[SelectMixin],

	  components: {
		},
		props:[
			'param',
			'edit',
	  ],
	  data () {
			return {
				titleModal: 'Clientes',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				// VARIABLES PRINCIPALES
				nombre			: '',
				tipo_cliente: '',
				rfc					:	'',
				curp				: '',
				cartera     : '',
				nivel       : '',
				razon_social: '',
			
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
			}
		},

		created(){
			this.consultarZonas() //MANDO A CONSULTAR ZONAS A MIXINS
			this.consultarCarteras() //MANDO A CONSULTAR CARTERAS A MIXINS
			this.validarModoVista() // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - CLIENTES (GETTERS)
			...mapGetters('Clientes'  ,['getClientes']),

		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - CLIENTES(ACCIONES)
			...mapActions('Clientes'  ,['consultaClientes']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 			= this.edit.nombre;
					this.razon_social = this.edit.razon_social;
					this.Zonas 				= this.edit.nomzona; 
					this.tipo_cliente = this.edit.tipo_cliente === 1? 'Nacional':'Internacional'
					this.rfc        	= this.edit.rfc;
					this.curp         = this.edit.curp;
					this.id_cartera   = this.edit.id_cartera;
					this.Cartera      = this.edit.nomcartera;
					this.consultarSubZonas(this.edit.idzona)
					this.SubZona 			= this.edit.nomsubzona;
					this.id_subzona   = this.id_subzona; 
					
					if(this.edit.nivel === 1){
						this.nivel  = 'A' 
					}else if (this.edit.nivel===2){
						this.nivel = 'AA'
					}else{
						this.nivel = 'AAA'
					}
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre)	  	{ this.snackbar = true; this.text="No puedes omitir el NOMBRE DEL CLIENTE"   ; return }
				if(!this.SubZona)	  	{ this.snackbar = true; this.text="No puedes omitir la SUB ZONA" ; return }
				if(!this.tipo_cliente){ this.snackbar = true; this.text="No puedes omitir el TIPO DE CLIENTE"; return }
				if(!this.nivel)				{ this.snackbar = true; this.text="No puedes omitir el NIVEL"; return }
				if(!this.razon_social){ this.snackbar = true; this.text="No puedes omitir la RAZON SOCIAL"; return }
				// if(!this.rfc)		  { this.snackbar = true; this.text="No puedes omitir el rfc"	 	; return }
				// if(!this.curp)		  { this.snackbar = true; this.text="No puedes omitir el CURP"	 	; return }
				if(!this.cartera)	  { this.snackbar = true; this.text="No puedes omitir la CARTERA"	; return }
				
				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { nombre			: this.nombre,
													id_subzona	: this.id_subzona,
													tipo_cliente: this.tipo_cliente === 'Nacional'? 1:2,
													rfc					: this.rfc,
													curp				: this.curp,
													id_cartera	: this.id_cartera ,
													fuente      : 1 ,
													nivel       : this.nivel.length,
													razon_social: this.razon_social,
													estatus     : 1
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearCliente(payload): this.ActualizarCliente(payload);
			},

			CrearCliente(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('cliente', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarCliente(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('cliente/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;

				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				// this.snackbar = true ; this.color="success" ;this.text= mensaje;
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaClientes() //ACTUALIZAR CONSULTA DE CLIENTES
				// this.$emit('modal',false) //CERRAR MODAL
			},

			limpiarCampos(){
				this.nombre = '';
				this.SubZona = '',
				this.Zonas = '',
				this.tipo_cliente = '';
				this.nivel = '';
				this.razon_social = '';
				this.rfc = '';
				this.curp='';
				this.Cartera = '';
			}
		}
	}
</script>