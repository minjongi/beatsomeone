import Vue from 'vue'
import VueRouter  from 'vue-router';
import app from './cart.vue';
// i18n
import i18n from '*/src/i18n/i18n'

import cart_1 from "./cart";
import cart_2 from "./cart2";
import cart_3 from "./cart3";
Vue.use(VueRouter);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    { path: '/', component: cart},
    { path: '/2', component: cart2},
    { path: '/3', component: cart3},
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});


window.vm = new Vue({
  i18n,
  router,
  render: h => h(app),
}).$mount('#app')