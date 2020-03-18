<template>

    <header class="header">
        <div class="wrap">
            <h1 class="header__logo">
                <a href="/"><img src="@/assets_m//images/logo.png" alt=""/></a>
            </h1>
            <div class="header__btnbox">
                <a href="" class="header__search"></a>
                <a href="" class="header__nav"></a>
            </div>
        </div>
    </header>

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