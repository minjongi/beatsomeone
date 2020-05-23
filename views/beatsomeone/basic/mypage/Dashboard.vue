<template>


    <div class="wrapper">
        <Header :is-login="isLogin"/>




        <div class="container sub">
            <div class="main">
                <section class="main__section1">
                    <div class="BG" style="background-image:url('https://images.unsplash.com/photo-1513366208864-87536b8bd7b4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <div class="banner">
                                <h3>Together with <span>beatsomeone</span>!</h3>
                                <p>
                                    Let’s make a relationship with people you like. Make your profits by beats you made. These can be started in an easy way.
                                </p>
                                <button class="btn btn--yellow round">Start Selling</button>
                            </div>
                        </header>
                        <div class="main__media">

                            <div class="mypage sublist">
                                <div class="wrap">
                                    <div class="sublist__filter sticky">
                                        <div class="row center">
                                            <div class="profile">
                                                <div class="portait">
                                                    <img src="/assets/images/portait.png"/>
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
                                                    <div class="location">
                                                        <img class="site" src="/assets/images/icon/position.png"/><div>Seoul, South Korea</div>
                                                    </div>
                                                    <div class="brandshop">
                                                        <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">Go to Brandshop ></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <ul class="menu">
                                                <li class="active">Dashboard</li>
                                                <li>Manage Information</li>
                                                <li>Product List</li>
                                                <li>Order History</li>
                                                <li>Message</li>
                                                <li>Seller Register</li>
                                                <li>Support</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="sublist__content">
                                        
                                        <div class="row double">

                                            <div class="title-content">
                                                <div class="title">
                                                    <div>Order Details</div>
                                                    <button class="btn btn--glass">more ></button>
                                                </div>
                                                <div class="splitboard">
                                                    <div class="blue">12<span>Buy</span></div>
                                                    <div class="red">2<span>Cancel</span></div>
                                                    <div class="green">6<span>Refund</span></div>
                                                </div>
                                            </div>

                                            <div class="title-content">
                                                <div class="title">
                                                    <div>Expried soon</div>
                                                    <button class="btn btn--glass">more ></button>
                                                </div>
                                                <div>
                                                    <div class="slide">
                                                        <div class="playList" :class="slide_expired == 0 ? 'active' : ''">
                                                            <ul>
                                                                <li class="playList__itembox">
                                                                    <div class="playList__item playList__item--title active">
                                                                        <div class="col name">
                                                                            <figure>
                                                                                <span class="playList__cover">
                                                                                    <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
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
                                                                                    <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
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
                                                                                    <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
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
                                                                                    <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
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
                                                                                    <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
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
                                                                                    <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
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
                                                <div class="title">
                                                    <div>Recently Listen</div>
                                                    <button class="btn btn--glass">more ></button>
                                                </div>

                                                <div class="topFive">

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img src="'/uploads/cmallitem/'" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img src="'/uploads/cmallitem/'" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img src="'/uploads/cmallitem/'" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img src="'/uploads/cmallitem/'" alt="music-name" />
                                                        </button>
                                                        <a href="#//" class="albumItem__link">
                                                            <h4 class="albumItem__title">name</h4>
                                                            <p class="albumItem__singer">seller</p>
                                                        </a>
                                                    </div>

                                                    <div class="trending__slide-item albumItem">
                                                        <button class="albumItem__cover">
                                                            <img src="'/uploads/cmallitem/'" alt="music-name" />
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
                                                <div class="title">
                                                    <div>Message you received</div>
                                                    <button class="btn btn--glass">more ></button>
                                                </div>
                                                <div>
                                                    <div class="playList" :class="slide_expired == 0 ? 'active' : ''">
                                                        <ul>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <span class="playList__cover profile">
                                                                                <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
                                                                            </span>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">User 1</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="status active">
                                                                        Read
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <span class="playList__cover profile">
                                                                                <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
                                                                            </span>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">User 2</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="status">
                                                                        Unread
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <span class="playList__cover profile">
                                                                                <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
                                                                            </span>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">User 3</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="status">
                                                                        Unread
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="title-content">
                                                <div class="title">
                                                    <div>Support Case</div>
                                                    <button class="btn btn--glass">more ></button>
                                                </div>
                                                <div>
                                                    <div class="playList" :class="slide_expired == 0 ? 'active' : ''">
                                                        <ul>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">What is the usage range of my bought bea...</h3>
                                                                                <span class="playList__by">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="status">
                                                                        Unread
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">What is the usage range of my bought bea...</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="status">
                                                                        Unread
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="playList__itembox">
                                                                <div class="playList__item playList__item--title active">
                                                                    <div class="col name">
                                                                        <figure>
                                                                            <figcaption class="pointer">
                                                                                <h3 class="playList__title">What is the usage range of my bought bea...</h3>
                                                                                <span class="playList__by date">2020-04-20 15:53:42</span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                    <div class="status">
                                                                        Unread
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
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import Loader from '*/vue/common/Loader'
    import axios from 'axios'
    import Index_Items from "../Index_Items"
    import KeepAliveGlobal from "vue-keep-alive-global"
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import FileUpload from 'vue-simple-upload/dist/FileUpload'

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    //import MainPlayer from "@/vue/common/MainPlayer";
    import WaveSurfer from 'wavesurfer.js';

    export default {
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
    @import '/assets/plugins/flatpickr/flatpickr.css';
</style>