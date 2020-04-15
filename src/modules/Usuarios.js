import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		usuarios: [],
		loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		USUARIOS(state, data){
			state.usuarios = data
		},
	},
	actions:{
		consultaUsuarios({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('USUARIOS', [])

			Vue.http.get('catusuarios').then(response=>{
				commit('USUARIOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

		eliminarUsuario({commit}){

			
		}

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getUsuarios(state){
		  return state.usuarios
		},

	}
}