import Vue from 'vue'

import {store} from '../../common/store'
import app from './Policy.vue';
// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);


window.vm = new Vue({
    i18n,
    store,
    render: h => h(app),
}).$mount('#app')
