import Vue from "vue";
import VueRouter from "vue-router";
import "bootstrap";

import i18n from '*/src/i18n/i18n';
import app from "./Main.vue";
import Dashboard from "./pages/Dashboard";
import MemberModify from "./pages/MemberModify";
import OrderList from "./pages/OrderList";
import InquiryList from './pages/InquiryList';
import InquiryView from "./pages/InquiryView";
import InquiryEnroll from "./pages/InquiryEnroll";
import Faq from "./pages/Faq";
import SettlementHistory from "./pages/SettlementHistory";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {path: '/', component: Dashboard},
        {
            path: '/membermodify',
            component: MemberModify
        },
        {
            path: '/orders',
            component: OrderList
        },
        {
            path: '/settlement',
            component: SettlementHistory
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
        },
        // {path: '/profilemod', component: Profilemod},
        // {path: '/list_item', component: ProductList},
        // {path: '/mybilling', component: Mybilling},
        // {path: '/mybilling/:cor_id', component: Mybillingview},
        // {path: '/mycancelList', component: Mycancellist},
        // {path: '/mycancelView', component: Mycancelview},
        // {path: '/saleshistory', component: Saleshistory},
        // {path: '/seller', component: Seller},
        // {path: '/sellerbill', component: Sellerbill},
        // {path: '/message', component: Message},
    ],
});

window.vm = new Vue({
    i18n,
    router,
    render: (h) => h(app),
}).$mount('#app');