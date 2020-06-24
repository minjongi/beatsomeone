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
                <div class="_saving">Instant Savings of {{ $t('currencySymbol') }}<span>{{disBill}}</span></div>
            </div>

            <div class="accounts__payments">
                <label for="promoCode" class="checkbox">
                    <input type="checkbox" hidden id="promoCode" @change="promoCheckYn($event)" />
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
                                <input type="text" :placeholder="$t('number')" ref="pv" v-model="promoValue" />
                                <button class="btn " :class="{'btn--gray' : !isPromotionApplied,'btn--submit' : isPromotionApplied,}" @click="promoApply()">{{ $t('apply') }}</button>
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
                promoValue: null,
                disBill : "0.000",
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
            doJoin() {
                EventBus.$emit('finish_join_form',{ "promo_code" : this.promoValue});
            },
            fetchData() {
                Http.post( `/beatsomeoneApi/get_register_plan_cost`).then(r=> {
                    this.listPlan = r;
                    this.setCost();
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
                this.$refs.pv.readOnly = false;
                if(info.plan === 'Pro Page') {
                    if(info.billTerm === 'yearly') {
                        this.cost = this.proPlan.yearly_d;
                        this.disBill = this.proPlan.yearly_discount_amt_d;
                    } else {
                        this.cost = this.proPlan.monthly_d;
                        this.disBill = "0.000";
                    }
                } else {
                    if(info.billTerm === 'yearly') {
                        this.cost = this.marketplacePlan.yearly_d;
                        this.disBill = this.marketplacePlan.yearly_discount_amt_d;
                    } else {
                        this.cost = this.marketplacePlan.monthly_d;
                        this.disBill = "0.000";
                    }
                }
                this.promoValue = '';
            },
        },
    }
</script>

<style lang="scss">

</style>

<style lang="css">

</style>
