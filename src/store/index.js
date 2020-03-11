import Vue from 'vue'
import Vuex from 'vuex'


import Clientes from '@/modules/Clientes';
import Zonas    from '@/modules/Zonas';
import Carteras from '@/modules/Carteras';
import Monedas from '@/modules/Monedas';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  
  modules: {
    Clientes,
    Zonas,
    Carteras,
    Monedas
  }
})
