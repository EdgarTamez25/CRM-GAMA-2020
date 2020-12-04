import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		productosCliente: [],
		loading: false,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PRODUCTOS_CLIENTE(state, data){
			state.productosCliente = data;
		},
	
	},
	actions:{

		consultaProductosxCliente({commit}, id_cliente ){
      commit('LOADING',true); commit('PRODUCTOS_CLIENTE', []); 
      
			Vue.http.get('productos.cliente/'+ id_cliente ).then(response=>{
				commit('PRODUCTOS_CLIENTE', response.body);
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},
  },

	getters:{
		LoadingPxC(state){
			return state.loading
		},

		getProductosxCli(state){
		  return state.productosCliente
		},
	}
}