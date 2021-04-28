import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		solicitudes: [],
    loading: true,
		detalle: [],
		modificaciones: [],
		solicitudesddd:[],
		datosFlexo: null,
		datosDigital: null,
		
		parametros:{},
		filtros:{}
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
		},
		PARAMETROS(state, data){
			state.parametros = data;
		},
		SOLICITUDESDDD(state, data){
			state.solicitudesddd = data;
		},
		DATOS_COPIADOS(state, data){
			if(data.dx === 1){ state.datosFlexo   = data;  };
			if(data.dx === 3){ state.datosDigital = data;  };

		},
		SOLICITUDES_AUTOMATICAS(state, data){
			if(state.solicitudes.length != data.length){
				state.solicitudes = data
				console.log('SI HAY CAMBIOS')
			}else{
				console.log('NO HAY CAMBIOS')
			}
		},
		// SOLICITUDES_AUTOMATICAS_DDD(state, data){
		// 	if(state.solicitudesddd.length != data.length){
		// 		state.solicitudesddd = data
		// 		console.log('SI HAY CAMBIOS')
		// 	}else{
		// 		console.log('NO HAY CAMBIOS')
		// 	}
		// },
		PARAMETROS2(state, data){
			state.filtros = data
		}
		
	},
	actions:{ 
		
		consultaSolicitudes({commit}, payload){
			commit('PARAMETROS2', payload);
			commit('LOADING',true); commit('SOLICITUDES', [])
			Vue.http.post('solicitudes', payload).then(response=>{
				commit('SOLICITUDES', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
    },
		
		consultaSolicitudesDDD({commit}, payload){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('SOLICITUDESDDD', [])
			Vue.http.post('solicitudes.ddd', store.state.Solicitudes.parametros).then(response=>{
				// console.log('response', response.body)
				commit('SOLICITUDESDDD', response.body)
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
		},

		guardaParametrosConsulta( { commit },payload){
			commit('PARAMETROS', payload)
		},

		copiarInfoDeSolicitud({ commit }, payload){
			commit('DATOS_COPIADOS', payload)
		},

		agregaProducto({commit}, payload){
			return new Promise((resolve, reject) => {
				Vue.http.post('agregar.producto.solicitud', payload).then(response=>{
					resolve(response.bodyText)
				}).catch((error)=>{
					reject(errror.bodyText);
					console.log('error',error)
				}).finally(() => commit('LOADING', false)) 

			})
		},

		// consultaAutomatica({commit}){
		// 	Vue.http.post('solicitudes', store.state.Solicitudes.parametros).then(response=>{
		// 		console.log('RESPONSE', response)
		// 		commit('SOLICITUDES_AUTOMATICAS', response.body)
		// 	}).catch((error)=>{
		// 		console.log('error',error)
		// 	}).finally(() => commit('LOADING', false)) 
		// },

		// consultaAutomaticaDDD({commit}){
		// 	Vue.http.post('solicitudes',  store.state.Solicitudes.parametros).then(response=>{
		// 		commit('SOLICITUDES_AUTOMATICAS_DDD', response.body)
		// 	}).catch((error)=>{
		// 		console.log('error',error)
		// 	}).finally(() => commit('LOADING', false)) 
		// }


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
		},

		getSolicitudesDDD(state){
			return state.solicitudesddd
		},

		getDatosFlexo(state){
			return state.datosFlexo;
		},

		getDatosDigital(state){
			return state.datosDigital;
		},
		Parametros(state){
			return state.filtros
		},
		Parametros2(state){
			return state.parametros
		}
		
	}
}