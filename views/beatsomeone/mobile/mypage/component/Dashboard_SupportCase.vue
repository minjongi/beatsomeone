<template>
    <div class="title-content">
        <h4 class="title">
            <span>{{$t('supportCase')}}</span>
            <a class="more" :href="helper.langUrl($i18n.locale, '/mypage#/inquiry')">more <img src="/assets/images/icon/chevron-right.png"/></a>
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
                <p style="text-align: center; opacity: 0.7; font-size: 12px;">{{ $t('lang51') }}</p>
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
                window.location.href = this.helper.langUrl(this.$i18n.locale, `/mypage#/inquiry/${o.sp_id}`);
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
