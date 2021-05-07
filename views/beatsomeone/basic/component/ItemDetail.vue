<template>
    <div>
        <div class="feature">
            <div class="price yellow">
                {{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, pg) }}
            </div>
        </div>
        <div class="option">
            <div class="n-box" v-if="item.itemdetail[0].cde_title === 'LEASE'">
                <div>
                    <button class="playList__item--button">
                        <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                        <div>
                            <div class="title" @click.self="toggleButton">
                                {{ $t('lang23') }}
                            </div>
                            <div class="detail">{{ $t('lang24') }}</div>
                        </div>
                    </button>
                    <div class="option_item basic">
                        <PurchaseDescLease/>
                    </div>
                </div>
            </div>
            <div class="n-box" v-else-if="item.itemdetail[0].cde_title === 'STEM'">
                <div>
                    <button class="playList__item--button">
                        <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                        <div>
                            <div class="title" @click.self="toggleButton">
                                {{ $t('lang30') }}
                            </div>
                            <div class="detail">{{ $t('lang31') }}
                                <span class="copytransfer" v-if="item.item.cit_include_copyright_transfer === '1'">{{ $t('lang32') }}</span>
                            </div>
                        </div>
                    </button>
                    <div class="option_item basic">
                      <PurchaseDescMastering :includeCopyrightTransfer="item.item.cit_include_copyright_transfer"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PurchaseDescLease from "./PurchaseDescLease"
import PurchaseDescMastering from "./PurchaseDescMastering"

export default {
    components: {
      PurchaseDescLease,
      PurchaseDescMastering
    },
    name: "ItemDetail",
    props: [
        'item',
        'pg'
    ],
    methods: {
        toggleButton: function (e) {
            if (e.target.parentElement.parentElement.parentElement.parentElement.className === "n-box") {
                e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box active";
            } else if (e.target.parentElement.parentElement.parentElement.parentElement.className === "n-box active") {
                e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box";
            } else {
                //
            }
        },
        formatPrice: function (kr, en, pg) {
            if (pg === 'paypal') {
                return '$' + this.formatNumberEn(en);
            } else if (pg === 'allat') {
                return '₩' + this.formatNumber(kr);
            } else {
                return ''
            }
        },
        formatNumber(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
        },
        formatNumberEn(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
        },
        playAudio(i, e) {

        }
    }
}
</script>

<style lang="scss" scoped>
.n-box .playbtn {
    padding: 0;

    button {
        width: 20px;
        height: 20px;
    }

    .timer {
        margin-left: 15px;
    }
}
</style>