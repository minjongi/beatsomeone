import Vue from 'vue';
import Vuex from "vuex";
import Detail_SimilarTracks from "./Detail_SimilarTracks";
import Detail_Comments from "./Detail_Comments";
import Detail_Infomation from "./Detail_Infomation";
import VueRouter from 'vue-router';
// i18n
import i18n from '*/src/i18n/i18n'

import app from './Detail.vue';
// register globally
import infiniteScroll from 'vue-infinite-scroll'

Vue.use(infiniteScroll);
Vue.use(VueRouter);
Vue.use(Vuex);


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
    routes: [
        {path: '/', component: Detail_SimilarTracks},
        {path: '/comments', component: Detail_Comments},
        {path: '/infomation', component: Detail_Infomation},
    ],
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
    render: h => h(app),
}).$mount('#app')
