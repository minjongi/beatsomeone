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
                <form :action="fullUrl" method="post">
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
                                <p class="form-title">{{ $t('password') }}</p>
                                <div class="input">
                                    <input type="password" name="mem_password" :placeholder="$t('typeYourPassword')" />
                                </div>
                            </label>
                        </div>
                    </div>
                    <div v-html="errorMsg" v-if="errorMsg" class="errortext">

                    </div>
                    <div class="accounts__btnbox">
                        <button type="submit" class="btn btn--submit" style="height: 54px; width: 100%">
                            {{ $t('login') }}
                        </button>
                    </div>
                </form>

                <div class="accounts__social">
                    <h2>{{ $t('snsLogin') }}</h2>
                    <a @click="socialLogin('facebook')"
                    ><img
                            src="@/assets/images/accounts-facebook.png"
                            :alt="$t('loginFacebook')"
                    /></a>
                    <a @click="socialLogin('twitter')"
                    ><img
                            src="@/assets/images/accounts-twitter.png"
                            :alt="$t('loginTwitter')"
                    /></a>
                    <a @click="socialLogin('google')"
                    ><img src="@/assets/images/accounts-google.png" :alt="$t('loginGoogle')"
                    /></a>
                    <a @click="socialLogin('naver')"
                    ><img src="@/assets/images/accounts-naver.png" :alt="$t('loginNaver')"
                    /></a>
                    <a @click="socialLogin('kakao')"
                    ><img src="@/assets/images/accounts-kakao.png" :alt="$t('loginKakao')"
                    /></a>
                </div>

                <div class="accounts__etc">
                    {{ $t('dontHaveAccount') }} <a :href="helper.langUrl($i18n.locale, '/register')">{{ $t('signup') }}</a>
                </div>
                <div class="accounts__etc">
                    {{ $t('forgotYourAccount') }} <a :href="helper.langUrl($i18n.locale, '/findaccount')">{{ $t('findAccount') }}</a>
                </div>
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
    require('@/assets/js/function');

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";

    import { EventBus } from '*/src/eventbus';

    export default {
        components: {Header,Footer},
        data: function() {
            return {
                errorMsg: '',
                isLogin: false,
                fullUrl: '/login'
            }
        },
        mounted() {
            this.$refs.userid.focus();
            this.fullUrl = window.location.pathname + window.location.search;
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
    @import '@/assets/scss/App.scss';
</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    body, html {
        background:#111214 !important;
    }
    .errortext p {
        font-size: 14px;
        margin-top: 5px;
        opacity: .5;
    }
    .errortext p:before {
        content:'- ';
    }
</style>
