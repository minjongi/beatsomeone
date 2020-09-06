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
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'en' ? Number(data.total_sale_funds).toLocaleString() : Number(data.total_sale_funds_d).toLocaleString() }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? Number(data.total_sale_funds - data.total_last_sale_funds).toLocaleString() : Number(data.total_sale_funds_d - data.total_last_sale_funds_d).toLocaleString() }}{{ (data.total_sale_funds_d - data.total_last_sale_funds_d) > 0 ? '▲' : '▼' }})</div>
                    <span>{{$t('estimatedSalesAmount')}}
                        <button class="ml-2 button" data-toggle="tooltip" data-placement="bottom" title="Displays the estimated amount of sales of the bit sold so far, starting from the current month. The exact sales amount can be confirmed on the last day.">
                            <img src="/assets/images/icon/tip.png"/>
                        </button>
                    </span>
                </div>
                <div class="blue">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? Number(data.total_settle_funds).toLocaleString() : Number(data.total_settle_funds_d).toLocaleString() }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_settle_funds - data.total_last_settle_funds) : (data.total_settle_funds_d - data.total_last_settle_funds_d)}}{{ (data.total_settle_funds - data.total_last_settle_funds) > 0 ? '▲' : '▼' }})</div>
                    <span>{{$t('estimatedSettlementAmount')}}
                        <button class="button" data-toggle="tooltip" data-placement="bottom" title="Displays the estimated settlement amount, deducted from the fee, based on the amount sold so far from the current month. The exact settlement amount can be checked between 20-25 days of the following month.">
                            <img src="/assets/images/icon/tip.png"/>
                        </button>
                    </span>
                </div>
                <div class="red">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_last_settle_funds : data.total_last_settle_funds_d }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_last_settle_funds - data.total_lastlast_settle_funds) : (data.total_lastlast_settle_funds - data.total_lastlast_settle_funds_d) }}{{ (data.total_lastlast_settle_funds - data.total_lastlast_settle_funds_d) > 0 ? '▲' : '▼' }})</div>
                    <span>{{$t('lastMonthSettlementAmount')}}
                        <button class="button" data-toggle="tooltip" data-placement="bottom" title="Displays the amount settled last month.">
                            <img src="/assets/images/icon/tip.png"/>
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
