<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>
                <p class="yellow">Beat Someone과 함께하세요!</p>
                비트를 좋아하는 사람들과 관계를 형성해보세요. <br /> 직접 만든 비트를 올리고 수익을 창출해보세요. <br /> 이 모든 건 아주 간단한 방법으로 시작됩니다.
            </h1>
        </div>

        <div class="login accounts__defaultLayout">
            <form action="">

                <div class="accounts__switch" v-if="currentUserType === 'musician'">
                    <span class="accounts__switch-bg"></span>
                    <label for="monthly" @click="billTerm = 'monthly'">
                        <input type="radio" id="monthly" hidden name="bill" checked />
                        <span>매월 청구</span>
                    </label>
                    <label for="yearly" @click="billTerm = 'yearly'">
                        <input type="radio" id="yearly" hidden name="bill" />
                        <span>
                            매년 청구
                            <em>(20% 이상 절약)</em>
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
                MARKETPLACE PLAN
            </button>
            <button data-target="plan-pro" @click="plan = 'pro'" :class="{'active':this.plan === 'pro'}" v-if="currentUserType === 'musician'">
                PRO PAGE PLAN
            </button>
        </div>

        <div class="accounts__plan-case" id="plan-free"  v-if="currentUserType === 'user' && plan === 'free'">
            <div class="accounts__plan-header">
                <div class="left">
                    <p>
                        {{ $t('free') }}
                    </p>
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(1)">업그레이드</a>
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
                    <td>{{ $t('unlimited1') }}</td>
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
                        <a href="#" class="btn btn--start" @click="doNext(1)">업그레이드</a>
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
                    <h2><span>$</span> 0.00<em>/mo</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(1)">업그레이드</a>
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
                        <a href="#" class="btn btn--start" @click="doNext(1)">업그레이드</a>
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
                        <!-- {{ $t('platinum') }}<br /> -->
                        MARKETPLACE PLAN<br />
                    </p>
                    <h2><span>$</span>9.99<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(2)">업그레이드</a>
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
                    <td>{{ $t('unlimited1') }}</td>
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
                        <a href="#" class="btn btn--start" @click="doNext(2)">업그레이드</a>
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
                        <!-- {{ $t('master') }}<br /> -->
                        PRO PAGE PLAN
                    </p>
                    <h2><span>$</span>19.99<em>/{{ billTerm === 'monthly' ? 'mo' : 'yr'}}</em></h2>
                </div>
                <div class="right">
                    <a href="#" class="btn btn--start" @click="doNext(3)">업그레이드</a>
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
                    <td>{{ $t('unlimited1') }}</td>
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
                        {{ $t('unlimited1') }}
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
                        <a href="#" class="btn btn--start" @click="doNext(3)">업그레이드</a>
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
                planName: 'free',
                listPlan : null,
                disBill: 0,
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

<style lang="css" scoped>
    .accounts .accounts__title h1 {
        font-size: 18px;
        line-height: 28px;
    }
    .accounts .accounts__title p {
        margin-bottom: 20px;
    }
    .accounts .accounts__switch .accounts__switch-bg.right {
        left: 162.5px;
    }
    .accounts .accounts__switch .accounts__switch-bg {
        width: 162.5px;
    }
</style>
