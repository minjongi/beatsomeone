<template>
    <div class="my-5">
        <div class="mb-5">
            <h5 class="mb-3 title">
                {{$t('orderDetails')}}
            </h5>
            <div class="split-board row">
                <div class="item col text-center">
                    <h3 class="text-primary">{{ order_buy_count }}</h3>
                    <p>{{$t('buy')}}</p>
                </div>
                <div class="item col text-center">
                    <h3 class="text-danger">{{ order_cancel_count }}</h3>
                    <p>{{$t('cancel')}}</p>
                </div>
                <div class="item col text-center">
                    <h3 class="text-success">{{ order_refund_count }}</h3>
                    <p>{{$t('refund')}}</p>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <h5 class="mb-3 title">
                {{ $t('expiredSoon') }}
                <a href="javascript:;" class="float-right mr-2">
                    <span>more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <div id="expired-items" class="swiper-container" v-if="expired_soon_items.length > 0">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div>
                            Item 1
                        </div>
                        <div>
                            Item 2
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            Item 3
                        </div>
                        <div>
                            Item 4
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            Item 5
                        </div>
                        <div>
                            Item 6
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination">
                </div>
            </div>
            <div class="text-center empty-content" v-else>
                <span>{{ $t('dashboard_ExpiredSoon_notexists') }}</span>
            </div>
        </div>
        <div class="mb-5">
            <h5 class="title mb-3">
                {{$t('recentlyListen')}}
            </h5>
            <swiper :options="swiperOption" v-if="recentlyViewedItems.length > 0">
                <swiper-slide v-for="citem in recentlyViewedItems" :key="citem.ish_id">
                    <div class="item-wrapper" @click="goToItemPage(citem.cit_key)">
                        <div class="image-wrapper mt-3 mb-3">
                            <img :src="'/uploads/cmallitem/' + citem.cit_file_1" />
                        </div>
                        <h6 class="cit-name">{{ citem.cit_name }}</h6>
                        <p class="mem-name">{{ citem.mem_firstname + ' ' + citem.mem_lastname }}</p>
                    </div>
                </swiper-slide>
            </swiper>
            <div class="empty-content" v-else>
            <span>
                {{ $t('dashboard_RecentlyListen_notexists') }}
            </span>
            </div>
        </div>
        <div class="mb-5">
            <h5 class="title mb-3">
                {{$t('messageYouReceived')}}
                <a href="javascript:;" @click="$router.push('/message')" class="float-right mr-2">
                    <span class="">more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <div v-if="messages.length > 0">
            </div>
            <div class="empty-content recent" v-else>
                <span>No messages</span>
            </div>
        </div>
        <div class="mb-5">
            <h5 class="title mb-3">
                {{$t('supportCase')}}
                <a class="float-right mr-2" href="javascript:;" @click="goPage('/inquiry')">
                    <span class="">more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <div v-if="inquiries.length > 0">
            </div>
            <div class="empty-content recent" v-else>
                <span>No questions</span>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import { Swiper, SwiperSlide } from 'vue-awesome-swiper';

    export default {
        name: "Dashboard",
        components: {
            Swiper,
            SwiperSlide
        },
        data: function () {
            return {
                member_group_name: '',
                order_buy_count: 0,
                order_cancel_count: 0,
                order_refund_count: 0,
                refundCnt: 0,
                expired_soon_items: [],
                recentlyViewedItems: [],
                messages: [],
                inquiries: [],
                swiperOption: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                }
            }
        },
        mounted() {
            this.member_group_name = window.member_group_name;
            // var swiper = new Swiper('#expired-items', {
            //     pagination: {
            //         el: '.swiper-pagination',
            //     },
            // });

            axios.get('/mypage/ajax_info')
                .then(res => res.data)
                .then(data => {
                    this.order_buy_count = data.order_buy_count;
                    this.order_cancel_count = data.order_cancel_count;
                    this.order_refund_count = data.order_refund_count;
                    this.expired_soon_items = data.expired_soon_items;
                    this.recentlyViewedItems = data.recently_listen_items;
                    this.messages = data.messages;
                    this.inquiries = data.inquiries;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods: {
            goPage(page) {
                this.$router.push(page);
            },
            goToItemPage(cit_key) {
                window.location.href = `/beatsomeone/detail/${cit_key}`;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .split-board {
        > .item {
            &:not(:last-child) {
                border-right: solid 1px #4d4d4d;
            }

            h3 {
                font-size: 4rem;
            }
        }
    }

    .empty-content {
        height: 60px;
        position: relative;

        span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }

    .image-wrapper {
        padding-top: 100%;
    }

    .title {
        a {
            text-decoration: none;
            color: white;
            opacity: 0.7;
            line-height: 13px;

            span {
                font-size: 13px;
            }
        }
    }

    .item-wrapper {
        .mem-name {
            opacity: 0.3;
        }
    }

    .image-wrapper {
        padding-top: 100%;
        position: relative;

        &:hover {
            cursor: pointer;
        }

        img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 10px;
        }
    }
</style>