<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container sub event-content" style="position: relative;">
          <div><img :src="'/assets/images/event/210110/' + $i18n.locale + '/p1.png?v=1'"></div>
          <div><a href="/register?t=pr#/3"><img :src="'/assets/images/event/210110/' + $i18n.locale + '/p2.png?v=1'"></a></div>
          <div><img :src="'/assets/images/event/210110/' + $i18n.locale + '/p3.png?v=1'"></div>
          <div><a href="/register?t=pr#/3"><img :src="'/assets/images/event/210110/' + $i18n.locale + '/p4.png?v=1'"></a></div>
          <div><img :src="'/assets/images/event/210110/' + $i18n.locale + '/p5.png?v=1'"></div>
        </div>
        <Footer />
    </div>
</template>

<script>
    import axios from "axios";

    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import {EventBus} from '*/src/eventbus';

    export default {
        name: 'Index',
        components: {Header, Footer},
        data: function () {
            return {
              isLogin: false
            }
        },
        mounted() {
            var qs, js, q, s, d = document, gi = d.getElementById, ce = d.createElement, gt = d.getElementsByTagName,
                id = "typef_orm", b = "https://embed.typeform.com/";
            if (!gi.call(d, id)) {
              js = ce.call(d, "script");
              js.id = id;
              js.src = b + "embed.js";
              q = gt.call(d, "script")[0];
              q.parentNode.insertBefore(js, q)
            }
        }
    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scope="scope" lang="css">
    .event-content {
        text-align:center;
    }
    .event-content img {
      margin: 0 auto;
      max-width:100%;
      display: block;
    }
</style>
