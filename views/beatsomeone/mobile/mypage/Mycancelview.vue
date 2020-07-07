<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container sub">
            <div class="mypage sublist">
                <div class="wrap mycancel-view">
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
                            <li class="active">Order History</li>
                            <li @click="goPage('regist_item')" v-show="group_title == 'SELLER'">{{$t('registrationOfBeat')}}</li>
                            <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">{{$t('salesHistory')}}</li>
                            <li @click="goPage('seller')" v-show="group_title == 'SELLER'">{{$t('settlementHistory')}}</li>
                            <li @click="goPage('message')">{{$t('chat')}}</li>
                            <li @click="goPage('sellerreg')" v-show="group_title == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
                            <li @click="goPage('inquiry')">{{$t('support1')}}
                                <ul class="menu">
                                    <li @click="goPage('inquiry')">Support Case</li>
                                    <li @click="goPage('faq')">FAQ</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="sublist__content" style="margin-bottom:100px;">

                        <div class="row" style="margin-bottom:30px;">
                            
                            <div class="title-content">
                                <div class="title"> Refund detail </div>
                                <div class="n-box">
                                    <div class="n-flex">
                                        <span class="title">No</span> <span style="margin-top: 0; color: rgba(255,255,255,.7);">Order_099</span>
                                    </div>
                                    <div class="n-flex">
                                        <span class="title">Date</span> <span style="margin-top: 0; color: rgba(255,255,255,.3)">0000-00-00 00:00:00</span>
                                    </div>
                                    <div class="n-flex">
                                        <span class="title">Status</span> <span class="red"  style="margin-top: 0;">Refund Complete</span>
                                    </div>
                                </div>
                            </div>

                            <div class="main__media board inquirylist">
                                
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
                                        <div class="playList__item playList__item--title other">
                                            <div class="n-flex between">
                                                <div class="info"> <div class="code">item_1</div> </div>
                                                <!-- <div class="edit" style="flex: 1 1 auto;">
                                                    <div class="download_status green"> Download Available </div>
                                                </div> -->
                                                <div class="price" style="color: white;">₩ 22,000</div>
                                                <div class="price" style="color: white; display: none;">₩ 0 </div>
                                            </div>
                                            <div class="name">
                                                <figure class="n-flex" style="margin-right: 0px;">
                                                    <span class="playList__cover">
                                                        <img src="/uploads/cmallitem/2020/05//690d20391c8439243968cdf073ca8f2a.jpg" alt="">
                                                        <i class="label new" style="display: none;">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                    <h3 class="playList__title">Tidal Wave</h3>
                                                    <div class="n-flex">
                                                        <div class="listen">
                                                            <div class="playbtn"><button data-action="playAction105" class="btn-play">재생</button>
                                                                <span class="timer">
                                                                    <span data-v-27fa6da0="" class="current">0:00 / </span>
                                                                    <span class="duration">0:00</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="amount"><img src="/assets/images/icon/cd.png">
                                                            <div><span>500</span> left</div>
                                                        </div>
                                                    </div>
                                                </figcaption>
                                                <button class="btn-edit"><img src="/assets/images/icon/down.png"></button>
                                            </figure>
                                            </div>
                                            <div class="col n-option">
                                            <div class="option">
                                                <!---->
                                                <div class="n-box">
                                                <div><button class="playList__item--button"><span class="option_fold"><img
                                                        src="/assets/images/icon/togglefold.png"></span>
                                                    <div>
                                                        <div class="title">BASIC LEASE LICENSE</div>
                                                        <div class="detail">MP3 or WAV</div>
                                                    </div>
                                                    </button>
                                                    <div class="option_item basic" style="margin-left: 38px;">
                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info1.png"></span><span>Available for 60
                                                        days</span></div>
                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info2.png"></span><span>Unable to edit
                                                        arbitrarily</span></div>
                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info3.png"></span><span>Rented members
                                                        cannot
                                                        be re-rented to others</span></div>
                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info5.png"></span><span>No other
                                                        activities not
                                                        authorized by the platform</span></div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col genre">
                                            <span><button>Wave</button></span><span><button>Calm</button></span><span><button>Kpop</button></span><span><button>pop</button></span><span><button>singing</button></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="row">
                            <div class="title-content text-info">
                                <p>Beat download is not available when the deposit is in a waiting state.</p>
                                <p>Beat download is available for 60 days after payment is completed.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="payment_box">
                                <div class="n-box">
                                    <div class="n-flex between">
                                        <span class="title">Method</span>
                                        <span  style="font-weight: 600;">Wire Transfer</span>
                                    </div>
                                    <div class="n-flex between">
                                        <span class="title">Paid</span>
                                        <span class="yellow" style="font-weight: 600;">$ 27.00</span>
                                    </div>
                                    <div class="n-flex between" style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                        <span class="title">Refund request</span>
                                        <span style="opacity:.7; font-weight:normal;">0000-00-00 00:00:00</span>
                                    </div>
                                    <div class="n-flex between">
                                        <span class="title">Refund complete</span>
                                        <span style="opacity:.7; font-weight:normal;">0000-00-00 00:00:00</span>
                                    </div>
                                    <div class="n-flex between">
                                        <span class="title">Request Reason</span>
                                        <span style="opacity:.7; font-weight:normal;">etc</span>
                                    </div>
                                    <div class="n-flex between">
                                        <span style="opacity:.7; font-weight:600;">Request refund reason describtion</span>
                                    </div>
                                    <div class="n-flex between" style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                        <span class="title">Refund</span>
                                        <span class="red">$ 27.00 P</span>
                                    </div>
                                    <div class="n-flex between">
                                        <span class="title">Refund Points</span>
                                        <span class="red">300 P</span>
                                    </div>                  
                                </div>
                            </div>
                            <p class="desc">
                                <img data-v-6049000a="" src="/assets/images/icon/info_blue.png">
                                <span>If you are in a deposit waiting state or wish to cancel, please request a change through a <a href="/mypage/inquiry/">Support Case</a> menu.</span>
                            </p>
                        </div>

                        <div class="n-flex n-btnbox">
                            <button class="btn btn--gray">Back to List</button>
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
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .title-content {
        border: 1px solid red;
        .n-box {
            >div {
                span {
                    margin: 0;
                }
            }
        }
    }
</style>