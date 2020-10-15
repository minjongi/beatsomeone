<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:64px;">
                    <div class="active">Settlement Status ({{ total_stay_rows }})</div>
                    <div @click="goPage('/sellerbill')">Settlement Complete ({{ total_complete_rows }})</div>
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
        </div>

        <div class="row" style="display:flex; margin-bottom:30px;">
            <div class="title-content">
                <div class="title"></div>
                <p>
                    ※ The search period is based on the date and time of purchase. <br/>
                    ※ You can see not only the amount of sales, but also the amount of settlement that has occurred.
                </p>
            </div>
            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                <button class="btn btn--green" style="width:200px; height:40px;" @click="downloadExcel"><img
                        src="/assets/images/icon/excel.png" style="margin-top:-4px;"/>Download as Excel
                </button>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="main__media board mybillinglist saleshistory">
                <div class="tab nowrap">
                    <div class="index">No</div>
                    <div class="date">Date</div>
                    <div class="cover">Cover</div>
                    <div class="product">Product</div>
                    <div class="totalprice">Total price</div>
                    <div class="status">Order Status</div>
                    <div class="totalprice">Settlement</div>
                    <div class="status" style="padding:0">Settlement<br/>Status</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory">

                <ul>
                    <li class="playList__itembox" v-for="(item, index) in items" v-bind:key="index">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">{{ item.cor_id }}</div>
                            <div class="date">
                                {{ item.cor_datetime }}
                            </div>
                            <div class="col name">
                                <figure style="min-width: unset;">
                                    <span class="playList__cover">
                                        <img v-if="item.cit_file_1" class="cover" :src="'/uploads/cmallitem/' + item.cit_file_1" alt="">
                                        <img v-else class="cover" src="/assets/images/cover_default.png">
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">{{ truncate(item.cit_name, 25) }}</div>
                            <div class="totalprice">{{ formatPr(item.cor_pg, item.total_money) }}</div>
                            <div class="status">
                                <div v-if="item.cod_status === 'order'" class="green">
                                    {{ $t('orderComplete')}}
                                </div>
                                <div v-else-if="item.cod_status === 'deposit'" class="yellow">
                                    {{ $t('deposit')}}
                                </div>
                                <div v-else-if="item.cod_status === 'cancel'" class="red">
                                    {{ $t('orderCancel')}}
                                </div>
                            </div>
                            <div class="totalprice">{{ formatPr(item.cor_pg, item.csh_settle_money) }}</div>
                            <div class="status">
                                <span class="yellow">{{ $t('settleStay') }}</span>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row" style="margin-bottom:60px;">
            <div class="paging" v-html="pagination">
            </div>
        </div>

        <div class="row">
            <div class="payment_box" style="display: block; padding-top:0; padding-bottom:10px; margin-top:0; border:0;">
                <div class="tab row" style="display: flex">
                    <div style="width: 50%;">
                        <div style="max-width: unset;">
                            <div class="title big">Settlement detail</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3); justify-content: space-between; max-width: unset;">
                            <div class="title">Total rental (VAT included)</div>
                            <div style="display: block;">
                                <div>￦ {{ Number(total_lease_money).toLocaleString() }}</div>
                                <div style="margin-left: 0;">$ {{ Number(total_lease_money_d).toLocaleString() }}</div>
                            </div>
                        </div>
                        <div style="justify-content: space-between; max-width: unset; margin-bottom: 15px;">
                            <div class="subtitle">- Rent amount</div>
                            <div>{{ total_lease_amount }}</div>
                        </div>
                        <div style="justify-content: space-between; max-width: unset;">
                            <div class="title">Total sales (VAT included)</div>
                            <div style="display: block;">
                                <div>￦ {{ Number(total_stem_money).toLocaleString() }}</div>
                                <div style="margin-left: 0;">$ {{ Number(total_stem_money_d).toLocaleString() }}</div>
                            </div>
                        </div>
                        <div style="justify-content: space-between; max-width: unset;">
                            <div class="subtitle">- Sales amount</div>
                            <div>{{ total_stem_amount }}</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3); justify-content: space-between; max-width: unset;">
                            <div class="title">Order total (VAT Included)</div>
                            <div style="display: block;">
                                <div>￦ {{ Number(total_money).toLocaleString() }}</div>
                                <div style="margin-left: 0;">$ {{ Number(total_money_d).toLocaleString() }}</div>
                            </div>
                        </div>
                        <div style="justify-content: space-between; max-width: unset;" v-if="false">
                            <div class="title">VAT (10%)</div>
                            <div class="red">- {{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d * 0.1).toLocaleString() : Number(total_money * 0.1).toLocaleString() }}</div>
                        </div>
                        <div v-if="false" style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3); justify-content: space-between; max-width: unset;">
                            <div class="title">Settlement</div>
                            <div style="opacity:.7; font-weight:300;">{{ $t('currencySymbol') }} {{ $i18n.locale == 'en' ? Number(total_money_d * 0.9).toLocaleString() : Number(total_money * 0.9).toLocaleString() }}</div>
                        </div>
                        <div style="justify-content: space-between; max-width: unset;">
                            <div class="title">Fee</div>
                            <div class="red">{{ mgr_commission }}%</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3); justify-content: space-between; max-width: unset;">
                            <div class="title big">Total settlement</div>
                            <div style="display: block;">
                                <div class="blue big">￦ {{ Number(total_settle_money).toLocaleString() }}</div>
                                <div class="blue big" style="margin-left: 0">$ {{ Number(total_settle_money_d).toLocaleString() }}</div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 50%;">
                        <div class="col">
                            <div class="title big">Help</div>
                            <div>
                                <ul>
                                    <li>
                                        <strong>Total rental: </strong>It means the total purchase amount of the bit
                                        registered by the seller with the 'Rental' option. <span class="red">(At this time, the total is calculated as VAT included.)</span>
                                    </li>
                                    <li>
                                        <strong>Rental amount: </strong>It refers to the number of bit purchases
                                        registered with the 'Rental' option.
                                    </li>
                                    <li>
                                        <strong>Total Sales: </strong>It refers to the total purchase amount of the bits
                                        registered by the seller with the ‘Sale’ option. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                                    </li>
                                    <li>
                                        <strong>Sales volume: </strong>It means the number of purchases of the bit
                                        registered with the ‘Sale’ option.
                                    </li>
                                    <li>
                                        <strong>Total purchase: </strong>Total sum of rentals and total sales. <span
                                            class="red">(In this case, the total is calculated as VAT included.)</span>
                                    </li>
                                    <li>
                                        <strong>Settlement Amount: </strong>Total purchase price minus VAT.
                                    </li>
                                    <li>
                                        <strong>Fee: </strong>A portion of the fee is deducted based on the settlement
                                        amount.
                                    </li>
                                    <li>
                                        <strong>Total settlement: </strong>The amount of the settlement amount minus the
                                        fee.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="title-content">
                <p>
                    - Settlement will be made on the <strong>10th of the following month</strong> based on the
                    downloaded items from the 1st to the last day.<br/>
                    - If the user did not proceed with the download after purchase, <strong>both rentals and sales are
                    included in the settlement details <span>after 60 days from the purchase date</span></strong>.
                </p>
            </div>
        </div>
        <!-- 정산내역 팝업 -->
        <div class="panel" :class="popupActive">
            <div class="popup payment_popup active">
                <div class="popup close" @click="popupActive = false">
                    <span></span>
                    <span></span>
                </div>
                <h3><span class="blue">3월</span> 정산내역</h3>
                <div class="payment_box_head">
                    <div class="n-flex">
                        <div class="n-flex between">
                            <span>정산기간</span>
                            <span>2020.03.01~2020.03.31</span>
                        </div>
                        <div class="n-flex between">
                            <span>정산일시</span>
                            <span>2020.04.10 12:00:00</span>
                        </div>
                    </div>
                </div>
                <div class="payment_box" style="display: block; padding-top:0; padding-bottom:10px; margin-top:0; border:0;">
                    <div class="tab row" style="display: flex">
                        <div style="width: 50%">
                            <div>
                                <div class="title big">Settlement detail</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title">Total rental (VAT included)</div>
                                <div>$ 120.00</div>
                            </div>
                            <div>
                                <div class="subtitle">- Rent amount</div>
                                <div>200</div>
                            </div>
                            <div>
                                <div class="title">Total sales (VAT included)</div>
                                <div>$ 120.00</div>
                            </div>
                            <div>
                                <div class="subtitle">- Sales amount</div>
                                <div>300</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title">Order total (VAT Included)</div>
                                <div>$ 440.00</div>
                            </div>
                            <div>
                                <div class="title">VAT (10%)</div>
                                <div class="red">- $ 40.00</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title">Settlement</div>
                                <div style="opacity:.7; font-weight:300;">$ 400.00</div>
                            </div>
                            <div>
                                <div class="title">Fee (10%)</div>
                                <div class="red">- $ 40.00</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title big">Total settlement</div>
                                <div class="blue big">$ 365.00</div>
                            </div>
                        </div>
                        <div style="width: 50%">
                            <div class="col">
                                <div class="title big">Help</div>
                                <div>
                                    <ul>
                                        <li>
                                            <strong>Total rental: </strong>It means the total purchase amount of the bit
                                            registered by the seller with the 'Rental' option. <span class="red">(At this time, the total is calculated as VAT included.)</span>
                                        </li>
                                        <li>
                                            <strong>Rental amount: </strong>It refers to the number of bit purchases
                                            registered with the 'Rental' option.
                                        </li>
                                        <li>
                                            <strong>Total Sales: </strong>It refers to the total purchase amount of the
                                            bits registered by the seller with the ‘Sale’ option. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                                        </li>
                                        <li>
                                            <strong>Sales volume: </strong>It means the number of purchases of the bit
                                            registered with the ‘Sale’ option.
                                        </li>
                                        <li>
                                            <strong>Total purchase: </strong>Total sum of rentals and total sales. <span
                                                class="red">(In this case, the total is calculated as VAT included.)</span>
                                        </li>
                                        <li>
                                            <strong>Settlement Amount: </strong>Total purchase price minus VAT.
                                        </li>
                                        <li>
                                            <strong>Fee: </strong>A portion of the fee is deducted based on the
                                            settlement amount.
                                        </li>
                                        <li>
                                            <strong>Total settlement: </strong>The amount of the settlement amount minus
                                            the fee.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker';
    import axios from 'axios';

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
                total_stay_rows: 0,
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
                total_stem_money: 0,
                total_stem_money_d: 0,
                total_stem_amount: 0,
                total_money: 0,
                total_money_d: 0,
                total_settle_money: 0,
                total_settle_money_d: 0,
                complete_items: [],
                complete_pagination: null,
                popupActive: '',
                mgr_commission: 0,
            };
        },
        mounted() {
            $('.paging').on('click', 'a', this.pageClicked);
            this.start_date = '2020-01-01';
            let currentDate = new Date();
            this.end_date = currentDate.yyyymmdd();
            this.getData();
        },
        created() {
        },
        methods: {
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
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
                return typeof str == "undefined" || str == null || str === "";
            },
            resetSearchDate(date) {
                this.start_date = '2020-01-01';
                let currentDate = new Date();
                this.end_date = currentDate.yyyymmdd();
                this.period = -1;
                this.getData();
            },
            getData() {
                axios.get(`/settlement?start_date=${this.start_date}&end_date=${this.end_date}&page=${this.page}`)
                    .then(res => res.data)
                    .then(data => {
                        this.items = data.list;
                        this.pagination = data.paging;
                        this.total_stay_rows = data.total_stay_rows;
                        this.total_complete_rows = data.total_complete_rows;
                        this.total_lease_money = data.total_lease_money ? data.total_lease_money : 0;
                        this.total_lease_money_d = data.total_lease_money_d ? data.total_lease_money_d : 0;
                        this.total_lease_amount = data.total_lease_amount ? data.total_lease_amount : 0;
                        this.total_stem_money = data.total_stem_money ? data.total_stem_money : 0;
                        this.total_stem_money_d = data.total_stem_money_d ? data.total_stem_money_d : 0;
                        this.total_stem_amount = data.total_stem_amount ? data.total_stem_amount : 0;
                        this.total_money = data.total_money ? data.total_money : 0;
                        this.total_money_d = data.total_money_d ? data.total_money_d : 0;
                        this.total_amount = data.total_amount ? data.total_amount : 0;
                        this.total_settle_money = data.total_settle_money ? data.total_settle_money : 0;
                        this.total_settle_money_d = data.total_settle_money_d ? data.total_settle_money_d : 0;
                        this.mgr_commission = data.mgr_commission;
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
            downloadExcel: function () {
                axios({
                    method: "get",
                    url: `/settlement/ajax_download?start_date=${this.start_date}&end_date=${this.end_date}`,
                    responseType: "blob",
                })
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        let currentDate = new Date();
                        link.setAttribute('download', `settlement_${currentDate.yyyymmdd()}.xls`);
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch((error) => console.error(error));
            },
            formatPr: function (m, price) {
                if (m === 'paypal') {
                    return '$' + this.formatNumberEn(price);
                } else if (m === 'allat') {
                    return '₩' + this.formatNumber(price);
                } else {
                    return '₩' + this.formatNumber(price);
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
            goPage(path) {
                this.$router.push(path);
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

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';


    /* 정산내역 팝업 CSS */
    .panel {
        .popup {
            &.payment_popup {
                border-radius: 8px;
                position: relative;
                background: #2B2C30;

                h3 {
                    margin-top: 40px;
                    margin-bottom: 10px;
                    padding: 0 40px;
                    font-size: 24px;
                    line-height: 28px;
                }
            }

            .close {
                position: absolute;
                opacity: 1;
                top: 22px;
                right: 22px;
                width: 12px;
                height: 12px;
                display: block;
                cursor: pointer;
                pointer-events: auto;

                span {
                    display: block;
                    position: absolute;
                    width: 17px;
                    height: 2px;
                    transform: rotate(45deg);
                    background-color: white;
                    border-radius: 2px;

                    &:last-child {
                        transform: rotate(-45deg);
                    }
                }
            }

            .payment_box_head {
                padding: 30px 40px 0px;

                h4 {
                    margin-bottom: 10px;
                    font-size: 16px;
                    font-weight: 600;
                }

                > .n-flex {
                    border-bottom: 1px solid rgba(255, 255, 255, .3);
                    padding-bottom: 30px;
                }

                .n-flex {
                    display: flex;

                    > div {
                        flex: 1;
                        padding: 0 32px;

                        &:first-child {
                            padding-left: 0;
                        }
                    }

                    &.between {
                        justify-content: space-between;
                    }

                    span {
                        font-weight: 600;
                        font-size: 16px;

                        &:last-child {
                            font-weight: normal;
                            color: rgba(white, .7);
                        }
                    }
                }

            }

            .payment_box {
                .tab {
                    background: #2B2C30;
                    border: none;
                    margin: 0;

                    > * .title + * {
                        margin-right: 0;
                        font-weight: 600;
                    }
                }
            }
        }
    }
</style>