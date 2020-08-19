<template>
    <div class="wrapper">
        <div class="smtm9-top">
            <a href="/smtm9"><img src="/assets/images/event/smtm9/top.jpg"></a>
        </div>
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