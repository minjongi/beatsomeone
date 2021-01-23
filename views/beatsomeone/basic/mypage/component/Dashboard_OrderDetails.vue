<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('orderDetails')}}</div>
            <button class="btn btn--glass" @click="goMyBilling()">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div class="splitboard">
            <div class="green">{{ data.order_deposit_count }}<span>{{$t('waitingDeposit')}}</span></div>
            <div class="blue">{{ data.order_order_count }}<span>{{$t('buy')}}</span></div>
            <div class="red">{{ data.order_cancel_count }}<span>{{$t('cancel')}}</span></div>
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
          goMyBilling() {
            window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage#/mybilling')
          }
        },
    }
</script>