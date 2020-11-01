<template>
    <div class="title-content">
        <h4 class="title">
            <span>{{$t('supportCase')}}</span>
            <a class="more" href="/mypage#/inquiry">more <img src="/assets/images/icon/chevron-right.png"/></a>
        </h4>
        <div>
            <div class="playList" v-if="data.length > 0">
                <ul>
                    <li class="playList__itembox" v-for="(inquiry, index) in data" :key="index">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <figcaption class="pointer" @click="$router.push('/inquiry/' + inquiry.post_id)">
                                        <h3 class="playList__title" style="height:18px">{{ truncate(inquiry.post_title,20 )}}</h3>
                                        <span class="playList__by">{{ inquiry.post_updated_datetime }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action active" v-if="inquiry.replies.list.length === 0">Wait...</div>
                            <div class="action" v-else>Answer Complete...</div>
                        </div>
                    </li>

                </ul>
            </div>
            <div v-else>
                <h3 style="text-align: center">{{ $t('lang51') }}</h3>
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
            onClick(o) {
                window.location.href = `/mypage#/inquiry/${o.sp_id}`;
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
