import Vue from "vue";
import vSelect from 'vue-select';
import "bootstrap";
import $ from "jquery";
import i18n from '*/src/i18n/i18n';

import helper from '*/src/helper'
Vue.use(helper)

import app from "./Main.vue";
import VueRouter from "vue-router";

import Dashboard from "./pages/Dashboard";
import MemberModify from "./pages/MemberModify";
import OrderList from "./pages/OrderList";
import OrderView from "./pages/OrderView";
import InquiryList from "./pages/InquiryList";
import InquiryEnroll from "./pages/InquiryEnroll";
import Faq from "./pages/Faq";
import InquiryView from "./pages/InquiryView";
import SettlementHistory from "./pages/SettlementHistory";
import Chat from "./pages/Chat";

Vue.use(VueRouter);
Vue.component('v-select', vSelect);

const routes = [
    {
        path: '/',
        component: Dashboard
    },
    {
        path: '/membermodify',
        component: MemberModify
    },
    {
        path: '/orders',
        component: OrderList
    },
    {
        path: '/orders/:cor_id',
        component: OrderView,
    },
    {
        path: '/settlement',
        component: SettlementHistory
    },
    {
        path: '/message',
        component: Chat
    },
    {
        path: '/inquiry',
        component: InquiryList
    },
    {
        path: '/inquiry/:post_id',
        component: InquiryView
    },
    {
        path: '/inquiry/:post_id/edit',
        component: InquiryEnroll
    },
    {
        path: '/inquiryenroll',
        component: InquiryEnroll
    },
    {
        path: '/faq',
        component: Faq
    }
];

const router = new VueRouter({
    routes: routes
});

window.vm = new Vue({
    i18n,
    router,
    render: (h) => h(app),
}).$mount('#app');

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})