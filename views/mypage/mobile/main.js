import Vue from "vue";
import VueRouter from "vue-router";

import i18n from '*/src/i18n/i18n';
import app from "./Main.vue";
import Dashboard from "./pages/Dashboard";
import MemberModify from "./pages/MemberModify";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {path: '/', component: Dashboard},
        {
            path: '/membermodify',
            component: MemberModify
        }
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
        // {path: '/inquiry', component: Inquiry},
        // {path: '/inquiryenroll', component: Inquiryenroll},
        // {path: '/inquirymod', component: Inquirymod},
        // {path: '/inquiry/:post_id', component: Inquiryview},
        // {path: '/inquiry/:post_id/edit', component: Inquiryenroll},
        // {path: '/faq', component: Faq},
        // {path: '/favorites', component: Favorites},
    ],
});

window.vm = new Vue({
    i18n,
    router,
    render: (h) => h(app),
}).$mount('#app');