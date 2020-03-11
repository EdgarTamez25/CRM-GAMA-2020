import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		zonas: [],
	},

	mutations:{
		ZONAS(state, data){
			state.zonas = data
		},
	},
	actions:{
		consultaZonas({commit}){
			Vue.http.get('catzonas').then(response=>{
				commit('ZONAS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			})
		},

  },

	getters:{
		getZonas(state){
		  return state.zonas
		},
	}
}