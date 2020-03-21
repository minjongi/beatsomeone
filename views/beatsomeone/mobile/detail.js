import Vue from 'vue'
import Detail_SimilarTracks from "./Detail_SimilarTracks";
import Detail_Comments from "./Detail_Comments";
import Detail_Infomation from "./Detail_Infomation";
import VueRouter  from 'vue-router';

import app from './Detail.vue';

Vue.use(VueRouter);


Vue.config.productionTip = false;
Vue.prototype.$log = console.log.bind(console);

const router = new VueRouter({
  routes: [
    { path: '/', component: Detail_SimilarTracks},
    { path: '/comments', component: Detail_Comments},
    { path: '/infomation', component: Detail_Infomation},
  ],
});

window.vm = new Vue({
  router,
  render: h => h(app),
}).$mount('#app')
