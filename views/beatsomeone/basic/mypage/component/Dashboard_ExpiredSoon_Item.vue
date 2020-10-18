<template>
    <li class="playList__itembox" v-if="item">
        <div class="playList__item playList__item--title active">
            <div class="col name">
                <figure>
                    <span class="playList__cover">
                        <img
                                :src="'/uploads/cmallitem/' + item.coverImg"
                                alt=""
                        />
                    </span>
                    <figcaption class="pointer" @click="selectItem">
                        <h3 class="playList__title">{{ truncate(item.cit_name, 30) }}</h3>
                        <span class="playList__by">by {{ item.mem_nickname }}</span>
                    </figcaption>
                </figure>
            </div>
            <div class="info">
                <div class="expire">
                    <span>{{ timeago(item.expired_date).replace('ago','')}}</span> remaining
                </div>
            </div>
        </div>
    </li>
</template>


<script>
    import * as timeago from 'timeago.js';
    import { EventBus } from '*/src/eventbus';

    export default {
        props: ['item'],
        data: function () {
            return {
                slide_expired: 0,
            }
        },
        created() {

        },
        mounted() {

        },
        methods: {
            selectItem() {
                const path = `/beatsomeone/detail/${this.item.cit_key}`;
                window.location.href = path;
            },
            timeago(date) {
                return timeago.format(date);
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
        },

    }

</script>

<style scoped="scoped" lang="scss">
    .playList .playList__item .name figure .playList__cover {
        margin-right: 15px;
        margin-left: 15px;
    }
</style>