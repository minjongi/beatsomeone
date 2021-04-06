<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:64px;">
                    <div class="active">{{ $t('orderHistory') }} ({{ total_rows }})</div>
                    <div @click="gocancellist">{{ $t('lang57') }}({{ total_cancel_rows }})</div>
                </div>
            </div>
        </div>
        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="filter">
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
        <div class="row" style="display:flex; margin-bottom:30px;">
            <div class="tabmenu">
                <div :class="{ 'active': cor_status === '' }" @click="cor_status = ''">{{ $t('total1') }}
                    ({{ total_order_rows }})
                </div>
                <div :class="{ 'active': cor_status === '0' }" @click="cor_status = '0'">{{ $t('wait') }}
                    ({{ total_deposit_rows }})
                </div>
                <div :class="{ 'active': cor_status === '1' }" @click="cor_status = '1'">{{ $t('payComplete1') }}
                    ({{ total_complete_rows }})
                </div>
            </div>
            <div class="sort" style="text-align:right">
                <div class="custom-select" style="flex: 3;">
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
                    <li v-for="(order, idx) in orders" v-bind:key="idx" class="playList__itembox"
                        @click="goOrderDetail(order['cor_id'])">
                        <div class="playList__item playList__item--title nowrap pointer active">
                            <div class="index">{{ order.cor_id }}</div>
                            <div class="date">
                                {{ order.cor_datetime }}
                            </div>
                            <div class="subject">
                                {{ formatSub(order.detail) }}
                            </div>
                            <div class="totalprice">
                                {{ formatPr(order.cor_pg, order.cor_total_money) }}
                                <template v-if="(+order.cor_point) !== 0">
                                    <br> {{ order.cor_point }} P
                                </template>
                            </div>
                            <div class="status">
                              <div v-if="order.cor_status === '1'" :class="{'green': getDownloadStatus(order) === 1, 'blue': getDownloadStatus(order) === 0}">
                                {{ $t('orderComplete')}}
                              </div>
                              <div v-else-if="order.cor_status === '2'" class="red">
                                {{ $t('orderCancel')}}
                              </div>
                              <div v-else>
                                {{ $t('deposit')}}
                              </div>
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
        <div class="row" style="margin-bottom:30px;" v-if="false">
            <div class="pagination" v-html="pagination">
<!--                <div>-->
<!--                    <button class="prev active" @click="prevPage"><img src="/assets/images/icon/chevron_prev.png"/>-->
<!--                    </button>-->
<!--                    <button v-for="n in makePageList(this.totalpage)" v-bind:key="n"-->
<!--                            :class="{ 'active': currPage === n }" @click="currPage = n">{{n}}-->
<!--                    </button>-->
<!--                    <button class="next active" @click="nextPage"><img src="/assets/images/icon/chevron_next.png"/>-->
<!--                    </button>-->
<!--                </div>-->
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
                orders: [],
                orderType: 'recent',
                downType: 'total1',
                total_rows: 0,
                total_order_rows: 0,
                total_complete_rows: 0,
                total_deposit_rows: 0,
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
                forder: 'desc',
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

            this.fetchData();
        },
        created() {
        },
        methods: {
            fetchData: function () {
                axios.get(`/cmall/ajax_orderlist?start_date=${this.start_date}&end_date=${this.end_date}&cor_status=${this.cor_status}&forder=${this.forder}&is_download=${this.is_download}`)
                    .then(res => res.data)
                    .then(data => {
                        this.orders = data.data.list;
                        this.total_rows = (+data.data.total_rows);
                        this.total_deposit_rows = (+data.data.total_deposit_rows);
                        this.total_order_rows = (+data.data.total_order_rows);
                        this.total_complete_rows = (+data.data.total_complete_rows);
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
            formatSub: function (detail) {
                let size = detail.length;
                let title = '';
                if (size > 0) {
                    if (detail[0].item) {
                        title = this.truncate(detail[0].item.cit_name, 50);
                    }
                }
                if (1 < size) {
                    return title + this.$t('lang164') + ' ' + (size - 1) + this.$t('lang162');
                } else {
                    return title;
                }
            },
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
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
                this.start_date = ''
                this.end_date = ''
                this.fetchData();
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
            funcOrderType(od, forder) {
                if (this.orderType !== od) {
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
            // funcDownType(dt) {
            //     if (this.downType === dt) {
            //
            //     } else {
            //         // this.ajaxOrderList().then(() => {
            //         //     let list = [];
            //         //     let rst = [];
            //         //     Object.assign(list, this.myOrderList);
            //         //     if (dt == "Download Complete") {
            //         //         rst = list.filter(item => this.checkDownType(dt, item['items'][0]));
            //         //     } else if (dt == "Not Download") {
            //         //         rst = list.filter(item => this.checkDownType(dt, item['items'][0]));
            //         //     } else {
            //         //         rst = list;
            //         //     }
            //         //     this.downType = dt;
            //         //     this.myOrderList = rst;
            //         // });
            //     }
            // },
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
            getDownloadStatus(order) {
                if (order.detail.length > 0) {
                    let status = 0;
                    order.detail.forEach(item => {
                        if (!!item.item && item.item.possible_refund === 0) {
                            status = 1;
                            return false;
                        }
                    })
                    return status;
                } else {
                    return 0;
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
            cor_status: function () {
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
    }
</style>