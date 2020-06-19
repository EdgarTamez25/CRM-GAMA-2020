  import Vue from 'vue'
  import VueRouter from 'vue-router'

  import Home 	   from '../views/Home.vue'
  import Pendientes  from '@/views/Pendientes/Pendientes.vue'
 
  import Compromisos from '@/views/Compromisos/CatCompromisos.vue'
  import ControlCompromiso from '@/views/Compromisos/ControlCompromiso.vue'
  import ControldeFases from '@/views/Compromisos/controldeFases.vue'


  // USUARIO
  import CatUsuarios    from '@/views/Catalogos/Usuarios/CatUsuarios.vue';
  import ControlUsuario from '@/views/Catalogos/Usuarios/ControlUsuario.vue';
  // CLIENTE
  import CatClientes    from '@/views/Catalogos/Clientes/CatClientes.vue';
  import ControlCliente from '@/views/Catalogos/Clientes/ControlClientes.vue';
  // PROVEDOR
  import CatProveedores   from '@/views/Catalogos/Proveedores/CatProveedores.vue';
  import ControlProveedor from '@/views/Catalogos/Proveedores/ControlProveedor.vue';
  // PRODUCTOS
  import CatProductos    from '@/views/Catalogos/Productos/CatProductos.vue';
  import ControlProductos from '@/views/Catalogos/Productos/ControlProductos.vue';
  // ZONAS
  import CatZonas    from '@/views/Catalogos/Zonas/CatZonas.vue';
  import ControlZonas from '@/views/Catalogos/Zonas/ControlZonas.vue';
  // CARTERAS
  import CatCarteras    from '@/views/Catalogos/Carteras/CatCarteras.vue';
  import ControlCarteras from '@/views/Catalogos/Carteras/ControlCarteras.vue';
  // MONEDAS
  import CatMonedas     from '@/views/Catalogos/Monedas/CatMonedas.vue';
  import ControlMonedas from '@/views/Catalogos/Monedas/ControlMonedas.vue';

  // import Calendario from '@/views/Calendario.vue';
  import analisisFases from '@/views/Historial/analisisFases.vue';
  import Prospectos from '@/views/Catalogos/Prospectos/Prospectos.vue';

  import Prueba from '@/views/Prueba.vue';


  

Vue.use(VueRouter)

const routes = [
  // { path: '/calendario'				 , name: 'calendario'		     , component: Calendario },
  { path: '/'				 , name: 'Home'		     , component: Home },
  { path:'/pendientes'		 , name:'pendientes'	 , component: Pendientes},

  // COMPROMISOS
  { path:'/compromisos'		    , name:'compromisos'	     , component: Compromisos},
  { path:'/control_compromiso', name:'control_compromiso', component: ControlCompromiso},
  { path:'/control_fases', name:'control_fases', component: ControldeFases},

  //USUARIOS
  { path:'/usuarios'		    , name:'usuarios'	      , component: CatUsuarios},
  { path:'/control-usuario'	, name:'control-usuario', component: ControlUsuario},
  // CLIENTES
  { path:'/clientes'		    , name:'clientes'	      , component: CatClientes},
  { path:'/control-cliente'	, name:'control-cliente', component: ControlCliente},
  // PROVEEDOR
  { path:'/proveedores'		  , name:'proveedores'	   , component: CatProveedores},
  { path:'/control-provedor', name:'control-provedor', component: ControlProveedor},
  // PRODUCTOS
  { path:'/productos'		    , name:'productos'	      , component: CatProductos},
  { path:'/control-producto', name:'control-producto', component: ControlProductos},
  // ZONAS 
  { path:'/zonas-subzonas'	 , name:'zonas'	        , component: CatZonas},
  { path:'/control-zonas'    , name:'control-zonas' , component: ControlZonas},
  // CARTERAS
  { path:'/carteras'	       , name:'carteras'	       , component: CatCarteras},
  { path:'/control-carteras' , name:'control-carteras' , component: ControlCarteras},
  // MONEDAS
  { path:'/monedas'	        , name:'monedas'	       , component: CatMonedas},
  { path:'/control-monedas' , name:'control-monedas' , component: ControlMonedas},
  // HISTORIAL
  { path:'/analisis-fases' , name:'analisis-fases' , component: analisisFases},

  { path: '/prospectos'     ,  name: 'prospectos',  component: Prospectos },

  { path: '/prueba'     ,  name: 'prueba',  component: Prueba },




  
  // // COSTOS INDIRECTOS
  // { path:'/costos-indirectos'         , name:'costos-indirectos'	       , component: CatCostosIndirectos},
  // { path:'/control-costos-indirectos' , name:'control-costos-indirectos' , component: ControlCostosIndirectos},
  // MANOS DE OBRA
  // { path:'/manos-de-obra'	        , name:'manos-de-obra'	       , component: CatManosdeObra},
  // { path:'/control-manos-de-obra' , name:'control-manos-de-obra' , component: ControlManosdeObra},

]

const router = new VueRouter({
  routes
})

export default router
