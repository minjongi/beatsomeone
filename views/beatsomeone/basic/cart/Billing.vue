<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <main-player></main-player>
        <div class="container">
            <div class="main">
                <section class="main__section1" style="margin-bottom:160px;">
                    <div class="BG" style="background-image:url('/assets/images/cart.png')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>PLACE AN ORDER</h1>
                            <div class="step" style="margin-top:30px;">
                                <div class="stage active done">
                                    <span>1</span>Cart
                                </div>
                                <div class="stage active">
                                    <span>2</span>Pay
                                </div>
                                <div class="stage">
                                    <span>3</span>Complete
                                </div>
                            </div>
                        </header>
                        <div class="row">
                            <div class="checkbox" style="margin-left:20px; margin-bottom:30px; font-weight:600"><div class="number">3</div>Selected Items</div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                        <span class="playList__by"> ( Bpm )</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">BASIC LEASE</div>
                                                        <div class="detail">MP3 or WAV</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
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
                                                        <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                        <span class="playList__by"> ( Bpm )</span>
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
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
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
                                                        <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                        <span class="playList__by"> ( Bpm )</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">BASIC LEASE</div>
                                                        <div class="detail">MP3 or WAV</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
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
                                                        <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                        <span class="playList__by"> ( Bpm )</span>
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
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="payment_box">
                                <div>
                                    <div class="title-content">
                                        <div div class="title">
                                            Payment method
                                        </div>
                                        <div>
                                            <label class="checkbox" for="method1">
                                                <input type="radio" name="method" id="method1" hidden="hidden" >
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon credit"></div><div>Credit</div></div>
                                            </label>
                                            <label class="checkbox" for="method2">
                                                <input type="radio" name="method" id="method2" hidden="hidden" >
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon wire"></div><div>Wire</div></div>
                                            </label>
                                            <label class="checkbox" for="method3">
                                                <input type="radio" name="method" id="method3" hidden="hidden" >
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon paypal"></div><div>PayPal</div></div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="title-content">
                                        <div div class="title">
                                            Point
                                        </div>
                                        <div>
                                            <div class="input_wrap inputbox unit" style="height:48px">
                                                <input type="number" value="KKOMA">
                                                <span>P</span>
                                            </div>
                                            <button class="btn btn--blue" style="width:100px;height:48px;margin-left:-10px;">Use</button>
                                        </div>
                                        <p style="display:inline-block;">
                                            <span>40,000</span> P left
                                        </p>
                                    </div>
                                </div>
                                <div class="tab">
                                    <div>
                                        <div class="title">Subtotal</div>
                                        <div>$ 30.00</div>
                                    </div>
                                    <div>
                                        <div class="title">Points</div>
                                        <div>300 P</div>
                                    </div>
                                    <div class="total">
                                        <div>Total</div>
                                        <div>$ 27.00</div>
                                    </div>                           
                                </div>
                            </div>
                        </div>

                        <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                            <button class="btn btn--gray">Back</button>
                            <button type="submit" class="btn btn--submit">Pay</button>
                        </div>
                    </div>

                </section>
            </div>
        </div>
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