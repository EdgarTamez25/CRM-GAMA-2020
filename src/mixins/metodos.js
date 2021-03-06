import Vue from 'vue'

export default {

	data () {
		return {
			
		}
	},
	
	methods: {
		traerFechaActual(){
			var f = new Date(); 
			return f.getFullYear() +'-'+ (f.getMonth() + 1 < 10? '0' + (f.getMonth() + 1): f.getMonth() + 1 ) +'-'+ (f.getDate()<10?'0'+f.getDate():f.getDate());
		},
		traerHoraActual(){
			var f = new Date(); 
			return (f.getHours()<10? '0'+f.getHours(): f.getHours()) + ':' + (f.getMinutes()<10? '0'+ f.getMinutes(): f.getMinutes())
		},
		
		consultar_Clientes(){  // AUTOCOMPLETE -> CLIENTES
			return new Promise( resolve => {
				this.$http.get('clientes').then((response)=>{
					this.clientes = response.body //LLENNO ARRAY
					resolve(this.clientes);
				}).catch(error =>{
					console.log('error', error)
				})
			})	
		},

		consultar_Categorias(){ // CATEGORIAS
			this.$http.get('categorias').then((response)=>{
				this.categorias = response.body  // LLENO ARREGLO CON RESPUESTA COMPLETA
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultaDepartamentos(){
			this.deptos = [	{ id:1, nombre:'FLEXOGRAFÍA'},
											{ id:2, nombre:'BORDADOS'},
											{ id:3, nombre:'DIGITAL'},
											{ id:4, nombre:'OFFSET'},
											{ id:5, nombre:'SERIGRAFÍA'},
											{ id:6, nombre:'EMPAQUE'},
											{ id:7, nombre:'SUBLIMACIÓN'},
											{ id:8, nombre:'TAMPOGRAFÍA'},
											{ id:9, nombre:'UV'}
										]
		},

		consultar_Vendedores(){  // AUTOCOMPLETE -> VENDEDORES
			this.$http.get('vendedores').then((response)=>{
				this.vendedores = response.body //LLENNO ARRAY
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultar_Usuarios(){  // AUTOCOMPLETE -> VENDEDORES
			this.$http.get('catusuarios').then((response)=>{
				this.usuarios = response.body //LLENNO ARRAY
			}).catch(error =>{
				console.log('error', error)
			})
		},

		consultaEstructuras(){
			this.estructuras = [{ id:1, nombre:'Estructura PTR sencilla'},
													{	id:2, nombre:'Estructura PTR giratoria ( 2 caras )'},
													{	id:3, nombre:'Estructura PTR giratoria ( 3 caras o mas )'},
													{	id:4, nombre:'Estructura PTR con ruedas'}
											]
		},

		consultaMateriales(depto_id){
			return new Promise( resolve => {
				this.$http.get('materiales/'+ depto_id).then((response)=>{
					for(let i=0; i< response.body.length; i++){
						if(response.body[i].tipo != 2){
							this.materiales.push(response.body[i])
						}else{
							this.materiales2.push(response.body[i])
						}
					}
					resolve(true)
					// this.materiales = response.body  // LLENO ARREGLO CON RESPUESTA COMPLETA
				}).catch(error =>{
					console.log('error materiales', error)
				})
			})
		},

		consultaAcabados(depto_id){
			return new Promise( resolve => {
				this.$http.get('acabados/'+ depto_id).then((response)=>{
					this.acabados = response.body  
					resolve(response.body)
				}).catch(error =>{
					console.log('error acabados', error)
				})
			})
			
		},

		consultaProdxClientexDepto( data){
			return new Promise( (resolve, reject) => {
				this.$http.post('productos.cliente.deptos',data).then((response)=>{
					resolve(response.body)
				}).catch(error =>{
					reject('No se encontraron productos en esté departamento.')
					console.log('error clixdpto', error)
				})
			})
		},
		
		evualuaRetorno(){
			if(this.getSolicitudes.length){
				this.alertaDeContenido = true;
			}else{
				window.history.go(-1); return false;
			}
		},

		evaluarContenidoDetalles(data){
			data.length > 2 ? true: false;
		},
  }
}