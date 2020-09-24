<template>
    <div class="wrapper">
        <Header/>
        <PurchaseMembership/>
        <Footer/>
    </div>
</template>

<script>
require('@/assets/js/function');

import Header from "@/views/beatsomeone/basic/include/Header";
import Footer from "@/views/beatsomeone/basic/include/Footer";
import PurchaseMembership from "./PurchaseMembership";

export default {
    components: {PurchaseMembership, Header, Footer},
}
</script>

<style lang="scss">
@import '@/assets/scss/App.scss';
</style>