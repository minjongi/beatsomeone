<template>
    <div class="title-content">
        <h4 class="title">
            Product details
        </h4>
        <div class="n-flex splitboard">
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
