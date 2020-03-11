import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		carteras: [],
	},

	mutations:{
		CARTERAS(state, data){
			state.carteras = data
		},
	},
	actions:{
		consultaCarteras({commit}){
			Vue.http.get('carteras').then(response=>{
				commit('CARTERAS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			})
		},

  },

	getters:{
		getCarteras(state){
		  return state.carteras
		},
	}
}