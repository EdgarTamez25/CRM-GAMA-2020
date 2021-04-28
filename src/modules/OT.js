import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		ot: [],
    loading: true,
		parametros:[],
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		ORDENES_TRABAJO(state, data){
			state.ot = data
    },
		PARAMETROS(state, data){
			state.filtros = data
		},
		
	},
	actions:{ 
		
		consultaOT({commit}, payload){
			commit('PARAMETROS', payload); commit('LOADING',true); commit('ORDENES_TRABAJO', []);
			Vue.http.post('ordenes.trabajo', payload).then(response=>{
				commit('ORDENES_TRABAJO', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
    },
  },

	getters:{
		Loading(state){
			return state.loading
		},
		getOT(state){
		  return state.ot
    },
		Parametros(state){
			return state.filtros
		},
	}
}