<template>


    <div class="wrapper">
        <Header :is-login="isLogin"/>

        <div class="container sub">
            <div class="main mypage dashboard-wrap" style="overflow:initial;">
                <section class="main__section1" style="background:none;">
                    <div class="BG" style="background-image:url('https://images.unsplash.com/photo-1513366208864-87536b8bd7b4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <div class="banner">
                                <h3>Together with <span>beatsomeone</span>!</h3>
                                <p> Let’s make a relationship with people you like. <br>Make your profits by beats you made. <br>These can be started in an easy way. </p>
                                <button class="btn btn--yellow round">Start Selling</button>
                            </div>
                        </header>
                        <div class="main__media">

                            <div class="sublist">
                                <div>
                                    <div class="sublist__filter sticky">
                                        <div class="row center">
                                            <div class="profile">
                                                <div class="portait">
                                                    <img src="/assets/images/member_default.png"/>
                                                </div>
                                                <div class="info">
                                                    <div class="group">
                                                        <div class="group_title" :class="group_title">{{group_title}}</div>
                                                    </div>
                                                    <div class="username">
                                                        DROPBEAT
                                                    </div>
                                                    <div class="bio">
                                                        Music Lover, KKOMA
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile__footer">
                                                <div class="location">
                                                    <img class="site" src="/assets/images/icon/position.png"/><div>Seoul, South Korea</div>
                                                </div>
                                                <div class="brandshop">
                                                    <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">Go to Brandshop ></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row menu__wraper">
                                        <ul class="menu">
                                            <li class="active">Dashboard</li>
                                            <li @click="goPage('profilemod')">Manage Information</li>
                                            <li @click="goPage('list_item')">Product List</li>
                                            <li @click="goPage('mybilling')">Order History</li>
                                            <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">Sales History</li>
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

                                    <div class="sublist__content">
                                        <div class="row" v-show="group_title == 'SELLER'">

                                            <div class="title-content">
                                                <h4 class="title"> Settlement Overview </h4>
                                                <!-- <p>
                                                    ※· We will guide the amount of sales and settlements based on the current month / day.<br/>
                                                    ※· Exact sales / settlement amount can be checked on the basis of 20-25 days of the following month.
                                                </p> -->
                                            </div>
                                            
                                            <div>
                                                <div class="splitboard">
                                                    <div class="blue">
                                                        ₩ 123,456
                                                        <div class="change">(Change 40,093▲)</div>
                                                        <span>
                                                            Estimated sales amount
                                                            <button class="button active">
                                                                <img src="/assets/images/icon/tip.png"/>
                                                            </button>
                                                            <div class="tooltip">
                                                                <p>Displays the estimated amount of sales of the bit sold so far, starting from the current month. The exact sales amount can be confirmed on the last day. </p>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="blue">
                                                        ₩ 93,409
                                                        <div class="change">(Change 40,093▲)</div>
                                                        <span>
                                                            Estimated settlement amount
                                                            <button class="button">
                                                                <img src="/assets/images/icon/tip.png"/>
                                                            </button>
                                                            <span class="tooltip" style="display:none;">
                                                                <p> Displays the estimated settlement amount, deducted from the fee, based on the amount sold so far from the current month. The exact settlement amount can be checked between 20-25 days of the following month. </p>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="red">
                                                        ₩ 80,039
                                                        <div class="change">(Change 40,093▲)</div>
                                                        <span>
                                                            Last month settlement amount
                                                            <button class="button">
                                                                <img src="/assets/images/icon/tip.png"/>
                                                            </button>
                                                            <span class="tooltip" style="display:none;">
                                                                <p> Displays the amount settled last month. </p>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="row" v-show="group_title == 'SELLER'">

                                            <div class="title-content">
                                                <h4 class="title">Chart</h4>
                                            </div>
                                            <div class="chart">
                                                <img src="/assets/images/chart.png"/>                                                
                                            </div>
                                        </div>

                                        <div class="row double" v-show="group_title == 'SELLER'">

                                            <div class="title-content">
                                                <h4 class="title">
                                                    Order Details
                                                    <!-- <button class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button> -->
                                                </h4>
                                                <div class="n-flex splitboard">
                                                    <div class="blue">12<span>Buy</span></div>
                                                    <div class="red">2<span>Cancel</span></div>
                                                    <div class="green">6<span>Refund</span></div>
                                                </div>
                                            </div>

                                            <div class="title-content">
                                                <h4 class="title">
                                                    Product details
                                                    <!-- <button class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button> -->
                                                </h4>
                                                <div class="n-flex splitboard">
                                                    <div class="blue">12<span>Total</span></div>
                                                    <div class="red">2<span>Selling</span></div>
                                                    <div class="green">6<span>Pending</span></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row double" v-show="group_title == 'CUSTOMER'">

                                            <div class="title-content">
                                                <h4 class="title">
                                                    Order Details
                                                    <!-- <button class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button> -->
                                                </h4>
                                                <div class="n-flex splitboard">
                                                    <div class="blue">12<span>Buy</span></div>
                                                    <div class="red">2<span>Cancel</span></div>
                                                    <div class="green">6<span>Refund</span></div>
                                                </div>
                                            </div>

                                            <div class="title-content">
                                                <h4 class="title">
                                                    Expried soon
                                                    <!-- <button class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button> -->
                                                </h4>
                                                <div>
                                                    <div class="slide">
                                                        <div class="n-flex playList" :class="slide_expired == 0 ? 'active' : ''">
                                                            <ul>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="/assets/images/cover_default.png" alt="">
                                                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                                                </span>
                                                                                <figcaption class="pointer">
                                                                                    <h3 class="playList__title">Name</h3>
                                                                                    <span class="playList__by">Seller</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="expire">
                                                                                <span>10 hous</span> remaining
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="/assets/images/cover_default.png" alt="">
                                                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                                                </span>
                                                                                <figcaption class="pointer">
                                                                                    <h3 class="playList__title">Name</h3>
                                                                                    <span class="playList__by">Seller</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="expire">
                                                                                <span>10 hous</span> remaining
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="playList" :class="slide_expired == 1 ? 'active' : ''">
                                                            <ul>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="/assets/images/cover_default.png" alt="">
                                                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                                                </span>
                                                                                <figcaption class="pointer">
                                                                                    <h3 class="playList__title">Name</h3>
                                                                                    <span class="playList__by">Seller</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="expire">
                                                                                <span>10 hous</span> remaining
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="/assets/images/cover_default.png" alt="">
                                                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                                                </span>
                                                                                <figcaption class="pointer">
                                                                                    <h3 class="playList__title">Name</h3>
                                                                                    <span class="playList__by">Seller</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="expire">
                                                                                <span>10 hous</span> remaining
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="playList" :class="slide_expired == 2 ? 'active' : ''">
                                                            <ul>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="/assets/images/cover_default.png" alt="">
                                                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                                                </span>
                                                                                <figcaption class="pointer">
                                                                                    <h3 class="playList__title">Name</h3>
                                                                                    <span class="playList__by">Seller</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="expire">
                                                                                <span>10 hous</span> remaining
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="/assets/images/cover_default.png" alt="">
                                                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                                                </span>
                                                                                <figcaption class="pointer">
                                                                                    <h3 class="playList__title">Name</h3>
                                                                                    <span class="playList__by">Seller</span>
                                                                                </figcaption>
                                                                            </figure>
                                                                        </div>
                                                                        <div class="info">
                                                                            <div class="expire">
                                                                                <span>10 hous</span> remaining
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="slide_navigator">
                                                        <div :class="slide_expired == 0 ? 'active' : ''" @click="slide_expired = 0"></div>
                                                        <div :class="slide_expired == 1 ? 'active' : ''" @click="slide_expired = 1"></div>
                                                        <div :class="slide_expired == 2 ? 'active' : ''" @click="slide_expired = 2"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="title-content">
                                                <h4 class="title">
                                                    Recently Listen
                                                    <!-- <button class="btn btn--glass">more <img src="/assets/images/icon/chevron-right.png"/></button> -->
                                                </h4>

                                                <div class="n-flex topFive recentListen">

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img  src="/assets/images/cover_default.png" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img  src="/assets/images/cover_default.png" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img  src="/assets/images/cover_default.png" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img  src="/assets/images/cover_default.png" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img  src="/assets/images/cover_default.png" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img  src="/assets/images/cover_default.png" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>

                                        
                                        <div class="row double" style="margin-bottom:100px;">

                                            <div class="title-content">
                                                <h4 class="title">
                                                    <span>Message you received</span>
                                                    <a class="more" href="#">more <img src="/assets/images/icon/chevron-right.png"/></a>
                                                </h4>
                                                <div>
                                                    <div class="playList" :class="slide_expired == 0 ? 'active' : ''">
                                                        <ul>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <span class="playList__cover profile">
                                                                                <img src="/assets/images/member_default.png" alt="user_name">
                                                                            </span>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">User 1</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="action active">
                                                                        Unread
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <span class="playList__cover profile">
                                                                                <img src="/assets/images/member_default.png" alt="user_name">
                                                                            </span>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">User 2</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="action">
                                                                        Read
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <span class="playList__cover profile">
                                                                                <img src="/assets/images/member_default.png" alt="user_name">
                                                                            </span>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">User 3</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="action">
                                                                        Read
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="title-content">
                                                <h4 class="title">
                                                    <span>Support Case</span>
                                                    <a class="more" href="#">more <img src="/assets/images/icon/chevron-right.png"/></a>
                                                </h4>
                                                <div>
                                                    <div class="playList" :class="slide_expired == 0 ? 'active' : ''">
                                                        <ul>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title" style="height:18px">What is the usage range of my bought bea...</h3>
                                                                                <span class="playList__by">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="action active">
                                                                        Open
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title" style="height:18px">What is the usage range of my bought bea...</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="action">
                                                                        Closed
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title" style="height:18px">What is the usage range of my bought bea...</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="action">
                                                                        Closed
                                                                    </div>
                                                                </div>
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
                    </div>
                </section>
            </div>
        </div>
        <div id="waveform" ></div>
        <!--
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

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                myProduct_list: [],
                popup_filter:0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
                slide_expired: 0,
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

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>