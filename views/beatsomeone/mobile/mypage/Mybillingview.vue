<template>
    <div style="margin-bottom:100px;">
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <h4 class="title">{{ $t('orderDetail') }}</h4>
                <div class="n-box">
                    <div class="n-flex" style="justify-content: space-between">
                        <div>{{ $t('orderNumber') }}</div>
                        <div>{{ order.cor_id }}</div>
                    </div>
                    <div class="n-flex" style="justify-content: space-between">
                        <div>{{ $t('date') }}</div>
                        <div class="date">{{ order.cor_datetime }}</div>
                    </div>
                    <div class="n-flex" style="justify-content: space-between;">
                        <div>{{ $t('status') }}</div>
                        <div v-if="order.cor_status === '1'" class="green">
                            {{ $t('orderComplete') }}
                        </div>
                        <div v-else-if="order.cor_status === '2'" class="red">
                            {{ $t('orderCancel') }}
                        </div>
                        <div v-else>
                            {{ $t('deposit') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="title-content">
                <h4 class="title">
                    <span class="yellow">{{ orderItems.length }}</span>
                    {{ $t('orderedItems') }}
                </h4>
            </div>

            <div class="playList productList orderlist" style="margin-top:10px;">
                <ul>
                    <li
                        v-for="(item, idx) in orderItems"
                        v-bind:key="idx"
                        class="playList__itembox"
                    >
                        <div class="playList__item playList__item--title other">
                            <div class="n-flex between">
                                <div class="info">
                                    <div class="code">{{ item.item.cit_key }}</div>
                                </div>
                                <div class="edit">
                                    <div
                                        class="download_status"
                                        :class="getDownStatusColor(item.item)"
                                    >{{ $t(funcDownStatus(item.item)) }}
                                    </div>
                                </div>
                                <div class="price" style="color: white;">
                                    {{
                                        formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, order.cor_pg)
                                    }}
                                </div>
                            </div>

                            <div class="name">
                                <figure class="n-flex" style="margin-right: 0;">
                                    <div class="playList__cover">
                                        <img
                                            v-if="!item.item.cit_file_1"
                                            :src="'/assets/images/cover_default.png'"
                                            alt
                                        />
                                        <img v-else :src="'/uploads/cmallitem/' + item.item.cit_file_1" alt/>
                                        <i v-if="item.item.is_new" class="label new">N</i>
                                    </div>
                                    <figcaption class="pointer">
                                        <h3 class="playList__title"
                                            v-html="formatCitName(item.item.cit_name,50)"></h3>
                                        <div class="n-flex">
                                            <div class="listen">
                                                <div class="playbtn">
                                                    <button
                                                        class="btn-play"
                                                        @click="playAudio(item.item, $event)"
                                                        :data-action="'playAction' + item.item.cit_id "
                                                    >재생
                                                    </button>
                                                    <span class="timer"><span class="current">0:00 /</span><span
                                                        class="duration">0:00</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </figcaption>

                                    <button v-if="item.item.possible_download === 1"
                                            @click="downloadWithAxios(item.itemdetail[0])" class="btn-edit">
                                        <img src="/assets/images/icon/down.png"/>
                                    </button>
                                    <button v-else class="btn-edit unable">
                                        <img src="/assets/images/icon/down.png"/>
                                    </button>
                                </figure>
                            </div>
                            <div class="col n-option">
                                <div class="option">
                                    <div class="n-box" v-if="item.item.cit_mastering_license_use === '1'">
                                        <div>
                                            <button class="playList__item--button">
                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                                               @click.self="toggleButton"/></span>
                                                <div>
                                                    <div class="title" @click.self="toggleButton">{{ $t('lang30') }}
                                                    </div>
                                                </div>
                                            </button>
                                            <ParchaseComponent :item="item" :type="'mastering'"></ParchaseComponent>
                                        </div>
                                    </div>
                                    <div class="n-box" v-if="item.item.cit_mastering_license_use === '0' && item.item.cit_lease_license_use === '1'">
                                        <div>
                                            <button class="playList__item--button">
                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                                               @click.self="toggleButton"/></span>
                                                <div>
                                                    <div class="title" @click.self="toggleButton">{{ $t('lang23') }}
                                                    </div>
                                                </div>
                                            </button>
                                            <ParchaseComponent :item="item" :type="'basic'"></ParchaseComponent>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col genre" v-html="calcTag(item.item.hashTag)"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="title-content text-info">
                <p>{{ $t('downloadNotAvailableWhenDepositMsg') }}</p>
                <p>{{ $t('downloadAvailable60Msg') }}</p>
            </div>
        </div>

        <div class="row">
            <div class="payment_box">
                <div class="n-box">
                    <div class="n-flex between">
                        <span class="title">{{ $t('payMethod1') }}</span>
                        <div>{{ $t(order.cor_pg) }}</div>
                    </div>
                    <div class="n-flex between">
                        <span class="title">{{ $t('payMethodDetail') }}</span>
                        <div>{{ order.cor_pay_type }}</div>
                    </div>
                    <div class="n-flex between" v-if="false">
                        <span class="title">{{ $t('paySubtotal') }}</span>
                        <span>{{ totalPrice }}</span>
                    </div>
                    <div class="n-flex between" v-if="false">
                        <span class="title">{{ $t('usePoints') }}</span>
                        <span>0 P</span>
                    </div>
                    <div class="n-flex between total">
                        <span>{{ $t('payTotal') }}</span>
                        <div>{{ formatPr(order.cor_pg, order.cor_total_money) }}</div>
                    </div>
                </div>
            </div>
            <p class="desc">
                <img src="/assets/images/icon/info_blue.png"/>
                <span v-html="descNoti"></span>
            </p>
        </div>

        <div class="n-flex n-btnbox">
            <button class="btn btn--gray" @click="goPage('mybilling')">{{ $t('backToList') }}</button>
            <button v-if="order.cor_status==='1'" @click="openRequestModal" class="btn btn--submit">
                {{ $t('requestRefund') }}
            </button>
        </div>
        <main-player></main-player>
    </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import $ from "jquery";
import MainPlayer from "@/vue/common/MainPlayer";
import {EventBus} from "*/src/eventbus";
import WaveSurfer from "wavesurfer.js";
import ParchaseComponent from "./component/Parchase";

export default {
    components: {
        MainPlayer,
        ParchaseComponent,
    },
    data: function () {
        return {
            cid: "",
            no: "",
            isLogin: false,
            cor_datetime: "",
            cor_approve_datetime: "",
            cor_status: "",
            cor_pg: "",
            mem_photo: "",
            mem_usertype: "",
            mem_nickname: "",
            mem_address1: "",
            mem_type: "",
            mem_lastname: "",
            myOrderList: [],
            checkedAll: [],
            reqref: 0,
            isPlay: false,
            currentPlayId: null,
            wavesurfer: null,
            payType: "",
            totalPrice: "",
            order: {},
            descNoti: "",
            orderItems: [],
            total_refunds: 0,
            selectedCount: 0,
            description: ''
        };
    },
    mounted() {

        this.cor_id = this.$route.params.cor_id;
        axios.get(`/cmall/ajax_orderresult/${this.cor_id}`)
            .then(res => res.data)
            .then(data => {
                this.order = data.data;
                this.orderItems = data.orderdetail;
                this.orderItems.forEach(item => {
                    this.$set(item, 'is_selected', false);
                })
                this.funcDesc();
            })
            .catch(error => {
                console.error(error);
            })
    },
    created() {

    },
    methods: {
        goPage: function (page) {
            this.$router.push('/' + page);
        },
        formatCitName: function (data) {
            var rst;
            var limitLth = 50;
            if (limitLth < data.length && data.length <= limitLth * 2) {
                rst =
                    data.substring(0, limitLth) +
                    "<br>" +
                    data.substring(limitLth, limitLth * 2);
            } else if (limitLth < data.length && limitLth * 2 < data.length) {
                rst =
                    data.substring(0, limitLth) +
                    "<br>" +
                    data.substring(limitLth, limitLth * 2) +
                    "...";
            } else {
                rst = data;
            }
            return rst;
        },
        funcStatus(s) {
            if (s === "0") {
                return "depositWaiting";
            } else if (s === "1") {
                return "orderComplete";
            } else {
                return "refundComplete";
            }
        },
        getGenre(g1, g2) {
            if (this.isEmpty(g2)) {
                return g1;
            } else {
                return g1 + ", " + g2;
            }
        },
        toggleButton: function (e) {
            if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box active";
            } else if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box active"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box";
            } else {
                //
            }
        },
        formatCheck: function (o) {
            if (this.isEmpty(o)) {
                return "";
            } else {
                return 0;
            }
        },
        formatTotalPrice: function (price, simbol) {
            if (simbol === "$") {
                return (
                    "$ " +
                    Number(price).toLocaleString(undefined, {minimumFractionDigits: 2})
                );
            } else {
                return (
                    "₩ " +
                    Number(price).toLocaleString("ko-KR", {minimumFractionDigits: 0})
                );
            }
        },
        formatPrice: function (kr, en, pg) {
            if (pg === "paypal") {
                return (
                    "$ " +
                    Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
                );
            } else {
                return (
                    "₩ " +
                    Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
                );
            }
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
        playAudio(i, e) {
            if (!this.isPlay || this.currentPlayId !== i.cit_id) {
                if (this.currentPlayId !== i.cit_id) {
                    this.setAudioInstance(i);
                }
                this.currentPlayId = i.cit_id;
                EventBus.$emit("player_request_start", {
                    _uid: this._uid,
                    item: i,
                    ws: this.wavesurfer,
                });
                e.target.className = "btn-play playing";
                this.start();
            } else {
                EventBus.$emit("player_request_stop", {
                    _uid: this._uid,
                    item: i,
                    ws: this.wavesurfer,
                });
                e.target.className = "btn-play paused";
                this.stop();
            }
        },
        setAudioInstance(item) {
            if (!this.wavesurfer) {
                this.wavesurfer = WaveSurfer.create({
                    container: "#playerContainer",
                    waveColor: "#696969",
                    progressColor: "#c3ac45",
                    hideScrollbar: true,
                    height: 40,
                });
            }

            if (item.cde_id) {
                this.wavesurfer.load(`/cmallact/download_sample/${item.cde_id}`);
                //this.wavesurfer.load(`/uploads/cmallitemdetail/${item.cde_filename}`);
            }

            this.wavesurfer.on("ready", () => {
                this.wavesurfer.play();
            });
        },
        stop() {
            if (this.wavesurfer) {
                this.wavesurfer.pause();
            }
            this.isPlay = false;
        },
        start(isInit) {
            if (this.wavesurfer) {
                this.wavesurfer.play();
            }
            if (!isInit) {
                this.isPlay = true;
            }
        },
        isEmpty: function (str) {
            if (typeof str == "undefined" || str == null || str == "") return true;
            else return false;
        },
        caclLeftDay: function (orderDate) {
            var tDate = new Date(orderDate);
            var nDate = new Date();
            var diff = tDate.getTime() - nDate.getTime();
            diff = Math.ceil(diff / (1000 * 3600 * 24));
            return diff;
        },
        caclTargetDay: function (orderDate) {
            var tDate = new Date(orderDate);
            tDate.setDate(tDate.getDate() + 60);
            return moment(tDate).format("YYYY-MM-DD HH:mm:ss");
        },
        productEditBtn: function (key, status) {
            console.log("productEditBtn:" + key);
            if (status == 0) {
                return;
            } else {
                window.location.href = "/mypage/regist_item/" + key;
            }
        },
        removeReg: function (val) {
            const regExp = /[~!@#$%^&*()_+|'"<>?:{}]/;
            while (regExp.test(val)) {
                val = val.replace(regExp, "");
            }
            return val;
        },
        calcTag: function (hashTag) {
            let rst = "";
            let tags = hashTag.split(",");
            for (let i in tags) {
                rst =
                    rst +
                    "<span><button >" +
                    this.removeReg(tags[i]) +
                    "</button></span>";
            }
            return rst;
        },
        funcDownStatus: function (item) {
            if (item.possible_download === 0) {
                return "unavailable1";
            } else {
                return "downloadAvailable";
            }
        },
        getDownStatusColor: function (item) {
            if (item.possible_download === 0) {
                return "red";
            } else {
                if (item.cit_lease_license_use == "1") {
                    return "blue";
                }
                if (item.cit_lease_license_use == "1") {
                    return "green";
                }
                if (item.cit_mastering_license_use == "1") {
                    return "green";
                }
            }
        },
        funcDesc: function () {
            if (this.order.status === 'deposit') {
                this.descNoti =
                    this.$t("depositWaitingStateSupportCaseMenuMsg") +
                    " " +
                    '<a href="/mypage#/inquiry/">' +
                    this.$t("shortcut") +
                    "</a>";
            } else if (this.order.status === "order") {
                this.descNoti =
                    "If the download period has , the purchased bit cannot be downloaded";
            }
        },
        forceFileDownload(r, oriname) {
            const blob = new Blob([r.data], {type: "application/mp3"});
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = oriname;
            link.click();
            URL.revokeObjectURL(link.href);
        },
        downloadWithAxios: function (item) {
            axios({
                method: "get",
                url: `/cmallact/download/${this.cor_id}/${item.cde_id}`,
                responseType: "blob",
            })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data], {type: 'application/mp3'}));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', item.cde_originname);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => console.error(error));
        },
        openRequestModal: function () {
            this.reqref = 1;
        },
        toggleSelected: function (idx) {
            if (this.orderItems[idx].is_selected === true) {
                this.orderItems[idx].is_selected = false;
            } else {
                this.orderItems[idx].is_selected = true;
            }
        },
        setCheckAll: function () {
            if (this.checkedAll === true) {
                this.orderItems.forEach(item => {
                    item.is_selected = true;
                })
            } else {
                this.orderItems.forEach(item => {
                    item.is_selected = false;
                })
            }
        },
        submitRefund: function () {
            let formData = new FormData();
            formData.append('cor_id', this.order.cor_id);
            this.orderItems.forEach(item => {
                if (item.is_selected === true) {
                    formData.append('cod_id[]', item.itemdetail[0].cod_id);
                    formData.append('cde_id[]', item.itemdetail[0].cde_id);
                }
            });
            if (this.total_refunds > 0) {
                axios.post('/cmall/ajax_cancel', formData)
                    .then(res => res.data)
                    .then(data => {
                        this.reqref = 2;
                    })
                    .catch(error => {
                        console.error(error);
                    })
            }
        },
        submitReason: function () {
            let formData = new FormData();
            formData.append('description', this.description);
            formData.append('cor_id', this.order.cor_id);
            if (this.description !== null && this.description !== '') {
                axios.post('/cmall/ajax_refund_complete', formData)
                    .then(res => res.data)
                    .then(data => {
                        this.reqref = 0;
                        this.$router.push('/mybilling');
                    })
                    .catch(error => {
                        console.error(error);
                    })
            }
        }
    },
    watch: {
        orderItems: {
            deep: true,
            handler(val) {
                this.selectedCount = 0;
                this.total_refunds = 0;
                this.orderItems.forEach(item => {
                    if (item.is_selected === true) {
                        this.selectedCount++;
                        if (this.order.cor_memo === '$') {
                            this.total_refunds += (+item.itemdetail[0].cde_price_d);
                        } else if (this.order.cor_memo === '₩') {
                            this.total_refunds += (+item.itemdetail[0].cde_price);
                        }
                    }
                })
                this.checkedAll = this.selectedCount === this.orderItems.length;
            }
        }
    }
};
</script>

<style scoped="scoped" lang="scss">
.title-content .title {
    font-size: 14px;
    line-height: 16px;
}

.panel {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    padding: 100px 25px 200px;
    overflow-y: auto;
    background: rgba(0, 0, 0, 0.7);
    z-index: 1001;
    transition: 0.3s ease;

    &.active {
        display: block;
    }

    .popup {
        background: #1b1a1f;
        padding: 20px;
        display: none;

        &.active {
            display: block;
        }
    }
}
</style>