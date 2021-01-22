import Vue from 'vue'
import Vuex from "vuex";
import i18n from "*/src/i18n/i18n";

import helper from '*/src/helper'
Vue.use(helper)

import app from "./Purchase.vue";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        cartSum: 0,
        cartSumD: 0,
        userInfo: {}
    },
    mutations: {
        ADD_MONEY(state, payload) {
            state.cartSum = state.cartSum + payload.money;
            state.cartSumD = state.cartSumD + payload.money_d;
        },
        SET_USER_INFO(state, payload) {
            Object.assign(payload, state.userInfo);
        }
    },
    getters: {
        getCartSum(state) {
            return state.cartSum;
        },
        getCartSumD(state) {
            return state.cartSumD;
        },
        getUserInfo(state) {
            return state.userInfo;
        }
    },
    actions: {
        addMoney(context, moneyObject) {
            context.commit('ADD_MONEY', moneyObject);
        },
        setUserInfo(context, userInfo) {
            console.log(userInfo);
            context.commit('SET_USER_INFO', userInfo);
        }
    }
});

window.vm = new Vue({
    i18n,
    store,
    render: h => h(app),
}).$mount('#app')