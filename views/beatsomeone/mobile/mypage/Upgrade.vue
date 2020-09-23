<template>
    <div>
        <Header />
        <router-view />
        <Footer />
    </div>
</template>

<script>
    require('@/assets/js/function');

    import axios from 'axios';

    import Header from "@/views/beatsomeone/mobile/include/Header";
    import Footer from "@/views/beatsomeone/mobile/include/Footer";

    export default {
        components: {Header, Footer},
        created() {
        },
        mounted() {
            // 중간 리프레시 초기화
            if (this.$router.currentRoute.path !== '/') {
                this.$router.push({path: '/'});
            }
        },
    }
</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>