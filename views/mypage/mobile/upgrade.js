import Vue from "vue";
import VueRouter from "vue-router";

import i18n from '*/src/i18n/i18n';
import app from "./App.vue";
import Dashboard from "./pages/Dashboard";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {path: '/', component: Dashboard},
    ],
});

window.vm = new Vue({
    i18n,
    router,
    render: (h) => h(app),
}).$mount('#app');