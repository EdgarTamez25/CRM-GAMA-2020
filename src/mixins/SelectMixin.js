
export default {

	data () {
		return {
			// SELECTORES
			id_subzona  :  0,
			subzona			: [],
			subzonas    : [],
			SubZona     : '',

			id_zona     : 0,   //identificador
			zona				: [],  //Array completo
			zonas				: [],  //Solo nombres 
			Zonas				: '',

			id_cartera  : 0,
			cartera     : [],
			carteras    : [],
			Cartera     : '' 

			
		
		}
	},

	methods: {

		consultarMonedas(){
			this.$http.get('monedas').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.moneda = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.monedas.push(response.body[i].nombre)
				}
			})
		},

		consultarUnidades(){
			this.$http.get('unidades').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.unidad = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.unidades.push(response.body[i].nombre)
				}
			})
		},

		consultarProveedores(){
			this.$http.get('proveedores').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.proveedor = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.proveedores.push(response.body[i].nombre)
				}
			})
		},

		consultarLineas(){
			this.$http.get('lineas').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.linea = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.lineas.push(response.body[i].nombre)
				}
			})
		},

		consultarSucursales(){
			this.$http.get('sucursales').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.sucursal = response.body

				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.sucursales.push(response.body[i].nombre)
				}
			})
		},

		consultarCiudades(){
			this.$http.get('ciudades').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.ciudad = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.ciudades.push(response.body[i].nombre)
				}
			})
		},

		consultarZonas(){
			this.$http.get('zonas').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.zona = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.zonas.push(response.body[i].nombre)
				}
			})
		},

		consultarSubZonas(id){
			this.$http.get('subzonas/'+ id).then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.subzona = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.subzonas.push(response.body[i].nombre)
				}
			})
		},

		consultarCarteras(){
			this.$http.get('carteras').then((response)=>{
				// LLENO ARREGLO CON RESPUESTA COMPLETA
				this.cartera = response.body
				// FORMO ARREGLO A MOSTRAR EN SELECTOR
				for(const i in response.body){
					this.carteras.push(response.body[i].nombre)
				}
			})
		}
	},

	watch:{
		Moneda:function(){
			for(const i in this.moneda){
				if(this.moneda[i].nombre === this.Moneda){
					this.id_moneda = this.moneda[i].id
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