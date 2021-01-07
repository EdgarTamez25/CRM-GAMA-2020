import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		compromisos: [],
		loading: true,
		parametros: {}
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		COMPROMISOS(state, data){
			state.compromisos = data;
		},
		PARAMETROS(state, data){
			state.parametros = data
		}
	},
	actions:{ 
		
		consultaCompromisos({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('COMPROMISOS', [])
			Vue.http.post('compromisos', store.state.Compromisos.parametros).then(response=>{
				commit('COMPROMISOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},


		guardarParametros({ commit}, parametros){
			commit('PARAMETROS', parametros);
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