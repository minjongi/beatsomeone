<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title other">
            <div class="col name">
                <figure>
                    <div class="playList__cover">
                        <img
                            v-if="!product.cit_file_1"
                            :src="'/assets/images/cover_default.png'"
                            alt
                        />
                        <img v-else :src="'/uploads/cmallitem/' + product.cit_file_1" alt/>
                        <i v-if="product.is_new" class="label new">N</i>
                    </div>
                    <figcaption class="pointer" @click="goToDetail">
                        <h3 class="playList__title">{{ formatCitName(product.cit_name) }}</h3>
                        <span class="playList__by">by {{ product.mem_nickname }}</span>
                    </figcaption>
                </figure>
            </div>
            <div class="col n-option">
                <!-- Option -->
                <div class="option">
                    <!-- BASIC LEASE LICENSE -->
                    <div
                        class="n-box"
                        v-if="product.cde_title !== 'STEM'"
                    >
                        <div>
                            <button class="playList__item--button">
                                <span class="option_fold">
                                  <img
                                      src="/assets/images/icon/togglefold.png"
                                      @click.self="toggleButton"
                                  />
                                </span>
                                <div>
                                    <div
                                        class="title"
                                        @click.self="toggleButton"
                                    >{{ $t('lang23') }}
                                    </div>
                                    <div class="detail">{{ $t('lang24') }}</div>
                                </div>
                                <div
                                    class="price 11221122"
                                >
                                  {{ $t('currencySymbol') }}
                                  {{ formatPrice(product.detail[0], product.isfree) }}
                                </div>
                            </button>
                            <ParchaseComponent :item="product"
                                               :type="'basic'"></ParchaseComponent>
                        </div>
                    </div>
                    <!-- UNLIMITED STEMS LICENSE -->
                    <div
                        class="n-box"
                        v-else
                    >
                        <div>
                            <button class="playList__item--button">
                                <span class="option_fold">
                                  <img
                                      src="/assets/images/icon/togglefold.png"
                                      @click.self="toggleButton"
                                  />
                                </span>
                                <div>
                                    <div
                                        class="title"
                                        @click.self="toggleButton"
                                    >{{ $t('lang30') }}
                                    </div>
                                    <div class="detail 2222">{{ $t('lang31') }}
                                        <span class="copytransfer" v-if="product.cit_include_copyright_transfer === '1'">{{ $t('lang32') }}</span>
                                    </div>
                                </div>
                                <div
                                    class="price"
                                    v-if="product.detail[0].cit_mastering_license_use === '1'"
                                >
                                  {{ $t('currencySymbol') }}
                                  {{ formatPrice(product.detail[0], product.isfree) }}
                                </div>
                            </button>
                            <ParchaseComponent :item="product"
                                               :type="'mastering'"></ParchaseComponent>
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
    name: "BillingItem",
    components: {
        ParchaseComponent,
    },
    props: [
        'product'
    ],
    methods: {
        formatCitName: function (data) {
            var rst;
            var limitLth = 50;
            if (limitLth < data.length && data.length <= limitLth * 2) {
                rst =
                    data.substring(0, limitLth) +
                    "<br>" +
                    data.substring(limitLth, limitLth * 2);
            } else if (limitLth < data.length && limitLth * 2 < data.length) {
                rst =
                    data.substring(0, limitLth) +
                    "<br>" +
                    data.substring(limitLth, limitLth * 2) +
                    "...";
            } else {
                rst = data;
            }
            return rst;
        },
        formatPrice: function (detail, isfree = '0') {
          if (isfree == '1') {
            return 0
          }

          if (this.$i18n.locale === "en") {
            return Number(detail.cde_price_d).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
          } else if (this.$i18n.locale === "jp") {
            return Number(detail.cde_price_jpy).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
          } else if (this.$i18n.locale === "cn") {
            return Number(detail.cde_price_cny).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
          }

          return Number(detail.cde_price).toLocaleString("ko-KR", {minimumFractionDigits: 0})
        },
        toggleButton: function (e) {
            if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box active";
            } else if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box active"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box";
            } else {
                //
            }
        },
        goToDetail() {
            console.log(this.product);
            window.location.href = this.helper.langUrl(this.$i18n.locale, '/detail/' + this.product.cit_key)
        }
    },
    mounted() {
        console.log(this.product);
    }
}
</script>

<style lang="scss" scoped>
.playList__item .n-option .n-box:first-child .price {
    margin-top: 0;
}

.playList__item.other .active .option_item.unlimited {
    height: 140px;
}

.n-box.active {
    margin-bottom: 0;
}

.playList__item .n-option .n-box .price {
    color: white;
}
</style>