import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		clientes: [],
		loading: true,
		clientes_productos: []
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		CLIENTES(state, data){
			state.clientes = data
		},
		CLIENTES_PRODUCTOS(state,data){
			state.clientes_productos = data
		}
	},
	actions:{
		consultaClienteProductos({commit}){
			commit('LOADING',true); commit('CLIENTES_PRODUCTOS', []);

			Vue.http.get('clientes.productos').then(response=>{
				commit('CLIENTES_PRODUCTOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

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
		getClientesProductos(state){
			return state.clientes_productos
		}
	}
}