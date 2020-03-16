<template>

    <header class="header">
        <div class="wrap">
            <h1 class="header__logo">
                <a href="/"><img src="/assets/images/logo.png" alt=""/></a>
            </h1>
            <div class="header__gnb">
                <div class="header__search">
                    <div>
                        <input type="text" v-model="searchText"/>
                        <button @click="search"></button>
                    </div>
                </div>
                <nav class="header__nav">


                    <a href=""></a>
                    <a href="">Free Beats</a>
                    <a href="">Pricing</a>
                    <a href="/mypage" v-if="isLogin">MyPage</a>


                    <a href="/login/logout?/" v-if="isLogin">Logout</a>
                    <a href="/login" v-if="!isLogin">Login</a>
                    <a href="/register" v-if="!isLogin">Sign In</a>
                    <a href="" class="header__cart" v-if="!isLogin">($0.00)</a>
                </nav>
            </div>
        </div>
    </header>

</template>

<script>

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
            };
        },
        methods: {
            search() {
                const path = `/beatsomeone/sublist?q=${this.searchText}`;
                window.location.href = path;
            },
        },
    }

</script>

<style scoped="scoped">

</style>