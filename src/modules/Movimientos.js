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
		consultaMovimientos({commit}, payload){
			commit('MOVIMIENTOS', []); commit('LOADING',true)
			return new Promise((resolve,reject) =>{
				Vue.http.post('movim.sol', payload).then(response=>{
					if(response.body.length){
						commit('MOVIMIENTOS', response.body)
						resolve(true)
					}else{
						commit('MOVIMIENTOS', [])
						resolve(false)
					}
				}).catch((error)=>{
					console.log('error',error)
					reject(false)
				}).finally(()=>{ 
					commit('LOADING', false)
				})
			})
		},

		insertaMovimientos({commit}, payload ){
			return new Promise((resolve,reject) =>{
				Vue.http.post('enviar.movimiento', payload).then(response=>{
					console.log('respoonse', response)
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