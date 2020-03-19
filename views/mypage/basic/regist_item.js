import Vue from 'vue'

import app from './Regist_item.vue';



Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

// window.onload = function () {
    window.vm = new Vue({
        render: h => h(app),
    }).$mount('#app')

// };
