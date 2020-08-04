<template>
  <div class="wrapper">
    <Header :is-login="isLogin"></Header>
    <div class="container">
      <div class="main">
        <section class="main__section1" style="margin-bottom:160px;">
          <div class="BG" style="background-image:url('/assets/images/cart.png')"></div>
          <div class="filter"></div>
          <div class="wrap">
            <header class="main__section1-title">
              <h1>{{$t('placeAnorder')}}</h1>
              <div class="step" style="margin-top:30px;">
                <div class="stage active">
                  <span>1</span>
                  {{$t('cart')}}
                </div>
                <div class="stage">
                  <span>2</span>
                  {{$t('pay')}}
                </div>
                <div class="stage">
                  <span>3</span>
                  {{$t('payComplete1')}}
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
                      @change="setCheckAll"
                    />
                    <span></span>
                    <div
                      style="font-weight:600"
                    >{{$t('selectAll')}} ({{ cntSelectedItems }}/ {{ cntTotalItems }})</div>
                  </label>
                  <button
                    v-show="showDelete"
                    class="btn btn--red"
                    :class="disableDelete ? 'disable' : ''"
                    style="width:100px; height:40px; margin-bottom:20px; font-size: 14px; font-weight: normal"
                    @click="goDelete"
                  >
                    <img src="/assets/images/icon/bin.png" style="margin-top:-4px;" />
                    {{$t('delete')}}
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="playList productList cart">
                <div v-if="!showDelete" class="no-text">
                  <p>{{msgEmptyCart}}</p>
                </div>
                <ul>
                  <li
                    v-for="(item, i) in myCart_list"
                    v-bind:key="item.cct_id"
                    class="playList__itembox"
                    :id="'playList__item'+ item.cct_id"
                  >
                    <div class="playList__item playList__item--title other">
                      <div class="col check">
                        <label :for="'cartItem'+ i" class="checkbox">
                          <input
                            type="checkbox"
                            hidden="hidden"
                            :id="'cartItem'+ i"
                            :value="item.cit_id"
                            v-model="checkedItem"
                            @change="setCheck"
                          />
                          <span></span>
                        </label>
                      </div>
                      <div class="col name">
                        <figure>
                          <span class="playList__cover">
                            <img
                              v-if="!item.cit_file_1"
                              :src="'/assets/images/cover_default.png'"
                              alt
                            />
                            <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt />
                            <i v-show="checkToday(item.cct_datetime)" class="label new">N</i>
                          </span>
                          <figcaption class="pointer">
                            <h3 class="playList__title">{{ formatCitName(item.cit_name) }}</h3>
                            <span class="playList__by">by {{item.detail[0].mem_userid}}</span>
                          </figcaption>
                        </figure>
                      </div>
                      <div class="col n-option">
                        <!-- Option -->
                        <div class="option">
                          <div class="n-box" v-if="item.cde_id === item.detail[0].cde_id">
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
                                  >{{$t('lang23')}}</div>
                                  <div class="detail">{{$t('lang24')}}</div>
                                </div>
                                <div
                                  class="price"
                                >{{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}</div>
                              </button>
                              <ParchaseComponent :item="item" :type="'basic'"></ParchaseComponent>
                            </div>
                          </div>
                          <div class="n-box" v-if="item.cde_id === item.detail[0].cde_id_2">
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
                                  >{{$t('lang30')}}</div>
                                  <div class="detail">{{$t('lang31')}}</div>
                                </div>
                                <div
                                  class="price"
                                >{{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2) }}</div>
                              </button>
                              <ParchaseComponent :item="item" :type="'mastering'"></ParchaseComponent>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col feature">
                                                <div class="price" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                    {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                </div>
                                                <div class="price" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                    {{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2) }}
                                                </div>
                      </div>-->
                      <div class="col edit">
                        <button
                          class="btn btn--blue round"
                          style="height:40px; padding:0 16px;"
                          @click="goBuy(item.cit_id)"
                        >{{$t('buyNow')}}</button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <div class="bottom_bar tab" v-if="0 < cntTotalItems">
      <div class="wrap">
        <div>
          <div class="total">{{$t('estimatedPaymentAmount')}}</div>
        </div>
        <div>
          <div class="price">{{ formatPrice(totalPriceKr, totalPriceDr) }}</div>
          <button class="btn btn--submit" @click="goOrder">{{$t('payOrder')}}</button>
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
import ParchaseComponent from "../component/Parchase";

export default {
  components: {
    Header,
    Footer,
    ParchaseComponent
  },
  data: function () {
    return {
      isLogin: false,
      isLoading: false,
      myCart_list: [],
      totalPriceKr: "0",
      totalPriceDr: "00.00",
      selectedItem: null,
      checkedAll: false,
      checkedItem: [],
      cntTotalItems: 0,
      cntSelectedItems: 0,
      showDelete: false,
      disableDelete: true,
      msgEmptyCart: "There is no purchaseable list.",
    };
  },
  mounted() {},
  created() {
    this.ajaxCartList();
  },
  watch: {
    uudidl() {
      //console.log(this.$parent);
    },
  },
  methods: {
    async ajaxCartList() {
      try {
        this.isLoading = true;
        const { data } = await axios.get(
          "/beatsomeoneApi/get_user_cart_list",
          {}
        );
        console.log(data);
        /*
                data.forEach(function(d){
                    console.log(d.cit_datetime);
                    console.log(d.cit_start_datetime);
                });*/
        this.myCart_list = data;
        this.cntTotalItems = this.myCart_list.length;
        if (this.cntTotalItems == 0) {
          this.showDelete = false;
        } else {
          this.showDelete = true;
        }
      } catch (err) {
        console.log("ajaxCartList error");
      } finally {
        this.isLoading = false;
      }
    },
    async ajaxDeleteCart() {
      try {
        this.isLoading = true;
        var param = new FormData();
        param.append("chk", JSON.stringify(this.checkedItem));
        const { data } = await axios.post(
          "/beatsomeoneApi/delete_user_cart",
          param,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        console.log(data);
        this.totalPrice = 0.0;
      } catch (err) {
        console.log("ajaxDeleteCart error");
      } finally {
        this.isLoading = false;
      }
    },
    async ajaxCartToOrder(items) {
      try {
        this.isLoading = true;
        var param = new FormData();
        param.append("chk", JSON.stringify(items));
        const { data } = await axios.post(
          "/beatsomeoneApi/user_cart_to_order",
          param,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        console.log(data);
      } catch (err) {
        console.log("ajaxCartToOrder error");
      } finally {
        this.isLoading = false;
      }
    },
    formatNumber(n) {
      //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
      return Number(n).toLocaleString(undefined, { minimumFractionDigits: 0 });
    },
    formatPrice: function (kr, en) {
      if (this.$i18n.locale === "en") {
        return (
          "$ " +
          Number(en).toLocaleString(undefined, { minimumFractionDigits: 2 })
        );
      } else {
        return (
          "₩ " +
          Number(kr).toLocaleString("ko-KR", { minimumFractionDigits: 0 })
        );
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
    setCheckAll: function (e) {
      this.checkedItem = [];
      //console.log(this.checkedAll);
      if (this.checkedAll) {
        for (var i in this.myCart_list) {
          //console.log(i);
          this.checkedItem.push(this.myCart_list[i].cit_id);
        }
        this.disableDelete = false;
      } else {
        this.disableDelete = true;
      }
      this.calcTotalPrice();
    },
    setCheck: function () {
      this.checkedAll = false;
      this.disableDelete = false;
      this.calcTotalPrice();
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
    calcTotalPrice: function () {
      let tpkr = 0.0;
      let tpen = 0.0;
      let cnt = 0;

      for (let i in this.myCart_list) {
        if (this.checkedItem.includes(this.myCart_list[i].cit_id)) {
          if (
            this.myCart_list[i].cde_id ===
            this.myCart_list[i].detail[0].cde_id_2
          ) {
            tpkr += Number(this.myCart_list[i].detail[0].cde_price_2);
            tpen += Number(this.myCart_list[i].detail[0].cde_price_d_2);
          } else {
            tpkr += Number(this.myCart_list[i].detail[0].cde_price);
            tpen += Number(this.myCart_list[i].detail[0].cde_price_d);
          }
          cnt++;
        }
      }

      this.totalPriceKr = tpkr;
      this.totalPriceDr = tpen;
      this.cntSelectedItems = cnt;
      if (0 == this.cntSelectedItems) {
        this.disableDelete = true;
      } else {
        this.disableDelete = false;
      }
    },
    goDelete: function () {
      if (this.checkedItem.length == 0) {
        alert("삭제할 대상을 선택해주세요");
        return;
      } else {
        if (confirm("정말로 삭제하시겠습니까?")) {
          this.ajaxDeleteCart().then(() => {
            this.ajaxCartList();
          });
          this.checkedItem = [];
          this.calcTotalPrice();
          this.checkedAll = false;
          this.cntSelectedItems = 0;
          this.disableDelete = true;
        }
      }
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
    goBuy: function (id) {
      let items = [];
      console.log(id);
      items.push(id);
      this.ajaxCartToOrder(items).then(() => {
        window.location.href = "/cmall/billing";
      });
    },
    goOrder: function (id) {
      if (this.checkedItem.length == 0) {
        alert("주문할 대상을 선택해주세요");
        return;
      } else {
        this.ajaxCartToOrder(this.checkedItem).then(() => {
          window.location.href = "/cmall/billing";
        });
      }
    },
  },
};
</script>


<style lang="scss">
@import "@/assets/scss/App.scss";
</style>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

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
.playList__item--button {
  display: flex;
  flex-direction: row;
  color: white;
  text-align: left;
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
.playList__item .n-option .n-box:first-child .price {
  margin-top: 0;
}
.playList__item.other .active .option_item.unlimited {
  height: 140px;
}
.cart .playList__item .option {
  margin-top: 6px !important;
}
.n-box.active {
  margin-bottom: 0;
}
.playList__item .n-option .n-box .price {
  color: white;
}

// 추가
.cart .playList__item.other .option .active .option_item {
  height: auto !important;
  margin-top: 20px !important;
  margin-bottom: 0 !important;
}
.parchase-description {
}
.parchase-description p {
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
.parchase-description p:last-child {
  margin-bottom: 0;
}
.parchase-description p i {
  -webkit-box-flex: 0;
  -ms-flex: none;
  flex: none;
  margin-right: 10px;
  width: 20px;
  text-align: center;
  line-height: 20px;
  height: 20px;
}
.parchase-description p {
  margin-bottom: 5px !important;
}
</style>