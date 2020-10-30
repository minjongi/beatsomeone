<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('messageYouReceived')}}</div>
            <button class="btn btn--glass" onclick='location.href = "/mypage#/message"'>more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div>
            <p v-if="data.length === 0" style="text-align: center; opacity: 0.7; font-size: 16px;">
                No messages
            </p>
            <div class="playList" v-else>
                <ul>
                    <li class="playList__itembox" v-for="(message,index) in data" :key="index">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover profile">
                                        <img v-if="message.mem_photo" :src="message.mem_photo" :alt="message.mem_name">
                                        <img v-else src="/assets/images/portrait.png">
                                    </span>
                                    <figcaption class="pointer" onclick='location.href = `/mypage#/message/`'>
                                        <h3 class="playList__title">{{ message.mem_nickname }}</h3>
                                        <span class="playList__by date">{{ message.nte_datetime }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action" :class="{'active': message.nte_read_datetime }">
                                {{ message.nte_read_datetime ? $t('read') : $t('unread') }}
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
    .playList .playList__item .name figure .playList__cover {
        margin-left: 15px;
        margin-right: 15px;
    }
</style>
