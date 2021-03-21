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
					// console.log('VALIDACION', response.body)
					resolve(response.body[0])
				}).catch( error =>{
					console.log('valida error', error)
					reject(error)
				})
			});
		},

		ObtenerDatosUsuario({commit},payload){
			return new Promise((resolve, reject) => {
				Vue.http.post('obtener.datos.usuario',payload ).then(response =>{
					resolve(response.body.datosUsuario)
					commit('DATOS_USUARIO', response.body.datosUsuario );
					commit('SISTEMAS'     , response.body.sistemas);
					commit('LOGEADO', true);

				}).catch( error =>{
					console.log('valida error', error.body)
					reject(error)
				})	
			});
			
		},


		salirLogin({commit}){
			commit('AUTHENTICAR', true)
			commit('SALIR');

			const payload = new Object();
						payload.id = localStorage.getItem("KeyLogger");
			Vue.http.post('cerrar.sesion', payload ).then( res =>{
				console.log('SE CERRO CON EXITO');
			})
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