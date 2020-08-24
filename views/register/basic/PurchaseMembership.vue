<template>
    <div class="container accounts accounts--result">
        <h1 class="accounts__result-title">
            {{ $t('paymentMethodMsg') }}
        </h1>
        <div class="accounts__title">
            <h1 v-if="info.group">
                {{$t(info.group.mgr_title)}}
            </h1>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__switch">
                <span class="accounts__switch-bg"></span>
                <label>
                    <span>{{ info.billTerm === 'monthly' ? $t('billMonthly') : $t('billYearly') }}</span>
                </label>
            </div>
            <div class="accounts__plan-price" v-if="info.group">
                <h2>
                    <span>{{ $t('currencySymbol') }} {{ info.billTerm === 'monthly' ? ($i18n.locale === 'en' ? info.group.mgr_monthly_cost_d : info.group.mgr_monthly_cost_w) : ($i18n.locale === 'en' ? info.group.mgr_year_cost_d : info.group.mgr_year_cost_w) }}</span>
                </h2>
            </div>
            <div v-if="$i18n.locale === 'en'">
                <div class="accounts__payments">
                    <div class="accounts__btnbox">
                        <div style="margin: 0 auto;" v-if="isEmptyPaypal === false">
                            <PayPal :env="pg_paypal_env"
                                    currency="USD"
                                    :amount="amount"
                                    :client="paypal"
                                    :button-style="paypalBtnStyle"
                                    v-on:payment-authorized="paypalAuthorized"
                                    v-on:payment-completed="paypalCompleted"
                                    v-on:payment-cancelled="paypalCancelled"
                                    locale="en_US"/>
                        </div>
                        <p>
                            {{ $t('refundPolicyMsg') }}
                        </p>
                    </div>
                </div>
            </div>
            <div v-else-if="$i18n.locale === 'ko'">
                <div class="accounts__payments">
                    <label for="promoCode" class="checkbox" v-if="false">
                        <input type="checkbox" hidden id="promoCode" @change="promoCheckYn($event)"/>
                        <span></span> {{ $t('havePromoCode') }}
                    </label>
                    <div class="accounts__form">
                        <div class="row" id="nopromo">
                            <p class="form-title">{{ $t('payMethod') }}</p>
                            <div class="accounts__check">
                                <label for="type1" class="radio">
                                    <input type="radio" id="type1" hidden name="payments" v-bind:value="1"
                                           v-model="payMethod"/>
                                    <span></span> {{ $t('creditCard') }}
                                </label>
                                <label for="type2" class="radio">
                                    <input type="radio" id="type2" hidden name="payments" v-bind:value="2"
                                           v-model="payMethod"/>
                                    <span></span> {{ $t('realtimeBankTransfer') }}
                                </label>
                            </div>
                        </div>
                        <div class="row" style="display:none;" id="okpromo">
                            <label for="">
                                <p class="form-title">
                                    {{ $t('promoCode') }}
                                </p>
                                <div class="input flex">
                                    <input type="text" :placeholder="$t('number')" ref="pv" v-model="promoValue"/>
                                    <button class="btn "
                                            :class="{'btn--gray' : !isPromotionApplied,'btn--submit' : isPromotionApplied,}"
                                            @click="promoApply()">{{ $t('apply') }}
                                    </button>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="accounts__btnbox">
                        <button type="button" class="btn btn--submit" @click="payAllat">
                            {{ $t('checkout') }}
                        </button>
                        <form name="fm" style="background-color: white; display: none;">
                            <input type="text" name="allat_shop_id" v-model="allat_shop_id" size="19" maxlength=20>
                            <br>
                            <input type=text name="allat_order_no" v-model="allat_order_no" size="19" maxlength=70>
                            <br>
                            <input type=text name="allat_amt" v-model="allat_amt" size="19" maxlength=10>
                            <br>
                            <input type=text name="allat_pmember_id" v-model="allat_pmember_id" size="19" maxlength=20>
                            <br>
                            <input type=text name="allat_product_cd" v-model="allat_product_cd" size="19" maxlength=1000>
                            <br>
                            <input type=text name="allat_product_nm" v-model="allat_product_nm" size="19" maxlength=1000>
                            <br>
                            <input type=text name="allat_buyer_nm" v-model="allat_buyer_nm" size="19" maxlength=20>
                            <br>
                            <input type=text name="allat_recp_nm" v-model="allat_recp_nm" size="19" maxlength=20>
                            <br>
                            <input type=text name="allat_recp_addr" v-model="allat_recp_addr" size="19" maxlength=120>
                            <br>
                            <input type=text name="shop_receive_url" v-model="shop_receive_url" size="19">
                            <br>
                            <input type="hidden" name="allat_enc_data" v-model="allat_enc_data">
                            <br>
                            <input type=text name="allat_card_yn" v-model="allat_card_yn" size="19" maxlength=1>
                            <br>
                            <input type=text name="allat_bank_yn" v-model="allat_bank_yn" size="19" maxlength=1>
                        </form>
                        <p>
                            {{ $t('refundPolicyMsg') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PayPal from 'vue-paypal-checkout';
    import axios from 'axios';

    import {EventBus} from '*/src/eventbus';

    export default {
        name: "PurchaseMembership",
        components: {
            PayPal
        },
        data: function () {
            return {
                info: {},
                unique_id: '',
                use_pg_test: 0,
                pg_paypal_env: '',
                paypal: {},
                paypalBtnStyle: {
                    label: 'pay',
                    size: 'large',
                    shape: 'rect',
                },
                paypalData: null,
                amount: '0',
                amount_w: '0',
                isEmptyPaypal: true,
                payMethod: 1,
                promoValue: null,
                isPromotionApplied: false,
                allat_shop_id: 'dumdum',
                allat_order_no: '',
                allat_amt: '',
                allat_pmember_id: '',
                allat_product_cd: '',
                allat_product_nm: '',
                allat_buyer_nm: '',
                allat_recp_nm: '',
                allat_recp_addr: '',
                shop_receive_url: window.allat_shop_receive_url,
                allat_card_yn: 'N',
                allat_bank_yn: 'N',
                allat_enc_data: '',
            }
        },
        created() {
            axios.get('/payment/paypal_config')
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
        },
        mounted() {
            this.info = JSON.parse(localStorage.getItem('bs_user_info'));
            this.amount = this.info.billTerm === 'monthly' ? (this.info.group.mgr_monthly_cost_d) : (this.info.group.mgr_year_cost_d);
            this.amount_w = this.info.billTerm === 'monthly' ? (this.info.group.mgr_monthly_cost_w) : (this.info.group.mgr_year_cost_w);
            let now  = Date.now();
            this.allat_order_no = now.toString();
            this.allat_amt = this.amount_w;
            this.allat_pmember_id = this.info.username;
            this.allat_product_cd = this.info.group.mgr_title;
            this.allat_product_nm = this.info.group.mgr_description;
            this.allat_buyer_nm = (!!this.info.firstname && !!this.info.lastname) ? this.info.firstname + ' ' + this.info.lastname : this.info.username;
            this.allat_recp_nm = this.allat_buyer_nm;
            this.allat_recp_addr = this.info.location || this.info.email;
            if (this.payMethod === 1) {
                this.allat_card_yn = 'Y';
                this.allat_bank_yn = 'N';
            } else if (this.payMethod === 2) {
                this.allat_card_yn = 'N';
                this.allat_bank_yn = 'Y';
            }
        },
        methods: {
            isEmptyObject: function (data) {
                return Object.keys(data).length === 0;
            },
            paypalAuthorized: function (data) {
            },
            paypalCompleted: function (data) {
                this.info.paypal = data;
                this.info.pg = 'paypal';

                let formData = new FormData();
                formData.append('mem_userid', this.info.username);
                formData.append('mem_email', this.info.email);
                formData.append('mem_password', this.info.password);
                formData.append('mem_firstname', this.info.firstname || '');
                formData.append('mem_lastname', this.info.lastname || '');
                formData.append('mem_address1', this.info.location || '');
                formData.append('mem_profile_content', this.info.introduce);
                formData.append('mem_type', this.info.type);
                formData.append('mgr_id', this.info.group.mgr_id);
                formData.append('pg', this.info.pg);
                formData.append('amount', this.info.paypal.transactions[0].amount.total);
                formData.append('bill_term', this.info.billTerm);

                this.registerSeller(formData);
            },
            paypalCancelled: function (data) {
                alert('결제를 취소하셨습니다')
            },
            promoCheckYn(event) {
                var _no = document.getElementById('nopromo')
                var _ok = document.getElementById('okpromo')
                if (event.target.checked === true) {
                    _no.style.display = 'none';
                    _ok.style.display = 'block';
                    this.promoValue = '';
                } else {
                    _no.style.display = 'block';
                    _ok.style.display = 'none';
                }
                // this.setCost();
            },
            promoApply() {
                Http.post('/register/ajax_promocode_check', {'code': this.promoValue}).then(r => {
                    if (r["result"] == "available") {
                        if (r["data"]["type"] == "m" && this.$parent.info.billTerm == "monthly") {
                            alert(r["reason"]);
                            this.cost = String((1 - parseInt(r["data"]["disrate"]) / 100) * this.cost);
                            this.$refs.pv.readOnly = true;
                        } else {
                            alert(this.$t('notConditionOfCouponUse'));
                            // this.setCost();
                        }
                    } else {
                        alert(r["reason"]);
                        // this.setCost();
                    }
                });
            },
            payAllat: function (e) {
                window.AllatPay_Approval(document.fm);
                window.AllatPay_Closechk_Start();
            },
            procCompletePay: function (result_cd, result_msg, enc_data) {
                window.AllatPay_Closechk_End();

                if (result_cd !== "0000") {
                    setTimeout(function () {
                        alert(result_cd + " : " + result_msg);
                    }, 500);
                } else {
                    this.allat_enc_data = enc_data;
                    this.info.allat = this.allat_enc_data;
                    this.info.pg = 'allat';

                    let formData = new FormData();
                    formData.append('mem_userid', this.info.username);
                    formData.append('mem_email', this.info.email);
                    formData.append('mem_password', this.info.password);
                    formData.append('mem_firstname', this.info.firstname || '');
                    formData.append('mem_lastname', this.info.lastname || '');
                    formData.append('mem_address1', this.info.location || '');
                    formData.append('mem_profile_content', this.info.introduce);
                    formData.append('mem_type', this.info.type);
                    formData.append('mgr_id', this.info.group.mgr_id);
                    formData.append('pg', this.info.pg);
                    formData.append('amount', this.amount_w);
                    formData.append('bill_term', this.info.billTerm);

                    this.registerSeller(formData);
                }
            },
            registerSeller: function (formData) {
                axios.post('/register/form', formData)
                    .then(res => res.data)
                    .then(data => {
                        if (data.email_auth_message) {
                            alert(data.email_auth_message);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
        },
        watch: {
            payMethod: function (val) {
                if (val === 1) {
                    this.allat_card_yn = 'Y';
                    this.allat_bank_yn = 'N';
                } else if (val === 2) {
                    this.allat_card_yn = 'N';
                    this.allat_bank_yn = 'Y';
                }
            }
        }
    }
</script>

<style scoped>
    .accounts__switch-bg {
        width: 450px !important;
    }
</style>