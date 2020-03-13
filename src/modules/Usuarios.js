import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		usuarios: [],
	},

	mutations:{
		USUARIOS(state, data){
			state.usuarios = data
		},
	},
	actions:{
		consultaUsuarios({commit}){
			Vue.http.get('catusuarios').then(response=>{
				commit('USUARIOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			})
		},

  },

	getters:{
		getUsuarios(state){
		  return state.usuarios
		},
	}
}