import Vue from 'vue'
import Vuex from "vuex";
import i18n from "*/src/i18n/i18n";

import helper from '*/src/helper'
Vue.use(helper)

import app from "./Purchase.vue";

Vue.use(Vuex);

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    store,
    render: h => h(app),
}).$mount('#app')