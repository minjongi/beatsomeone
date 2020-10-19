<template>
    <li class="playList__itembox" v-if="item">
        <div class="playList__item playList__item--title other">
            <div class="col name">
                <figure>
                    <div class="playList__cover">
                        <img v-if="!item.item.cit_file_1"
                             :src="'/assets/images/cover_default.png'" alt="">
                        <img v-else
                             :src="'/uploads/cmallitem/' + item.item.cit_file_1"
                             alt="">
                        <i v-if="item.item.is_new"
                           class="label new">N</i>
                    </div>
                    <figcaption class="pointer">
                        <h3 class="playList__title"> {{ formatCitName(item.item.cit_name) }} </h3>
                        <span class="playList__by">by {{ item.item.mem_nickname }}</span>
                    </figcaption>
                </figure>
            </div>

            <div class="col n-option">
                <!-- Option -->
                <div class="option">
                    <!-- BASIC LEASE LICENSE -->
                    <div class="n-box" v-if="item.itemdetail[0].cde_title !== 'STEM'">
                        <div>
                            <button class="playList__item--button">
                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                               @click.self="toggleButton"/></span>
                                <div>
                                    <div class="title" @click.self="toggleButton">{{ $t('lang23') }}</div>
                                    <div class="detail">{{ $t('lang24') }}</div>
                                </div>
                            </button>
                            <ParchaseComponent :item="item.item" :type="'basic'" />
                        </div>
                        <div class="price">
                            {{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d) }}
                        </div>
                    </div>
                    <!-- UNLIMITED STEMS LICENSE -->
                    <div class="n-box" v-else>
                        <div>
                            <button class="playList__item--button">
                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                <div>
                                    <div class="title" @click.self="toggleButton">{{ $t('lang30') }}</div>
                                    <div class="detail">{{ $t('lang31') }}</div>
                                </div>
                            </button>
                            <ParchaseComponent :item="item.item" :type="'mastering'" />
                        </div>
                        <div class="price">
                            {{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import ParchaseComponent from "../component/Parchase";

export default {
    name: "OrderItem",
    props: ['item', 'pg'],
    components: {
        ParchaseComponent
    },
    mounted() {
        console.log(this.pg);
    },
    methods: {
        formatCitName: function (data) {
            var rst;
            var limitLth = 50
            if (limitLth < data.length && data.length <= limitLth * 2) {
                rst = data.substring(0, limitLth) + '<br>' + data.substring(limitLth, limitLth * 2);
            } else if (limitLth < data.length && limitLth * 2 < data.length) {
                rst = data.substring(0, limitLth) + '<br>' + data.substring(limitLth, limitLth * 2) + '...';
            } else {
                rst = data
            }
            return rst;
        },
        formatPrice: function (kr, en) {
            if (this.pg === 'paypal') {
                return '$ ' + Number(en).toLocaleString(undefined, {minimumFractionDigits: 2});
            } else if (this.pg === 'allat') {
                return '₩ ' + Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
            } else {
                return '₩ ' + Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
            }
        },
        toggleButton: function (e) {
            if (e.target.parentElement.parentElement.parentElement.parentElement.className === "n-box") {
                e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box active";
            } else if (e.target.parentElement.parentElement.parentElement.parentElement.className === "n-box active") {
                e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box";
            } else {
                //
            }
        },
    }
}
</script>

<style lang="scss" scoped>

</style>