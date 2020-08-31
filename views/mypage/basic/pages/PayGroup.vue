<template>
    <div class="accounts accounts--result">
        <div class="container">
            <h1 class="accounts__result-title">
                {{ $t('paymentMethodMsg') }}
            </h1>
            <div class="accounts__title">
                <h1 v-if="group">
                    {{$t(group.mgr_title)}}
                </h1>
            </div>
            <div class="login accounts__defaultLayout">
                <div class="accounts__switch">
                    <span class="accounts__switch-bg"></span>
                    <label>
                        <span>{{ group.billTerm === 'monthly' ? $t('billMonthly') : $t('billYearly') }}</span>
                    </label>
                </div>
                <div class="accounts__plan-price" v-if="group">
                    <h2>
                        <span>{{ $t('currencySymbol') }} {{ group.billTerm === 'monthly' ? ($i18n.locale === 'en' ? group.mgr_monthly_cost_d : group.mgr_monthly_cost_w) : ($i18n.locale === 'en' ? group.mgr_year_cost_d : group.mgr_year_cost_w) }}</span>
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
                            <button type="button" class="btn btn-block btn-primary" @click="payAllat">
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
                                <input type=text name="allat_product_cd" v-model="allat_product_cd" size="19"
                                       maxlength=1000>
                                <br>
                                <input type=text name="allat_product_nm" v-model="allat_product_nm" size="19"
                                       maxlength=1000>
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
    @mixin textIndet() {
        text-indent: -9999px;
        overflow: hidden;
    }

    @mixin flex($direction: row, $align: center, $justify: flex-start) {
        display: flex;
        flex-wrap: wrap;
        flex-direction: $direction;
        @if ($direction == row) {
            align-items: $align;
            justify-content: $justify;
        }
        @if ($direction == column) {
            align-items: $justify;
            justify-content: $align;
        }
    }

    .accounts__switch-bg {
        width: 450px !important;
    }

    .accounts {
        &.accounts--result {
            background: url('/assets/images/accounts-result-bg.png') no-repeat center -50px;
            background-size: 100% auto;

            .accounts__result-title {
                font-size: 32px;
                text-align: center;
                font-weight: 600;
                margin-bottom: 200px;
            }
        }

        padding-top: 140px;

        .accounts__defaultLayout {
            width: 460px;
            margin: 0 auto;
        }

        .accounts__title {
            margin-bottom: 50px;
            text-align: center;

            h1 {
                font-size: 45px;
                font-weight: 600;
                line-height: 55px;
            }

            p {
                font-size: 18px;
                margin-top: 20px;
            }
        }

        form,
        label {
            width: 100%;
        }

        .accounts__btnbox {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #3c3d3d;
            display: flex;
            flex-wrap: wrap;

            &.half {
                .btn {
                    flex: 1;

                    &:first-child {
                        margin-right: 10px;
                    }
                }
            }

            &.border-none {
                border: none;
                padding: 0;
            }

            p {
                margin-top: 1em;
                color: #fff;
                font-size: 14px;
                line-height: 1.5em;
                opacity: 0.3;

                a {
                    color: #fff;
                    text-decoration: underline;
                }
            }
        }

        .accounts__check {
            @include flex();

            .radio {
                width: 50%;
                flex: none;
                margin-top: 15px;
            }
        }

        .accounts__switch {
            padding: 5px;
            background: #232325;
            border-radius: 30px;
            position: relative;

            .accounts__switch-bg {
                position: absolute;
                display: block;
                width: 225px;
                height: 50px;
                line-height: 50px;
                background: #ffda2a;
                border-radius: 25px;
                left: 5px;
                top: 5px;
                z-index: 1;
                transition: all 0.5s;

                &.right {
                    left: 230px;
                }
            }

            @include flex;

            label {
                position: relative;
                z-index: 2;
                flex: 1;
                height: 50px;
                width: 50%;
                text-align: center;
                cursor: pointer;
                margin-bottom: 0;

                span {
                    position: absolute;
                    width: 100%;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 0;
                    color: #7f7f7f;
                    font-weight: 600;
                    transition: all 0.5s;

                    em {
                        display: block;
                        font-size: 14px;
                        color: #7f7f7f;
                        font-weight: 300;
                        font-style: normal;
                    }
                }

                input:checked + span {
                    color: #000;

                    em {
                        color: #000;
                    }
                }
            }
        }

        .accounts__plan-price {
            text-align: center;
            margin-top: 50px;

            h2 {
                span {
                    font-size: 34px;
                    font-weight: 600;
                }

                font-size: 45px;
                color: #fff;
                font-weight: 600;
            }

            ._saving {
                margin-top: 30px;
                display: inline-block;
                background: url('/assets/images/icon/saving-icon.png') #279198 no-repeat 25px center;
                border-radius: 2em;
                font-size: 15px;
                color: #fff;
                padding: 0 30px;
                padding-left: 55px;
                line-height: 34px;
                border: 2px solid #2a7e83;

                span {
                    border-bottom: 1px solid #fff;
                }
            }
        }

        .accounts__payments {
            margin-top: 60px;

            .checkbox {
                padding-bottom: 10px;
                margin-bottom: 25px;
                border-bottom: 1px solid #3c3d3d;
            }
        }
    }

    .accounts__form {
        .accounts__btn {
            width: 100%;
        }

        .row {
            margin-bottom: 20px;

            &:last-child {
                margin-bottom: 0;
            }
        }

        .form-title {
            color: #fff;
            font-size: 15px;
            margin-bottom: 5px;
            font-weight: 600;

            .required {
                color: #d54d4d;
                font-size: 18px;
            }
        }

        .input {
            width: 100%;

            &.flex {
                @include flex();

                button {
                    width: 140px;
                    margin-left: 10px;
                }

                input {
                    flex: 1;
                }
            }

            input {
                display: block;
                width: 100%;
                height: 55px;
                border-radius: 3px;
                background: #fff;
                font-size: 14px;
                padding: 0 15px;

                &:disabled {
                    background: #9fa2a5;
                    color: #63676b;
                }
            }
        }
    }

</style>