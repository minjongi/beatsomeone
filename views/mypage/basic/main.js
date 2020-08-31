import Vue from "vue";
import "bootstrap";
import i18n from '*/src/i18n/i18n';
import app from "./Main.vue";
import VueRouter from "vue-router";

import Dashboard from "./pages/Dashboard";
import MemberModify from "./pages/MemberModify";

Vue.use(VueRouter);

const routes = [
    {path: '/', component: Dashboard},
    {
        path: '/membermodify',
        component: MemberModify
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