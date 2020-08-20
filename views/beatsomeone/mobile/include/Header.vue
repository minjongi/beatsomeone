<template>

    <div>
        <header class="header">
            <div class="wrap">
                <h1 class="header__logo">
                    <a href="/"><img src="@/assets_m//images/logo.png" alt=""/></a>
                </h1>
                <div class="header__btnbox">
                    <a href="#" class="header__locale" @click="toggleLocale()">{{ toggleLocaleMenuTit }}</a>
                    <a href="#" class="header__search"></a>
                    <a class="header__nav" @click="toggleOpenMenu"></a>
                </div>
            </div>
        </header>

        <div class="gnb" v-if="isOpen">
            <div class="gnb__bg" ></div>
        </div>

<!--        <transition name="slide-fade">-->
        <nav class="gnb" v-if="isOpen" >

            <div class="gnb__content">
                <a class="gnb__close" @click="toggleOpenMenu">닫기</a>
                <div class="gnb__links">
                    <a href="/mypage/favorites">{{ $t('favorite') }}</a>
                    <a href="/mypage/regist_item">{{ $t('registrationSources') }}</a>
                    <a href="/mypage" v-if="isLogin">{{ $t('mypage') }}</a>
                    <a href="/login/logout?/" v-if="isLogin">{{ $t('logout') }}</a>
                    <a href="/login" v-if="!isLogin">{{ $t('login') }}</a>
                    <a href="/register" v-if="!isLogin">{{ $t('signup') }}</a>
                    <a href="/cmall/cart" class="header__cart" v-if="isLogin">({{ $t('currencySymbol') + cartSum }})</a>
                </div>

                <a href="" class="gnb__banner">
                    <img src="@/assets_m/images/gnb-banner.png" alt="">
                </a>
            </div>

        </nav>
<!--        </transition>-->
    </div>


</template>

<script>

    import { EventBus } from '*/src/eventbus';
    import Vuecookies from 'vue-cookies'

    export default {
        name: 'Header',
        props: {
            isLogin : {
                type: Boolean,
                default: false,
            }
        },
        data: function () {
            return {
                userInfo: null,
                searchText: null,
                cartSum: 0,
                isOpen: false,
            };
        },
        watch: {
          isLogin: function (n) {

          },
        },
        created() {
            this.fetchUserInfo();
            EventBus.$on('add_cart',() => {
                this.updateCartSum();
            });
        },
        mounted() {
            this.updateCartSum();
        },
        computed: {
            toggleLocaleMenuTit: function() {
                return this.$i18n.locale === 'en' ? 'KOR' : 'ENG';
            },
        },
        methods: {
            fetchUserInfo() {
              Http.post('/beatsomeoneApi/get_user_info').then(r=> {
                  this.userInfo = r[0];
              });
            },
            toggleOpenMenu() {
              this.isOpen = !this.isOpen;

            },
            updateCartSum() {
                Http.post( `/beatsomeoneApi/getCartSum`).then(r=> {
                    if(r >= 0) {
                        this.cartSum = r;
                    }
                });
            },
            search() {
                if(!this.searchText) {
                    return;
                }
                const path = `/beatsomeone/search?q=${this.searchText}`;
                window.location.href = path;
            },
            toggleLocale() {
                let locale = this.$i18n.locale === 'en' ? 'ko' : 'en'
                Vuecookies.set('locale', locale)
                this.$i18n.locale = locale
            },
            moveAction(o) {
                let url = null;
                // 로그인시
                if(this.userInfo) {
                    switch(o) {
                        case 'freeBeats': {
                            url = this.userInfo.mem_usertype == 1 ? '무료비트URL수정필요' : '음원등록URL수정필요';
                            break;
                        }
                    }
                }
                // 비로그인시
                else {
                    url = '무료비트URL수정필요';
                }

                // 이동
                window.location.href = url;
            },
        },
    }

</script>

<style scoped="scoped" type="css">
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(100px);
        opacity: 0;
    }

</style>