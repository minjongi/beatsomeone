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
                                    <span>1</span>{{$t('cart')}}
                                </div>
                                <div class="stage active">
                                    <span>2</span>{{$t('pay')}}
                                </div>
                                <div class="stage">
                                    <span>3</span>{{$t('payComplete1')}}
                                </div>
                            </div>
                        </header>
                        <div class="row">
                            <div class="checkbox" style="margin-left:20px; margin-bottom:30px; font-weight:600; cursor: auto;"><div class="number">{{ selectedItems }}</div>{{$t('selectedItems')}}</div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <li v-for="(item, i) in myOrder_list" v-bind:key="item.cct_id" class="playList__itembox" :id="'playList__item'+ item.cct_id" >
                                        <div class="playList__item playList__item--title other">
                                                <div class="col name">
                                                    <figure>
                                                        <span class="playList__cover">
                                                            <img v-if="!item.cit_file_1" :src="'/assets/images/cover_default.png'" alt="">
                                                            <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt="">
                                                            <i v-show="checkToday(item.cct_datetime)" class="label new">N</i>
                                                        </span>
                                                        <figcaption class="pointer">
                                                            <h3 class="playList__title"> {{ formatCitName(item.cit_name) }} </h3>
                                                            <span class="playList__by">by {{item.detail[0].mem_userid}}</span>
                                                        </figcaption>
                                                    </figure>
                                                </div>
                                                <div class="col n-option">

                                                    <!-- Option -->
                                                    <div class="option">
                                                        <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                        <div class="n-box" v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' ">
                                                            <div>
                                                                <button class="playList__item--button" >
                                                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                    <div>
                                                                        <div class="title" @click.self="toggleButton">{{$t('basicLeaseLicense')}}</div>
                                                                        <div class="detail">{{$t('mp3Orwav')}}</div>
                                                                    </div>
                                                                    <div class="price 11221122" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                                        {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d, true) }}
                                                                    </div>
                                                                </button>
                                                                <div class="option_item basic">
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info1.png"></span><span>{{$t('available60Days')}}</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info2.png"></span><span>{{$t('unableToEditArbitrarily')}}</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info3.png"></span><span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info5.png"></span><span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE --><!--
                                                        <div class="n-box" v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' ">{{$t('unlimitedStemsLicense')}}
                                                            <div>
                                                                <button class="playList__item--button" >
                                                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                    <div>
                                                                        <div class="title" @click.self="toggleButton">{{$t('unlimitedStemsLicense')}}</div>
                                                                        <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                                    </div>
                                                                    <div class="price  1122" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                                            {{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2, true) }}
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
                                                        <div class="n-box" v-else-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '0'" >

                                                            <div>
                                                                <button class="playList__item--button" >
                                                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                    <div>
                                                                        <div class="title" @click.self="toggleButton">{{$t('basicLeaseLicense')}}</div>
                                                                        <div class="detail">{{$t('mp3Orwav')}}</div>
                                                                    </div>
                                                                    <div class="price 1111" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                                        {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d, true) }}
                                                                    </div>
                                                                </button>
                                                                <div class="option_item basic">
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info1.png"></span><span>{{$t('available60Days')}}</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info2.png"></span><span>{{$t('unableToEditArbitrarily')}}</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info3.png"></span><span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info5.png"></span><span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- UNLIMITED STEMS LICENSE -->
                                                        <div class="n-box" v-else-if="item.detail[0].cit_mastering_license_use === '1' && item.detail[0].cit_lease_license_use === '0' " >

                                                            <div>
                                                                <button class="playList__item--button" >
                                                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                    <div>
                                                                        <div class="title" @click.self="toggleButton">{{$t('unlimitedStemsLicense')}}</div>
                                                                        <div class="detail 2222">{{$t('mp3OrwavStems')}}</div>
                                                                    </div>
                                                                    <div class="price" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                                        {{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2, true) }}
                                                                    </div>
                                                                </button>
                                                                <div class="option_item unlimited">
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span><span>{{$t('unlimited1')}}</span></div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> {{$t('unlimitedMsg1')}} </span> </div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> {{$t('unlimitedMsg2')}} </span> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </li>
                                    <!--
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
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
                                                        <div class="title">{{$t('unlimitedStemsLicense')}} PRICE</div>
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
                                        </div>
                                    </li>

                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
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
                                                        <div class="title">BASIC LEASE</div>
                                                        <div class="detail">{{$t('mp3Orwav')}}</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>{{$t('available60Days')}}</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>{{$t('unableToEditArbitrarily')}}</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info5.png"><span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
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
                                                        <div class="title">{{$t('unlimitedStemsLicense')}} PRICE</div>
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
                                        </div>
                                    </li>
                                    -->
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="payment_box" style="max-width:initial!important">
                                <div>
                                    <div class="title-content">
                                        <div div class="title">
                                            {{$t('payMethod')}}
                                        </div>
                                        <div v-if="currentLocale === 'ko'">
                                            <label class="checkbox" for="method1">
                                                <input type="radio" name="method" id="method1" hidden="hidden" value="1" v-model="payMethod" @change="chgPayMethod(1)">
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon credit"></div><div style="font-size:14px;">{{$t('creditCard')}}</div></div>
                                            </label>
                                            <label class="checkbox" for="method2">
                                                <input type="radio" name="method" id="method2" hidden="hidden" value="2" v-model="payMethod" @change="chgPayMethod(2)">
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon wire"></div><div style="font-size:14px;">{{$t('realtimeBankTransfer')}}</div></div>
                                            </label>
                                        </div>
                                        <div v-if="currentLocale === 'en'">
                                            <label class="checkbox" for="method3">
                                                <input type="radio" name="method" id="method3" hidden="hidden" value="3" v-model="payMethod">
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon paypal"></div><div style="font-size:14px;">PayPal</div></div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="title-content">
                                        <div div class="title">
                                            {{$t('point')}}
                                        </div>
                                        <div>
                                            <div class="input_wrap inputbox unit" style="height:48px">
                                                <input type="number" value="0" v-model="useWPoint">
                                                <span>P</span>
                                            </div>
                                            <button class="btn btn--blue" style="width:100px;height:48px;margin-left:-10px;" @click="usePointFn">{{$t('use')}}</button>
                                        </div>
                                        <p style="display:inline-block;">
                                            <span>{{ remPoint }}</span> P {{$t('left')}}
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
                                        <div>{{ usePoint }} P</div>
                                    </div>
                                    <div class="total">
                                        <div>{{$t('payTotal2')}}</div>
                                        <div>{{ formatPrice(totalPriceKr - usePoint, totalPriceEn - usePoint, true) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btnbox col" style="width:50%; margin:30px auto 100px;" v-if="currentLocale === 'ko'">
                            <button class="btn btn--gray" @click="goBack">{{$t('back')}}</button>
                            <button type="submit" class="btn btn--submit" @click="goPay">{{$t('pay')}}</button>
                        </div>
                        <div class="btnbox col" style="width:50%; margin:30px auto 100px;" v-if="currentLocale === 'en'">
                            <button class="btn btn--gray mr-3" style="height:47px;" @click="goBack">{{$t('back')}}</button>
                            <PayPal
                                    env="production"
                                    currency="USD"
                                    locale="en_US"
                                    :amount="this.totalPriceEn.toString() || '0'"
                                    :client="paypal"
                                    :invoice-number="orderNo"
                                    :button-style="paypalBtnStyle"
                                    @payment-authorized="paypalAuthorized"
                                    @payment-completed="paypalCompleted"
                                    @payment-cancelled="paypalCancelled">
                            </PayPal>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div>
            <form name="fm1" method="POST">
                <input type="text" name="allat_shop_id" v-model="allatForm.shop_id" maxlength=20 style="color:#000000;">
                <!--주문번호-->
                <input type="text" name="allat_order_no" v-model="allatForm.order_no" maxlength=70>
                <!--승인금액-->
                <input type=hidden name="allat_amt" v-model="allatForm.amt" maxlength=10>
                <!--회원ID-->
                <input type=hidden name="allat_pmember_id" v-model="allatForm.pmember_id" maxlength=20>
                <!--상품코드-->
                <input type=hidden name="allat_product_cd" v-model="allatForm.product_cd" maxlength=1000>
                <!--상품명-->
                <input type=hidden name="allat_product_nm" v-model="allatForm.product_nm" maxlength=1000>
                <!--결제자성명-->
                <input type=hidden name="allat_buyer_nm" v-model="allatForm.buyer_nm" maxlength=20>
                <!--수취인성명-->
                <input type=hidden name="allat_recp_nm" v-model="allatForm.recp_nm" maxlength=20>
                <!--수취인주소-->
                <input type=hidden name="allat_recp_addr" v-model="allatForm.recp_addr" maxlength=120>
                <!--인증정보수신URL-->
                <input type=hidden name="shop_receive_url" v-model="allatForm.shop_receive_url" size="19">
                <!--주문정보암호화필드-->
                <input type=hidden name=allat_enc_data value="">
                <!--테스트 여부-->
                <input type=hidden name="allat_test_yn" value="N" maxlength=1>
                <input type="hidden" name="allat_card_yn" v-model="allatForm.card_yn" maxlength="1">
                <input type="hidden" name="allat_bank_yn" v-model="allatForm.bank_yn" maxlength="1">
                <input type="hidden" name="allat_vbank_yn" v-model="allatForm.vbank_yn" maxlength="1">
                <input type="hidden" name="allat_encode_type" value="U">
            </form>
        </div>
    </div>
</template>

<script>
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import axios from 'axios'
    import PayPal from 'vue-paypal-checkout'

    export default {
        components: {
            Header, Footer, PayPal
        },
        data: function () {
            return {
                isLogin: false,
                myOrder_list: [],
                myMember: [],
                totalPriceKr: 0,
                totalPriceEn: 0,
                point: 0,
                useWPoint: 0,
                remPoint: 0,
                usePoint: 0,
                payMethod: 0,
                unique_id: 0,
                cor_id: '',
                selectedItems: 0,
                allatForm: {
                    'shop_id': 'dumdum',
                    'order_no': '',
                    'amt': '',
                    'pmember_id': '',
                    'product_cd': '',
                    'product_nm': '',
                    'buyer_nm': '',
                    'recp_nm': '',
                    'recp_addr': '',
                    'shop_receive_url': window.allat_shop_receive_url,
                    'test_yn': 'Y',
                    'card_yn': 'N',
                    'bank_yn': 'N',
                    'vbank_yn': 'N',
                    'encode_type': 'U',
                    'enc_data': ''
                },
                paypal: {
                    sandbox: 'AQRhzAlMZbwjG9B47YjqzJsQMmkQG6I4BA5hYiJjDFKiW2ysRUPkmKCInxmvCQ7Ij7zixTA_ZlPk8nC3',
                    production: 'AQnRlgkRT0pVUuORozmUa2qd6nOJH2BBvCvg8miFYWVpueRjfM4oepwZ5GfNOkfqznCrVbbriZSC83Z3'
                },
                paypalBtnStyle: {
                    label: 'pay',
                    size: 'large',
                    shape: 'rect',
                },
                paypalData: null
            }
        },
        created() {
            if (this.$i18n.locale === 'en') {
                this.payMethod = 3
            }
            this.ajaxOrderList().then(() => {
                this.calcTotalPrice()
                this.point = this.myMember[0].mem_point
                this.remPoint = this.myMember[0].mem_point
            })
        },
        computed: {
            orderNo() {
                return this.unique_id || 'none'
            },
            currentLocale() {
                if (this.$i18n.locale === 'en') {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.payMethod = 3
                } else {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.payMethod = 0
                }

                return this.$i18n.locale
            }
        },
        methods: {
            paypalAuthorized: function (data) {
            },
            paypalCompleted: function (data) {
                console.log(data)
                this.paypalData = JSON.stringify(data)
                this.ajaxUpdateOrder().then(() => {
                    if (!this.cor_id) {
                        alert("결제가 실패하였습니다.")
                    } else {
                        window.location.href = '/cmall/complete?cor_id=' + this.cor_id
                    }
                })

            },
            paypalCancelled: function (data) {
                alert('결제를 취소하셨습니다')
            },
            async ajaxOrderList() {
                try {
                    this.isLoading = true
                    const {data} = await axios.get(
                        '/beatsomeoneApi/user_order_list', {}
                    )
                    this.myOrder_list = data.result
                    this.selectedItems = this.myOrder_list.length
                    this.myMember = data.mem_result
                    this.unique_id = data.unique_id
                } catch (err) {
                    console.log('ajaxCartList error')
                } finally {
                    this.isLoading = false
                }
            },
            async ajaxUpdateOrder() {
                try {
                    this.isLoading = true
                    var param = new FormData()
                    param.append('pay_type', this.payMethod)
                    param.append('priceType', this.getPriceType())
                    param.append('total_price_sum', this.formatPrice(this.totalPriceKr, this.totalPriceEn, false))
                    param.append('usePoint', this.usePoint)
                    param.append('unique_id', this.unique_id)
                    param.append('paypal_data', this.paypalData)

                    for (const key in this.allatForm) {
                        param.append('allat_' + key, this.allatForm[key])
                    }

                    const {data} = await axios.post('/beatsomeoneApi/user_order_update', param)
                    if (data.message === 'ok') {
                        this.cor_id = data.cor_id
                    }
                } catch (err) {
                    console.log('ajaxUpdateOrder error')
                } finally {
                    this.isLoading = false
                }
            },
            goBack: function (e) {
                window.location.href = '/cmall/cart'
            },
            goPay: function (e) {
                if ((this.totalPrice - this.usePoint) <= 0) {
                    alert("결제 금액을 확인해주세요")
                    return
                }
                if (!this.payMethod) {
                    alert("결제 방법을 선택해주세요")
                    return
                }

                if (this.payMethod === 1) {
                    this.allatForm.card_yn = 'Y'
                    this.allatForm.bank_yn = 'N'
                } else if (this.payMethod === 2) {
                    this.allatForm.card_yn = 'N'
                    this.allatForm.bank_yn = 'Y'
                } else {
                    alert('준비중 입니다')
                    return false
                }

                this.allatForm.order_no = this.unique_id
                this.allatForm.amt = this.totalPriceKr
                this.allatForm.pmember_id = this.myMember[0].mem_id
                this.allatForm.product_cd = this.myOrder_list[0].cit_id
                this.allatForm.product_nm = this.myOrder_list[0].cit_name
                this.allatForm.buyer_nm = (!!this.myMember[0].mem_firstname && !!this.myMember[0].mem_lastname) ? this.myMember[0].mem_firstname + ' ' + this.myMember[0].mem_lastname : this.myMember[0].mem_nickname
                this.allatForm.recp_nm = this.allatForm.buyer_nm
                this.allatForm.recp_addr = this.myMember[0].mem_address1 || this.myMember[0].mem_email

                Http.post(
                    '/beatsomeoneApi/set_session_order_price', {price: this.allatForm.amt}
                ).then(
                    () => {
                        window.AllatPay_Approval(document.fm1)
                        window.AllatPay_Closechk_Start()
                    }
                )
            },
            procCompletePay: function (result_cd, result_msg, enc_data) {
                window.AllatPay_Closechk_End()

                if (result_cd !== '0000') {
                    setTimeout(function () {
                        alert(result_cd + " : " + result_msg)
                    }, 500)
                } else {
                    this.allatForm.enc_data = enc_data
                    this.ajaxUpdateOrder().then(() => {
                        if (this.cor_id == '') {
                            alert("결제가 실패하였습니다.")
                            return
                        } else {
                            window.location.href = '/cmall/complete?cor_id=' + this.cor_id
                        }
                    })
                }
            },
            chgPayMethod: function (idx) {
                this.payMethod = idx
            },
            calcTotalPrice: function () {
                let tpkr = 0.0
                let tpen = 0.0
                for (let i in this.myOrder_list) {
                    if (this.myOrder_list[i].detail[0].cit_lease_license_use == '1') {
                        tpkr += Number(this.myOrder_list[i].detail[0].cde_price)
                        tpen += Number(this.myOrder_list[i].detail[0].cde_price_d)
                    } else if (this.myOrder_list[i].detail[0].cit_mastering_license_use == '1') {
                        tpkr += Number(this.myOrder_list[i].detail[0].cde_price_2)
                        tpen += Number(this.myOrder_list[i].detail[0].cde_price_d_2)
                    }
                }
                this.totalPriceKr = tpkr
                this.totalPriceEn = tpen
            },
            checkToday: function (date) {
                const input = new Date(date)
                const today = new Date()
                return input.getDate() === today.getDate() &&
                    input.getMonth() === today.getMonth() &&
                    input.getFullYear() === today.getFullYear()
            },
            formatPrice: function (kr, en, simbol) {
                if (!simbol) {
                    if (this.$i18n.locale === 'en') {
                        return en
                    } else {
                        return kr
                    }
                }
                if (this.$i18n.locale === 'en') {
                    return '$ ' + Number(en).toLocaleString(undefined, {minimumFractionDigits: 2});
                } else {
                    return '₩ ' + Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0})
                }
            },
            formatCitName: function (data) {
                var rst
                var limitLth = 50
                if (limitLth < data.length && data.length <= limitLth * 2) {
                    rst = data.substring(0, limitLth) + '<br>' + data.substring(limitLth, limitLth * 2)
                } else if (limitLth < data.length && limitLth * 2 < data.length) {
                    rst = data.substring(0, limitLth) + '<br>' + data.substring(limitLth, limitLth * 2) + '...'
                } else {
                    rst = data
                }
                return rst
            },
            getPriceType: function () {
                if (this.$i18n.locale === 'en') {
                    return '$'
                } else {
                    return '₩'
                }
            },
            toggleButton: function (e) {
                if (e.target.parentElement.parentElement.parentElement.parentElement.className == "n-box") {
                    e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box active"
                } else if (e.target.parentElement.parentElement.parentElement.parentElement.className == "n-box active") {
                    e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box"
                } else {
                    //
                }
            },
            usePointFn: function(){
                if(this.point - this.useWPoint <= 0){
                    alert("보유중인 포인트가 부족합니다.")
                    this.useWPoint = 0
                    this.usePoint = 0
                    this.remPoint = this.point
                }else{
                    this.remPoint = this.point - this.useWPoint
                    this.usePoint = this.useWPoint
                }
            },
        }
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

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
</style>
