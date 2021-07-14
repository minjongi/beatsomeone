<template>
<!--  class="event-header"-->
  <div>
    <header class="header">
<!--      <div class="event-top">-->
<!--        <a :href="helper.langUrl($i18n.locale, '/event')"><img :src="'/assets/images/event/210422/top_bn.png?v=1'"></a>-->
<!--      </div>-->
        <div class="wrap">
            <div class="header__logo">
                <a :href="helper.langUrl($i18n.locale, '/')"><img src="/assets/images/logo.png" alt="logo"/></a>
            </div>
            <div class="header__gnb">
                <div class="header__search">
                    <div>
                        <input type="text" v-model="searchText" @keyup.enter="search"/>
                        <button @click="search"></button>
                    </div>
                </div>
                <nav class="header__nav">
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
                    <a :href="helper.langUrl($i18n.locale, '/cmall/cart')" class="header__cart" v-if="isLogin">({{ $t('currencySymbol') }}{{ getCartSum }})</a>
                    <div class="language-selector">
                      <div class="custom-select">
                        <button class="selected-option">{{ localeMenuTit }}</button>
                        <div class="options">
                          <button class="option" @click="setLocale('en')">ENG</button>
                          <button class="option" @click="setLocale('ko')">KOR</button>
                          <button class="option" @click="setLocale('jp')">日本語</button>
                        </div>
                      </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
  </div>
</template>

<script>
    import { EventBus } from '*/src/eventbus';
    import Vuecookies from 'vue-cookies';
    import axios from 'axios';
    import { mapGetters, mapActions } from 'vuex';
    import $ from "jquery";

    export default {
        name: 'Header',
        data: function () {
            return {
                searchText: '',
                cartSum: 0,
                member_group_name: '',
                member: false
            };
        },
        created() {
            EventBus.$on('add_cart',() => {
                this.updateCartSum();
            });
        },
        mounted() {
            this.updateCartSum();
            this.member_group_name = window.member_group_name;
            this.member = window.member;

            $(".language-selector .custom-select, .language-selector .custom-select .options").on("mouseover", function () {
              $(this).addClass("active")
              $(this).find(".options").show()
            })

            $(".language-selector .custom-select, .language-selector .custom-select .options").on("mouseout", function () {
              $(this).removeClass("active")
              $(this).find(".options").hide()
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
            isSeller() {
              console.log(this.member_group_name)
                return this.member_group_name.includes('seller')
            },
            isCustomer() {
                return this.member_group_name === 'buyer';
            },
            isLogin () {
                return this.member !== false;
            },

        },
        methods: {
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
            search() {
                // if(!this.searchText) {
                //     return;
                // }
                const path = `/sublist?search=${this.searchText ?? ''}`;
                window.location.href = this.helper.langUrl(this.$i18n.locale, path);
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

<style scoped="scoped">

    .header .header__nav a {
        cursor: pointer !important;
    }
</style>