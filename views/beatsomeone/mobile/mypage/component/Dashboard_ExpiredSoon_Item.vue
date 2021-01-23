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
                        <i class="label new" v-if="item.is_new">N</i>
                    </span>
                    <figcaption class="pointer" @click="selectItem">
                        <h3 class="playList__title">{{ truncate(item.cit_name, 20)}}</h3>
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
            if (this.item) {
                if (this.item.cit_type3 === '0') {
                    this.$set(this.item, 'is_new', false);
                    let now = new Date();
                    let startDateTime = new Date(this.item.cit_start_datetime);
                    if ((now - startDateTime) < 1000 * 3600 * 24 * 7) this.$set(this.item, 'is_new', true);
                } else if (this.item.cit_type3 === '1') {
                    this.$set(this.item, 'is_new', true);
                }
            } else {
                return false;
            }
        },
        methods: {
            selectItem() {
                const path = `/detail/${this.item.cit_key}`;
                window.location.href = this.helper.langUrl(this.$i18n.locale, path);
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

<style scoped="scoped" lang="css">
    .playList__itembox .playList__item {
        display: flex;
    }
</style>