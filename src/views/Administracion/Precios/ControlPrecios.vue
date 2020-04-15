<template>
	<v-container>
		<v-row justify="center">
			<v-col cols="12">

				<v-snackbar top v-model="snackbar" :timeout="2000"  :color="color"> {{text}}
					<v-btn color="white" text @click="snackbar = false" > Cerrar </v-btn>
				</v-snackbar>

				<v-card-actions class="pa-0" > <!-- NOMBRE DE LA VISTA -->
					<h3> <strong> {{ param2 === 1? 'Nuevo Precio':'Editar Precio' }} </strong></h3> 
					<v-spacer></v-spacer>
					<v-btn color="error" small @click="$emit('modal2',false)" text><v-icon>clear</v-icon></v-btn>
				</v-card-actions>

				<v-divider class=""></v-divider>

				<v-row>
					<v-col cols="12" sm="6" lg="4">  <!-- RESUMEN DE PRODUCCION -->
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

					<v-col cols="12" sm="6" lg="8"> <!-- PRODUCTO-->
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
								disabled
							></v-autocomplete>

							<v-simple-table dense v-if="Producto">
								<template >
									<thead>
										<tr>
											<th class="text-left">Descripción:</th>
											<th class="text-justify"> {{ descripcion }}</th>
										</tr>
										<tr>
											<th class="text-left">Línea:</th>
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

					<v-col cols="12" sm="6" lg="4"> <!-- PROVEEDOR -->
						<v-select
							:items="proveedores"
							label="Proveedores"
							placeholder="Proveedor"
							append-icon="how_to_reg"
							dense
							hide-details
							clearable
							outlined
							v-model="Proveedor"
							:disabled="contenidoProvedor"
						></v-select>
					</v-col>

					<v-col cols="12" sm="6" lg="4"> <!-- TIPO DE PRECIO -->
						<v-select
							:items="tipo_precios"
							label="Tipo de Precio"
							placeholder="Tipo de Precio"
							append-icon="attach_money"
							dense
							hide-details
							outlined
							v-model="Tipo_Precio"
						></v-select>
					</v-col>

					<v-col cols="6" lg="2"> <!-- MONEDA  -->
						<v-select
							:items="monedas"
							label="Moneda"
							placeholder="Moneda"
							append-icon="monetization_on"
							dense
							hide-details
							outlined
							v-model="Moneda"
							:disabled="contenidoMoneda"
						></v-select>
					</v-col>

					<v-col cols="6"  lg="2"> <!-- PRECIO DEL PRODUCTO -->
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

					<v-col cols="9" v-if="tipo_producto === 2"> <strong >MATERIAS PRIMAS</strong> </v-col> <!-- DIVISOR PARA MATERIA PRIMA -->

					<v-col cols="12" v-if="tipo_producto === 2"> <!-- SELECTOR MATERIAS PRIMAS -->
            <v-autocomplete
              v-model="MP_Seleccionada"
              :items="materias_primas"
              outlined
							dense
              label="Materias Primas"
              item-text="nombre"
              item-value="nombre"
              multiple
              chips
							hide-details=""
							@click="cambiarProceso"
            >
              <template v-slot:selection="data">
                <v-chip
                  :input-value="data.selected"
                  close
                  @click="data.select"
                  @click:close="remover(data.item)"
                >
									{{ data.item }}
                </v-chip>
              </template>
              
            </v-autocomplete>
          </v-col>

					<v-col cols="12" v-if="tipo_producto === 2 && MATERIAS_PRIMAS">  <!-- MATERIAS PRIMAS A SELECCIONAR -->
						<v-card class="mx-auto" flat >

							<v-simple-table fixed-header dense height="200px" v-if ="MP_Detalle">
								<template v-slot:default>
									<thead>
										<tr>
											<th class="text-left">Nombre</th>
											<th class="text-left">Descripción</th>
											<th class="text-left">Proveedor</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="mp_det in MP_Detalle" :key="mp_det.id">
											<td>{{ mp_det.nombre }}</td>
											<td>{{ mp_det.descripcion }}</td>
											<td>{{ mp_det.nomprov }}</td>
										</tr>
									</tbody>
								</template>
							</v-simple-table>

						</v-card>
					</v-col>

					<v-col cols="12" sm="4" class="text-start"> <!-- PORCENAJE ADMINISTRATIVO  -->
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
				
				<v-card-actions> <!-- //DIALOG PARA GUARDAR LA INFORMACION -->
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
	import  SelectMixin from '@/mixins/SelectMixin.js'; // IMPORTAR USO DE SELECTORES
	import {mapGetters, mapActions} from 'vuex'         // IMPORTAR USO DE VUEX 
	export default {
		mixins:[SelectMixin],
	  components: {
		},
		props:[          // COMUNICACION ENTRE CATALOGO Y CONTROLADOR
			'param2',      // CONTIENE EL MODO DE LA VISTA 1.NUEVO - 2.EDITAR & ELIMINAR
			'edit2',       // CONTIENE LA CONSULTA QUE ARRASTRAMOS DESDE EL CATALOGO
			'id_art',      // ID DEL ARTICULO EN SEGUIMIENTO
			'nomproducto', // NOMBRE DEL PRODUCTO EN SEGUIMIENTO 
				],

		// props:{
		// 	edit2: Number,
		// 	param2: Array,
		// 	id_art: Number,
		// 	nomproducto: String
		// },
		
	  data () {
			return {
				selection: '',
				dialog : false,
				textDialog : "Guardando Información",
				Correcto   : false,
				textCorrecto: '',
				
				// AUTOCOMPLETE
				MP_Seleccionada:[], // Materias Selecionadas
				MP_Detalle:[], // Mostrar En tabla
				amenities: [1,4],
				DetalleActual:[], // GUARDA EL DETALLE QUE CONSULTO. 

				// SELECTOR
				id_proveedor  : 0,  // PROVEEDORES 
				proveedor     : [],
				proveedores   : [],
				Proveedor     : '',

				id_moneda  : 0,  //  MONEDAS
				moneda     : [],
				monedas    : [],
				Moneda     : '',
				contenidoMoneda: true,
				tipo_de_cambio: 0,

				id_tipo_precio  : 0, // TIPO DE PRECIO
				tipo_precio     : [],
				tipo_precios    : [],
				Tipo_Precio     : '' ,

				id_mp  					: 0,  // MATERIA PRIMA
				materia_prima   : [],
				materias_primas : [],
				Materia_Prima   : '',

				// VARIABLES PRINCIPALES
				pjeAdmin: 19,
				Producto: '',
				id_producto: 0,
				descripcion: 'No hay una descripción del articulo',
				linea: '',
				tipo_producto: '', // GUARDA EL TIPO DE PRODUCTO QUE SE SELECCIONE
				precio: 0,
				produccion: 0.00,
				contenidoProvedor: false,
				costo_admin : 0.00,
				total: 0.00,
				

				llenarTabla: false,
			 // ALERTAS
				snackbar: false,
				text		: '',
				color		: 'error',
			}
		},

		created(){
			this.validarModoVista() 		// VALIDO EL MODO DE LA VISTA
			this.consultarProveedores() //LLENAR SELECTOR DE PROVEEDORES
			this.consultarMonedas()			//LLENAR SELECTOR DE MONEDAS
			this.consultarTipo_Precios()//LLENAR SELECTOR DE TIPO DE PRECIOS
			this.consultar_MateriaPrima()
			
		},
			
		computed:{
			// IMPORTANDO USO DE VUEX 
			...mapGetters('Precios',['getPreciosxId','getPrecios']),
			...mapGetters('Productos',['getProductos']),
			...mapGetters('Monedas',['predeterminada','moneda_USD']),


			MATERIAS_PRIMAS:function(){ // EVALUA SI EXISTE ALGUN DETALLE DEL PRODUCTO
				return this.MP_Detalle.length != 0 ? true: false;
			},

			Costo_Administrativo: function(){  // CALCULO DEL COSTO ADMINISTRATIVO
				this.costo_admin = 0.00;

				if(this.predeterminada.codigo === this.Moneda){  // COMPARO SI EL PRECIO ESTA EN FUNCION DE LA MONEDA PREDETERMINADA
					this.costo_admin = parseFloat(this.precio) + (this.precio *  (this.pjeAdmin/100)) // SI LO ESTA SOLAMENTE SUMO

				}else{ // SI NO ESTA EN FUNCION DE LA MONEDA PREDETERMINADA 
					var precio = this.convertirMoneda2(this.precio) // MANDO A CONVERTIR EL PRECIO
					this.costo_admin = parseFloat(precio) + (precio *  (this.pjeAdmin/100)) // SUMO EL PRECIO YA CONVERTIDO
				}

				this.costo_admin > 0 ? this.costo_admin= this.costo_admin: this.costo_admin = 0.00; // EVALUO QUE EL COSTO NO SEA 0 
				return this.costo_admin.toFixed(2); // RETORNO EL VALOR ADMINISTRATIVO.

			},

			TOTAL: function(){ // CALCULO DEL TOTAL DEL RESUMEN.

				if(this.predeterminada.codigo === this.Moneda){
					this.total = this.produccion + parseFloat(this.precio) + (this.precio *  (this.pjeAdmin/100))
				}else{
					var precio = this.convertirMoneda2(this.precio)	
					this.total = this.produccion + parseFloat(precio) + (precio *  (this.pjeAdmin/100))
				}
				
				this.total > 0 ? this.total = this.total : this.total = 0.00;
				return this.total.toFixed(2);
			},
		},

		watch:{
			// ESTA FUNCION SOLO SE EJECUTA CUANDO MANDAN A LLAMAR LA MODAL PRECIOS
			edit2: function(){
				this.consultar_MateriaPrima() //LLENO EL ARRAY DE MATERIAS PRIMAS ANTES DE ASIGNAR autocomplete.
				this.validarModoVista(); // Valido en que modo se encuentra la vista // Nuevo - Editar
				this.llenarTabla = false ;
			},

			MP_Seleccionada: function(){
				if(!this.llenarTabla){  
					this.MP_Detalle = []; // Cada vez que seleccionen una materia prima limpio el array
					this.produccion = 0.00;
					for(var j=0 ; j<this.materia_prima.length;j++){ // Genero ciclo para buscar la info de la materia prima
						for(var i = 0; i<this.MP_Seleccionada.length; i++){ // Genero un ciclo de las materias primas seleccionadas para buscar su informacion
							if(this.MP_Seleccionada[i] === this.materia_prima[j].nombre){ //Comparo la MP seleccionada con los del array hasta encontrarla
								this.MP_Detalle.push({id:     		this.materia_prima[j].id, //Inserto en MP_DETALLE el detalle de la materia prima.
																codigo: 		this.materia_prima[j].codigo ,
																nombre:  		this.materia_prima[j].nombre,
																descripcion:this.materia_prima[j].descripcion,
																nomprov:  	this.materia_prima[j].nomprov,
																moneda :    this.materia_prima[j].moneda
																})
							}

						}
					}
					this.CalculaCostoProduccion() // Calcular el costo de producción
				}

			},

			Producto: function(){
				// Boorro todoo lo que contenga el arreglo de Materia Prima -> detalle
				this.MP_Detalle = [];
				// Genero un ciclo para buscar el resumen del articulo seleccionado
				for(var i = 0 ; i< this.getProductos.length; i++){
					// Si encuentro el producto seleccionado en el array obtengo su informacion
					if(this.Producto === this.getProductos[i].nombre){
						this.id_producto = this.getProductos[i].id
						this.descripcion = this.getProductos[i].descripcion
						this.linea       = this.getProductos[i].nomlin
						this.tipo_producto = this.getProductos[i].tipo_producto
						// Si el tipo de producto es "Producto final" entonces bloque proveedor
						// Ya que el producto final pertenece| a GAMA ETIQUETAS id -> 1 
						if(this.tipo_producto === 2){ 
							this.Proveedor = "GAMA ETIQUETAS";
							this.id_proveedor = 1;
							this.contenidoProvedor = true; //BLOQUEAR PROVEEDOR
							this.contenidoMoneda   = true; // BLOQUEAR MONEDA
						}else{
							this.Proveedor = "";
							this.id_proveedor = 0;
							this.contenidoProvedor = false;
							this.contenidoMoneda   = false; 

						}
					}
				}
			},

			
			
		},

		methods:{
			// IMPORTANDO USO DE VUEX - PROVEEDORES(ACCIONES)
			...mapActions('Precios'  ,['consultaPrecios','consultaPreciosxId']),

			validarModoVista(){

				this.limpiarCampos();  // MANDAR A LIMPIAR CAMPOS

				if(this.param2 === 2){ // ASIGNAR VALORES AL FORMULARIO
					this.id_producto 		= this.edit2.id_producto;
					this.Producto 	 		= this.edit2.nomprod;
					this.id_proveedor		= this.edit2.id_proveedor;
					this.Proveedor   		= this.edit2.nomprov;
					this.id_moneda   		= this.edit2.id_moneda;
					this.Moneda      		= this.edit2.cod_moneda;
					this.id_tipo_precio = this.edit2.tipo_precio;
					this.Tipo_Precio 		= this.edit2.nomtipo_precio;
					this.precio         = this.edit2.precio;
					this.produccion     = this.edit2.produccion;
					this.llenarTabla    = true;
					this.consultaDetalleProducto()// CONSULTO MP POR PRODUCTO EN VUEX

				}else{
					this.id_producto = this.id_art;   //PRODUCTO QUE TENGO EN SEGUIMIENTO DESDE PRODUCTOS
					this.Producto    = this.nomproducto;
					this.id_moneda   = this.predeterminada.id;
					this.Moneda      = this.predeterminada.codigo;
				}
				
			},

			consultaDetalleProducto(){
				this.$http.get('detalle_productos/'+ this.edit2.id ).then((response)=>{
					for( var i in response.body){ this.MP_Seleccionada.push(response.body[i].nombre) }
					for( var j in response.body){ this.MP_Detalle.push(response.body[j])}
					for( var k in response.body){ this.DetalleActual.push(response.body[k].id_key )}
				})
			},

			validaInfo(){
				if(!this.Producto)			{ this.snackbar = true; this.text="No puedes omitir el PRODUCTO" ; return }
				if(!this.Proveedor)	 		{ this.snackbar = true; this.text="No puedes omitir el PROVEEDOR" ; return }
				if(!this.Moneda)	 		  { this.snackbar = true; this.text="No puedes omitir la MONEDA" ; return }
				if(!this.Tipo_Precio)	  { this.snackbar = true; this.text="No puedes omitir el TIPO DE PRECIO" ; return }
				if(!this.precio)				{ this.snackbar = true; this.text="No puedes omitir el PRECIO" ; return }
				if(this.precio === 0)		{ this.snackbar = true; this.text="No puedes omitir el PRECIO" ; return }
				if(!this.pjeAdmin)		  { this.snackbar = true; this.text="No puedes omitir el PORCENTAJE ADMINISTRATIVO" ; return }

				this.PrepararPeticion()
			},

			PrepararPeticion(){
				// FORMAR ARRAY A MANDAR
				const payload = { 
													detalleActual: this.DetalleActual,
													id_producto	: this.id_producto,
													id_proveedor: this.id_proveedor,
													tipo_precio : this.id_tipo_precio,
													id_moneda   : this.id_moneda,
													estatus     : 1,
													tipo_producto: this.tipo_producto,
													detalle     : this.MP_Detalle,
													precio      : parseFloat(this.precio).toFixed(2),
													produccion  : parseFloat(this.produccion).toFixed(2),
													pje_admin   : parseInt(this.pjeAdmin),
													costo_admin : parseFloat(this.costo_admin).toFixed(2),
													total       : parseFloat(this.total).toFixed(2),
													predeterminado : 0
												}

				// VALIDO QUE ACCION VOY A EJECUTAR SEGUN EL MODO DE LA VISTA
				this.param2 === 1 ? this.CrearPrecio(payload): this.ActualizarPrecio(payload);
			},

			CrearPrecio(payload){ // ESTA FUNCION MANDAR A INSERTAR EL PRECIO Y LOS DETALLES
				this.dialog = true ;// ACTIVO DIALOGO -> GUARDANDO INFO
				setTimeout(() => (this.dialog = false), 2000)
				
				this.$http.post('precios', payload).then((response)=>{ // MANDO A INSERTAR CLIENTE
					this.TerminarProceso(response.body);// MANDO A TERMINAR EL PROCESO			
				})
			},

			ActualizarPrecio(payload){ // ESTA FUNCION MANDA A ACTUALIZAR EL PRECIO Y SUS DETALLES
				this.dialog = true ; this.textDialog ="Actualizando Información" // ACTIVO DIALOGO -> GUARDANDO INFO
				setTimeout(() => (this.dialog = false), 2000)
				this.$http.put('precios/'+ this.edit2.id, payload).then((response)=>{
					this.TerminarProceso(response.body);// MANDO A TERMINAR EL PROCESO							
				})
			},

			TerminarProceso(mensaje){
				var me = this ;
				this.dialog = false; this.Correcto = true ; this.textCorrecto = mensaje;
				setTimeout(function(){ me.$emit('modal2',false)}, 2000);
				this.limpiarCampos();  //LIMPIAR FORMULARIO
				this.consultaPreciosxId(this.id_producto) //ACTUALIZAR CONSULTA DE PROVEEDORES
			},

			limpiarCampos(){
				// this.Producto 		= '';
				// this.Proveedor 		= '';
				this.Tipo_Precio 	= '';
				this.Moneda 			= '';
				this.precio 			= '';
				this.MP_Detalle   = [];
				this.MP_Seleccionada = [];
			
			},

			remover (item) { // FUNCIONA PARA REMOVER CHIP DEL SELECTOR DE MATERIAS PRIMAS
        const index = this.MP_Seleccionada.indexOf(item)
        if (index >= 0) this.MP_Seleccionada.splice(index, 1)
			},

			cambiarProceso(){ this.llenarTabla = false; }, // HABILITA EL AUTOCOMPLETED BLOQUEADO POR EL WATCH
			
			CalculaCostoProduccion(){  // CALCULAR COSTO DE PRODUCCION - SUMA TODOS LOS COSTOS DE LAS MATERIAS PRIMAS.
				for(var x =0 ; x < this.MP_Detalle.length; x++){
					for(var value of this.materia_prima){   
						if(this.MP_Detalle[x].id === value.id ){  						 // COMPARO EL ID DE LAS MATERIAS PRIMAS 

							if(this.predeterminada.codigo === value.moneda ){    // VALIDO SI EL CODIGO DE LA MP ES IGUAL AL PREDETERMINADO
									this.produccion = this.produccion + value.precio // SI ES IGUAL SOLAMENTE SUMO LAS CANTIDADES
							}else{																							 // SI NO SON IGUALES 
								var precio = this.convertirMoneda(value.precio)           // MANDO A CONVERTIR LA MONEDA.   
								this.produccion = parseFloat(this.produccion) + parseFloat(precio) // UNA VEZ CONVERTIDO EL PRECIO LO SUMO A PRODUCCION. 
							}

						}
					}
				}
			},

			convertirMoneda(value){
				var conversion = 0;
				if(this.predeterminada.codigo === 'USD'){ // CONVRTIR DE PESOS A DOLARES 
					conversion = value / this.predeterminada.tipo_cambio
				}
				if(this.predeterminada.codigo === 'MX'){// CONVERTIR DE DOLARES A PESOS 
					conversion = value * this.moneda_USD.tipo_cambio
				}
				return conversion.toFixed(2);  // RETORNO LA CONVERSION
			},

			convertirMoneda2(value){
				console.log('recibo precio', value)

				var conversion = 0;
			 if(this.Moneda === 'USD'){
				 conversion = value / this.predeterminada.tipo_cambio
				console.log('conversion en usd', conversion)

			 }
			 if(this.Moneda === 'MX'){
				 conversion = value * this.moneda_USD.tipo_cambio
				 console.log('conversion en mx', conversion)
			 }
			 	return conversion.toFixed(2);  // RETORNO LA CONVERSION
			}
		}
	}
</script>