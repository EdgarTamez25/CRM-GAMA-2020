import Vue     from 'vue'
import Vuex    from 'vuex'
import router  from '@/router'
import Login   from '@/modules/AppController/Login'
// CATALOGOS
import Usuarios    from '@/modules/Usuarios';
import Clientes    from '@/modules/Clientes';
import Zonas       from '@/modules/Zonas';
import Carteras    from '@/modules/Carteras';
import Monedas     from '@/modules/Monedas';
import Proveedores from '@/modules/Proveedores';
import Productos   from '@/modules/Productos';
import ProductosxCliente from '@/modules/ProductosxCliente';

import Precios     from '@/modules/Precios';
import Prospectos  from '@/modules/Prospectos';
// COMPROMISOS
import Compromisos from '@/modules/Compromisos';
import Solicitudes from '@/modules/Solicitudes';
import Movimientos from '@/modules/Movimientos';

import OT from '@/modules/OT';


Vue.use(Vuex)

export default new Vuex.Store({
  state: {
      usuario: '',
	    token: null,   
	    usuario: null,
	    nivel: null,
	    acuses:'',
	    drawer: true,
	    menu: true,
  },
  mutations: {
    setToken(state, token){
      state.token= token
    },
    setUsuario (state, usuario){
      state.usuario= usuario
    },
    setNivel (state, nivel){
      state.nivel=  nivel
    }
  },
  actions: {
    guardarToken({commit},token){
      commit("setToken", token)
      localStorage.setItem("tlaKey", token)
       var UsuarioActivo = decode.id 
       commit("setUsuario", UsuarioActivo)   // Decodifica el token para sacar usuario
    },

    guardarNivel({commit},nivel){
      commit('setNivel', nivel)

    },
    
    autoLogin({commit}){
    },

    salir({commit}){
      // commit("setUsuario", '')
      // commit("setToken", '')
      // localStorage.removeItem("tlaKey")
      // router.push({name: 'Login'})
      setTimeout(()=>{ window.location.href = "http://producciongama.com:8080/"; }, 2000)

    }
  },

  getters:{
		traeNomuser(state){
			return state.usuario
		},
		traeNivel(state){
			return state.nivel
		},

	},
  
  modules: {
    Login,
    Usuarios,
    Clientes,
    Zonas,
    Carteras,
    Monedas,
    Proveedores,
    Productos,
    Precios,
    Compromisos,
    Solicitudes,
    Prospectos,
    Movimientos,
    ProductosxCliente,
    OT
  }
})
