<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container sub event-content" style="position: relative;">
          <div style="position: absolute;left: 50%;margin-left: -325px;" :style="$i18n.locale === 'ko' ? 'top: 1110px;' : 'top: 1060px;'">
            <iframe width="650" height="365" src="https://www.youtube.com/embed/d7tfADQU3J0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <div><img :src="'/assets/images/event/201230/' + $i18n.locale + '/p1.png'"></div>
          <div><a :href="helper.langUrl($i18n.locale, '/register?t=pr#/3')"><img :src="'/assets/images/event/201230/' + $i18n.locale + '/p2.png'"></a></div>
          <div><img :src="'/assets/images/event/201230/' + $i18n.locale + '/p3.png'"></div>
          <div><a :href="helper.langUrl($i18n.locale, '/register?t=pr#/3')"><img :src="'/assets/images/event/201230/' + $i18n.locale + '/p4.png'"></a></div>
          <div><img :src="'/assets/images/event/201230/' + $i18n.locale + '/p5.png'"></div>
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
