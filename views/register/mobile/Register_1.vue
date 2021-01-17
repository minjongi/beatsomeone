<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ $t('doYouCreateBeats') }}<br />{{ $t('thenJoin') }}</h1>
        </div>

        <div class="login accounts__defaultLayout">
            <form action="">
                <div class="accounts__case">
                    <label for="listen " class="case case--listen">
                        <input type="radio" name="case" id="listen " hidden :checked="currentUserType == 'buyer'"/>
                        <div @click="currentUserType = 'buyer'">
                            <span class="icon"></span>
                            <p>{{ $t ('listenAndBuyMusic1') }}<br />{{ $t ('listenAndBuyMusic2') }}</p>
                        </div>
                    </label>

                    <label for="monetize" class="case case--monetize">
                        <input type="radio" name="case" id="monetize" hidden :checked="currentUserType == 'seller'"/>
                        <div @click="currentUserType = 'seller'">
                            <span class="icon"></span>
                            <p>{{ $t('monetizeMyMusic1') }}<br />{{ $t('monetizeMyMusic2') }}</p>
                        </div>
                    </label>
                </div>

                <div class="accounts__switch" v-if="isMusician">
                    <span class="accounts__switch-bg" :class="billTerm == 'yearly' ? 'right' : ''"></span>
                    <label for="monthly" @click="billTerm = 'monthly'">
                        <input type="radio" id="monthly" hidden name="bill" :checked="billTerm == 'monthly'"/>
                        <span>{{ $t('billMonthly') }}</span>
                    </label>
                    <label for="yearly" @click="billTerm = 'yearly'">
                        <input type="radio" id="yearly" hidden name="bill" :checked="billTerm == 'yearly'"/>
                        <span>
                            {{ $t('billYearly') }}
                            <em>{{ disBill }}{{ $t('savepercent') }}</em>
                        </span>
                    </label>
                </div>
            </form>
        </div>

        <div class="tab accounts__tab">
            <button data-target="plan-free" @click="plan = 'free'" :class="{'active':this.plan === 'free'}" style="padding: 0 9px !important;">
                {{ $t('free') }}
            </button>
            <button data-target="plan-marketplace" @click="plan = 'marketplace'" :class="{'active':this.plan === 'marketplace'}" v-if="isMusician">
                {{ $t('platinum') }}
            </button>
            <button data-target="plan-pro" @click="plan = 'pro'" :class="{'active':this.plan === 'pro'}" v-if="isMusician">
                {{ $t('master') }}
            </button> 
            <button data-target="plan-subscribe_common" @click="plan = 'subscribe_common'" :class="{'active':this.plan === 'subscribe_common'}" v-if="!isMusician && false"  style="padding: 0 9px !important;">
                {{ $t('lang128') }}
            </button>
             <button data-target="plan-subscribe_creater" @click="plan = 'subscribe_creater'" :class="{'active':this.plan === 'subscribe_creater'}" v-if="!isMusician && false"  style="padding: 0 9px !important;">
                {{ $t('lang129') }}
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free"  v-if="!isMusician && plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span> 0</h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>

                <tr v-if="false">
                    <td>{{ $t('lang130') }}</td>
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>


        <div class="accounts__plan-case" id="plan-musician-free"  v-if="isMusician && plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'en' ? sellerFreeGroup.mgr_monthly_cost_d : sellerFreeGroup.mgr_monthly_cost_w }}</h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(sellerFreeGroup)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                  <td>{{ $t('lang138') }}<br/>{{ $t('lang139') }}</td>
                  <td>{{ $t('lang140') }}</td>
                </tr>
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
                        {{ sellerFreeGroup.mgr_commission }}%
                    </td>
                </tr>
                <tr v-if="false">
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerFreeGroup)">{{ $t('getStarted') }}</a>
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
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ? sellerPlatinumGroup.mgr_monthly_cost_d : sellerPlatinumGroup.mgr_monthly_cost_w) :
                        ($i18n.locale === 'en' ? sellerPlatinumGroup.mgr_year_cost_d : sellerPlatinumGroup.mgr_year_cost_w) }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                  <td>{{ $t('lang138') }}<br/>{{ $t('lang139') }}</td>
                  <td>{{ $t('lang140') }}</td>
                </tr>
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
                        {{ sellerPlatinumGroup.mgr_commission }}%
                    </td>
                </tr>
                <tr v-if="false">
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
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
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ? sellerMasterGroup.mgr_monthly_cost_d : sellerMasterGroup.mgr_monthly_cost_w) : ($i18n.locale === 'en' ? sellerMasterGroup.mgr_year_cost_d : sellerMasterGroup.mgr_year_cost_w) }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>
                <tr>
                  <td>{{ $t('lang138') }}<br/>{{ $t('lang139') }}</td>
                  <td>{{ $t('lang141') }}</td>
                </tr>
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
                        {{ sellerMasterGroup.mgr_commission }}%<br>({{ $t('revenueToSeller100') }})
                    </td>
                </tr>
                <tr v-if="false">
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table>
        </div>

        <div class="accounts__plan-case" id="plan-subscribe_common"  v-if="!isMusician && plan === 'subscribe_common'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('lang128') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span> {{ $i18n.locale === 'en' ? subscribedCommon.mgr_monthly_cost_d : subscribedCommon.mgr_monthly_cost_w }}<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCommon)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>

                <tr v-if="false">
                    <td>{{ $t('lang130') }}</td>
                    <td>20건</td>
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                </tr>
<!--                </tfoot>-->
                </tbody>
            </table> 
        </div>

        <div class="accounts__plan-case" id="plan-subscribe_creater"  v-if="!isMusician && plan === 'subscribe_creater'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('lang129') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span> {{ $i18n.locale === 'en' ? subscribedCreater.mgr_monthly_cost_d : subscribedCreater.mgr_monthly_cost_w }}<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCreater)">{{ $t('getStarted') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>

                <tr v-if="false">
                    <td>{{ $t('lang130') }}</td>
                    <td>10건</td>
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
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
    import axios from "axios";

    export default {
        data: function () {
            return {
                userType: ['buyer', 'seller'],
                currentUserType: 'buyer',
                billTerm: 'monthly',
                listPlan: null,
                planName: 'free',
                plan: 'free',
                disBill: 10,
                buyerGroup: {},
                sellerFreeGroup: {},
                sellerPlatinumGroup: {},
                sellerMasterGroup: {},
                selectedGroup: {},
                subscribedCommon: {},
                subscribedCreater: {}
            }
        },
        filters: {
            money(value) {
                if (!value) return '';
                value = parseFloat(value.toString());
                return value.toFixed(2);
            }
        },
        computed: {
            isMusician: function () {
                return this.currentUserType === this.userType[1];
            },
        },
        created() {
            this.billTerm = localStorage.getItem("bill_term") || this.billTerm
            this.currentUserType = localStorage.getItem("UserOffer") || this.currentUserType
            this.fetchData();
        },
        mounted() {
            
        },
        watch: {
            currentUserType(n) {
                this.plan = 'free';
                if (n === 'seller') {
                    this.plan = 'pro';
                    this.billTerm = 'yearly';
                    this.$nextTick(function () {
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
                }else{
                     this.billTerm = 'monthly';
                }
            }
        },
        methods: {
            doNext(group) {
                this.$store.dispatch('setUserInfo', {
                    group: group,
                    billTerm: this.billTerm,
                })
                localStorage.setItem('mgr_id', group.mgr_id);
                localStorage.setItem('bill_term', (this.currentUserType === 'buyer' ? 'monthly' : this.billTerm))

                this.$router.push('/2');
            },
            fetchData() {
                axios.get('/membergroup')
                    .then(res => res.data)
                    .then(data => {
                        let list = Object.values(data);
                        console.log('this is list__________', list);
                        list.forEach(item => {
                            if (item.mgr_title === 'buyer') {
                                this.buyerGroup = item;
                            } else if (item.mgr_title === 'seller_free') {
                                this.sellerFreeGroup = item;
                            } else if (item.mgr_title === 'seller_platinum') {
                                this.sellerPlatinumGroup = item;
                            } else if (item.mgr_title === 'seller_master') {
                                this.sellerMasterGroup = item;
                            } else if (item.mgr_title === 'subscribe_common'){
                                this.subscribedCommon = item;
                            } else if (item.mgr_title === 'subscribe_creater'){
                                this.subscribedCreater = item;
                            }
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    })
                // Http.post(`/beatsomeoneApi/get_register_plan_cost`).then(r => {
                //     this.listPlan = r;
                //     // this.disBill = this.listPlan[0].yearly_discount_pc;
                // });
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
