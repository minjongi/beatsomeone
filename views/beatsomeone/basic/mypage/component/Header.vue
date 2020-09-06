<template>
    <header class="header" :class="scrolled">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <img src="/assets/images/logo.png" alt=""/>
                </a>
                <div class="navbar-collapse collapse">
                    <div class="header__search ml-auto">
                        <div>
                            <input type="text" v-model="searchText" @keyup.enter="search"/>
                            <button @click="search"></button>
                        </div>
                    </div>
                    <ul class="navbar-nav ml-3">
                        <li class="nav-item">
                            <a class="nav-link" href="/mypage/favorites">{{ $t('favorite') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/mypage/regist_item">{{ $t('registrationSources') }}</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="/mypage">{{ $t('mypage') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login/logout" v-if="is_member">{{ $t('logout') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="/cmall/cart" class="nav-link"><span class="fal fa-shopping-cart mr-1"></span>({{ $t('currencySymbol') + cartSum }})</a>
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
    import { EventBus } from '*/src/eventbus';
    import Vuecookies from 'vue-cookies'
    import $ from "jquery";

    export default {
        name: 'Header',
        data: function () {
            return {
                userInfo: null,
                searchText: null,
                cartSum: 0,
                is_member: 0,
                scrolled: '',
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
            window.addEventListener('scroll', this.handleScroll);
        },
        mounted() {
            this.is_member = (+window.is_member);
            this.updateCartSum();
        },
        destroyed() {
            window.removeEventListener('scroll', this.handleScroll);
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
            }
        },
    }

</script>

<style lang="scss" scoped>

    .header .header__nav a {
        cursor: pointer !important;
    }

    .smtm9-top {
        text-align:center;
        background-color: #000000;
        width: 100%;
    }

    .smtm9-top img {
        max-width: 100%;
    }

    .header {
        position: absolute;
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