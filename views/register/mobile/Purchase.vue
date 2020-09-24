<template>
    <div class="wrapper">
        <Header/>
        <PurchaseMembership />
        <Footer/>
    </div>
</template>

<script>
require('@/assets_m/js/function');

import Header from "@/views/beatsomeone/mobile/include/Header";
import Footer from "@/views/beatsomeone/mobile/include/Footer";
import PurchaseMembership from "./PurchaseMembership";

export default {
    name: "Purchase",
    components: {
        PurchaseMembership, Header, Footer
    }
}
</script>

<style lang="scss">
@import '@/assets_m/scss/App.scss';
</style>