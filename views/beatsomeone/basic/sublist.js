import Vue from 'vue';
import Vuex from "vuex";
import infiniteScroll from 'vue-infinite-scroll'
// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

import app from './Sublist.vue';
// register globally

Vue.use(infiniteScroll);
Vue.use(Vuex);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    store,
    render: h => h(app),
}).$mount('#app')
