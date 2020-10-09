<template>
    <div>
        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
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
            <div style="margin-left:auto; ">
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
                <div class="tab" style="height:96px;">
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

        <div class="row" style="display:flex; margin-bottom:30px;">
            <div class="tabmenu">
                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">{{ $t('total1') }}
                    ({{ calcTotalCnt }})
                </div>
                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">{{ $t('wait') }}
                    ({{ calcWaitCnt }})
                </div>
                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">{{ $t('payComplete1') }}
                    ({{ calcCompleteCnt }})
                </div>
                <div :class="{ 'active': search_tabmenu_idx === 4 }" @click="goTabMenu(4)">{{ $t('refundComplete') }}
                    ({{ calcRefundCnt }})
                </div>
            </div>
            <div class="sort" style="text-align:right">
                <div class="custom-select">
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

                <div class="custom-select" style="min-width:max-content;">
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

        <div class="row" style="margin-bottom:10px;">
            <div class="main__media board mybillinglist saleshistory">
                <div class="tab nowrap">
                    <div class="index">{{ $t('orderNumber') }}</div>
                    <div class="date">{{ $t('saleDate') }}</div>
                    <div class="cover">{{ $t('cover') }}</div>
                    <div class="product">{{ $t('saleProduct') }}</div>
                    <div class="totalprice">{{ $t('saleTotalPrice') }}</div>
                    <div class="status">{{ $t('status') }}</div>
                    <div class="user">{{ $t('buyer') }}</div>
                    <div class="download">{{ $t('expirePeriod') }}</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory">
                <ul>
                    <li v-for="(item, i) in paging()" v-bind:key="i" class="playList__itembox"
                        :id="'slist'+ item.cor_id + item.cit_id">
                        <div class="playList__item playList__item--title nowrap active">
                            <!--<div class="index" v-html="formatCitName(item.cor_id,10)"> </div>-->
                            <div class="index">{{ item.cor_id }}</div>
                            <div class="date">
                                {{ item.cor_datetime }}
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                        <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt="">
                                        <!-- <i ng-if="item.isNew" class="label new">N</i> -->
                                    </span>
                                </figure>
                            </div>
                            <div class="subject" @click="goToDetailPage(item.cit_key)" v-html="truncate(item.cit_name,30)">
                            </div>
                            <div class="totalprice" v-html="formatPr(item.cor_pg,item.total_money)"></div>
                            <div class="status">
                                <div
                                    :class="{ 'green': item.cod_status === 'order', 'blue': item.cod_status === 'deposit', 'red': item.cod_status === 'cancel' }">
                                    {{ $t(funcStatus(item.cod_status)) }}
                                </div>
                            </div>
                            <div class="user"> {{ item.buyer_nickname }}</div>
                            <div
                                v-if="item.cor_status === '1' && item.cit_lease_license_use === '1'  && caclLeftDay(item.cor_datetime) <= 0 "
                                class="download">
                                <span class="red">{{ $t('unavailable') }}</span>
                            </div>
                            <div
                                v-else-if="item.cor_status === '1' && item.cit_lease_license_use === '1' && 0 < caclLeftDay(item.cor_datetime)"
                                class="download">
                                <span>{{ caclLeftDay(item.cor_datetime) }} {{ $t('daysLeft') }}</span>
                                <span class="gray">(~ {{ caclTargetDay(item.cor_datetime) }})</span>
                            </div>
                            <div
                                v-else-if="item.cor_status === '1' && item.cit_lease_license_use === '0' && item.cit_mastering_license_use === '1'"
                                class="download">
                                <span>{{ caclLeftDay(item.cor_datetime) }} {{ $t('daysLeft') }}</span>
                                <span class="gray">(~ {{ caclTargetDay(item.cor_datetime) }})</span>
                            </div>
                            <div v-else class="download">
                                <span class="red">{{ $t('unavailable') }}</span>
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
import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker';

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
            axios.get(`/cmall/ajax_salehistory?start_date=${this.start_date}&end_date=${this.end_date}&page=${this.page}&forder=${this.forder}&is_download=${this.is_download}`)
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
            window.location.href = '/beatsomeone/detail/' + cit_key;
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
        formatNumber(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
        },
        formatNumberEn(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
        },
        formatSub: function (data, genre, bpm) {
            return data + " (" + genre + " / " + bpm + "bpm)";
        },
        isEmpty: function (str) {
            return typeof str == "undefined" || str == null || str === "";
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
            this.start_date = '2020-01-01';
            let currentDate = new Date();
            this.end_date = currentDate.yyyymmdd();
            this.period = -1;
            this.fetchData();
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
        goPage: function (page) {
            window.location.href = '/mypage/' + page;
        },
        goSearch: function () {
            this.fetchData();
        },
        goTabMenu: function (menu) {
            this.fetchData();
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
            this.fetchData();
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
        funcStatus(s) {
            if (s == 'deposit') {
                return "depositWaiting";
            } else if (s == 'order') {
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

.sublist .col.name figure {
    min-width: auto;
}
</style>