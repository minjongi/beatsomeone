<template>
    <div class="order-history">
        <div class="mb-3">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:;" data-toggle="pill" data-target="#order-pane">{{$t('orderHistory')}} ({{ total_rows }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;" data-toggle="pill" data-target="#cancel-pane">Cancellation / Refund History ({{ total_refund_rows }})</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="order-pane">
                <div class="d-flex mb-3">
                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn active">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked> {{$t('all')}}
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option2" autocomplete="off"> {{$t('months3')}}
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option3" autocomplete="off"> {{$t('months6')}}
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option4" autocomplete="off"> {{$t('year1')}}
                        </label>
                    </div>
                    <div class="ml-auto">
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
                <div class="mb-3">
                </div>
                <div class="mb-3">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>{{$t('orderNumber')}}</th>
                            <th>{{$t('date')}}</th>
                            <th class="text-left">{{$t('product')}}</th>
                            <th>{{$t('totalPrice')}}</th>
                            <th>{{$t('status')}}</th>
                            <th>{{$t('download1')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in myOrderList" :key="index" @click="$router.push('/orders/' + order.cor_id)">
                            <td>{{ order.cor_id }}</td>
                            <td>{{ order.cor_datetime }}</td>
                            <td class="text-left">{{ (order.detail && order.detail.length > 0) ? formatSub(order.detail[0].item.cit_name, order.detail.length) : '' }}</td>
                            <td v-html="formatPr(order.cor_memo, order.cor_total_money)"></td>
                            <td>
                                <span :class="{ 'text-success': order.cor_status === '0', 'text-primary': order.cor_status === '1', 'text-danger': order.cor_status === '2' }">{{ $t(funcStatus(order.cor_status)) }}</span>
                            </td>
                            <td class="text-right">
                                <div v-if="0 < funcDownStatus('Possible', order)" class="download">
                                    <span class="text-success">{{$t('possible')}} {{ funcDownStatus('Possible', order) }} </span>
                                </div>
                                <div v-if="0 < funcDownStatus('Impossible', order)" class="download">
                                    <span class="text-danger">{{$t('impossible')}} {{ funcDownStatus('Impossible', order) }} </span>
                                </div>
                                <div v-if="0 < funcDownStatus('Expired', order)" class="download">
                                    <span class="text-grey">{{$t('expired')}} {{ funcDownStatus('Expired', order) }} </span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="paging mb-5" v-html="pagination">
                </div>
            </div>
            <div class="tab-pane fade" id="cancel-pane">
                Refund
            </div>
        </div>
    </div>
</template>

<script>
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker';
    import axios from "axios";
    import $ from "jquery";

    export default {
        name: "OrderList",
        components: {
            VueHotelDatepicker
        },
        data: function () {
            return {
                start_date: '',
                end_date: '',
                currDate: new Date().toISOString().substring(0, 10),
                myOrderList: [],
                total_rows: 0,
                pagination: null,
                search_field: '',
                search_keyword: '',
                total_refund_rows: 0,
            }
        },
        mounted() {
            $('.paging').on('click', 'a', this.pageClicked);
            this.fetchData();
        },
        methods: {
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
            },
            formatSub: function (data, size) {
                if (1 < size) {
                    return data + " 외 " + (size - 1) + "건";
                }
                return data;
            },
            formatPr: function (m, price) {
                if (this.isEmpty(m)) {
                    m = '';
                }
                if (m === '$') {
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
            isEmpty: function (str) {
                if (typeof str == "undefined" || str == null || str === "")
                    return true;
                else
                    return false;
            },
            funcStatus: function (s) {
                if (s === '0') {
                    return "depositWaiting";
                } else if (s === '1') {
                    return "orderComplete";
                } else {
                    return "refundComplete";
                }
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
            caclLeftDay: function (orderDate) {
                var tDate = new Date(orderDate);
                var nDate = new Date();
                tDate.setDate(tDate.getDate() + 60);
                var diff = tDate.getTime() - nDate.getTime();
                diff = Math.ceil(diff / (1000 * 3600 * 24));
                return diff;
            },
            pageClicked: function (event) {
                event.preventDefault();
                let page = $(event.target).data('ci-pagination-page');
                this.query_string = `sfield=${this.search_field}&skeyword=${this.search_keyword}&page=${page}`;
                this.fetchData(this.query_string);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .order-history {
        .nav {
            background-color: #141418;
            border: solid 1px #333640;
        }

        .nav-pills .nav-link {
            color: #b8b8b9;
            font-weight: 600;
            padding: 1rem;

            &.active {
                background-color: unset;
                color: #ffda2a;
            }
        }

        .btn-group {
            border: solid 1px #414143;
            border-radius: 30px;

            .btn {
                color: white;
                border-radius: 30px;
                margin: 5px;

                &.active {
                    background-color: #ffda2a;
                    color: black;
                }
            }
        }

        table {
            thead {
                tr {
                    th {
                        &:first-child {
                            width: 110px;
                        }

                        &:last-child {
                            width: 115px;
                        }
                    }
                }
            }
        }
    }
</style>