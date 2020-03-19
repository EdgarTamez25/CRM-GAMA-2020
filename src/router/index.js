import Vue from 'vue'
import VueRouter from 'vue-router'

import Home 	   from '../views/Home.vue'
import Compromisos from '@/views/Compromisos/CatCompromisos.vue'
import NuevoCompromiso from '@/views/Compromisos/NuevoCompromiso.vue'
import Pendientes  from '@/views/Pendientes/Pendientes.vue'

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
  // // PRECIOS
  // import CatPrecios    from '@/views/Catalogos/Precios/CatPrecios.vue';
  // import ControlPrecios from '@/views/Catalogos/Precios/ControlPrecios.vue';
  // CARTERAS
  import CatCarteras    from '@/views/Catalogos/Carteras/CatCarteras.vue';
  import ControlCarteras from '@/views/Catalogos/Carteras/ControlCarteras.vue';
  // MONEDAS
  import CatMonedas     from '@/views/Catalogos/Monedas/CatMonedas.vue';
  import ControlMonedas from '@/views/Catalogos/Monedas/ControlMonedas.vue';
  // PRECIOS
  import CatPrecios     from '@/views/Administracion/Precios/CatPrecios.vue';
  import ControlPrecios from '@/views/Administracion/Precios/ControlPrecios.vue';


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
  // PROVEEDOR
  { path:'/proveedores'		  , name:'proveedores'	   , component: CatProveedores},
  { path:'/control-provedor', name:'control-provedor', component: ControlProveedor},
  // PRODUCTOS
  { path:'/productos'		    , name:'productos'	      , component: CatProductos},
  { path:'/control-producto', name:'control-producto', component: ControlProductos},
  // ZONAS Y SUBZONAS
  { path:'/zonas-subzonas'	 , name:'zonas'	        , component: CatZonas},
  { path:'/control-zonas'    , name:'control-zonas' , component: ControlZonas},
  // CARTERAS
  { path:'/carteras'	       , name:'carteras'	       , component: CatCarteras},
  { path:'/control-carteras' , name:'control-carteras' , component: ControlCarteras},
  // MONEDAS
  { path:'/monedas'	        , name:'monedas'	       , component: CatMonedas},
  { path:'/control-monedas' , name:'control-monedas' , component: ControlMonedas},
  // PRECIOS
  { path:'/precios'	        , name:'precios'	       , component: CatPrecios},
  { path:'/control-precios' , name:'control-precios' , component: ControlPrecios},


]

const router = new VueRouter({
  routes
})

export default router
