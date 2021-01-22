import Vue from 'vue'

// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

import app from './status_item.vue';


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);


window.vm = new Vue({
    i18n,
    render: h => h(app),
}).$mount('#app')
