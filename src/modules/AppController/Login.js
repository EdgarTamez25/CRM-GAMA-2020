import Vue from 'vue'

export default{
	namespaced: true,
	state:{
		login:false,
		datosUsuario:[],
		sistemas:[],

	},

	mutations:{
		LOGEADO(state, value){
			state.login = value
		},
		DATOS_USUARIO(state, datosUsuario){
      state.datosUsuario = datosUsuario
		},
		SISTEMAS(state, data){
			state.sistemas = data
		},

		SALIR(state){
			state.login = false;
			state.datosUsuario = [];
		}
	},

	actions:{
    
    Login({commit}, payload){
			return new Promise((resolve, reject) => {
			  Vue.http.post('login', payload).then(response =>{
					// localStorage.setItem("KeyId",response.body[0].id)
					if(response.body.length){
						resolve(true)
            commit('DATOS_USUARIO', response.body[0]);
						commit('LOGEADO', true);
					}else{
						resolve(false)
					}
			  }).catch((error)=>{
					reject(error)
				})
			})
		},

		validaSession(){
			return new Promise((resolve, reject) => {
				const payload = new Object();
              payload.id = localStorage.getItem("KeyLogger")
				Vue.http.post('valida.sesion.activa', payload).then(response =>{
					console.log('VALIDACION', response.body)
					resolve(response.body[0])
				}).catch( error =>{
					console.log('valida error', error)
					reject(error)
				})
			});
		},

		ObtenerDatosUsuario({commit},id_usuario){
			return new Promise((resolve, reject) => {
				Vue.http.get('obtener.datos.usuario/'+ id_usuario ).then(response =>{
					// console.log('user', response.body)
					resolve(response.body[0])
					commit('DATOS_USUARIO', response.body[0][0]);
					commit('SISTEMAS'     , response.body[1]);
				}).catch( error =>{
					console.log('valida error', error.body)
					reject(error)
				})	
			});
			
		},


		salirLogin({commit}){
			// this.$store.dispatch("salir")
			commit('SALIR')
		},
	},

	getters:{
		getLogeado(state){
		  return state.login
		},
		getdatosUsuario(state){
			return state.datosUsuario
		},

		getSistemas(state){
			return state.sistemas;
		}

	}
}