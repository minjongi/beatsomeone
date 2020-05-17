<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ $t('doYouCreateBeats') }}<br />{{ $t('thenJoin') }}</h1>
        </div>

        <div class="login accounts__defaultLayout">
            <form action="">
                <div class="accounts__case">
                    <label for="listen " class="case case--listen">
                        <input type="radio" name="case" id="listen " hidden  @click="currentUserType = 'user'"/>
                        <div>
                            <span class="icon"></span>
                            <p>{{ $t ('listenAndBuyMusic1') }}<br />{{ $t ('listenAndBuyMusic2') }}</p>
                        </div>
                    </label>

                    <label for="monetize" class="case case--monetize">
                        <input type="radio" name="case" id="monetize" hidden checked @click="currentUserType = 'musician'"/>
                        <div>
                            <span class="icon"></span>
                            <p>{{ $t('monetizeMyMusic1') }}<br />{{ $t('monetizeMyMusic2') }}</p>
                        </div>
                    </label>
                </div>

                <div class="accounts__switch" v-if="currentUserType === 'musician'">
                    <span class="accounts__switch-bg"></span>
                    <label for="monthly" @click="billTerm = 'monthly'">
                        <input type="radio" id="monthly" hidden name="bill" checked />
                        <span>{{ $t('billMonthly') }}</span>
                    </label>
                    <label for="yearly" @click="billTerm = 'yearly'">
                        <input type="radio" id="yearly" hidden name="bill" />
                        <span>
                            {{ $t('billYearly') }}
                            <em>{{ $t('save20') }}</em>
                        </span>
                    </label>
                </div>
            </form>
        </div>

        <div class="tab accounts__tab">
            <button data-target="plan-free" @click="plan = 'free'" :class="{'active':this.plan === 'free'}">
                {{ $t('free') }}
            </button>
            <button data-target="plan-marketplace" @click="plan = 'marketplace'" :class="{'active':this.plan === 'marketplace'}" v-if="currentUserType === 'musician'">
                {{ $t('marketPlace') }}
            </button>
            <button data-target="plan-pro" @click="plan = 'pro'" :class="{'active':this.plan === 'pro'}" v-if="currentUserType === 'musician'">
                {{ $t('proPage') }}
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free"  v-if="plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(1)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>{{ $t('uploadTracksLimit') }}</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('sellSoundKits') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>{{ $t('sellCustomServices') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('proPageSalesRevenue') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('instantPayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('acceptPayPalPayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('acceptStripePayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('sellOnBeatStarsMarketplace') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('beatStarsMarketplaceCommission') }}</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('embeddableBlazePlayer') }}</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>{{ $t('monthlyPrivateMessages') }}</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>{{ $t('numberOfLicenseAgreementsForSale') }}</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>{{ $t('premiumStatistics') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('submissionsPerOpportunity') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('widgets') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('soundCloudMonetization') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('audiomackMonetization') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(1)">{{ $t('getStarted') }}</a>
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
                        {{ $t('marketPlace') }}
                    </p>
                    <h2><span>$</span>{{ (billTerm === 'monthly' ? marketplacePlan.monthly_d : marketplacePlan.yearly_d) | money }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(2)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>{{ $t('uploadTracksLimit') }}</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('sellSoundKits') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>{{ $t('sellCustomServices') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('proPageSalesRevenue') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('instantPayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('acceptPayPalPayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('acceptStripePayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('sellOnBeatStarsMarketplace') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('beatStarsMarketplaceCommission') }}</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('embeddableBlazePlayer') }}</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>{{ $t('monthlyPrivateMessages') }}</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>{{ $t('numberOfLicenseAgreementsForSale') }}</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>{{ $t('premiumStatistics') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('submissionsPerOpportunity') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('widgets') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('soundCloudMonetization') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('audiomackMonetization') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(2)">{{ $t('getStarted') }}</a>
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
                        {{ $t('proPage') }}
                    </p>
                    <h2><span>$</span>{{ (billTerm === 'monthly' ? proPlan.monthly_d : proPlan.yearly_d) | money }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(3)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                    <td>{{ $t('uploadTracksLimit') }}</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('sellSoundKits') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>

                </tr>
                <tr>
                    <td>{{ $t('sellCustomServices') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('proPageSalesRevenue') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('instantPayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('acceptPayPalPayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('acceptStripePayments') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('sellOnBeatStarsMarketplace') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('beatStarsMarketplaceCommission') }}</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('embeddableBlazePlayer') }}</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>{{ $t('monthlyPrivateMessages') }}</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>{{ $t('numberOfLicenseAgreementsForSale') }}</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>{{ $t('premiumStatistics') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('submissionsPerOpportunity') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('widgets') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('soundCloudMonetization') }}</td>
                    <td>
                        <span class="un-check">X</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('audiomackMonetization') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
<!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="#" class="btn btn--start" @click="doNext(3)">{{ $t('getStarted') }}</a>
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
                if(type==2){
                    this.plan = "Marketplace";
                }else if(type==3){
                    this.plan = "Pro Page";
                }
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
