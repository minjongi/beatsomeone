import Vue from 'vue'
import VueRouter  from 'vue-router';

// i18n
import i18n from '*/src/i18n/i18n'
import app from './Mybilling.vue';

import Mybillinglist from "./Mybillinglist";
import Mybillingview from "./Mybillingview";
import Mycancellist from "./Mycancellist";
import Mycancelview from "./Mycancelview";
Vue.use(VueRouter);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    { path: '/', component: Mybillinglist},
    { path: '/mybillingview', component: Mybillingview},
    { path: '/mycancellist', component: Mycancellist},
    { path: '/mycancelview', component: Mycancelview},
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
