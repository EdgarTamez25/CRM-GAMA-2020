<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12">

				<v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" >
					<h3> <strong> {{ param2 === 1? 'Nuevo Precio':'Editar Precio' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal2',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class=""></v-divider>

				<v-row>
					<v-col cols="12" lg="4">
						<v-card outlined>
							<v-simple-table dense>
								<template>
									<thead>
										<tr>
											<th class="text-left">PRODUCCIÓN:</th>
											<th class="text-right">{{ produccion }}</th>
										</tr>
										<tr>
											<th class="text-left">C.ADMINISTRATIVOS</th>
											<th class="text-right"> {{ Costo_Administrativo }}</th>
										</tr>
										<tr>
											<th class="text-left"></th>
											<th class="text-right"></th>
										</tr>
										<tr>
											<th class="text-left">TOTAL</th>
											<th class="text-right">{{ TOTAL }}</th>
										</tr>
									</thead>
								</template>
							</v-simple-table>
						</v-card>
					</v-col>

					<v-col cols="12" lg="8">
						<v-card outlined>
							<v-autocomplete
								:items="getProductos"
								color="blue"
								item-text="nombre"
								label="Producto"
								placeholder="Seleccione un producto"
								hide-details
								dense
								filled
								v-model="Producto"
							></v-autocomplete>

							<v-simple-table dense v-if="Producto">
								<template >
									<thead>
										<tr>
											<th class="text-left">Descripcion:</th>
											<th class="text-justify"> {{ descripcion }}</th>
										</tr>
										<tr>
											<th class="text-left">Linea:</th>
											<th class="text-left">{{ linea }}</th>
										</tr>
										<tr>
											<th class="text-left">Tipo de Producto</th>
											<th class="text-left">{{ tipo_producto===1 ? 'Materia Prima':'Producto Final' }}</th>
										</tr>
									</thead>
								</template>
							</v-simple-table>
						</v-card>
					</v-col>

					<v-col cols="12" lg="3">
						<v-select
							:items="proveedores"
							label="Proveedores"
							placeholder="Proveedor"
							append-icon="show_chart"
							dense
							hide-details
							clearable
							outlined
							v-model="Proveedor"
						></v-select>
					</v-col>

					<v-col cols="12" lg="3">
						<v-select
							:items="monedas"
							label="Moneda"
							placeholder="Moneda"
							append-icon="show_chart"
							dense
							hide-details
							outlined
							v-model="Moneda"
						></v-select>
					</v-col>

					<v-col cols="12" lg="3">
						<v-select
							:items="proveedores"
							label="Tipo de Precio"
							placeholder="Tipo de Precio"
							append-icon="show_chart"
							dense
							hide-details
							outlined
							v-model="Proveedor"
						></v-select>
					</v-col>

					<v-col cols="3">
						<v-text-field
							label="Precio"
							placeholder="Precio del producto"
							hide-details
							dense
							outlined 
							v-model="precio"
							type="number"
						></v-text-field>
					</v-col>

					
					

					<v-col cols="9" v-if="tipo_producto === 2">
						<strong >MATERIAS PRIMAS</strong>
					</v-col>

					 <v-col cols="12" v-if="tipo_producto === 2">
            <v-autocomplete
              v-model="MP_Seleccionada"
              :items="Materia_Prima"
              outlined
							dense
              label="Materias Primas"
              item-text="nombre"
              item-value="nombre"
              multiple
              chips
							hide-details=""
            >
              <template v-slot:selection="data">
                <v-chip
                  :input-value="data.selected"
                  close
                  @click="data.select"
                  @click:close="remove(data.item)"
                >
									{{ data.item }}
                </v-chip>
              </template>
              
            </v-autocomplete>
          </v-col>

					<v-col cols="12" v-if="tipo_producto === 2 && MATERIAS_PRIMAS">
						<v-card class="mx-auto" >
				
							<v-alert  color="green" text dark  v-if="Materia_Prima.length === 0">
								No hay materias primas seleccionadas
							</v-alert>

							<v-simple-table fixed-header height="200px">
								<template v-slot:default>
									<thead>
										<tr>
											<th class="text-left">Nombre</th>
											<!-- <th class="text-left">Codigo</th> -->
											<th class="text-left">Descripción</th>
											<th class="text-left">Proveedor</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="mp_det in MP_Detalle" :key="mp_det.id">
											<td>{{ mp_det.nombre }}</td>
											<!-- <td>{{ mp_det.codigo }}</td> -->
											<td>{{ mp_det.descripcion }}</td>
											<td>{{ mp_det.nombre }}</td>
										</tr>
									</tbody>
								</template>
							</v-simple-table>

						</v-card>
					</v-col>
					<v-col cols="3" class="text-start">
						<v-text-field
							label="Porcentaje Administrativo"
							hide-details
							dense
							outlined 
							v-model="pjeAdmin"
							type="number"
						></v-text-field>
					</v-col>
				</v-row>

				<!-- //DIALOG PARA GUARDAR LA INFORMACION -->
				<v-card-actions>
					<v-spacer></v-spacer>
					 <v-btn small :disabled="dialog" persistent :loading="dialog" dark center class="white--text" color="success" @click="validaInfo" v-if="param2 === 1">
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
			'param2',
			'edit2',
	  ],
	  data () {
			return {
				selection: '',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',
				
				// AUTOCOMPLETE
				Materia_Prima:[], // Nombre=>autocomplete
				Materia_Primas:[], // Todas las materias Primas
				MP_Seleccionada:[], // Materias Selecionadas
				MP_Detalle:[], // Mostrar En tabla
				amenities: [1,4],

				// SELECTOR
				id_proveedor  : 0,
				proveedor     : [],
				proveedores   : [],
				Proveedor     : '',

				id_moneda  : 0,
				moneda     : [],
				monedas    : [],
				Moneda     : '',

				id_tipo_precio  : 0,
				tipo_precio     : [],
				tipo_precios    : [],
				Tipo_Precio     : '',

				// VARIABLES PRINCIPALES
				pjeAdmin: 19,
				Producto: '',
				id_producto: 0,
				descripcion: 'No hay una descripción del articulo',
				linea: '',
				tipo_producto: '',
				precio: 0,
				produccion: 0.00,
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
			}
		},

		created(){
			this.AsignarMP();
			this.validarModoVista() // VALIDO EL MODO DE LA VISTAT
			this.consultarProveedores()
			this.consultarMonedas()

		},
			
		computed:{
			// IMPORTANDO USO DE VUEX - PROVEEDORES (GETTERS)
			...mapGetters('Precios',['Loading','getPrecios']),
			...mapGetters('Productos',['getProductos']),

			MATERIAS_PRIMAS:function(){
				return this.MP_Detalle.length != 0 ? true: false;
			},

			Costo_Administrativo: function(){
				var costo_admin = parseFloat(this.precio) + (this.precio *  (this.pjeAdmin/100))
				costo_admin > 0 ? costo_admin= costo_admin: costo_admin = 0.00;
				return costo_admin.toFixed(2);
			},

			TOTAL: function(){
				var total = this.produccion + parseFloat(this.precio) + (this.precio *  (this.pjeAdmin/100))
				total > 0 ? total = total : total = 0.00;
				return total.toFixed(2);
			}
	
		},

		watch:{
			edit2: function(){
				this.AsignarMP();
				this.validarModoVista();
			},

			MP_Seleccionada: function(){
				this.MP_Detalle = [];

				for(var i = 0; i<this.MP_Seleccionada.length; i++){
					var MP = this.MP_Seleccionada[i]
					for(var j=0 ; j<this.Materia_Primas.length;j++){
						if(MP === this.Materia_Primas[j].nombre){
							this.MP_Detalle.push({id: this.Materia_Primas[j].id,
																		codigo: this.Materia_Primas[j].codigo ,
																		nombre:  this.Materia_Primas[j].nombre,
																		descripcion:  this.Materia_Primas[j].descripcion,
																		nomprov:  this.Materia_Primas[j].nomprov})
						}
					}
				}
			},

			Producto: function(){
				this.MP_Detalle = [];
				for(var i = 0 ; i< this.getProductos.length; i++){
					if(this.Producto === this.getProductos[i].nombre){
						this.id_producto = this.getProductos[i].id
						this.descripcion = this.getProductos[i].descripcion
						this.linea       = this.getProductos[i].nomlin
						this.tipo_producto = this.getProductos[i].tipo_producto
					}
				}
			}		
			
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PROVEEDORES(ACCIONES)
			...mapActions('Precios'  ,['consultaPrecios']),
			remove (item) {
        const index = this.MP_Seleccionada.indexOf(item)
        if (index >= 0) this.MP_Seleccionada.splice(index, 1)
			},
			
			AsignarMP(){
				for(var i = 0; i<this.getProductos.length; i++){
					if(this.getProductos[i].tipo_producto === 1){
						this.Materia_Primas.push(this.getProductos[i])
						this.Materia_Prima.push(this.getProductos[i].nombre	)
					}
				}
				console.log('ma', this.Materia_Primas)
			},

			validarModoVista(){
				if(this.param2 === 2){
					// ASIGNAR VALORES AL FORMULARIO
					this.nombre 			= this.edit2.nombre;
			
				}else{
				this.limpiarCampos()
				}
			},

			validaInfo(){
				if(!this.Producto)			{ this.snackbar = true; this.text="No puedes omitir el PRODUCTO" ; return }
				if(!this.Proveedor)	 		{ this.snackbar = true; this.text="No puedes omitir el PROVEEDOR" ; return }
				if(!this.Tipo_producto)	{ this.snackbar = true; this.text="No puedes omitir el TIPO DE PRODUCTO" ; return }
				if(!this.precio)				{ this.snackbar = true; this.text="No puedes omitir el PRECIO" ; return }
				if(!this.pjeAdmin)				{ this.snackbar = true; this.text="No puedes omitir el PORCENTAJE ADMINISTRATIVO" ; return }

				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { 
													id_producto	: this.id_producto,
													id_proveedor: this.id_proveedor,
													tipo_precio : this.id_tipo_precio,
													iva         : this.iva,
													id_moneda   : this.id_moneda,
													estatus     : 1
												}

												console.log('new precio', payload)
				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param2 === 1 ? this.CrearPrecio(payload): this.ActualizarPrecio(payload);
			},

			CrearPrecio(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ;
				setTimeout(() => (this.dialog = false), 2000)
				
				// MANDO A INSERTAR CLIENTE
				this.$http.post('precios', payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			ActualizarPrecio(payload){
				// ACTIVO DIALOGO -> GUARDANDO INFO
				this.dialog = true ; this.textDialog ="Actualizando Información"
				setTimeout(() => (this.dialog = false), 2000)

				this.$http.put('precios/'+ this.edit2.id, payload).then((response)=>{
					this.TerminarProceso(response.body);					
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal2',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaPrecios() //ACTUALIZAR CONSULTA DE PROVEEDORES
			},

			limpiarCampos(){
				this.nombre 			= '';
			
			}
		}
	}
</script>