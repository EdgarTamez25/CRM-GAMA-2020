import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import router from '@/router'

export default{
	namespaced: true,
	state:{
		usuarios: '',
		login:false,
	},

	mutations:{
		USUARIOS(state, value){
			state.usuarios = value
		},
	},
	actions:{
		CerrarSesion({commit}){
			commit('USUARIOS', '')
		},

  },

	getters:{
		getUsuarios(state){
		  return state.usuarios
		},
	}
}
