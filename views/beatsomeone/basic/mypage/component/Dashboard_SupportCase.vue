<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('supportCase')}}</div>
            <button class="btn btn--glass" onclick='location.href = "/mypage#/inquiry"'>more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div>
            <div class="playList" v-if="data.length > 0">
                <ul>
                    <li class="playList__itembox" v-for="o in data" :key="o.sp_id">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <figcaption class="pointer" @click="onClick(o)">
                                        <h3 class="playList__title" style="height:18px">{{ truncate(o.title,50 )}}</h3>
                                        <span class="playList__by">{{ o.regDt.date }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action" :class="{'active': o.status === 'answerCompleted'}">
                                {{ $t(o.status) }}
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <div v-else>
                <h3 style="text-align: center">No questions</h3>
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
