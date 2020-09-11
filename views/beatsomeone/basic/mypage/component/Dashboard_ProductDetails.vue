<template>
    <div class="title-content">
        <div class="title">
            <div>Product details</div>
            <button class="btn btn--glass" onclick='location.href = "/mypage#/list_item"'>more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div class="splitboard">
            <div class="blue">{{ data.Total }}<span>Total</span></div>
            <div class="red">{{ data.Selling }}<span>Selling</span></div>
            <div class="green">{{ data.Pending }}<span>Pending</span></div>
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
