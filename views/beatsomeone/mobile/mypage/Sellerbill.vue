<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div @click="goPage('seller#/sellerlist')">Settlement Status ({{ total_current_rows }})</div>
                    <div class="active">Settlement Complete ({{ total_complete_rows }})</div>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="n-flex between filter">
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
                    @update="updateSearchDate"
                    @reset="resetSearchDate"
                />
            </div>
        </div>

        <div class="row">
            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                    <button class="btn btn--green" style="display: flex;height: 40px; margin-bottom: 10px; justify-content: center;align-items: center;" @click="downloadExcel"><img src="/assets/images/icon/excel.png" style="margin-top:-4px; margin-right: 4px;" />Download as Excel</button>
                    <button class="btn btn--blue" style="display: flex;height: 40px;justify-content: center;align-items: center;" @click="setAccount"><img src="/assets/images/icon/bank.png" style="margin-top:-4px; margin-right: 4px;" />Account Setting</button>
            </div>
            <div class="title-content">
                <div class="title"></div>
                <p style="line-height: 1.2;">- The settlement amount will be credited to the registered account.</p>
                <p style="margin-top: 5px; line-height: 1.2;">- If the account is not registered, the settlement amount will be credited to the account without additional settlement instructions.</p>
            </div>

        </div>

        <div class="row" v-if="false" style="margin-top:30px;">
            <div class="n-swiper-wrap">
                <ul class="n-swiper">
                    <li>
                        <h4>{{$t('estimatedSettlementAmount')}}</h4>
                        <div class="date">2020-08</div>
                        <div class="num blue">₩ 337,282,172 </div>
                    </li>
                    <li>
                        <h4>Earn to Account</h4>
                        <div class="date">2020-07</div>
                        <div class="num green">₩ 337,282,172 </div>
                    </li>
                    <li>
                        <h4>{{$t('estimatedSettlementAmount')}}</h4>
                        <div class="date">2020-06</div>
                        <div class="num blue">₩ 337,282,172 </div>
                    </li>
                </ul>
                <a class="slidenav-prev" href="#">
                    <img src="/assets_m/images/icon/chevron-left.png" alt="">
                </a>
                <a class="slidenav-next" href="#">
                    <img src="/assets_m/images/icon/chevron-right.png" alt="">
                </a>
                <ul class="">
                    <li><span class="dot active"></span></li>
                    <li><span class="dot"></span></li>
                    <li><span class="dot"></span></li>
                </ul>
            </div>
        </div>

        <div class="row payment-box" v-if="false">
            <h4 class="title">Last Month Settlement Detail</h4>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Total Items</span>
                    <span>10</span>
                </div>
                <div class="n-flex between">
                    <span>Earn to Account</span>
                    <span class="green">7</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement Complete</span>
                    <span class="blue">3</span>
                </div>
            </div>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Order total</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Fee</span>
                    <span class="red">- $ 10.00</span>
                </div>
            </div>
            <div class="n-box total">
                <div class="n-flex between">
                    <span>Profit</span>
                    <span class="blue">$ 396.00</span>
                </div>
            </div>
        </div>

        <div class="row payment-box" v-if="false">
            <h4 class="title"> Today Settlement Detail</h4>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Total Items</span>
                    <span>10</span>
                </div>
                <div class="n-flex between">
                    <span>Earn to Account</span>
                    <span class="green">7</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement Complete</span>
                    <span class="blue">3</span>
                </div>
            </div>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Order total</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Fee</span>
                    <span class="red">- $ 10.00</span>
                </div>
            </div>
            <div class="n-box total">
                <div class="n-flex between">
                    <span>Profit</span>
                    <span class="blue">$ 396.00</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
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
            total_current_rows: 0,
            total_complete_rows: 0,
            period: -1,
            start_date: '',
            end_date: '',
            currDate: new Date().toISOString().substring(0, 10),
            items: [],
            complete_pagination: ''
        };
    },
    mounted() {
        this.getData()
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
            this.start_date = ''
            this.end_date = ''
            this.getData();
        },
        getData() {
            axios.get(`/settlement/complete_list?start_date=${this.start_date}&end_date=${this.end_date}&page=${this.page}`)
                .then(res => res.data)
                .then(data => {
                    this.items = data.list;
                    this.total_complete_rows = data.total_rows;
                    this.complete_pagination = data.paging;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        goPage(path) {
            this.$router.push(path);
        },
        downloadExcel() {

        },
        setAccount() {

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
            border-bottom: 1px solid rgba(white,.3);
        }
        .n-box {
            >div {
                +div {
                    border-top: 1px solid rgba(white,.3);
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
                    color: rgba(white,.7);
                }
                &+.n-flex {
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
                    +li {
                        margin-top: 20px;
                    }
                }
            }
        }
    }

    .n-swiper-wrap {
        margin: 30px -16px;
        height: 192px;
        width: 100vw;
        overflow: hidden;
        position: relative;
        background-color: #1b1b1e;
        [class^="slidenav"] {
            position: absolute;
            top: 50%;
            margin-top: -12px;
            img {
                opacity: .3;
                width: 24px;
            }
        }
        .slidenav-prev {
            // margin-left: 8px;
            left: 8px;
        }
        .slidenav-next {
            right: 8px;
            // margin-right: 8px;
        }
    }

    .n-swiper {
        position: relative;
        display: flex;
        width: auto;
        float: left;
        li {
            margin: 0;
            padding: 24px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100vw;
            height: 192px;

            h4 {
                height: 25px;
                font-weight: 600;
                margin-bottom: 24px;
            }
        }
        .date {
            font-size: 14px;
            line-height: 1.2;
            margin-bottom: 10px;
        }
        .num {
            font-size: 32px;
            line-height: 1.2;
        }
    }

    .payment-box {
        h4.title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 600;
        }
        .n-box {
            background-color: #1B1B1E;
            padding: 16px;
            margin-right: -16px;
            margin-left: -16px;
            &+.n-box {
                margin-top: 1px;
            }
            &.total {
                margin-top: 0;
                padding-top: 0;
                >div {
                    padding-top: 16px;
                    border-top: 1px solid rgba(white,.3);
                }
            }
            span {
                font-size: 14px;
                font-weight: 600;
                &:last-child {
                    font-weight: normal;
                }
            }
            >div {

                &+div {
                margin-top: 10px;
            }
            }
        }
    }
</style>