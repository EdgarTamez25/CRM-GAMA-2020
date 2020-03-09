import Vue from 'vue'
import VueRouter from 'vue-router'

import Home 	   from '../views/Home.vue'
import Compromisos from '@/views/Compromisos/CatCompromisos.vue'
import NuevoCompromiso from '@/views/Compromisos/NuevoCompromiso.vue'
import Pendientes  from '@/views/Pendientes/Pendientes.vue'

  // VISTAS -> USUARIO
  import CatUsuarios    from '@/views/Catalogos/Usuarios/CatUsuarios.vue';
  import ControlUsuario from '@/views/Catalogos/Usuarios/ControlUsuario.vue';
  // VISTAS -> CLIENTE
  import CatClientes    from '@/views/Catalogos/Clientes/CatClientes.vue';
  import ControlCliente from '@/views/Catalogos/Clientes/ControlClientes.vue';
  // VISTAS -> PRODUCTOS
  import CatProductos    from '@/views/Catalogos/Productos/CatProductos.vue';
  import ControlProductos from '@/views/Catalogos/Productos/ControlProductos.vue';
  // VISTAS -> ZONAS
  import CatZonas    from '@/views/Catalogos/Zonas/CatZonas.vue';
  import ControlZonas from '@/views/Catalogos/Zonas/ControlZonas.vue';
  // VISTAS -> PRECIOS
  import CatPrecios    from '@/views/Catalogos/Precios/CatPrecios.vue';
  import ControlPrecios from '@/views/Catalogos/Precios/ControlPrecios.vue';
  // VISTAS -> CARTERAS
  import CatCarteras    from '@/views/Catalogos/Carteras/CatCarteras.vue';
  import ControlCarteras from '@/views/Catalogos/Carteras/ControlCarteras.vue';
  // VISTAS -> MONEDAS
  import CatMonedas     from '@/views/Catalogos/Monedas/CatMonedas.vue';
  import ControlMonedas from '@/views/Catalogos/Monedas/ControlMonedas.vue';
  // VISTAS -> COSTOS INDIRECTOS
  import CatCostosIndirectos     from '@/views/Catalogos/Costos_Indirectos/CatCostosIndirectos.vue';
  import ControlCostosIndirectos from '@/views/Catalogos/Costos_Indirectos/ControlCostosIndirectos.vue';
  // VISTAS -> MANOS DE OBRA
  import CatManosdeObra     from '@/views/Catalogos/Manos_de_obra/CatManosdeObra.vue';
  import ControlManosdeObra from '@/views/Catalogos/Manos_de_obra/ControlManosdeObra.vue';

Vue.use(VueRouter)

const routes = [
  { path: '/'				 , name: 'Home'		     , component: Home },
  { path:'/compromisos'		 , name:'compromisos'	 , component: Compromisos},
  { path:'/Nuevo_Compromisos', name:'nuevocompromiso', component: NuevoCompromiso},
  { path:'/pendientes'		 , name:'pendientes'	 , component: Pendientes},

  //USUARIOS
  { path:'/usuarios'		    , name:'usuarios'	      , component: CatUsuarios},
  { path:'/control-usuario'	, name:'control-usuario', component: ControlUsuario},
  // CLIENTES
  { path:'/clientes'		    , name:'clientes'	      , component: CatClientes},
  { path:'/control-cliente'	, name:'control-cliente', component: ControlCliente},
  // PRODUCTOS
  { path:'/productos'		    , name:'productos'	      , component: CatProductos},
  { path:'/control-producto', name:'control-producto', component: ControlProductos},
  // ZONAS Y SUBZONAS
  { path:'/zonas-subzonas'	 , name:'zonas'	        , component: CatZonas},
  { path:'/control-zonas'    , name:'control-zonas' , component: ControlZonas},
  // PRECIOS
  { path:'/precios'	        , name:'precios'	        , component: CatPrecios},
  { path:'/control-precios' , name:'control-precios' , component: ControlPrecios},
  // CARTERAS
  { path:'/carteras'	       , name:'carteras'	       , component: CatCarteras},
  { path:'/control-carteras' , name:'control-carteras' , component: ControlCarteras},
  // MONEDAS
  { path:'/monedas'	        , name:'monedas'	       , component: CatMonedas},
  { path:'/control-monedas' , name:'control-monedas' , component: ControlMonedas},
  // COSTOS INDIRECTOS
  { path:'/costos-indirectos'         , name:'costos-indirectos'	       , component: CatCostosIndirectos},
  { path:'/control-costos-indirectos' , name:'control-costos-indirectos' , component: ControlCostosIndirectos},
  // MANOS DE OBRA
  { path:'/manos-de-obra'	        , name:'manos-de-obra'	       , component: CatManosdeObra},
  { path:'/control-manos-de-obra' , name:'control-manos-de-obra' , component: ControlManosdeObra},

]

const router = new VueRouter({
  routes
})

export default router
