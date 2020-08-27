import Vue from "vue";
import "bootstrap";
import i18n from '*/src/i18n/i18n';
import app from "./Mypage.vue";
import VueRouter from "vue-router";

import Dashboard from "./Dashboard";

Vue.use(VueRouter);

const routes = [
    {path: '/', component: Dashboard},
];

const router = new VueRouter({
    routes: routes
});

window.vm = new Vue({
    i18n,
    router,
    render: (h) => h(app),
}).$mount('#app');