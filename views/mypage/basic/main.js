import Vue from "vue";
import vSelect from 'vue-select';
import "bootstrap";
import i18n from '*/src/i18n/i18n';
import app from "./Main.vue";
import VueRouter from "vue-router";

import Dashboard from "./pages/Dashboard";
import MemberModify from "./pages/MemberModify";
import OrderList from "./pages/OrderList";
import OrderView from "./pages/OrderView";

Vue.use(VueRouter);
Vue.component('v-select', vSelect);

const routes = [
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
        path: '/orders/:cor_id',
        component: OrderView,
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