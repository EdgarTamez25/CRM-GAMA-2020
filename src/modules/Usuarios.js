import Vue from 'vue'
import Vuex from 'vuex'

export default{
	namespaced: true,
	state:{
		usuarios: [],
		loading: true,
		sistemas_usuario:[],
		accesosAEditar:[]

	},

	mutations:{
		LOADING(state, data){
			state.loading = data; 
		},
		USUARIOS(state, data){
			state.usuarios = data
		},
		AGREGAR_SISTEMAS_USUARIO(state, data){
			const payload = new Object();
						payload.id         = state.sistemas_usuario.length? state.sistemas_usuario.length + 1 : 1;
						payload.id_sistema = data.id_sistema;
						payload.nomsistema = data.nomsistema;
						payload.id_nivel   = data.id_nivel;
						payload.nomnivel   = data.nomnivel;
			state.sistemas_usuario.push(payload);
		},
		EDITAR_SISTEMAS_USUARIO(state, payload){
			// console.log('editar prr', payload)
			for(let i =0; i < state.sistemas_usuario.length;i++){
				if(state.sistemas_usuario[i].id === payload.id){
					state.sistemas_usuario[i] = payload;
				}
			}
			//!NUNCA HAGAN ESTO AMIGITOS - SOLCION POCO OPTIMA
			var temporal = state.sistemas_usuario;
			state.sistemas_usuario = [];
			state.sistemas_usuario = temporal;	
		},
		ELIMINAR_SISTEMAS_USUARIO(state, id){
			for(let i =0; i < state.sistemas_usuario.length;i++){
				if(state.sistemas_usuario[i].id === id){
					state.sistemas_usuario.splice(i,1);
				}
			}
		},
		LIMPIAR_SISTEMAS_USUARIO(state){
			state.sistemas_usuario = [];
		},
		ACCESOS_USUARIOS_MODO2(state, payload){
			state.sistemas_usuario = payload;
			state.accesosAEditar   = payload;
		}

	},
	actions:{
		consultaUsuarios({commit}){
			// Limpio Arreglo y Genero Consulta
			commit('LOADING',true); commit('USUARIOS', [])

			Vue.http.get('catusuarios').then(response=>{
				commit('USUARIOS', response.body)
			}).catch((error)=>{
				console.log('error',error)
			}).finally(() => commit('LOADING', false)) 
		},

		agregar_sistema_usuario({ commit}, payload){
		 return new Promise((resolve, reject)=>{
			commit('AGREGAR_SISTEMAS_USUARIO',  payload);
			resolve("Se agrego correctamente");
		 })
		},

		editar_sistema_usuario({commit}, payload){
			return new Promise((resolve) =>{
				commit('EDITAR_SISTEMAS_USUARIO', payload)
				resolve("Se editó correctamente");
			})
		},

		eliminar_sistema_usuario({commit}, id){
			return new Promise((resolve) =>{
				commit('ELIMINAR_SISTEMAS_USUARIO', id)
				resolve("Se Eliminó correctamente");
			})
		},

		limpiar_sistema_usuario({commit}){
			commit('LIMPIAR_SISTEMAS_USUARIO');
		},

		accesos_usuario_consulta({commit},id){
			return new Promise((resolve) => {
				Vue.http.get('consulta.accesos.usuario/'+ id).then( response =>{
					// console.log('accesos', response)
					commit('ACCESOS_USUARIOS_MODO2', response.body)
					resolve(response.body)
				}).catch(error =>{
					console.log('error accesos', error.body);
				})
			})
			
		},

		

  },

	getters:{
		Loading(state){
			return state.loading
		},

		getUsuarios(state){
		  return state.usuarios
		},
		
		getSistemasUsuario(state){
			return state.sistemas_usuario;
		},

		SistemasUsuarioAEdit(state){
			return state.accesosAEditar;
		}
		
	}
}