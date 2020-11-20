import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		solicitudes: [],
    loading: true,
		detalle: [],
		modificaciones: [],
	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		SOLICITUDES(state, data){
			state.solicitudes = data
    },
    DETALLE(state, data){
      state.detalle = data
		},
		MODIFICACIONES(state, data){
      state.modificaciones = data
		}
	},
	actions:{ 
		
		consultaSolicitudes({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('SOLICITUDES', [])
			Vue.http.get('solicitudes').then(response=>{
				commit('SOLICITUDES', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
    },
    
    consultaDetalle({commit}, id_solicitud){
      commit('LOADING',true); commit('DETALLE', []);
      Vue.http.get('detalle.solicitud/'+ id_solicitud).then(response=>{
				commit('DETALLE', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 

		},
		
		consultaModificaciones({commit}, id){

			commit('MODIFICACIONES', []);
			return new Promise( resolve => {
				Vue.http.get('modificaciones/'+ id).then(response=>{
					commit('MODIFICACIONES', response.body)
					resolve(true);
				}).catch((error)=>{
					console.log('error',error)
					resolve(false)
				})
			})
		},

		actualizaModificaciones({commit}){
			commit('MODIFICACIONES', []);
		}
  },

	getters:{
		Loading(state){
			return state.loading
		},

		getSolicitudes(state){
		  return state.solicitudes
    },
    
    getDetalle(state){
		  return state.detalle
		},

		getModificaciones(state){
			return state.modificaciones;
		}
	}
}