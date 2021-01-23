<template>
    <div class="sublist__content" style="margin-bottom:100px;">

        <div class="row" style="margin-bottom:10px;">
            <div class="search condition" style="margin-bottom:10px;">
                <div class="filter">
                    <div class="condition" :class="{ 'active': period === -1 }"
                         @click="period = -1">{{ $t('all') }}
                    </div>
                    <div class="condition" :class="{ 'active': period === 3 }"
                         @click="period = 3">{{ $t('months3') }}
                    </div>
                    <div class="condition" :class="{ 'active': period === 6 }"
                         @click="period = 6">{{ $t('months6') }}
                    </div>
                    <div class="condition" :class="{ 'active': period === 12 }"
                         @click="period = 12">{{ $t('year1') }}
                    </div>
                </div>
            </div>
            <div style="margin-bottom:10px;">
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
                <!--
                <div>
                    <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
                        <input type="date" :placeholder="$t('startDate')" @change="goStartDate"/>
                        <span>─</span>
                        <input type="date" :placeholder="$t('endDate')" @change="goEndDate"/>
                        <button><img src="/assets/images/icon/calendar-white.png" /></button>
                    </div>
                </div>
                -->
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="main__media board inquirylist">
                <div class="tab">
                    <div class="splitboard">
                        <div class="green">{{ formatPr('allat', waiting_funds) }} <br/>{{ formatPr('paypal', waiting_funds_d) }}
                            <span>{{ $t('waitingDeposit') }}</span>
                        </div>
                        <div class="blue">{{ formatPr('allat', order_funds) }} <br/>{{ formatPr('paypal', order_funds_d) }}
                            <span>{{ $t('orderComplete') }}</span>
                        </div>
                        <div class="red">{{ formatPr('allat', refunds) }} <br/>{{ formatPr('paypal', refunds_d) }}
                            <span>{{ $t('refundComplete') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 30px; margin-bottom: 10px;">

            <div class="n-flex sort">
                <div class="custom-select" style="flex: 3; margin-right: 10px;">
                    <button class="selected-option">
                        {{ $t(downType) }}
                    </button>
                    <div class="options">
                        <button class="option" @click="downType = 'total1'; is_download = ''"> {{$t('total1')}}</button>
                        <button class="option" @click="downType = 'downloadComplete'; is_download = '1'">
                            {{$t('downloadComplete')}}
                        </button>
                        <button class="option" @click="downType = 'notDownloaded'; is_download = '0'">
                            {{$t('notDownloaded')}}
                        </button>
                    </div>
                </div>

                <div class="custom-select" style="flex: 2; min-width:max-content;">
                    <button class="selected-option">
                        {{ $t(orderType) }}
                    </button>
                    <div class="options">
                        <button class="option" @click="funcOrderType('recent', 'desc')"> {{$t('recent')}}</button>
                        <button class="option" @click="funcOrderType('past', 'asc')"> {{$t('past')}}</button>
                    </div>
                </div>
            </div>

            <div class="tabmenu">
                <div :class="{ 'active': status === '' }" @click="goTabMenu('')">{{ $t('total1') }}
                    ({{ calcTotalCnt }})
                </div>
                <div :class="{ 'active': status === 'deposit' }" @click="goTabMenu('deposit')">{{ $t('wait') }}
                    ({{ calcWaitCnt }})
                </div>
                <div :class="{ 'active': status === 'order' }" @click="goTabMenu('order')">{{ $t('payComplete1') }}
                    ({{ calcCompleteCnt }})
                </div>
                <div :class="{ 'active': status === 'cancel' }" @click="goTabMenu('cancel')">{{ $t('refundComplete') }}
                    ({{ calcRefundCnt }})
                </div>
            </div>

        </div>

        <!-- <div class="row" style="margin-bottom:20px;">
            <div class="main__media board mybillinglist saleshistory">
                <div class="tab nowrap">
                    <div class="index">{{$t('orderNumber')}}</div>
                    <div class="date">{{$t('date')}}</div>
                    <div class="cover">{{$t('cover')}}</div>
                    <div class="product">{{$t('product')}}</div>
                    <div class="totalprice">{{$t('totalPrice')}}</div>
                    <div class="status">{{$t('status')}}</div>
                    <div class="user">{{$t('buyer')}}</div>
                    <div class="download">{{$t('expirePeriod')}}</div>
                </div>
            </div>
        </div> -->

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory">

                <ul>
                    <li v-for="(item, i) in paging()" v-bind:key="i" class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <!--<div class="index" v-html="formatCitName(item.cor_id,10)"> </div>-->

                            <div class="n-flex between">
                                <div class="index">{{ item.cor_id }}</div>
                                <div class="date"> {{ item.cor_datetime }}</div>
                            </div>

                            <div class="n-flex between">
                                <div>
                                    <div class="status">
                                        <div
                                            :class="{ 'green': item.cod_status === 'order', 'blue': item.cod_status === 'deposit', 'red': item.cod_status === 'cancel' }">
                                            {{ $t(funcStatus(item.cod_status)) }}
                                        </div>
                                    </div>
                                    <div class="subject" @click="goToDetailPage(item.cit_key)" v-html="truncate(item.cit_name,30)"></div>
                                </div>
                                <div style="white-space: nowrap;" class="totalprice"
                                     v-html="formatPr(item.cor_pg,item.total_money)"></div>
                            </div>
                            <div class="n-flex between">
                                <div class="user"> {{ item.buyer_nickname }}</div>
                                <div v-if="item.cde_title === 'STEM' && item.cod_status === 'order'" class="download">
                                    <span class="gray">{{ $t('possible') }}</span>
                                </div>
                                <div v-else-if="item.cde_title === 'LEASE' && item.cod_status === 'order'" class="download">
                                    <template v-if="item.remain_days >= 0">
                                        <span>{{ item.remain_days }} {{ $t('daysLeft') }}</span>
                                        <span class="gray">(~ {{ item.expired_date }})</span>
                                    </template>
                                    <template v-else>
                                        <span class="red">{{ $t('unavailable') }}</span>
                                    </template>
                                </div>
                                <div v-else class="download">
                                    <span class="red">{{ $t('unavailable') }}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="pagination">
                <div>
                    <button class="prev active" @click="prevPage"><img src="/assets/images/icon/chevron_prev.png"/>
                    </button>

                    <button v-for="n in makePageList(this.totalpage)" v-bind:key="n"
                            :class="{ 'active': currPage === n }" @click="currPage = n">{{ n }}
                    </button>
                    <button class="next active" @click="nextPage"><img src="/assets/images/icon/chevron_next.png"/>
                    </button>
                </div>
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
            mySalesList: [],
            search_condition_active_idx: 1,
            search_tabmenu_idx: 1,
            orderType: 'recent',
            downType: 'All',
            calcTotalCnt: 0,
            calcWaitCnt: 0,
            calcCompleteCnt: 0,
            calcRefundCnt: 0,
            start_date: '',
            end_date: '',
            totalpage: 0,
            currPage: 1,
            perPage: 10,
            waiting_funds: 0,
            waiting_funds_d: 0,
            order_funds: 0,
            order_funds_d: 0,
            refunds: 0,
            refunds_d: 0,
            currDate: new Date().toISOString().substring(0, 10),
            period: -1,
            page: 1,
            forder:'desc',
            is_download: '',
            status: ''
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

        this.start_date = '2020-01-01';
        let currentDate = new Date();
        this.end_date = currentDate.yyyymmdd();

        this.fetchData();
    },
    computed: {},
    filters: {},
    methods: {
        fetchData() {
            axios.get(`/cmall/ajax_salehistory?start_date=${this.start_date}&end_date=${this.end_date}&page=${this.page}&status=${this.status}&forder=${this.forder}&is_download=${this.is_download}`)
                .then(res => res.data)
                .then(data => {
                    this.waiting_funds = data.waiting_funds;
                    this.waiting_funds_d = data.waiting_funds_d;
                    this.order_funds = data.order_funds;
                    this.order_funds_d = data.order_funds_d;
                    this.refunds = data.refunds;
                    this.refunds_d = data.refunds_d;
                    this.calcTotalCnt = data.total_rows;
                    this.calcWaitCnt = data.deposit_rows;
                    this.calcCompleteCnt = data.order_rows;
                    this.calcRefundCnt = data.refund_rows;
                    this.mySalesList = data.sp_list;
                    if (this.mySalesList.length === 0) {
                        this.totalpage = 1;
                    } else {
                        this.totalpage = Math.ceil(this.mySalesList.length / this.perPage);
                    }
                })
                .catch(error => {
                    console.error(error);
                })
        },
        goToDetailPage(cit_key) {
            window.location.href = this.helper.langUrl(this.$i18n.locale, '/detail/' + cit_key);
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
        truncate(str, n) {
            return (str.length > n) ? str.substr(0, n-1) + '...' : str;
        },
        formatPr: function (pg, price) {
            if (pg === 'paypal') {
                return '$ ' + this.formatNumberEn(price);
            } else {
                return '₩ ' + this.formatNumber(price);
            }
        },
        formatSub: function (data, genre, bpm) {
            return data + " (" + genre + " / " + bpm + "bpm)";
        },
        isEmpty: function (str) {
            return typeof str == "undefined" || str == null || str === "";
        },
        updateSearchDate(date) {
            if (this.isEmpty(date.start) || this.isEmpty(date.end)) {
                this.goSearchDate();
                this.fetchData();
            } else {
                this.start_date = date.start
                this.end_date = date.end
                this.goSearchDate();
                this.fetchData();
            }
        },
        resetSearchDate(date) {
            this.start_date = '2020-01-01';
            let currentDate = new Date();
            this.end_date = currentDate.yyyymmdd();
            this.period = -1;
            this.goSearchDate();
            this.fetchData();
        },
        caclLeftDay: function (orderDate) {
            var tDate = new Date(orderDate);
            var nDate = new Date();
            tDate.setDate(tDate.getDate() + 60);
            var diff = Math.abs(tDate.getTime() - nDate.getTime());
            diff = Math.ceil(diff / (1000 * 3600 * 24));
            return diff;
        },
        caclTargetDay: function (orderDate) {
            var tDate = new Date(orderDate);
            tDate.setDate(tDate.getDate() + 60);
            return moment(tDate).format('YYYY-MM-DD HH:mm:ss');
        },
        goPage: function (page) {
            window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/' + page);
        },
        goSearch: function () {
            this.ajaxSalesList().then(() => {
                let list = [];
                Object.assign(list, this.mySalesList);
                if (this.search_condition_active_idx == 1) {
                    //all
                } else if (this.search_condition_active_idx == 2) {
                    let m3 = moment(new Date().getTime()).add("-3", "M");
                    let rst = list.filter(item => moment(item.cor_datetime).isAfter(m3));
                    this.mySalesList = rst;
                } else if (this.search_condition_active_idx == 3) {
                    let m6 = moment(new Date().getTime()).add("-6", "M");
                    let rst = list.filter(item => moment(item.cor_datetime).isAfter(m6));
                    this.mySalesList = rst;
                } else if (this.search_condition_active_idx == 4) {
                    let m12 = moment(new Date().getTime()).add("-1", "y");
                    let rst = list.filter(item => moment(item.cor_datetime).isAfter(m12));
                    this.mySalesList = rst;
                }
            });
        },
        goTabMenu: function (status) {
            this.status = status;
            this.fetchData();
            // this.ajaxSalesList().then(() => {
            //     let list = [];
            //     Object.assign(list, this.mySalesList);
            //     if (menu == 1) {
            //         this.mySalesList = list;
            //         this.search_tabmenu_idx = 1;
            //     } else if (menu == 2) {
            //         let rst = list.filter(item => item.cor_status === '0');
            //         this.mySalesList = rst;
            //         this.search_tabmenu_idx = 2;
            //     } else if (menu == 3) {
            //         let rst = list.filter(item => item.cor_status === '1');
            //         this.mySalesList = rst;
            //         this.search_tabmenu_idx = 3;
            //     } else if (menu == 4) {
            //         let rst = list.filter(item => item.cor_status === '2');
            //         this.mySalesList = rst;
            //         this.search_tabmenu_idx = 4;
            //     }
            // });
        },
        goStartDate: function (e) {
            console.log(e.target.value);
            this.start_date = e.target.value;
            if (this.start_date == '' || this.end_date == '') {
                return;
            } else {
                this.goSearchDate();
            }
        },
        goEndDate: function (e) {
            console.log(e.target.value);
            this.end_date = e.target.value;
            if (this.start_date == '' || this.end_date == '') {
                return;
            } else {
                this.goSearchDate();
            }
        },
        goSearchDate: function () {
            this.ajaxSalesList().then(() => {
                let list = [];
                Object.assign(list, this.mySalesList);
                if (this.isEmpty(this.start_date) || this.isEmpty(this.end_date)) {
                    this.mySalesList = list;
                } else {
                    let rst = list.filter(item => this.start_date <= item.cor_datetime.substr(0, 10)
                        && item.cor_datetime.substr(0, 10) <= this.end_date);
                    this.mySalesList = rst;
                }
            });
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
        formatNumber(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
        },
        formatNumberEn(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
        },
        makePageList(n) {
            return [...Array(n).keys()].map(x => x = x + 1);
        },
        funcStatus(s) {
            if (s === 'deposit') {
                return "depositWaiting";
            } else if (s === 'order') {
                return "orderComplete";
            } else {
                return "refundComplete";
            }
        },
        paging() {
            let list = [];
            Object.assign(list, this.mySalesList);
            if (this.mySalesList.length == 0) {
                this.totalpage = 1;
            } else {
                this.totalpage = Math.ceil(this.mySalesList.length / this.perPage);
            }
            return list.slice((this.currPage - 1) * this.perPage, this.currPage * this.perPage);
        },
        funcOrderType(od, forder) {
            if (this.orderType !== od) {
                this.orderType = od;
                this.forder = forder;
                this.fetchData();
            }
        },
        checkDownload(dt, d, q) {
            console.log(dt + ',' + d + ',' + q);
            if (dt == "Download Complete") {
                //console.log(d==q);
                if (d == q) return true;
            } else if (dt == "Not Downloaded") {
                //console.log(d<q);
                if (d < q) return true;
            } else if (dt == "All") {
                return true;
            }
            return false;
        },
        funcDownType(dt) {
            if (!this.downType === dt) {
                this.fetchData();
            }
        }
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
        is_download: function () {
            this.fetchData();
        }
    }
}
</script>

<style scoped="scoped" lang="scss">
@import '/assets/plugins/slick/slick.css';
@import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

.menu {
    transform: translate(-203px, 0)
}
</style>