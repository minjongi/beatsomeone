<template>
    <div class="title-content">
        <h4 class="title">
            <span>{{$t('messageYouReceived')}}</span>
            <a class="more" href="/mypage#/message">more <img src="/assets/images/icon/chevron-right.png"/></a>
        </h4>
        <div>
            <div class="playList">
                <ul>
                    <li class="playList__itembox" v-for="(o,index) in data" :key="index">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover profile">
                                        <img :src="'/uploads/member_photo/' + o.mem_photo" :alt="o.mem_name">
                                    </span>
                                    <figcaption class="pointer" onclick='location.href = `/mypage#/message/`'>
                                        <h3 class="playList__title">{{ o.mem_name }}</h3>
                                        <span class="playList__by date">{{ o.sendDt.date }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action" :class="{'active': o.status === 'unread'}">
                                {{ $t(o.status) }}
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
.playList .playList__item {
    display: flex;
}
</style>
