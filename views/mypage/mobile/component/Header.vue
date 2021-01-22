<template>
    <header class="header" :class="scrolled">
        <nav class="navbar navbar-expand navbar-dark">
            <a :href="helper.langUrl($i18n.locale, '/')" class="navbar-brand">
                <img src="/assets/images/logo.png" alt=""/>
            </a>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#" class="btn btn-sm btn-icon" @click="toggleLocale()">{{ toggleLocaleMenuTit }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-icon" href="javascript:;">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-icon" @click="toggleSidebar" href="javascript:;">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="gnb" v-if="showSidebar">
            <div class="gnb__bg" ></div>
        </div>
        <nav class="gnb" v-if="showSidebar" >
            <div class="gnb__content">
                <a class="gnb__close" href="javascript:;" @click="toggleSidebar"></a>
                <div class="gnb__links">
                    <a :href="helper.langUrl($i18n.locale, '/mypage/favorites')">{{ $t('favorite') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/mypage/regist_item')">{{ $t('registrationSources') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/mypage')">{{ $t('mypage') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/login/logout?/')">{{ $t('logout') }}</a>
                    <a :href="helper.langUrl($i18n.locale, '/cmall/cart')" class="header__cart">({{ $t('currencySymbol') }}{{ $i18n.locale == 'en' ? getCartSumD : getCartSum }})</a>
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
                showSidebar: false,
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
                const path = `/beatsomeone/sublist?genre=All Genre&search=${this.searchText ?? ''}`;
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
            toggleSidebar: function () {
                this.showSidebar = !this.showSidebar;
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

        .btn.btn-icon {
            color: white;
        }
    }

    .gnb {
        position: fixed;
        right: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;

        .gnb__bg {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1;
        }
        .gnb__content {
            position: absolute;
            right: 0;
            top: 0;
            width: 300px;
            height: 100%;
            background:#1c1d23;
            z-index: 2;
            padding: 25px;
            padding-top: 80px;
            display: flex;
            flex-direction: column;
        }
        .gnb__close {
            width: 40px;
            height: 40px;
            display: block;
            background: url('/assets_m/images/icon/x.png') no-repeat center;
            position: absolute;
            right: 0;
            top: 0;
            background-size: auto 15px;
        }
        .gnb__links {
            display: flex;
            flex-direction: column;
            align-items: center;
            a {
                font-size: 20px;
                color:#fff;
                font-weight: 500;
                line-height: 60px;
                width: 100%;
                text-align: center;
            }
        }
        .gnb__banner {
            margin-top: auto;
        }
    }
</style>