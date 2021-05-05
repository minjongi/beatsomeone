<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ pageTitle }}</h1>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__switch" v-if="isMusician">
                <span class="accounts__switch-bg right"></span>
                <label for="monthly" @click="selectBillTerm('monthly')">
                    <input type="radio" id="monthly" hidden name="bill"/>
                    <span>{{ $t('billMonthly') }}</span>
                </label>
                <label for="yearly" @click="selectBillTerm('yearly')">
                    <input type="radio" id="yearly" hidden name="bill" checked/>
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
                  <col width="195" v-if="false"/>
                  <col width="210"/>
                  <col width="195" v-if="false"/>
                </colgroup>
                <thead>
                <tr>
                  <th></th>
                  <th v-if="false">
                    <p>
                      {{ $t('free') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'ko' ? buyerGroup.mgr_monthly_cost_w : buyerGroup.mgr_monthly_cost_d }}</h2>
                    <a href="javascript:;" class="btn btn--start" style="background-color: #999494;">{{ $t('lang159') }}</a>
                  </th>
                  <th>
                    <p>
                      {{ $t('lang160') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'ko' ? subscribedCommon.mgr_monthly_cost_w : subscribedCommon.mgr_monthly_cost_d }}<em>{{ $t('monthly') }}</em></h2>
                    <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCommon)" v-if="this.member_group_name !== 'subscribe_common'">{{ $t('getStarted') }}</a>
                    <a href="javascript:;" class="btn btn--start" style="background-color: #999494;" v-else>{{ $t('lang159') }}</a>
                  </th>
                  <th v-if="false">
                    <p>
                      {{ $t('lang129') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'ko' ? subscribedCreater.mgr_monthly_cost_w : subscribedCreater.mgr_monthly_cost_d }}<em>{{ $t('monthly') }}</em></h2>
                    <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCreater)">{{ $t('getStarted') }}</a>
                  </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>{{ $t('lang161') }}</td>
                  <td v-if="false">0{{ $t('lang162') }}</td>
                  <td>10{{ $t('lang162') }}</td>
                  <td v-if="false">10{{ $t('lang162') }}</td>
                </tr>
                <tr>
                  <td>{{ $t('freeBeatDownload') }}</td>
                  <td v-if="false">
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
                  <td v-if="false">
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
                  <td v-if="false">
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
                  <td v-if="false">
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
                  <td v-if="false">
                    <a href="javascript:;" class="btn btn--start" style="background-color: #999494;">{{ $t('lang159') }}</a>
                  </td>
                  <td>
                    <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCommon)" v-if="this.member_group_name !== 'subscribe_common'">{{ $t('getStarted') }}</a>
                    <a href="javascript:;" class="btn btn--start" style="background-color: #999494;" v-else>{{ $t('lang159') }}</a>
                  </td>
                  <td v-if="false">
                    <a href="javascript:;" class="btn btn--start" @click="doNext(subscribedCreater)">{{ $t('getStarted') }}</a>
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
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'ko' ? sellerFreeGroup.mgr_monthly_cost_w : sellerFreeGroup.mgr_monthly_cost_d }}</h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerFreeGroup)">{{ $t('upgrade') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('platinum') }}<br/>
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'ko' ? sellerPlatinumGroup.mgr_monthly_cost_w : sellerPlatinumGroup.mgr_monthly_cost_d) :
                            ($i18n.locale === 'ko' ? sellerPlatinumGroup.mgr_year_cost_w : sellerPlatinumGroup.mgr_year_cost_d) }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('upgrade') }}</a>
                    </th>
                    <th>
                        <p>
                            {{ $t('master') }}<br/>
                        </p>
                        <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'ko' ? sellerMasterGroup.mgr_monthly_cost_w : sellerMasterGroup.mgr_monthly_cost_d) : ($i18n.locale === 'ko' ? sellerMasterGroup.mgr_year_cost_w : sellerMasterGroup.mgr_year_cost_d) }}<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('upgrade') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>{{ $t('uploadTracksLimit') }}</td>
                  <td>5 → {{ $t('lang155') }}(event)</td>
                  <td>{{ $t('lang155') }}</td>
                  <td>{{ $t('lang155') }}</td>
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
                <tr>
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
                        <a href="javascript:;" class="btn btn--start" @click="doNext(buyerGroup)">{{ $t('upgrade') }}</a>
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('upgrade') }}</a>
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('upgrade') }}</a>
                    </td>
                </tr>
                <!--                    </tfoot>-->
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        name: "SelectGroup",
        data: function () {
            return {
                userType: ['buyer', 'seller'],
                currentUserType: null,
                billTerm: 'yearly',
                listPlan: null,
                planName: 'free',
                disBill: 10,
                buyerGroup: {},
                sellerFreeGroup: {},
                sellerPlatinumGroup: {},
                sellerMasterGroup: {},
                selectedGroup: {},
                subscribedCommon: {},
                subscribedCreater: {},
                member_group_name: ''
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
            pageTitle() {
              return this.currentUserType === 'buyer' ? this.$t('lang158') : this.$t('lang157')
            }
        },
        created() {
            const urlParams = new URLSearchParams(window.location.search)
            const type = urlParams.get('type')

            if (type === 'sub') {
              this.currentUserType = this.userType[0]
              this.billTerm = 'monthly'
            } else {
              this.currentUserType = this.userType[1]
            }

            window.billTerm = this.billTerm
            this.member_group_name = window.member_group_name
            this.fetchData()
        },
        watch: {
            currentUserType(n) {
                this.plan = 'free';
                if (n === 'seller') {
                    // this.billTerm = 'monthly';
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
                if (group.mgr_title === 'seller_free' || group.mgr_title === 'buyer') {
                    let formData = new FormData();
                    formData.append('mgr_id', group.mgr_id);
                    axios.post('/register/ajax_purchase', formData)
                        .then(res => res.data)
                        .then(data => {
                            alert(data.message);
                            window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage');
                        })
                        .catch(error => {
                            console.error(error);
                        })
                } else {
                    window.location.href = this.helper.langUrl(this.$i18n.locale, `/register/purchase?mgr_id=${group.mgr_id}&billTerm=${this.billTerm}`);
                }
            },
            fetchData() {
              axios.get('/membergroup')
                  .then(res => res.data)
                  .then(data => {
                    let list = Object.values(data);
                    list.forEach(item => {
                      if (item.mgr_title === 'buyer') {
                        this.buyerGroup = item;
                      } else if (item.mgr_title === 'seller_free') {
                        this.sellerFreeGroup = item;
                      } else if (item.mgr_title === 'seller_platinum') {
                        this.sellerPlatinumGroup = item;
                      } else if (item.mgr_title === 'seller_master') {
                        this.sellerMasterGroup = item;
                      } else if (item.mgr_title === 'subscribe_common') {
                        this.subscribedCommon = item;
                      } else if (item.mgr_title === 'subscribe_creater') {
                        this.subscribedCreater = item;
                      }
                    });
                  })
                  .catch(error => {
                    console.error(error);
                  })
            },
            selectBillTerm(term) {
                window.billTerm = term;
                this.billTerm = term;
            }
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
