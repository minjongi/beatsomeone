import Vue from 'vue'
import VueRouter  from 'vue-router';

// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

import app from './Sellerreg.vue';

import Sellerregform from "./Sellerregform";

Vue.use(VueRouter);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    { path: '/', component: Sellerregform}
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
