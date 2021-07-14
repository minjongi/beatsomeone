import Vue from 'vue';
import Vuex from 'vuex';
import vSelect from 'vue-select';
// i18n
import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

Vue.component('v-select', vSelect);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);
Vue.use(Vuex);

import app from './Regist_item.vue';

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    store,
    render: h => h(app),
}).$mount('#app')
