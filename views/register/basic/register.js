import Vue from 'vue'
import VueRouter from 'vue-router';
import Vuex from "vuex";

Vue.use(Vuex);

import app from './Register.vue';
// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

import Register_1 from "./Register_1";
import Register_2 from "./Register_2";
import Register_3 from "./Register_3";
import Register_4 from "./Register_4";
import Register_5 from "./Register_5";
import Register_7 from "./Register_7";
import Register_8 from "./Register_8";
import Register_9 from "./Register_9";
import PurchaseMembership from "./PurchaseMembership";

Vue.use(VueRouter);


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
    routes: [
        {path: '/',  component: Register_1},
        {path: '/2', component: Register_2},
        {path: '/3', component: Register_3},
        {path: '/4', component: Register_4},
        {path: '/5', component: Register_5},
        {path: '/7', component: Register_7},
        {path: '/8', component: Register_8},
        {path: '/9', component: Register_9},
    ],
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    }
});

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    router,
    store,
    render: h => h(app),
}).$mount('#app')
