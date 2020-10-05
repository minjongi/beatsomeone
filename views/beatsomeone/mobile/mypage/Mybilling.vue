<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab n-flex" style="height:48px;">
                    <div class="active">{{$t('orderHistory')}} ({{calcTotalCnt}})</div>
                    <div @click="gocancellist">Cancellation / Refund History({{ total_cancel_rows }})</div>
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

        <div class="row" style="margin-bottom: 10px;">
            <div class="sort">
                <div class="custom-select" style="flex: 3;">
                    <button class="selected-option">
                        {{ $t(downType) }}
                    </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcDownType('All')"> {{$t('total1')}} </button>
                        <button data-value="" class="option" @click="funcDownType('Download Complete')"> {{$t('downloadComplete')}} </button>
                        <button data-value="" class="option" @click="funcDownType('Not Downloaded')"> {{$t('notDownloaded')}} </button>
                    </div>
                </div>

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

        <div class="row">
            <div class="tabmenu">
              <div :class="{ 'active': cor_status === '' }" @click="cor_status = ''">{{$t('total1')}}
                ({{calcTotalCnt}})
              </div>
              <div :class="{ 'active': cor_status === '0' }" @click="cor_status = '0'">{{$t('wait')}}
                ({{calcWaitCnt}})
              </div>
              <div :class="{ 'active': cor_status === '1' }" @click="cor_status = '1'">{{$t('payComplete1')}}
                ({{calcCompleteCnt}})
              </div>
            </div>
        </div>

        <!-- <div class="row" style="margin-bottom:20px;">
            <div class="main__media board mybillinglist">
                <div class="tab nowrap">
                    <div class="index">{{$t('orderNumber')}}</div>
                    <div class="date">{{$t('date')}}</div>
                    <div class="product">{{$t('product')}}</div>
                    <div class="totalprice">{{$t('totalPrice')}}</div>
                    <div class="status">{{$t('status')}}</div>
                    <div class="download">{{$t('download1')}}</div>
                </div>
            </div>
        </div> -->

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
                                <div class="status">
                                  <div v-if="order.cor_status === '1'" class="green">
                                    {{ $t('orderComplete')}}
                                  </div>
                                  <div v-else-if="order.cor_status === '2'" class="red">
                                    {{ $t('orderCancel')}}
                                  </div>
                                  <div v-else>
                                    {{ $t('deposit')}}
                                  </div>
                                </div>
                              <div class="totalprice"
                                   v-html="formatPr(order.cor_pg, order.cor_total_money)"></div>
                            </div>

                            <div class="subject"
                                 v-html="formatSub(order.detail)">
                            </div>

                            <div class="download">
                                <div v-if="0 < funcDownStatus('Possible', order['detail'])" class="download">
                                    <span class="green">{{$t('possible')}} {{ funcDownStatus('Possible', order['detail'])}} </span>
                                </div>
                                <div v-if="0 < funcDownStatus('Impossible', order['detail'])" class="download">
                                    <span class="red">{{$t('impossible')}} {{ funcDownStatus('Impossible', order['detail'])}} </span>
                                </div>
                                <div v-if="0 < funcDownStatus('Expired', order['detail'])" class="download">
                                    <span class="gray">{{$t('expired')}} {{ funcDownStatus('Expired', order['detail'])}} </span>
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
    import axios from 'axios'
    import moment from "moment";
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'

    Date.prototype.yyyymmdd = function () {
        let mm = this.getMonth() + 1;
        let dd = this.getDate();

        return [this.getFullYear(), (mm > 9 ? '' : '0') + mm, (dd > 9 ? '' : '0') + dd].join('-');
    }

    export default {
        components: {
            VueHotelDatepicker
        },
        data: function () {
            return {
                isLogin: false,
                mem_photo: '',
                mem_usertype: '',
                mem_nickname: '',
                mem_address1: '',
                mem_type: '',
                mem_lastname: '',
                group_title: 'SELLER',
                product_status: 'PENDING',
                orders: [],
                search_condition_active_idx: 1,
                search_tabmenu_idx: 1,
                orderType: 'recent',
                downType: 'total1',
                calcTotalCnt: 0,
                calcWaitCnt: 0,
                calcCompleteCnt: 0,
                calcRefundCnt: 0,
                total_cancel_rows: 0,
                start_date: '',
                end_date: '',
                totalpage: 0,
                currPage: 1,
                perPage: 10,
                currDate: new Date().toISOString().substring(0, 10),
                pagination: '',
                period: -1,
                cor_status: '',
                forder: 'desc'
            };
        },
        mounted() {
            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function () {

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
        methods: {
            fetchData: function () {
                axios.get(`/cmall/ajax_orderlist?start_date=${this.start_date}&end_date=${this.end_date}&cor_status=${this.cor_status}&forder=${this.forder}`)
                    .then(res => res.data)
                    .then(data => {
                        this.orders = data.data.list;
                        this.calcTotalCnt = (+data.data.total_rows);
                        this.calcWaitCnt = (+data.data.total_deposit_rows);
                        this.calcCompleteCnt = (+data.data.total_order_rows);
                        this.total_cancel_rows = (+data.data.total_cancel_rows);
                        this.pagination = data.paging;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            formatPr: function (m, price) {
              if (m === 'paypal') {
                return '$' + this.formatNumberEn(price);
              } else if (m === 'allat') {
                return '₩' + this.formatNumber(price);
              } else {
                return ''
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
            formatSub: function (detail) {
                let size = detail.length;
                let title = '';
                if (size > 0) {
                    if (detail[0].item) {
                        title = detail[0].item.cit_name;
                    }
                }
                if (1 < size) {
                    return title + " 외 " + (size - 1) + "건";
                }
                return title;
            },
            calcFuncTotalCnt() {
                return this.orders.length;
            },
            calcFuncWaitCnt() {
                let list = [];
                Object.assign(list, this.orders);
                let rst = list.filter(item => item['items'][0].cor_status === '0');
                return rst.length;
            },
            calcFuncCompleteCnt() {
                let list = [];
                Object.assign(list, this.orders);
                let rst = list.filter(item => item['items'][0].cor_status === '1');
                return rst.length;
            },
            calcFuncRefundCnt() {
                let list = [];
                Object.assign(list, this.orders);
                let rst = list.filter(item => item['items'][0].cor_status === '2');
                return rst.length;
            },
            caclLeftDay: function (orderDate) {
                var tDate = new Date(orderDate);
                var nDate = new Date();
                tDate.setDate(tDate.getDate() + 60);
                var diff = tDate.getTime() - nDate.getTime();
                diff = Math.ceil(diff / (1000 * 3600 * 24));
                return diff;
            },
            caclTargetDay: function (orderDate) {
                var tDate = new Date(orderDate);
                tDate.setDate(tDate.getDate() + 60);
                return moment(tDate).format('YYYY-MM-DD HH:mm:ss');
            },
            isEmpty: function (str) {
                if (typeof str == "undefined" || str == null || str == "")
                    return true;
                else
                    return false;
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
            goPage: function (page) {
                window.location.href = '/mypage/' + page;
            },
            goTabMenu: function (menu) {
                this.ajaxOrderList().then(() => {
                    let list = [];
                    Object.assign(list, this.orders);
                    if (menu == 1) {
                        this.orders = list;
                        this.search_tabmenu_idx = 1;
                    } else if (menu == 2) {
                        let rst = list.filter(item => item['items'][0].cor_status === '0');
                        this.orders = rst;
                        this.search_tabmenu_idx = 2;
                    } else if (menu == 3) {
                        let rst = list.filter(item => item['items'][0].cor_status === '1');
                        this.orders = rst;
                        this.search_tabmenu_idx = 3;
                    } else if (menu == 4) {
                        let rst = list.filter(item => item['items'][0].cor_status === '2');
                        this.mySalesList = rst;
                        this.search_tabmenu_idx = 4;
                    }
                });
            },
            goOrderDetail: function (cor_id) {
                this.$router.push('/mybilling/' + cor_id);
            },
            prevPage: function () {
                if (this.currPage == 1) return
                this.currPage -= 1;
            },
            nextPage: function () {
                if (this.currPage == this.totalpage) return
                this.currPage += 1;
            },
            setSearchCondition: function (idx) {
                this.search_condition_active_idx = idx;
                this.goSearch();
            },
            makePageList(n) {
                return [...Array(n).keys()].map(x => x = x + 1);
            },
            paging() {
                let list = [];
                Object.assign(list, this.orders);
                if (this.orders.length == 0) {
                    this.totalpage = 1;
                } else {
                    this.totalpage = Math.ceil(this.orders.length / this.perPage);
                }
                return list.slice((this.currPage - 1) * this.perPage, this.currPage * this.perPage);
            },
            funcStatus(s) {
                if (s == '0') {
                    return "depositWaiting";
                } else if (s == '1') {
                    return "orderComplete";
                } else {
                    return "refundComplete";
                }
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
            checkDownType(dt, i) {
                if (dt == "Download Complete") {
                    if (i.cit_lease_license_use == "1"
                        && i.cde_quantity <= i.cde_download) {
                        return true;
                    }
                } else if (dt == "Not Download") {
                    if (i.cit_lease_license_use == "1"
                        && i.cde_quantity > i.cde_download) {
                        return true;
                    }
                    if (i.cit_lease_license_use == "1"
                        && i.cit_mastering_license_use == "1"
                        && i.cde_quantity > i.cde_download) {
                        return false;
                    }
                    if (i.cit_mastering_license_use == "1") {
                        return true;
                    }
                }
            },
            funcDownType(dt) {
                if (this.downType == dt) {
                    return;
                } else {
                    // this.ajaxOrderList().then(() => {
                    //     let list = [];
                    //     let rst = [];
                    //     Object.assign(list, this.myOrderList);
                    //     if (dt == "Download Complete") {
                    //         rst = list.filter(item => this.checkDownType(dt, item['items'][0]));
                    //     } else if (dt == "Not Download") {
                    //         rst = list.filter(item => this.checkDownType(dt, item['items'][0]));
                    //     } else {
                    //         rst = list;
                    //     }
                    //     this.downType = dt;
                    //     this.myOrderList = rst;
                    // });
                }
            },
            gocancellist() {
                this.$router.push({path: '/mycancelList'})
            },
            funcDownStatus: function (status, items) {
                if (status === 'Possible') {
                    let possCnt = 0;
                    items.forEach(item => {
                        if (item.item) {
                            if (item.item.possible_download === 1) {
                                possCnt++;
                            }
                        }
                    })
                    return possCnt;
                } else if (status === 'Impossible') {
                    let possCnt = 0;
                    items.forEach(item => {
                        if (item.item) {
                            if (item.item.possible_download === 0) {
                                possCnt++;
                            }
                        }
                    })
                    return possCnt;
                } /* else if (status === 'Expired') {
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
                } */
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
            cor_status: function (val) {
                this.fetchData();
            }
        }
    }
</script>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .sub .sublist .row {
        margin-bottom: 0;
    }
    .sub .sublist .tab {
        align-items: center;
        background-color: #2B2C30;
        border-bottom: none;
        >div {
            flex: 1;
            text-align: center;
            font-size: 12px;
            line-height: 14px;
            color: rgb(white,.7);
            padding: 0 20px;
            &.active {
                color: #ffda2a;
            }
        }
    }
    .sub .playList .playList__item .index {
        color: rgba(white,.7);
    }
    .sublist .sort {
        >div {
            +div {
                margin-left: 10px;
            }
        }
    }
    .playList .playList__item {
        display: block;
    }
    .sub .playList .playList__item {
        .status {
            font-weight: 600;
        }
        .download {
            >div {
                font-size: 12px;
            }
        }
    }
    .sub .search.condition {
        width: 100%;
        .filter {
            display: flex;
        }
    }
</style>