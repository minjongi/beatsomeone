<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container sub">
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
                                    <div class="location">
                                        <img class="site" src="/assets/images/icon/position.png"/><div>{{mem_address1}}</div>
                                    </div>
                                    <div class="brandshop">
                                        <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">Go to Brandshop ></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ul class="menu">
                                <li @click="goPage('')">Dashboard</li>
                                <li @click="goPage('profilemod')">Manage Information</li>
                                <li @click="goPage('list_item')">Product List</li>
                                <li @click="goPage('mybilling')">Order History</li>
                                <li class="active" v-show="group_title == 'SELLER'">Sales History</li>
                                <li @click="goPage('seller')" v-show="group_title == 'SELLER'">Settlement History</li>
                                <li @click="goPage('message')">Message</li>
                                <li v-show="group_title == 'CUSTOMER'">Seller Register</li>
                                <li @click="goPage('inquiry')">Support
                                    <ul class="menu">
                                        <li @click="goPage('inquiry')">Support Case</li>
                                        <li @click="goPage('faq')">FAQ</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="sublist__content" style="margin-bottom:100px;">

                        <div class="row" style="display:flex; margin-bottom:10px;">
                            <div class="search condition">
                                <div class="filter">
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">All</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">3 months</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">6 months</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">1 year</div>
                                </div>
                            </div>
                            <div style="margin-left:auto; ">
                                <div>
                                    <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
                                        <input type="date" placeholder="Start Date" />
                                        <span>─</span>
                                        <input type="date" placeholder="End Date" />
                                        <button><img src="/assets/images/icon/calendar-white.png" /></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board inquirylist">
                                <div class="tab" style="height:96px;">
                                    <div class="splitboard">
                                        <div class="green">
                                            ₩ 123,456
                                            <span>Waiting Deposit</span>
                                        </div>
                                        <div class="blue">₩ 93,409
                                            <span>Order Complete</span>
                                        </div>
                                        <div class="red">₩ 80,039
                                            <span>Refund Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:flex; margin-bottom:30px;">
                            <div class="tabmenu">
                                <div class="active">Total ({{calcTotalCnt}})</div>
                                <div>Wait ({{calcSellingCnt}})</div>
                                <div>Complete ({{calcPendingCnt}})</div>
                            </div>
                            <div class="sort" style="text-align:right">
                                <div class="custom-select">
                                    <button class="selected-option">
                                        All
                                    </button>
                                    <div class="options">
                                        <button data-value="" class="option"> Download Complete </button>
                                        <button data-value="" class="option"> Not Downloaded </button>
                                    </div>
                                </div>

                                <div class="custom-select" style="min-width:max-content;">
                                    <button class="selected-option">
                                        Recent
                                    </button>
                                    <div class="options">
                                        <button data-value="" class="option"> Past </button>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board mybillinglist saleshistory">
                                <div class="tab nowrap">
                                    <div class="index">No</div>
                                    <div class="date">Date</div>
                                    <div class="cover">Cover</div>
                                    <div class="product">Product</div>
                                    <div class="totalprice">Total price</div>
                                    <div class="status">Status</div>
                                    <div class="user">User</div>
                                    <div class="download">Expire period</div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:30px;">
                            <div class="playList board mybillinglist saleshistory">

                                <ul>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span class="red">Unavailable</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span>37 days left</span>
                                                <span class="gray">(~2020.06.24 12:30:34)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span class="red">Unavailable</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span>37 days left</span>
                                                <span class="gray">(~2020.06.24 12:30:34)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span class="red">Unavailable</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span>37 days left</span>
                                                <span class="gray">(~2020.06.24 12:30:34)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span class="red">Unavailable</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span>37 days left</span>
                                                <span class="gray">(~2020.06.24 12:30:34)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span class="red">Unavailable</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">Order_010</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                             <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                </figure>
                                            </div>
                                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <div class="blue">Deposit Waiting</div>
                                            </div>
                                            <div class="user">User_001</div>
                                            <div class="download">
                                                <span>37 days left</span>
                                                <span class="gray">(~2020.06.24 12:30:34)</span>
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
                                    <button>5</button>
                                    <button>6</button>
                                    <button>7</button>
                                    <button>8</button>
                                    <button>9</button>
                                    <button>10</button>
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
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    //import MainPlayer from "@/vue/common/MainPlayer";
    import WaveSurfer from 'wavesurfer.js';

    export default {
        components: {
            Header, Footer
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
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>