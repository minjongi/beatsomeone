<template>
    <div>
        <header class="header">
            <div class="wrap">
                <div class="header__logo">
                    <a :href="helper.langUrl($i18n.locale, '/')"><img src="@/assets_m/images/logo.png" alt="logo"/></a>
                </div>
                <div class="header__btnbox">
                    <a href="javascript:;" class="header__locale" @click="toggleOpenMenu(true)">{{ localeMenuTit }}</a>
                    <input type="text"
                           v-if="isShowSearchBox"
                           v-model="searchText"
                           @keyup.enter="enterClicked()"
                           class="mo-header-input"
                           style="width: 175px;
                                position:absolute;
                                top: 8px;
                                right:60px;
                                height: 25px;
                                color: #fff;
                                background: rgba(255, 255, 255, 0.2);
                                border-radius: 2em;
                                font-size: 12px;
                                padding: 0 35px 0 10px;
                                -webkit-transition: all 0.3s;
                                transition: all 0.3s;"/>
                    <a href="javascript:;" class="header__search" @click="clickSearchButton" style="z-index: 10000"></a>
                    <a class="header__nav" @click="toggleOpenMenu"></a>
                </div>
            </div>
        </header>

        <div class="gnb" v-if="isOpen">
            <div class="gnb__bg" ></div>
        </div>
        <nav class="gnb" v-if="isOpen" >
            <div class="gnb__content" v-if="!isOpenLanguageSelector">
                <a class="gnb__close" @click="toggleOpenMenu">닫기</a>
                <div class="gnb__links">
                    <a :href="helper.langUrl($i18n.locale, '/sublist?genre=Free')">{{ $t('freeBeats') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/mypage/favorites')">{{ $t('favorite') }}</a>
                    <a v-if="isSeller" :href="helper.langUrl($i18n.locale, '/mypage/regist_item')">{{ $t('registrationSources') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/mypage')" v-if="isLogin">{{ $t('mypage') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/login/logout')" v-if="isLogin">{{ $t('logout') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/login')" v-if="!isLogin">{{ $t('login') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/register')" v-if="!isLogin" @click="signUpClick('buyer')">{{ $t('signup') }}</a>
                    <button v-if="!isLogin">
                        <a :href="helper.langUrl($i18n.locale, '/register')" class="sale_signup" @click="signUpClick('seller')">{{ $t('lang119') }}</a>
                        <span class="tooltip">
                             {{ $t('lang120') }}
                        </span>
                    </button>
                    <a :href="helper.langUrl($i18n.locale, '/cmall/cart')" class="header__cart" v-if="isLogin">
                        {{ $t('cart')}}<br>
                        ({{ $t('currencySymbol') }}{{ getCartSum }})
                    </a>
                </div>
                <!-- <div v-html="banner_content" class="gnb__banner">

                </div> -->

<!--                <a href="" class="gnb__banner">-->
<!--                    <img src="@/assets_m/images/gnb-banner.png" alt="">-->
<!--                </a>-->
            </div>
            <ul class="language-selector" v-if="isOpenLanguageSelector">
              <li class="close">
                <img src="/assets_m/images/icon/x.png" @click="toggleOpenMenu">
              </li>
              <li class="lang" @click="setLocale('en')">ENG</li>
              <li class="lang" @click="setLocale('ko')">KOR</li>
              <li class="lang" @click="setLocale('jp')">日本語</li>
            </ul>
        </nav>
    </div>


</template>

<script>

    import { EventBus } from '*/src/eventbus';
    import Vuecookies from 'vue-cookies';
    import axios from 'axios';

    export default {
        name: 'Header',
        data: function () {
            return {
                userInfo: false,
                searchText: null,
                cartSum: 0,
                isOpen: false,
                isOpenLanguageSelector: false,
                isShowSearchBox: false,
                member_group_name: '',
                banner_content: ''
            };
        },
        created() {
            // this.fetchUserInfo();
            this.userInfo = window.member;
            this.member_group_name = window.member_group_name;
            EventBus.$on('add_cart',() => {
                this.updateCartSum();
            });
        },
        mounted() {
            this.updateCartSum();

            axios.get('/beatsomeoneApi/get_banner')
                .then(res => res.data)
                .then(data=> {
                    this.banner_content = data.content;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        computed: {
            localeMenuTit: function() {
              switch (this.$i18n.locale) {
                case 'ko':
                  return 'KOR'
                case 'jp':
                  return '日本語'
              }
              return 'ENG'
            },
            isSeller() {
                return this.member_group_name.includes('seller')
            },
            isCustomer() {
                return this.member_group_name === 'buyer';
            },
            isLogin () {
                return this.userInfo !== false;
            },
            getCartSum() {
              if (this.$i18n.locale === "en") {
                return Number(this.$store.getters.getCartSumD).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
              } else if (this.$i18n.locale === "jp") {
                return Number(this.$store.getters.getCartSumJPY).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
              } else if (this.$i18n.locale === "cn") {
                return Number(this.$store.getters.getCartSumCNY).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
              }

              return Number(this.$store.getters.getCartSum).toLocaleString("ko-KR", {minimumFractionDigits: 0})
            },
        },
        methods: {
            fetchUserInfo() {
              Http.post('/beatsomeoneApi/get_user_info').then(r=> {
                  this.userInfo = r[0];
              });
            },
            toggleOpenMenu(languageSelector = false) {
              this.isOpen = !this.isOpen
              this.isOpenLanguageSelector = languageSelector === true
            },
            updateCartSum() {
                axios.get('/beatsomeoneApi/getCartSum')
                    .then(res => res.data)
                    .then(data => {
                        this.cartSum = data.s;
                        this.cartSumD = data.s_d;
                        this.cartSumJPY = data.s_jpy;
                        this.cartSumCNY = data.s_cny;
                        this.$store.dispatch('addMoney', {
                            money: data.s,
                            money_d: data.s_d,
                            money_jpy: data.s_jpy,
                            money_cny: data.s_cny,
                        })
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            clickSearchButton() {
                this.isShowSearchBox = !this.isShowSearchBox;
                if(this.isShowSearchBox === false){
                    this.search();
                }
            },
            search() {
                if (!this.searchText) {
                    return;
                }
                const path = `/sublist?search=${this.searchText}`;
                window.location.href = this.helper.langUrl(this.$i18n.locale, path);
            },
            enterClicked(){
                this.search();
            },
            toggleLocale() {
              if (this.$i18n.locale === 'ko') {
                location.href = location.href.replace(location.hostname + '/ko', location.hostname + '/en')
              } else {
                location.href = location.href.replace(location.hostname + '/' + this.$i18n.locale, location.hostname + '/ko')
              }
            },
            setLocale(locale) {
                location.href = location.href.replace(location.hostname + '/' + this.$i18n.locale, location.hostname + '/' + locale)
            },
            signUpClick(state) {
                localStorage.setItem("UserOffer", state);
            }
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