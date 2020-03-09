import Vue from 'vue'
import VueRouter from 'vue-router'

import Home 	   from '../views/Home.vue'
import Compromisos from '@/views/Compromisos/CatCompromisos.vue'
import NuevoCompromiso from '@/views/Compromisos/NuevoCompromiso.vue'
import Pendientes  from '@/views/Pendientes/Pendientes.vue'

// CATALOGOS
import CatUsuarios    from '@/views/Catalogos/Usuarios/CatUsuarios.vue';
import ControlUsuario from '@/views/Catalogos/Usuarios/ControlUsuario.vue';


// import Pruebas  from '@/views/Pruebas.vue'


Vue.use(VueRouter)

const routes = [
  { path: '/'				 , name: 'Home'		     , component: Home },
  { path:'/compromisos'		 , name:'compromisos'	 , component: Compromisos},
  { path:'/Nuevo_Compromisos', name:'nuevocompromiso', component: NuevoCompromiso},
  { path:'/pendientes'		 , name:'pendientes'	 , component: Pendientes},

  //CATALOGOS
  { path:'/usuarios'		    , name:'usuarios'	      , component: CatUsuarios},
  { path:'/control-usuario'	, name:'control-usuario', component: ControlUsuario},



  // { path:'/pruebas'		 , name:'pruebas'	 , component: Pruebas},


]

const router = new VueRouter({
  routes
})

export default router
