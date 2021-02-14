<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container sub event-content" style="position: relative;">
          <div><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/p1.png'"></div>
          <div><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/p2-1.png'"></div>
          <div><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/p3.png'"></div>
          <div style="position:fixed;bottom:0;left:50%;transform: translate(-50%, 0);"><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/p_btn.png'" @click="goEvent()"></div>
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
        },
        methods: {
          goEvent() {
            axios.get('/event/chk')
                .then(res => {
                  if (res.data === 'join') {
                    location.href = this.helper.langUrl(this.$i18n.locale, '/register?t=event#/3')
                  } else if (res.data === 'event') {
                    alert(this.$t('lang152'))
                  } else if (res.data === 'not_target') {
                    alert(this.$t('lang153'))
                  }
                })
                .catch(error => {
                  console.error(error);
                })
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
