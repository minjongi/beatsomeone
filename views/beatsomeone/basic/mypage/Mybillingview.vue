<template>
    <div>
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>{{ $t('orderDetail') }}</div>
                </div>
            </div>
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px; justify-content:flex-start;">
                    <div>
                        <div class="title">{{ $t('orderNumber') }}</div>
                        <div>{{ order.cor_id }} <span v-if="order.is_test === '1'">(테스트결제)</span></div>
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
                        <div v-else>
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
                        <div class="title">{{ $t('payMethod1') }}</div>
                        <div>{{ $t(order.cor_pg) }}</div>
                    </div>
                    <div>
                        <div class="title">{{ $t('payMethodDetail') }}</div>
                        <div>{{ $t(order.cor_pay_type) }}</div>
                    </div>
                    <div v-if="false">
                        <div class="title">{{ $t('paySubtotal') }}</div>
                        <div>{{ order.cor_total_money }}</div>
                    </div>
                    <div v-if="false">
                        <div class="title">{{ $t('usePoints') }}</div>
                        <div>0 P</div>
                    </div>
                    <div class="total">
                        <div>{{ $t('payTotal') }}</div>
                        <div>{{ formatPr(order.cor_pg, order.cor_total_money) }}</div>
                    </div>
                </div>
            </div>
            <p class="desc">
                <img src="/assets/images/icon/info_blue.png"/>
                <span v-html="descNoti"></span>
            </p>
        </div>

        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
            <button class="btn btn--gray" @click="goPage('mybilling')">{{ $t('backToList') }}</button>
            <button v-if="order.cor_status ==='1'" @click="toggleRefundModalOpen" type="submit" class="btn btn--submit">
                {{ $t('requestRefund') }}
            </button>
        </div>
        <RefundModal ref="refundModal" :order="order" :items="orderItems" v-if="isRefundModalOpen && order.cor_status === '1'" @dismissModal="doDismissModal"
                     @submitModal="doSubmitModal"/>
        <RefundMemoModal :cor_id="cor_id" v-if="isMemoModalOpen" @dismissModal="doDismissModal2" @submitModal="doSubmitModal2" />
        <main-player></main-player>
    </div>
</template>

<script>
import axios from "axios";
import $ from "jquery";
import MainPlayer from "@/vue/common/MainPlayer";
import ParchaseComponent from "./component/Parchase";
import RefundModal from "*/views/beatsomeone/basic/mypage/RefundModal";
import OrderDetailItem from "./OrderDetailItem";
import RefundMemoModal from "./RefundMemoModal";

export default {
    components: {
        RefundModal,
        MainPlayer,
        ParchaseComponent,
        OrderDetailItem,
        RefundMemoModal
    },
    data: function () {
        return {
            checkedAll: false,
            reqref: 0,
            wavesurfer: null,
            payType: "",
            totalPrice: "",
            order: {},
            descNoti: "",
            orderItems: [],
            total_refunds: 0,
            selectedCount: 0,
            description: '',
            isRefundModalOpen: false,
            isMemoModalOpen: false,
            cor_id: ''
        };
    },
    mounted() {
        this.cor_id = this.$route.params.cor_id;
        axios.get(`/cmall/ajax_orderresult/${this.cor_id}`)
            .then(res => res.data)
            .then(data => {
                this.order = data.data;
                this.orderItems = data.orderdetail;
                this.orderItems.forEach(item => {
                    if (item.item.cit_type3 === '0') {
                        this.$set(item.item, 'is_new', false);
                        let now = new Date();
                        let startDateTime = new Date(item.item.cit_start_datetime);
                        if ((now - startDateTime) < 1000 * 3600 * 24 * 7) this.$set(item.item, 'is_new', true);
                    } else if (item.item.cit_type3 === '1') {
                        this.$set(item.item, 'is_new', true);
                    }
                })
                this.funcDesc();
            })
            .catch(error => {
                console.error(error);
            })
    },
    created() {
    },
    methods: {
        goPage: function (page) {
            this.$router.push('/' + page);
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
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
        },
        formatNumberEn(n) {
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
        },
        funcDesc: function () {
            if (this.order.status === 'deposit') {
                this.descNoti =
                    this.$t("depositWaitingStateSupportCaseMenuMsg") +
                    " " +
                    '<a href="/mypage#/inquiry/">' +
                    this.$t("shortcut") +
                    "</a>";
            } else if (this.order.status === "order") {
                this.descNoti =
                    "If the download period has , the purchased bit cannot be downloaded";
            }
        },
        toggleRefundModalOpen() {
            let el = document.body;
            el.style.overflow = 'hidden'
            this.isRefundModalOpen = !this.isRefundModalOpen;
        },
        doDismissModal() {
            let el = document.body;
            el.style.overflow = 'auto'
            this.isRefundModalOpen = false;
        },
        doSubmitModal() {
            this.isRefundModalOpen = false;
            this.isMemoModalOpen = true;
        },
        doDismissModal2() {
            let el = document.body;
            el.style.overflow = 'auto'

            this.isMemoModalOpen = false;
        },
        doSubmitModal2() {
            let el = document.body;
            el.style.overflow = 'auto'

            this.isMemoModalOpen = false;
            this.$router.push('/');
        },
    },
    watch: {
        orderItems: {
            deep: true,
            handler(val) {
                this.selectedCount = 0;
                this.total_refunds = 0;
                this.orderItems.forEach(item => {
                    if (item.is_selected === true) {
                        this.selectedCount++;
                        if (this.order.cor_memo === '$') {
                            this.total_refunds += (+item.itemdetail[0].cde_price_d);
                        } else if (this.order.cor_memo === '₩') {
                            this.total_refunds += (+item.itemdetail[0].cde_price);
                        }
                    }
                })
                this.checkedAll = this.selectedCount === this.orderItems.length;
            }
        }
    }
};
</script>

<style lang="scss">
.playList__item .n-option .n-box .price {
    color: white;
}

// 추가
.playList__item.other .option .active .option_item {
    height: auto !important;
    margin-top: 20px !important;
    margin-bottom: 0 !important;
}

.purchase-description {
}

.purchase-description p {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    font-size: 14px;
    margin-bottom: 10px;
    line-height: 20px;
}

.purchase-description p:last-child {
    margin-bottom: 0;
}

.purchase-description p i {
    -webkit-box-flex: 0;
    -ms-flex: none;
    flex: none;
    margin-right: 10px;
    width: 20px;
    text-align: center;
    line-height: 20px;
    height: 20px;
}

.purchase-description p {
    margin-bottom: 5px !important;
}

.payment_box .tab {
    display: block;

    > div {
        display: flex;
        justify-content: space-between;
        max-width: unset;

        div:not(.title) {
            text-align: right;
            margin-right: unset;
        }
    }
}

.custom-select.modal-select {
    .options {
        z-index: 1002;
    }
}
</style>