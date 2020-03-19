import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		precios: [],
		preciosxId : [],
		loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PRECIOS(state, data){
			state.precios = data
		},

		PRECIOSXID(state, data){
			state.preciosxId = data
		},
	},
	actions:{
		consultaPrecios({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('PRECIOS', [])

			Vue.http.get('catusuarios').then(response=>{
				commit('PRECIOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

		consultaPreciosxId({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('PRECIOSXID', [])
			Vue.http.get('catusuarios').then(response=>{
				commit('PRECIOSXID', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		}

  },

	getters:{
		Loading_precios(state){
			return state.loading
		},

		getPrecios(state){
		  return state.precios
		},

		getPreciosxId(state){
			return state.preciosxId
		}

	}
}