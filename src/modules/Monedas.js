import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		monedas: [],
		loading: true,
		predeterminada: [],
	},

	mutations:{
		MONEDAS(state, data){
			state.monedas = data
		},
		LOADING(state, data){
			state.loading = data; 
		},
		PREDETERMINADA(state, data){
			state.predeterminada = data;
		}
	},
	actions:{
		consultaMonedas({commit}){
			commit('LOADING',true); commit('MONEDAS', []);
			Vue.http.get('monedas').then(response=>{
                console.log('monedas', response.body)
				commit('MONEDAS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},


		guardarMonedaPredeterminada({commit,dispatch}, id){
			return new Promise((resolve) =>{
				Vue.http.put('predeterminado/'+ id).then(response =>{
					dispatch('consultaMonedas');
					dispatch('ActualizaMoneda');
					resolve(true);
				}).catch((error)=>{
					console.log('error',error)
				})
			})
		},

		ActualizaMoneda({commit}){
			Vue.http.get('monedaPredeterminada').then(response =>{
				commit('PREDETERMINADA', response.body);
			}).catch((error)=>{
				console.log('error',error)
			})
		}

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getMonedas(state){
		  return state.monedas
		},

		predeterminada(){
		 return state.predeterminada
		}
	}
}