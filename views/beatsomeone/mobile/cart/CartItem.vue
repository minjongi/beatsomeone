<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title other">
            <div class="n-flex" style="align-items: center">
                <div class="col check">
                    <label class="checkbox">
                        <input
                            type="checkbox"
                            hidden="hidden"
                            :value="item.cit_id"
                            v-model="checked"
                        />
                        <span></span>
                    </label>
                </div>
                <div class="col name">
                    <figure>
                        <div class="playList__cover">
                            <img :src="(!item.thumb) ? '/assets/images/cover_default.png' : '/uploads/cmallitem/' + item.thumb" alt/>
                            <i v-if="item.is_new" class="label new">N</i>
                        </div>
                        <figcaption class="pointer">
                            <h3 class="playList__title">{{
                                    truncate(item.cit_name, 20)
                                }}</h3>
                            <span
                                class="playList__by">by {{
                                    item.mem_nickname
                                }}</span>
                        </figcaption>
                    </figure>
                </div>
                <div class="edit" style="text-align: right">
                    <button
                        class="btn btn--blue round"
                        style="width: 32px; height:32px; padding:0;"
                        @click="goBuy(item.cit_id)"
                    >
                        <img src="/assets_m/images/icon/buy_now.png" width="12" alt/>
                    </button>
                    
                </div>
            </div>
            <div class="n-flex">
                <div class="col n-option">
                    <!-- Option -->
                    <div class="option" v-if="item.detail[0].cde_title === 'LEASE'">
                        <div class="n-box">
                            <div>
                                <!-- <div style="display:flex;"> -->
                                    <button class="playList__item--button">
                                        <span class="option_fold">
                                            <img
                                                src="/assets/images/icon/togglefold.png"
                                                @click.self="toggleButton"
                                            />
                                        </span>
                                        <div>
                                            <div class="title" style="font-size: 12px;" @click.self="toggleButton">
                                                {{ $t('lang23') }}
                                            </div>
                                            <div class="detail">{{ $t('lang24') }}</div>
                                        </div>
                                        <div class="price" style="margin-top: 5px; font-size: 12px;">
                                          {{ $t('currencySymbol') }}
                                          {{ formatPrice(item.detail[0], item.isfree) }}
                                        </div>
                                    </button>
                                   
                                <!-- </div> -->
                                <div class="option_item basic">
                                  <PurchaseDescLease/>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="option basic" v-else-if="item.detail[0].cde_title === 'STEM'">
                        <div class="n-box">
                            <div>
                                <button class="playList__item--button">
                                  <span class="option_fold">
                                    <img
                                        src="/assets/images/icon/togglefold.png"
                                        @click.self="toggleButton"
                                    />
                                  </span>
                                    <div>
                                        <div class="title" style="font-size: 12px;" @click.self="toggleButton">
                                            {{ $t('lang30') }}
                                        </div>
                                        <div class="detail">{{ $t('lang31') }}
                                            <span class="copytransfer" v-if="item.cit_include_copyright_transfer === '1'">{{ $t('lang32') }}</span>
                                        </div>
                                    </div>
                                </button>
                                <div class="option_item unlimited">
                                  <PurchaseDescMastering :includeCopyrightTransfer="item.cit_include_copyright_transfer"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import axios from "axios";
import ItemDetail from "../component/ItemDetail";
import PurchaseDescLease from "../component/PurchaseDescLease"
import PurchaseDescMastering from "../component/PurchaseDescMastering"

export default {
    name: "CartItem",
    props: ['item', "value"],
    components: {
        ItemDetail,
        PurchaseDescLease,
        PurchaseDescMastering
    },
    computed: {
        checked: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    mounted() {
        console.log(this.item);
    },
    methods: {
        truncate(str, n) {
            return (str.length > n) ? str.substr(0, n - 1) + '...' : str;
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
        goBuy: function () {
            let formData = new FormData();
            formData.append('chk[]', this.item.cit_id);
            axios.post('/cmall/ajax_orderstart', formData)
                .then(res => res.data)
                .then(data => {
                    window.location.href = this.helper.langUrl(this.$i18n.locale, '/cmall/billing');
                })
                .catch(error => {
                    console.error(error.response);
                })
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
    }
}
</script>

<style lang="scss" scoped>
.purchase-description p {
    margin-bottom: 5px !important;
    display: flex;
    align-items: flex-start;
    font-size: 10px;
    line-height: 20px;

    i {
        flex: none;
        margin-right: 10px;
        width: 20px;
        text-align: center;
        line-height: 20px;
        height: 20px;
    }
}
</style>