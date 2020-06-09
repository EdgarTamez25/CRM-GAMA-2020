import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		clientes: [],
		loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		CLIENTES(state, data){
			state.clientes = data
		},
	},
	actions:{
		consultaClientes({commit}){
			commit('LOADING',true); commit('CLIENTES', []);

			Vue.http.get('clientes').then(response=>{
				commit('CLIENTES', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

  },

	getters:{
		Loading(state){
			return state.loading
		},
		getClientes(state){
		  return state.clientes
		},
	}
}