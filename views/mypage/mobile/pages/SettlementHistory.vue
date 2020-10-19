<template>
    <div class="order-history">
        <div class="mb-3">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:;" data-toggle="pill" data-target="#status-pane">Settlement Status ({{ total_current_rows }})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;" data-toggle="pill" data-target="#complete-pane">Settlement Complete ({{ total_complete_rows }})</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="status-pane">
                <div class="container-fluid">
                    <div class="mb-3">
                        <div class="btn-group btn-group-sm btn-group-toggle w-100">
                            <label class="btn" :class="period === -1 ? 'active' : ''">
                                <input type="radio" id="option1" autocomplete="off" v-model="period" :value="-1"> {{$t('all')}}
                            </label>
                            <label class="btn" :class="period === 3 ? 'active' : ''">
                                <input type="radio" id="option2" autocomplete="off" v-model="period" :value="3"> {{$t('months3')}}
                            </label>
                            <label class="btn" :class="period === 6 ? 'active' : ''">
                                <input type="radio" id="option3" autocomplete="off" v-model="period" :value="6"> {{$t('months6')}}
                            </label>
                            <label class="btn" :class="period === 12 ? 'active' : ''">
                                <input type="radio" id="option4" autocomplete="off" v-model="period" :value="12"> {{$t('year1')}}
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
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
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(item, index) in items" v-bind:key="index">
                            <div class="d-flex text-secondary mb-2">
                                <div>{{ item.cor_id }}</div>
                                <div class="ml-auto">{{ item.cor_datetime }}</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <img class="img-cover" :src="'/uploads/cmallitem/' + item.cit_file_1">
                                <div class="ml-2">{{ item.cit_name }}</div>
                            </div>
                            <div class="row">
                                <span class="col" :class="{'text-warning': item.cod_status === 'order', 'text-primary': item.cod_status === 'deposit', 'text-danger': item.cod_status === 'cancel'}">{{ $t(item.cod_status) }}</span>
                                <span class="col">{{ item.csh_status == 0 ? $t('settleStay') : $t('settleComplete') }}</span>
                            </div>
                            <div class="row">
                                <span class="col">{{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? item.cde_price * item.cod_count : item.cde_price_d * item.cod_count }}</span>
                                <span class="col">{{ item.csh_settle_money }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="paging mb-4" v-html="pagination">
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $t('settlementDetail') }}</h5>
                        <hr>
                        <div class="d-flex font-weight-bold mb-4">
                            <span>{{ $t('totalRental') }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_lease_money_d).toLocaleString() : Number(total_lease_money).toLocaleString() }}</span>
                        </div>
                        <div class="d-flex mb-4">
                            <span> - {{ $t('rentAmount') }}</span>
                            <span class="ml-auto">{{ total_lease_amount }}</span>
                        </div>
                        <div class="d-flex font-weight-bold mb-4">
                            <span>{{ $t('totalSales') }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_sale_money_d).toLocaleString() : Number(total_sale_money).toLocaleString() }}</span>
                        </div>
                        <div class="d-flex mb-4">
                            <span> - {{ $t('salesVolume') }}</span>
                            <span class="ml-auto">{{ total_sale_amount }}</span>
                        </div>
                        <hr>
                        <div class="d-flex font-weight-bold mb-4">
                            <span>{{ $t('orderTotal') }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d).toLocaleString() : Number(total_money).toLocaleString() }}</span>
                        </div>
                        <div class="d-flex font-weight-bold mb-4">
                            <span>{{ $t('vat', {percent: 10}) }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d * 0.1).toLocaleString() : Number(total_money * 0.1).toLocaleString() }}</span>
                        </div>
                        <hr>
                        <div class="d-flex font-weight-bold mb-4">
                            <span>{{ $t('settlement') }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d * 0.9).toLocaleString() : Number(total_money * 0.9).toLocaleString() }}</span>
                        </div>
                        <div class="d-flex font-weight-bold mb-4">
                            <span>{{ $t('fee', {percent: 10}) }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d * 0.9 * 0.1).toLocaleString() : Number(total_money * 0.9 * 0.1).toLocaleString() }}</span>
                        </div>
                        <hr>
                        <div class="d-flex font-weight-bold mb-4">
                            <span class="h5">{{ $t('totalSettlement') }}</span>
                            <span class="ml-auto">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d * 0.9 * 0.9).toLocaleString() : Number(total_money * 0.9 * 0.9).toLocaleString() }}</span>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4">{{ $t('help') }}</h5>
                        <div v-html="$t('totalRentalHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('rentalAmountHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('totalSalesHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('salesVolumeHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('totalPurchaseHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('settlementAmountHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('feeHelp')" class="mb-3">
                        </div>
                        <div v-html="$t('totalSettlementHelp')" class="mb-3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="complete-pane">
                Refund
            </div>
        </div>
    </div>
</template>

<script>
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker';
    import axios from 'axios';
    import $ from "jquery";

    Date.prototype.yyyymmdd = function () {
        let mm = this.getMonth() + 1;
        let dd = this.getDate();

        return [this.getFullYear(), (mm > 9 ? '' : '0') + mm, (dd > 9 ? '' : '0') + dd].join('-');
    }

    export default {
        name: "SettlementHistory",
        components: {
            VueHotelDatepicker
        },
        data: function () {
            return {
                total_current_rows: 0,
                total_complete_rows: 0,
                start_date: '',
                end_date: '',
                currDate: new Date().toISOString().substring(0, 10),
                pagination: null,
                search_field: '',
                search_keyword: '',
                items: [],
                period: -1,
                total_rows: 0,
                page: 1,
                total_lease_money: 0,
                total_lease_money_d: 0,
                total_lease_amount: 0,
                total_sale_money: 0,
                total_sale_money_d: 0,
                total_sale_amount: 0,
                total_money: 0,
                total_money_d: 0,
            }
        },
        mounted() {
            $('.paging').on('click', 'a', this.pageClicked);
            this.getData();
        },
        methods: {
            updateSearchDate(date) {
                if (this.isEmpty(date.start) || this.isEmpty(date.end)) {
                    this.getData();
                } else {
                    this.start_date = date.start
                    this.end_date = date.end
                    this.getData();
                }
            },
            isEmpty: function (str) {
                if (typeof str == "undefined" || str == null || str == "") return true;
                else return false;
            },
            resetSearchDate(date) {
                this.start_date = ''
                this.end_date = ''
                this.getData();
            },
            getData() {
                axios.get(`/settlement?start_date=${this.start_date}&end_date=${this.end_date}&page=${this.page}`)
                    .then(res => res.data)
                    .then(data => {
                        this.items = data.list;
                        this.total_current_rows = data.total_rows;
                        this.pagination = data.paging;
                        this.total_lease_money = data.total_lease_money ? data.total_lease_money : 0;
                        this.total_lease_money_d = data.total_lease_money_d ? data.total_lease_money_d : 0;
                        this.total_lease_amount = data.total_lease_amount ? data.total_lease_amount : 0;
                        this.total_sale_money = data.total_sale_money ? data.total_sale_money : 0;
                        this.total_sale_money_d = data.total_sale_money_d ? data.total_sale_money_d : 0;
                        this.total_sale_amount = data.total_sale_amount ? data.total_sale_amount : 0;
                        this.total_money = data.total_money ? data.total_money : 0;
                        this.total_money_d = data.total_money_d ? data.total_money_d : 0;
                        this.total_amount = data.total_amount ? data.total_amount : 0;
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            pageClicked: function (event) {
                event.preventDefault();
                let page = $(event.target).data('ci-pagination-page');
                this.page = page;
                this.getData();
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
                this.getData();
            }
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

        .list-group-item {
            background-color: #1b1b1e;
            margin-bottom: 1px;

            .title {
                color: #bababb;
                font-weight: bold;
            }
        }

        .img-cover {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }

        .card {
            background-color: #1c1d23;
        }
    }
</style>