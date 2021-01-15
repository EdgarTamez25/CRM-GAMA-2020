import Vue            from 'vue'
import VueRouter      from 'vue-router'
import store          from '@/store'
import Login          from '@/views/AppController/Login.vue'
import Home 	        from '../views/Home.vue'
import Compromisos    from '@/views/Compromisos/CatCompromisos.vue'
import Solicitudes    from '@/views/Solicitudes/Solicitudes.vue'
import DetSolicitud   from '@/views/Solicitudes/DetSolicitud.vue'
import SolicitudesDDD    from '@/views/Solicitudes/SolicitudesDDD.vue'

import ControldeFases from '@/views/Compromisos/controldeFases.vue'

Vue.use(VueRouter)

const routes = [
  { path:'/'				       , name: 'Login'        , component: Login         , meta: { libre:true }},
  { path:'/home'			     , name: 'Home'	        , component: Home          , meta: { ADMIN:true, SUPER:true, ALMACEN:true, VENTAS:true, SCLIENTE:true, VEND:true, CHOFER:true, EXTRA:true, DDD:true  }},
  { path:'/compromisos'    , name:'compromisos'   , component: Compromisos   , meta: { ADMIN:true, SUPER:true, ALMACEN:true, VENTAS:true, SCLIENTE:true }},
  { path:'/solicitudes'    , name:'solicitudes'   , component: Solicitudes   , meta: { ADMIN:true, SUPER:true, ALMACEN:true, VENTAS:true, SCLIENTE:true }},
  { path:'/detsolicitud'   , name:'detsolicitud'  , component: DetSolicitud  , meta: { ADMIN:true, SUPER:true, ALMACEN:true, VENTAS:true, SCLIENTE:true }},
  { path:'/desarrollo/proyectos' , name:'desarrollo/proyectos'   , component: SolicitudesDDD   , meta: { ADMIN:true, SUPER:true, ALMACEN:true, VENTAS:true, SCLIENTE:true, DDD:true }},
  { path:'/control_fases'  , name:'control_fases' , component: ControldeFases, meta: { ADMIN:true, SUPER:true, ALMACEN:true, VENTAS:true }},
  // { path:'/pendientes'	   , name:'pendientes'	  , component:()=> import('@/views/Pendientes/Pendientes.vue')               , meta: { ADMIN: true } },
  { path:'/usuarios'       , name:'usuarios'      , component:()=> import('@/views/Catalogos/Usuarios/CatUsuarios.vue')      , meta: { ADMIN: true, SUPER:true } },
  { path:'/clientes'		   , name:'clientes'	    , component:()=> import('@/views/Catalogos/Clientes/CatClientes.vue')      , meta: { ADMIN: true, SUPER:true, SCLIENTE:true }},
  { path:'/proveedores'		 , name:'proveedores'	  , component:()=> import('@/views/Catalogos/Proveedores/CatProveedores.vue'), meta: { ADMIN: true, SUPER:true, SCLIENTE:true }},
  { path:'/productos'		   , name:'productos'	    , component:()=> import('@/views/Catalogos/Productos/CatProductos.vue')    , meta: { ADMIN: true, SUPER:true }},
  { path:'/productos-por-cliente', name:'productos-por-cliente'	, component:()=> import('@/views/Catalogos/Productos/ProductosxCli.vue')    , meta: { ADMIN: true, SUPER:true, SCLIENTE:true, }},
  { path:'/ordenes-de-trabajo'   , name:'ordenes-de-trabajo'	  , component:()=> import('@/views/OT/ordenTrabajo.vue')    , meta: { ADMIN: true, SUPER:true,  SCLIENTE:true }},
  { path:'/detalle-ot'           , name:'detalle-ot'	          , component:()=> import('@/views/OT/controlOT.vue')       , meta: { ADMIN: true, SUPER:true,  SCLIENTE:true }},


  { path:'/zonas-subzonas' , name:'zonas'	        , component:()=> import('@/views/Catalogos/Zonas/CatZonas.vue')            , meta: { ADMIN: true, SUPER:true }},
  { path:'/monedas'	       , name:'monedas'	      , component:()=> import('@/views/Catalogos/Monedas/CatMonedas.vue')        , meta: { ADMIN: true, SUPER:true }},
  { path:'/prospectos'     , name:'prospectos'    , component:()=> import('@/views/Catalogos/Prospectos/Prospectos.vue' )    , meta: { ADMIN: true, SUPER:true, SCLIENTE:true }},
  // { path:'/analisis-fases' , name:'analisis-fases', component:()=> import('@/views/Historial/analisisFases.vue')             , meta: { ADMIN: true, SUPER:true }},
  
]

const router = new VueRouter({
  mode:'history',
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
  }else if(store.state.Login.datosUsuario.nivel === 5){
    if(to.matched.some(record => record.meta.ALMACEN)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 6){
    if(to.matched.some(record => record.meta.VENTAS)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 7){
    if(to.matched.some(record => record.meta.SCLIENTE)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 8){
    if(to.matched.some(record => record.meta.EXTRA)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 9){
    if(to.matched.some(record => record.meta.DDD)){
      next()
    }
  }else{
    next({
      name: 'Login'
    })
  }
})

export default router
