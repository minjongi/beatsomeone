<template>
    <div>
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>Refund detail</div>
                </div>
            </div>

            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px; justify-content:flex-start;">
                    <div>
                        <div class="title">{{ $t('orderNumber') }}</div>
                        <div>{{ order.cor_id }}</div>
                    </div>
                    <div>
                        <div class="title">{{ $t('date') }}</div>
                        <div>{{ order.cor_datetime }}</div>
                    </div>
                    <div>
                        <div class="title">{{ $t('status') }}</div>
                        <div v-if="order.cor_status === '1'" class="green">
                            {{ $t('orderComplete') }}
                        </div>
                        <div v-else-if="order.cor_status === '2'" class="red">
                            {{ $t('orderCancel') }}
                        </div>
                        <div v-else class="yellow">
                            {{ $t('deposit') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="title-content">
                <div class="title">
                    <div>
                        <span class="yellow">{{ orderItems.length }}</span>
                        {{ $t('orderedItems') }}
                    </div>
                </div>
            </div>

            <div class="playList productList orderlist" style="margin-top:10px;">
                <ul>
                    <OrderDetailItem v-for="(item, idx) in orderItems" :cor_id="cor_id" :item="item" v-bind:key="idx" :pg="order.cor_pg" />
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="title-content">
                <p>
                    ※- {{ $t('downloadNotAvailableWhenDepositMsg') }}
                    <br/>
                    ※- {{ $t('downloadAvailable60Msg') }}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="payment_box" style="padding-top:0; margin-top:0; border:0;">
                <div class="tab">
                    <div>
                        <div class="title">Method</div>
                        <div>{{ $t(order.cor_pay_type) }}</div>
                    </div>
                    <div>
                        <div class="title">Paid</div>
                        <div class="yellow">{{ formatPr(order.cor_pg, order.cor_refund_price) }}</div>
                    </div>
                    <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);" v-if="order.cor_cancel_datetime">
                        <div class="title">Refund request</div>
                        <div style="opacity:.7; font-weight:lighter;">{{ order.cor_cancel_datetime }}</div>
                    </div>
                    <div v-if="order.cor_refund_datetime">
                        <div class="title">Refund complete</div>
                        <div style="opacity:.7; font-weight:lighter;">{{ order.cor_refund_datetime }}</div>
                    </div>
                    <div>
                        <div class="title">Request Reason</div>
                        <div style="opacity:.7; font-weight:300;">{{ order.cor_memo || '' }}</div>
                    </div>
                    <div>
                        <div style="opacity:.7; font-weight:300;">{{ order.cor_admin_memo }}</div>
                    </div>
                    <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                        <div class="title">Refund</div>
                        <div class="red">{{ formatPr(order.cor_pg, order.cor_refund_price) }}</div>
                    </div>
                    <div>
                        <div class="title">Refund Points</div>
                        <div class="red">{{ order.cor_refund_point }} P</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
            <button class="btn btn--gray" @click="goPage('mycancelList')">{{ $t('backToList') }}</button>
        </div>
    </div>
</template>

<script>
import ParchaseComponent from "./component/Parchase";
import OrderDetailItem from "./OrderDetailItem";
import axios from "axios";

export default {
    components: {
        ParchaseComponent,
        OrderDetailItem,
    },
    data: function () {
        return {
            isLogin: false,
            item: {},
            order: {},
            orderItems: []
        };
    },
    mounted() {
        this.cor_id = this.$route.params.cor_id;
        axios.get(`/cmall/ajax_orderresult/${this.cor_id}`)
            .then(res => res.data)
            .then(data => {
                this.order = data.data;
                if (this.order.cor_refund_point == undefined) this.$set(this.order, 'cor_refund_point', 0);
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
    methods: {
        checkToday: function (date) {
            const input = new Date(date);
            const today = new Date();
            return (
                input.getDate() === today.getDate() &&
                input.getMonth() === today.getMonth() &&
                input.getFullYear() === today.getFullYear()
            );
        },
        getGenre(g1, g2) {
            if (this.isEmpty(g2)) {
                return g1;
            } else {
                return g1 + ", " + g2;
            }
        },
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
        isEmpty: function (str) {
            if (typeof str == "undefined" || str == null || str == "") return true;
            else return false;
        },
        formatPrice: function (kr, en, pg) {
            if (pg === "paypal") {
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
        formatPr: function (m, price) {
            if (m === 'paypal') {
                return '$' + this.formatNumberEn(price);
            } else if (m === 'allat') {
                return '₩' + this.formatNumber(price);
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
        goPage(page) {
            this.$router.push('/' + page);
        }
    },
};
</script>

<style scoped="scoped" lang="css">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";
</style>