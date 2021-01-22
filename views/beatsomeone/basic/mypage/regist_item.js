import Vue from 'vue';
import Vuex from 'vuex';
import vSelect from 'vue-select';
// i18n
import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

Vue.component('v-select', vSelect);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);
Vue.use(Vuex);

import app from './Regist_item.vue';

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
    store,
    render: h => h(app),
}).$mount('#app')
