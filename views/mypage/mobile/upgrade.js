import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
import VueRouter from "vue-router";
import "bootstrap";

import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

import app from "./Upgrade.vue";
import SelectGroup from "./pages/SelectGroup.vue";
import PayGroup from "./pages/PayGroup.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {path: '/', component: SelectGroup},
        {path: '/pay', component: PayGroup},
    ],
});

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    router,
    store,
    render: (h) => h(app),
}).$mount('#app');