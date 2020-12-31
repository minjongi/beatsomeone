<template>
    <div class="wrapper">

        <Header />
        <router-view/>
        <Footer />
    </div>

</template>

<script>

    require('@/assets/js/function');

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";

    export default {
        components: {Header, Footer},
        mounted() {
            if (this.$router.currentRoute.path !== '/' && window.location.search !== '?t=pr') {
                window.location.href = '/register'
            }
        },
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style lang="css">

</style>
