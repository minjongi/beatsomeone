<template>
    <div>
        <div class="wrapper">
            <Header :is-login="isLogin"></Header>
            <div class="container sub event-content">
              <div class="typeform-widget" data-url="https://form.typeform.com/to/X17k6U4F?typeform-medium=embed-snippet"></div>
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
    .typeform-widget {
      width: 100%;
      height: 500px;
    }
</style>
