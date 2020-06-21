<template>
    <div class="title-content">
        <div class="title">
            <div>Recently Listen</div>
            <button class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>

        <div class="topFive recentListen">
            <div class="trending__slide-item albumItem" v-for="(o,index) in data" :key="index">
                <a :href="'/beatsomeone/detail/'+o.cit_key">
                <button class="albumItem__cover">
                    <img  :src="'/uploads/cmallitem/' + o.coverImg" :alt="o.cit_name" />
                </button>
                </a>
                <a :href="'/beatsomeone/detail/'+o.cit_key" class="albumItem__link">
                    <h4 class="albumItem__title">{{ o.cit_name }}</h4>
                    <p class="albumItem__singer">{{ o.musician }}</p>
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

<style scoped="scoped" lang="sass">

</style>
