<template>
  <div class="footer-banner" v-if="footerBanner && cookie">
    <div class="close" @click="closeFooterBanner"></div>
    <a :href="helper.langUrl($i18n.locale, '/event/join')"><img
        :src="'/assets_m/images/event/2101241/' + $i18n.locale + '/bn.png'"></a>
  </div>
</template>

<script>
import Vuecookies from 'vue-cookies'

export default {
  name: "FooterBanner",
  props: [
    'footerBanner',
  ],
  data: function () {
    return {
      cookie: false,
      member: null
    }
  },
  created() {
    this.member = window.member;
    if (Vuecookies.get('FooterBanner-close') !== 'Y' && !this.member) {
      this.cookie = true
    }
  },
  methods: {
    closeFooterBanner() {
      Vuecookies.set('FooterBanner-close', 'Y', '1d')
      this.cookie = false
    },
  }
}
</script>
