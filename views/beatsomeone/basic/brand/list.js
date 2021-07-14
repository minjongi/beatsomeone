import Vue from 'vue';
import Vuex from "vuex";
import VueRouter  from 'vue-router'
import infiniteScroll from 'vue-infinite-scroll'
// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)
import VueClipboard from "vue-clipboard2";
import app from './list.vue';
// register globally

VueClipboard.config.autoSetContainer = true;
Vue.use(VueRouter);
Vue.use(infiniteScroll);
Vue.use(VueClipboard);
Vue.use(Vuex);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

import store from '*/vue/common/store'

window.vm = new Vue({
  i18n,
  store,
  render: h => h(app),
}).$mount('#app')
