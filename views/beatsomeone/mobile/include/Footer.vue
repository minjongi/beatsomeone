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
                            alt="인스타그렘으로 바로가기"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img src="@/assets_m/images/icon/youtube.png" alt="유튜브로 바로가기"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img
                            src="@/assets_m/images/icon/facebook.png"
                            alt="페이스북으로 바로가기"
                    /></a>
                    <a href="" class="sns__insta"
                    ><img src="@/assets_m/images/icon/twitter.png" alt="트위터로 바로가기"
                    /></a>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="footer__appLink">
                    <a href=""
                    ><img src="@/assets_m/images/app-store.png" alt="앱스토어 바로가기"
                    /></a>
                    <a href=""
                    ><img src="@/assets_m/images/google-play.png" alt="구글스토어 바로가기"
                    /></a>
                </div>
                <p class="footer__copyright">
                    copyright@beat someone2019 .All Right reserved.
                </p>
            </div>
        </div>
        <div class="player">
            <audio controls="controls">
                <source src="@/assets_m/audio/testfile.mp3" type="audio/ogg" />
                <source src="@/assets_m/audio/testfile.mp3" type="audio/mpeg" />
                Your browser does not support the audio element.
            </audio>
            <div class="player__progress"></div>
            <div class="player__content">
                <div class="wrap"></div>
            </div>
        </div>
    </footer>

</template>


<script>

    export default {
        name: 'Footer'
    }

</script>

<style scoped="scoped">

</style>
