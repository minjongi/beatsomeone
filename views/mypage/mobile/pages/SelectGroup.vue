<template>
    <div class="plan">
        <div class="title text-center">
            <h1>{{ $t('doYouCreateBeats') }}<br />{{ $t('thenJoin') }}</h1>
        </div>
        <div class="switch-wrapper">
            <div class="switch">
                <span class="switch-bg" :class="billTerm === 'monthly' ? '' : 'right'"></span>
                <label>
                    <input type="radio" hidden v-model="billTerm" value="monthly" />
                    <span>{{ $t('billMonthly') }}</span>
                </label>
                <label>
                    <input type="radio" hidden v-model="billTerm" value="year" />
                    <span>{{ $t('billYearly') }}<br /><small>{{ disBill }}{{ $t('savepercent') }}</small></span>
                </label>
            </div>
        </div>

        <ul class="nav nav-pills justify-content-center my-4">
            <li class="nav-item">
                <a class="nav-link" :class="planName === 'free' ? 'active' : ''" data-toggle="pill" data-target="#free-plan" @click="setPlan('free')" href="javascript:;">{{ $t('free') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="planName === 'platinum' ? 'active' : ''" data-toggle="pill" data-target="#monthly-plan" @click="setPlan('platinum')" href="javascript:;">{{ $t('platinum') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="planName === 'master' ? 'active' : ''" data-toggle="pill" data-target="#year-plan" @click="setPlan('master')" href="javascript:;">{{ $t('master') }}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" :class="planName === 'free' ? 'show active' : ''" id="free-plan">
                <div class="row align-items-center mb-3">
                    <div class="col-6">
                        <h4 class="mb-0">
                            {{ $t('free') }}<br/>
                        </h4>
                        <h3 class="text-warning"><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ?
                            sellerFreeGroup.mgr_monthly_cost_d : sellerFreeGroup.mgr_monthly_cost_w) : ($i18n.locale
                            === 'en' ? sellerFreeGroup.mgr_year_cost_d : sellerFreeGroup.mgr_year_cost_w) }}<em>/{{
                            billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h3>
                    </div>
                    <div class="col-6 text-right">
                        <button @click="doNext(sellerFreeGroup)" class="btn btn-primary">{{ $t('getStarted') }}</button>
                    </div>
                </div>
                <table class="w-100">
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
                            <span class="fa fa-check text-success"></span>
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
                            <span class="fa fa-check text-success"></span>
                        </td>
                    </tr>
                    <!--                <tfoot>-->
                    <tr>
                        <td colspan="2">
                            <button @click="doNext(sellerFreeGroup)" class="btn btn-primary btn-block mt-2">{{ $t('getStarted') }}</button>
                        </td>
                    </tr>
                    <!--                </tfoot>-->
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" :class="planName === 'platinum' ? 'show active' : ''" id="monthly-plan">
                <div class="row align-items-center mb-3">
                    <div class="col-6">
                        <h4 class="mb-0">
                            {{ $t('platinum') }}<br/>
                        </h4>
                        <h3 class="text-warning"><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ?
                            sellerPlatinumGroup.mgr_monthly_cost_d : sellerPlatinumGroup.mgr_monthly_cost_w) : ($i18n.locale
                            === 'en' ? sellerPlatinumGroup.mgr_year_cost_d : sellerPlatinumGroup.mgr_year_cost_w) }}<em>/{{
                            billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h3>
                    </div>
                    <div class="col-6 text-right">
                        <button @click="doNext(sellerPlatinumGroup)" class="btn btn-primary">{{ $t('getStarted') }}</button>
                    </div>
                </div>
                <table class="w-100">
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
                            <span class="fa fa-check text-success"></span>
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
                            <span class="fa fa-check text-success"></span>
                        </td>
                    </tr>
                    <!--                <tfoot>-->
                    <tr>
                        <td colspan="2">
                            <button @click="doNext(sellerPlatinumGroup)" class="btn btn-primary btn-block mt-2">{{ $t('getStarted') }}</button>
                        </td>
                    </tr>
                    <!--                </tfoot>-->
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" :class="planName === 'master' ? 'show active' : ''" id="year-plan">
                <div class="row align-items-center mb-3">
                    <div class="col-6">
                        <h4 class="mb-0">
                            {{ $t('master') }}<br/>
                        </h4>
                        <h3 class="text-warning"><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ?
                            sellerMasterGroup.mgr_monthly_cost_d : sellerMasterGroup.mgr_monthly_cost_w) : ($i18n.locale
                            === 'en' ? sellerMasterGroup.mgr_year_cost_d : sellerMasterGroup.mgr_year_cost_w) }}<em>/{{
                            billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h3>
                    </div>
                    <div class="col-6 text-right">
                        <button @click="doNext(sellerMasterGroup)" class="btn btn-primary">{{ $t('getStarted') }}</button>
                    </div>
                </div>
                <table class="w-100">
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
                            <span class="fa fa-check text-success"></span>
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
                            {{ $t('unlimited') }}
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $t('salesStatistics') }}</td>
                        <td>
                            <span class="fa fa-check text-success"></span>
                        </td>
                    </tr>
                    <!--                <tfoot>-->
                    <tr>
                        <td colspan="2">
                            <button @click="doNext(sellerMasterGroup)" class="btn btn-primary btn-block mt-2">{{ $t('getStarted') }}</button>
                        </td>
                    </tr>
                    <!--                </tfoot>-->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "SelectGroup",
        data: function () {
            return {
                disBill: 0,
                billTerm : 'monthly',
                planName: 'free',
                listPlan : null,
                buyerGroup: {},
                sellerFreeGroup: {},
                sellerPlatinumGroup: {},
                sellerMasterGroup: {},
                selectedGroup: {}
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            setPlan(plan) {
                this.planName = plan;
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
                            }
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            doNext(group) {
                if (group.mgr_title === 'seller_free') {
                    let formData = new FormData();
                    formData.append('mgr_id', group.mgr_id);
                    axios.post('/mypage/post_upgrade', formData)
                        .then(res => res.data)
                        .then(data => {
                            alert(data.message);
                            window.location.href = '/mypage';
                        })
                        .catch(error => {
                            console.error(error);
                        })
                } else {
                    this.selectedGroup = group;
                    this.$set(this.selectedGroup, 'billTerm', this.billTerm);
                    localStorage.setItem('bs_group_info', JSON.stringify(this.selectedGroup));
                    this.$router.push({path: '/pay'});
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .plan {
        background: url("/assets_m/images/signup01-nbg.png");
        background-size: 100% auto;

        .title {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .switch-wrapper {
            padding-left: 20px;
            padding-right: 20px;
        }

        .switch {
            background-color: #232325;
            border-radius: 30px;
            height: 60px;
            display: flex;
            align-items: center;
            position: relative;

            label {
                width: 50%;
                text-align: center;
                margin-bottom: 0;
                display: block;
                flex: 0 0 50%;
                z-index: 2;

                span {
                    color: #7f7f7f;
                    font-weight: 600;
                }

                input:checked+span {
                    color: #000;
                }
            }

            .switch-bg {
                position: absolute;
                width: calc(50% - 10px);
                margin: 5px;
                height: 48px;
                background-color: #ffda2a;
                border-radius: 30px;
                left: 0;
                right: unset;
                transition: all .5s;

                &.right {
                    left: unset;
                    right: 0;
                }
            }
        }

        .nav {
            background: #1c1d23;
            border: 1px solid #2b2c30;
        }

        .nav-pills {
            .nav-link {
                border-radius: 0;
                height: 40px;
                color: #9fa1a9;

                &.active {
                    color: white;
                    background-color: unset;
                    border-bottom: solid 4px white;
                }
            }
        }

        .tab-content {
            .tab-pane {
                padding: 20px;

                table {
                    border-top: 2px solid grey;

                    tr:last-child td {
                        border-bottom: none;
                        border-right: none;
                    }

                    td {
                        border-bottom: 1px solid #1a1a1a;
                        height: 40px;
                        text-align: center;

                        &:first-child {
                            text-align: left;
                            padding: 0 15px;
                            border-right: 1px solid #1a1a1a;
                        }
                    }
                }
            }
        }
    }
</style>