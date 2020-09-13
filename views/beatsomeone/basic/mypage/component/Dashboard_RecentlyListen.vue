<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('recentlyListen')}}</div>
        </div>

        <div v-if="data.length === 0">
            <h3 style="text-align: center">{{ $t('dashboard_RecentlyListen_notexists') }}</h3>
        </div>

        <div v-else class="topFive recentListen">
            <div class="trending__slide-item albumItem" v-for="(citem,index) in data" :key="index">
                <a :href="'/beatsomeone/detail/'+citem.cit_key">
                    <div class="albumItem__cover">
                            <img class="coverImg" :src="citem.cit_file_1 ? '/uploads/cmallitem/' + citem.cit_file_1 : '/assets/images/cover_default.png'" :alt="citem.cit_name" />
                    </div>
                </a>
                <a :href="'/beatsomeone/detail/'+citem.cit_key" class="albumItem__link">
                    <h4 class="albumItem__title">{{ citem.cit_name }}</h4>
                    <p class="albumItem__singer">{{ citem.musician }}</p>
                </a>
            </div>
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

<style scoped="scoped" lang="scss">
    .albumItem {
        width: 15%;
    }
    .albumItem__cover {
        width: 150px;
        height: 150px;
    }
</style>
