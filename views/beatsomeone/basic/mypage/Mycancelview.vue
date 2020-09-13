<template>
    <div>
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>Refund detail</div>
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
                        <div class="red" >{{ $t(order.status) }}
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
                        <div class="title">Method</div>
                        <div>{{$t('realtimeBankTransfer')}}</div>
                    </div>
                    <div>
                        <div class="title">Paid</div>
                        <div class="yellow">$ 27.00</div>
                    </div>
                    <div
                            style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);"
                    >
                        <div class="title">Refund request</div>
                        <div style="opacity:.7; font-weight:lighter;">0000-00-00 00:00:00</div>
                    </div>
                    <div>
                        <div class="title">Refund complete</div>
                        <div style="opacity:.7; font-weight:lighter;">0000-00-00 00:00:00</div>
                    </div>
                    <div>
                        <div class="title">Request Reason</div>
                        <div style="opacity:.7; font-weight:300;">etc</div>
                    </div>
                    <div>
                        <div style="opacity:.7; font-weight:300;">Request refund reason describtion</div>
                    </div>
                    <div
                            style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);"
                    >
                        <div class="title">Refund</div>
                        <div class="red">$ 27.00 P</div>
                    </div>
                    <div>
                        <div class="title">Refund Points</div>
                        <div class="red">300 P</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
            <button class="btn btn--gray" @click="goPage('mycancelList')">{{$t('backToList')}}</button>
        </div>
    </div>
</template>

<script>
    import ParchaseComponent from "./component/Parchase";
    import axios from "axios";

    export default {
        components: {
            ParchaseComponent,
        },
        data: function () {
            return {
                isLogin: false,
                item: {},
                order: {},
                orderItems: []
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
                    // this.funcDesc();
                })
                .catch(error => {
                    console.error(error);
                })
        },
        created() {
        },
        methods: {
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
            isEmpty: function (str) {
                if (typeof str == "undefined" || str == null || str == "") return true;
                else return false;
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
            goPage(page) {
                this.$router.push('/' + page);
            }
        },
    };
</script>

<style scoped="scoped" lang="css">
    @import "/assets/plugins/slick/slick.css";
    @import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";
</style>