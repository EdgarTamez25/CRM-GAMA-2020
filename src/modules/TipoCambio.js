import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		ot: [],
    loading: true,
		parametros:[],
		tipo_cambio:[]

	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		PARAMETROS(state, data){
			state.filtros = data
		},
		TIPO_CAMBIO(state,  data){
			state.tipo_cambio = data
		}
		
	},
	actions:{ 
		obtener_tipo_cambio({commit}, payload){
			// commit('LOADING',true); 
      commit('TIPO_CAMBIO', []);
			return new Promise( resolve => {
				Vue.http.post('obtener.tipo.cambio',payload).then(response=>{
					commit('TIPO_CAMBIO', response.body[0])
          // console.log('Tipo',response.body[0].cambio)
					resolve(response.body[0].cambio);
				}).catch((error)=>{
					console.log('error tipo cambio',error)
					resolve(false)
				})
        // .finally(() => commit('LOADING', false)) 
			})
		},

		programaProductos({commit}, payload){
			return new Promise( resolve => {
				Vue.http.post('programar.producto', payload).then(response=>{
					console.log('monitor', response.body)
					resolve(response);
				}).catch((error)=>{
					console.log('error',error)
					resolve(error)
				})
			})
		},

		agregar_tipo_cambio({commit}, payload){
			return new Promise( resolve => {
				Vue.http.post('agregar.tipo.cambio', payload).then(response=>{
					console.log('guardar', response.body)
					resolve(response);
				}).catch((error)=>{
					console.log('error',error)
					resolve(error)
				})
			})
		},

		editar_tipo_cambio({commit}, payload){
			let id =  this.state.TipoCambio.tipo_cambio.id;
			return new Promise( resolve => {
				Vue.http.put('editar.tipo.cambio/'+ id, payload).then(response=>{
					console.log('editar', response.body)
					resolve(response);
				}).catch((error)=>{
					console.log('error',error)
					resolve(error)
				})
			})
		},
		
  },

	getters:{
		Loading(state){
			return state.loading
		},
		Parametros(state){
			return state.filtros
		},

		tipo_cambio_hoy(state){
			return state.tipo_cambio
      
		}
	}
}