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
                                <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">Sales History</li>
                                <li class="active" v-show="group_title == 'SELLER'">Settlement History</li>
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

                    <div class="sublist__content">

                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board inquirylist">
                                <div class="tab" style="height:64px;">
                                    <div class="active">Settlement Status (123)</div>
                                    <div @click="goPage('seller#/sellerbill')">Settlement Complete (32)</div>
                                </div>
                            </div>
                        </div>

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

                        <div class="row" style="display:flex; margin-bottom:30px;">
                            <div class="title-content">
                                <div class="title"></div>
                                <p>
                                    ※ The search period is based on the date and time of purchase. <br/>
                                    ※ You can see not only the amount of sales, but also the amount of settlement that has occurred.
                                </p>
                            </div>
                            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                                <button class="btn btn--green" style="width:200px; height:40px;" @click="goDelete"><img src="/assets/images/icon/excel.png" style="margin-top:-4px;" />Download as Excel</button>
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
                                    <div class="status">Order Status</div>
                                    <div class="totalprice">Settlement</div>
                                    <div class="status" style="padding:0">Settlement<br/>Status</div>
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
                                                <div class="red">Refund Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="red">Refund Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="blue">Order Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="red">Refund Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="blue">Order Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="red">Refund Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="red">Refund Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="blue">Order Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="red">Refund Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
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
                                                <div class="blue">Order Complete</div>
                                            </div>
                                            <div class="totalprice">$ 10.00</div>
                                            <div class="status">
                                                <span class="green">Stay</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="row" style="margin-bottom:60px;">
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

                        

                        <div class="row">
                            <div class="payment_box" style="padding-top:0; padding-bottom:10px; margin-top:0; border:0;">
                                <div class="tab row">
                                    <div>
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
                                    <div>
                                        <div class="col">
                                            <div class="title big">Help</div>
                                            <div>
                                                <ul>
                                                    <li>
                                                        <strong>Total rental: </strong>It means the total purchase amount of the bit registered by the seller with the 'Rental' option. <span class="red">(At this time, the total is calculated as VAT included.)</span>
                                                    </li>
                                                    <li>
                                                        <strong>Rental amount: </strong>It refers to the number of bit purchases registered with the 'Rental' option.
                                                    </li>
                                                    <li>
                                                        <strong>Total Sales: </strong>It refers to the total purchase amount of the bits registered by the seller with the ‘Sale’ option. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                                                    </li>
                                                    <li>
                                                        <strong>Sales volume: </strong>It means the number of purchases of the bit registered with the ‘Sale’ option.
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
                                    </div>             
                                </div>
                            </div>
                            <div class="title-content">
                                <p>
                                    - Settlement will be made on the <strong>10th of the following month</strong> based on the downloaded items from the 1st to the last day.<br/>
                                    - If the user did not proceed with the download after purchase, <strong>both rentals and sales are included in the settlement details <span>after 60 days from the purchase date</span></strong>.
                                </p>
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