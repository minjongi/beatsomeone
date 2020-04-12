<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>Do you create beats?<br />Then join us!</h1>

        </div>


        <div class="login accounts__defaultLayout">

                <div class="accounts__case">
                    <label for="listen " class="case case--listen">
                        <input type="radio" name="case" id="listen " hidden  @click="currentUserType = 'user'" />
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

                <div class="accounts__switch" v-if="isMusician">
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

        </div>


        <div class="accounts__plan-case" v-if="!isMusician">
            <table>
                <colgroup>
                    <col width="300" />
                    <col  />
                </colgroup>
                <thead>
                <tr>
                    <th></th>
                    <th>
                        <p>
                            <br />
                            FREE
                        </p>
                        <h2><span>$</span>0.00</h2>
                        <a href="#" class="btn btn--start" @click="doNext(1)">Get Started</a>
                    </th>
                </tr>
                </thead>
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
                <!--                    <tfoot>-->
                <tr>
                    <td></td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext(1)">Get Started</a>
                    </td>
                </tr>
                <!--                    </tfoot>-->
                </tbody>
            </table>
        </div>
        <div class="accounts__plan-case" v-if="isMusician">
            <table>
                <colgroup>
                    <col width="300" />
                    <col width="200" />
                    <col width="200" />
                    <col width="200" />
                </colgroup>
                <thead>
                <tr>
                    <th></th>
                    <th>
                        <p>
                            <br />
                            FREE
                        </p>
                        <h2><span>$</span>0.00</h2>
                        <a href="#" class="btn btn--start" @click="doNext('free')">Get Started</a>
                    </th>
                    <th>
                        <p>
                            MARKETPLACE<br />
                            PLAN
                        </p>
                        <h2><span>$</span>0.00<em>/mo</em></h2>
                        <a href="#" class="btn btn--start" @click="doNext('marketplace')">Get Started</a>
                    </th>
                    <th>
                        <p>PRO PAGE PLAN<br /><span>(Unlimited)</span></p>
                        <h2><span>$</span>0.00<em>/mo</em></h2>
                        <a href="#" class="btn btn--start" @click="doNext('pro')">Get Started</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Upload Tracks Limit</td>
                    <td>10</td>
                    <td>Unlimited</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td>Upload Track Stems</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Sound Kits</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell Custom Services</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Pro Page Sales Revenue</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        100% of Revenue to Seller
                    </td>
                </tr>
                <tr>
                    <td>Instant Payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <!-- <span class="un-check">X</span> -->
                        <span class="check">O</span>
                    </td>
                    <td>
                        <!-- <span class="un-check">X</span> -->
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept PayPal payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Accept Stripe payments</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sell On BeatStars Marketplace</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>BeatStars Marketplace Commission</td>
                    <td>
                        30%
                    </td>
                    <td>
                        0%
                    </td>
                    <td>
                        0%
                    </td>
                </tr>
                <tr>
                    <td>Embeddable Blaze Player</td>
                    <td>1</td>
                    <td>Unlimited</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td>Monthly Private Messages</td>
                    <td>5</td>
                    <td>20</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td>Number of License Agreements for Sale</td>
                    <td>2</td>
                    <td>4</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td>Premium Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Sales Statistics</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Submissions per Opportunity</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        1
                    </td>
                    <td>
                        2
                    </td>
                </tr>
                <tr>
                    <td>Widgets</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>SoundCloud Monetization</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>Audiomack Monetization</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <!--                    <tfoot>-->
                <tr>
                    <td></td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('free')">Get Started</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('marketplace')">Get Started</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('pro')">Get Started</a>
                    </td>
                </tr>
                <!--                    </tfoot>-->
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    import { EventBus } from '*/src/eventbus';

    export default {
        data: function() {
            return {
                userType : ['user','musician'],
                currentUserType: null,
                billTerm : 'monthly',

            }
        },
        computed: {
            isMusician: function() {
                return this.currentUserType === this.userType[1];
            },
        },
        created() {
            this.currentUserType = this.userType[1];
        },
        mounted() {

            // var bg = document.querySelector(".accounts__switch-bg");
            // // 월간
            // document.getElementById("monthly").addEventListener("change", function() {
            //     if (this.checked === true) {
            //         bg.classList.remove("right");
            //     }
            // });
            // // 연간
            // document.getElementById("yearly").addEventListener("change", function() {
            //     if (this.checked === true) {
            //         bg.classList.add("right");
            //     }
            // });

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
            doNext(plan) {
                EventBus.$emit('submit_join_form',{ userType: this.currentUserType, plan: plan, billTerm: this.billTerm  });
                this.$router.push({path: '/2'});
            },
        },

    }




</script>

<style lang="scss">



</style>

<style lang="css">

</style>
