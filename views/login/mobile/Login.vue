<template>

    <div class="wrapper">

        <Header :is-login="isLogin"></Header>
        <div class="container accounts">
            <div class="accounts__title">
                <h1>
                    Log in to continue
                </h1>
            </div>
            <div class="login accounts__defaultLayout">


                <form action="/login" method="post">
                    <div class="accounts__form">
                        <div class="row">
                            <label for="">
                                <p class="form-title">Email or username</p>
                                <div class="input">
                                    <input ref="userid"
                                            type="text" name="mem_userid"
                                            placeholder="Type your e-mail or username"
                                    />
                                </div>
                            </label>
                        </div>
                        <div class="row">
                            <label for="">
                                <p class="form-title">Password
                                    <a href="/findaccount">Forgot ID/password?</a>
                                </p>
                                <div class="input">
                                    <input type="password" name="mem_password" placeholder="Type your password" />
                                </div>
                            </label>
                        </div>
                    </div>
                    <div v-html="errorMsg" v-if="errorMsg" >

                    </div>
                    <div class="accounts__btnbox">
                        <button type="submit" class="btn btn--submit">
                            Log in
                        </button>
                    </div>
                </form>

                <div class="accounts__social">
                    <h2>SNS Log in</h2>
                    <a href=""
                    ><img
                            src="@/assets_m/images/accounts-facebook.png"
                            alt="페이스북 로그인"
                    /></a>
                    <a href=""
                    ><img
                            src="@/assets_m/images/accounts-twitter.png"
                            alt="트위터 로그인"
                    /></a>
                    <a href=""
                    ><img src="@/assets_m/images/accounts-google.png" alt="구글 로그인"
                    /></a>
                    <a href=""
                    ><img src="@/assets_m/images/accounts-naver.png" alt="네이버 로그인"
                    /></a>
                    <a href=""
                    ><img src="@/assets_m/images/accounts-kakao.png" alt="카카오 로그인"
                    /></a>
                </div>

                <div class="accounts__etc">
                    Don`t have an account? <a href="/register">Sign up</a>
                </div>

            </div>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>


    require('@/assets_m/js/function');

    import Header from "@/views/beatsomeone/mobile/include/Header";
    import Footer from "@/views/beatsomeone/mobile/include/Footer";

    import { EventBus } from '*/src/eventbus';

    export default {
        components: {Header,Footer},
        data: function() {
            return {
                errorMsg: '',
                isLogin: false,
            }
        },
        mounted() {
            this.$refs.userid.focus();
        },
        watch: {

        },
        methods: {



        },

    }

</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';


</style>

<style lang="css">

</style>
