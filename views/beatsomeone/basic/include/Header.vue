<template>
  <div class="event-header">
    <header class="header">
      <div class="event-top">
        <a :href="helper.langUrl($i18n.locale, '/event/join')"><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/top_bn.png'"></a>
      </div>
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
                    <a :href="helper.langUrl($i18n.locale, '/mypage/favorites')">{{ $t('favorite') }}</a>
                    <a v-if="isCustomer && false" href="">{{ $t('freeBeats') }}</a>
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
                    <a :href="helper.langUrl($i18n.locale, '/cmall/cart')" class="header__cart" v-if="isLogin">({{ $t('currencySymbol') }}{{ $i18n.locale == 'en' ? getCartSumD : getCartSum }})</a>
                    <a href="javascript:;" @click="toggleLocale()">{{ toggleLocaleMenuTit }}</a>
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
        },
        computed: {
            toggleLocaleMenuTit: function() {
                return this.$i18n.locale === 'en' ? 'KOR' : 'ENG';
            },
            getCartSum() {
                return Number(this.$store.getters.getCartSum).toLocaleString('ko-KR', {minimumFractionDigits: 0});
            },
            getCartSumD() {
                return Number(this.$store.getters.getCartSumD).toLocaleString(undefined, {minimumFractionDigits: 2});
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
                        this.$store.dispatch('addMoney', {
                            money: data.s,
                            money_d: data.s_d,
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
                if (this.$i18n.locale === 'en') {
                  location.href = location.href.replace(location.hostname, location.hostname + '/ko')
                } else {
                  location.href = location.href.replace('/ko', '')
                }
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