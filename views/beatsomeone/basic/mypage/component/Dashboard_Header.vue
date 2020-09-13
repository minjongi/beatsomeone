<template>
    <header class="main__section1-title" >
        <div class="banner">
            <h3 v-html="$t('togetherWithBeatsomeone')"></h3>
            <p v-html="$t('makeRelationshipWithPeopleMsg')"></p>
            <a href="/mypage/upgrade" class="btn btn--yellow round">{{$t('startSelling1')}}</a>
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

<style lang="scss" scoped>
    .main__section1-title {
        width: 100%;
    }
</style>
