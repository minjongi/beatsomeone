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
                                <div class="number">{{ myOrder_list.length }}</div>
                                {{$t('selectedItems')}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <li
                                            v-for="(item, i) in myOrder_list"
                                            v-bind:key="item.cct_id"
                                            class="playList__itembox"
                                            :id="'playList__item'+ item.cct_id"
                                    >
                                        <div class="playList__item playList__item--title other">
                                            <div class="col name">
                                                <figure>
                          <span class="playList__cover">
                            <img
                                    v-if="!item.cit_file_1"
                                    :src="'/assets/images/cover_default.png'"
                                    alt
                            />
                            <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt/>
                            <i v-show="checkToday(item.cct_datetime)" class="label new">N</i>
                          </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title">{{ formatCitName(item.cit_name)
                                                            }}</h3>
                                                        <span class="playList__by">by {{item.detail[0].mem_userid}}</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col n-option">
                                                <!-- Option -->
                                                <div class="option">
                                                    <!-- BASIC LEASE LICENSE -->
                                                    <div
                                                            class="n-box"
                                                            v-if="item.cde_title !== 'STEM'"
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
                                                                    >{{$t('lang23')}}
                                                                    </div>
                                                                    <div class="detail">{{$t('lang24')}}</div>
                                                                </div>
                                                                <div
                                                                        class="price 11221122"
                                                                >{{ formatPrice(item.detail[0].cde_price,
                                                                    item.detail[0].cde_price_d, true) }}
                                                                </div>
                                                            </button>
                                                            <ParchaseComponent :item="item"
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
                                                                    >{{$t('lang30')}}
                                                                    </div>
                                                                    <div class="detail 2222">{{$t('lang31')}}</div>
                                                                </div>
                                                                <div
                                                                        class="price"
                                                                        v-if="item.detail[0].cit_mastering_license_use === '1'"
                                                                >{{ formatPrice(item.detail[0].cde_price,
                                                                    item.detail[0].cde_price_d, true) }}
                                                                </div>
                                                            </button>
                                                            <ParchaseComponent :item="item"
                                                                               :type="'mastering'"></ParchaseComponent>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="payment_box" style="max-width:initial!important">
                                <div>
                                    <div class="title-content">
                                        <div div class="title">{{$t('payMethod')}}</div>
                                        <div v-if="currentLocale === 'ko'">
                                            <label class="checkbox" for="method1">
                                                <input
                                                        type="radio"
                                                        name="method"
                                                        id="method1"
                                                        hidden="hidden"
                                                        value="1"
                                                        v-model="payMethod"
                                                        @change="chgPayMethod(1)"
                                                />
                                                <div class="btn btn--yellow" style="height:48px">
                                                    <div class="icon credit"></div>
                                                    <div style="font-size:14px;">{{$t('creditCard')}}</div>
                                                </div>
                                            </label>
                                            <label class="checkbox" for="method2">
                                                <input
                                                        type="radio"
                                                        name="method"
                                                        id="method2"
                                                        hidden="hidden"
                                                        value="2"
                                                        v-model="payMethod"
                                                        @change="chgPayMethod(2)"
                                                />
                                                <div class="btn btn--yellow" style="height:48px">
                                                    <div class="icon wire"></div>
                                                    <div style="font-size:14px;">{{$t('realtimeBankTransfer')}}</div>
                                                </div>
                                            </label>
                                        </div>
                                        <div v-if="currentLocale === 'en'">
                                            <label class="checkbox" for="method3">
                                                <input
                                                        type="radio"
                                                        name="method"
                                                        id="method3"
                                                        hidden="hidden"
                                                        value="3"
                                                        v-model="payMethod"
                                                />
                                                <div class="btn btn--yellow" style="height:48px">
                                                    <div class="icon paypal"></div>
                                                    <div style="font-size:14px;">PayPal</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="title-content">
                                        <div div class="title">{{$t('point')}}</div>
                                        <div>
                                            <div class="input_wrap inputbox unit" style="height:48px">
                                                <input type="number" value="0" v-model="mem_point"/>
                                                <span>P</span>
                                            </div>
                                            <button
                                                    class="btn btn--blue"
                                                    style="width:100px;height:48px;margin-left:-10px;"
                                                    @click="usePointFn"
                                            >{{$t('use')}}
                                            </button>
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
                                        <div>{{ formatPrice(totalPriceKr, totalPriceEn, true) }}</div>
                                    </div>
                                    <div>
                                        <div class="title">{{$t('points')}}</div>
                                        <div>{{ mem_point }} P</div>
                                    </div>
                                    <div class="total">
                                        <div>{{$t('payTotal2')}}</div>
                                        <div>{{ formatPrice(totalPriceKr - usePoint, totalPriceEn - usePoint, true) }}
                                        </div>
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
                                <button class="btn btn--gray mr-3" style="height:47px;" @click="goBack">{{$t('back')}}
                                </button>
                                <PayPal v-if="isEmptyPaypal === false"
                                        :env="pg_paypal_env"
                                        currency="USD"
                                        locale="en_US"
                                        :amount="this.totalPriceEn.toString() || '0'"
                                        :client="paypal"
                                        :invoice-number="orderNo"
                                        :button-style="paypalBtnStyle"
                                        @payment-authorized="paypalAuthorized"
                                        @payment-completed="paypalCompleted"
                                        @payment-cancelled="paypalCancelled"
                                ></PayPal>
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
            <form name="fm1" method="POST">
                <input type="text" name="allat_shop_id" v-model="allatForm.shop_id" maxlength="20"/>
                <!--주문번호-->
                <input type="text" name="allat_order_no" v-model="allatForm.order_no" maxlength="70"/>
                <!--승인금액-->
                <input type="hidden" name="allat_amt" v-model="allatForm.amt" maxlength="10"/>
                <!--회원ID-->
                <input type="hidden" name="allat_pmember_id" v-model="allatForm.pmember_id" maxlength="20"/>
                <!--상품코드-->
                <input
                        type="hidden"
                        name="allat_product_cd"
                        v-model="allatForm.product_cd"
                        maxlength="1000"
                />
                <!--상품명-->
                <input
                        type="hidden"
                        name="allat_product_nm"
                        v-model="allatForm.product_nm"
                        maxlength="1000"
                />
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
    require("@/assets/js/function");
    import Header from "../include/Header";
    import Footer from "../include/Footer";
    import axios from "axios";
    import PayPal from "vue-paypal-checkout";
    import ParchaseComponent from "../component/Parchase";

    export default {
        components: {
            Header,
            Footer,
            PayPal,
            ParchaseComponent
        },
        data: function () {
            return {
                isLogin: false,
                myOrder_list: [],
                myMember: [],
                totalPriceKr: 0,
                totalPriceEn: 0,
                freebeatPay: false,
                point: 0,
                useWPoint: 0,
                remPoint: 0,
                usePoint: 0,
                payMethod: 0,
                unique_id: 0,
                cor_id: "",
                selectedItems: 0,
                allatForm: {
                    shop_id: "dumdum",
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
                    card_yn: "N",
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
                paypalData: null,
                isEmptyPaypal: true,
                mem_point: 0
            };
        },
        created() {
            axios.get('/payment/pg_config')
                .then(res => res.data)
                .then(data => {
                    this.use_pg_test = +data.use_pg_test;
                    this.paypal.sandbox = data.sandbox;
                    this.paypal.production = data.production;
                    if (this.use_pg_test === 1) {
                        this.pg_paypal_env = 'sandbox';
                    } else {
                        this.pg_paypal_env = 'production';
                    }
                    this.isEmptyPaypal = Object.keys(this.paypal).length === 0;
                })
                .catch(error => {
                    console.log(error);
                });
            if (this.$i18n.locale === "en") {
                this.payMethod = 3;
            }
            this.mem_point = (+window.member.mem_point);
            axios.get('/cmall/ajax_order')
                .then(res => res.data)
                .then(data => {
                    console.log(data);
                    this.myOrder_list = data.data;
                    this.totalPriceEn = 0;
                    this.myOrder_list.forEach(item => {
                        this.totalPriceEn += (+item.detail[0].cde_price_d);
                        this.totalPriceKr += (+item.detail[0].cde_price);
                    });
                })
                .catch(error => {
                    console.error(error);
                })
        },
        computed: {
            orderNo() {
                return this.unique_id || "none";
            },
            currentLocale() {
                if (this.$i18n.locale === "en") {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.payMethod = 3;
                } else {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.payMethod = 0;
                }

                return this.$i18n.locale;
            },
        },
        methods: {
            paypalAuthorized: function (data) {
            },
            paypalCompleted: function (data) {
                this.paypalData = JSON.stringify(data);
                console.log(data);
                let formData = new FormData();
                formData.append('pay_type', 'paypal');
                formData.append('data', this.paypalData);
                formData.append('state', data.state);
                formData.append('good_mny', data.transactions[0].amount.total);
                axios.post('/cmall/ajax_orderupdate', formData)
                    .then(res => res.data)
                    .then(data => {
                        window.location.href = "/cmall/complete?cor_id=" + this.cor_id;
                    })
                    .catch(error => {
                        alert("결제가 실패하였습니다.");
                    });
            },
            paypalCancelled: function (data) {
                alert("결제를 취소하셨습니다");
            },
            async ajaxOrderList() {
                try {
                    this.isLoading = true;
                    const {data} = await axios.get("/beatsomeoneApi/user_order_list", {});
                    this.myOrder_list = data.result;
                    this.selectedItems = this.myOrder_list.length;
                    this.myMember = data.mem_result;
                    this.unique_id = data.unique_id;
                } catch (err) {
                    console.log("ajaxCartList error");
                } finally {
                    this.isLoading = false;
                }
            },
            async ajaxUpdateOrder() {
                try {
                    this.isLoading = true;
                    var param = new FormData();
                    param.append("pay_type", this.payMethod);
                    param.append("priceType", this.getPriceType());
                    param.append(
                        "total_price_sum",
                        this.formatPrice(this.totalPriceKr, this.totalPriceEn, false)
                    );
                    param.append("usePoint", this.usePoint);
                    param.append("unique_id", this.unique_id);
                    param.append("paypal_data", this.paypalData);

                    for (const key in this.allatForm) {
                        param.append("allat_" + key, this.allatForm[key]);
                    }

                    const {data} = await axios.post(
                        "/beatsomeoneApi/user_order_update",
                        param
                    );
                    if (data.message === "ok") {
                        this.cor_id = data.cor_id;
                    }
                } catch (err) {
                    console.log("ajaxUpdateOrder error");
                } finally {
                    this.isLoading = false;
                }
            },
            goBack: function (e) {
                window.location.href = "/cmall/cart";
            },
            goPay: function (e) {
                if (this.totalPrice - this.usePoint <= 0) {
                    alert("결제 금액을 확인해주세요");
                    return;
                }
                if (!this.payMethod) {
                    alert("결제 방법을 선택해주세요");
                    return;
                }

                if (this.payMethod === 1) {
                    this.allatForm.card_yn = "Y";
                    this.allatForm.bank_yn = "N";
                } else if (this.payMethod === 2) {
                    this.allatForm.card_yn = "N";
                    this.allatForm.bank_yn = "Y";
                } else {
                    alert("준비중 입니다");
                    return false;
                }

                this.allatForm.order_no = this.unique_id;
                this.allatForm.amt = this.totalPriceKr;
                this.allatForm.pmember_id = this.myMember[0].mem_id;
                this.allatForm.product_cd = this.myOrder_list[0].cit_id;
                this.allatForm.product_nm = this.myOrder_list[0].cit_name;
                this.allatForm.buyer_nm =
                    !!this.myMember[0].mem_firstname && !!this.myMember[0].mem_lastname
                        ? this.myMember[0].mem_firstname + " " + this.myMember[0].mem_lastname
                        : this.myMember[0].mem_nickname;
                this.allatForm.recp_nm = this.allatForm.buyer_nm;
                this.allatForm.recp_addr =
                    this.myMember[0].mem_address1 || this.myMember[0].mem_email;

                Http.post("/beatsomeoneApi/set_session_order_price", {
                    price: this.allatForm.amt,
                }).then(() => {
                    window.AllatPay_Approval(document.fm1);
                    window.AllatPay_Closechk_Start();
                });
            },
            procCompletePay: function (result_cd, result_msg, enc_data) {
                window.AllatPay_Closechk_End();

                if (result_cd !== "0000") {
                    setTimeout(function () {
                        alert(result_cd + " : " + result_msg);
                    }, 500);
                } else {
                    this.allatForm.enc_data = enc_data;
                    this.ajaxUpdateOrder().then(() => {
                        if (this.cor_id == "") {
                            alert("결제가 실패하였습니다.");
                            return;
                        } else {
                            window.location.href = "/cmall/complete?cor_id=" + this.cor_id;
                        }
                    });
                }
            },
            chgPayMethod: function (idx) {
                this.payMethod = idx;
            },
            calcTotalPrice: function () {
                let tpkr = 0.0,
                    tpen = 0.0,
                    freebeatCnt = 0

                for (let i in this.myOrder_list) {
                    if (this.myOrder_list[i].cde_title === "STEM") {
                        tpkr += Number(this.myOrder_list[i].detail[0].cde_price);
                        tpen += Number(this.myOrder_list[i].detail[0].cde_price_d);
                    } else {
                        tpkr += Number(this.myOrder_list[i].detail[0].cde_price);
                        tpen += Number(this.myOrder_list[i].detail[0].cde_price_d);
                    }

                    if (this.myOrder_list[i].detail[0].cit_freebeat == 1) {
                        freebeatCnt++
                    }
                }
                this.totalPriceKr = tpkr;
                this.totalPriceEn = tpen;
                this.freebeatPay = (freebeatCnt === this.myOrder_list.length)
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
            formatPrice: function (kr, en, simbol) {
                if (!simbol) {
                    if (this.$i18n.locale === "en") {
                        return en;
                    } else {
                        return kr;
                    }
                }
                if (this.$i18n.locale === "en") {
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
            getPriceType: function () {
                if (this.$i18n.locale === "en") {
                    return "$";
                } else {
                    return "₩";
                }
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
            usePointFn: function () {
                if (this.point - this.useWPoint <= 0) {
                    alert("보유중인 포인트가 부족합니다.");
                    this.useWPoint = 0;
                    this.usePoint = 0;
                    this.remPoint = this.point;
                } else {
                    this.remPoint = this.point - this.useWPoint;
                    this.usePoint = this.useWPoint;
                }
            },
            procFreebeatPay: function () {
                this.ajaxUpdateOrder().then(() => {
                    if (this.cor_id == "") {
                        alert("결제가 실패하였습니다.");
                        return;
                    } else {
                        window.location.href = "/cmall/complete?cor_id=" + this.cor_id;
                    }
                });
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

    .cart .playList__item > * {
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
