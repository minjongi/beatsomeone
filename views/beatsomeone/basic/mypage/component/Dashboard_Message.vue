<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('messageYouReceived')}}</div>
            <button class="btn btn--glass" @click="$router.push('/message')">more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <h6 class="text-center" v-if="data.length === 0">
            No messages
        </h6>
        <div v-if="data.length > 0">
            <div class="playList">
                <ul>
                    <li class="playList__itembox" v-for="(message,index) in data" :key="index">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover profile">
                                        <img v-if="message.mem_photo" :src="'/uploads/member_photo/' + message.mem_photo" :alt="message.mem_name">
                                        <img v-else src="/assets/images/portait.png">
                                    </span>
                                    <figcaption class="pointer" onclick='location.href = `/mypage#/message/`'>
                                        <h3 class="playList__title">{{ message.mem_userid }}</h3>
                                        <span class="playList__by date">{{ message.nte_datetime }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action text-right" :class="{'active': !message.nte_read_datetime}">
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

<style scoped="scoped" lang="sass">

</style>
