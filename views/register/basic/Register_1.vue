<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ $t('doYouCreateBeats') }}<br/>{{ $t('thenJoin') }}</h1>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__case">
                <label for="listen" class="case case--listen">
                    <input type="radio" name="case" id="listen" hidden :checked="currentUserType == 'buyer'"/>
                    <div @click="currentUserType = 'buyer'">
                        <span class="icon"></span>
                        <p>{{ $t ('listenAndBuyMusic1') }}<br/>{{ $t ('listenAndBuyMusic2') }}</p>
                    </div>
                </label>

                <label for="monetize" class="case case--monetize">
                    <input type="radio" name="case" id="monetize" hidden :checked="currentUserType == 'seller'"/>
                    <div @click="currentUserType = 'seller'">
                        <span class="icon"></span>
                        <p>{{ $t('monetizeMyMusic1') }}<br/>{{ $t('monetizeMyMusic2') }}</p>
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
        </div>

        <div class="accounts__plan-case" v-if="!isMusician">
            <table>
                <colgroup>
                    <col width="300"/>
                    <col/>
                </colgroup>
                <thead>
                <tr>
                    <th></th>
                    <th>
                        <p>
                            {{ $t('free') }}
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'en' ? buyerGroup.mgr_monthly_cost_d : buyerGroup.mgr_monthly_cost_w }}</h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </th>
                    <th v-if="test">
                        <p>
                            {{ $t('lang128') }}
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'en' ? subscribedCommon.mgr_monthly_cost_d : subscribedCommon.mgr_monthly_cost_w }}<em>{{ $t('monthly') }}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCommon)">{{ $t('getStarted') }}</a>
                    </th>
                    <th v-if="test">
                        <p>
                            {{ $t('lang129') }}
                        </p>
                       <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'en' ? subscribedCreater.mgr_monthly_cost_d : subscribedCreater.mgr_monthly_cost_w }}<em>{{ $t('monthly') }}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCreater)">{{ $t('getStarted') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="test">
                    <td>{{ $t('downloadBackgroundMusic') }}</td>
                    <td> <span class="check">1</span></td>
                    <td>20건</td>
                    <td>10건</td>
                </tr>
                <tr>
                    <td>{{ $t('freeBeatDownload') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('storePurchaseMusicFiles') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('purchaseSoundSourceLicenseStorage') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('previewStreamingService') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                     <td v-if="test">
                        <span class="check">O</span>
                    </td>
                    <td v-if="test">
                        <span class="check">O</span>
                    </td>
                </tr>
                <!--                    <tfoot>-->
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                    <td v-if="test">
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                    <td v-if="test">
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                </tr>
                <!--                    </tfoot>-->
                </tbody>
            </table>
        </div>
        <div class="accounts__plan-case" v-if="isMusician">
            <table>
                <colgroup>
                    <col width="300"/>
                    <col width="200"/>
                    <col width="200"/>
                    <col width="200"/>
                </colgroup>
                <thead>
                <tr>
                    <th></th>
                    <th>
                        <p>
                            {{ $t('free') }}
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'en' ? sellerFreeGroup.mgr_monthly_cost_d : sellerFreeGroup.mgr_monthly_cost_w }}</h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerFreeGroup)">{{ $t('getStarted') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('platinum') }}<br/>
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ? sellerPlatinumGroup.mgr_monthly_cost_d : sellerPlatinumGroup.mgr_monthly_cost_w) :
                            ($i18n.locale === 'en' ? sellerPlatinumGroup.mgr_year_cost_d : sellerPlatinumGroup.mgr_year_cost_w) }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('master') }}<br/>
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ? sellerMasterGroup.mgr_monthly_cost_d : sellerMasterGroup.mgr_monthly_cost_w) : ($i18n.locale === 'en' ? sellerMasterGroup.mgr_year_cost_d : sellerMasterGroup.mgr_year_cost_w) }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $t('uploadTracksLimit') }}</td>
                    <td>5 → 10(event)<br>(1{{ $t('month') }})</td>
                    <td>{{ $t('unlimited') }}</td>
                    <td>{{ $t('unlimited') }}</td>
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
                        {{ sellerFreeGroup.mgr_commission }}%
                    </td>
                    <td>
                        {{ sellerPlatinumGroup.mgr_commission }}%
                    </td>
                    <td>
                        {{ sellerMasterGroup.mgr_commission }}%<br>({{ $t('revenueToSeller100') }})
                    </td>
                </tr>
                <tr v-if="test">
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>
                        10<br>(1{{ $t('month') }})
                    </td>
                    <td>
                        20
                    </td>
                    <td>
                        {{ $t('unlimited') }}
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerFreeGroup)">{{ $t('getStarted') }}</a>
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
                    </td>
                </tr>
                <!--                    </tfoot>-->
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    import {EventBus} from '*/src/eventbus';
    import axios from 'axios';

    export default {
        data: function () {
            return {
                userType: ['buyer', 'seller'],
                currentUserType: 'buyer',
                billTerm: 'monthly',
                listPlan: null,
                planName: 'free',
                disBill: 17,
                buyerGroup: {},
                sellerFreeGroup: {},
                sellerPlatinumGroup: {},
                sellerMasterGroup: {},
                selectedGroup: {},
                subscribedCommon: {},
                subscribedCreater: {},
                buyerFree: {},
                test: false
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

            if (window.location.search === '?t=1') {
              this.test = true
            }
        },
        mounted() {
            var bg = document.querySelector(".accounts__switch-bg");
            // 월간
            // document.getElementById("monthly").addEventListener("change", function () {
            //     if (this.checked === true) {
            //         bg.classList.remove("right");
            //     }
            // });
            // // 연간
            // document.getElementById("yearly").addEventListener("change", function () {
            //     if (this.checked === true) {
            //         bg.classList.add("right");
            //     }
            // });
            localStorage.clear();
        },
        watch: {
            currentUserType(n) {
                console.log('this si currentUserType_______', n);
                this.plan = 'free';
                if (n === 'seller') {
                    this.billTerm = 'yearly'
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
                }
            }
        },
        methods: {
            doNext(group) {
                let billTerm = this.currentUserType === 'buyer' ? 'monthly' : this.billTerm
                this.$store.dispatch('setUserInfo', {
                    group: group,
                    billTerm: billTerm
                })
                localStorage.setItem('mgr_id', group.mgr_id)
                localStorage.setItem('bill_term', billTerm)
                this.$router.push('/2')
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


</style>

<style lang="css">
    .wrapper {
        background: url("/assets/images/signup01-bg.png") no-repeat center -50px;
        background-size: 100% auto;
    }
</style>
