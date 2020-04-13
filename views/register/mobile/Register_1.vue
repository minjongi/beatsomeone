<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>Do you create beats?<br />Then join us!</h1>
        </div>

        <div class="login accounts__defaultLayout">
            <form action="">
                <div class="accounts__case">
                    <label for="listen " class="case case--listen">
                        <input type="radio" name="case" id="listen " hidden  @click="currentUserType = 'user'"/>
                        <div>
                            <span class="icon"></span>
                            <p>I want to listen<br />& buy music</p>
                        </div>
                    </label>

                    <label for="monetize" class="case case--monetize">
                        <input type="radio" name="case" id="monetize" hidden checked @click="currentUserType = 'musician'"/>
                        <div>
                            <span class="icon"></span>
                            <p>I want to monetize<br />my music</p>
                        </div>
                    </label>
                </div>

                <div class="accounts__switch" v-if="currentUserType === 'musician'">
                    <span class="accounts__switch-bg"></span>
                    <label for="monthly" @click="billTerm = 'monthly'">
                        <input type="radio" id="monthly" hidden name="bill" checked />
                        <span>Bill monthly</span>
                    </label>
                    <label for="yearly" @click="billTerm = 'yearly'">
                        <input type="radio" id="yearly" hidden name="bill" />
                        <span>
                  Bill yearly
                  <em>Save 20% or more</em>
                </span>
                    </label>
                </div>
            </form>
        </div>

        <div class="tab accounts__tab">
            <button data-target="plan-free" @click="plan = 'free'" :class="{'active':this.plan === 'free'}">
                FREE
            </button>
            <button data-target="plan-marketplace" @click="plan = 'marketplace'" :class="{'active':this.plan === 'marketplace'}" v-if="currentUserType === 'musician'">
                MARKETPLACE
            </button>
            <button data-target="plan-pro" @click="plan = 'pro'" :class="{'active':this.plan === 'pro'}" v-if="currentUserType === 'musician'">
                PRO PAGE
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free"  v-if="plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        FREE
                    </p>
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(1)">Get Started</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(1)">Get Started</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

        <div class="accounts__plan-case" id="plan-marketplace"  v-if="plan === 'marketplace'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        MARKETPLACE
                    </p>
                    <h2><span>$</span>{{ (billTerm === 'monthly' ? marketplacePlan.monthly_d : marketplacePlan.yearly_d) | money }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(2)">Get Started</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(2)">Get Started</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

        <div class="accounts__plan-case" id="plan-pro" v-if="plan === 'pro'" >
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        PRO PAGE
                    </p>
                    <h2><span>$</span>{{ (billTerm === 'monthly' ? proPlan.monthly_d : proPlan.yearly_d) | money }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(3)">Get Started</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(3)">Get Started</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>

    import { EventBus } from '*/src/eventbus';
    import $ from 'jquery'

    export default {
        data: function() {
            return {
                userType : ['user','musician'],
                currentUserType: null,
                billTerm : 'monthly',
                plan: 'free',
                listPlan : null,
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
            isMusician: function() {
                return this.currentUserType === this.userType[1];
            },
            marketplacePlan: function () {
                return this.listPlan ? _.find(this.listPlan,{'plan':'MARKETPLACE'}) : null;
            },
            proPlan: function () {
                return this.listPlan ? _.find(this.listPlan,{'plan':'PRO PAGE'}) : null;
            },
        },

        created() {
            this.currentUserType = this.userType[1];
            this.fetchData();
        },
        mounted() {


            // $('.accounts__tab button').on('click', function(){
            //     $('.accounts__tab button').removeClass('active');
            //     $(this).addClass('active')
            //     $('.accounts__plan-case').hide();
            //     var target = $(this).data('target');
            //     $('#'+target).show();
            // })

        },
        watch: {
            currentUserType(n) {
                this.plan = 'free';
                if(n === 'musician') {
                    this.billTerm = 'monthly';
                    this.$nextTick(function() {
                        var bg = document.querySelector(".accounts__switch-bg");
                        // 월간
                        document.getElementById("monthly").addEventListener("change", function () {
                            if (this.checked === true) {
                                bg.classList.remove("right");
                            }
                        });
                        // 연간
                        document.getElementById("yearly").addEventListener("change", function () {
                            if (this.checked === true) {
                                bg.classList.add("right");
                            }
                        });
                    });
                }
            }
        },
        methods: {
            doNext(type) {
                EventBus.$emit('submit_join_form',{ userType: this.currentUserType, plan: this.plan, billTerm: this.billTerm });
                this.$router.push({path: '/2'});
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

    .btn--start {
        margin-top: 10px;
        width: 100% !important;
    }

    div.right {
        width: 100px !important;
    }


</style>

<style lang="css">

</style>
