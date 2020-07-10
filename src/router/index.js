  import Vue from 'vue'
  import VueRouter from 'vue-router'
  import store from '@/store'

  import Login from '@/views/AppController/Login.vue'
  import Home 	   from '../views/Home.vue'
  import Compromisos from '@/views/Compromisos/CatCompromisos.vue'
  import ControlCompromiso from '@/views/Compromisos/ControlCompromiso.vue'
  import ControldeFases from '@/views/Compromisos/controldeFases.vue'

Vue.use(VueRouter)

const routes = [
  { path: '/'				    , name: 'Login', component: Login, meta: { libre: true}   },
  { path: '/home'			  , name: 'Home'		     , component: Home, meta: { ADMIN: true, SUPER:true} },
  { path:'/pendientes'	, name:'pendientes'	 , component:()=> import('@/views/Pendientes/Pendientes.vue'), 
    meta: { ADMIN: true }
  },
  // COMPROMISOS
  { path:'/compromisos'		    , name:'compromisos'	     , component: Compromisos,
    meta: { ADMIN: true , SUPER:true }
  },
  { path:'/control_compromiso', name:'control_compromiso', component: ControlCompromiso,
    meta: { ADMIN: true , SUPER:true }
  },
  { path:'/control_fases', name:'control_fases', component: ControldeFases,
    meta: { ADMIN: true , SUPER:true }
  },

  //USUARIOS
  { path:'/usuarios'		    , name:'usuarios'	      , component:()=> import('@/views/Catalogos/Usuarios/CatUsuarios.vue'), 
    meta: { ADMIN: true, USUARIO:true}  
  },
  { path:'/control-usuario'	, name:'control-usuario', component:()=> import('@/views/Catalogos/Usuarios/ControlUsuario.vue'),
    meta: { ADMIN: true , SUPER:true }},
  // CLIENTES
  { path:'/clientes'		    , name:'clientes'	      , component:()=> import('@/views/Catalogos/Clientes/CatClientes.vue'), meta: { ADMIN: true , SUPER:true }},
  { path:'/control-cliente'	, name:'control-cliente', component:()=> import('@/views/Catalogos/Clientes/ControlClientes.vue'), meta: { ADMIN: true , SUPER:true }},
  // PROVEEDOR
  { path:'/proveedores'		  , name:'proveedores'	   , component:()=> import('@/views/Catalogos/Proveedores/CatProveedores.vue'), meta: { ADMIN: true , SUPER:true }},
  { path:'/control-provedor', name:'control-provedor', component:()=> import('@/views/Catalogos/Proveedores/ControlProveedor.vue'), meta: { ADMIN: true , SUPER:true }},
  // PRODUCTOS
  { path:'/productos'		    , name:'productos'	      , component:()=> import('@/views/Catalogos/Productos/CatProductos.vue'), meta: { ADMIN: true , SUPER:true }},
  { path:'/control-producto', name:'control-producto', component:()=> import('@/views/Catalogos/Productos/ControlProductos.vue'), meta: { ADMIN: true , SUPER:true }},
  // ZONAS 
  { path:'/zonas-subzonas'	 , name:'zonas'	        , component:()=> import('@/views/Catalogos/Zonas/CatZonas.vue'), meta: { ADMIN: true , SUPER:true }},
  { path:'/control-zonas'    , name:'control-zonas' , component:()=> import('@/views/Catalogos/Zonas/ControlZonas.vue'), meta: { ADMIN: true , SUPER:true }},
  // CARTERAS
  // { path:'/carteras'	       , name:'carteras'	       , component:()=> import('@/views/Catalogos/Carteras/CatCarteras.vue'), meta: { ADMIN: true , SUPER:true }},
  // { path:'/control-carteras' , name:'control-carteras' , component:()=> import('@/views/Catalogos/Carteras/ControlCarteras.vue'),
  // MONEDAS
  { path:'/monedas'	        , name:'monedas'	       , component:()=> import('@/views/Catalogos/Monedas/CatMonedas.vue'), meta: { ADMIN: true , SUPER:true }},
  { path:'/control-mo nedas' , name:'control-monedas' , component:()=> import('@/views/Catalogos/Monedas/ControlMonedas.vue'), meta: { ADMIN: true , SUPER:true }},
  // HISTORIAL
  { path:'/analisis-fases' , name:'analisis-fases' ,  component:()=> import('@/views/Historial/analisisFases.vue'), meta: { ADMIN: true , SUPER:true }},

  { path: '/prospectos'     ,  name: 'prospectos',  component:()=> import('@/views/Catalogos/Prospectos/Prospectos.vue' ), meta: { ADMIN: true , SUPER:true }},

  // { path: '/prueba'     ,  name: 'prueba',  component: Prueba },
]

const router = new VueRouter({
  routes
})

// NIVELES DE ACCESO
// 1 => ADMINISTRADOR
// 2 => SUPERVISOR
// 3 => VENDEDOR
// 4 => CHOFER


router.beforeEach( (to, from, next) => {

  if(to.matched.some(record => record.meta.libre)){
    next()
  }else if(store.state.Login.datosUsuario.nivel === 1){
    if(to.matched.some(record => record.meta.ADMIN)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 2){
    if(to.matched.some(record => record.meta.SUPER)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 3){

    if(to.matched.some(record => record.meta.VEND)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 4){

    if(to.matched.some(record => record.meta.CHOFER)){
      next()
    }
  }else{

    next({
      name: 'Login'
    })
  }
})

export default router
