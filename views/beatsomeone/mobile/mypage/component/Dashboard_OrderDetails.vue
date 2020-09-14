<template>
    <div class="title-content">
        <h4 class="title">
            {{$t('orderDetails')}}
        </h4>
        <div class="n-flex splitboard">
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
        computed: {
        },
        created() {
        },
        mounted() {
        },
        methods: {
        },
    }
</script>