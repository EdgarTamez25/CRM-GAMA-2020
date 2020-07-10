
export default {
	methods: {

		traerFechaActual(){
			var f = new Date(); 
			return f.getFullYear() +'-'+ (f.getMonth() + 1 < 10? '0' + (f.getMonth() + 1): f.getMonth() + 1 ) +'-'+ (f.getDate()<10?'0'+f.getDate():f.getDate());
		},

		traerHoraActual(){
			var f = new Date(); 
			return (f.getHours()<10? '0'+f.getHours(): f.getHours()) + ':' + (f.getMinutes()<10? '0'+ f.getMinutes(): f.getMinutes())
		},

		traerMesActual(){
			var f = new Date();
			var primerDia = new Date(f.getFullYear(), f.getMonth(), 1).toISOString().substr(0, 10);
			var ultimoDia = new Date(f.getFullYear(), f.getMonth() + 1, 0).toISOString().substr(0, 10);
			const fecha = { fechaInicial: primerDia , fechaFinal: ultimoDia}
			return fecha;
		},

		

		consultaChofer(){
			this.$http.get('choferes').then(response =>{
				this.choferes = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultar_Clientes(){  // AUTOCOMPLETE -> CLIENTES
			this.$http.get('clientes').then((response)=>{
				this.clientes = response.body //LLENNO ARRAY
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultar_Categorias(){ // CATEGORIAS
			this.$http.get('categorias').then((response)=>{
				this.categorias = response.body  // LLENO ARREGLO CON RESPUESTA COMPLETA
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultar_Vendedores(){  // AUTOCOMPLETE -> VENDEDORES
			this.$http.get('vendedores').then((response)=>{
				this.vendedores = response.body //LLENNO ARRAY
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultar_MateriaPrima(){ // MATERIA PRIMA
			this.$http.get('mp-productos').then((response)=>{
				this.materia_prima = response.body
				for(const i in response.body){
					this.materias_primas.push(response.body[i].nombre)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},
			
		consultarTipo_Precios(){ //TIPO DE PRECIOS
			this.$http.get('tipos-precios').then((response)=>{
				this.tipo_precio = response.body
				for(const i in response.body){
					this.tipo_precios.push(response.body[i].nombre)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarMonedas(){ //MONEDAS
			this.$http.get('monedas').then((response)=>{
				this.moneda = response.body
				for(const i in response.body){
					this.monedas.push(response.body[i].codigo)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarUnidades(){ //UNIDADES
			this.$http.get('unidades').then((response)=>{
				this.unidad = response.body
				for(const i in response.body){
					this.unidades.push(response.body[i].nombre)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarProveedores(){ // PROVEEDORES
			this.$http.get('proveedores').then((response)=>{
				this.proveedor = response.body
				for(const i in response.body){
					this.proveedores.push(response.body[i].nombre)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarLineas(){ //LINEAS
			this.$http.get('lineas').then((response)=>{
				for(var i = 0; i<response.body.length;i++){
					this.lineas.push(response.body[i])
				}
				// this.lineas = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarSucursales(){ //SUCURSALES
			this.$http.get('sucursales').then((response)=>{
				this.sucursal = response.body
				for(const i in response.body){
					this.sucursales.push(response.body[i].nombre)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarCiudades(){ // CIUDADES
			this.$http.get('ciudades').then((response)=>{
				this.ciudad = response.body
				for(const i in response.body){
					this.ciudades.push(response.body[i].nombre)
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarZonas(){ // ZONAS
			this.$http.get('zonas').then((response)=>{
				this.zonas = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarCarteras(){ // CARTERAS
			this.$http.get('carteras').then((response)=>{
				this.carteras = response.body
			}).catch(error =>{
				console.log('error', error)
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

		// Linea:function(){
		// 	for(const i in this.linea){
		// 		if(this.linea[i].nombre === this.Linea){
		// 			this.id_linea = this.linea[i].id
		// 		}
		// 	}
		// },

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
	},
}