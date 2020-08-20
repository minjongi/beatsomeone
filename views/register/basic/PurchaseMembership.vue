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
                                    locale="en_US" />
                        </div>
                        <p>
                            {{ $t('refundPolicyMsg') }}
                        </p>
                    </div>
                </div>
            </div>
            <div v-else-if="$i18n.locale === 'ko'">
                AllAt
            </div>
        </div>
    </div>
</template>

<script>
    import PayPal from 'vue-paypal-checkout';
    import axios from 'axios';

    import { EventBus } from '*/src/eventbus';

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
                isEmptyPaypal: true,
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
                    console.log(this.isEmptyPaypal);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        mounted() {
            this.info = JSON.parse(localStorage.getItem('bs_user_info'));
            this.amount = this.info.billTerm === 'monthly' ? (this.info.group.mgr_monthly_cost_d) : (this.info.group.mgr_year_cost_d);
        },
        methods: {
            isEmptyObject: function(data) {
                return Object.keys(data).length === 0;
            },
            paypalAuthorized: function (data) {
            },
            paypalCompleted: function (data) {
                console.log(data);
                this.info.paypal = data;
                this.info.pg = 'paypal';

                this.registerSeller();
            },
            paypalCancelled: function (data) {
                alert('결제를 취소하셨습니다')
            },
            registerSeller: function () {
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
            }
        }
    }
</script>

<style scoped>
.accounts__switch-bg {
    width: 450px !important;
}
</style>