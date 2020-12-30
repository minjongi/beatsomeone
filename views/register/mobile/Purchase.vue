<template>
    <div class="wrapper">
        <Header/>
        <PurchaseMembership1 v-if="flag"/>
        <PurchaseMembership v-if="!flag"/>
        <Footer/>
    </div>
</template>

<script>
require('@/assets_m/js/function');

import Header from "@/views/beatsomeone/mobile/include/Header";
import Footer from "@/views/beatsomeone/mobile/include/Footer";
import PurchaseMembership from "./PurchaseMembership";
import PurchaseMembership1 from "./PurchaseMembership1";

export default {
    name: "Purchase",
    components: {PurchaseMembership, PurchaseMembership1, Header, Footer},
    data: function() {
        return {
            flag: false
        }
    },
    mounted() {
        const urlParams = new URLSearchParams(window.location.search);
        const mgrid = urlParams.get('mgr_id');
        if (mgrid > 4) this.flag = true; else this.flag = false;
    }
}
</script>

<style lang="scss">
@import '@/assets_m/scss/App.scss';
</style>