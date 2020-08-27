<template>
    <header class="header" :class="scrolled">
        <nav class="navbar navbar-expand navbar-dark">
            <a href="/" class="navbar-brand">
                <img src="/assets/images/logo.png" alt=""/>
            </a>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-sm btn-icon" href="javascript:;">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-icon" href="javascript:;">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
    import Vuecookies from "vue-cookies";
    import $ from "jquery";

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
</style>