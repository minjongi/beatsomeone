<template>
    <div class="container">
        <h4 class="text-center mb-5">
            {{ $t('paymentMethodMsg') }}
        </h4>
        <h3 class="text-center" v-if="group">
            {{$t(group.mgr_title)}}
        </h3>
        <div class="bill-term">
            <label>
                <span>{{ group.billTerm === 'monthly' ? $t('billMonthly') : $t('billYearly') }}</span>
            </label>
        </div>
        <div class="text-center" v-if="group">
            <h2>
                <span>{{ $t('currencySymbol') }} {{ group.billTerm === 'monthly' ? ($i18n.locale === 'en' ? group.mgr_monthly_cost_d : group.mgr_monthly_cost_w) : ($i18n.locale === 'en' ? group.mgr_year_cost_d : group.mgr_year_cost_w) }}</span>
            </h2>
        </div>
        <div v-if="$i18n.locale === 'en'">
            <div class="my-4">
                <div class="checkout">
                    <div v-if="isEmptyPaypal === false">
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
                    <p class="text-center">
                        {{ $t('refundPolicyMsg') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PayPal from 'vue-paypal-checkout';
    import axios from 'axios';

    export default {
        name: "PayGroup",
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
                group: '',
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
            this.group = JSON.parse(localStorage.getItem('bs_group_info'));
            this.info = window.member;
            this.amount = this.group.billTerm === 'monthly' ? (this.group.mgr_monthly_cost_d) : (this.group.mgr_year_cost_d);
            this.amount_w = this.group.billTerm === 'monthly' ? (this.group.mgr_monthly_cost_w) : (this.group.mgr_year_cost_w);
            let now = Date.now();
            this.allat_order_no = now.toString();
            this.allat_amt = this.amount_w;
            this.allat_pmember_id = this.info.username;
            this.allat_product_cd = this.group.mgr_title;
            this.allat_product_nm = this.group.mgr_description;
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
                formData.append('mgr_id', this.group.mgr_id);
                formData.append('pg', this.info.pg);
                formData.append('amount', this.info.paypal.transactions[0].amount.total);
                formData.append('bill_term', this.group.billTerm);

                this.upgradeSeller(formData);
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

                    this.upgradeSeller(formData);
                }
            },
            upgradeSeller: function (formData) {
                axios.post('/mypage/post_upgrade', formData)
                    .then(res => res.data)
                    .then(data => {
                        alert(data.message);
                        window.location.href = '/mypage';
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

<style lang="scss" scoped>
    .container {
        background: url(/assets_m/images/accounts-result-bg.png) no-repeat center -50px;
        background-size: 100% auto;
        padding-top: 100px;

        .bill-term {
            label {
                display: flex;
                margin: 20px 75px;
                height: 50px;
                border-radius: 30px;
                background-color: #ffda2a;
                align-items: center;
                justify-content: center;
                color: black;
                border: solid 5px #232325;

                span {
                    font-size: 14px;
                    font-weight: 600;
                }
            }
        }

        .checkout {
            p {
                opacity: 0.3;
            }
        }
    }
</style>