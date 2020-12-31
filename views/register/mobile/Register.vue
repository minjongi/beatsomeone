<template>
    <div class="wrapper">
        <Header/>
        <router-view/>
        <Footer/>
    </div>

</template>

<script>

require('@/assets_m/js/function');

import Header from "@/views/beatsomeone/mobile/include/Header";
import Footer from "@/views/beatsomeone/mobile/include/Footer";

export default {
    components: {Header, Footer},
    created() {
    },
    mounted() {
        // 중간 리프레시 초기화
        if (this.$router.currentRoute.path !== '/' && window.location.search !== '?t=pr') {
            this.$router.push({path: '/'});
        }
    },
}
</script>

<style lang="scss">
@import '@/assets_m/scss/App.scss';
</style>

<style lang="css">

</style>
