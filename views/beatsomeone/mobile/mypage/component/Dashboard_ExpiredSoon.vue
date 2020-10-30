<template>
    <div class="title-content">
        <h4 class="title">
            {{$t('expiredSoon')}}
            <a class="more" href="/mypage#/mybilling">more <img src="/assets/images/icon/chevron-right.png"/></a>
        </h4>

        <p v-if="data.length === 0" style="text-align: center; opacity: 0.7; font-size: 12px;">
            {{ $t('dashboard_ExpiredSoon_notexists') }}
        </p>


        <div v-if="data.length > 0" >
            <div class="slide">
                <div class="n-flex playList" style="justify-content: center" :class="slide_expired == 0 ? 'active' : ''" v-if="slide_expired === 0">
                    <ul class="itemContainer">
                        <Dashboard_ExpiredSoon_Item :item="data[0]"></Dashboard_ExpiredSoon_Item>
                        <Dashboard_ExpiredSoon_Item :item="data[1]"></Dashboard_ExpiredSoon_Item>
                    </ul>
                </div>
                <div class="n-flex playList" style="justify-content: center" :class="slide_expired == 1 ? 'active' : ''" v-if="slide_expired === 1">
                    <ul class="itemContainer">
                    <Dashboard_ExpiredSoon_Item :item="data[2]"></Dashboard_ExpiredSoon_Item>
                    <Dashboard_ExpiredSoon_Item :item="data[3]"></Dashboard_ExpiredSoon_Item>
                    </ul>
                </div>
                <div class="n-flex playList" style="justify-content: center" :class="slide_expired == 2 ? 'active' : ''" v-if="slide_expired === 2">
                    <ul class="itemContainer">
                    <Dashboard_ExpiredSoon_Item :item="data[4]"></Dashboard_ExpiredSoon_Item>
                    <Dashboard_ExpiredSoon_Item :item="data[5]"></Dashboard_ExpiredSoon_Item>
                    </ul>
                </div>
            </div>
            <div class="slide_navigator">
                <div :class="slide_expired == 0 ? 'active' : ''" @click="slide_expired = 0"></div>
                <div :class="slide_expired == 1 ? 'active' : ''" @click="slide_expired = 1" v-if="data.length > 2"></div>
                <div :class="slide_expired == 2 ? 'active' : ''" @click="slide_expired = 2" v-if="data.length > 4"></div>
            </div>
        </div>
    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import Dashboard_ExpiredSoon_Item from "./Dashboard_ExpiredSoon_Item";

    export default {
        components: {Dashboard_ExpiredSoon_Item},
        props: ['data'],
        data: function () {
            return {
                slide_expired: 0,
            }
        },

        created() {

        },
        mounted() {

        },
        methods: {

        },

    }

</script>

<style scoped="scoped" lang="css">
    @import '/assets_m/plugins/slick/slick.css';
    @import '/assets_m/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    /*.itemContainer {*/
    /*    height: 181px;*/
    /*}*/
</style>