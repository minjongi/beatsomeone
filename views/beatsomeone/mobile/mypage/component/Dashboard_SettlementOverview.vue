<template>

    <div class="row">
        <div class="title-content">
            <h4 class="title">{{$t('settlementOverview')}}</h4>
            <!-- <p>
                ※· {{$t('guideAmountSalesSettlementsMsg')}}<br/>
                ※· {{$t('exactSalesSettlementAmountMsg')}}
            </p> -->
        </div>

        <div>
            <div class="splitboard">
                <div class="blue">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_sale_funds.toFixed(0) : data.total_sale_funds_d.toFixed(2) }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_sale_funds - data.total_last_sale_funds).toFixed(0) : (data.total_sale_funds_d - data.total_last_sale_funds_d).toFixed(2) }}{{ (data.total_sale_funds_d - data.total_last_sale_funds_d) > 0 ? '▲' : '▼' }})</div>
                    <span>
                    {{$t('estimatedSalesAmount')}}
                    <button class="button active">
                        <img src="/assets/images/icon/tip.png"/>
                    </button>
                    <div class="tooltip" style="display:none;">
                        <p>Displays the estimated amount of sales of the bit sold so far, starting from the current month. The exact sales amount can be confirmed on the last day. </p>
                    </div>
                </span>
                </div>
                <div class="blue">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_settle_funds.toFixed(0) : data.total_settle_funds_d.toFixed(2) }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_settle_funds - data.total_last_settle_funds).toFixed(0) : (data.total_settle_funds_d - data.total_last_settle_funds_d).toFixed(2) }}{{ (data.total_settle_funds - data.total_last_settle_funds) > 0 ? '▲' : '▼' }})</div>
                    <span>
                    {{$t('estimatedSettlementAmount')}}
                    <button class="button">
                        <img src="/assets/images/icon/tip.png"/>
                    </button>
                    <span class="tooltip" style="display:none;">
                        <p> Displays the estimated settlement amount, deducted from the fee, based on the amount sold so far from the current month. The exact settlement amount can be checked between 20-25 days of the following month. </p>
                    </span>
                </span>
                </div>
                <div class="red">
                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? data.total_last_settle_funds.toFixed(0) : data.total_last_settle_funds_d.toFixed(2) }}
                    <div class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (data.total_last_settle_funds - data.total_lastlast_settle_funds).toFixed(0) : (data.total_lastlast_settle_funds - data.total_lastlast_settle_funds_d).toFixed(2) }}{{ (data.total_lastlast_settle_funds - data.total_lastlast_settle_funds_d) > 0 ? '▲' : '▼' }})</div>
                    <span>
                    {{$t('lastMonthSettlementAmount')}}
                    <button class="button">
                        <img src="/assets/images/icon/tip.png"/>
                    </button>
                    <span class="tooltip" style="display:none;">
                        <p> Displays the amount settled last month. </p>
                    </span>
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
