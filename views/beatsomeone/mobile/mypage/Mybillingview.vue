<template>
  <div style="margin-bottom:100px;">
    <div class="row" style="margin-bottom:30px;">
      <div class="title-content">
        <h4 class="title">{{ $t('orderDetail') }}</h4>
        <div class="payment_box">
          <div class="n-box">
            <div class="n-flex" style="justify-content: space-between">
              <div>{{ $t('orderNumber') }}</div>
              <div>{{ order.cor_id }}</div>
            </div>
            <div class="n-flex" style="justify-content: space-between">
              <div>{{ $t('date') }}</div>
              <div class="date">{{ order.cor_datetime }}</div>
            </div>
            <div class="n-flex" style="justify-content: space-between;">
              <div>{{ $t('status') }}</div>
              <div v-if="order.cor_status === '1'" :class="{'green': downloadStatus === 1, 'blue': downloadStatus === 0}">
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
    </div>

    <div class="row" style="margin-bottom:10px;">
      <div class="title-content">
        <h4 class="title">
          <span class="yellow">{{ orderItems.length }}</span>
          {{ $t('orderedItems') }}
        </h4>
      </div>

      <div class="playList productList orderlist" style="margin-top:10px;">
        <ul>
          <OrderDetailItem v-for="(item, idx) in orderItems" :cor_id="cor_id" :item="item" v-bind:key="idx" :pg="order.cor_pg" />
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="title-content text-info">
        <p>{{ $t('downloadNotAvailableWhenDepositMsg') }}</p>
        <p>{{ $t('downloadAvailable60Msg') }}</p>
      </div>
    </div>

    <div class="row">
      <div class="payment_box">
        <div class="n-box">
          <div class="n-flex between">
            <span class="title">{{ $t('payMethod1') }}</span>
            <div>{{ $t(order.cor_pg) }}</div>
          </div>
          <div class="n-flex between">
            <span class="title">{{ $t('payMethodDetail') }}</span>
            <div>{{ $t(paymentMethod) }}</div>
          </div>
          <div class="n-flex between">
            <span class="title">{{ $t('paySubtotal') }}</span>
            <div>{{ formatPr(order.cor_pg, order.cor_cash_request) }}</div>
          </div>
          <div class="n-flex between">
            <span class="title">{{ $t('usePoints') }}</span>
            <div v-if="order.cor_point">{{ order.cor_point }} P</div>
            <div v-else>0 P</div>
          </div>
          <div class="n-flex between total">
            <span>{{ $t('payTotal') }}</span>
            <div>{{ formatPr(order.cor_pg, order.cor_total_money - order.cor_point) }}</div>
          </div>
        </div>
      </div>
      <p class="desc">
        <img src="/assets/images/icon/info_blue.png"/>
        <span v-html="descNoti"></span>
      </p>
    </div>

    <div class="n-flex n-btnbox">
      <button class="btn btn--gray" @click="goPage('mybilling')">{{ $t('backToList') }}</button>
      <button v-if="order.cor_status==='1'" @click="toggleRefundModalOpen" class="btn btn--submit">
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
import RefundModal from "./RefundModal";
import RefundMemoModal from "./RefundMemoModal";
import OrderDetailItem from "./OrderDetailItem";

export default {
  components: {
    OrderDetailItem,
    MainPlayer,
    ParchaseComponent,
    RefundMemoModal,
    RefundModal,
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
            this.$set(item, 'is_selected', false);
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
  },
  computed: {
    paymentMethod() {
      if (this.order.cor_pay_type === '3D' || this.order.cor_pay_type === 'NOR') {
        return 'creditCard'
      } else if (this.order.cor_pay_type === 'ABANK') {
        return 'realtimeBankTransfer';
      } else if (this.order.cor_pay_type === 'paypal') {
        return 'paypal';
      } else {
        return '';
      }
    },
    downloadStatus() {
      if (this.orderItems.length > 0) {
        let status = 0;
        this.orderItems.forEach(item => {
          if (item.item.possible_refund === 0) {
            status = 1;
            return false;
          }
        })
        return status;
      } else {
        return 0;
      }
    }
  }
};
</script>

<style scoped="scoped" lang="scss">
.title-content .title {
  font-size: 14px;
  line-height: 16px;
}

.panel {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  padding: 100px 25px 200px;
  overflow-y: auto;
  background: rgba(0, 0, 0, 0.7);
  z-index: 1001;
  transition: 0.3s ease;

  &.active {
    display: block;
  }

  .popup {
    background: #1b1a1f;
    padding: 20px;
    display: none;

    &.active {
      display: block;
    }
  }
}
</style>