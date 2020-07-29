<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container sub smtm9">
            <div>
                <img src="/assets/images/event/smtm9/1.jpg">
            </div>
            <div>
                <a href="https://kyh.typeform.com/to/QzFUq3cH" target="_blank"><img src="/assets/images/event/smtm9/2.jpg"></a>
            </div>
            <div>
                <img src="/assets/images/event/smtm9/3.jpg">
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
    require('@/assets/js/function')

    import Header from "../include/Header"
    import Footer from "../include/Footer"

    export default {
        name: 'Index',
        components: {Header, Footer},
        data: function () {
            return {}
        },
    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scope="scope" lang="css">
    .smtm9 {
        text-align:center;
    }
    .smtm9 img {
        max-width:100%;
    }
</style>
