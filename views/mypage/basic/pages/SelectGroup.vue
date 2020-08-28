<template>
    <div class="accounts accounts--result">
        <div class="container">
            <h1 class="text-center my-60">{{ $t('doYouCreateBeats') }}<br/>{{ $t('thenJoin') }}</h1>
            <div class="login accounts__defaultLayout">
                <div class="accounts__switch">
                    <span class="accounts__switch-bg"></span>
                    <label for="monthly" @click="billTerm = 'monthly'">
                        <input type="radio" id="monthly" hidden name="bill" checked/>
                        <span>{{ $t('billMonthly') }}</span>
                    </label>
                    <label for="yearly" @click="billTerm = 'yearly'">
                        <input type="radio" id="yearly" hidden name="bill"/>
                        <span>
                            {{ $t('billYearly') }}
                            <em>{{ disBill }}{{ $t('savepercent') }}</em>
                        </span>
                    </label>
                </div>
            </div>
            <div class="accounts__plan-case">
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
                            <h2><span>{{ $t('currencySymbol') }}</span>{{ $i18n.locale === 'en' ?
                                sellerFreeGroup.mgr_monthly_cost_d : sellerFreeGroup.mgr_monthly_cost_w }}</h2>
                        </th>
                        <th>
                            <p>
                                {{ $t('platinum') }}<br/>
                            </p>
                            <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ?
                                sellerPlatinumGroup.mgr_monthly_cost_d : sellerPlatinumGroup.mgr_monthly_cost_w) :
                                ($i18n.locale === 'en' ? sellerPlatinumGroup.mgr_year_cost_d :
                                sellerPlatinumGroup.mgr_year_cost_w) }}<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em>
                            </h2>
                        </th>
                        <th>
                            <p>
                                {{ $t('master') }}<br/>
                            </p>
                            <h2><span>{{ $t('currencySymbol') }}</span>{{ billTerm === 'monthly' ? ($i18n.locale === 'en' ?
                                sellerMasterGroup.mgr_monthly_cost_d : sellerMasterGroup.mgr_monthly_cost_w) : ($i18n.locale
                                === 'en' ? sellerMasterGroup.mgr_year_cost_d : sellerMasterGroup.mgr_year_cost_w) }}<em>/{{
                                    billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
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
                            <button class="btn btn-primary" @click="doNext(sellerFreeGroup)">{{ $t('getStarted') }}</button>
                        </td>
                        <td>
                            <button class="btn btn-primary" @click="doNext(sellerPlatinumGroup)">{{ $t('getStarted')
                                }}</button>
                        </td>
                        <td>
                            <button class="btn btn-primary" @click="doNext(sellerMasterGroup)">{{ $t('getStarted')
                                }}</button>
                        </td>
                    </tr>
                    <!--                    </tfoot>-->
                    </tbody>
                </table>
            </div>
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
                billTerm: 'monthly',
                listPlan: null,
                planName: 'free',
                disBill: 0,
                buyerGroup: {},
                sellerFreeGroup: {},
                sellerPlatinumGroup: {},
                sellerMasterGroup: {},
                selectedGroup: {}
            }
        },
        created() {
            this.currentUserType = this.userType[1];
            this.fetchData();
        },
        mounted() {
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
        },
        watch: {
            currentUserType(n) {
                this.plan = 'free';
                if (n === 'seller') {
                    this.billTerm = 'monthly';
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
        },

    }


</script>

<style lang="scss" scoped>
    @mixin textIndet() {
        text-indent: -9999px;
        overflow: hidden;
    }

    @mixin flex($direction: row, $align: center, $justify: flex-start) {
        display: flex;
        flex-wrap: wrap;
        flex-direction: $direction;
        @if ($direction == row) {
            align-items: $align;
            justify-content: $justify;
        }
        @if ($direction == column) {
            align-items: $justify;
            justify-content: $align;
        }
    }

    .my-60 {
        margin-top: 60px;
        margin-bottom: 60px;
    }

    .accounts {
        padding-top: 140px;
        padding-bottom: 140px;

        &.accounts--result {
            background: url('/assets/images/signup01-bg.png') no-repeat center -50px;
            background-size: 100% auto;

            .accounts__result-title {
                font-size: 32px;
                text-align: center;
                font-weight: 600;
                margin-bottom: 200px;
            }
        }

        .accounts__defaultLayout {
            width: 460px;
            margin: 0 auto;
        }

        form,
        label {
            width: 100%;
        }

        .accounts__plan-case {
            width: 900px;
            margin: 65px auto 0;

            th,
            td {
                border-right: 1px solid #1a1a1a;
                text-align: center;

                &:last-child {
                    border-right: 0;
                }
            }

            td {
                border-bottom: 1px solid #1a1a1a;
                height: 60px;
                font-size: 14px;

                &:first-child {
                    text-align: left;
                    padding: 0 15px;
                }

                span {
                    @include textIndet;
                    width: 21px;
                    height: 18px;
                    display: inline-block;

                    &.check {
                        background: url('/assets/images/icon/accounts-check.png') no-repeat center;
                    }

                    &.un-check {
                        background: url('/assets/images/icon/accounts-x.png') no-repeat center;
                    }
                }
            }

            th {
                border-bottom: 2px solid #808080;
                padding: 20px;

                p {
                    color: #fff;
                    font-size: 16px;
                    line-height: 20px;
                    font-weight: 600;

                    span {
                        font-weight: 300;
                        font-size: 12px;
                    }
                }

                h2 {
                    margin: 15px 0;
                    font-size: 30px;
                    color: #ffda2a;
                    font-weight: 600;
                    line-height: 1em;

                    span {
                        font-size: 24px;
                    }

                    em {
                        font-size: 12px;
                        font-style: normal;
                    }
                }
            }

            tr:last-child td {
                border-bottom: none;
            }

            tfoot td {
                padding: 20px 0;
                border-top: 1px solid #808080;
            }
        }

        .accounts__switch {
            padding: 5px;
            background: #232325;
            border-radius: 30px;
            position: relative;

            .accounts__switch-bg {
                position: absolute;
                display: block;
                width: 225px;
                height: 50px;
                line-height: 50px;
                background: #ffda2a;
                border-radius: 25px;
                left: 5px;
                top: 5px;
                z-index: 1;
                transition: all 0.5s;

                &.right {
                    left: 230px;
                }
            }

            @include flex;

            label {
                position: relative;
                z-index: 2;
                flex: 1;
                height: 50px;
                width: 50%;
                text-align: center;
                cursor: pointer;
                margin-bottom: 0;

                span {
                    position: absolute;
                    width: 100%;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 0;
                    color: #7f7f7f;
                    font-weight: 600;
                    transition: all 0.5s;

                    em {
                        display: block;
                        font-size: 14px;
                        color: #7f7f7f;
                        font-weight: 300;
                        font-style: normal;
                    }
                }

                input:checked + span {
                    color: #000;

                    em {
                        color: #000;
                    }
                }
            }
        }
    }

</style>
