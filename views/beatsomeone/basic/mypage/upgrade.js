import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

import app from "./Upgrade.vue";
import VueRouter from "vue-router";

import SelectGroup from "./SelectGroup.vue";
import PurchaseMembership from "./PurchaseMembership";

Vue.use(VueRouter);

const routes = [
    {path: '/', component: SelectGroup},
    {path: '/pay', component: PurchaseMembership},
];

const router = new VueRouter({
    routes: routes
});

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    router,
    store,
    render: (h) => h(app),
}).$mount('#app');