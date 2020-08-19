import Vue from 'vue'
import VueRouter  from 'vue-router'

import i18n from '*/src/i18n/i18n';
import app from './Video.vue';
import VideoList from "./VideoList.vue";
import VideoView from './VideoView.vue';

Vue.use(VueRouter);

Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
    routes: [
        {path: '/', component: VideoList},
        {path: '/:id', component: VideoView}
    ]
})


window.vm = new Vue({
    i18n,
    router,
    render: h => h(app),
}).$mount('#app')