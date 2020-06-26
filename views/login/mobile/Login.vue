<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container accounts">
            <div class="accounts__title">
                <h1>
                    {{ $t('loginToContinue') }}
                </h1>
            </div>
            <div class="login accounts__defaultLayout">
                <form action="/login" method="post">
                    <div class="accounts__form">
                        <div class="row">
                            <label for="">
                                <p class="form-title">{{ $t('emailOrUsername') }}</p>
                                <div class="input">
                                    <input ref="userid"
                                            type="text" name="mem_userid"
                                           :placeholder="$t('typeEmailOrUsername')"
                                    />
                                </div>
                            </label>
                        </div>
                        <div class="row">
                            <label for="">
                                <p class="form-title">{{ $t('password') }}
                                    <a href="/findaccount">{{ $t('forgotYourAccount') }}</a>
                                </p>
                                <div class="input">
                                    <input type="password" name="mem_password" :placeholder="$t('typeYourPassword')" />
                                </div>
                            </label>
                        </div>
                    </div>
                    <div v-html="errorMsg" v-if="errorMsg" >

                    </div>
                    <div class="accounts__btnbox">
                        <button type="submit" class="btn btn--submit">
                            {{ $t('login') }}
                        </button>
                    </div>
                </form>

                <div class="accounts__social">
                    <h2>SNS Log in</h2>
                    <a @click="socialLogin('facebook')"
                    ><img
                            src="@/assets_m/images/accounts-facebook.png"
                            :alt="$t('loginFacebook')"
                    /></a>
                    <a @click="socialLogin('twitter')"
                    ><img
                            src="@/assets_m/images/accounts-twitter.png"
                            :alt="$t('loginTwitter')"
                    /></a>
                    <a @click="socialLogin('google')"
                    ><img src="@/assets_m/images/accounts-google.png" :alt="$t('loginGoogle')"
                    /></a>
                    <a @click="socialLogin('naver')"
                    ><img src="@/assets_m/images/accounts-naver.png" :alt="$t('loginNaver')"
                    /></a>
                    <a @click="socialLogin('kakao')"
                    ><img src="@/assets_m/images/accounts-kakao.png" :alt="$t('loginKakao')"
                    /></a>
                </div>
                <div class="accounts__etc">
                    {{ $t('dontHaveAccount') }} <a href="/register">{{ $t('signup') }}</a>
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
            socialLogin(social_type) {

                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }
                window.open('/social/' + social_type + '_login', social_type + '-on', 'width=600,height=600');
            }
        },
    }
</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style lang="css">

</style>
