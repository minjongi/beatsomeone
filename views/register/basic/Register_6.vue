<template>
    <div class="container accounts accounts--result">
        <h1 class="accounts__result-title">
            {{ $t('paymentMethodMsg') }}
        </h1>
        <div class="accounts__title">
            <h1>
                {{$parent.info.planName}}
            </h1>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__switch">
                <span class="accounts__switch-bg"></span>
                <label for="monthly">
                    <input type="radio" id="monthly" value="monthly" hidden name="bill" v-model="billTerm" />
                    <span>{{ $t('billMonthly') }}</span>
                </label>
                <label for="yearly">
                    <input type="radio" id="yearly" value="yearly" hidden name="bill"  v-model="billTerm" />
                    <span>{{ $t('billYearly') }}</span>
                </label>
            </div>
            <div class="accounts__plan-price">
                <h2>
                    <span>{{ $t('currencySymbol') }}</span>
                    {{ localePrice(cost) }}
                </h2>
                <div class="_saving">{{ $t('instantSaving') }} {{ $t('currencySymbol') }}<span>{{ parseFloat(disBill.toString()).toFixed(0) }}</span></div>
            </div>
            <div class="accounts__payments">
                <label for="promoCode" class="checkbox">
                    <input type="checkbox" hidden id="promoCode" @change="promoCheckYn($event)" />
                    <span></span> {{ $t('havePromoCode') }}
                </label>
                <div class="accounts__form">
                    <div class="row" id="nopromo">
                        <p class="form-title">{{ $t('payMethod') }}</p>
                        <div class="accounts__check" v-if="locale !== 'en'">
                            <label for="type1" class="radio">
                                <input type="radio" id="type1" hidden name="payments" value="1" v-model="payMethod"/>
                                <span></span> {{ $t('creditCard') }}
                            </label>
                            <label for="type2" class="radio">
                                <input type="radio" id="type2" hidden name="payments" value="2" v-model="payMethod"/>
                                <span></span> {{ $t('realtimeBankTransfer') }}
                            </label>
                        </div>
                        <div class="accounts__check" v-if="locale === 'en'">
                            <label for="type3" class="radio">
                                <input type="radio" id="type3" hidden name="payments" value="3" v-model="payMethod"/>
                                <span></span> PayPal
                            </label>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="okpromo">
                        <label for="">
                            <p class="form-title">
                                {{ $t('promoCode') }}
                            </p>
                            <div class="input flex">
                                <input type="text" :placeholder="$t('number')" ref="pv" v-model="promoValue" />
                                <button class="btn " :class="{'btn--gray' : !isPromotionApplied,'btn--submit' : isPromotionApplied,}" @click="promoApply()">{{ $t('apply') }}</button>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="accounts__btnbox" v-if="this.cost == 0">
                    <button type="button" class="btn btn--submit" @click="procFreePay">
                        {{ $t('checkout') }}
                    </button>
                    <p>
                        {{ $t('refundPolicyMsg') }}
                    </p>
                </div>
                <div class="accounts__btnbox" v-else>
                    <button type="submit" class="btn btn--submit" @click="goPay" v-if="locale === 'ko'">
                        {{ $t('checkout') }}
                    </button>
                    <div style="margin: 0 auto;" v-else>
                        <PayPal
                                env="production"
                                currency="USD"
                                locale="en_US"
                                :amount="localePrice(cost)"
                                :client="paypal"
                                :invoice-number="unique_id"
                                :button-style="paypalBtnStyle"
                                @payment-authorized="paypalAuthorized"
                                @payment-completed="paypalCompleted"
                                @payment-cancelled="paypalCancelled">
                        </PayPal>
                    </div>
                    <p>
                        {{ $t('refundPolicyMsg') }}
                    </p>
                </div>
            </div>
        </div>
        <div>
            <form name="fm1" method="POST">
                <input type="text" name="allat_shop_id" v-model="allatForm.shop_id" maxlength=20>
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
                <input type=hidden name="allat_test_yn" v-model="allatForm.test_yn" maxlength=1>
                <input type="hidden" name="allat_card_yn" v-model="allatForm.card_yn" maxlength="1">
                <input type="hidden" name="allat_bank_yn" v-model="allatForm.bank_yn" maxlength="1">
                <input type="hidden" name="allat_vbank_yn" v-model="allatForm.vbank_yn" maxlength="1">
                <input type="hidden" name="allat_encode_type" value="U">
            </form>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '*/src/eventbus'
    import axios from "axios";
    import PayPal from 'vue-paypal-checkout'

    export default {
        components: {
            PayPal
        },
        data: function () {
            return {
                unique_id: '',
                userInfo: {},
                billTerm: null,
                promotionCode: null,
                isPromotionApplied: false,
                listPlan: null,
                cost: null,
                promoValue: null,
                disBill: "0.000",
                payMethod: 0,
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
                    'test_yn': 'N',
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
        computed: {
            locale: function () {
                this.setCost()
                return this.$i18n.locale
            },
            marketplacePlan: function () {
                return this.listPlan ? _.find(this.listPlan,{'plan':'MARKETPLACE'}) : null;
            },
            proPlan: function () {
                return this.listPlan ? _.find(this.listPlan,{'plan':'PRO PAGE'}) : null;
            },
            proPlanMonthlyPrice: function() {
                return this.$i18n.locale === 'en' ? this.proPlan.monthly_d : this.proPlan.monthly
            },
            proPlanYearlyPrice: function() {
                return this.$i18n.locale === 'en' ? this.proPlan.yearly_d : this.proPlan.yearly
            },
            proPlanYearlyDiscountAmt: function() {
                return this.$i18n.locale === 'en' ? this.proPlan.yearly_discount_amt_d : this.proPlan.yearly_discount_amt
            },
            marketplacePlanMonthlyPrice: function() {
                return this.$i18n.locale === 'en' ? this.marketplacePlan.monthly_d : this.marketplacePlan.monthly
            },
            marketplacePlanYearlyPrice: function() {
                return this.$i18n.locale === 'en' ? this.marketplacePlan.yearly_d : this.marketplacePlan.yearly
            },
            marketplacePlanYearlyDiscountAmt: function() {
                return this.$i18n.locale === 'en' ? this.marketplacePlan.yearly_discount_amt_d : this.marketplacePlan.yearly_discount_amt
            },
        },
        created() {
            this.billTerm = this.$parent.info.billTerm;
            // this.billTerm = 'monthly';
            this.fetchData();
        },
        mounted() {
            var bg = document.querySelector(".accounts__switch-bg");
            // 월간
            document
                .getElementById("monthly")
                .addEventListener("change", function() {
                    if (this.checked === true) {
                        bg.classList.remove("right");
                    }
                });
            // // 연간
            document
                .getElementById("yearly")
                .addEventListener("change", function() {
                    if (this.checked === true) {
                        bg.classList.add("right");
                    }
                });
        },
        watch: {
            billTerm(n) {
                var bg = document.querySelector(".accounts__switch-bg");
                if(n === 'monthly') {
                    bg.classList.remove("right");
                } else {
                    bg.classList.add("right");
                }
                EventBus.$emit('submit_join_form',{ billTerm : n});
                this.setCost();
            },
            promoValue(n){
                if(0< n.length){
                    this.isPromotionApplied = true;
                }else{
                    this.isPromotionApplied = false;
                }
                EventBus.$emit('submit_join_form',{ promoValue : n});
            }
        },
        methods: {
            fetchData() {
                Http.post( '/beatsomeoneApi/get_register_plan_cost').then(r=> {
                    this.listPlan = r;
                    this.setCost();
                });
                Http.post( '/beatsomeoneApi/get_unique_id').then(r=> {
                    this.unique_id = r.unique_id;
                });
                Http.post('/BeatsomeoneMypageApi/getUserInfo').then(r => {
                    this.userInfo = r;
                });
            },
            promoCheckYn(event) {
                var _no = document.getElementById('nopromo')
                var _ok = document.getElementById('okpromo')
                if( event.target.checked === true ) {
                    _no.style.display = 'none';
                    _ok.style.display = 'block';
                    this.promoValue = '';
                } else {
                    _no.style.display = 'block';
                    _ok.style.display = 'none';
                }
                this.setCost();
            },
            promoApply() {
                Http.post('/register/ajax_promocode_check', {'code' : this.promoValue}).then(r=> {
                    if(r["result"] == "available"){
                        if(r["data"]["type"] == "m" && this.$parent.info.billTerm == "monthly"){
                            alert(r["reason"]);
                            this.cost = String((1 - parseInt(r["data"]["disrate"])/100) * this.cost);
                            this.$refs.pv.readOnly = true;
                        }else{
                            alert(this.$t('notConditionOfCouponUse'));
                            this.setCost();
                        }
                    }else{
                        alert(r["reason"]);
                        this.setCost();
                    }
                });
            },
            setCost: function () {
                if(!this.listPlan) return null;
                let cost = 0;
                const info = this.$parent.info;
                if (this.$refs.pv) {
                    this.$refs.pv.readOnly = false;
                }
                if(info.plan === 'Pro Page') {
                    if(info.billTerm === 'yearly') {
                        this.cost = this.proPlanYearlyPrice
                        this.disBill = this.proPlanYearlyDiscountAmt
                    } else {
                        this.cost = this.proPlanMonthlyPrice
                        this.disBill = "0.000"
                    }
                } else {
                    if(info.billTerm === 'yearly') {
                        this.cost = this.marketplacePlanYearlyPrice
                        this.disBill = this.marketplacePlanYearlyDiscountAmt
                    } else {
                        this.cost = this.marketplacePlanMonthlyPrice
                        this.disBill = "0.000"
                    }
                }
                this.promoValue = '';

                this.payMethod = this.$i18n.locale === 'en' ? 3 : 0
            },
            goPay: function (e) {
                if ((this.cost) <= 0) {
                    alert("결제 금액을 확인해주세요")
                    return
                }
                if (!this.payMethod) {
                    alert("결제 방법을 선택해주세요")
                    return
                }

                if (this.payMethod == 1) {
                    this.allatForm.card_yn = 'Y'
                    this.allatForm.bank_yn = 'N'
                } else if (this.payMethod == 2) {
                    this.allatForm.card_yn = 'N'
                    this.allatForm.bank_yn = 'Y'
                } else {
                    alert('준비중 입니다')
                    return false
                }

                this.allatForm.order_no = this.unique_id
                this.allatForm.amt = this.localePrice(this.cost)
                this.allatForm.pmember_id = this.userInfo.mem_id
                this.allatForm.product_nm = this.$parent.info.plan + ' ' + this.$parent.info.planName + ' ' + this.$parent.info.billTerm
                this.allatForm.product_cd = this.allatForm.product_nm.replace(/ /gi, "")
                let buyerNm = this.userInfo.mem_firstname + ' ' + this.userInfo.mem_lastname
                if (!buyerNm.trim()) {
                  buyerNm = this.userInfo.mem_nickname || this.userInfo.mem_id;
                }
                this.allatForm.buyer_nm = buyerNm
                this.allatForm.recp_nm = this.allatForm.buyer_nm
                this.allatForm.recp_addr = this.userInfo.mem_address1 || this.userInfo.mem_email || this.userInfo.mem_id

                Http.post(
                    '/beatsomeoneApi/set_session_order_price', {price: this.allatForm.amt}
                ).then(
                    () => {
                        console.log(document.fm1)
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
                    this.ajaxMembershipPurchase().then(() => {
                        if (this.cor_id == '') {
                            alert("결제가 실패하였습니다.")
                            return
                        } else {
                            alert("결제가 완료되었습니다.")
                            window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage')
                        }
                    })
                }
            },
            procFreePay: function () {
                this.ajaxMembershipPurchase().then(() => {
                    if (this.cor_id == '') {
                        alert("결제가 실패하였습니다.")
                        return
                    } else {
                        alert("결제가 완료되었습니다.")
                        window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage')
                    }
                })
            },
            async ajaxMembershipPurchase() {
                try {
                    this.isLoading = true
                    var param = new FormData()
                    param.append('pay_type', this.payMethod)
                    param.append('priceType', this.getPriceType())
                    param.append('total_price_sum', this.cost)
                    param.append('paypal_data', this.paypalData)
                    param.append('bill_term', this.$parent.info.billTerm)
                    param.append('plan', this.$parent.info.plan)
                    param.append('plan_name', this.$parent.info.planName)

                    for (const key in this.allatForm) {
                        param.append('allat_' + key, this.allatForm[key])
                    }

                    const {data} = await axios.post('/beatsomeoneApi/membership_purchase', param)
                    if (data.message === 'ok') {
                        this.cor_id = data.cor_id
                    }
                } catch (err) {
                    console.log('ajaxUpdateOrder error')
                } finally {
                    this.isLoading = false
                }
            },
            getPriceType: function () {
                if (this.$i18n.locale === 'en') {
                    return '$'
                } else {
                    return '₩'
                }
            },
            paypalAuthorized: function (data) {
            },
            paypalCompleted: function (data) {
                this.paypalData = JSON.stringify(data)
                this.ajaxMembershipPurchase().then(() => {
                    if (this.cor_id == '') {
                        alert("결제가 실패하였습니다.")
                        return
                    } else {
                        alert("결제가 완료되었습니다.")
                        window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage')
                    }
                })
            },
            paypalCancelled: function (data) {
                alert('결제를 취소하셨습니다')
            },

            goBack: function (e) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/cmall/cart')
            },

            localePrice(price) {
                if (!price) return '';
                let decimalPoint = this.$i18n.locale === 'en' ? 2 : 0
                return parseFloat(price.toString()).toFixed(decimalPoint);
            }
        },
    }
</script>
