import Vue from 'vue'

// i18n
import i18n from '*/src/i18n/i18n'
import app from './Mypage.vue';
import VueRouter  from 'vue-router';
import Dashboard from "./Dashboard.vue";
import Profilemod from "./Profilemod.vue";


Vue.use(VueRouter);


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        { path: '/', component: Dashboard},
        { path: '/profilemod', component: Profilemod},
    ],
});


window.vm = new Vue({
    i18n,
    router,
    render: h => h(app),
}).$mount('#app')
