<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:64px;">
                    <div @click="goPage('/seller')">Settlement Status ({{ total_current_rows }})</div>
                    <div class="active">Settlement Complete ({{ total_complete_rows }})</div>
                </div>
            </div>
        </div>

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
                <button class="btn btn--blue" style="width:200px; height:40px; margin-left:10px;" @click="setAccount">
                    <img src="/assets/images/icon/bank.png" style="margin-top:-4px;"/>Account Setting
                </button>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board mybillinglist saleshistory set_complete">
                <div class="tab nowrap">
                    <div class="index">No</div>
                    <div class="date">Date</div>
                    <div class="totalprice">Order total</div>
<!--                    <div class="totalprice">Settlement</div>-->
                    <div class="totalprice">Fee</div>
                    <div class="totalprice">Total Settlement</div>
                    <div class="status">Status</div>
                    <div class="feature">Detail</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory set_complete">

                <ul>
                    <li class="playList__itembox" v-for="(item, index) in items" :key="index">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">{{ item.cor_id }}</div>
                            <div class="date">
                                {{ item.cor_datetime }}
                            </div>
                            <div class="totalprice">{{ formatPr(item.cor_pg, item.total_money) }}</div>
<!--                            <div class="totalprice">{{ formatPr(item.cor_pg, item.csh_settle_money) }}</div>-->
                            <div class="totalprice red">{{ item.mgr_commission }} %</div>
                            <div class="totalprice">{{ formatPr(item.cor_pg, item.csh_settle_money) }}</div>
                            <div class="status">
                                <div class="green" v-if="item.csh_status === '1'">{{ $t('settleComplete') }}</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

<!--        <div class="row" style="margin-bottom:60px;">-->
<!--            <div class="pagination">-->
<!--                <div>-->
<!--                    <button class="prev active"><img src="/assets/images/icon/chevron_prev.png"/></button>-->
<!--                    <button class="active">1</button>-->
<!--                    <button>2</button>-->
<!--                    <button>3</button>-->
<!--                    <button>4</button>-->
<!--                    <button>5</button>-->
<!--                    <button>6</button>-->
<!--                    <button>7</button>-->
<!--                    <button>8</button>-->
<!--                    <button>9</button>-->
<!--                    <button>10</button>-->
<!--                    <button class="next active"><img src="/assets/images/icon/chevron_next.png"/></button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <AccountSettingModal v-if="isModalOpen" @dismissModal="doDismissModal" @submitModal="doSubmitModal" />
    </div>
</template>

<script>
import axios from 'axios';
import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker';
import AccountSettingModal from "./component/AccountSettingModal";

Date.prototype.yyyymmdd = function () {
    let mm = this.getMonth() + 1;
    let dd = this.getDate();

    return [this.getFullYear(), (mm > 9 ? '' : '0') + mm, (dd > 9 ? '' : '0') + dd].join('-');
}

export default {
    components: {
        VueHotelDatepicker,
        AccountSettingModal
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
            complete_pagination: '',
            isModalOpen: false,
        };
    },
    mounted() {
        this.start_date = '2020-01-01';
        let currentDate = new Date();
        this.end_date = currentDate.yyyymmdd();
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
            this.start_date = '2020-01-01';
            let currentDate = new Date();
            this.end_date = currentDate.yyyymmdd();
            this.period = -1;
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
            axios({
                method: "get",
                url: `/settlement/ajax_download_complete?start_date=${this.start_date}&end_date=${this.end_date}`,
                responseType: "blob",
            })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    let currentDate = new Date();
                    link.setAttribute('download', `settlement_complete_${currentDate.yyyymmdd()}.xls`);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => console.error(error));
        },
        setAccount() {
            let el = document.body;
            el.style.overflow = 'hidden'
            this.isModalOpen = !this.isModalOpen;
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
        doDismissModal() {
            let el = document.body;
            el.style.overflow = 'auto'
            this.isModalOpen = false;
        },
        doSubmitModal() {
            this.isModalOpen = false;
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

<style scoped="scoped" lang="css">
@import '/assets/plugins/slick/slick.css';
@import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>