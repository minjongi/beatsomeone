import Vue from 'vue';
import Vuex from 'vuex';

import app from './Beatsomeone.vue';
// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);
Vue.use(Vuex);

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    store,
    helper,
    render: h => h(app),
}).$mount('#app')
