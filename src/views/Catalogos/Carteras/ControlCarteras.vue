<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12">

				<v-snackbar top v-model="snackbar" :timeout="1000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param === 1? 'Nuevo Cartera':'Editar Cartera' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class="ma-2"></v-divider>
				<v-row>
					<v-col cols="12" lg="6">
						<v-text-field
							append-icon="folder_shared"
							label="Cartera"
							placeholder="Nombre de la cartera"
							hide-details
							dense
							clearable
							v-model="nombre"
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
				nombre	: '',
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',

			}
		},

		created(){
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - ZONAS (GETTERS)
			...mapGetters('Carteras' ,['getCarteras']), 

		},

		watch:{
			edit: function(){
				console.log('edit', this.edit)
				this.validarModoVista();
			}
		},

		methods:{
			// IMPORTANDO USO DE VUEX - ZONAS(ACCIONES)
			...mapActions('Carteras'  ,['consultaCarteras']),

			validarModoVista(){
				if(this.param === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 		= this.edit.nombre;
			
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.nombre) { this.snackbar = true; this.text="No puedes omitir el NOMBRE DE LA ZONA"   ; return }
				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { 
													nombre			: this.nombre,
													estatus     : 1
												}
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param === 1 ? this.CrearCartera(payload): this.ActualizarCartera(payload);
			},

			CrearCartera(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR ZONA
				this.$http.post('carteras', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarCartera(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('carteras/'+ this.edit.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaCarteras() //ACTUALIZAR CONSULTA
			},

			limpiarCampos(){
				this.nombre = '';
			}
		}
	}
</script>