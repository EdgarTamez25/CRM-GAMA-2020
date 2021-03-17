
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

		traerNivelxSistema(id_sistema = 1, niveles){
			// console.log('niveles', niveles)
			// console.log('id_sistema', id_sistema)
			if(!niveles.length){ return };
			this.nivelesxsistema = [];
			const sistemas = [ 
				{ id: 1, niveles:[ 1,2,3,4,5,6,13] }, // CRM-GAMA-2020
				{ id: 2, niveles:[ 3,,12,13 ] },  		// CRM-GAMA-MOVIL 
				{ id: 3, niveles:[ 1,7,13 ] },  		  // REGISTRO ENTRADA Y SALIDA 
				{ id: 4, niveles:[ 1,10,13 ] },  		  // MEJORA CONTINUA 
				{ id: 5, niveles:[ 1,2,9,13 ] }   		// PROGRAMACION FLEXO 
			]
			
			for(let i=0; i< sistemas[id_sistema-1].niveles.length; i++){
				for( let j=0; j< niveles.length ; j++ ){
					if(sistemas[id_sistema-1].niveles[i] === niveles[j].id ){
						this.nivelesxsistema.push(niveles[j])
					}
				}
			}

		},

		consultaNiveles(){
			this.$http.get('niveles').then(response =>{
				this.niveles = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultaSistemas(){
			this.$http.get('sistemas').then(response =>{
				this.sistemas = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultaDeptos(){
			this.$http.get('departamentos').then(response =>{
				this.departamentos = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultaPuestos(){
			this.$http.get('puestos').then(response =>{
				this.puestos = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultaChofer(){
			this.$http.get('choferes').then(response =>{
				this.choferes = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultar_Clientes(){  // AUTOCOMPLETE -> CLIENTES
			this.$http.get('clientes.selector').then((response)=>{
				// console.log('clientes.se', response.body)
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
				this.unidades = response.body
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

		consultarLineas(){ //LINEAS|
			this.$http.get('lineas').then((response)=>{
				for(var i = 0; i<response.body.length;i++){
					this.lineas.push(response.body[i])
				}
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarSucursales(){ //SUCURSALES
			this.$http.get('sucursales').then((response)=>{
				this.sucursales = response.body
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultarCiudades(){ // CIUDADES
			this.$http.get('ciudades').then((response)=>{
				this.ciudades = response.body
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

	},
}