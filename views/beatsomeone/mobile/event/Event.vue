<template>
    <div>
        <div class="wrapper">
            <Header :is-login="isLogin"></Header>
            <div class="container sub event-content">

              <div><img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p1_1.png'"></div>
              <div style="position: relative;">
                <div style="position: absolute;margin: 0 auto;">
                  <iframe style="width:86vw;height:48vw;margin: 0 7vw;" src="https://www.youtube.com/embed/d7tfADQU3J0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p1_2.png'">
              </div>
              <div><img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p1_3.png'"></div>
              <div><a href="/register?t=pr#/3"><img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p2.png'"></a></div>
              <div><img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p3.png'"></div>
              <div><a href="/register?t=pr#/3"><img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p4.png'"></a></div>
              <div><img :src="'/assets_m/images/event/201230/' + $i18n.locale + '/p5.png'"></div>
            </div>
            <Footer />
        </div>
    </div>
</template>

<script>
    require('@/assets_m/js/function');

    import Header from "../include/Header";
    import Footer from "../include/Footer";

    export default {
        name: 'Index',
        components: {Header, Footer},
        data: function() {
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
    @import '@/assets_m/scss/App.scss';
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
