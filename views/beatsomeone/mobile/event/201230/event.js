import Vue from 'vue'
import Vuex from "vuex"

import app from './Event.vue';
// i18n
import i18n from '*/src/i18n/i18n'

Vue.use(Vuex)

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

import store from '*/vue/common/store'

window.vm = new Vue({
  i18n,
  store,
  render: h => h(app),
}).$mount('#app')
