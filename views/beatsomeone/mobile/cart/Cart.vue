<template>
  <div class="wrapper">
    <Header :is-login="isLogin"></Header>
    <div class="container">
      <div class="main cart-wrap">
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
                <div class="title n-flex between">
                  <label for="checkAll" class="checkbox" style="width: auto;">
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
                    style="font-weight: normal; width: 72px; height: 28px; padding: 0 8px; display: flex; box-sizing: border-box; align-items: center; font-size: 12px; vertical-align: middle;"
                    @click="goDelete"
                  >
                    <img src="/assets/images/icon/bin.png" style="margin-right: 2px; width: 20px;" />
                    {{$t('delete')}}
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div v-if="!showDelete" class="no-text">
                <p>{{msgEmptyCart}}</p>
              </div>
              <div class="playList productList cart">
                <ul>
                  <li
                    v-for="(item, i) in myCart_list"
                    v-bind:key="item.cct_id"
                    class="playList__itembox"
                    :id="'playList__item'+ item.cct_id"
                  >
                    <div class="playList__item playList__item--title other">
                      <div class="n-flex">
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
                        <div class="edit">
                          <button
                            class="btn btn--blue round"
                            style="width: 32px; height:32px; padding:0;"
                            @click="goBuy(item.cit_id)"
                          >
                            <img src="/assets_m/images/icon/buy_now.png" width="12" alt />
                          </button>
                        </div>
                      </div>
                      <div class="n-flex">
                        <div class="col n-option">
                          <!-- Option -->
                          <div class="option">
                            <!-- BASIC LEASE LICENSE -->
                            <!-- UNLIMITED STEMS LICENSE -->
                            <div
                              class="n-box"
                              v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' "
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
                                    >{{$t('basicLeaseLicense')}}</div>
                                    <div class="detail">{{$t('mp3Orwav')}}</div>
                                  </div>
                                  <div
                                    class="price"
                                    v-if="item.detail[0].cit_lease_license_use === '1'"
                                  >{{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}</div>
                                </button>
                                <div class="option_item basic">
                                  <div
                                    class="parchase-description"
                                    :ref="'purchaseDesc' + item.detail.LEASE.cde_id"
                                  >
                                    <p>
                                      <i>
                                        <img src="/assets/images/icon/parchase-info6.png" alt />
                                      </i>
                                      <!-- {{$t('available60Days')}} -->
                                      Profits from performances and can be used in broadcasting
                                    </p>
                                    <p></p>
                                    <p>
                                      <i>
                                        <img src="/assets/images/icon/parchase-info1.png" alt />
                                      </i>
                                      <!-- {{$t('available60Days')}} -->
                                      Available for 60 days
                                    </p>
                                    <p>
                                      <i>
                                        <img src="/assets/images/icon/parchase-info3.png" alt />
                                      </i>
                                      <!-- {{$t('rentedMembersCannotBeRerentedToOthers')}} -->
                                      Unable to register commercial music copyrights
                                    </p>
                                    <p>
                                      <i>
                                        <img src="/assets/images/icon/parchase-info2.png" alt />
                                      </i>
                                      <!-- {{$t('unableToEditArbitrarily')}} -->
                                      Only simple cutting editing is possible
                                    </p>
                                    <p>
                                      <i>
                                        <img src="/assets/images/icon/parchase-info7.png" alt />
                                      </i>
                                      <!-- {{$t('noOtherActivitiesNotAuthorizedByThePlatform')}} -->
                                      Will continue to be sold to the majority other than this buyer
                                    </p>
                                    <div class="copybox">
                                      <span>Seller's copyright must also be partially recognized when registering music copyrights.</span>
                                      <span>If you wish to transfer copyrights, you need to contact the customer center.</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- BASIC LEASE LICENSE -->
                            <!-- UNLIMITED STEMS LICENSE -->
                            <!-- 
                                                        <div class="n-box" v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' ">
                                                            UNLIMITED STEMS LICENSE //둘다 있는경우 lease만 보여주도록함
                                                            <div>
                                                                <button class="playList__item--button" >
                                                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                    <div>
                                                                        <div class="title" @click.self="toggleButton">{{$t('unlimitedStemsLicense')}}</div>
                                                                        <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                                    </div>
                                                                    <div class="price" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                                            {{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2) }}
                                                                        </div>
                                                                </button>
                                                                <div class="option_item unlimited">
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span><span>{{$t('unlimited1')}}</span></div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> {{$t('unlimitedMsg1')}} </span> </div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> {{$t('unlimitedMsg2')}} </span> </div>
                                                                </div>
                                                            </div>
                            </div>-->

                            <!-- BASIC LEASE LICENSE -->
                            <div
                              class="n-box"
                              v-else-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '0'"
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
                                    >{{$t('basicLeaseLicense')}}</div>
                                    <div class="detail">{{$t('mp3Orwav')}}</div>
                                  </div>
                                  <div
                                    class="price"
                                    v-if="item.detail[0].cit_lease_license_use === '1'"
                                  >{{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}</div>
                                </button>
                                <div class="option_item basic">
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info1.png" />
                                    </span>
                                    <span>{{$t('available60Days')}}</span>
                                  </div>
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info2.png" />
                                    </span>
                                    <span>{{$t('unableToEditArbitrarily')}}</span>
                                  </div>
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info3.png" />
                                    </span>
                                    <span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span>
                                  </div>
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info5.png" />
                                    </span>
                                    <span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- UNLIMITED STEMS LICENSE -->
                            <div
                              class="n-box"
                              v-else-if="item.detail[0].cit_mastering_license_use === '1' && item.detail[0].cit_lease_license_use === '0' "
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
                                    >{{$t('unlimitedStemsLicense')}}</div>
                                    <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                  </div>
                                  <div
                                    class="price"
                                    v-if="item.detail[0].cit_mastering_license_use === '1'"
                                  >{{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2) }}</div>
                                </button>
                                <div class="option_item unlimited">
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info4.png" />
                                    </span>
                                    <span>{{$t('unlimited1')}}</span>
                                  </div>
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info4.png" />
                                    </span>
                                    <span>{{$t('unlimitedMsg1')}}</span>
                                  </div>
                                  <div>
                                    <span class="img-box">
                                      <img src="/assets/images/icon/parchase-info4.png" />
                                    </span>
                                    <span>{{$t('unlimitedMsg2')}}</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="col feature">
                                                    <div class="price" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                        {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                    </div>
                                                    <div class="price 2222" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                        {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                    </div>
                        </div>-->
                      </div>
                    </div>
                  </li>
                  <!--
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col check">
                                                <label for="type2" class="checkbox">
                                                    <input type="checkbox" hidden="hidden" id="type2" value="Music Lover">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                        <span class="playList__by"> ( Bpm )</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">{{$t('unlimitedStemsLicensePrice')}}</div>
                                                        <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>{{$t('unlimited')}}</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button class="btn btn--blue round" style="height:40px; padding:0 16px;">{{$t('buyNow')}}</button>
                                            </div>
                                        </div>
                                    </li>

                  -->
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <div class="bottom_bar tab" v-if="0 < cntTotalItems">
      <div class="wrap">
        <div class="n-flex between">
          <div class="total">{{$t('estimatedPaymentAmount')}}</div>
          <div class="price">{{ formatPrice(totalPriceKr, totalPriceDr) }}</div>
        </div>
        <div>
          <button class="btn btn--submit" @click="goOrder">{{$t('payOrder')}}</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
require("@/assets_m/js/function");
import Header from "../include/Header";
import Footer from "../include/Footer";
import Loader from "*/vue/common/Loader";
import axios from "axios";

import $ from "jquery";
import { EventBus } from "*/src/eventbus";

export default {
  components: {
    Header,
    Footer,
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
      disableDelete: true,
      showDelete: false,
      cntSelectedItems: 0,
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
      if (this.checkedAll) {
        for (let i in this.myCart_list) {
          if (this.myCart_list[i].detail[0].cit_lease_license_use == "1") {
            tpkr += Number(this.myCart_list[i].detail[0].cde_price);
            tpen += Number(this.myCart_list[i].detail[0].cde_price_d);
          } else if (
            this.myCart_list[i].detail[0].cit_mastering_license_use == "1"
          ) {
            tpkr += Number(this.myCart_list[i].detail[0].cde_price_2);
            tpen += Number(this.myCart_list[i].detail[0].cde_price_d_2);
          }
          cnt++;
        }
      } else {
        for (let i in this.myCart_list) {
          if (this.checkedItem.includes(this.myCart_list[i].cit_id)) {
            if (this.myCart_list[i].detail[0].cit_lease_license_use == "1") {
              tpkr += Number(this.myCart_list[i].detail[0].cde_price);
              tpen += Number(this.myCart_list[i].detail[0].cde_price_d);
            } else if (
              this.myCart_list[i].detail[0].cit_mastering_license_use == "1"
            ) {
              tpkr += Number(this.myCart_list[i].detail[0].cde_price_2);
              tpen += Number(this.myCart_list[i].detail[0].cde_price_d_2);
            }
            cnt++;
          }
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
        if (confirm("정말로 주문하시겠습니까?")) {
          this.ajaxCartToOrder(this.checkedItem).then(() => {
            window.location.href = "/cmall/billing";
          });
        }
      }
    },
  },
};
</script>


<style lang="scss">
@import "@/assets_m/scss/App.scss";
</style>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

// 충돌문제 2020-06-04
.main .main__section1-title {
  padding-top: 0;
  margin-bottom: 30px;
}

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

// 추가
.option_item.basic {
  height: auto !important;
  margin-top: 15px !important;
  margin-bottom: 0 !important;
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