import Vue from 'vue'
import VueRouter  from 'vue-router';

// i18n
import i18n from '*/src/i18n/i18n'
import app from './Inquiry.vue';

import Inquirylist from "./Inquirylist";
import Inquiryview from "./Inquiryview";
import Inquirymod from "./Inquirymod";
import Inquiryenroll from "./Inquiryenroll";
Vue.use(VueRouter);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    { path: '/', component: Inquirylist},
    { path: '/inquiryview', component: Inquiryview},
    { path: '/inquirymod', component: Inquirymod},
    { path: '/Inquiryenroll', component: Inquiryenroll},
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
