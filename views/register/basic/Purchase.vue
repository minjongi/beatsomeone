<template>
    <div class="wrapper">
        <Header/>
        <PurchaseMembership1 v-if="flag"/>
        <PurchaseMembership v-if="!flag"/>
        <Footer/>
    </div>
</template>

<script>
require('@/assets/js/function');

import Header from "@/views/beatsomeone/basic/include/Header";
import Footer from "@/views/beatsomeone/basic/include/Footer";
import PurchaseMembership from "./PurchaseMembership";
import PurchaseMembership1 from "./PurchaseMembership1";

export default {
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
@import '@/assets/scss/App.scss';
</style>