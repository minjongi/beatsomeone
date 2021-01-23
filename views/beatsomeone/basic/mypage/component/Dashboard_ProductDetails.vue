<template>
    <div class="title-content">
        <div class="title">
            <div>{{ $t('lang53') }}</div>
            <button class="btn btn--glass" @click="goListItem()">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div class="splitboard">
            <div class="blue">{{ data.total_product_count }}<span>Total</span></div>
            <div class="red">{{ data.selling_product_count }}<span>Selling</span></div>
            <div class="green">{{ data.pending_product_count }}<span>Pending</span></div>
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
          goListItem() {
            window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage#/list_item')
          }
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
