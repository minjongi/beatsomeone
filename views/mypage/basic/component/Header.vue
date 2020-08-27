<template>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark mx-5">
            <a href="/" class="navbar-brand">
                <img src="/assets/images/logo.png" alt=""/>
            </a>
            <div class="navbar-collapse collapse">
                <div class="header-search ml-auto">
                    <div>
                        <input type="text" v-model="searchText" @keyup.enter="search"/>
                        <button @click="search"></button>
                    </div>
                </div>
                <ul class="navbar-nav">
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
        </nav>
    </header>
</template>

<script>
    import Vuecookies from "vue-cookies";

    export default {
        name: "Header",
        data: function () {
            return {
                searchText: '',
                is_member: 0,
                cartSum: 0,
            }
        },
        mounted() {
            this.is_member = (+window.is_member);
        },
        computed: {
            toggleLocaleMenuTit: function() {
                return this.$i18n.locale === 'en' ? 'KOR' : 'ENG';
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
                window.location.href = path;
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
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);

        .navbar {
            font-size: 13px;
        }
    }
</style>