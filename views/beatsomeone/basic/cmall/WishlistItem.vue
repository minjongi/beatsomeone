<template>
    <div class="playList__item playList__item--title">
        <div class="col check">
            <label class="checkbox">
                <input type="checkbox" hidden="hidden"
                       v-model="item.is_selected" @click="selected" />
                <span></span>
            </label>
        </div>
        <div class="col name">
            <figure>
                                                            <span class="playList__cover"><img
                                                                    :src="'/uploads/cmallitem/' + item.cit_file_1" alt/><i
                                                                    class="label new" ng-if="item.isNew">N</i></span>
                <figcaption class="pointer" @click="selectItem(item)">
                    <h3 class="playList__title">{{ item.cit_name }}</h3>
                    <span class="playList__by">by {{ item.mem_nickname }}</span>
                </figcaption>
            </figure>
        </div>
        <div class="col genre">
            <!--                                                        <span v-for="(t,i) in hashtag" :key="i"><button @click="clickHash(t)" v-hover="'active'">{{ t }}</button></span>-->
        </div>
        <div class="col playbtn" v-if="item.detail.length > 0">
            <button class="btn-play" @click="playAudio">재생</button>
            <span class="timer"><span class="current">0:00 / </span><span
                    class="duration">{{ item.detail[0].duration }}</span></span>
        </div>
        <div class="col spectrum">
            <div class="wave">
                <VueWaveSurfer ref="surfer" :detail="item.detail[0]" :options="options"></VueWaveSurfer>
            </div>
        </div>
        <div class="col price">
            <span>{{ $t('currencySymbol') }} {{ $i18n.locale === 'en' ? item.detail[0].cde_price_d : item.detail[0].cde_price }}</span>
        </div>
        <div class="col edit ml-auto">
            <button class="btn btn--blue round"
                    style="height:40px; padding:0 16px;">
                {{$t('buyNow')}}
            </button>
        </div>
    </div>
</template>

<script>
    import VueWaveSurfer from '../component/VueWaveSurfer';
    export default {
        name: "WishlistItem",
        components: {
            VueWaveSurfer
        },
        props: [
            "item"
        ],
        data: function () {
            return {

            }
        },
        methods: {
            formatCitName: function (data) {
                var rst;
                var limitLth = 50;
                if (limitLth < data.length && data.length <= limitLth * 2) {
                    rst =
                        data.substring(0, limitLth) +
                        "<br>" +
                        data.substring(limitLth, limitLth * 2);
                } else if (limitLth < data.length && limitLth * 2 < data.length) {
                    rst =
                        data.substring(0, limitLth) +
                        "<br>" +
                        data.substring(limitLth, limitLth * 2) +
                        "...";
                } else {
                    rst = data;
                }
                return rst;
            },
            playAudio: function () {
                this.$refs.surfer.playPause();
            },
            selectItem(i) {
                window.location.href = `/detail/${i.cit_key}`;
            },
            selected: function (event) {
                this.$emit('selected', {
                    item: this.item,
                    newSelection: !this.item.is_selected,
                })
            }
        },
    }
</script>

<style lang="scss" scoped>
    .playList__item {
        padding: 0 40px;
    }

    .fa-1d5x {
        font-size: 1.5em;
    }

    .ml-auto {
        margin-left: auto;
    }

    .playList__item .n-option .n-box:first-child {
        .price {
            margin-top: 0;
            color: white;
        }
        .option_fold {
            color: #ffffff;
            opacity: 0.3;
        }
    }
</style>