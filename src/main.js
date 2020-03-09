import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';

Vue.config.productionTip = false

// Vue.http.options.root = 'http://localhost:80/ProyectosGit/petbarbershop/api2/public/'

// Vue.http.interceptors.push((request, next) => {
//   request.headers.set('Accept', 'application/json')
//   next()
// });

new Vue({
  router,
  store,
  vuetify,
  render: function (h) { return h(App) }
}).$mount('#app')
