<template>

    <header class="header">
        <div class="wrap">
            <h1 class="header__logo">
                <a href="/"><img src="/assets/images/logo.png" alt=""/></a>
            </h1>
            <div class="header__gnb">
                <div class="header__search">
                    <div>
                        <input type="text" v-model="searchText" @keyup.enter="search"/>
                        <button @click="search"></button>
                    </div>
                </div>
                <nav class="header__nav">
                    <a href=""></a>
                    <a href="/cmall/wishlist">{{ $t('favorite') }}</a>
                    <a @click="moveAction('freeBeats')">{{ $t('freeBeats') }}</a>
                    <a href="/mypage" v-if="isLogin">{{ $t('mypage') }}</a>
                    <a href="/login/logout?/" v-if="isLogin">{{ $t('logout') }}</a>
                    <a href="/login" v-if="!isLogin">{{ $t('login') }}</a>
                    <a href="/register" v-if="!isLogin">{{ $t('signup') }}</a>
                    <a href="/cmall/cart" class="header__cart" v-if="isLogin">({{ $t('currencySymbol') + cartSum }})</a>
                    <a href="#" @click="toggleLocale()">{{ toggleLocaleMenuTit }}</a>
                </nav>
            </div>
        </div>
    </header>
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
            updateCartSum() {
                Http.post( `/beatsomeoneApi/getCartSum`).then(r=> {
                    if(r >= 0) {
                        this.cartSum = r;
                    }
                });
            },
            search() {
                // if(!this.searchText) {
                //     return;
                // }
                const path = `/beatsomeone/sublist?genre=All Genre&search=${this.searchText ?? ''}`;
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

<style scoped="scoped">

    .header .header__nav a {
        cursor: pointer !important;
    }

</style>