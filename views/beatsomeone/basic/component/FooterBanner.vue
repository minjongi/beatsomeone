<template>
  <div class="footer-banner" v-if="footerBanner && $i18n.locale !== 'en'">
    <a href="http://wdmastering.com/" target="_blank"><img src="/assets/images/banner/wdmastering.png"></a>
  </div>
</template>

<script>
export default {
    name: "FooterBanner",
    props: [
        'footerBanner',
    ],
    methods: {
    }
}
</script>
