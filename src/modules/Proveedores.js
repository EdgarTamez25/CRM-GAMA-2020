import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		proveedores: [],
		loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PROVEEDORES(state, data){
			state.proveedores = data
		},
	},
	actions:{
		consultaProveedores({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('PROVEEDORES', [])

			Vue.http.get('catproveedores').then(response=>{
				commit('PROVEEDORES', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getProveedores(state){
		  return state.proveedores
		},

	}
}