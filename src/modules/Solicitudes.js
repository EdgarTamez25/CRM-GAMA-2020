import Vue from 'vue'
import store from '@/store'

export default{
	namespaced: true,
	state:{
		solicitudes: [],
    loading: true,
		detalle: [],
		modificaciones: [],
		parametros:[],
		solicitudesddd:[],
		datosFlexo: null,
		datosDigital: null,
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

		}
	},
	actions:{ 
		
		consultaSolicitudes({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('SOLICITUDES', [])
			Vue.http.post('solicitudes', store.state.Solicitudes.parametros).then(response=>{
				commit('SOLICITUDES', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
    },
		
		consultaSolicitudesDDD({commit}){
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

		actualizaProducto({commit}, payload){
			return new Promise(resolve => {
				Vue.http.post('actualiza.prod.nuevo', payload).then(response=>{
					// console.log('response actualiza', response.body)
					resolve(true);
				}).catch((error)=>{
					console.log('error',error)
					resolve(false)
				})
			})
		},

		guardaParametrosConsulta( { commit },payload){
			commit('PARAMETROS', payload)
		},

		copiarInfoDeSolicitud({ commit }, payload){
			commit('DATOS_COPIADOS', payload)
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
		},

		getSolicitudesDDD(state){
			return state.solicitudesddd
		},

		getDatosFlexo(state){
			return state.datosFlexo;
		},

		getDatosDigital(state){
			return state.datosDigital;
		}
		
	}
}