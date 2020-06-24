import Vue from 'vue'
import VueRouter  from 'vue-router';

// i18n
import i18n from '*/src/i18n/i18n'
import app from './Seller.vue';

import Sellerlist from "./Sellerlist";
import Sellerbill from "./Sellerbill";

// 임시수정 개발 필요.
import SellerRegister from "./SellerRegister/Register_1";
// import Register_1 from "./SellerRegister/Register_1";
// import Register_2 from "./SellerRegister/Register_2";
// import Register_3 from "./SellerRegister/Register_3";
// import Register_4 from "./SellerRegister/Register_4";
// import Register_5 from "./SellerRegister/Register_5";
import Register_6 from "./SellerRegister/Register_6";
Vue.use(VueRouter);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    // { path: '/', component: SellerRegister},
    { path: '/', component: Sellerlist},
    { path: '/sellerbill', component: Sellerbill},
    { path: '/sellerregister', component: SellerRegister},
    // { path: '/sellerregister/1', component: Register_1 },
    // { path: '/sellerregister/2', component: Register_2 },
    // { path: '/sellerregister/3', component: Register_3 },
    // { path: '/sellerregister/4', component: Register_4 },
    // { path: '/sellerregister/5', component: Register_5 },
    { path: '/sellerregister/6', component: Register_6 },
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
