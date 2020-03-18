<template>

    <div>
        <header class="header">
            <div class="wrap">
                <h1 class="header__logo">
                    <a href="/"><img src="@/assets_m//images/logo.png" alt=""/></a>
                </h1>
                <div class="header__btnbox">
                    <a href="#" class="header__search"></a>
                    <a href="#" class="header__nav"></a>
                </div>
            </div>
        </header>


        <nav class="gnb">
            <div class="gnb__bg"></div>
            <div class="gnb__content">
                <a href="" class="gnb__close">닫기</a>
                <div class="gnb__links">
                    <a href="">Free Beats</a>
                    <a href="">Pricing</a>
                    <a href="">Login</a>
                    <a href="">Sign in</a>
                </div>

                <a href="" class="gnb__banner">
                    <img src="@/assets_m/images/gnb-banner.png" alt="">
                </a>
            </div>

        </nav>
    </div>


</template>

<script>

    import { EventBus } from '*/src/eventbus';

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
                searchText: null,
                cartSum: 0,
            };
        },
        watch: {
          isLogin: function (n) {

          },
        },
        created() {
            EventBus.$on('add_cart',() => {
                this.updateCartSum();
            });
        },
        mounted() {
            this.updateCartSum();
        },
        methods: {
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
        },
    }

</script>

<style scoped="scoped">

</style>