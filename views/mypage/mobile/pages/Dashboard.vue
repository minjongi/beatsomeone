<template>
    <div class="my-5">
        <div class="container-fluid mb-5" v-if="isSeller">
            <h5>{{$t('settlementOverview')}}</h5>
            <div class="row settle-overview">
                <div class="col-12 text-center text-primary">
                    <h3>{{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? total_sale_funds : total_sale_funds_d }}</h3>
                    <p class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (total_sale_funds - total_last_sale_funds) : (total_sale_funds_d - total_last_sale_funds_d) }})</p>
                    <p class="text-secondary">
                        {{$t('estimatedSalesAmount')}} <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Displays the estimated amount of sales of the bit sold so far, starting from the current month. The exact sales amount can be confirmed on the last day."></span>
                    </p>
                </div>
                <div class="col-12 text-center text-primary">
                    <h3>{{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? total_settle_funds : total_settle_funds_d }}</h3>
                    <p class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (total_settle_funds - total_last_settle_funds) : (total_settle_funds_d - total_last_settle_funds_d) }})</p>
                    <p class="text-secondary">
                        {{$t('estimatedSettlementAmount')}} <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Displays the estimated settlement amount, deducted from the fee, based on the amount sold so far from the current month. The exact settlement amount can be checked between 20-25 days of the following month."></span>
                    </p>
                </div>
                <div class="col-12 text-center text-danger">
                    <h3>{{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? total_last_settle_funds : total_last_settle_funds_d }}</h3>
                    <p class="change">({{$t('change')}} {{ $i18n.locale === 'ko' ? (total_last_settle_funds - total_lastlast_settle_funds) : (total_lastlast_settle_funds - total_lastlast_settle_funds_d) }})</p>
                    <p class="text-secondary">
                        {{$t('lastMonthSettlementAmount')}} <span class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Displays the amount settled last month."></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="container-fluid mb-5" v-if="isSeller">
            <h5>{{$t('chart')}}</h5>
            <div class="chart">
                <SaleChart :data="saleData" v-if="saleData" />
            </div>
        </div>
        <div class="container-fluid mb-5">
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
        <div class="container-fluid mb-5" v-if="isSeller">
            <h5 class="mb-3 title">
                Product details
                <a href="javascript:;" @click="$router.push('/list_item')" class="float-right mr-2">
                    <span>more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <div class="split-board row">
                <div class="item col text-center">
                    <h3 class="text-primary">{{ total_product_count }}</h3>
                    <p>Total</p>
                </div>
                <div class="item col text-center">
                    <h3 class="text-danger">{{ selling_product_count }}</h3>
                    <p>Selling</p>
                </div>
                <div class="item col text-center">
                    <h3 class="text-success">{{ pending_product_count }}</h3>
                    <p>Pending</p>
                </div>
            </div>
        </div>
        <div class="mb-5" v-if="isBuyer">
            <h5 class="m-3 title">
                {{ $t('expiredSoon') }}
                <a href="javascript:;" class="float-right mr-2">
                    <span>more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <swiper v-if="expired_soon_items.length > 0">
                <swiper-slide v-for="cod_item in expired_soon_items" :key="cod_item.cod_id">
                    <div class="d-flex py-3 align-items-center list-item" @click="goToItemPage(cod_item.cit_key)">
                        <div class="col d-flex align-items-center">
                            <div class="expired-wrapper mr-2">
                                <div class="image-wrapper">
                                    <img :src="'/uploads/cmallitem/' + cod_item.coverImg" />
                                </div>
                            </div>
                            <h6 class="cit-name">{{ cod_item.cit_name }}</h6>
                        </div>
                        <div class="col-auto text-right text-secondary">
                            <span class="text-danger">{{ timeago(cod_item.expireTm).replace('in','')}}</span> remaining
                        </div>
                    </div>
                </swiper-slide>
            </swiper>
            <div class="text-center empty-content" v-else>
                <span>{{ $t('dashboard_ExpiredSoon_notexists') }}</span>
            </div>
        </div>
        <div class="container-fluid mb-5">
            <h5 class="title m-3">
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
            <h5 class="title m-3">
                {{$t('messageYouReceived')}}
                <a href="javascript:;" @click="$router.push('/message')" class="float-right mr-2">
                    <span class="">more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <div v-if="messages.length > 0">
                <ul class="list-group">
                    <li class="list-group-item" v-for="(message, index) in messages" v-bind:key="index">
                        <div class="row align-items-center">
                            <div class="col-2 pr-0">
                                <div class="mem-photo">
                                    <img :src="message.mem_photo" v-if="message.mem_photo">
                                    <img src="/assets/images/portait.png" v-else>
                                </div>
                            </div>
                            <div class="col-7">
                                <div>{{ message.mem_nickname }}</div>
                                <div class="text-secondary">{{ message.nte_datetime }}</div>
                            </div>
                            <div class="col-3">
                                <span class="text-secondary" v-if="message.nte_read_datetime">Read</span>
                                <span class="text-warning" v-else>Unread</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="empty-content recent" v-else>
                <span>No messages</span>
            </div>
        </div>
        <div class="mb-5">
            <h5 class="title m-3">
                {{$t('supportCase')}}
                <a class="float-right mr-2" href="javascript:;" @click="goPage('/inquiry')">
                    <span class="">more <i class="fal fa-chevron-right"></i></span>
                </a>
            </h5>
            <div v-if="inquiries.length > 0">
                <ul class="list-group">
                    <li class="list-group-item" v-for="(inquiry, index) in inquiries" v-bind:key="index">
                        <div class="row align-items-center" @click="$router.push('/inquiry/' + inquiry.post_id)">
                            <div class="col-9">
                                <div>{{ inquiry.post_title }}</div>
                                <div class="text-secondary">{{ inquiry.post_updated_datetime }}</div>
                            </div>
                            <div class="col-3">
                                <span class="text-warning" v-if="inquiry.replies.list.length === 0">Wait...</span>
                                <span class="text-secondary" v-else>Answer Complete...</span>
                            </div>
                        </div>
                    </li>
                </ul>
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
    import * as timeago from "timeago.js";
    import SaleChart from "../component/SaleChart";

    export default {
        name: "Dashboard",
        components: {
            Swiper,
            SwiperSlide,
            SaleChart
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
                },
                total_sale_funds: 0,
                total_sale_funds_d: 0,
                total_settle_funds: 0,
                total_settle_funds_d: 0,
                total_last_sale_funds: 0,
                total_last_sale_funds_d: 0,
                total_last_settle_funds: 0,
                total_last_settle_funds_d: 0,
                total_lastlast_settle_funds: 0,
                total_lastlast_settle_funds_d: 0,
                total_product_count: 0,
                selling_product_count: 0,
                pending_product_count: 0,
                saleData: null,
            }
        },
        mounted() {
            this.member_group_name = window.member_group_name;
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
                    if (this.isSeller) {
                        this.total_sale_funds = data.total_sale_funds;
                        this.total_sale_funds_d = data.total_sale_funds_d;
                        this.total_settle_funds = data.total_settle_funds;
                        this.total_settle_funds_d = data.total_settle_funds_d;
                        this.total_last_sale_funds = data.total_last_sale_funds;
                        this.total_last_sale_funds_d = data.total_last_sale_funds_d;
                        this.total_last_settle_funds = data.total_last_settle_funds;
                        this.total_last_settle_funds_d = data.total_last_settle_funds_d;
                        this.total_lastlast_settle_funds = data.total_lastlast_settle_funds;
                        this.total_lastlast_settle_funds_d = data.total_lastlast_settle_funds_d;
                        this.total_product_count = data.total_product_count;
                        this.selling_product_count = data.selling_product_count;
                        this.pending_product_count = data.pending_product_count;
                        this.saleData = data.saleData;
                    }
                })
                .catch(error => {
                    console.error(error);
                })
        },
        computed: {
            isSeller() {
                return this.member_group_name.includes('seller');
            },
            isBuyer() {
                return this.member_group_name === 'buyer';
            }
        },
        methods: {
            goPage(page) {
                this.$router.push(page);
            },
            goToItemPage(cit_key) {
                window.location.href = `/detail/${cit_key}`;
            },
            timeago(date) {
                return timeago.format(date);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .settle-overview {
        h3 {
            font-size: 4rem;
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

    .list-group-item, .list-item {
        background-color: #1b1b1e;
        margin-bottom: 1px;
    }

    .mem-photo {
        img {
            width: 100%;
            border-radius: 50%;
        }
    }

    .expired-wrapper {
        width: 90px;

        .image-wrapper {
            padding-top: 100%;
            position: relative;

            img {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
                height: 100%;
                border-radius: 10px;
                box-shadow: unset;

                &:hover {
                    box-shadow: unset;
                }
            }
        }
    }
</style>