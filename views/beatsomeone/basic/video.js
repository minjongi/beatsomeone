import Vue from 'vue'
import VueRouter  from 'vue-router'

import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

import app from './Video.vue';
import VideoList from "./VideoList.vue";
import VideoView from './VideoView.vue';
import VueClipboard from "vue-clipboard2";
import Vuex from "vuex";

VueClipboard.config.autoSetContainer = true;
Vue.use(VueRouter);
Vue.use(VueClipboard);
Vue.use(Vuex);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
    routes: [
        {path: '/', component: VideoList},
        {path: '/:id', component: VideoView}
    ]
})

const store = new Vuex.Store({
    state: {
        cartSum: 0,
        cartSumD: 0,
    },
    mutations: {
        ADD_MONEY(state, payload) {
            state.cartSum = state.cartSum + payload.money;
            state.cartSumD = state.cartSumD + payload.money_d;
        }
    },
    getters: {
        getCartSum(state) {
            return state.cartSum;
        },
        getCartSumD(state) {
            return state.cartSumD;
        }
    },
    actions: {
        // moneyObject: {money: 0, money_d: 0}
        addMoney(context, moneyObject) {
            context.commit('ADD_MONEY', moneyObject);
        }
    }
});

window.vm = new Vue({
    i18n,
    router,
    store,
    render: h => h(app),
}).$mount('#app')