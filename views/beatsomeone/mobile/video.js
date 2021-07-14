import Vue from 'vue'
import VueRouter  from 'vue-router';
import VueClipboard from 'vue-clipboard2';
import Vuex from "vuex";


// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

import app from './Video.vue';

import Videolist from "./Videolist";
import Videoview from "./Videoview";

VueClipboard.config.autoSetContainer = true;
Vue.use(VueRouter);
Vue.use(VueClipboard);
Vue.use(Vuex);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    { path: '/', component: Videolist},
    { path: '/:id', component: Videoview},
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

import store from '*/vue/common/store'

window.vm = new Vue({
    i18n,
    router,
    store,
    render: h => h(app),
}).$mount('#app')
