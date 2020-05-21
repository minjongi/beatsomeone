import Vue from 'vue'
import app from './main.vue';
// i18n
import i18n from '*/src/i18n/i18n'

window.vm = new Vue({
  i18n,
  router,
  render: h => h(app),
}).$mount('#app')
