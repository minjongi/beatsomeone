<template>
    <div class="wrapper">
        <div class="page-wrapper">
            <Header :is-login="isLogin"></Header>
            <router-view />
            <Footer />
        </div>
    </div>
</template>

<script>
    import Header from "./include/Header";
    import Footer from "./include/Footer";

    export default {
        components: {
            Header,
            Footer
        },
        data: function () {
            return {
                isLogin: false,
            }
        },
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>