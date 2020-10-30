<template>
    <div class="title-content">
        <h4 class="title">
            {{$t('recentlyListen')}}
        </h4>

        <h3 v-if="data.length === 0" style="text-align: center; opacity: 0.7; font-size: 12px;">
            {{ $t('dashboard_RecentlyListen_notexists') }}
        </h3>

        <div v-else class="n-flex topFive recentListen">
            <div class="trending__slide-item albumItem" v-for="(citem,index) in data" :key="index">
                <a :href="'/detail/'+citem.cit_key">
                <button class="albumItem__cover">
                    <img class="coverImg" :src="citem.cit_file_1 ? ('/uploads/cmallitem/' + citem.cit_file_1) : '/assets/images/cover_default.png'" :alt="citem.cit_name" />
                </button>
                </a>
                <a :href="'/detail/'+citem.cit_key" class="albumItem__link">
                    <h4 class="albumItem__title">{{ truncate(citem.cit_name, 10) }}</h4>
                    <p class="albumItem__singer">by {{ citem.mem_nickname }}</p>
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
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
