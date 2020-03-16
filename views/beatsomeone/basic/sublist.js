import Vue from 'vue'

import app from './Sublist.vue';


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);


new Vue({
  render: h => h(app),
}).$mount('#app')
