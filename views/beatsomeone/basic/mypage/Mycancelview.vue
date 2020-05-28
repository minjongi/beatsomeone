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
                                <li class="active">Order History</li>
                                <li v-show="group_title == 'SELLER'">Sales History</li>
                                <li v-show="group_title == 'SELLER'">Settlement History</li>
                                <li>Message</li>
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

                        <div class="row" style="margin-bottom:30px;">
                            
                            <div class="title-content">
                                <div class="title">
                                    <div>Refund detail</div>
                                </div>
                            </div>

                            <div class="main__media board inquirylist">
                                <div class="tab" style="height:48px; justify-content:flex-start;">
                                    <div>
                                        <div class="title">No</div>
                                        <div>Order_099</div>
                                    </div>
                                    <div>
                                        <div class="title">Date</div>
                                        <div>0000-00-00 00:00:00</div>
                                    </div>
                                    <div>
                                        <div class="title">Status</div>
                                        <div class="red">Refund Complete</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-bottom:10px;">
                            
                            <div class="title-content">
                                <div class="title">
                                    <div><span class="yellow">3</span> Requested items</div>
                                </div>
                            </div>

                            <div class="playList productList orderlist" style="margin-top:10px;">
                                <ul>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="amount">
                                                    <img src="/assets/images/icon/cd.png"/><div><span>500</span> left</div>
                                                </div>
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="amount">
                                                    <img src="/assets/images/icon/cd.png"/><div><span>500</span> left</div>
                                                </div>
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="amount">
                                                    <img src="/assets/images/icon/cd.png"/><div><span>500</span> left</div>
                                                </div>
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="amount">
                                                    <img src="/assets/images/icon/cd.png"/><div><span>500</span> left</div>
                                                </div>
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="row">
                            <div class="title-content">
                                <p>
                                    ※- Beat download is not available when the deposit is in a waiting state.<br/>
                                    ※- Beat download is available for 60 days after payment is completed.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="payment_box" style="padding-top:0; margin-top:0; border:0;">
                                <div class="tab">
                                    <div>
                                        <div class="title">Method</div>
                                        <div>Wire Transfer</div>
                                    </div>
                                    <div>
                                        <div class="title">Paid</div>
                                        <div class="yellow">$ 27.00</div>
                                    </div>
                                    <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                        <div class="title">Refund request</div>
                                        <div style="opacity:.7; font-weight:light;">0000-00-00 00:00:00</div>
                                    </div>
                                    <div>
                                        <div class="title">Refund complete</div>
                                        <div style="opacity:.7; font-weight:light;">0000-00-00 00:00:00</div>
                                    </div>
                                    <div>
                                        <div class="title">Request Reason</div>
                                        <div style="opacity:.7; font-weight:300;">etc</div>
                                    </div>
                                    <div>
                                        <div style="opacity:.7; font-weight:300;">Request refund reason describtion</div>
                                    </div>
                                    <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                        <div class="title">Refund</div>
                                        <div class="red">$ 27.00 P</div>
                                    </div>
                                    <div>
                                        <div class="title">Refund Points</div>
                                        <div class="red">300 P</div>
                                    </div>                  
                                </div>
                            </div>
                            <p class="desc">
                                <img src="/assets/images/icon/info_blue.png">If you are in a deposit waiting state or wish to cancel, please request a change through a <a href="/mypage/inquiry/">Support Case</a> menu.
                            </p>
                        </div>

                        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
                            <button class="btn btn--gray">Back to List</button>
                            <button type="submit" class="btn btn--submit">Request Refund</button>
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
    @import '/assets/plugins/flatpickr/flatpickr.css';
</style>