<template>
    <footer class="footer">
        <div class="wrap">
            <div class="footer__top">
                <div class="footer__logo">
                    <a href="/"><img src="/assets/images/logo.png" alt=""/></a>
                </div>
                <div class="footer__sns sns">
                    <a href="" class="sns__insta"
                    ><img
                            src="/assets/images/icon/instagram.png"
                            alt="instagram"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img src="/assets/images/icon/youtube.png" alt="youtube"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img
                            src="/assets/images/icon/facebook.png"
                            alt="facebook"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img src="/assets/images/icon/twitter.png" alt="twitter"
                    /></a>
                </div>
            </div>
            <div class="footer__content">
                <div class="footer__subLink">
                    <div class="row">
                        <h3>
                            <a href="/">BEAT SOMEONE</a>
                        </h3>
                        <ul>
                            <li><a href="">{{ $t('aboutUs') }}</a></li>
                            <li><a href="">{{ $t('careers') }}</a></li>
                            <li><a href="">{{ $t('merch') }}</a></li>
                            <li><a href="">{{ $t('blog') }}</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <h3>
                            <a href="/">{{ $t('features') }}</a>
                        </h3>
                        <ul>
                            <li><a href="">{{ $t('sellingMusic') }}</a></li>
                            <li><a href="">{{ $t('proPage') }}</a></li>
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
                </div>
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
            </div>
            <div class="footer__bottom">
                <div class="footer__appLink">
                    <a href=""
                    ><img src="/assets/images/app-store.png" alt="앱스토어 바로가기"
                    /></a>
                    <a href=""
                    ><img src="/assets/images/google-play.png" alt="구글스토어 바로가기"
                    /></a>
                </div>
                <p class="footer__copyright">
                    copyright@beat someone 2019 .All Right reserved.
                </p>
            </div>
        </div>
        <div style="text-align:center;margin-top: 10px;">
            <button @click="setLocale('ko')" style="border:1px solid #ffda2a;color:#ffffff;padding:5px 20px;border-radius: 3px;font-size:10px;margin-right:5px;">한국어</button>
            <button @click="setLocale('en')" style="border:1px solid #ffda2a;color:#ffffff;padding:5px 20px;border-radius: 3px;font-size:10px;">영어</button>
        </div>
    </footer>
</template>

<script>
    export default {
        name: 'Footer',
        methods: {
            setLocale(locale) {
                i18n.locale = locale
            },
        },
    }
</script>

<style scoped="scoped">

</style>
