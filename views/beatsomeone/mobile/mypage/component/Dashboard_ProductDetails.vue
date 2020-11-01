<template>
    <div class="title-content">
        <h4 class="title">
          {{ $t('lang53') }}
        </h4>
        <div class="n-flex splitboard">
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

        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
