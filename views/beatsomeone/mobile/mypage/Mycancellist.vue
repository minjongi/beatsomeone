<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container sub cancellist-wrap">
            <div class="mypage sublist">
                <div class="wrap">
                    <div class="sublist__filter sticky">
                        <div class="row center">
                            <div class="profile">
                                <div class="portait">
                                    <img v-if="mem_photo === ''" src="/assets/images/portait.png"/>
                                    <img v-else :src="'http://dev.beatsomeone.com/uploads/member_photo/' + mem_photo" alt="">
                                </div>
                                <div class="info">
                                    <div class="group">
                                        <div class="group_title" :class="group_title">{{group_title}}</div>
                                    </div>
                                    <div class="username">
                                        {{mem_nickname}}
                                    </div>
                                    <div class="bio">
                                        Music Lover, KKOMA
                                    </div>
                                </div>
                            </div>
                            <div class="profile__footer">
                                <div class="location">
                                    <img class="site" src="/assets/images/icon/position.png"/><div>{{mem_address1}}</div>
                                </div>
                                <div class="brandshop">
                                    <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">{{ $t('goToBrandshop') }} ></a>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row menu__wraper">
                        <ul class="menu">
                            <li @click="goPage('')">{{$t('dashboard')}}</li>
                            <li @click="goPage('profilemod')">{{$t('manageInformation')}}</li>
                            <li @click="goPage('list_item')">{{$t('productList')}}</li>
                            <li class="active">{{$t('orderHistory')}}</li>
                            <li @click="goPage('regist_item')" v-show="group_title == 'SELLER'">{{$t('registrationOfBeat')}}</li>
                            <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">{{$t('salesHistory')}}</li>
                            <li @click="goPage('seller')" v-show="group_title == 'SELLER'">{{$t('settlementHistory')}}</li>
                            <li @click="goPage('message')">{{$t('chat')}}</li>
                            <li @click="goPage('sellerreg')" v-show="group_title == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
                            <li @click="goPage('inquiry')">{{$t('support1')}}
                                <ul class="menu">
                                    <li @click="goPage('inquiry')">{{$t('supportCase')}}</li>
                                    <li @click="goPage('faq')">FAQ</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="sublist__content">
                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board inquirylist">
                                <div class="tab n-flex" style="height:48px;">
                                    <div @click="goPage('mybilling')">{{$t('orderHistory')}} (123)</div>
                                    <div class="active">Cancellation / Refund History(32)</div>
                                </div>
                            </div>
                        </div>


                        <div class="row" style="display:flex; margin-bottom:10px;">
                            <div class="search condition">
                                <div class="n-flex between filter">
                                    <div class="condition active" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">All</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">3 months</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">6 months</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">1 year</div>
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
                            
                        <div class="row" style="margin-bottom:30px;">
                            <div class="sort">
                                <div class="custom-select">
                                    <button class="selected-option">
                                        Recent
                                    </button>
                                    <div class="options">
                                        <button data-value="" class="option"> Past </button>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="tabmenu">
                                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">Total ({{calcTotalCnt}})</div>
                                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">Wait ({{calcWaitCnt}})</div>
                                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">Complete ({{calcCompleteCnt}})</div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:30px;">
                            <div class="playList board mybillinglist">

                                <ul>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="red">Refund Complete</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="row" style="margin-bottom:30px;">
                            <div class="pagination">
                                <div>
                                    <button class="prev active"><img src="/assets/images/icon/chevron_prev.png"/></button>
                                    <button class="active">1</button>
                                    <button>2</button>
                                    <button>3</button>
                                    <button>4</button>
                                    <button class="next active"><img src="/assets/images/icon/chevron_next.png"/></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--
        <div id="waveform" ></div>
        <main-player></main-player>
        -->
        <Footer/>
    </div>

</template>


<script>
    require('@/assets_m/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    //import MainPlayer from "@/vue/common/MainPlayer";
    import WaveSurfer from 'wavesurfer.js';
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'

    export default {
        components: {
            Header, Footer, VueHotelDatepicker
        },
        data: function() {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                popup_filter:0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
            };
        },
        mounted(){
                        // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function() {

                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this)
                    .find(".options")
                    .toggle();
            });
        },
        created() {
                Http.get('/beatsomeoneApi/get_user_regist_item_list').then(r => {
                    console.log(r.data);
                    this.myProduct_list = r.data;
                });
        },
        methods:{
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            calcSeq: function(size, i){
                return parseInt(size) - parseInt(i);
            },
            formatCitName: function(data){
                var rst;
                var limitLth = 50
                if(limitLth < data.length && data.length <= limitLth*2){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2);
                }else if(limitLth < data.length && limitLth*2 < data.length){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2) + '...';
                }else{
                    rst = data
                }
                return rst;
            },
            productEditBtn: function(key){
                console.log("productEditBtn:" +key);
                window.location.href = 'http://dev.beatsomeone.com/beatsomeone/detail/'+key;
            },
            playAudio(i) {
                this.wavesurfer = WaveSurfer.create({
                    container: document.querySelector('#waveform'),
                });
                // https://nachwon.github.io/waveform/
                this.wavesurfer.load('http://dev.beatsomeone.com/uploads/cmallitemdetail/2020/04/cb40bdf9165462c6351ebd82abedb1d6.mp3');
                this.wavesurfer.on('ready', this.start);
            },
            start(){
                this.wavesurfer.play();
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';


    
</style>