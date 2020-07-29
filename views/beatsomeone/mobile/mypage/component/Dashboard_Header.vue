<template>
    <header class="main__section1-title" >
        <div class="banner">
            <h3>{{$t('togetherWithBeatsomeone')}}</h3>
            <p>{{$t('makeRelationshipWithPeopleMsg')}}</p>
            <button class="btn btn--yellow round">{{$t('startSelling1')}}</button>
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

        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
