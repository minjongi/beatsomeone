<template>
  <footer class="footer">
    <div class="wrap">
      <div class="footer__top">
        <div class="footer__logo">
          <img src="/assets/images/logo.png" alt />
        </div>
        <div class="footer__sns sns">
          <a href="https://www.instagram.com/beatsomeone" class="sns__insta">
            <img src="/assets/images/icon/instagram.png" alt="instagram" />
          </a>
          <a href="https://www.youtube.com/channel/UCkOZTgnHFgC0Cb04W0AJ1LQ" class="sns__insta">
            <img src="/assets/images/icon/youtube.png" alt="youtube" />
          </a>
          <a href="https://www.facebook.com/beatsomeone" class="sns__insta">
            <img src="/assets/images/icon/facebook.png" alt="facebook" />
          </a>
          <a href="https://twitter.com/beatsomeone1" class="sns__insta">
            <img src="/assets/images/icon/twitter.png" alt="twitter" />
          </a>
        </div>
      </div>
      <div class="footer__content">
        <div class="footer__subLink">
          <div class="row">
            <!-- <h3>
              <a href="/">BEAT SOMEONE</a>
            </h3>-->
            <ul>
              <li>
                <a href="#//" style="cursor:default;">BEAT SOMEONE</a>
              </li>
              <li>
                <a
                  href="http://dev.beatsomeone.com/register#/TermsOfService"
                  target="_blank"
                >{{ $t('termsOfService') }}</a>
              </li>
              <li>
                <a
                  href="http://dev.beatsomeone.com/register#/PrivacyPolicy"
                  target="_blank"
                >{{ $t('privacyPolicy') }}</a>
              </li>
              <li>
                <a href="http://dumdum.kr">{{ $t('aboutUs') }}</a>
              </li>
            </ul>
          </div>
          <!--
                    <div class="row">
                        <h3>
                            <a href="/">{{ $t('features') }}</a>
                        </h3>
                        <ul>
                            <li><a href="">{{ $t('sellingMusic') }}</a></li>
                            <li><a href="">{{ $t('blazePlayer') }}</a></li>
                            <li><a href="">{{ $t('monetization') }}</a></li>
                            <li><a href="">{{ $t('testimonialsMenu') }}</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <h3>
                            <a href="/">{{ $t('aboutUs') }}SUPPORT</a>
                        </h3>
                        <ul>
                            <li><a href="">{{ $t('help') }}</a></li>
                            <li><a href="">{{ $t('cookiePolicy') }}</a></li>
                            <li><a href="">{{ $t('privacyPolicy') }}</a></li>
                            <li><a href="">{{ $t('copyrightComplaint') }}</a></li>
                            <li><a href="">{{ $t('termsConditions') }}</a></li>
                            <li><a href="">{{ $t('contactUs') }}</a></li>
                        </ul>
                    </div>
          -->
        </div>
        <!--
                <div class="footer__subscribe">
                    <h3>BEAT SOMEONE SOCIAL</h3>
                    <p>
                        {{ $t('newsOfferMsg') }}
                    </p>
                    <form action="">
                        <div class="subscribe-form">
                            <input type="text" :placeholder="$t('enterYourEmailAddress')"/>
                            <button class="submit">{{ $t('subscribe') }}</button>
                        </div>
                    </form>
                </div>
        -->
      </div>
      <div class="footer__bottom">
        <!--
                <div class="footer__appLink">
                    <a href=""
                    ><img src="/assets/images/app-store.png" alt="앱스토어 바로가기"
                    /></a>
                    <a href=""
                    ><img src="/assets/images/google-play.png" alt="구글스토어 바로가기"
                    /></a>
                </div>
        -->
        <p class="footer__copyright">copyright@beat someone 2019 .All Right reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer"
};
</script>

<style scoped="scoped">
</style>
