import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		movimientos: [],
    loading: true,
		resultados:[]
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		MOVIMIENTOS(state, data){
			state.movimientos = data
    },

		RESULTADOS(state, data){
			state.resultados = data;
		}
    
		
	},
	actions:{ 
		consultaMovimientos({commit}, id_det_sol){
			commit('MOVIMIENTOS', []); commit('LOADING',true)
				Vue.http.get('movim.sol/'+ id_det_sol).then(response=>{
						commit('MOVIMIENTOS', response.body)
				}).catch((error)=>{
					console.log('error',error)
				}).finally(()=>{ 
					commit('LOADING', false)
				})
		},

		insertaMovimientos({commit}, payload ){
			return new Promise((resolve,reject) =>{
				Vue.http.post('enviar.movimiento', payload).then(response=>{
					commit('MOVIMIENTOS', response.body)
					resolve(response)
				}).catch((error)=>{
					reject(error)
					console.log('error',error)
				}).finally(()=>{ 
					commit('LOADING', false)
				})
			})
		},

		ActualizaMovimientos({commit}, payload){
			return new Promise((resolve,reject) =>{
				Vue.http.post('actualiza.envio.movimiento', payload).then(response=>{
					commit('MOVIMIENTOS', response.body)
					resolve(response)
				}).catch((error)=>{
					reject(error)
					console.log('error',error)
				}).finally(()=>{ 
					commit('LOADING', false)
				})
			})
		},

		agregarResultado({commit}, payload){
			return new Promise((resolve,reject) =>{
				Vue.http.post('agrega.resultados.actividad', payload).then(response=>{
					resolve(response.bodyText)
				}).catch((error)=>{
					reject(error.bodyText)
					console.log('error',error)
				}).finally(()=>{ 
					commit('LOADING', false)
				})
			})
		},

		consultaResultados({commit}, id){
			Vue.http.get('obtener.res.act.id/'+ id).then(response=>{
				commit('RESULTADOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			})
		},

		eliminarResultado({commit},id){
			return new Promise((resolve,reject) =>{
				Vue.http.delete('elimina.registro.actividad/'+ id).then(response=>{
					resolve(response.bodyText)
				}).catch((error)=>{
					reject(error.bodyText)
					console.log('error',error)
				}).finally(()=>{ 
					commit('LOADING', false)
				})
			})
		}

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getMovimientos(state){
		  return state.movimientos
    },

		getResultados(state){
		  return state.resultados

		}
	}
}