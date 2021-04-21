import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		movimientos: [],
    loading: true,
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		MOVIMIENTOS(state, data){
			state.movimientos = data
    },
    
		
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
		}
  },

	getters:{
		Loading(state){
			return state.loading
		},

		getMovimientos(state){
		  return state.movimientos
    },
	}
}