<template>
    <footer class="footer">
        <div class="wrap">
            <div class="footer__top">
                <div class="footer__logo">
                    <a href="/"><img src="@/assets_m/images/logo.png" alt=""/></a>
                </div>
                <div class="footer__sns sns">
                    <a href="https://www.instagram.com/beatsomeone" class="sns__insta"
                    ><img
                            src="@/assets_m/images/icon/instagram.png"
                            alt="instagram"
                    /></a>
                    <a href="https://www.youtube.com/channel/UCkOZTgnHFgC0Cb04W0AJ1LQ" class="sns__insta"
                    ><img src="@/assets_m/images/icon/youtube.png" alt="youtube"
                    /></a>
                    <a href="https://www.facebook.com/beatsomeone" class="sns__insta"
                    ><img
                            src="@/assets_m/images/icon/facebook.png"
                            alt="youtube"
                    /></a>
                    <a href="https://twitter.com/beatsomeone1" class="sns__insta"
                    ><img src="@/assets_m/images/icon/twitter.png" alt="twitter"
                    /></a>
                </div>
            </div>
            <div class="footer__bottom">
                <!--
                <div class="footer__appLink">
                    <a href=""
                    ><img src="@/assets_m/images/app-store.png" alt="app-store"
                    /></a>
                    <a href=""
                    ><img src="@/assets_m/images/google-play.png" alt="google-play"
                    /></a>
                </div>
                -->
                <div class="footer__appLink">
                  <a href="http://scan.beatsomeone.com" target="_blank" style="color:#ffffff;font-size:10px;">beatsomeone Blockchain Mornitoring System</a>
                </div>
                <p class="footer__copyright">
                  {{ $t('lang131') }}<br/>
                  {{ $t('lang132') }}<br/>
                  {{ $t('lang133') }}<br/><br/>
                  {{ $t('lang134') }}<br/>
                  {{ $t('lang135') }}
                </p>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
  name: 'Footer',
  data: function () {
    return {
    }
  },
  methods: {
  },
}
</script>

<style scoped="scoped">

</style>
