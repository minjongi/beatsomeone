<template>
    <div class="wrapper">
        <Header />
        <div class="container">
            <div class="main">
                <section class="main__section1" style="margin-bottom:160px;">
                    <div class="BG" style="background-image:url('/assets/images/cart.png')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>{{ $t('placeAnorder') }}</h1>
                            <div class="step" style="margin-top:30px;">
                                <div class="stage active">
                                    <span>1</span>
                                    {{ $t('cart') }}
                                </div>
                                <div class="stage">
                                    <span>2</span>
                                    {{ $t('pay') }}
                                </div>
                                <div class="stage">
                                    <span>3</span>
                                    {{ $t('payComplete1') }}
                                </div>
                            </div>
                        </header>
                        <div class="row">
                            <div class="title-content">
                                <div class="title" style="justify-content: space-between;">
                                    <label
                                        for="checkAll"
                                        class="checkbox"
                                        style="margin-left:20px; margin-bottom:30px; width: auto;"
                                    >
                                        <input
                                            type="checkbox"
                                            hidden="hidden"
                                            id="checkAll"
                                            v-model="checkedAll"
                                        />
                                        <span></span>
                                        <div
                                            style="font-weight:600"
                                        >{{ $t('selectAll') }} ({{ cntSelectedItems }}/ {{ cartItems.length }})
                                        </div>
                                    </label>
                                    <button
                                        class="btn btn--red"
                                        :class="{'disable': cntSelectedItems === 0}"
                                        style="width:100px; height:40px; margin-bottom:20px; font-size: 14px; font-weight: normal"
                                        @click="goDelete"
                                    >
                                        <img src="/assets/images/icon/bin.png" style="margin-top:-4px;"/>
                                        {{ $t('delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <div v-if="cartItems.length === 0" class="no-text">
                                    <p>{{ msgEmptyCart }}</p>
                                </div>
                                <ul v-else>
                                    <CartItem v-model="item.is_selected" v-for="item in cartItems" v-bind:key="item.cct_id" :item="item"/>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="bottom_bar tab" v-if="cartItems.length > 0">
            <div class="wrap">
                <div>
                    <div class="total">{{ $t('estimatedPaymentAmount') }}</div>
                </div>
                <div>
                    <div class="price">
                      {{ $t('currencySymbol') }}
                      {{ total_amount }}
                    </div>
                    <button class="btn btn--submit" @click="goOrder">{{ $t('payOrder') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
require("@/assets/js/function");
import Header from "../include/Header";
import Footer from "../include/Footer";
import axios from "axios";
import CartItem from './CartItem'

export default {
    components: {
        Header,
        Footer,
        CartItem
    },
    data: function () {
        return {
            cartItems: [],
            totalPriceKr: 0,
            totalPriceEn: 0.0,
            totalPriceJPY: 0.0,
            totalPriceCNY: 0.0,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                checkedAll: true,
            cntSelectedItems: 0,
            msgEmptyCart: "There is no purchaseable list.",
        };
    },
    mounted() {
        this.getCart();
    },
    created() {
    },
    computed: {
      total_amount() {
        if (this.$i18n.locale === "en") {
          return Number(this.totalPriceEn).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
        } else if (this.$i18n.locale === "jp") {
          return Number(this.totalPriceJPY).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
        } else if (this.$i18n.locale === "cn") {
          return Number(this.totalPriceCNY).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false})
        }

        return Number(this.totalPriceKr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
      }
    },
    watch: {
        checkedAll(val) {
            this.cntSelectedItems = 0;
            this.totalPriceKr = 0;
            this.totalPriceEn = 0.0;
            this.totalPriceJPY = 0.0;
            this.totalPriceCNY = 0.0;
            this.cartItems.forEach(item => {
                this.$set(item, 'is_selected', val);
                if (val === true) {
                    this.cntSelectedItems++;
                    if (item.detail[0].isfree == 0) {
                        this.totalPriceKr += (+item.detail[0].cde_price);
                        this.totalPriceEn += (+item.detail[0].cde_price_d);
                        this.totalPriceJPY += (+item.detail[0].cde_price_jpy);
                        this.totalPriceCNY += (+item.detail[0].cde_price_cny);
                    }
                }
            })
        },
        cartItems: {
            deep: true,
            handler(items) {
                this.cntSelectedItems = 0;
                this.totalPriceKr = 0;
                this.totalPriceEn = 0.0;
                this.totalPriceJPY = 0.0;
                this.totalPriceCNY = 0.0;
                items.forEach(item => {
                    if (item.is_selected === true) {
                        this.cntSelectedItems++;
                        if (item.detail[0].isfree == 0) {
                            this.totalPriceKr += (+item.detail[0].cde_price);
                            this.totalPriceEn += (+item.detail[0].cde_price_d);
                            this.totalPriceJPY += (+item.detail[0].cde_price_jpy);
                            this.totalPriceCNY += (+item.detail[0].cde_price_cny);
                        }
                    }
                })
                this.checkedAll = items.length !== 0 && this.cntSelectedItems === items.length;
            }
        }
    },
    methods: {
        getCart() {
            axios.get('/cmall/ajax_cart')
                .then(res => res.data)
                .then(data => {
                    this.cartItems = data;
                    this.cartItems.forEach(item => {
                        this.$set(item, 'is_selected', true);
                    })
                })
                .catch(error => {
                    console.error(error);
                })
        },
        formatPrice: function (kr, en) {
            if (this.$i18n.locale === "ko") {
              return (
                  "₩ " +
                  Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
              );
            } else {
              return (
                  "$ " +
                  Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
              );
            }
        },
        goDelete: function () {
            if (this.cntSelectedItems === 0) {
                alert("삭제할 대상을 선택해주세요");
            } else {
                if (confirm("정말로 삭제하시겠습니까?")) {
                    let formData = new FormData();
                    this.cartItems.forEach(item => {
                        if (item.is_selected === true) {
                            formData.append('chk[]', item.cit_id);
                        }
                    })
                    axios.post('/cmallact/ajax_cart_delete', formData)
                        .then(res => res.data)
                        .then(data => {
                            this.getCart();
                            this.checkedAll = false;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        },
        goOrder: function (id) {
            if (this.cntSelectedItems === 0) {
                alert("주문할 대상을 선택해주세요");
            } else {
                let formData = new FormData();
                this.cartItems.forEach(item => {
                    if (item.is_selected) {
                        formData.append('chk[]', item.cit_id);
                    }
                })
                axios.post('/cmall/ajax_orderstart', formData)
                    .then(res => res.data)
                    .then(data => {
                        console.log("&&&&-------------", data);
                        window.location.href = this.helper.langUrl(this.$i18n.locale, '/cmall/billing');
                    })
                    .catch(error => {
                        console.error(error.response);
                    })
            }
        },
    },
};
</script>


<style lang="scss">
@import "@/assets/scss/App.scss";

// 임시수정 2020-06-04
.select-genre .checkbox {
    font-size: 1rem;
}

.productList {
    .playList__item {
        .option {
            > div {
                flex-direction: column;
            }
        }
    }
}

.mypage.sublist .search-date {
    min-width: 256px;
}

.productList .playList__item > * {
    height: auto;
}

//
.cart .playList__item.other .option {
    padding-right: 48px;
}

.cart .playList__item .option {
    margin-top: 6px !important;
}

// 추가
.cart .playList__item.other .option .active .option_item {
    height: auto !important;
    margin-top: 20px !important;
    margin-bottom: 0 !important;
}
</style>