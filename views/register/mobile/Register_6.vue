<template>
    <div class="container accounts accounts--result">
        <h1 class="accounts__result-title">
            {{ $t('paymentMethodMsg') }}
        </h1>
        <div class="accounts__title">
            <h1>
                {{$parent.info.plan}} {{ $t('plan') }}
            </h1>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__switch">
                <span class="accounts__switch-bg " ></span>
                <label for="monthly">
                    <input type="radio" id="monthly" value="monthly" hidden name="bill" v-model="billTerm"/>
                    <span>{{ $t('billMonthly') }}</span>
                </label>
                <label for="yearly">
                    <input type="radio" id="yearly" value="yearly" hidden name="bill"  v-model="billTerm"/>
                    <span>{{ $t('billYearly') }}</span>
                </label>
            </div>
            <div class="accounts__plan-price">
                <h2>
                    <span>$</span>
                    {{ cost | money }}
                </h2>
                <div class="_saving">{{ $t('instantSaving') }} <span id="disBill">{{ $t('currencySymbol') }}0.000</span></div>
            </div>

            <div class="accounts__payments">
                <label for="promoCode" class="checkbox">
                    <input type="checkbox" hidden id="promoCode"/>
                    <span></span> {{ $t('havePromoCode') }}
                </label>
                <div class="accounts__form">
                    <div class="row" id="nopromo">
                        <p class="form-title">{{ $t('payMethod') }}</p>
                        <div class="accounts__check">
                            <label for="type1" class="radio">
                                <input type="radio" id="type1" hidden name="payments"/>
                                <span></span> {{ $t('creditCard') }}
                            </label>
                            <label for="type2" class="radio">
                                <input type="radio" id="type2" hidden name="payments" checked/>
                                <span></span> {{ $t('realtimeBankTransfer') }}
                            </label>
                        </div>
                    </div>
                    <div class="row" style="display: none;" id="okpromo">
                        <label for="">
                            <p class="form-title">
                                {{ $t('promoCode') }}
                            </p>
                            <div class="input flex">
                                <input type="text" :placeholder="$t('number')"/>
                                <button class="btn " :class="{'btn--gray' : !isPromotionApplied,'btn--submit' : isPromotionApplied,}" @click="applyPromotionCode()">{{ $t('apply') }}</button>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="accounts__btnbox">
                    <button type="submit" class="btn btn--submit" @click="doJoin">
                        {{ $t('checkout') }}
                    </button>
                    <p>
                        {{ $t('refundPolicyMsg') }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '*/src/eventbus';

    export default {
        data: function () {
            return {
                user: {},
                billTerm: null,
                promotionCode: null,
                isPromotionApplied: false,
                listPlan: null,
                cost: null,
            }
        },
        filters: {
            money (value) {
                if (!value) return '';
                value = parseFloat(value.toString());
                return value.toFixed(2);
            }
        },
        computed: {
            marketplacePlan: function () {
                return this.listPlan ? _.find(this.listPlan,{'plan':'MARKETPLACE'}) : null;
            },
            proPlan: function () {
                return this.listPlan ? _.find(this.listPlan,{'plan':'PRO PAGE'}) : null;
            },
        },
        created() {
            this.billTerm = this.$parent.info.billTerm;
            this.fetchData();
        },
        mounted() {
            var bg = document.querySelector(".accounts__switch-bg");

            document.getElementById('promoCode').addEventListener('change', function(){
                var _no = document.getElementById('nopromo')
                var _ok = document.getElementById('okpromo')
                if( this.checked === true ) {
                    _no.style.display = 'none';
                    _ok.style.display = 'block';
                } else {
                    _no.style.display = 'block';
                    _ok.style.display = 'none';
                }
            })
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
        },
        methods: {
            doJoin() {
                EventBus.$emit('finish_join_form',{});
            },
            applyPromotionCode(){
                this.isPromotionApplied = true;
            },
            fetchData() {
                Http.post( `/beatsomeoneApi/get_register_plan_cost`).then(r=> {
                    this.listPlan = r;
                    this.setCost();
                });
            },
            setCost: function () {
                if(!this.listPlan) return null;
                let cost = 0;
                const info = this.$parent.info;
                if(info.plan === 'Pro Page') {
                    if(info.billTerm === 'yearly') {
                        this.cost = this.proPlan.yearly_d;
                        // eslint-disable-next-line no-undef
                        $('#disBill').text("$"+this.proPlan.yearly_discount_amt_d);
                    } else {
                        this.cost = this.proPlan.monthly_d;
                        // eslint-disable-next-line no-undef
                        $('#disBill').text("$0.000");
                    }
                } else {
                    if(info.billTerm === 'yearly') {
                        this.cost = this.marketplacePlan.yearly_d;
                        // eslint-disable-next-line no-undef
                        $('#disBill').text("$"+this.marketplacePlan.yearly_discount_amt_d);
                    } else {
                        this.cost = this.marketplacePlan.monthly_d;
                        // eslint-disable-next-line no-undef
                        $('#disBill').text("$0.000");
                    }
                }
            },
        },
    }
</script>

<style lang="scss">

</style>

<style lang="css">

</style>
