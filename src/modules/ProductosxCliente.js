import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		productosCliente: [],
		productosClienteDeptos: [],
		loading: false,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PRODUCTOS_CLIENTE(state, data){
			state.productosCliente = data;
		},
		PRODUCTOS_CLIENTE_DEPTOS(state, data){
			state.productosClienteDeptos = data;
		}
	},
	actions:{

		consultaProductosxCliente({commit}, id_cliente ){
			
			commit('PRODUCTOS_CLIENTE', []); 
			if(!id_cliente){ return }
			commit('LOADING',true);
			Vue.http.get('productos.cliente/'+ id_cliente ).then(response=>{
				commit('PRODUCTOS_CLIENTE', response.body);
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},


		consultaPxCxD({ commit}, payload){
			commit('LOADING',true); commit('PRODUCTOS_CLIENTE_DEPTOS', []); 
			Vue.http.post('productos.cliente.deptos', payload ).then(response=>{
				commit('PRODUCTOS_CLIENTE_DEPTOS', response.body);
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		}
	},
	

	getters:{
		Loading(state){
			return state.loading;
		},

		getProductosxCli(state){
		  return state.productosCliente;
		},

		getPxCxD(state){
			return state.productosClienteDeptos;
		}

	}
}