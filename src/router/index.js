import Vue            from 'vue'
import VueRouter      from 'vue-router'
import store          from '@/store'
// import Login          from '@/views/AppController/Login.vue'
import Home 	        from '@/views/Home.vue'
import Inicio 	      from '@/views/Inicio.vue'

import Compromisos    from '@/views/Compromisos/CatCompromisos.vue'
import Solicitudes    from '@/views/Solicitudes/Solicitudes.vue'
import DetSolicitud   from '@/views/Solicitudes/DetSolicitud.vue'
import SolicitudesDDD    from '@/views/Solicitudes/SolicitudesDDD.vue'

// import ControldeFases from '@/views/Compromisos/controldeFases.vue'

Vue.use(VueRouter)

const routes = [
  { path:'/'				 , name: 'Inicio'       , component: Inicio        , meta: { libre:true }},
  { path:'/compromisos'          , name:'compromisos'           , component: Compromisos    , meta: { ADMIN:true, SUPER:true , SCLIENTE:true }},
  { path:'/solicitudes'          , name:'solicitudes'           , component: Solicitudes    , meta: { ADMIN:true, SUPER:true , SCLIENTE:true }},
  { path:'/detsolicitud'         , name:'detsolicitud'          , component: DetSolicitud   , meta: { ADMIN:true, SUPER:true , SCLIENTE:true }},
  { path:'/desarrollo/proyectos' , name:'desarrollo/proyectos'  , component: SolicitudesDDD , meta: { ADMIN:true, SUPER:true , SCLIENTE:true, DESARROLLO:true }},
  { path:'/usuarios'             , name:'usuarios'              , component:()=> import('@/views/Catalogos/Usuarios/CatUsuarios.vue')      , meta: { ADMIN: true, SUPER:true, SCLIENTE:false  }},
  { path:'/clientes'		         , name:'clientes'	            , component:()=> import('@/views/Catalogos/Clientes/CatClientes.vue')      , meta: { ADMIN: true, SUPER:true, SCLIENTE:true   }},
  { path:'/proveedores'		       , name:'proveedores'	          , component:()=> import('@/views/Catalogos/Proveedores/CatProveedores.vue'), meta: { ADMIN: true, SUPER:true, SCLIENTE:true   }},
  { path:'/productos-por-cliente', name:'productos-por-cliente'	, component:()=> import('@/views/Catalogos/Productos/ProductosxCli.vue')   , meta: { ADMIN: true, SUPER:true, SCLIENTE:true,  }},
  { path:'/ordenes-de-trabajo'   , name:'ordenes-de-trabajo'	  , component:()=> import('@/views/OT/ordenTrabajo.vue')                     , meta: { ADMIN: true, SUPER:true,  SCLIENTE:true  }},
  { path:'/monitor-master'       , name:'monitor-master'	      , component:()=> import('@/views/OT/Monitor.vue')                          , meta: { ADMIN: true, SUPER:true,  SCLIENTE:false }},
  { path:'/detalle-ot'           , name:'detalle-ot'	          , component:()=> import('@/views/OT/controlOT.vue')                        , meta: { ADMIN: true, SUPER:true,  SCLIENTE:true  }},
  
  // { path:'/:id'				       , name: 'Login'        , component: Login         , meta: { libre:true }},
  // { path:'/home'			     , name: 'Home'	        , component: Home          , meta: { ADMIN:true, SUPER:true,  VENTAS:true, SCLIENTE:true, VEND:true, CHOFER:true, EXTRA:true, DDD:true  }},
  // { path:'/productos'		   , name:'productos'	    , component:()=> import('@/views/Catalogos/Productos/CatProductos.vue')    , meta: { ADMIN: true, SUPER:true }},
  // { path:'/control_fases'  , name:'control_fases' , component: ControldeFases, meta: { ADMIN:true, SUPER:true  }},
  // { path:'/pendientes'	   , name:'pendientes'	  , component:()=> import('@/views/Pendientes/Pendientes.vue')               , meta: { ADMIN: true } },
  // { path:'/zonas-subzonas' , name:'zonas'	        , component:()=> import('@/views/Catalogos/Zonas/CatZonas.vue')            , meta: { ADMIN: true, SUPER:true }},
  // { path:'/monedas'	       , name:'monedas'	      , component:()=> import('@/views/Catalogos/Monedas/CatMonedas.vue')        , meta: { ADMIN: true, SUPER:true }},
  // { path:'/prospectos'     , name:'prospectos'    , component:()=> import('@/views/Catalogos/Prospectos/Prospectos.vue' )    , meta: { ADMIN: true, SUPER:true, SCLIENTE:true }},
  // { path:'/analisis-fases' , name:'analisis-fases', component:()=> import('@/views/Historial/analisisFases.vue')             , meta: { ADMIN: true, SUPER:true }},
  
]

const router = new VueRouter({
  mode:'history',
  base: process.env.BASE_URL,
  routes
})

// NIVELES DE ACCESO
// 1 => ADMINISTRADOR
// 2 => SUPERVISOR
// 3 => VENDEDOR
// 4 => SERVICIO AL CLIENTE
// 5 => PROGRAMACION 
// 6 => DESARROLLO
// 7 => RECURSOS HUMANOS
// 8 => PRODUCCION
// 9 => OPERADOR
// 10 => MEJORA CONTINUA 
// 11 => ALMACENISTA
// 12 => CHOFER
// 13 => SIN NIVEL

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
    if(to.matched.some(record => record.meta.SCLIENTE)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 5){
    if(to.matched.some(record => record.meta.PROGRA)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 6){
    if(to.matched.some(record => record.meta.DESARROLLO)){
      next()
    }
  }else if(store.state.Login.datosUsuario.nivel === 13){
    if(to.matched.some(record => record.meta.SNIVEL)){
      next()
    }
  }else{
    next({ name: 'Inicio'   })
  }
})

export default router
