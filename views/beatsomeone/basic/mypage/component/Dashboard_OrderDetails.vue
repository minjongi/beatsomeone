<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('orderDetails')}}</div>
            <button class="btn btn--glass" @click="$router.push('/mybilling')">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div class="splitboard">
            <div class="blue">{{ data.order_buy_count }}<span>{{$t('buy')}}</span></div>
            <div class="red">{{ data.order_cancel_count }}<span>{{$t('cancel1')}}</span></div>
            <div class="green">{{ data.order_refund_count }}<span>{{$t('refund')}}</span></div>
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