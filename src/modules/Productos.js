import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		productos: [],
		productosAll:[],
		masProductos: false,
		loading: false,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PRODUCTOSALL(state, data){
			state.productosAll = data
		},
		PRODUCTOS(state, data){
			state.productos    = data;
			state.masProductos = false;

		},
		VERMASPRODUCTOS(state){
			state.masProductos = true;
			var valor_actual = parseInt(state.productos.length);
			var cantidad 		 = parseInt(state.productos.length + 50);
			
			if(state.productosAll.length < cantidad){
				var cant = cantidad;
				cantidad = valor_actual + (cant-parseInt(state.productosAll.length));
				state.masProductos = false;
			}
		
			for(var i=valor_actual;i<cantidad;i++){
				state.productos.push(state.productosAll[i])
			}
		}
	},
	actions:{
		consultaProductosxId({commit}, id ){
			commit('LOADING',true); commit('PRODUCTOSALL', []); 
			Vue.http.get('productosxId/'+id ).then(response=>{
				commit('PRODUCTOSALL', response.body);
					commit('PRODUCTOS',response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

		consultaProductos({commit}, id ){
			commit('LOADING',true); commit('PRODUCTOSALL', []); 
			Vue.http.get('catproductos' ).then(response=>{
				commit('PRODUCTOSALL', response.body);
				if(response.body.length >100){
					commit('VERMASPRODUCTOS');
				}else 
					commit('PRODUCTOS',response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

		

		VerMasProductos({commit}){
			commit('VERMASPRODUCTOS');
		}
  },

	getters:{
		Loading(state){
			return state.loading
		},

		getProductos(state){
		  return state.productos
		},

		masProductos(state){
			return state.masProductos;
		},

		getProductosAll(state){
			return state.productosAll;
		}

	}
}