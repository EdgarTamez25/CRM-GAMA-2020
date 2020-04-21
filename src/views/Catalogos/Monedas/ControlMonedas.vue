<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12">

				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Moneda':'Editar Moneda' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" sm="6" >
						<v-text-field
							append-icon="settings_ethernet"
							label="Codigo"
							placeholder="Codigo de la moneda"
							hide-details
							dense
							clearable
							v-model="codigo"
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="monetization_on"
							label="Moneda"
							placeholder="Nombre de la Moneda"
							hide-details
							dense
							clearable
							v-model="nombre"
						></v-text-field>
					</v-col>

					<v-col cols="12" sm="6">
						<v-text-field
							append-icon="attach_money"
							label="Tipo de cambio"
							placeholder="Tipo de cambio"
							hide-details
							dense
							clearable
							type="number"
							v-model.number="tipo_cambio"
						></v-text-field>
					</v-col>
				</v-row>
				
				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="param === 1">
             GUARDAR  
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
	import {mapGetters, mapActions} from 'vuex'
	export default {

	  components: {
		},
		props:[
			'param',
			'edit',
	  ],
	  data () {
			return {
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',

				// VARIABLES PRINCIPALES
				codigo  : '',
				nombre	: '',
				tipo_cambio: 0,
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',

			}
		},

		created(){
			this.validarModoVista() // VALIDO EL MODO DE LA VISTA
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - ZONAS (GETTERS)
			...mapGetters('Monedas' ,['getMonedas']), 

		},

		watch:{
			edit: function(){
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - ZONAS(ACCIONES)
			...mapActions('Monedas'  ,['consultaMonedas']),

			validarModoVista(){

				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 		= this.edit.nombre;
					this.codigo     = this.edit.codigo;
					this.tipo_cambio = this.edit.tipo_cambio;
			
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.codigo) { this.snackbar = true; this.text="No puedes omitir el CODIGO"   ; return }
				if(!this.nombre) { this.snackbar = true; this.text="No puedes omitir el NOMBRE DE LA MONEDA"   ; return }
				if(!this.tipo_cambio) { this.snackbar = true; this.text="No puedes omitir el TIPO DE CAMBIO"   ; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { 
													codigo			: this.codigo,
													nombre			: this.nombre,
													tipo_cambio	: this.tipo_cambio,
													estatus     : 1,
													predeterminado: 0
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearMoneda(payload): this.ActualizarMoneda(payload);
			},

			CrearMoneda(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 	)
				
				// MANDO A INSERTAR ZONA
				this.$http.post('monedas', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarMoneda(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('monedas/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaMonedas() //ACTUALIZAR CONSULTA
			},

			limpiarCampos(){
				this.nombre = '';
				this.codigo = '';
				this.tipo_cambio = 0;

			}
		}
	}
</script>