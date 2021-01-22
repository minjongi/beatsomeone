import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";
Vue.use(Vuex);
Vue.use(VueRouter);

import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

import app from "./Upgrade.vue";

import SelectGroup from "./SelectGroup.vue";
import PurchaseMembership from "./PurchaseMembership";

const routes = [
    {path: '/', component: SelectGroup},
    {path: '/pay', component: PurchaseMembership},
];

const router = new VueRouter({
    routes: routes
});

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
    render: (h) => h(app),
}).$mount('#app');