<template>
    <footer class="footer">
        <div class="wrap">
            <div class="footer__top">
                <div class="footer__logo">
                    <a href="/"><img src="@/assets_m/images/logo.png" alt=""/></a>
                </div>
                <div class="footer__sns sns">
                    <a href="" class="sns__insta"
                    ><img
                            src="@/assets_m/images/icon/instagram.png"
                            alt="instagram"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img src="@/assets_m/images/icon/youtube.png" alt="youtube"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img
                            src="@/assets_m/images/icon/facebook.png"
                            alt="youtube"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img src="@/assets_m/images/icon/twitter.png" alt="twitter"
                    /></a>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="footer__appLink">
                    <a href=""
                    ><img src="@/assets_m/images/app-store.png" alt="app-store"
                    /></a>
                    <a href=""
                    ><img src="@/assets_m/images/google-play.png" alt="google-play"
                    /></a>
                </div>
                <p class="footer__copyright">
                    copyright@beat someone2019 .All Right reserved.
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
