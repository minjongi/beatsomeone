import Vue from 'vue'

// i18n
import i18n from '*/src/i18n/i18n'
import app from './Mypage.vue';
import VueRouter  from 'vue-router';
import Dashboard from "./Dashboard.vue";
import Profilemod from "./Profilemod.vue";
import Favorites from "./Favorites.vue";

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
        { path: '/favorites', component: Favorites},
    ],
});

window.vm = new Vue({
    i18n,
    router,
    render: h => h(app),
}).$mount('#app')
