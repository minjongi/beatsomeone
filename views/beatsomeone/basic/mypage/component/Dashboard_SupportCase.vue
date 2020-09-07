<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('supportCase')}}</div>
            <button class="btn btn--glass" @click="goRoute('inquiry')">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div>
            <div class="playList" v-if="data.length > 0">
                <ul>
                    <li class="playList__itembox" v-for="inquiry in data" :key="inquiry.sp_id">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <figcaption class="pointer" @click="onClick(inquiry)">
                                        <h3 class="playList__title" style="height:18px">{{ truncate(inquiry.post_title,50 )}}</h3>
                                        <span class="playList__by">{{ inquiry.post_datetime }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action" :class="{'active': inquiry.status === 'answerCompleted'}">
                                {{ $t(inquiry.status) }}
                            </div>
                        </div>
                    </li>
                </ul>
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
                current: 'dashboard'
            }
        },
        created() {

        },
        mounted() {

        },
        methods: {
            onClick(o) {
                window.location.href = `/mypage#/inquiry/${o.post_id}`;
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
            goRoute: function (page) {
                this.$router.push({path: page})
            },
        },

    }

</script>

<style scoped="scoped" lang="scss">
</style>
