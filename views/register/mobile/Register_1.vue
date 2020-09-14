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
                            <em>{{ disBill }}{{ $t('savepercent') }}</em>
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
                {{ $t('platinum') }}
            </button>
            <button data-target="plan-pro" @click="plan = 'pro'" :class="{'active':this.plan === 'pro'}" v-if="currentUserType === 'musician'">
                {{ $t('master') }}
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free"  v-if="currentUserType === 'user' && plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span> {{ '0' | money($i18n.locale) }}<em>/mo</em></h2>
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
                    <td>개인 메시지(채팅) 기능</td>
                    <td>{{ $t('unlimited') }}</td>
                </tr>
                <tr>
                    <td>무료비트 다운로드</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <tr>
                    <td>구매 음원 파일 저장</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <tr>
                    <td>구매 음원 라이센스 저장</td>
                    <td>
                        <span class="check">O</span>
                    </td>

                </tr>
                <tr>
                    <td>미리듣기 스트리밍 서비스</td>
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


        <div class="accounts__plan-case" id="plan-musician-free"  v-if="currentUserType === 'musician' && plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span> {{ '0' | money($i18n.locale) }}<em>/mo</em></h2>
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
                    <td>5 → 10(event)<br>(1{{ $t('month') }})</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('beatsomeoneMarketplaceCommission') }}</td>
                    <td>
                        30%
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>
                        10<br>(1{{ $t('month') }})
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
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
                        {{ $t('platinum') }}<br />
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ (billTerm === 'monthly' ? marketplacePlanMonthlyPrice : marketplacePlanYearlyPrice) | money($i18n.locale) }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
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
                    <td>{{ $t('unlimited') }}</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('beatsomeoneMarketplaceCommission') }}</td>
                    <td>
                        10%
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>
                        20
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
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
                        {{ $t('master') }}<br />
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ (billTerm === 'monthly' ? proPlanMonthlyPrice : proPlanYearlyPrice) | money($i18n.locale) }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
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
                    <td>{{ $t('unlimited') }}</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('beatsomeoneMarketplaceCommission') }}</td>
                    <td>
                        O%<br>{{ $t('revenueToSeller100') }}
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>
                        {{ $t('unlimited') }}
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('salesStatistics') }}</td>
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

    export default {
        data: function() {
            return {
                userType : ['user','musician'],
                currentUserType: null,
                billTerm : 'monthly',
                plan: 'free',
                planName: 'free',
                listPlan : null,
                disBill: 0,
            }
        },
        filters: {
            money (value, locale) {
                if (!value) return '';
                value = parseFloat(value.toString());
                return value.toFixed(locale === 'en' ? 2 : 0);
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
            marketplacePlanMonthlyPrice: function () {
              return this.$i18n.locale === 'en' ? this.marketplacePlan.monthly_d : this.marketplacePlan.monthly
            },
            marketplacePlanYearlyPrice: function () {
              return this.$i18n.locale === 'en' ? this.marketplacePlan.yearly_d : this.marketplacePlan.yearly
            },
            proPlanMonthlyPrice: function () {
              return this.$i18n.locale === 'en' ? this.proPlan.monthly_d : this.proPlan.monthly
            },
            proPlanYearlyPrice: function () {
              return this.$i18n.locale === 'en' ? this.proPlan.yearly_d : this.proPlan.yearly
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
                var islogin = this.$parent.isLogin;
                if(type==2){
                    this.plan = "Marketplace";
                    this.planName = this.$t('Platinum');
                }else if(type==3){
                    this.plan = "Pro Page";
                    this.planName = this.$t('Master');
                }
                EventBus.$emit('submit_join_form',{ userType: this.currentUserType, plan: this.plan, planName: this.planName, billTerm: this.billTerm });

                if(islogin){
                    this.$router.push({path: '/6'});    
                }else{
                    this.$router.push({path: '/2'});
                }
            },
            fetchData() {
                Http.post( `/beatsomeoneApi/get_register_plan_cost`).then(r=> {
                    this.listPlan = r;
                    this.disBill = this.listPlan[0].yearly_discount_pc;
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
