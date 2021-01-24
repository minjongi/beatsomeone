<template>
    <header class="header" :class="scrolled">
        <nav class="navbar navbar-expand-lg navbar-dark mx-5">
            <div class="container">
                <a :href="helper.langUrl($i18n.locale, '/')" class="navbar-brand">
                    <img src="/assets/images/logo.png" alt=""/>
                </a>
                <div class="navbar-collapse collapse">
                    <div class="header-search ml-auto">
                        <div>
                            <input type="text" v-model="searchText" @keyup.enter="search"/>
                            <button @click="search"></button>
                        </div>
                    </div>
                    <ul class="navbar-nav ml-3">
                        <li class="nav-item">
                            <a class="nav-link" :href="helper.langUrl($i18n.locale, '/mypage/favorites')">{{ $t('favorite') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :href="helper.langUrl($i18n.locale, '/mypage/regist_item')">{{ $t('registrationSources') }}</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" :href="helper.langUrl($i18n.locale, '/mypage')">{{ $t('mypage') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" :href="helper.langUrl($i18n.locale, '/login/logout')" v-if="is_member">{{ $t('logout') }}</a>
                        </li>
                        <li class="nav-item">
                            <a :href="helper.langUrl($i18n.locale, '/cmall/cart')" class="nav-link"><span class="fal fa-shopping-cart mr-1"></span>({{ $t('currencySymbol') }}{{ $i18n.locale == 'en' ? getCartSumD : getCartSum }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:;" @click="toggleLocale()">{{ toggleLocaleMenuTit }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
    import Vuecookies from "vue-cookies";
    import $ from "jquery";
    import axios from "axios";

    export default {
        name: "Header",
        data: function () {
            return {
                searchText: '',
                is_member: 0,
                cartSum: 0,
                scrolled: '',
            }
        },
        created() {
            window.addEventListener('scroll', this.handleScroll);
            this.updateCartSum();
        },
        destroyed() {
            window.removeEventListener('scroll', this.handleScroll);
        },
        mounted() {
            this.is_member = (+window.is_member);
        },
        computed: {
            toggleLocaleMenuTit: function() {
                return this.$i18n.locale === 'en' ? 'KOR' : 'ENG';
            },
            getCartSum() {
                return this.$store.getters.getCartSum;
            },
            getCartSumD() {
                return this.$store.getters.getCartSumD;
            },
        },
        methods: {
            toggleLocale() {
                let locale = this.$i18n.locale === 'en' ? 'ko' : 'en'
                Vuecookies.set('locale', locale)
                this.$i18n.locale = locale
            },
            search() {
                // if(!this.searchText) {
                //     return;
                // }
                const path = `/sublist?genre=All Genre&search=${this.searchText ?? ''}`;
                window.location.href = this.helper.langUrl(this.$i18n.locale, path);
            },
            handleScroll (event) {
                let t = $("html, body").scrollTop();
                let offset = 0;
                if ($('.smtm9-top')[0]) {
                    offset = 100;
                } else {
                    offset = 10;
                }
                if (t > offset) {
                    this.scrolled = 'scrolled';
                } else {
                    this.scrolled = '';
                }
            },
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
        }
    }
</script>

<style scoped lang="scss">
    @mixin position(
        $position: absolute,
        $top: auto,
        $right: auto,
        $bottom: auto,
        $left: auto
    ) {
        position: $position;
        top: $top;
        bottom: $bottom;
        left: $left;
        right: $right;
    }

    $white-line: rgba(255, 255, 255, 0.1);

    .header-search {
        position: relative;
        input {
            width: 175px;
            height: 25px;
            color: #fff;
            background: $white-line;
            border-radius: 2em;
            font-size: 12px;
            padding: 0 35px 0 10px;
            transition: all 0.3s;
            border: 0;
            outline-style: none;

            &:focus {
                width: 190px;
                border-left-color: $white-line;
            }
        }
        button {
            @include position($top: 0, $right: 5px);
            background: url("/assets/images/icon/search.png") no-repeat center center;
            width: 25px;
            height: 25px;
            cursor: pointer;
            outline-style: none;
            border: 0;
        }
    }

    .header {
        position: fixed;
        top: 0;
        width: 100%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1000;

        &.scrolled {
            position: fixed;
            background: black;
        }

        .navbar {
            font-size: 13px;
        }

        .nav-item {
            &:not(:first-child) {
                .nav-link {
                    border-left: solid 1px #404040;
                }
            }

            &:not(:last-child) {
                .nav-link {
                    border-right: solid 1px #404040;
                }
            }
        }

        .nav-link {
            margin-left: -1px;
            padding: 0 14px !important;
        }
    }
</style>