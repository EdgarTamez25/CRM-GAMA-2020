import Vue from 'vue'
import Vuex from 'vuex'


import Clientes from '@/modules/Clientes';
import Zonas    from '@/modules/Zonas';


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
    Zonas
  }
})
