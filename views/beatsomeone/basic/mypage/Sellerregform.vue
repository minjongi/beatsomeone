<template>
    <div class="container accounts accounts--start">
        <div class="accounts__title">
            <h1>
                <p class="yellow">Beat Someone과 함께하세요!</p>
                비트를 좋아하는 사람들과 관계를 형성해보세요. <br /> 직접 만든 비트를 올리고 수익을 창출해보세요. <br /> 이 모든 건 아주 간단한 방법으로 시작됩니다.
            </h1>
        </div>
        <div class="login accounts__defaultLayout">

                <div class="accounts__switch" v-if="isMusician">
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
                    <td>{{ $t('unlimited') }}</td>
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
                        <p style="min-height: 40px;">
                            <!-- <br /> -->
                            {{ $t('free') }}
                        </p>
                        <h2><span>$</span>0.00</h2>
                        <a href="#" class="btn btn--start" @click="doNext('free')">업그레이드</a>
                    </th>
                    <th>
                        <p> MARKETPLACE PLAN<br /> </p>
                        <h2><span>$</span>9.99<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="#" class="btn btn--start" @click="doNext('Marketplace')">업그레이드</a>
                    </th>
                    <th>
                        <p> PRO PAGE<br />PLAN<br /> </p>
                        <h2><span>$</span>19.99<em>/{{ billTerm === 'monthly' ? $t('lang46') : $t('lang47')}}</em></h2>
                        <a href="#" class="btn btn--start" @click="doNext('Pro Page')">업그레이드</a>
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
                        30%
                    </td>
                    <td>
                        10%
                    </td>
                    <td>
                        O%<br>{{ $t('revenueToSeller') }}
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
                        <a href="#" class="btn btn--start" @click="doNext('free')">업그레이드</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('Marketplace')">업그레이드</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn--start" @click="doNext('Pro Page')">업그레이드</a>
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
            doNext(plan) {
                var islogin = this.$parent.isLogin;
                if(plan=="Marketplace"){
                    this.planName = this.$t('Platinum');
                }else if(plan=="Pro Page"){
                    this.planName = this.$t('Master');
                }
                EventBus.$emit('submit_join_form',{ userType: this.currentUserType, plan: plan, planName: this.planName, billTerm: this.billTerm  });

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

<style lang="css" scoped>
.accounts .accounts__title p {
    margin-bottom: 30px;
}
.accounts .accounts__title h1 {
    line-height: 40px;
    font-size: 30px;
}
.wrapper {
    background: url("/assets/images/signup01-bg.png") no-repeat center -50px;
    background-size: 100% auto;
}
</style>
