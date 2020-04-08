import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		monedas: [],
		loading: true,
		predeterminada: [],
		USD: []
	},

	mutations:{
		MONEDAS(state, data){
			state.monedas = data
		},
		LOADING(state, data){
			state.loading = data; 
		},
		PREDETERMINADA(state, payload){
			state.predeterminada = payload;
		},
		USD(state, moneda){
			state.USD = moneda;
		}
	},
	actions:{
		consultaMonedas({commit}){
			commit('LOADING',true); commit('MONEDAS', []);
			Vue.http.get('monedas').then(response=>{
				commit('MONEDAS', response.body)   // GUARDO RESPUESTA PARA EL CATALOGO DE MONEDAS
				for( var value of response.body){  // CICLO PARA GUARDAR DATOS DEL DOLAR
					if(value.codigo === 'USD'){
						commit('USD', value)
					}
				}
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
				commit('PREDETERMINADA', response.body[0]);
			}).catch((error)=>{
				console.log('error',error)
			})
		},

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getMonedas(state){
		  return state.monedas
		},

		predeterminada(state){
		 return state.predeterminada
		},

		moneda_USD(state){
			return state.USD
		}
	}
}