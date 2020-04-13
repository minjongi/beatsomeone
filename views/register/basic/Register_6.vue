<template>
    <div class="container accounts accounts--result">
        <h1 class="accounts__result-title">
            Join us with the various payment methods available!
        </h1>
        <div class="accounts__title">
            <h1>
                Marketplace Plan
            </h1>
        </div>

        <div class="login accounts__defaultLayout">

            <div class="accounts__switch">
                <span class="accounts__switch-bg"></span>
                <label for="monthly">
                    <input type="radio" id="monthly" value="monthly" hidden name="bill" v-model="billTerm"/>
                    <span>Bill monthly</span>
                </label>
                <label for="yearly">
                    <input type="radio" id="yearly" value="yearly" hidden name="bill"  v-model="billTerm"/>

                    <span>Bill yearly</span>
                </label>
            </div>


            <div class="accounts__plan-price">
                <h2>
                    <span>$</span>
                    {{ cost | money }}
                </h2>
                <div class="_saving">Instant Savings of <span>$100.00</span></div>
            </div>

            <div class="accounts__payments">
                <label for="promoCode" class="checkbox">
                    <input type="checkbox" hidden id="promoCode"/>
                    <span></span> I have a promo code
                </label>
                <div class="accounts__form">
                    <div class="row" id="nopromo">
                        <p class="form-title">결제수단(영문일 시 14pt Bold 사용)</p>
                        <div class="accounts__check">
                            <label for="type1" class="radio">
                                <input type="radio" id="type1" hidden name="payments"/>
                                <span></span> 신용카드
                            </label>
                            <label for="type2" class="radio">
                                <input type="radio" id="type2" hidden name="payments" checked/>
                                <span></span> 실시간계좌이체
                            </label>
                        </div>
                    </div>
                    <div class="row" style="display: none;" id="okpromo">
                        <label for="">
                            <p class="form-title">
                                Promo code
                            </p>
                            <div class="input flex">
                                <input type="text" placeholder="Number Number Number"/>
                                <button class="btn " :class="{'btn--gray' : !isPromotionApplied,'btn--submit' : isPromotionApplied,}" @click="applyPromotionCode()">Apply</button>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="accounts__btnbox">
                    <button type="submit" class="btn btn--submit" @click="doJoin">
                        Checkout
                    </button>
                    <p>
                        All sales are final and non-refundable. Please make sure to
                        fully read the <a href="">BeatSomeone Refund Policy</a>. before
                        you proceed.
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
            cost: function () {
                if(!this.listPlan) return null;
                let cost = 0;
                const info = this.$parent.info;
                if(info.plan === 'pro') {
                    if(info.billTerm === 'yearly') {
                        cost = this.proPlan.yearly_d;
                    } else {
                        cost = this.proPlan.monthly_d;
                    }
                } else {
                    if(info.billTerm === 'yearly') {
                        cost = this.marketplacePlan.yearly_d;
                    } else {
                        cost = this.marketplacePlan.monthly_d;
                    }
                }
                return cost;
            },
        },
        created() {
            this.billTerm = this.$parent.info.billTerm;
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
            // 연간
            document
                .getElementById("yearly")
                .addEventListener("change", function() {
                    if (this.checked === true) {
                        bg.classList.add("right");
                    }
                });


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
                });
            },
        },

    }


</script>

<style lang="scss">


</style>

<style lang="css">

</style>
