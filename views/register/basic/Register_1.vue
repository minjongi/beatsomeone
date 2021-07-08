<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ $t('doYouCreateBeats') }}<br/>{{ $t('thenJoin') }}</h1>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__case">
                <label for="listen" class="case case--listen">
                    <input type="radio" name="case" id="listen" hidden :checked="currentUserType == 'buyer'"/>
                    <div @click="setCurrentUserType('buyer')">
                        <span class="icon"></span>
                        <p>{{ $t ('listenAndBuyMusic1') }}<br/>{{ $t ('listenAndBuyMusic2') }}</p>
                    </div>
                </label>

                <label for="monetize" class="case case--monetize">
                    <input type="radio" name="case" id="monetize" hidden :checked="currentUserType == 'seller'"/>
                    <div @click="setCurrentUserType('seller')">
                        <span class="icon"></span>
                        <p>{{ $t('monetizeMyMusic1') }}<br/>{{ $t('monetizeMyMusic2') }}</p>
                    </div>
                </label>
            </div>

            <div class="accounts__switch" v-if="isMusician">
                <span class="accounts__switch-bg" :class="billTerm == 'yearly' ? 'right' : ''"></span>
                <label for="monthly" @click="setBillTerm('monthly')">
                    <input type="radio" id="monthly" hidden name="bill" :checked="billTerm == 'monthly'"/>
                    <span>{{ $t('billMonthly') }}</span>
                </label>
                <label for="yearly" @click="setBillTerm('yearly')">
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
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ buyerGroup[costKey('mgr_monthly_cost')] }}</h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('lang160') }}
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ subscribedCommon[costKey('mgr_monthly_cost')] }}<em>{{ $t('monthly') }}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCommon)">{{ $t('getStarted') }}</a>
                    </th>
                    <th v-if="false">
                        <p>
                            {{ $t('lang129') }}
                        </p>
                       <h2><span>{{ $t('currencySymbol') }}</span>{{ subscribedCreater[costKey('mgr_monthly_cost')] }}<em>{{ $t('monthly') }}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCreater)">{{ $t('getStarted') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $t('lang161') }}</td>
                    <td>0{{ $t('lang162') }}</td>
                    <td>10{{ $t('lang162') }}</td>
                    <td v-if="false">10{{ $t('lang162') }}</td>
                </tr>
                <tr>
                    <td>{{ $t('freeBeatDownload') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="false">
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('storePurchaseMusicFiles') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="false">
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('purchaseSoundSourceLicenseStorage') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="false">
                        <span class="check">O</span>
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('previewStreamingService') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                     <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="false">
                        <span class="check">O</span>
                    </td>
                </tr>
                <!--                    <tfoot>-->
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('getStarted') }}</a>
                    </td>
                    <td v-if="false">
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
                    <col width="200" v-if="false"/>
                    <col width="200"/>
                </colgroup>
                <thead>
                <tr>
                    <th></th>
                    <th>
                        <p>
                            {{ $t('free') }}
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ sellerFreeGroup[costKey('mgr_monthly_cost')] }}</h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerFreeGroup)">{{ $t('getStarted') }}</a>
                    </th>
                    <th v-if="false">
                        <p>
                            {{ $t('platinum') }}<br/>
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? sellerPlatinumGroup[costKey('mgr_monthly_cost')] : sellerPlatinumGroup[costKey('mgr_year_cost')] }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('master') }}<br/>
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? sellerMasterGroup[costKey('mgr_monthly_cost')] : sellerMasterGroup[costKey('mgr_year_cost')] }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $t('uploadTracksLimit') }}</td>
                    <td>5 → {{ $t('lang155') }}(event)</td>
                    <td v-if="false">{{ $t('lang155') }}</td>
                    <td>{{ $t('lang155') }}</td>
                </tr>
                <tr>
                    <td>{{ $t('uploadTrackStems') }}</td>
                    <td>
                        <span class="check">O</span>
                    </td>
                    <td v-if="false">
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
                    <td v-if="false">
                        {{ sellerPlatinumGroup.mgr_commission }}%
                    </td>
                    <td>
                        {{ sellerMasterGroup.mgr_commission }}%<br>({{ $t('revenueToSeller100') }})
                    </td>
                </tr>
                <tr>
                    <td>{{ $t('personalChatFunction') }}</td>
                    <td>
                        10<br>(1{{ $t('month') }})
                    </td>
                    <td v-if="false">
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
                    <td v-if="false">
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
                    <td v-if="false">
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
            const urlParams = new URLSearchParams(window.location.search)
            const type = urlParams.get('t')

            this.billTerm = localStorage.getItem("bill_term") || this.billTerm
            if (type === 'sub') {
              this.currentUserType = 'buyer'
              this.plan = 'subscribe_common'
            } else {
              this.currentUserType = localStorage.getItem("UserOffer") || this.currentUserType
              this.plan = localStorage.getItem("plan") || this.plan
            }
            this.fetchData();
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
            // localStorage.clear();
        },
        watch: {
            currentUserType(n) {
                console.log('this si currentUserType_______', n);
                this.plan = 'free';
                if (n === 'seller') {
                    // this.billTerm = 'monthly'
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
            costKey(key) {
              return key + '_' + this.currencyCode()
            },
            currencyCode() {
              switch (this.$i18n.locale) {
                case 'ko':
                  return 'w'
                case 'jp':
                  return 'jpy'
              }
              return 'd'
            },
            setBillTerm(billTerm) {
              localStorage.setItem('bill_term', billTerm)
              this.billTerm = billTerm
            },
            setCurrentUserType(type) {
              localStorage.setItem('UserOffer', type)
              this.currentUserType = type
            },
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
