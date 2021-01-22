import Vue from 'vue';
import Vuex from "vuex";
import vSelect from 'vue-select';
Vue.use(Vuex);
Vue.component('v-select', vSelect);

// i18n
import i18n from '*/src/i18n/i18n'

import helper from '*/src/helper'
Vue.use(helper)

import app from './Mypage.vue'
import VueRouter  from 'vue-router'
import Dashboard from "./Dashboard.vue"
import Profilemod from "./Profilemod.vue"
import List_item from './List_item.vue'
import Mybilling from './Mybilling.vue'
import Mybillingview from './Mybillingview.vue'
import Mycancellist from './Mycancellist.vue'
import Mycancelview from './Mycancelview.vue'
import Saleshistory from './Saleshistory.vue'
import Seller from './Seller.vue'
import Sellerbill from './Sellerbill.vue'
import Message from './Message.vue'
import Inquiry from './Inquiry.vue'
import Inquiryenroll from './Inquiryenroll.vue'
import Inquiryview from './Inquiryview.vue'
import Faq from './Faq.vue'
import Favorites from "./FavoritesOld.vue"

Vue.use(VueRouter);

import infiniteScroll from 'vue-infinite-scroll'
Vue.use(infiniteScroll);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        { path: '/', component: Dashboard},
        { path: '/profilemod', component: Profilemod},
        { path: '/list_item', component: List_item},
        { path: '/mybilling', component: Mybilling},
        { path: '/mybilling/:cor_id', component: Mybillingview },
        { path: '/mycancelList', component: Mycancellist},
        { path: '/mycancelList/:cor_id', component: Mycancelview },
        { path: '/saleshistory', component: Saleshistory},
        { path: '/seller', component: Seller},
        { path: '/sellerbill', component: Sellerbill},
        { path: '/message', component: Message},
        { path: '/inquiry', component: Inquiry},
        { path: '/inquiryenroll', component: Inquiryenroll},
        { path: '/inquiry/:post_id', component: Inquiryview},
        { path: '/inquiry/:post_id/edit', component: Inquiryenroll},
        { path: '/faq', component: Faq},
        { path: '/favorites', component: Favorites},
    ],
});

const store = new Vuex.Store({
    state: {
        cartSum: 0,
        cartSumD: 0,
        refundObj: {},
        accountSetting: {
            bank_name: '',
            account_number: '',
            recipient: ''
        }
    },
    mutations: {
        ADD_MONEY(state, payload) {
            state.cartSum = state.cartSum + payload.money;
            state.cartSumD = state.cartSumD + payload.money_d;
        },
        SET_REFUND_DATA(state, payload) {
            state.refundObj = payload;
        },
        SET_ACCOUNT_SETTING(state, payload) {
            state.accountSetting.bank_name = payload.bank_name;
            state.accountSetting.account_number = payload.account_number;
            state.accountSetting.recipient = payload.recipient;
        }
    },
    getters: {
        getCartSum(state) {
            return state.cartSum;
        },
        getCartSumD(state) {
            return state.cartSumD;
        },
        getRefundData(state) {
            return state.refundObj;
        },
        getAccountSetting(state) {
            return state.accountSetting;
        }
    },
    actions: {
        // moneyObject: {money: 0, money_d: 0}
        addMoney(context, moneyObject) {
            context.commit('ADD_MONEY', moneyObject);
        },
        setRefundData(context, refundObj) {
            context.commit('SET_REFUND_DATA', refundObj);
        },
        setAccountSetting(context, accountSetting) {
            context.commit('SET_ACCOUNT_SETTING', accountSetting);
        },
    }
});


window.vm = new Vue({
    i18n,
    router,
    store,
    render: h => h(app),
}).$mount('#app')
