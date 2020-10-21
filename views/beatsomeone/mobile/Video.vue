<template>
    <div>
        <Header :is-login="isLogin" />
        <router-view />
        <Footer />
    </div>
</template>

<script>
    import Header from "@/views/beatsomeone/mobile/include/Header";
    import Footer from "@/views/beatsomeone/mobile/include/Footer";

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
            }
        },
    }
</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>