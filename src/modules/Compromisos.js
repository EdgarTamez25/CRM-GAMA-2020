import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		compromisos: [],
		loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		COMPROMISOS(state, data){
			state.compromisos = data
		},
	},
	actions:{ 
		
		consultaCompromisos({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('COMPROMISOS', [])
			Vue.http.get('compromisos/'+ parseInt(store.state.Login.datosUsuario.nivel)).then(response=>{
				commit('COMPROMISOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getCompromisos(state){
		  return state.compromisos
		},

	}
}