<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('expiredSoon')}} </div>
            <button @click="goOrderPage" class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>

        <p v-if="data.length === 0" style="text-align: center; opacity: 0.7; font-size: 16px;">
            {{ $t('dashboard_ExpiredSoon_noexists') }}
        </p>

        <div v-if="data.length > 0" >
            <div class="slide">
                <div class="playList" :class="slide_expired == 0 ? 'active' : ''">
                    <ul class="itemContainer">
                        <Dashboard_ExpiredSoon_Item :item="data[0]"></Dashboard_ExpiredSoon_Item>
                        <Dashboard_ExpiredSoon_Item :item="data[1]"></Dashboard_ExpiredSoon_Item>
                    </ul>
                </div>
                <div class="playList" :class="slide_expired == 1 ? 'active' : ''">
                    <ul class="itemContainer">
                    <Dashboard_ExpiredSoon_Item :item="data[2]"></Dashboard_ExpiredSoon_Item>
                    <Dashboard_ExpiredSoon_Item :item="data[3]"></Dashboard_ExpiredSoon_Item>
                    </ul>
                </div>
                <div class="playList" :class="slide_expired == 2 ? 'active' : ''">
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

<!--        <div class="playList" v-if="data.length === 0">-->
<!--            <ul class="itemContainer">-->
<!--                <li class="playList__itembox" >-->
<!--                    <div class="playList__item playList__item&#45;&#45;title active">-->
<!--                        <div class="col name">-->
<!--                            <figure>-->
<!--                                <figcaption>-->
<!--                                    <h3 class="playList__title">Not Exists</h3>-->
<!--                                </figcaption>-->
<!--                            </figure>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </div>-->

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
            goOrderPage() {
                this.$router.push('/mybilling');
            }
        },

    }

</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .itemContainer {
        height: 181px;
    }
</style>