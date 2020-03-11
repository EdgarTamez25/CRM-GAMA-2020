import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		clientes: [],
	},

	mutations:{
		CLIENTES(state, data){
			state.clientes = data
		},
	},
	actions:{
		consultaClientes({commit}){
			Vue.http.get('clientes').then(response=>{
				console.log('vuex clientes', response.body)
				commit('CLIENTES', response.body)
			}).catch((error)=>{
				console.log('error',error)
			})
		},

  },

	getters:{
		getClientes(state){
		  return state.clientes
		},
	}
}