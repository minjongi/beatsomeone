<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ $t('doYouCreateBeats') }}<br />{{ $t('thenJoin') }}</h1>
        </div>

        <div class="login accounts__defaultLayout">
                <div class="accounts__case">
                    <label for="listen " class="case case--listen">
                        <input type="radio" name="case" id="listen " hidden  @click="currentUserType = 'user'" />
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

                <div class="accounts__switch" v-if="isMusician">
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
                            {{ $t('free') }}
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>0.00</h2>
                        <a href="#" class="btn btn--start" @click="doNext(1)">{{ $t('getStarted') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>{{ $t('unlimited1') }}</td>
                </tr>
                <tr>
                    <td>{{ $t('freeBitDownload') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <tr>
                    <td>{{ $t('storePurchaseMusicFiles') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <tr>
                    <td>{{ $t('purchaseSoundSourceLicenseStorage') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <tr>
                    <td>{{ $t('previewStreamingService') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <!--                    <tfoot>-->
                <tr>
                    <td></td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext(1)">{{ $t('getStarted') }}</a>
                    </td>
                </tr>
                <!--                    </tfoot>-->
                </tbody>
            </table>
        </div>
        <div class="accounts__plan-case" v-if="isMusician && listPlan" >
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
                            {{ $t('free') }}
                        </p>
                        <h2><span>$</span>0.00</h2>
                        <a href="#" class="btn btn--start" @click="doNext('free')">{{ $t('getStarted') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('platinum') }}<br />
                        </p>
                        <h2><span>$</span>{{ (billTerm === 'monthly' ? marketplacePlan.monthly_d : marketplacePlan.yearly_d) | money }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                        <a href="#" class="btn btn--start" @click="doNext('Marketplace')">{{ $t('getStarted') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('master') }}<br />
                        </p>
                        <h2><span>$</span>{{ (billTerm === 'monthly' ? proPlan.monthly_d : proPlan.yearly_d) | money }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                        <a href="#" class="btn btn--start" @click="doNext('Pro Page')">{{ $t('getStarted') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $t('uploadTracksLimit') }}</td>
                    <td>10(event)<br>(1{{ $t('month') }})</td>
                    <td>{{ $t('unlimited1') }}</td>
                    <td>{{ $t('unlimited1') }}</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
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
                    <td>{{ $t('beatsomeoneMarketplaceCommission') }}</td>
                    <td>
                        30%
                    </td>
                    <td>
                        10%
                    </td>
                    <td>
                        O%
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>
                        10<br>(1{{ $t('month') }})
                    </td>
                    <td>
                        20
                    </td>
                    <td>
                        {{ $t('unlimited1') }}
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
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
                        <a href="#" class="btn btn--start" @click="doNext('free')">{{ $t('getStarted') }}</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('marketplace')">{{ $t('getStarted') }}</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('pro')">{{ $t('getStarted') }}</a>
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
                listPlan : null,
                planName: 'free',

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
                if(plan=="Marketplace"){
                    this.planName = this.$t('Platinum');
                }else if(plan=="Pro Page"){
                    this.planName = this.$t('Master');
                }
                EventBus.$emit('submit_join_form',{ userType: this.currentUserType, plan: plan, planName: this.planName, billTerm: this.billTerm  });
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



</style>

<style lang="css">

</style>
