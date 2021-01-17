<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('settlementOverview')}}</div>
        </div>
        <p>
            ※· {{$t('guideAmountSalesSettlementsMsg')}}<br/>
            ※· {{$t('exactSalesSettlementAmountMsg')}}
        </p>
        <div>
            <div class="splitboard" v-if="data">
                <div class="blue">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_sale_funds.toFixed(0) : data.total_sale_funds_d.toFixed(2) }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_sale_funds - data.total_last_sale_funds).toFixed(0) : (data.total_sale_funds_d - data.total_last_sale_funds_d).toFixed(2) }}{{ (data.total_sale_funds_d - data.total_last_sale_funds_d) > 0 ? '▲' : '▼' }})</div>
                    <span>{{$t('estimatedSalesAmount')}}
                        <button class="button" style="position: relative; cursor: default;">
                            <img src="/assets/images/icon/tip.png"/>
                            <span data-v-27fa6da0="" class="tooltip">
                                <p>{{ $t('lang149') }}</p>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="blue">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_settle_funds.toFixed(0) : data.total_settle_funds_d.toFixed(2) }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_settle_funds - data.total_last_settle_funds).toFixed(0) : (data.total_settle_funds_d - data.total_last_settle_funds_d).toFixed(2) }}{{ (data.total_settle_funds - data.total_last_settle_funds) > 0 ? '▲' : '▼' }})</div>
                    <span>{{$t('estimatedSettlementAmount')}}
                        <button class="button" style="position: relative">
                            <img src="/assets/images/icon/tip.png"/>
                            <span data-v-27fa6da0="" class="tooltip">
                                <p>{{ $t('lang150') }}</p>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="red">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_last_settle_funds.toFixed(0) : data.total_last_settle_funds_d.toFixed(2) }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_last_settle_funds - data.total_lastlast_settle_funds).toFixed(0) : (data.total_lastlast_settle_funds - data.total_lastlast_settle_funds_d).toFixed(2) }}{{ (data.total_lastlast_settle_funds - data.total_lastlast_settle_funds_d) > 0 ? '▲' : '▼' }})</div>
                    <span>{{$t('lastMonthSettlementAmount')}}
                        <button class="button" style="position: relative">
                            <img src="/assets/images/icon/tip.png"/>
                            <span data-v-27fa6da0="" class="tooltip">
                                <p>{{  $t('lang151') }}</p>
                            </span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>

</template>


<script>

    import { EventBus } from '*/src/eventbus';

    export default {
        props: ['data'],
        data: function () {
            return {

            }
        },
        created() {

        },
        mounted() {

        },
        methods: {

        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
