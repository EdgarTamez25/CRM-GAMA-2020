import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import VueResource from 'vue-resource'


Vue.config.productionTip = false;
Vue.use(VueResource)


Vue.http.options.root = 'http://127.0.0.1:8000/api/'
 
Vue.http.interceptors.push((request, next) => {
  request.headers.set('Accept', 'application/json')
  next()
});

new Vue({
  router,
  store,
  vuetify,
  render: function (h) { return h(App) }
}).$mount('#app')
