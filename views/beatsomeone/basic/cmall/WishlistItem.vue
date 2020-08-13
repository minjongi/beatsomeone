<template>
    <li class="playList__itembox">
        <div class="playList__item">
            <div class="col check">
                <label class="checkbox">
                    <input type="checkbox" hidden="hidden" v-model="item.is_selected" @change="toggleFold"/>
                    <span></span>
                </label>
            </div>
            <div class="col name">
                <figure>
                    <span class="playList__cover">
                        <img v-if="!item.cit_file_1" :src="'/assets/images/cover_default.png'" alt />
                        <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt/>
<!--                        <i v-show="checkToday(item.cct_datetime)" class="label new">N</i>-->
                    </span>
                    <figcaption class="pointer">
                        <h3 class="playList__title">{{ formatCitName(item.cit_name) }}</h3>
                        <span class="playList__by">by {{item.mem_nickname}}</span>
                    </figcaption>
                </figure>
            </div>
            <div class="col n-option">
                <div class="option">
                    <div class="n-box">
                        <div class="playList__item--button">
                            <span class="option_fold" @click="toggleFold" ><i class="fal fa-1d5x fa-chevron-circle-down"></i></span>
                            <div class="price">$ 10.00</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col edit ml-auto">
                <button class="btn btn--blue round" style="height:40px; padding:0 16px;">
                    {{$t('buyNow')}}
                </button>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: "WishlistItem",
        props: [
            "item"
        ],
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
            toggleFold: function (event) {
                this.$emit('toggleSelected', this.item.is_selected);
            }
        }
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