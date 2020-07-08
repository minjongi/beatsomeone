<template>
    <div class="title-content">
        <h4 class="title">
            {{$t('orderDetails')}}
        </h4>
        <div class="n-flex splitboard">
            <div class="blue">{{ buyCnt }}<span>{{$t('buy')}}</span></div>
            <div class="red">{{ cancelCnt }}<span>{{($t('cancel')}}</span></div>
            <div class="green">{{ refundCnt }}<span>{{($t('refund')}}</span></div>
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
            buyCnt() {
                // return this.data ? _.find(this.data,r => { return r.cod_status === 'deposit'}).cnt : 0;
                if(!this.data) return 0;
                const p = _.find(this.data,r => { return r.cod_status === 'deposit'});
                return p ? (p.cnt) : 0;
            },
            cancelCnt() {
                if(!this.data) return 0;
                const p = _.find(this.data,r => { return r.cod_status === 'cancel'});
                return p ? (p.cnt) : 0;
            },
            refundCnt() {
                // return this.data ? _.find(this.data,r => { return r.cod_status === 'refund'}).cnt : 0;
                if(!this.data) return 0;
                const p = _.find(this.data,r => { return r.cod_status === 'refund'});
                return p ? (p.cnt) : 0;
            },
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
