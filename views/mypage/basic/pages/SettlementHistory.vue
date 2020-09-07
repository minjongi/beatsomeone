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
                <div class="d-flex mb-3">
                    <div class="btn-group btn-group-sm btn-group-toggle">
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
                            <th>No</th>
                            <th>{{$t('date')}}</th>
                            <th>{{ $t('cover') }}</th>
                            <th class="text-left">{{$t('product')}}</th>
                            <th>{{$t('totalPrice')}}</th>
                            <th>{{$t('status')}}</th>
                            <th>{{ $t('settlement') }}</th>
                            <th v-html="$t('settlementStatus')"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in items" v-bind:key="index">
                            <td>{{ item.cor_id }}</td>
                            <td>{{ item.cor_datetime }}</td>
                            <td><img class="img-cover" :src="'/uploads/cmallitem/' + item.cit_file_1"></td>
                            <td>{{ item.cit_name }}</td>
                            <td>{{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? item.cde_price * item.cod_count : item.cde_price_d * item.cod_count }}</td>
                            <td>
                                <span :class="{'text-warning': item.cod_status === 'order', 'text-primary': item.cod_status === 'deposit', 'text-danger': item.cod_status === 'cancel'}">{{ $t(item.cod_status) }}</span>
                            </td>
                            <td>{{ item.csh_settle_money }}</td>
                            <td>{{ item.csh_status == 0 ? $t('settleStay') : $t('settleComplete') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="paging mb-5" v-html="pagination">
                </div>
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col-6 pr-5 border-right">
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
                            <div class="col-6 pl-5">
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
                </div>
            </div>
            <div class="tab-pane fade" id="complete-pane">
                <div class="d-flex mb-3">
                    <div class="btn-group btn-group-sm btn-group-toggle">
                        <label class="btn" :class="period === -1 ? 'active' : ''">
                            <input type="radio" autocomplete="off" v-model="period" :value="-1"> {{$t('all')}}
                        </label>
                        <label class="btn" :class="period === 3 ? 'active' : ''">
                            <input type="radio" autocomplete="off" v-model="period" :value="3"> {{$t('months3')}}
                        </label>
                        <label class="btn" :class="period === 6 ? 'active' : ''">
                            <input type="radio" autocomplete="off" v-model="period" :value="6"> {{$t('months6')}}
                        </label>
                        <label class="btn" :class="period === 12 ? 'active' : ''">
                            <input type="radio" autocomplete="off" v-model="period" :value="12"> {{$t('year1')}}
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
                <div class="mb-3 d-flex">
                    <div class="ml-auto">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#account-setting"><i class="fa fa-university"></i>Account Setting</button>
                    </div>
                </div>
                <div class="mb-3">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>{{$t('date')}}</th>
                            <th>{{$t('totalPrice')}}</th>
                            <th>{{ $t('settlement') }}</th>
                            <th>Fee</th>
                            <th>{{ $t('totalSettlement') }}</th>
                            <th v-html="$t('settlementStatus')"></th>
                            <th>Detail</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in complete_items" v-bind:key="index">
                            <td>{{ item.cor_id }}</td>
                            <td>{{ item.cor_datetime }}</td>
                            <td>{{ $t('currencySymbol') }}{{ $i18n.locale === 'ko' ? item.cde_price * item.cod_count : item.cde_price_d * item.cod_count }}</td>
                            <td>{{ item.csh_settle_money }}</td>
                            <td>-{{ $t('currencySymbol') }} 0</td>
                            <td>{{ item.csh_settle_money }}</td>
                            <td>{{ item.csh_status == 0 ? $t('settleStay') : $t('settleComplete') }}</td>
                            <td><button class="btn btn-primary btn-rounded">View</button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="paging mb-5" v-html="complete_pagination">
                </div>
            </div>
        </div>
        <div class="modal fade" id="account-setting">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <h5 class="text-uppercase">Account Setting</h5>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Bank Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="bank_name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Account Number</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="account_number" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-3">Receipent</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="receipent" />
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <label class="col-form-label col-3">Copy of Account</label>
                            <div class="col-9">
                                <label class="btn btn-primary">
                                    <input type="file" class="d-none" v-on:change="fileAttached($event.target.files)" /> File Attach
                                </label>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button data-dismiss="modal" class="btn btn-default px-5 mr-3">Cancel</button>
                            <button @click="submitAccount" class="btn btn-warning px-5">Save</button>
                        </div>
                    </div>
                </div>
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
                complete_items: [],
                complete_pagination: null,
                bank_name: '',
                account_number: '',
                receipent: '',
                file_attach: null,
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

                axios.get(`/settlement/complete_list?start_date=${this.start_date}&end_date=${this.end_date}&page=${this.page}`)
                    .then(res => res.data)
                    .then(data => {
                        this.complete_items = data.list;
                        this.total_complete_rows = data.total_rows;
                        this.complete_pagination = data.paging;
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
            fileAttached: function (fileList) {
                this.file_attach = fileList[0]
            },
            submitAccount: function () {
                let formData = new FormData();
                if (!this.bank_name) {
                    return false;
                }
                if (!this.account_number) {
                    return false;
                }
                if (!this.receipent) {
                    return false;
                }
                if (!this.file_attach) {
                    return false;
                }
                formData.append('bank_name', this.bank_name);
                formData.append('account_number', this.account_number);
                formData.append('receipent', this.receipent);
                formData.append('file', this.file_attach, this.file_attach.name);

                axios.post('/settlement/save_account')
                    .then(res => res.data)
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    })
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

        .btn.btn-rounded {
            border-radius: 20px;
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
                        vertical-align: middle;

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

        .img-cover {
            width: 50px;
            height: 50px;
            border-radius: 5px;
        }
    }
</style>