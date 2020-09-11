import Vue from 'vue'

// i18n
import i18n from '*/src/i18n/i18n'
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
import Inquirymod from './Inquirymod.vue'
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
        { path: '/mybillingView', component: Mybillingview},
        { path: '/mycancelList', component: Mycancellist},
        { path: '/mycancelView', component: Mycancelview},
        { path: '/saleshistory', component: Saleshistory},
        { path: '/seller', component: Seller},
        { path: '/sellerbill', component: Sellerbill},
        { path: '/message', component: Message},
        { path: '/inquiry', component: Inquiry},
        { path: '/inquiryenroll', component: Inquiryenroll},
        { path: '/inquirymod', component: Inquirymod},
        { path: '/inquiryview', component: Inquiryview},
        { path: '/faq', component: Faq},
        { path: '/favorites', component: Favorites},
    ],
});


window.vm = new Vue({
    i18n,
    router,
    render: h => h(app),
}).$mount('#app')
