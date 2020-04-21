
export default {

	data () {
		return {
			// SELECTORES
			id_subzona  :  0,
			subzona			: [],
			subzonas    : [],
			SubZona     : '',	
		}
	},

	methods: {

		consultar_Clientes(){  // AUTOCOMPLETE -> CLIENTES
			this.$http.get('clientes').then((response)=>{
				this.clientes = response.body //LLENNO ARRAY
			})
		},

		consultar_Categorias(){ // CATEGORIAS
			this.$http.get('categorias').then((response)=>{
				this.categorias = response.body  // LLENO ARREGLO CON RESPUESTA COMPLETA
			})
		},

		consultar_Vendedores(){  // AUTOCOMPLETE -> VENDEDORES
			this.$http.get('vendedores').then((response)=>{
				this.vendedores = response.body //LLENNO ARRAY
			})
		},

		consultar_MateriaPrima(){ // MATERIA PRIMA
			this.$http.get('mp-productos').then((response)=>{
				this.materia_prima = response.body
				for(const i in response.body){
					this.materias_primas.push(response.body[i].nombre)
				}
			})
		},
			
		consultarTipo_Precios(){ //TIPO DE PRECIOS
			this.$http.get('tipos-precios').then((response)=>{
				this.tipo_precio = response.body
				for(const i in response.body){
					this.tipo_precios.push(response.body[i].nombre)
				}
			})
		},

		consultarMonedas(){ //MONEDAS
			this.$http.get('monedas').then((response)=>{
				this.moneda = response.body
				for(const i in response.body){
					this.monedas.push(response.body[i].codigo)
				}
			})
		},

		consultarUnidades(){ //UNIDADES
			this.$http.get('unidades').then((response)=>{
				this.unidad = response.body
				for(const i in response.body){
					this.unidades.push(response.body[i].nombre)
				}
			})
		},

		consultarProveedores(){ // PROVEEDORES
			this.$http.get('proveedores').then((response)=>{
				this.proveedor = response.body
				for(const i in response.body){
					this.proveedores.push(response.body[i].nombre)
				}
			})
		},

		consultarLineas(){ //LINEAS
			this.$http.get('lineas').then((response)=>{
				this.linea = response.body
				for(const i in response.body){
					this.lineas.push(response.body[i].nombre)
				}
			})
		},

		consultarSucursales(){ //SUCURSALES
			this.$http.get('sucursales').then((response)=>{
				this.sucursal = response.body
				for(const i in response.body){
					this.sucursales.push(response.body[i].nombre)
				}
			})
		},

		consultarCiudades(){ // CIUDADES
			this.$http.get('ciudades').then((response)=>{
				this.ciudad = response.body
				for(const i in response.body){
					this.ciudades.push(response.body[i].nombre)
				}
			})
		},

		consultarZonas(){ // ZONAS
			this.$http.get('zonas').then((response)=>{
				this.zona = response.body
				for(const i in response.body){
					this.zonas.push(response.body[i].nombre)
				}
			})
		},

		consultarSubZonas(id){ // SUBZONAS
			this.$http.get('subzonas/'+ id).then((response)=>{
				this.subzona = response.body
				for(const i in response.body){
					this.subzonas.push(response.body[i].nombre)
				}
			})
		},

		consultarCarteras(){ // CARTERAS
			this.$http.get('carteras').then((response)=>{
				this.cartera = response.body
				for(const i in response.body){
					this.carteras.push(response.body[i].nombre)
				}
			})
		}
	},

	watch:{
		cliente:function(){
			for(const i in this.clientes){
				if(this.clientes[i].nombre === this.cliente ){
					this.id_cliente = this.clientes[i].id
				}
			}
		},

		Categoria:function(){
			for(const i in this.categorias){
				if(this.categorias[i].nombre === this.Categoria ){
					this.id_categoria = this.categorias[i].id
				}
			}
		},

		vendedor:function(){
			for(const i in this.vendedores){
				if(this.vendedores[i].nombre === this.vendedor ){
					this.id_vendedor = this.vendedores[i].id
				}
			}
		},

		Materia_Prima:function(){
			for(const i in this.materia_prima){
				if(this.materia_prima[i].nombre === this.Materia_Prima){
					this.id_mp = this.materia_prima[i].id
				}
			}
		},

		Tipo_Precio:function(){
			for(const i in this.tipo_precio){
				if(this.tipo_precio[i].nombre === this.Tipo_Precio){
					this.id_tipo_precio = this.tipo_precio[i].id
				}
			}
		},

		Unidad:function(){
			for(const i in this.unidad){
				if(this.unidad[i].nombre === this.Unidad){
					this.id_unidad = this.unidad[i].id
				}
			}
		},

		Moneda:function(){
			for(const i in this.moneda){
				if(this.moneda[i].codigo === this.Moneda){
					this.id_moneda = this.moneda[i].id
					this.tipo_de_cambio = this.moneda[i].tipo_cambio
				}
			}
		},

		Proveedor:function(){
			for(const i in this.proveedor){
				if(this.proveedor[i].nombre === this.Proveedor){
					this.id_proveedor = this.proveedor[i].id
				}
			}
		},

		Linea:function(){
			for(const i in this.linea){
				if(this.linea[i].nombre === this.Linea){
					this.id_linea = this.linea[i].id
				}
			}
		},

		Sucursal:function(){
			for(const i in this.sucursal){
				if(this.sucursal[i].nombre === this.Sucursal){
					this.id_sucursal = this.sucursal[i].id
				}
			}
		},

		Ciudad:function(){
			for(const i in this.ciudad){
				if(this.ciudad[i].nombre === this.Ciudad){
					this.id_ciudad = this.ciudad[i].id
				}
			}
		},

		Zonas:function(){
			for(const i in this.zona){
				if(this.zona[i].nombre === this.Zonas){
					this.id_zona = this.zona[i].id
				}
			}
			this.subzonas = []; // Borramos el contenido del selector de subZonas
			this.consultarSubZonas(this.id_zona) //Mando a consultar SubZonas
		},

		SubZona:function(){
			for(const j in this.subzona){
				if(this.subzona[j].nombre === this.SubZona){
					this.id_subzona = this.subzona[j].id
				}
			}
		},

		Cartera:function(){
			for(const x in this.cartera){
				if(this.cartera[x].nombre === this.Cartera){
					this.id_cartera = this.cartera[x].id
				}
			}
		}
	},
}