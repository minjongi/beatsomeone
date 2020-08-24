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
                        <h3 class="playList__title">{{ item.cit_name}}</h3>
                        <span class="playList__by">{{ item.musician }}</span>
                    </figcaption>
                </figure>
            </div>
            <div class="info">
                <div class="expire">
                    <span>{{ timeago(item.expireTm).replace('in','')}}</span> remaining
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
        },

    }

</script>

<style scoped="scoped" lang="scss">
    .playList .playList__item {
        display: flex;

        .info .expire span {
            color: #f14545;
        }
    }
</style>