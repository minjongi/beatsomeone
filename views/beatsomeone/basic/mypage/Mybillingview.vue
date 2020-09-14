<template>
    <div>
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>{{$t('orderDetail')}}</div>
                </div>
            </div>
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px; justify-content:flex-start;">
                    <div>
                        <div class="title">{{$t('orderNumber')}}</div>
                        <div>{{ order.cor_id }}</div>
                    </div>
                    <div>
                        <div class="title">{{$t('date')}}</div>
                        <div>{{ order.cor_datetime }}</div>
                    </div>
                    <div>
                        <div class="title">{{$t('status')}}</div>
                        <div
                                :class="{ 'green': order.status === 'order', 'red': order.status === 'deposit' }"
                        >{{ $t(order.status) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="title-content">
                <div class="title">
                    <div>
                        <span class="yellow">{{ orderItems.length }}</span>
                        {{$t('orderedItems')}}
                    </div>
                </div>
            </div>

            <div class="playList productList orderlist" style="margin-top:10px;">
                <ul>
                    <li
                            v-for="(item, idx) in orderItems"
                            v-bind:key="idx"
                            class="playList__itembox"
                    >
                        <div class="playList__item playList__item--title other">
                            <div class="col name">
                                <figure>
                  <span class="playList__cover">
                    <img
                            v-if="!item.item.cit_file_1"
                            :src="'/assets/images/cover_default.png'"
                            alt
                    />
                    <img v-else :src="'/uploads/cmallitem/' + item.item.cit_file_1" alt/>
                    <i v-show="checkToday(order.cor_datetime)" class="label new">N</i>
                  </span>
                                    <figcaption class="pointer">
                                        <div class="info">
                                            <div class="code">{{ item.item.cit_key }}</div>
                                        </div>
                                        <h3 class="playList__title"
                                            v-html="formatCitName(item.item.cit_name,50)"></h3>
                                        <span class="playList__by">{{ item.item.mem_nickname }}</span>
                                        <span
                                                v-if="item.item.bpm > 0"
                                                class="playList__bpm"
                                        >{{ getGenre(item.item.genre, item.item.subgenre) }} | {{ item.item.bpm }}BPM</span>
                                        <span
                                                v-else
                                                class="playList__bpm"
                                        >{{ getGenre(item.item.genre, item.item.subgenre) }}</span>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="col n-option" style="height: auto;">
                                <div class="feature">
                                    <div class="listen">
                                        <div class="playbtn">
                                            <button
                                                    class="btn-play"
                                                    @click="playAudio(item.item, $event)"
                                                    :data-action="'playAction' + item.item.cit_id "
                                            >재생
                                            </button>
                                            <span class="timer">
                        <span data-v-27fa6da0 class="current">0:00 /</span>
                        <span class="duration">0:00</span>
                      </span>
                                        </div>
                                    </div>
                                    <!--
                                                      <div class="amount">
                                                          <img src="/assets/images/icon/cd.png"/><div><span>{{ item.cde_quantity }}</span> left</div>
                                    </div>-->
                                </div>

                                <!-- Option -->
                                <div class="option">
                                    <!-- BASIC LEASE LICENSE -->
                                    <!-- UNLIMITED STEMS LICENSE -->
                                    <div
                                            class="n-box"
                                            v-if="item.item.cit_lease_license_use === '1' && item.item.cit_mastering_license_use === '1' "
                                    >
                                        <div>
                                            <button class="playList__item--button">
                        <span class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/>
                        </span>
                                                <div>
                                                    <div class="title" @click.self="toggleButton">{{$t('lang23')}}</div>
                                                    <div class="detail">{{$t('lang24')}}</div>
                                                </div>
                                            </button>

                                            <ParchaseComponent :item="item" :type="'basic'"></ParchaseComponent>
                                        </div>
                                        <div
                                                class="price yellow"
                                        >{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d,
                                            order.cor_memo) }}
                                        </div>
                                    </div>
                                    <!-- BASIC LEASE LICENSE -->
                                    <!-- UNLIMITED STEMS LICENSE -->
                                    <!--
                                                      <div class="n-box" v-if="item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '1' ">
                                                          {{$t('lang30')}}
                                                          <div>
                                                              <button class="playList__item--button" >
                                                                  <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                  <div>
                                                                      <div class="title" @click.self="toggleButton">{{$t('lang30')}}</div>
                                                                      <div class="detail">{{$t('lang31')}}</div>
                                                                  </div>
                                                              </button>
                                                              <div class="option_item unlimited">
                                                                  <div> <img src="/assets/images/icon/parchase-info4.png"><span>{{$t('unlimited1')}}</span></div>
                                                                  <div> <img src="/assets/images/icon/parchase-info4.png"> <span> {{$t('unlimitedMsg1')}} </span> </div>
                                                                  <div> <img src="/assets/images/icon/parchase-info4.png"> <span> {{$t('unlimitedMsg2')}} </span> </div>
                                                              </div>
                                                          </div>
                                                          <div class="price">{{ formatPrice(item.order.Item.cde_price_2, item.order.Item.cde_price_d_2, true) }}</div>
                                    </div>-->
                                    <!-- BASIC LEASE LICENSE -->
                                    <div
                                            class="n-box"
                                            v-else-if="item.item.cit_lease_license_use === '1' && item.item.cit_mastering_license_use === '0'"
                                    >
                                        <div>
                                            <button class="playList__item--button">
                        <span class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/>
                        </span>
                                                <div>
                                                    <div class="title" @click.self="toggleButton">{{$t('lang23')}}</div>
                                                    <div class="detail">{{$t('lang24')}}</div>
                                                </div>
                                            </button>
                                            <ParchaseComponent :item="item" :type="'basic'"></ParchaseComponent>
                                        </div>
                                        <div
                                                class="price yellow"
                                        >{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d,
                                            order.cor_memo) }}
                                        </div>
                                    </div>

                                    <!-- UNLIMITED STEMS LICENSE -->
                                    <div
                                            class="n-box"
                                            v-else-if="item.item.cit_mastering_license_use === '1' && item.item.cit_lease_license_use === '0'"
                                    >
                                        <div>
                                            <button class="playList__item--button">
                        <span class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/>
                        </span>
                                                <div>
                                                    <div
                                                            class="title"
                                                            @click.self="toggleButton"
                                                    >{{$t('lang30')}}
                                                    </div>
                                                    <div class="detail">{{$t('lang31')}}</div>
                                                </div>
                                            </button>
                                            <ParchaseComponent :item="item" :type="'mastering'"></ParchaseComponent>
                                        </div>
                                        <div
                                                class="price yellow"
                                        >{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d,
                                            order.cor_memo) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col edit">
                                <button v-if="item.item.possible_download === 1" @click="downloadWithAxios(item.itemdetail[0])" class="btn-edit">
                                  <img src="/assets/images/icon/down.png"/>
                                </button>
                                <button v-else class="btn-edit unable">
                                  <img src="/assets/images/icon/down.png"/>
                                </button>
                                <div
                                        class="download_status"
                                        :class="getDownStatusColor(item.item)"
                                >{{ $t(funcDownStatus(item.item)) }}
                                </div>

                                <div
                                        v-if="item.item.download_end_date"
                                        class="download_period"
                                >
                  <span>
                    {{ caclLeftDay(item.item.download_end_date) }} {{$t('daysLeft')}}
                    <br/>
                    (~ {{ item.item.download_end_date }})
                  </span>
                                </div>
                            </div>
                            <div class="col genre" v-html="calcTag(item.item.hashTag)"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="title-content">
                <p>
                    ※- {{$t('downloadNotAvailableWhenDepositMsg')}}
                    <br/>
                    ※- {{$t('downloadAvailable60Msg')}}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="payment_box" style="padding-top:0; margin-top:0; border:0;">
                <div class="tab">
                    <div>
                        <div class="title">{{$t('payMethod1')}}</div>
                        <div>{{ order.cor_pay_type }}</div>
                    </div>
                    <div>
                        <div class="title">{{$t('payMethodDetail')}}</div>
                        <div>{{ order.cor_pg }}</div>
                    </div>
                    <div>
                        <div class="title">{{$t('paySubtotal')}}</div>
                        <div>{{ order.cor_total_money }}</div>
                    </div>
                    <div>
                        <div class="title">{{$t('usePoints')}}</div>
                        <div>0 P</div>
                    </div>
                    <div class="total">
                        <div>{{$t('payTotal')}}</div>
                        <div>{{ order.cor_memo }}{{ order.cor_total_money }}</div>
                    </div>
                </div>
            </div>
            <p class="desc">
                <img src="/assets/images/icon/info_blue.png"/>
                <span v-html="descNoti"></span>
            </p>
        </div>

        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
            <button class="btn btn--gray" @click="goPage('mybilling')">{{$t('backToList')}}</button>
            <button v-if="order.status ==='order'" @click="openRequestModal" type="submit" class="btn btn--submit">{{$t('requestRefund')}}</button>
        </div>
        <div class="panel" :class="{ 'active': reqref > 0 }" v-if="order.status === 'order'">
            <div class="popup" style="width:1110px;" :class="{ 'active': reqref === 1 }">
                <div class="box" style="padding-bottom:50px;">
                    <div class="title">Request Refund</div>
                    <div class="tab">
                        <div>
                            <div class="title">{{$t('orderNumber')}}</div>
                            <div>{{ order.cor_id }}</div>
                        </div>
                        <div>
                            <div class="title">{{$t('date')}}</div>
                            <div>{{ order.cor_datetime }}</div>
                        </div>
                        <div>
                            <div class="title">{{$t('status')}}</div>
                            <div :class="{ 'green': order.status === 'order', 'red': order.status === 'deposit' }">{{$t(order.status)}}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="title-content">
                            <div class="title">
                                <label for="checkAll" class="checkbox" style="margin-left:20px;">
                                    <input
                                            type="checkbox"
                                            hidden="hidden"
                                            id="checkAll"
                                            v-model="checkedAll"
                                            @change="setCheckAll"
                                    />
                                    <span></span>
                                    <div style="font-weight:600">{{$t('selectAll')}} ({{ selectedCount }} /{{
                                      orderItems.length }})</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="playList productList cart">
                            <ul>
                                <li class="playList__itembox" v-for="(item, idx) in orderItems" :key="idx">
                                    <div class="playList__item playList__item--title">
                                        <div class="col check">
                                            <label class="checkbox">
                                                <input type="checkbox" hidden="hidden" v-model="item.is_selected"/>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col name" style="margin-top:0">
                                            <figure>
                                                <span class="playList__cover">
                                                    <img v-if="!item.item.cit_file_1" :src="'/assets/images/cover_default.png'" alt/>
                                                    <img v-else :src="'/uploads/cmallitem/' + item.item.cit_file_1" alt/>
                                                    <i v-show="checkToday(order.cor_datetime)" class="label new">N</i>
                                                </span>
                                                <figcaption class="pointer">
                                                    <h3 class="playList__title" v-html="formatCitName(item.item.cit_name,50)"></h3>
                                                    <span v-if="item.item.bpm > 0" class="playList__by">{{ getGenre(item.item.genre, item.item.subgenre) }} | {{ item.item.bpm }}BPM</span>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class="col option">
                                            <div>
                                                <button class="option_fold">
                                                    <img src="/assets/images/icon/togglefold.png"/>
                                                </button>
                                                <div>
                                                    <div class="title">BASIC LEASE</div>
                                                    <div class="detail">{{$t('lang24')}}</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div>
                                                    <img src="/assets/images/icon/parchase-info1.png"/>
                                                    <span>{{$t('available60Days')}}</span>
                                                </div>
                                                <div>
                                                    <img src="/assets/images/icon/parchase-info2.png"/>
                                                    <span>{{$t('unableToEditArbitrarily')}}</span>
                                                </div>
                                                <div>
                                                    <img src="/assets/images/icon/parchase-info3.png"/>
                                                    <span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span>
                                                </div>
                                                <div>
                                                    <img src="/assets/images/icon/parchase-info5.png"/>
                                                    <span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col feature">
                                            <div class="price">{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, order.cor_memo) }}</div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab" style="margin-top:30px; margin-bottom:10px;">
                        <div>
                            <div class="title">Total Refund</div>
                            <div class="yellow" style="font-weight:600">{{ order.cor_memo }} {{ total_refunds }}</div>
                        </div>
                        <div>
                            <div class="title">Points to be Refunded</div>
                            <div>
                                <div class="yellow" style="font-weight:600; margin-right:10px;">0 P</div>
                                <div class="gray">
                                    (Used Point
                                    <span class="yellow">0 P</span>)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col" style="margin:0">
                        <div class="title-content" style="margin:0;">
                            <div class="title"></div>
                            <p style="margin:0">
                                - Returned points will be returned / paid depending on the number of products requested
                                for cancellation if there are any points used in ordering.
                                <br/>- In the case of a full cancellation, the return points will be returned as the
                                amount of points used for payment.
                            </p>
                        </div>
                    </div>

                    <div class="btnbox" style="text-align:center;">
                        <button
                                type="button"
                                class="btn btn--yellow"
                                style="width:208px"
                                @click="submitRefund"
                        >Request Fund
                        </button>
                    </div>
                </div>
            </div>

            <div class="popup" :class="{ 'active': reqref === 2 }" style="width:1110px;">
                <div class="box" style="padding-bottom:50px;">
                    <div class="title" style="margin-bottom:30px;">{{$t('requestRefund')}}</div>
                    <div class="row" style="margin-bottom:30px;">
                        <div class="type"></div>
                        <div class="data">
                            <div class="result">
                                <div>
                                    <img src="/assets/images/icon/check-circle.png"/>
                                </div>
                                <div>
                                    <div class="title">Your refund request has been completed.</div>
                                    <div
                                            class="desc"
                                    >Please let us know the reason for the refund and we will process it after
                                        confirmation.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="type">
                            <span>Reason *</span>
                        </div>
                        <div class="data">
                            <div class="sort" style="display:flex; margin-left:0; flex-flow:row nowrap">
                                <div class="custom-select modal-select">
                                    <button class="selected-option" style="min-width: 224px;">Select your reason
                                    </button>
                                    <div class="options">
                                        <button class="option">Selecting the wrong beat</button>
                                        <button class="option">No intention to purchase</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="type">
                            <span>Description *</span>
                        </div>
                        <div class="data">
              <textarea
                      class="firstname"
                      type="text"
                      placeholder="Write your description for refund requesting..." v-model="description"
              ></textarea>
                        </div>
                        <div></div>
                    </div>

                    <div class="btnbox" style="text-align:center;">
                        <button
                                type="button"
                                class="btn btn--yellow"
                                style="width:208px"
                                @click="submitReason"
                        >Request Complete
                        </button>
                    </div>
                </div>
            </div>
            <div id="playerContainer" class="hidden"></div>
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
                group_title: "SELLER",
                product_status: "PENDING",
                myOrderList: [],
                checkedAll: false,
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
            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function () {
                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this).find(".options").toggle();
            });

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
            async ajaxOrderList() {
                try {
                    this.isLoading = true;
                    var param = new FormData();
                    param.append("cid", JSON.stringify(this.cid));
                    const {data} = await axios.post(
                        "/beatsomeoneApi/user_order_Detail",
                        param,
                        {
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                        }
                    );
                    this.myOrderList = data.result;

                    this.cor_datetime = this.myOrderList[0].order.cor_datetime;
                    this.cor_approve_datetime = this.myOrderList[0].order.cor_approve_datetime;
                    this.cor_status = this.myOrderList[0].order.cor_status;
                    this.payType = this.$t(
                        this.formPayType(this.myOrderList[0].order.cor_pay_type)
                    );
                    this.totalPrice = this.formatTotalPrice(
                        this.order.cor_total_money,
                        this.order.cor_memo
                    );
                    this.cor_pg = this.myOrderList[0].order.cor_pg;
                } catch (err) {
                    console.log("ajaxOrderList error");
                } finally {
                    this.isLoading = false;
                }
            },
            getParam: function () {
                this.cid = window.location.hash.split("?")[1].split("&")[0].split("=")[1];
                this.no = window.location.hash.split("?")[1].split("&")[1].split("=")[1];
                // let uri = window.location.search.substring(1);
                // let params = new URLSearchParams(uri);
                // this.cid = params.get('cid');
                // this.no = params.get('n');
            },
            formPayType: function (pt) {
                if (pt == 1) {
                    return "creditCard";
                } else if (pt == 2) {
                    return "realtimeBankTransfer";
                } else {
                    return "paypal";
                }
            },
            goPage: function (page) {
                this.$router.push('/' + page);
            },
            calcSeq: function (size, i) {
                return parseInt(size) - parseInt(i);
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
                if (s == "0") {
                    return "depositWaiting";
                } else if (s == "1") {
                    return "orderComplete";
                } else {
                    return "refundComplete";
                }
            },
            checkToday: function (date) {
                const input = new Date(date);
                const today = new Date();
                return (
                    input.getDate() === today.getDate() &&
                    input.getMonth() === today.getMonth() &&
                    input.getFullYear() === today.getFullYear()
                );
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
            formatPrice: function (kr, en, simbol) {
                if (simbol == "$") {
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
                    //url: '/cmallact/download_sample/'+cde_id,
                    url: "/uploads/cmallitemdetail/" + item.cde_filename,
                    responseType: "arraybuffer",
                })
                    .then((r) => {
                        this.forceFileDownload(r, item.cde_originame);
                    })
                    .catch(() => console.log("error occurred"));
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
                        .then(data=> {
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
    @import "/assets/plugins/slick/slick.css";
    @import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

    .playList__item .n-option .n-box .price {
        color: white;
    }

    // 추가
    .playList__item.other .option .active .option_item {
        height: auto !important;
        margin-top: 20px !important;
        margin-bottom: 0 !important;
    }

    .parchase-description {
    }

    .parchase-description p {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
        font-size: 14px;
        margin-bottom: 10px;
        line-height: 20px;
    }

    .parchase-description p:last-child {
        margin-bottom: 0;
    }

    .parchase-description p i {
        -webkit-box-flex: 0;
        -ms-flex: none;
        flex: none;
        margin-right: 10px;
        width: 20px;
        text-align: center;
        line-height: 20px;
        height: 20px;
    }

    .parchase-description p {
        margin-bottom: 5px !important;
    }

  .payment_box .tab {
    display: block;

    > div {
      display: flex;
      justify-content: space-between;
      max-width: unset;

      div:not(.title) {
        text-align: right;
        margin-right: unset;
      }
    }
  }

  .custom-select.modal-select {
    .options {
      z-index: 1002;
    }
  }
</style>