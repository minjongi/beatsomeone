import Vue from 'vue'

import Index from './Index.vue';


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);


new Vue({
  render: h => h(Index),
}).$mount('#app')
