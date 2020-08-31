<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:64px;">
                    <div class="active">{{$t('orderHistory')}} ({{ total_rows }})</div>
                    <div @click="gocancellist">Cancellation / Refund History(0)</div>
                </div>
            </div>
        </div>
        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="filter">
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }"
                         @click="setSearchCondition(1)">{{$t('all')}}
                    </div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }"
                         @click="setSearchCondition(2)">{{$t('months3')}}
                    </div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }"
                         @click="setSearchCondition(3)">{{$t('months6')}}
                    </div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 4 }"
                         @click="setSearchCondition(4)">{{$t('year1')}}
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
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-30">
            <div class="tabmenu">
                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">{{$t('total1')}} ({{
                    total_rows }})
                </div>
                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">{{$t('wait')}}
                    ({{calcWaitCnt}})
                </div>
                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">{{$t('payComplete1')}}
                    ({{calcCompleteCnt}})
                </div>
            </div>
            <div class="sort" style="text-align:right">
                <div class="custom-select" style="flex: 3;">
                    <button class="selected-option">
                        {{ downType }}
                    </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcDownType('All')"> {{$t('total1')}}</button>
                        <button data-value="" class="option" @click="funcDownType('Download Complete')">
                            {{$t('downloadComplete')}}
                        </button>
                        <button data-value="" class="option" @click="funcDownType('Not Downloaded')">
                            {{$t('notDownloaded')}}
                        </button>
                    </div>
                </div>

                <div class="custom-select" style="min-width:max-content;">
                    <button class="selected-option">
                        {{ orderType }}
                    </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcOrderType('Recent')"> {{$t('recent')}}</button>
                        <button data-value="" class="option" @click="funcOrderType('Past')"> {{$t('past')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:10px;">
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
        </div>
        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist">
                <ul>
                    <li v-for="(order, idx) in myOrderList" v-bind:key="idx" class="playList__itembox" @click="goOrderDetail(order.cor_id)">
                        <div class="playList__item playList__item--title nowrap pointer active">
                            <div class="order_no">{{ order.cor_id }}</div>
                            <div class="date">
                                {{ order.cor_datetime }}
                            </div>
                            <div class="subject">
                                {{ (order.detail && order.detail.length > 0) ? formatSub(order.detail[0].item.cit_name,
                                order.detail.length) : '' }}
                            </div>
                            <div class="totalprice" v-html="formatPr(order.cor_memo, order.cor_total_money)"></div>
                            <div class="status">
                                <div :class="{ 'green': order.cor_status === '0', 'blue': order.cor_status === '1', 'red': order.cor_status === '2' }">
                                    {{ $t(funcStatus(order.cor_status)) }}
                                </div>
                            </div>
                            <div class="download">
                                <div v-if="0 < funcDownStatus('Possible', order)" class="download">
                                    <span class="green">{{$t('possible')}} {{ funcDownStatus('Possible', order) }} </span>
                                </div>
                                <div v-if="0 < funcDownStatus('Impossible', order)" class="download">
                                    <span class="red">{{$t('impossible')}} {{ funcDownStatus('Impossible', order) }} </span>
                                </div>
                                <div v-if="0 < funcDownStatus('Expired', order)" class="download">
                                    <span class="gray">{{$t('expired')}} {{ funcDownStatus('Expired', order) }} </span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
        <div class="row paging" style="margin-bottom:30px;" v-html="pagination">
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import moment from "moment";
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'

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
                myOrderList: [],
                search_condition_active_idx: 1,
                search_tabmenu_idx: 1,
                orderType: 'Recent',
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
                currDate: new Date().toISOString().substring(0, 10),
                total_rows: 0,
                pagination: null
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
            $('.paging').on('click', 'a', this.pageClicked);
            this.fetchData();
        },
        created() {
            // this.ajaxOrderList().then(()=>{
            //     this.calcTotalCnt = this.calcFuncTotalCnt();
            //     this.calcWaitCnt = this.calcFuncWaitCnt();
            //     this.calcCompleteCnt = this.calcFuncCompleteCnt();
            //     this.calcRefundCnt = this.calcFuncRefundCnt();
            // });
        },
        methods: {
            async ajaxUserInfo() {
                try {
                    // this.isLoading = true;
                    // const {data} = await axios.get(
                    //     '/beatsomeoneApi/get_user_info', {}
                    // );
                    // //console.log(data);
                    // this.mem_photo = data[0].mem_photo;
                    // this.mem_usertype = data[0].mem_usertype;
                    // this.mem_nickname = data[0].mem_nickname;
                    // this.mem_address1 = data[0].mem_address1;
                    // this.mem_type = data[0].mem_type;
                    // this.mem_lastname = data[0].mem_lastname;
                    //
                    // if (this.mem_usertype == 1) {
                    //     this.group_title = "CUSTOMER";
                    // } else {
                    //     this.group_title = "SELLER";
                    // }
                } catch (err) {
                    console.log('ajaxUserInfo error');
                } finally {
                    this.isLoading = false;
                }
            },
            async ajaxOrderList() {
                try {
                    this.isLoading = true;
                    const {data} = await axios.get(
                        '/beatsomeoneApi/user_order_history', {}
                    );
                    this.myOrderList = data.sp_list.reverse();
                    if (this.myOrderList.length == 0) {
                        this.totalpage = 1;
                    } else {
                        this.totalpage = Math.ceil(this.myOrderList.length / this.perPage);
                    }
                } catch (err) {
                    console.log('ajaxOrderList error');
                } finally {
                    this.isLoading = false;
                }
            },
            formatPr: function (m, price) {
                if (this.isEmpty(m)) {
                    m = '';
                }
                if (m == '$') {
                    return m + this.formatNumberEn(price);
                } else {
                    return m + this.formatNumber(price);
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
            formatSub: function (data, size) {
                if (1 < size) {
                    return data + " 외 " + (size - 1) + "건";
                }
                return data;
            },
            calcFuncTotalCnt() {
                return this.myOrderList.length;
            },
            calcFuncWaitCnt() {
                let list = [];
                Object.assign(list, this.myOrderList);
                let rst = list.filter(item => item['items'][0].cor_status === '0');
                return rst.length;
            },
            calcFuncCompleteCnt() {
                let list = [];
                Object.assign(list, this.myOrderList);
                let rst = list.filter(item => item['items'][0].cor_status === '1');
                return rst.length;
            },
            calcFuncRefundCnt() {
                let list = [];
                Object.assign(list, this.myOrderList);
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
                    this.goSearchDate();
                } else {
                    this.start_date = date.start
                    this.end_date = date.end
                    this.goSearchDate();
                }
            },
            resetSearchDate(date) {
                this.start_date = ''
                this.end_date = ''
                this.goSearchDate();
            },
            goPage: function (page) {
                window.location.href = '/mypage/' + page;
            },
            goSearch: function () {
                this.ajaxOrderList().then(() => {
                    let list = [];
                    Object.assign(list, this.myOrderList);
                    if (this.search_condition_active_idx == 1) {
                        //all
                    } else if (this.search_condition_active_idx == 2) {
                        let m3 = moment(new Date().getTime()).add("-3", "M");
                        let rst = list.filter(item => moment(item['items'][0].cor_datetime).isAfter(m3));
                        this.myOrderList = rst;
                    } else if (this.search_condition_active_idx == 3) {
                        let m6 = moment(new Date().getTime()).add("-6", "M");
                        let rst = list.filter(item => moment(item['items'][0].cor_datetime).isAfter(m6));
                        this.myOrderList = rst;
                    } else if (this.search_condition_active_idx == 4) {
                        let m12 = moment(new Date().getTime()).add("-1", "y");
                        let rst = list.filter(item => moment(item['items'][0].cor_datetime).isAfter(m12));
                        this.myOrderList = rst;
                    }
                });
            },
            goTabMenu: function (menu) {
                this.ajaxOrderList().then(() => {
                    let list = [];
                    Object.assign(list, this.myOrderList);
                    if (menu == 1) {
                        this.myOrderList = list;
                        this.search_tabmenu_idx = 1;
                    } else if (menu == 2) {
                        let rst = list.filter(item => item['items'][0].cor_status === '0');
                        this.myOrderList = rst;
                        this.search_tabmenu_idx = 2;
                    } else if (menu == 3) {
                        let rst = list.filter(item => item['items'][0].cor_status === '1');
                        this.myOrderList = rst;
                        this.search_tabmenu_idx = 3;
                    } else if (menu == 4) {
                        let rst = list.filter(item => item['items'][0].cor_status === '2');
                        this.mySalesList = rst;
                        this.search_tabmenu_idx = 4;
                    }
                });
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
                this.ajaxOrderList().then(() => {
                    let list = [];
                    Object.assign(list, this.myOrderList);
                    if (this.isEmpty(this.start_date) || this.isEmpty(this.end_date)) {
                        this.myOrderList = list;
                    } else {
                        let rst = list.filter(item => this.start_date <= item['items'][0].cor_datetime.substr(0, 10)
                            && item['items'][0].cor_datetime.substr(0, 10) <= this.end_date);
                        this.myOrderList = rst;
                    }
                });
            },
            goOrderDetail: function (cor_id) {
                this.$router.push({path: `/mybilling/${cor_id}`});
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
                Object.assign(list, this.myOrderList);
                if (this.myOrderList.length == 0) {
                    this.totalpage = 1;
                } else {
                    this.totalpage = Math.ceil(this.myOrderList.length / this.perPage);
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
            funcOrderType(od) {
                if (this.orderType == od) {
                    return;
                } else {
                    this.orderType = od;
                    this.myOrderList.reverse();
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
                    this.ajaxOrderList().then(() => {
                        let list = [];
                        let rst = [];
                        Object.assign(list, this.myOrderList);
                        if (dt == "Download Complete") {
                            rst = list.filter(item => this.checkDownType(dt, item['items'][0]));
                        } else if (dt == "Not Download") {
                            rst = list.filter(item => this.checkDownType(dt, item['items'][0]));
                        } else {
                            rst = list;
                        }
                        this.downType = dt;
                        this.myOrderList = rst;
                    });
                }
            },
            gocancellist() {
                this.$router.push({path: '/mycancelList'})
            },
            funcDownStatus: function (status, order) {
                if (status === 'Possible') {
                    let possCnt = 0;
                    if (order.cor_status === '1') {
                        order.detail.forEach((orderDetail, idx) => {
                            if (orderDetail.item.cit_lease_license_use === '1' && 0 < this.caclLeftDay(order.cor_datetime)) {
                                possCnt += 1;
                            } else if (orderDetail.item.cit_lease_license_use === '1'
                                && orderDetail.item.cit_mastering_license_use === '1'
                                && 0 < this.caclLeftDay(order.cor_datetime)) {
                                possCnt += 1;
                            } else if (orderDetail.item.cit_lease_license_use === '0'
                                && orderDetail.item.cit_mastering_license_use === '1') {
                                possCnt += 1;
                            }
                        });
                    }
                    return possCnt;
                } else if (status === 'Impossible') {
                    let possCnt = 0;
                    if (order.cor_status != '1') {
                        possCnt += 1;
                    }
                    return possCnt;
                } else if (status === 'Expired') {
                    let possCnt = 0;
                    if (order.cor_status === '1') {
                        order.detail.forEach((orderDetail, idx) => {
                            if (orderDetail.item.cit_lease_license_use === '1'
                                && this.caclLeftDay(order.cor_datetime) <= 0) {
                                possCnt += 1;
                            } else if (orderDetail.item.cit_lease_license_use === '1'
                                && orderDetail.item.cit_mastering_license_use === '1'
                                && this.caclLeftDay(order.cor_datetime) <= 0) {
                                possCnt += 1;
                                //
                            }
                        });
                    }
                    return possCnt;
                }
            },
            pageClicked: function (event) {
                event.preventDefault();
                let page = $(event.target).data('ci-pagination-page');
                this.query_string = `sfield=${this.search_field}&skeyword=${this.search_keyword}&page=${page}`;
                this.fetchData(this.query_string);
            },
            fetchData: function (q) {
                axios.get('/cmall/ajax_orderlist?' + q)
                    .then(res => res.data)
                    .then(data => {
                        this.myOrderList = data.data.list;
                        this.total_rows = data.data.total_rows;
                        this.pagination = data.paging;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }
</script>

<style lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .select-genre .checkbox {
        font-size: 1rem;
    }

    .mybillinglist {
        .playList__item {
            .option {
                > div {
                    flex-direction: column;
                }
            }
        }
    }

    .playList__item--button {
        display: flex;
        flex-direction: row;
        color: white;
        text-align: left;
    }

    .mypage.sublist .search-date {
        min-width: 256px;
    }

    .mybillinglist .playList__item {
        > * {
            height: auto;
        }

        // 한줄표기
        > .genre {
            height: 26px;
            white-space: nowrap;
            display: inline-block;
            text-overflow: ellipsis;
            overflow: hidden;
            color: rgba(white, .3);

            span {
                color: rgba(white, .3);
            }
        }

        .order_no {
            word-break: break-all;
            width: 250px;
        }
    }

    .row {
        .vhd-container {
            height: 100%;

            .vhd-input {
                line-height: 14px;
                font-size: 14px;
                height: 100%;
                border: solid 1px #414143;
                border-radius: 4px;
            }

            .vhd-picker {
                left: unset;
                right: 0;
                margin-top: 10px;
                background-color: #2b2c30;
            }

            .vhd-calendar {
                .calendar-month-title {
                    color: white;
                }

                .calendar-date .week .day .in-date-range span {
                    color: black;
                }
            }
        }
    }
</style>