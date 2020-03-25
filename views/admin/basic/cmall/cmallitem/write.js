import Vue from 'vue'
import app from './App.vue';

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

// window.onload = function () {
    window.vm = new Vue({

        render: h => h(app),
    }).$mount('#app')

// };
