<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab n-flex" style="height:48px; font-size: 12px;">
                    <div @click="goPage('/mybilling')">{{$t('orderHistory')}} ({{total_order_rows}})</div>
                    <div class="active">{{ $t('lang57') }}({{total_cancel_rows}})</div>
                </div>
            </div>
        </div>


        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="n-flex between filter">
                    <div class="condition" :class="{ 'active': period === -1 }"
                         @click="period = -1">{{$t('all')}}
                    </div>
                    <div class="condition" :class="{ 'active': period === 3 }"
                         @click="period = 3">{{$t('months3')}}
                    </div>
                    <div class="condition" :class="{ 'active': period === 6 }"
                         @click="period = 6">{{$t('months6')}}
                    </div>
                    <div class="condition" :class="{ 'active': period === 12 }"
                         @click="period = 12">{{$t('year1')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 10px;">
            <div>
                <VueHotelDatepicker
                        class="search-date"
                        format="YYYY-MM-DD"
                        :placeholder="$t('startDate') + ' ~ ' + $t('endDate')"
                        :startDate="start_date"
                        :endDate="end_date"
                        minDate="1970-01-01"
                        :maxDate="currDate"
                        :endingDateValue="currDate"
                        @update="updateSearchDate"
                        @reset="resetSearchDate"
                />
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="sort">
                <div class="custom-select" style="flex: 2;">
                    <button class="selected-option">
                        {{ $t(orderType) }}
                    </button>
                    <div class="options">
                        <button class="option" @click="funcOrderType('recent', 'desc')"> {{$t('recent')}}</button>
                        <button class="option" @click="funcOrderType('past', 'asc')"> {{$t('past')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist">

                <ul>
                    <li v-for="(order, idx) in orders" v-bind:key="idx" class="playList__itembox" :id="'slist'+ order['id']" @click="goOrderDetail(order.cor_id)" >
                        <div class="playList__item playList__item--title nowrap active">

                            <div class="n-flex between">
                                <div class="index">{{ order.cor_id }} </div>
                                <div class="date"> {{ order.cor_datetime }} </div>
                            </div>

                            <div class="n-flex between">
                                <div class="subject"
                                     v-html="formatSub(order.detail)">
                                </div>
                                <div class="totalprice"
                                     v-html="formatPr(order.cor_pg, order.cor_total_money)"></div>
                            </div>
                            <div class="status">
                                <div v-if="order.cor_status === '1'" class="green">
                                    {{ $t('orderComplete') }}
                                </div>
                                <div v-else-if="order.cor_status === '2'" class="red">
                                    {{ $t('orderCancel') }}
                                </div>
                                <div v-else class="yellow">
                                    {{ $t('deposit') }}
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="pagination" v-html="pagination">
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'
    import axios from 'axios';

    export default {
        components: {
            VueHotelDatepicker
        },
        data: function() {
            return {
                isLogin: false,
                period: -1,
                start_date: '',
                end_date: '',
                currDate: new Date().toISOString().substring(0, 10),
                orderType: 'recent',
                pagination: '',
                total_order_rows: 0,
                total_cancel_rows: 0,
                orders: [],
                forder: 'desc',
            };
        },
        mounted(){
            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function() {

                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this)
                    .find(".options")
                    .toggle();
            });
            this.fetchData();
        },
        created() {
        },
        methods:{
            goPage: function(page){
                this.$router.push(page);
            },
            goRoute: function (page) {
                this.$router.push({path: "/" + page});
            },
            updateSearchDate(date) {
                if (this.isEmpty(date.start) || this.isEmpty(date.end)) {
                    this.fetchData();
                } else {
                    this.start_date = date.start
                    this.end_date = date.end
                    this.fetchData();
                }
            },
            resetSearchDate(date) {
                this.start_date = ''
                this.end_date = ''
                this.fetchData();
            },
            isEmpty: function (str) {
                return typeof str == "undefined" || str == null || str === "";
            },
            funcOrderType(od, forder) {
                if (this.orderType === od) {
                    return;
                } else {
                    this.orderType = od;
                    this.forder = forder;
                    this.fetchData();
                }
            },
            fetchData: function () {
                axios.get(`/cmall/ajax_cancellist?start_date=${this.start_date}&end_date=${this.end_date}&forder=${this.forder}`)
                    .then(res => res.data)
                    .then(data => {
                        this.orders = data.data.list;
                        this.total_order_rows = (+data.data.total_rows);
                        this.total_cancel_rows = (+data.data.total_cancel_rows);
                        this.pagination = data.paging;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            goOrderDetail: function (cor_id) {
                this.$router.push('/mycancelList/' + cor_id);
            },
            formatSub: function (detail) {
                let size = detail.length;
                let title = '';
                if (size > 0) {
                    if (detail[0].item) {
                        title = this.truncate(detail[0].item.cit_name, 20);
                    }
                }
                if (1 < size) {
                    return title + this.$t('lang164') + ' ' + (size - 1) + this.$t('lang162');
                }
                return title;
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
            formatPr: function (pg, price) {
                if (pg === 'paypal') {
                    return '$' + this.formatNumberEn(price);
                } else if (pg === 'allat') {
                    return '₩' + this.formatNumber(price);
                } else {
                    return price
                }
            },
            formatNumber(n) {
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
            },
            formatNumberEn(n) {
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
            },
            formatCitName: function (data, limitLth) {
                let rst;
                if (limitLth < data.length && data.length <= limitLth * 2) {
                    rst = data.substring(0, limitLth) + '<br/>' + data.substring(limitLth, limitLth * 2);
                } else if (limitLth < data.length && limitLth * 2 < data.length) {
                    rst = data.substring(0, limitLth) + '<br/>' + data.substring(limitLth, limitLth * 2) + '...';
                } else {
                    rst = data
                }
                return rst;
            },
            funcDownStatus: function (status, items) {
                if (status === 'Possible') {
                    let possCnt = 0;
                    items.forEach(item => {
                        if (item.itemdetail) {
                            if (item.itemdetail[0].cod_status === 'order') {
                                if (item.item.possible_download === 1) {
                                    possCnt++;
                                }
                            }
                        }
                    })
                    return possCnt;
                } else if (status === 'Impossible') {
                    let possCnt = 0;
                    items.forEach(item => {
                        if (!item.itemdetail) {
                            possCnt++;
                        } else {
                            if (item.itemdetail[0].cod_status === 'deposit') {
                                possCnt++;
                            }
                        }
                    });
                    return possCnt;
                } else if (status === 'Expired') {
                    let possCnt = 0;
                    items.forEach(item => {
                        if (item.itemdetail) {
                            if (item.itemdetail[0].cod_status === 'order') {
                                if (item.item.possible_download === 0) {
                                    possCnt++;
                                }
                            }
                        }
                    });
                    return possCnt;
                }
            },
        },
        watch: {
            period: function (val) {
                let currentDate = new Date();
                if (val === -1) {
                    this.start_date = '2020-01-01';
                } else {
                    let priorDate = new Date(new Date().setMonth(currentDate.getMonth() - val));
                    this.start_date = priorDate.yyyymmdd();
                }
                this.end_date = currentDate.yyyymmdd();
                this.fetchData();
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .tab {
        align-items: center;
        background: #2B2C30 !important;

        div {
            width: 50%;
            text-align: center;
            padding: 0 20px;
        }
    }

    .playList .playList__item .subject {
        color: white;
    }
    .sub .search.condition {
      width: 100%;
      .filter {
        display: flex;
      }
    }
</style>
