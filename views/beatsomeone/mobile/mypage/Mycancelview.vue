<template>
    <div style="margin-bottom:100px;">
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title"> Refund detail </div>
                <div class="n-box">
                    <div class="n-flex">
                        <span class="title">{{$t('orderNumber')}}</span> <span style="margin-top: 0; color: rgba(255,255,255,.7);">{{ order.cor_id }}</span>
                    </div>
                    <div class="n-flex">
                        <span class="title">Date</span>
                        <span style="margin-top: 0; color: rgba(255,255,255,.3)">{{ order.cor_datetime }}</span>
                    </div>
                    <div class="n-flex">
                        <span class="title">Status</span> <span class="red"  style="margin-top: 0;">{{ $t(order.status) }}</span>
                    </div>
                </div>
            </div>

            <div class="main__media board inquirylist">

            </div>

        </div>

        <div class="row" style="margin-bottom:10px;">

            <div class="title-content">
                <div class="title">
                    <div><span class="yellow">{{ orderItems.length }}</span> Requested items</div>
                </div>
            </div>

            <div class="playList productList orderlist" style="margin-top:10px;">
                <ul>
                    <li
                            v-for="(item, idx) in orderItems"
                            v-bind:key="idx"
                            class="playList__itembox"
                    >
                        <div class="playList__item playList__item--title other">
                            <div class="n-flex between">
                                <div class="info">
                                    <div class="code">{{ item.item.cit_key }}</div>
                                </div>
                                <div
                                        class="price"
                                        v-if="item.item.cit_lease_license_use === '1' && item.item.cit_mastering_license_use === '1' "
                                        style="color: white;"
                                >{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d,
                                    order.cor_pg) }}
                                </div>
                                <div
                                        class="price"
                                        v-else-if="item.item.cit_lease_license_use === '1' && item.item.cit_mastering_license_use === '0'"
                                        style="color: white;"
                                >{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d,
                                    order.cor_pg) }}
                                </div>
                                <div
                                        class="price"
                                        v-else-if="item.item.cit_mastering_license_use === '1' && item.item.cit_lease_license_use === '0'"
                                        style="color: white;"
                                >{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d,
                                    order.cor_pg) }}
                                </div>
                            </div>

                            <div class="name">
                                <figure class="n-flex" style="margin-right: 0;">
                  <span class="playList__cover">
                    <img
                            v-if="!item.item.cit_file_1"
                            :src="'/assets/images/cover_default.png'"
                            alt
                    />
                    <img v-else :src="'/uploads/cmallitem/' + item.item.cit_file_1" alt/>
                  </span>
                                    <figcaption class="pointer">
                                        <h3 class="playList__title"
                                            v-html="formatCitName(item.item.cit_name,20)"></h3>
                                        <!-- <span class="playList__by">{{ item.order.Item.mem_nickname }}</span>
                                        <span class="playList__bpm">{{ getGenre(item.order.Item.genre, item.order.Item.subgenre) }} | {{ item.order.Item.bpm }}BPM</span>-->
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="col genre" v-html="calcTag(item.item.hashTag)"></div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

        <div class="row">
            <div class="title-content text-info">
                <p>{{$t('downloadNotAvailableWhenDepositMsg')}}</p>
                <p>{{$t('downloadAvailable60Msg')}}</p>
            </div>
        </div>

        <div class="row">
            <div class="payment_box">
                <div class="n-box">
                    <div class="n-flex between">
                        <span class="title">Method</span>
                        <span  style="font-weight: 600;">{{ order.cor_pg }}</span>
                    </div>
                    <div class="n-flex between">
                        <span class="title">Paid</span>
                        <span class="yellow" style="font-weight: 600;">{{ formatPr(order.cor_pg, order.cor_refund_price) }}</span>
                    </div>
                    <div class="n-flex between" style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);" v-if="false">
                        <span class="title">Refund request</span>
                        <span style="opacity:.7; font-weight:normal;">{{ order.cor_request_datetime }}</span>
                    </div>
                    <div class="n-flex between" v-if="false">
                        <span class="title">Refund complete</span>
                        <span style="opacity:.7; font-weight:normal;">{{ order.cor_refund_datetime }}</span>
                    </div>
                    <div class="n-flex between">
                        <span class="title">Request Reason</span>
                        <span style="opacity:.7; font-weight:normal;">{{ order.cor_memo }}</span>
                    </div>
                    <div class="n-flex between">
                        <span style="opacity:.7; font-weight:600;">{{ order.cor_admin_memo }}</span>
                    </div>
                    <div class="n-flex between" style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);" v-if="false">
                        <span class="title">Refund</span>
                        <span class="red">{{ order.cor_memo }}{{ order.cor_refund_price }}</span>
                    </div>
                    <div class="n-flex between" v-if="false">
                        <span class="title">Refund Points</span>
                        <span class="red">0 P</span>
                    </div>
                </div>
            </div>
            <p class="desc">
                <img data-v-6049000a="" src="/assets/images/icon/info_blue.png">
                <span>{{$t('depositWaitingStateSupportCaseMenuMsg')}} <a href="/mypage#/inquiry/">{{$t('shortcut')}}</a></span>
            </p>
        </div>

        <div class="n-flex n-btnbox">
            <button class="btn btn--gray" @click="goPage('/mycancelList')">{{$t('backToList')}}</button>
        </div>
    </div>
</template>


<script>
    import $ from "jquery";
    import WaveSurfer from 'wavesurfer.js';
    import axios from "axios";

    export default {
        components: {
        },
        data: function() {
            return {
                isLogin: false,
                item: {},
                order: {},
                orderItems: []
            };
        },
        mounted(){
            this.cor_id = this.$route.params.cor_id;
            axios.get(`/cmall/ajax_orderresult/${this.cor_id}`)
                .then(res => res.data)
                .then(data => {
                    this.order = data.data;
                    this.orderItems = data.orderdetail;
                    this.orderItems.forEach(item => {
                        this.$set(item, 'is_selected', false);
                    })
                    // this.funcDesc();
                })
                .catch(error => {
                    console.error(error);
                })
        },
        created() {
        },
        methods:{
            goPage(path) {
                this.$router.push(path);
            },
            checkToday: function (date) {
                const input = new Date(date);
                const today = new Date();
                return (
                    input.getDate() === today.getDate() &&
                    input.getMonth() === today.getMonth() &&
                    input.getFullYear() === today.getFullYear()
                );
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
            getGenre(g1, g2) {
                if (this.isEmpty(g2)) {
                    return g1;
                } else {
                    return g1 + ", " + g2;
                }
            },
            formatCitName: function (data, limitLth) {
                var rst;
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
            isEmpty: function (str) {
                if (typeof str == "undefined" || str == null || str == "") return true;
                else return false;
            },
            formatPrice: function (kr, en, simbol) {
                if (simbol == "paypal") {
                    return (
                        "$ " +
                        Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
                    );
                } else {
                    return (
                        "₩ " +
                        Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
                    );
                }
            },
            formatPr: function (pg, price) {
                if (pg === 'paypal') {
                    return '$' + this.formatNumberEn(price);
                } else if (pg === 'allat') {
                    return '₩' + this.formatNumber(price);
                } else {
                    return price
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
            removeReg: function (val) {
                const regExp = /[~!@#$%^&*()_+|'"<>?:{}]/;
                while (regExp.test(val)) {
                    val = val.replace(regExp, "");
                }
                return val;
            },
            calcTag: function (hashTag) {
                let rst = "";
                let tags = hashTag.split(",");
                for (let i in tags) {
                    rst =
                        rst +
                        "<span><button >" +
                        this.removeReg(tags[i]) +
                        "</button></span>";
                }
                return rst;
            },
        }
    }
</script>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .title-content {
        .n-box {
            >div {
                span {
                    margin: 0;
                }
            }
        }
    }

    .title-content {
        justify-content: space-between;

        .title {
            font-size: 14px;
        }

        .n-box {
            .n-flex {
                justify-content: space-between;
            }
        }
    }
</style>