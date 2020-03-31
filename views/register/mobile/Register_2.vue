<template>
    <div class="container accounts">
        <div class="accounts__title">
            <h1>
                Sign Up
            </h1>
            <p>
                Create a beatsomeone account & start monetizing your beats!
            </p>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__btnbox border-none">
                <button type="submit" class="btn btn--white" @click="doNext('email')">
                    <img src="@/assets/images/icon/email.png" alt="" />
                    Sign up with Email
                </button>
            </div>

            <div class="accounts__social">
                <h2>SNS Log in</h2>
                <a href="#" @click="doNext('facebook')"><img
                        src="@/assets/images/accounts-facebook.png"
                        alt="페이스북 로그인"
                /></a>
                <a href="#"  @click="doNext('twitter')"
                ><img
                        src="@/assets/images/accounts-twitter.png"
                        alt="트위터 로그인"
                /></a>
                <a href="#"  @click="doNext('google')"
                ><img src="@/assets/images/accounts-google.png" alt="구글 로그인"
                /></a>
                <a href="#"  @click="doNext('naver')"
                ><img src="@/assets/images/accounts-naver.png" alt="네이버 로그인"
                /></a>
                <a href="#"  @click="doNext('kakao')"
                ><img src="@/assets/images/accounts-kakao.png" alt="카카오 로그인"
                /></a>
            </div>

            <div class="accounts__etc">
                Already have an account? <a href="/login">Login</a>
            </div>
        </div>
    </div>
</template>

<script>

    import { EventBus } from '*/src/eventbus';

    export default {

        data: function() {
            return {

            }
        },
        created() {

        },
        mounted() {


        },
        watch: {

        },
        methods: {
            doNext(type) {
                EventBus.$emit('submit_join_form',{ accountType: type });
                this.$router.push({path: '/3'});
            },
        },

    }




</script>

<style lang="scss">


</style>

<style lang="css">

</style>
