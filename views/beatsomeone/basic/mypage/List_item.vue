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
                                <li>Dashboard</li>
                                <li>Manage Information</li>
                                <li class="active">Product List</li>
                                <li>Order History</li>
                                <li>Sales History</li>
                                <li>Settlement History</li>
                                <li>Message</li>
                                <li>Support</li>
                            </ul>
                        </div>
                    </div>
                    <div class="sublist__content">
                        
                        <div class="row" style="margin-bottom:10px;">
                            <div class="search condition">
                                <div class="filter">
                                    <div class="condition active">Product Name</div>
                                    <div class="condition">Product Code</div>
                                    <div class="condition">Keyword</div>
                                </div>
                                <div class="wrap">
                                    <input type="text" placeholder="enter your word..."> 
                                    <img src="/assets/images/icon/searchicon.png"/>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:flex; margin-bottom:30px;">
                            <div class="tabmenu">
                                <div class="active">Total (33)</div>
                                <div>Selling (15)</div>
                                <div>Pending (18)</div>
                            </div>
                            <div>
                                <div class="sort">
                                    <span>{{ $t('sortBy') }}</span>
                                    <div class="custom-select " style="width:initial;">
                                        <button class="selected-option">
                                            Genre / Mood / Track Type
                                        </button>
                                        <div class="select-genre popup active">
                                            <div class="tab">
                                                <button :class="popup_filter == 0 ? 'active' : ''" @click="popup_filter = 0">Genre<div class="count">7</div></button>
                                                <button :class="popup_filter == 1 ? 'active' : ''" @click="popup_filter = 1">Mode<div class="count">3</div></button>
                                                <button :class="popup_filter == 2 ? 'active' : ''" @click="popup_filter = 2">Track Type<div class="count">2</div></button>
                                            </div>
                                            <div class="tab_container">

                                                <div class="tab_content" :class="popup_filter = 0 ? 'active' : ''">
                                                    <ul class="filter__list">
                                                        <li class="filter__item">
                                                            <label for="fillter1" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter1" value="All Genre">
                                                                <span></span> All Genre
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab_content" :class="popup_filter = 1 ? 'active' : ''">
                                                    <ul class="filter__list">
                                                        <li class="filter__item">
                                                            <label for="fillter1" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter1" value="All Genre">
                                                                <span></span> All Genre
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab_content" :class="popup_filter = 2 ? 'active' : ''">
                                                    <ul class="filter__list">
                                                        <li class="filter__item">
                                                            <label for="fillter1" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter1" value="All Genre">
                                                                <span></span> All Genre
                                                            </label>
                                                        </li>
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                            <div>
                                                <div class="btnbox col">
                                                    <button type="submit" class="btn btn--gray"> Cancel </button>
                                                    <button type="submit" class="btn btn--submit"> Apply </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sort">
                                    <div class="custom-select">
                                        <button class="selected-option">
                                            Register Date
                                        </button>
                                        <div class="options">
                                            <button data-value="" class="option"> Launch Date </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="sort datepicker">
                                    <input type="date" placeholder="Start Date" />
                                    <span>─</span>
                                    <input type="date" placeholder="End Date" />
                                    <button><img src="/assets/images/icon/calendar-white.png" /></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="playList productList">
                                <ul>
                                    <li v-for="(item, i) in myProduct_list" v-bind:key="item.cde_id" class="playList__itembox" :id="'playList__item'+ item.cit_id">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col index">{{ calcSeq(myProduct_list.length,i) }}</div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img :src="'http://dev.beatsomeone.com/uploads/cmallitem/'+item.cit_file_1" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <!-- <div class="status" :class="product_status">{{product_status}}</div>-->
                                                          <div v-if="item.cit_status === '1'" class="status SEELING">SEELING</div>
                                                          <div v-if="item.cit_status === '0'" class="status PENDING">PENDING</div>
                                                          
                                                          <div class="code">{{ item.cit_key }}</div>
                                                        </div>
                                                        <h3 class="playList__title">{{ formatCitName(item.cit_name)  }}</h3>
                                                        <span class="playList__by"> ( {{ item.bpm }} )</span>
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
                                                        <button class="btn-play" @click="playAudio(item)" :data-action="'playAction' + item.cit_id ">재생</button>
                                                        <span class="timer"><span data-v-27fa6da0="" class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div data-v-27fa6da0="" class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="amount">
                                                    <img src="/assets/images/icon/cd.png"/><div><span>{{ item.cde_quantity }}</span> left</div>
                                                </div>
                                                <div class="price">
                                                    $ {{ item.cde_price_d }}
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button @click="productEditBtn(item.cit_key)" class="btn-edit"><img src="/assets/images/icon/edit.png"/></button>
                                            </div>
                                            <div class="col genre">
                                                <span><button >{{ item.hashTag }}</button></span>
                                            </div>
                                        </div>
                                    </li>

                                    <!--
                                    <li class="playList__itembox" style="opacity: 1; margin-bottom: 1px;">
                                        <div class="playList__item playList__item--title">
                                            <div class="col index">18</div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img src="/uploads/cmallitem/2020/01/37617719f8a82eaee60242b2a0acf30e.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="status" :class="product_status">{{product_status}}</div>
                                                          <div class="code">item_100</div>
                                                        </div>
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
                                                        <span class="timer"><span data-v-27fa6da0="" class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div data-v-27fa6da0="" class="col spectrum">
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
                                            <div class="col edit">
                                                <button class="btn-edit"><img src="/assets/images/icon/edit.png"/></button>
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
                                    -->
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
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