<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>{{ pageTitle }}</h1>
        </div>

        <div class="login accounts__defaultLayout">
            <form action="">
                <div class="accounts__switch" v-if="isMusician">
                    <span class="accounts__switch-bg right"></span>
                    <label for="monthly" @click="billTerm = 'monthly'">
                        <input type="radio" id="monthly" hidden name="bill"/>
                        <span>{{ $t('billMonthly') }}</span>
                    </label>
                    <label for="yearly" @click="billTerm = 'yearly'">
                        <input type="radio" id="yearly" hidden name="bill" checked/>
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
            <button data-target="plan-subscribe_common" @click="plan = 'subscribe_common'" :class="{'active':this.plan === 'subscribe_common'}" v-if="!isMusician"  style="padding: 0 9px !important;">
              {{ $t('lang160') }}
            </button>
            <button data-target="plan-subscribe_creater" @click="plan = 'subscribe_creater'" :class="{'active':this.plan === 'subscribe_creater'}" v-if="false && !isMusician"  style="padding: 0 9px !important;">
              {{ $t('lang129') }}
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free"  v-if="!isMusician && plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>{{ $t('currencySymbol') }}</span> 0 <em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="javascript:;" class="btn btn--start" style="background-color: #999494;">{{ $t('lang159') }}</a>
                </div>
            </div>
            <table>
                <colgroup>
                    <col width="" />
                    <col width="120" />
                </colgroup>
                <tbody>

                <tr>
                  <td>{{ $t('lang161') }}</td>
                  <td>{{ $t('lang155') }}</td>
                </tr>
                <tr>
                  <td>{{ $t('freeBeatDownload') }}</td>
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
                <!--                <tfoot>-->
                <tr>
                    <td colspan="2">
                        <a href="javascript:;" class="btn btn--start" style="background-color: #999494;">{{ $t('lang159') }}</a>
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
                    <a href="javascript:" class="btn btn--start" style="background-color: #999494;">{{ $t('lang159') }}</a>
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
                  <td>5 → {{ $t('lang155') }}(event)</td>
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
                        <a href="javascript:" class="btn btn--start" style="background-color: #999494;">{{ $t('lang159') }}</a>
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
                    <a href="javascript:" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
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
                  <td>{{ $t('lang155') }}</td>
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
                        <a href="javascript:" class="btn btn--start" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted') }}</a>
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
                    <a href="javascript:" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
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
                  <td>{{ $t('lang155') }}</td>
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
                <tr>
                  <td>{{ $t('personalChatFunction') }}</td>
                  <td>
                    {{ $t('lang155') }}
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
                        <a href="javascript:" class="btn btn--start" @click="doNext(sellerMasterGroup)">{{ $t('getStarted') }}</a>
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
                {{ $t('lang160') }}
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

            <tr>
              <td>{{ $t('lang161') }}</td>
              <td>10{{ $t('lang162') }}</td>
            </tr>
            <tr>
              <td>{{ $t('freeBeatDownload') }}</td>
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

            <tr>
              <td>{{ $t('lang161') }}</td>
              <td>10{{ $t('lang162') }}</td>
            </tr>
            <tr>
              <td>{{ $t('freeBeatDownload') }}</td>
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
                currentUserType: null,
                billTerm: 'yearly',
                listPlan: null,
                planName: 'master',
                plan: 'pro',
                disBill: 10,
                buyerGroup: {},
                sellerFreeGroup: {},
                sellerPlatinumGroup: {},
                sellerMasterGroup: {},
                selectedGroup: {},
                subscribedCommon: {},
                subscribedCreater: {},
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
              this.plan = 'subscribe_creater'
              this.planName = 'master'
            } else {
              this.currentUserType = this.userType[1]
            }

            this.fetchData();
        },
        mounted() {
            localStorage.clear();
        },
        watch: {
            currentUserType(n) {
                // this.plan = 'free';
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
                    return
                }
                window.location.href = this.helper.langUrl(this.$i18n.locale, `/register/purchase?mgr_id=${group.mgr_id}&billTerm=${this.billTerm}`);
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
