import Vue from 'vue'

import app from './Sublist.vue';

// register globally
import infiniteScroll from 'vue-infinite-scroll'
Vue.use(infiniteScroll);
Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);


window.vm = new Vue({
  render: h => h(app),
}).$mount('#app')
