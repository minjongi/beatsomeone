<template>
    <div class="wrapper">
        <Header></Header>
        <div class="container">
            <div class="main">
                <section class="main__section1" style="margin-bottom:160px;">
                    <div class="BG" style="background-image:url('/assets/images/cart.png')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>{{$t('placeAnorder')}}</h1>
                            <div class="step" style="margin-top:30px;">
                                <div class="stage active done">
                                    <span>1</span>
                                    {{$t('cart')}}
                                </div>
                                <div class="stage active">
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
                            <div
                                    class="checkbox"
                                    style="margin-left:20px; margin-bottom:30px; font-weight:600; cursor: auto;"
                            >
                                <div class="number">{{ orderProducts.length }}</div>
                                {{$t('selectedItems')}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <BillingItem v-for="(product) in orderProducts" :key="product.cct_id" :product="product" />
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="payment_box" style="max-width:initial!important">
                                <div>
                                    <div class="title-content">
                                        <div class="title">{{$t('payMethod')}}</div>
                                        <div v-if="currentLocale === 'ko'">
                                          <div>
                                            <label class="checkbox" for="method1" style="margin-bottom: 10px;">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method1"
                                                  hidden="hidden"
                                                  :value="1"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div class="icon credit"></div>
                                                <div style="font-size:14px;">{{$t('creditCard')}}</div>
                                              </div>
                                            </label>
                                            <label class="checkbox" for="method4">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method4"
                                                  hidden="hidden"
                                                  :value="3"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div style="font-size:14px;" id="payco_btn_type_A1">
                                                  <img src="/assets/images/payco_white_unselect@3x.png" class="payco-logo" v-show="pay_type !== 3">
                                                  <img src="/assets/images/payco_black_select@3x.png" class="payco-logo" v-show="pay_type === 3">
                                                </div>
                                              </div>
                                            </label>
                                          </div>
                                          <div>
                                            <label class="checkbox" for="method2">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method2"
                                                  hidden="hidden"
                                                  :value="2"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div class="icon wire"></div>
                                                <div style="font-size:14px;">{{$t('realtimeBankTransfer')}}</div>
                                              </div>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="payco-desc" v-if="pay_type === 3">
                                          PAYCO는 온/오프라인 쇼핑은 물론 송금, 멤버십 적립까지 가능한 통합 서비스입니다.<br/>
                                          - 지원카드: 모든 국내 신용/체크카드
                                        </div>
                                        <div v-if="currentLocale === 'en'">
                                          <div>
                                            <label class="checkbox" for="method3" style="margin-bottom: 10px;">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method3"
                                                  hidden="hidden"
                                                  :value="4"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div class="icon paypal"></div>
                                                <div style="font-size:14px;">PayPal</div>
                                              </div>
                                            </label>
                                            <label class="checkbox" for="method6">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method6"
                                                  hidden="hidden"
                                                  :value="6"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div style="font-size:14px;">WechatPay</div>
                                              </div>
                                            </label>
                                          </div>
                                          <div>
                                            <label class="checkbox" for="method5" style="margin-bottom: 10px;">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method5"
                                                  hidden="hidden"
                                                  :value="5"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div style="font-size:14px;">Credit Card</div>
                                              </div>
                                            </label>
                                            <label class="checkbox" for="method7">
                                              <input
                                                  type="radio"
                                                  name="method"
                                                  id="method7"
                                                  hidden="hidden"
                                                  :value="7"
                                                  v-model="pay_type"
                                              />
                                              <div class="btn btn--yellow" style="height:48px">
                                                <div style="font-size:14px;">Alipay</div>
                                              </div>
                                            </label>
                                          </div>
                                        </div>
                                        <div v-if="currentLocale === 'jp'">
                                          <label class="checkbox" for="method8">
                                            <input
                                                type="radio"
                                                name="method"
                                                id="method8"
                                                hidden="hidden"
                                                :value="8"
                                                v-model="pay_type"
                                            />
                                            <div class="btn btn--yellow" style="height:48px">
                                              <div style="font-size:14px;">Credit Card</div>
                                            </div>
                                          </label>
                                        </div>
                                    </div>

                                    <div class="title-content">
                                        <div div class="title">{{$t('point')}}</div>
                                        <div>
                                            <div class="input_wrap inputbox unit" style="height:48px">
                                                <input type="number" value="0" v-model="cor_point"/>
                                                <span>P</span>
                                            </div>
<!--                                            <button-->
<!--                                                    class="btn btn&#45;&#45;blue"-->
<!--                                                    style="width:100px;height:48px;margin-left:-10px;"-->
<!--                                            >{{$t('use')}}-->
<!--                                            </button>-->
                                        </div>
                                        <p style="display:inline-block;">
                                            <span>{{ remPoint }}</span>
                                            P {{$t('left')}}
                                        </p>
                                    </div>
                                </div>
                                <div class="tab">
                                    <div>
                                        <div class="title">{{$t('paySubtotal')}}</div>
                                        <div>{{ formatPrice(good_mny, good_mny_d, true) }}</div>
                                    </div>
                                    <div>
                                        <div class="title">{{$t('points')}}</div>
                                        <div>{{ cor_point }} P</div>
                                    </div>
                                    <div class="total">
                                        <div>{{$t('payTotal2')}}</div>
                                        <!--                                        <div>{{ formatPrice(totalPriceKr - usePoint, totalPriceEn - usePoint, true) }}-->
                                        <!--                                        </div>-->
                                        <div>{{ formatPrice(good_mny - cor_point, good_mny_d - cor_point, true) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="!freebeatPay">
                            <div
                                    class="btnbox col"
                                    style="width:50%; margin:30px auto 100px;"
                                    v-if="currentLocale === 'ko'"
                            >
                                <button class="btn btn--gray" @click="goBack">{{$t('back')}}</button>
                                <button type="submit" class="btn btn--submit" @click="goPay">{{$t('pay')}}</button>
                            </div>
                            <div
                                    class="btnbox col"
                                    style="width:50%; margin:30px auto 100px;"
                                    v-if="currentLocale === 'en'"
                            >
                                <button class="btn btn--gray mr-3" style="height:47px;" @click="goBack">{{$t('back')}}</button>
                                <PayPal v-if="isEmptyPaypal === false && pay_type === 4"
                                        :env="pg_paypal_env"
                                        currency="USD"
                                        locale="en_US"
                                        :amount="total_money_d"
                                        :client="paypal"
                                        :invoice-number="orderNo"
                                        :button-style="paypalBtnStyle"
                                        @payment-authorized="paypalAuthorized"
                                        @payment-completed="paypalCompleted"
                                        @payment-cancelled="paypalCancelled"
                                ></PayPal>
                                <button v-if="pay_type !== 4" type="submit" class="btn btn--submit" @click="goPayletter">{{$t('pay')}}</button>
                            </div>
                            <div
                                class="btnbox col"
                                style="width:50%; margin:30px auto 100px;"
                                v-if="currentLocale === 'jp'"
                            >
                              <button class="btn btn--gray" @click="goBack">{{$t('back')}}</button>
                              <button type="submit" class="btn btn--submit" @click="goPayletter">{{$t('pay')}}</button>
                            </div>
                        </div>
                        <div v-else>
                            <div
                                    class="btnbox col"
                                    style="width:50%; margin:30px auto 100px;"
                            >
                                <button class="btn btn--gray" @click="goBack">{{$t('back')}}</button>
                                <button type="button" class="btn btn--submit" @click="procFreebeatPay">{{$t('pay')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div>
            <form name="fm1" method="POST" action="/pg/allat/proc">
                <input type="text" name="allat_shop_id" v-model="allatForm.shop_id" maxlength="20"/>
                <!--주문번호-->
                <input type="text" name="allat_order_no" v-model="allatForm.order_no" maxlength="70"/>
                <!--승인금액-->
                <input type="hidden" name="allat_amt" v-model="allatForm.amt" maxlength="10"/>
                <!--회원ID-->
                <input type="hidden" name="allat_pmember_id" v-model="allatForm.pmember_id" maxlength="20"/>
                <!--상품코드-->
                <input type="hidden" name="allat_product_cd" v-model="allatForm.product_cd" maxlength="1000"/>
                <!--상품명-->
                <input type="hidden" name="allat_product_nm" v-model="good_name" maxlength="1000"/>
                <!--결제자성명-->
                <input type="hidden" name="allat_buyer_nm" v-model="allatForm.buyer_nm" maxlength="20"/>
                <!--수취인성명-->
                <input type="hidden" name="allat_recp_nm" v-model="allatForm.recp_nm" maxlength="20"/>
                <!--수취인주소-->
                <input type="hidden" name="allat_recp_addr" v-model="allatForm.recp_addr" maxlength="120"/>
                <!--인증정보수신URL-->
                <input type="hidden" name="shop_receive_url" v-model="allatForm.shop_receive_url" size="19"/>
                <!--주문정보암호화필드-->
                <input type="hidden" name="allat_enc_data" value/>
                <!--테스트 여부-->
                <input type="hidden" name="allat_test_yn" v-model="allatForm.test_yn" maxlength="1"/>
                <input type="hidden" name="allat_card_yn" v-model="allatForm.card_yn" maxlength="1"/>
                <input type="hidden" name="allat_bank_yn" v-model="allatForm.bank_yn" maxlength="1"/>
                <input type="hidden" name="allat_vbank_yn" v-model="allatForm.vbank_yn" maxlength="1"/>
                <input type="hidden" name="allat_encode_type" value="U"/>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import PayPal from "vue-paypal-checkout";

    require("@/assets/js/function");

    import Header from "../include/Header";
    import Footer from "../include/Footer";
    import BillingItem from './BillingItem'

    export default {
        name: "BillingNew",
        components: {
            Header,
            Footer,
            PayPal,
            BillingItem
        },
        data: function () {
            return {
                orderProducts: [],
                pay_type: 1,
                mem_point: 0,
                good_mny: 0,
                good_mny_d: 0,
                freebeatPay: false,
                allatForm: {
                    shop_id: "",
                    order_no: "",
                    amt: "",
                    pmember_id: "",
                    product_cd: "",
                    product_nm: "",
                    buyer_nm: "",
                    recp_nm: "",
                    recp_addr: "",
                    shop_receive_url: window.allat_shop_receive_url,
                    test_yn: "N",
                    card_yn: "Y",
                    bank_yn: "N",
                    vbank_yn: "N",
                    encode_type: "U",
                    enc_data: "",
                },
                pg_paypal_env: '',
                paypal: {},
                paypalBtnStyle: {
                    label: "pay",
                    size: "large",
                    shape: "rect",
                },
                payletter: {
                  currency: 'USD',
                  pg_info: 'PLCreditCardMpi'
                },
                isEmptyPaypal: true,
                unique_id: '',
                good_name: '',
                member: {},
                cor_point: 0
            }
        },
        computed: {
            currentLocale() {
                return this.$i18n.locale;
            },
            orderNo() {
                return this.unique_id || "none";
            },
            remPoint() {
                return this.mem_point - this.cor_point;
            },
            total_money_d() {
                return Number(this.good_mny_d - this.cor_point).toLocaleString('en-US', {minimumFractionDigits: 2, useGrouping: false});
            }
        },
        mounted() {
            axios.get('/payment/pg_config')
                .then(res => res.data)
                .then(data => {
                    this.use_pg_test = +data.use_pg_test;
                    this.paypal.sandbox = data.sandbox;
                    this.paypal.production = data.production;
                    if (this.use_pg_test === 1) {
                        this.pg_paypal_env = 'sandbox';
                        this.$set(this.allatForm, 'test_yn', 'Y');
                    } else {
                        this.pg_paypal_env = 'production';
                        this.$set(this.allatForm, 'test_yn', 'N');
                    }
                    this.$set(this.allatForm, 'shop_id', data.allat_shop_id);
                    this.isEmptyPaypal = Object.keys(this.paypal).length === 0;
                })
                .catch(error => {
                    console.error(error);
                });
            axios.get('/cmall/ajax_order')
                .then(res => res.data)
                .then(data => {
                    this.orderProducts = data.data;
                    this.good_mny = 0;
                    this.good_mny_d = 0;
                    let product_cds = [];
                    let product_nms = [];
                    this.orderProducts.forEach(item => {
                        if (item.isfree == 0) {
                            this.good_mny_d += (+item.detail[0].cde_price_d);
                            this.good_mny += (+item.detail[0].cde_price);
                        }
                        product_cds.push(item.cit_key);
                        product_nms.push(item.cit_name);
                        if (item.cit_type3 === '0') {
                            this.$set(item, 'is_new', false);
                            let now = new Date();
                            let startDateTime = new Date(item.cit_start_datetime);
                            if ((now - startDateTime) < 1000 * 3600 * 24 * 7) this.$set(item, 'is_new', true);
                        } else if (item.cit_type3 === '1') {
                            this.$set(item, 'is_new', true);
                        }
                    });
                    if (this.good_mny_d == 0) {
                        this.freebeatPay = true;
                    }
                    this.unique_id = data.unique_id;
                    this.good_name = data.good_name;
                    this.$set(this.allatForm, 'product_cd', product_cds.join('||'))
                    this.$set(this.allatForm, 'product_nm', product_nms.join('||'))
                    this.$set(this.allatForm, 'order_no', this.unique_id);
                    this.$set(this.allatForm, 'amt', this.good_mny);
                })
                .catch(error => {
                    console.error(error);
                })
            this.member = window.member;
            this.mem_point = (+this.member.mem_point);
            let mem_name = this.member.mem_firstname + ' ' + this.member.mem_lastname;
            if (!mem_name.trim()) {
                mem_name = this.member.mem_nickname || this.member.mem_id;
            }
            this.$set(this.allatForm, 'buyer_nm', mem_name);
            this.$set(this.allatForm, 'pmember_id', this.member.mem_userid);
            let address = this.member.mem_address1 + ' ' + this.member.mem_address2 + ' ' + this.member.mem_address3 + ' ' + this.member.mem_address4;
            if (!address.trim()) {
                address = this.member.mem_email || this.member.mem_id;
            }
            this.$set(this.allatForm, 'recp_addr', address);
            this.$set(this.allatForm, 'recp_nm', mem_name);

            if (this.$i18n.locale === "en") {
              this.pay_type = 4
            } else if (this.$i18n.locale === "jp") {
              this.pay_type = 8
            }
        },
        methods: {
            formatPrice: function (kr, en, symbol) {
                if (!symbol) {
                    if (this.$i18n.locale === "ko") {
                      return kr;
                    } else {
                      return en;
                    }
                }
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
            procFreebeatPay: function (amt = 0) {
                let formData2 = new FormData();
                formData2.append('pay_type', 'free');
                formData2.append('cor_pg', (this.$i18n.locale === "ko" ? 'allat' : 'paypal'));
                formData2.append('unique_id', this.unique_id);
                formData2.append('good_mny', amt);
                formData2.append('cor_point', this.cor_point);
                formData2.append('mem_realname', this.member.mem_lastname + this.member.mem_firstname);
                axios.post('/cmall/ajax_orderupdate', formData2)
                    .then(res => res.data)
                    .then(data => {
                        window.location.href = this.helper.langUrl(this.$i18n.locale, "/cmall/complete/" + this.unique_id);
                    })
                    .catch(error => {
                        if (error.response) {
                            alert(error.response.data.message);
                        }
                        console.error(error);
                    });
            },
            procAllPointPay: function () {
              if (parseInt(this.allatForm.amt) > parseInt(this.cor_point)) {
                return false
              }

              this.procFreebeatPay(this.allatForm.amt)
              return true
            },
            goBack: function () {
                window.location.href = this.helper.langUrl(this.$i18n.locale, "/cmall/cart");
            },
            goPayletter: function () {
              switch (this.pay_type) {
                case 5:
                  this.payletter.currency = 'USD'
                  this.payletter.pg_info = 'PLCreditCard'
                  break
                case 6:
                  this.payletter.currency = 'USD'
                  this.payletter.pg_info = 'WeChatPayQRCodePayment'
                  break
                case 7:
                  this.payletter.currency = 'USD'
                  this.payletter.pg_info = 'ICBAlipay'
                  break
                case 8:
                  this.payletter.currency = 'JPY'
                  this.payletter.pg_info = 'PLCreditCardMpi'
                  break
              }

              let formData = new FormData();
              formData.append('currency', this.payletter.currency);
              formData.append('order_no', this.allatForm.order_no);
              formData.append('amt', this.total_money_d);
              formData.append('pmember_id', this.allatForm.pmember_id);
              formData.append('recp_addr', this.allatForm.recp_addr);
              formData.append('pg_info', this.payletter.pg_info);

              axios.post('/pg/payletter/payment', formData)
                  .then(res => res.data)
                  .then(data => {
                    console.log(data)
                    window.open(data.online_url, 'payletter', 'width=762,height=500,scrollbars=1');
                  })
                  .catch(error => {
                    if (error.response) {
                      alert(error.response.data.message);
                    }
                    console.error(error);
                  });
            },
            paycoReserve: function () {
              let formData = new FormData();
              formData.append('customerOrderNumber', this.allatForm.order_no);
              formData.append('cartNo', this.allatForm.order_no);
              formData.append('orderQuantity', 1);
              formData.append('productUnitPrice', this.allatForm.amt);
              formData.append('productUnitPaymentPrice', this.allatForm.amt);
              formData.append('productName', this.allatForm.product_nm);
              formData.append('sellerOrderProductReferenceKey', this.allatForm.product_cd);
              formData.append('orderChannel', 'PC');

              axios.post('/pg/payco/reserve', formData)
                  .then(res => res.data)
                  .then(data => {
                    window.open(data.result.orderSheetUrl, 'popupPayco', 'top=100, left=300, width=727px, height=512px, resizble=no, scrollbars=yes');
                  })
                  .catch(error => {
                    if (error.response) {
                      alert('오류가 발생하였습니다');
                    }
                    console.error(error);
                  });
            },
            goPay: function () {
                if (this.procAllPointPay()) {
                  return
                }

                if (this.pay_type === 3) {
                  this.paycoReserve()
                  return
                }

                window.AllatPay_Approval(document.fm1);
                // 결제창 자동종료 체크 시작
                window.AllatPay_Closechk_Start();
            },
            procCompletePay: function (result_cd, result_msg, enc_data) {
                // 결제창 자동종료 체크 종료
                window.AllatPay_Closechk_End();

                if (result_cd !== "0000" && result_cd !== "0001") {
                    window.setTimeout(function () {
                        alert(result_cd + " : " + result_msg);
                    }, 1000);
                } else {
                    this.$set(this.allatForm, 'enc_data', enc_data);
                    document.fm1.allat_enc_data.value = enc_data;
                    document.fm1.unique_id = this.unique_id;

                    let formData1 = new FormData(document.fm1);
                    formData1.append('pay_type', 'allat');
                    formData1.append('unique_id', this.unique_id);
                    formData1.append('good_mny', this.allatForm.amt);
                    formData1.append('cor_point', this.cor_point);
                    formData1.append('mem_realname', this.member.mem_lastname + this.member.mem_firstname);
                    axios.post('/cmall/ajax_orderupdate', formData1)
                        .then(res => res.data)
                        .then(data => {
                            window.location.href = this.helper.langUrl(this.$i18n.locale, "/cmall/complete/" + this.unique_id);
                        })
                        .catch(error => {
                            if (error.response) {
                                alert(error.response.data.message);
                            }
                            console.error(error);
                        });
                }
            },
            procCompletePayco: function (code, msg, data) {
              if (code !== '0') {
                alert(msg)
                return
              }

              let formData = new FormData();
              formData.append('pay_type', 'payco');
              formData.append('unique_id', this.unique_id);
              formData.append('good_mny', this.allatForm.amt);
              formData.append('cor_point', this.cor_point);
              formData.append('mem_realname', this.member.mem_firstname + this.member.mem_lastname);
              formData.append('payco_data', data);

              axios.post('/cmall/ajax_orderupdate', formData)
                  .then(res => res.data)
                  .then(data => {
                    window.location.href = this.helper.langUrl(this.$i18n.locale, "/cmall/complete/" + this.unique_id);
                  })
                  .catch(error => {
                    alert(error.response.data.message);
                  });
            },
            procCompletePayletter: function () {
              let formData = new FormData();
              formData.append('pay_type', 'payletter');
              formData.append('unique_id', this.unique_id);
              formData.append('good_mny', this.total_money_d);
              formData.append('cor_point', this.cor_point);
              formData.append('mem_realname', this.member.mem_firstname + this.member.mem_lastname);

              axios.post('/cmall/ajax_orderupdate_payletter', formData)
                  .then(res => res.data)
                  .then(data => {
                    window.location.href = this.helper.langUrl(this.$i18n.locale, "/cmall/complete/" + this.unique_id);
                  })
                  .catch(error => {
                    alert(error.response.data.message);
                  });
            },
            paypalAuthorized: function (data) {
            },
            paypalCompleted: function (data) {
                this.paypalData = JSON.stringify(data);
                let formData = new FormData();
                formData.append('pay_type', 'paypal');
                formData.append('unique_id', this.unique_id);
                formData.append('state', data.state);
                formData.append('good_mny', data.transactions[0].amount.total);
                formData.append('cor_point', this.cor_point);
                formData.append('mem_realname', this.member.mem_firstname + this.member.mem_lastname);
                formData.append('paypal_data', this.paypalData);
                axios.post('/cmall/ajax_orderupdate', formData)
                    .then(res => res.data)
                    .then(data => {
                        window.location.href = this.helper.langUrl(this.$i18n.locale, "/cmall/complete/" + this.unique_id);
                    })
                    .catch(error => {
                        alert(error.response.data.message);
                    });
            },
            paypalCancelled: function (data) {
                alert("결제를 취소하셨습니다");
            },
        },
        watch: {
            pay_type(val) {
                if (val === 1) { // 신용카드
                    this.$set(this.allatForm, 'card_yn', 'Y');
                    this.$set(this.allatForm, 'bank_yn', 'N');
                } else if (val === 2) { // 실시간 계좌이체
                    this.$set(this.allatForm, 'card_yn', 'N');
                    this.$set(this.allatForm, 'bank_yn', 'Y');
                }
            },
            cor_point(val) {
                if (this.$i18n.locale !== 'ko') {
                  alert(this.$t('lang163'))
                  this.cor_point = 0
                }

                if ((+val) < 0) {
                    this.cor_point = 0
                }

                if (this.good_mny < val) {
                  this.cor_point = this.good_mny
                }

                if ((+val) > this.mem_point) {
                    this.cor_point = (this.good_mny <= this.mem_point) ? this.good_mny : this.mem_point;
                }

                this.$set(this.allatForm, 'amt', this.good_mny - (+val));
            }
        }
    }
</script>

<style lang="scss">
    @import "@/assets/scss/App.scss";

    .cart .playList__item > * {
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

    .payco-desc {
      font-size: 14px;
      padding-top: 10px;
      line-height: 1.4;
      word-break: keep-all;
    }

    .payco-logo {
      max-width: 70px;
    }
</style>