<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('supportCase')}}</div>
            <button class="btn btn--glass" onclick='location.href = "/mypage#/inquiry"'>more <img src="/assets/images/icon/chevron-right.png"/></button>
        </div>
        <div>
            <div class="playList" v-if="data.length > 0">
                <ul>
                    <li class="playList__itembox" v-for="(post, index) in data" :key="index">
                        <div class="playList__item playList__item--title active">
                            <div class="col name">
                                <figure>
                                    <figcaption class="pointer" @click="onClick(post)">
                                        <h3 class="playList__title" style="height:18px">{{ truncate(post.post_title,50 )}}</h3>
                                        <span class="playList__by">{{ post.post_updated_datetime }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="action active" v-if="post.replies.list.length === 0">Wait...</div>
                            <div class="action" v-else>Answer Complete...</div>
                        </div>
                    </li>

                </ul>
            </div>
            <div v-else>
                <p style="text-align: center; opacity: 0.7; font-size: 16px;">{{ $t('lang51') }}</p>
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
                window.location.href = this.helper.langUrl(this.$i18n.locale, `/mypage#/inquiry/${o.post_id}`);
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
        },

    }

</script>

<style scoped="scoped" lang="scss">
    .sublist .col.name figure {
        margin-left: 15px;
    }
</style>
