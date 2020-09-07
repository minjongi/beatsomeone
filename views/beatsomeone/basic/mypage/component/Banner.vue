<template>
    <section class="banner">
        <div class="row justify-content-center">
            <div class="col-8 text-center">
                <h3 class="font-weight-bold" v-html="$t('togetherWithBeatsomeone')"></h3>
                <p v-html="$t('makeRelationshipWithPeopleMsg')"></p>
                <button class="btn btn-warning round">{{$t('startSelling1')}}</button>
            </div>
        </div>
    </section>
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
    .banner {
        padding-top: 180px;

        h3 {
            span {
                color: #ffda2a;
                text-decoration: underline;
            }
        }

        p {
            margin-top: 50px;
            opacity: 0.5;
        }

        button {
            margin-top: 50px;
            font-weight: 600;
        }
    }
</style>