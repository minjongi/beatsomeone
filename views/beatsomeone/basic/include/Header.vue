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
                    <a href="/">HOME</a>
                    <a href="">Free Beats</a>
                    <a href="">Pricing</a>
                    <a href="">Login</a>
                    <a href="">Sign In</a>
                    <a href="" class="header__cart">($0.00)</a>
                </nav>
            </div>
        </div>
    </header>

</template>

<script>

    export default {
        name: 'Header',
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