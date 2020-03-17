import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		productos: [],
		loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PRODUCTOS(state, data){
			state.productos = data
		},
	},
	actions:{
		consultaProductos({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('PRODUCTOS', [])
			Vue.http.get('catproductos').then(response=>{
				commit('PRODUCTOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getProductos(state){
		  return state.productos
		},

	}
}