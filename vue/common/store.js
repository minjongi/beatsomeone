import Vue from 'vue'
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        cartSum: 0,
        cartSumD: 0,
        cartSumJPY: 0,
        cartSumCNY: 0,
        refundObj: {},
        accountSetting: {
            bank_name: '',
            account_number: '',
            recipient: ''
        },
        userInfo: {}
    },
    mutations: {
        ADD_MONEY(state, payload) {
            console.log(payload)
            state.cartSum = state.cartSum + payload.money;
            state.cartSumD = state.cartSumD + payload.money_d;
            state.cartSumJPY = state.cartSumJPY + payload.money_jpy;
            state.cartSumCNY = state.cartSumCNY + payload.money_cny;
        },
        SET_REFUND_DATA(state, payload) {
            state.refundObj = payload;
        },
        SET_ACCOUNT_SETTING(state, payload) {
            state.accountSetting.bank_name = payload.bank_name;
            state.accountSetting.account_number = payload.account_number;
            state.accountSetting.recipient = payload.recipient;
        },
        SET_USER_INFO(state, payload) {
            Object.assign(payload, state.userInfo);
        },
        SET_USER_Offer(state, offer){
            state.userOffer = offer
        }
    },
    getters: {
        getCartSum(state) {
            return state.cartSum;
        },
        getCartSumD(state) {
            return state.cartSumD;
        },
        getCartSumJPY(state) {
            return state.cartSumJPY;
        },
        getCartSumCNY(state) {
            return state.cartSumCNY;
        },
        getRefundData(state) {
            return state.refundObj;
        },
        getAccountSetting(state) {
            return state.accountSetting;
        },
        getUserInfo(state) {
            return state.userInfo;
        },
        getUserOffer(state) {
            return state.userOffer;
        }
    },
    actions: {
        addMoney(context, moneyObject) {
            context.commit('ADD_MONEY', moneyObject);
        },
        setRefundData(context, refundObj) {
            context.commit('SET_REFUND_DATA', refundObj);
        },
        setAccountSetting(context, accountSetting) {
            context.commit('SET_ACCOUNT_SETTING', accountSetting);
        },
        setUserInfo(context, userInfo) {
            context.commit('SET_USER_INFO', userInfo);
        },
        setUserOffer(context, userOffer) {
            context.commit('SET_USER_Offer', userOffer);
        }
    }
});

export default store
