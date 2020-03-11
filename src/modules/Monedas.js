import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		monedas: [],
	},

	mutations:{
		MONEDAS(state, data){
			state.monedas = data
		},
	},
	actions:{
		consultaMonedas({commit}){
			Vue.http.get('monedas').then(response=>{
                console.log('monedas', response.body)
				commit('MONEDAS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			})
		},
  },

	getters:{
		getMonedas(state){
		  return state.monedas
		},
	}
}