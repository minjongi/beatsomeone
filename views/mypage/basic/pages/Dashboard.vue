<template>
    <div>
        <div class="row mb-5">
            <div class="col-6">
                <h5 class="mb-3 title">
                    {{$t('orderDetails')}}
                    <a href="javascript:;" class="float-right mr-2" @click="$router.push('/orders')">
                        <span>more <i class="fal fa-chevron-right"></i></span>
                    </a>
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
            <div class="col-6">
                <h5 class="mb-3 title">
                    {{ $t('expiredSoon') }}
                    <a href="javascript:;" class="float-right mr-2">
                        <span>more <i class="fal fa-chevron-right"></i></span>
                    </a>
                </h5>
                <div class="swiper-container" v-if="expired_soon_items.length > 0">
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
        </div>
        <div class="mb-5">
            <h5 class="title mb-4">
                {{$t('recentlyListen')}}
            </h5>
            <div v-if="recentlyViewedItems.length > 0">
                <div class="row">
                    <div class="col-2" v-for="citem in recentlyViewedItems" :key="citem.ish_id">
                        <div class="item-wrapper" @click="goToItemPage(citem.cit_key)">
                            <div class="image-wrapper mb-3">
                                <img :src="'/uploads/cmallitem/' + citem.cit_file_1" />
                            </div>
                            <h6 class="cit-name">{{ citem.cit_name }}</h6>
                            <p class="mem-name">{{ citem.mem_firstname + ' ' + citem.mem_lastname }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="empty-content recent" v-else>
                <span>
                    {{ $t('dashboard_RecentlyListen_notexists') }}
                </span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-6">
                <h5 class="title">
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
            <div class="col-6">
                <h5 class="title">
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
    </div>
</template>

<script>
    import Swiper from "swiper/bundle";
    import axios from "axios";

    export default {
        name: "Dashboard",
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
            }
        },
        mounted() {
            this.member_group_name = window.member_group_name;
            var swiper = new Swiper('.swiper-container', {
                pagination: {
                    el: '.swiper-pagination',
                },
            });

            axios.get('/mypage/ajax_info')
                .then(res => res.data)
                .then(data => {
                    console.log(data);
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
        height: calc(100% - 40px);
        position: relative;

        &.recent {
            height: 120px;
        }

        span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
            box-shadow: 0 0 10px 0 #4c4c4c;

            &:hover {
                box-shadow: 0 0 20px 0 #4c4c4c;
            }
        }
    }
</style>