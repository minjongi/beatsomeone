<template>
    <div>
        <Header />
        <router-view />
        <Footer />
    </div>
</template>

<script>
    require('@/assets/js/function');

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";

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
        watch: {},
        methods: {
            goPurchase() {
                if (this.isLogin) {
                    this.$router.push({path: '/pay'});
                }
            },
        },
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>