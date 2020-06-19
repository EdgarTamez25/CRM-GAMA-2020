import Vue from 'vue'
import Vuex from 'vuex'

// CATALOGOS
import Usuarios from '@/modules/Usuarios';
import Clientes from '@/modules/Clientes';
import Zonas    from '@/modules/Zonas';
import Carteras from '@/modules/Carteras';
import Monedas from '@/modules/Monedas';
import Proveedores from '@/modules/Proveedores';
import Productos from '@/modules/Productos';
import Precios from '@/modules/Precios';
import Prospectos from '@/modules/Prospectos';


// COMPROMISOS
import Compromisos from '@/modules/Compromisos';



Vue.use(Vuex)

export default new Vuex.Store({
  state: {
  },
  mutations: {
  },
  actions: {
  },
  
  modules: {
    Usuarios,
    Clientes,
    Zonas,
    Carteras,
    Monedas,
    Proveedores,
    Productos,
    Precios,
    Compromisos,
    Prospectos
  }
})
