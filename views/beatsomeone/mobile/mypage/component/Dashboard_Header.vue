<template>
    <header class="main__section1-title" >
        <div class="banner">
            <h3 v-html="$t('togetherWithBeatsomeone')"></h3>
            <p v-html="$t('makeRelationshipWithPeopleMsg')"></p>
            <button class="btn btn--yellow round" @click="goSellerReg">{{$t('startSelling1')}}</button>
        </div>
    </header>
</template>


<script>

    import { EventBus } from '*/src/eventbus';

    export default {
        props: ['item'],
        data: function () {
            return {

            }
        },
        created() {

        },
        mounted() {

        },
        methods: {
            goSellerReg() {
                window.location.href = '/mypage/sellerreg';
            }
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
