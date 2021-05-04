<template>
    <div class="sublist__content">

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div class="active">Settlement<br>Status ({{ total_stay_rows }})</div>
                    <div @click="goPage('/sellerbill')">Settlement<br>Complete ({{ total_complete_rows }})</div>
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

        <!-- <div style="margin-left:auto; ">
            <div>
                <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
                    <input type="date" :placeholder="$t('startDate')" />
                    <span>─</span>
                    <input type="date" :placeholder="$t('endDate')" />
                    <button><img src="/assets/images/icon/calendar-white.png" /></button>
                </div>
            </div>
        </div> -->
        <div class="row" style="margin-bottom: 10px;">
            <div>
                <VueHotelDatepicker
                    class="search-date"
                    format="YYYY-MM-DD"
                    :placeholder="$t('startDate') + ' ~ ' + $t('endDate')"
                    :startDate="start_date"
                    :endDate="end_date"
                    minDate="1970-01-01"
                    @update="updateSearchDate"
                    @reset="resetSearchDate"
                />
            </div>
        </div>

        <div class="row">
            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                <button class="btn btn--green"
                        style="display: flex;height: 40px;justify-content: center;align-items: center;"
                        @click="downloadExcel"><img src="/assets/images/icon/excel.png" style="margin-top:-4px;"/>Download as
                    Excel
                </button>
            </div>

            <div class="title-content" style="opacity: 0.3; font-size: 14px; padding-top: 12px;">
                <p style="line-height: 1.2; ">- The search period is based on the date and time of purchase. </p>
                <p style="margin-top: 5px; line-height: 1.2;">- You can see not only the amount of sales, but also the
                    amount of settlement that has occurred.</p>
            </div>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="playList board mybillinglist saleshistory">

                <ul>
                    <li class="playList__itembox" v-for="(item, index) in items" v-bind:key="index">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="n-flex between">
                                <div class="index">{{ item.cor_id }}</div>
                                <div class="date"> {{ item.cor_datetime }}</div>
                            </div>
                            <div class="n-flex none">
                                <div class="col name" style="width: 32px; margin-right: 16px;">
                                    <figure>
                                        <span class="playList__cover">
                                            <img v-if="item.cit_file_1" class="cover" :src="'/uploads/cmallitem/' + item.cit_file_1" :alt="item.cit_name">
                                            <img v-else class="cover" src="/assets/images/cover_default.png">
<!--                                            <i ng-if="item.isNew" class="label new">N</i>-->
                                        </span>
                                    </figure>
                                </div>
                                <div class="subject">
                                    <p style="word-break: break-all;">{{ truncate(item.cit_name, 20) }}</p>
<!--                                    <p>(HipHop / 108Bpm)</p>-->
                                </div>
                            </div>
                            <div class="n-flex">
                                <div style="flex: 1;">
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
                                    <div class="totalprice">{{ formatPr(item.cor_pg, item.total_money) }}</div>
                                </div>
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="yellow">{{ $t('settleStay') }}</span>
                                    </div>
                                    <div class="totalprice">{{ formatPr(item.cor_pg, item.csh_settle_money) }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <!-- Paganation -->
<!--        <div class="row">-->
<!--            <div class="pagination">-->
<!--                <div>-->
<!--                    <button class="prev active"><img src="/assets/images/icon/chevron_prev.png"/></button>-->
<!--                    <button class="active">1</button>-->
<!--                    <button>2</button>-->
<!--                    <button>3</button>-->
<!--                    <button>4</button>-->
<!--                    <button class="next active"><img src="/assets/images/icon/chevron_next.png"/></button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->


        <div class="row">
            <div class="payment_box">
                <div class="n-box">
                    <h4 class="title big">Settlement detail</h4>

                    <div>
                        <div class="n-flex between">
                            <span>
                                Total rental (VAT included)
                                <img src="/assets_m/images/icon/info.png"/>
                            </span>
                            <div style="display: block; text-align: right;">
                                <div>￦ {{ Number(total_lease_money).toLocaleString() }}</div>
                                <div>$ {{ Number(total_lease_money_d).toLocaleString() }}</div>
                            </div>
                        </div>
                        <div class="n-flex between">
                            <span class="subtitle">- Rent amount<img src="/assets_m/images/icon/info.png"/></span>
                            <span>{{ total_lease_amount }}</span>
                        </div>
                        <div class="n-flex between">
                            <span>Total sales (VAT included)<img src="/assets_m/images/icon/info.png"/></span>
                            <div style="display: block; text-align: right;">
                                <div>￦ {{ Number(total_stem_money).toLocaleString() }}</div>
                                <div>$ {{ Number(total_stem_money_d).toLocaleString() }}</div>
                            </div>
                        </div>
                        <div class="n-flex between">
                            <span class="subtitle">- Sales amount<img src="/assets_m/images/icon/info.png"/></span>
                            <span>{{ total_stem_amount }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="n-flex between">
                            <span>Order total (VAT Included)<img src="/assets_m/images/icon/info.png"/></span>
                            <div style="display: block; text-align: right;">
                                <div>￦ {{ Number(total_money).toLocaleString() }}</div>
                                <div>$ {{ Number(total_money_d).toLocaleString() }}</div>
                            </div>
                        </div>

                        <div class="n-flex between" v-if="false">
                            <span>VAT (10%)</span>
                            <span class="red">- {{ $t('currencySymbol') }} {{ $i18n.locale == 'ko' ? Number(total_money * 0.1).toLocaleString() : Number(total_money_d * 0.1).toLocaleString() }}</span>
                        </div>
                    </div>

                    <div v-if="false">
                        <div class="n-flex between">
                            <span>Settlement<img src="/assets_m/images/icon/info.png"/></span>
                            <span style="opacity:.7; font-weight:300;">{{ $t('currencySymbol') }} {{ $i18n.locale == 'ko' ? Number(total_money * 0.9).toLocaleString() : Number(total_money_d * 0.9).toLocaleString() }}</span>
                        </div>
                        <div class="n-flex between">
                            <span>Fee (10%)<img src="/assets_m/images/icon/info.png"/></span>
                            <span class="red">- {{ $t('currencySymbol') }} {{ $i18n.locale == 'ko' ? Number(total_money * 0.9 * 0.1).toLocaleString() : Number(total_money_d * 0.9 * 0.1).toLocaleString() }}</span>
                        </div>
                    </div>

                    <div class="n-flex between large">
                        <span>Total settlement</span>
                        <div style="display: block; text-align: right">
                            <div class="blue big">￦ {{ Number(total_settle_money).toLocaleString() }}</div>
                            <div class="blue big" style="margin-left: 0">$ {{ Number(total_settle_money_d).toLocaleString() }}</div>
                        </div>
                    </div>
                </div>

                <div class="n-box" style="margin-top: 1px;">
                    <h4 class="title">Help</h4>
                    <ul class="text">
                        <li>
                            <strong>Total rental: </strong>It means the total purchase amount of the bit registered by
                            the seller with the 'Rental' option. <span class="red">(At this time, the total is calculated as VAT included.)</span>
                        </li>
                        <li>
                            <strong>Rental amount: </strong>It refers to the number of bit purchases registered with the
                            'Rental' option.
                        </li>
                        <li>
                            <strong>Total Sales: </strong>It refers to the total purchase amount of the bits registered
                            by the seller with the ‘Sale’ option. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                        </li>
                        <li>
                            <strong>Sales volume: </strong>It means the number of purchases of the bit registered with
                            the ‘Sale’ option.
                        </li>
                        <li>
                            <strong>Total purchase: </strong>Total sum of rentals and total sales. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                        </li>
                        <li>
                            <strong>Settlement Amount: </strong>Total purchase price minus VAT.
                        </li>
                        <li>
                            <strong>Fee: </strong>A portion of the fee is deducted based on the settlement amount.
                        </li>
                        <li>
                            <strong>Total settlement: </strong>The amount of the settlement amount minus the fee.
                        </li>
                    </ul>
                </div>

            </div>
            <div class="title-content" style="padding-top: 12px; font-size: 12px; opacity: 0.3;">
                <p>
                    - Settlement will be made on the <strong>10th of the following month</strong> based on the
                    downloaded items from the 1st to the last day.<br/>
                    - If the user did not proceed with the download after purchase, <strong>both rentals and sales are
                    included in the settlement details <span>after 60 days from the purchase date</span></strong>.
                </p>
            </div>
        </div>
        <div style="margin-top: 30px;">
            <button class="btn btn--gray"> {{ $t('backToList') }}</button>
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
            bank_name: '',
            account_number: '',
            receipent: '',
            file_attach: null,
            popupActive: '',
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
        goPage(path) {
            this.$router.push(path);
        },
        truncate(str, n) {
            return (str.length > n) ? str.substr(0, n-1) + '...' : str;
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

    > div {
        flex: 1;
        text-align: center;
        font-size: 12px;
        line-height: 14px;
        color: rgb(white, .7);
        padding: 0 20px;

        &.active {
            color: #ffda2a;
        }
    }
}

.sub .playList .playList__item .index {
    color: rgba(white, .7);
}

.sublist .sort {
    > div {
        + div {
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
        > div {
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

.playList .playList__item {
    .name {
        figure .playList__cover {
            width: 32px;
            height: 32px;

            img {
                width: 100%;
            }
        }
    }

    .subject {
        font-weight: normal;
        line-height: 16px;
    }
}

.sub .playList .playList__item .subject {
    font-weight: normal;
}


.payment_box {
    .title {
        line-height: 19px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        font-size: 16px;
        border-bottom: 1px solid rgba(white, .3);
    }

    .n-box {
        > div {
            + div {
                border-top: 1px solid rgba(white, .3);
                padding-top: 20px;
            }
        }

        .n-flex {
            span {
                font-size: 12px;
                line-height: 14px;
                font-weight: 600;
                display: flex;
                align-items: center;

                img {
                    width: 16px;
                    height: 16px;
                    margin-left: 4px;
                }
            }

            .subtitle {
                font-weight: normal;
                color: rgba(white, .7);
            }

            & + .n-flex {
                margin-top: 20px;
            }

            &.large {
                span {
                    font-size: 14px;
                    line-height: 16px;
                }
            }
        }

        ul.text {
            font-size: 12px;

            li {
                line-height: 1.6;

                + li {
                    margin-top: 20px;
                }
            }
        }
    }
}
</style>