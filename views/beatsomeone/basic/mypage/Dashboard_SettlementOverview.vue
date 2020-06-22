<template>
    <div class="title-content">
        <div class="title">
            <div>Settlement Overview</div>
        </div>
        <p>
            ※· We will guide the amount of sales and settlements based on the current month / day.<br/>
            ※· Exact sales / settlement amount can be checked on the basis of 20-25 days of the following month.
        </p>
        <div>
            <div class="splitboard" v-if="data">
                <div class="blue">
                    ₩ {{ data.EstimatedSales.toLocaleString() }}
                    <div class="change">(Change {{ data.EstimatedSales_C.toLocaleString() }}{{ data.EstimatedSales_C > 0 ? '▲' : '▼' }})</div>
                    <span>Estimated sales amount
                        <button class="button">
                            <img src="/assets/images/icon/tip.png"/>
                            <span data-v-27fa6da0="" class="tooltip">
                                <p>
                                 Displays the estimated amount of sales of the bit sold so far, starting from the current month. The exact sales amount can be confirmed on the last day.
                                 </p>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="blue">
                    ₩ {{ data.EstimatedSettlement.toLocaleString() }}
                    <div class="change">(Change {{ data.EstimatedSettlement_C.toLocaleString() }}{{ data.EstimatedSettlement_C > 0 ? '▲' : '▼' }})</div>
                    <span>Estimated settlement amount
                        <button class="button">
                            <img src="/assets/images/icon/tip.png"/>
                            <span data-v-27fa6da0="" class="tooltip">
                                <p>
                                 Displays the estimated settlement amount, deducted from the fee, based on the amount sold so far from the current month. The exact settlement amount can be checked between 20-25 days of the following month.
                                 </p>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="red">
                    ₩ {{ data.LastMonthSettlement.toLocaleString() }}
                    <div class="change">(Change {{ data.LastMonthSettlement_C.toLocaleString() }}{{ data.LastMonthSettlement_C > 0 ? '▲' : '▼' }})</div>
                    <span>Last month settlement amount
                        <button class="button">
                            <img src="/assets/images/icon/tip.png"/>
                            <span data-v-27fa6da0="" class="tooltip">
                                <p>
                                 Displays the amount settled last month.
                                 </p>
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
