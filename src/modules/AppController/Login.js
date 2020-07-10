import Vue from 'vue'

export default{
	namespaced: true,
	state:{
		login:false,
		datosUsuario:[],
	},

	mutations:{
		LOGEADO(state, value){
			state.login = value
		},
		DATOS_USUARIO(state, datosUsuario){
      state.datosUsuario = datosUsuario
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

	}
}