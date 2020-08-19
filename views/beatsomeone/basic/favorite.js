import Vue from 'vue'
import Detail_SimilarTracks from "./Detail_SimilarTracks";
import Detail_Comments from "./Detail_Comments";
import Detail_Infomation from "./Detail_Infomation";
import VueRouter  from 'vue-router';
// i18n
import i18n from '*/src/i18n/i18n'

import app from './Favorite.vue';
// register globally
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
  i18n,
  router,
  render: h => h(app),
}).$mount('#app')
