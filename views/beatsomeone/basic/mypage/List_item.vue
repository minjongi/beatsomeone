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
                                    <img v-else :src="'/uploads/member_photo/' + mem_photo" alt="">
                                </div>
                                <div class="info">
                                    <div class="group">
                                        <div class="group_title" :class="group_title">{{group_title}}</div>
                                    </div>
                                    <div class="username">
                                        {{mem_nickname}}
                                    </div>
                                    <div class="bio">
                                        {{ mem_type }}, {{ mem_lastname }}
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
                                <li class="active">Product List</li>
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
                    </div>

                    <div class="sublist__content">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="search condition">
                                <div class="filter">
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">Product Name</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">Product Code</div>
                                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">Keyword</div>
                                </div>
                                <div class="wrap">
                                    <input type="text" placeholder="Searching product..." :model="goSearchText" @keypress.enter="goSearch"> 
                                    <img src="/assets/images/icon/searchicon.png" @click="goSearch"/>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:flex; margin-bottom:30px;">
                            <div class="tabmenu">
                                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">Total ({{calcTotalCnt}})</div>
                                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">Selling ({{calcSellingCnt}})</div>
                                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">Pending ({{calcPendingCnt}})</div>
                            </div>
                            <div>
                                <div class="sort">
                                    <span>{{ $t('sortBy') }}</span>
                                    <div class="custom-select" :class="GMT == 1 ? 'active' : ''" style="width:initial; border-radius:8px;">
                                        <button class="selected-option" @click="toggleGMT">
                                            Genre / Mood / Track Type
                                        </button>
                                        <div class="select-genre popup active">
                                            <div class="tab">
                                                <button :class="popup_filter == 0 ? 'active' : ''" @click="popup_filter = 0">Genre<div class="count">{{selectedGenre.length}}</div></button>
                                                <button :class="popup_filter == 1 ? 'active' : ''" @click="popup_filter = 1">Mode<div class="count">{{selectedMood.length}}</div></button>
                                                <button :class="popup_filter == 2 ? 'active' : ''" @click="popup_filter = 2">Track Type<div class="count">{{selectedTrackType.length}}</div></button>
                                            </div>
                                            <div class="tab_container">
                                                <div v-show="popup_filter === 0" class="tab_content active">
                                                    <ul class="filter__list">
                                                        <li class="filter__item" v-for="(item, index) in listGenre" :key="'genre' + index" >
                                                            <label :for="'genrefillter'+index" class="checkbox">
                                                                <input type="checkbox" hidden="hidden" :id="'genrefillter'+index" :value="item" v-model="selectedGenre">
                                                                <span></span><div> {{ item }}</div>
                                                            </label>
                                                        </li>
                                                        <!--
                                                        <li class="filter__item">
                                                            <label for="fillter2" class="checkbox">
                                                                <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                                <span></span> Hip hop
                                                            </label>
                                                        </li>
                                                        -->
                                                    </ul>
                                                </div>

                                                <div v-show="popup_filter === 1" class="tab_content active">
                                                    <ul class="filter__list">
                                                        <li class="filter__item" v-for="(item, index) in listMoods" :key="'mood' + index" >
                                                            <label :for="'moodfillter'+index" class="checkbox">
                                                                <input type="checkbox" hidden="hidden" :id="'moodfillter'+index" :value="item" v-model="selectedMood">
                                                                <span></span><div>{{ item }}</div>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div v-show="popup_filter === 2" class="tab_content active">
                                                    <ul class="filter__list">
                                                        <li class="filter__item" v-for="(item, index) in listTrackType" :key="'track' + index" >
                                                            <label :for="'trackfillter'+index" class="checkbox">
                                                                <input type="checkbox" hidden="hidden" :id="'trackfillter'+index" :value="item" v-model="selectedTrackType">
                                                                <span></span><div> {{ item }}</div>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="btnbox col">
                                                    <button class="btn btn--gray" @click="goGMTBtn('Cancel')"> Cancel </button>
                                                    <button type="submit" class="btn btn--submit" @click="goGMTBtn('Apply')"> Apply </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sort">
                                    <div class="custom-select custom-select-dropdown">
                                        <button class="selected-option">
                                            {{ dateType }}
                                        </button>
                                        <div class="options">
                                            <button v-show="dateType === 'Launch Date'" class="option" @click="funcDateType('Register Date')"> Register Date </button>
                                            <button v-show="dateType === 'Register Date'" data-value="" class="option" @click="funcDateType('Launch Date')"> Launch Date  </button>
                                        </div>
                                    </div>
                                </div>
                                <VueHotelDatepicker
                                        class="search-date"
                                        format="YYYY-MM-DD"
                                        placeholder="Start date ~ End date"
                                        :startDate="start_date"
                                        :endDate="end_date"
                                        minDate="1970-01-01"
                                        @update="updateSearchDate"
                                        @reset="resetSearchDate"
                                />
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="playList productList">
                                <ul>
                                    <li v-for="(item, i) in myProduct_list" v-bind:key="item.cde_id" class="playList__itembox" :id="'playList__item'+ item.cit_id">
                                        <!-- 2가지 동시에 있는경우 other클래스 추가. -->
                                        <div class="playList__item playList__item--title other">

                                            <div class="col index">{{ calcSeq(myProduct_list.length,i) }}</div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img v-if="!item.cit_file_1" :src="'/assets/images/cover_default.png'" alt="">
                                                        <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt="">
                                                        <i v-show="checkToday(item.cit_datetime)" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <!-- <div class="status" :class="product_status">{{product_status}}</div>-->
                                                          <div v-if="item.cit_status === '1'" class="status SEELING">SEELING</div>
                                                          <div v-if="item.cit_status === '0'" class="status PENDING">PENDING</div>
                                                          
                                                          <div class="code">{{ item.cit_key }}</div>
                                                        </div>
                                                        <h3 class="playList__title" v-html="formatCitName(item.cit_name,50)"></h3>
                                                        <span class="playList__by">by {{ item.mem_nickname }}</span>
                                                        <span class="playList__bpm">{{ getGenre(item.genre, item.subgenre) }} | {{ item.bpm }}BPM</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col n-option">

                                                <div class="feature">
                                                    <div class="listen">
                                                        <div class="playbtn">
                                                            <button class="btn-play" @click="playAudio(item)" :data-action="'playAction' + item.cit_id ">재생</button>
                                                            <span class="timer"><span data-v-27fa6da0="" class="current">0:00 / </span>
                                                            <span class="duration">0:00</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="amount">
                                                        <img src="/assets/images/icon/cd.png"/><div><span>{{ item.cde_quantity }}</span> left</div>
                                                    </div>
                                                </div>
                                                <!-- Option -->
                                                <div class="option">
                                                    <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-if="item.cit_lease_license_use === '1' && item.cit_mastering_license_use === '1' ">
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">BASIC LEASE LICENSE</div>
                                                                    <div class="detail">MP3 or WAV</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item basic">
                                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="price">{{ formatPrice(item.cde_price, item.cde_price_d, true) }}</div>
                                                    </div>
                                                    <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-if="item.cit_lease_license_use === '1' && item.cit_mastering_license_use === '1' ">
                                                        <!-- UNLIMITED STEMS LICENSE -->
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">UNLIMITED STEMS LICENSE</div>
                                                                    <div class="detail">MP3 or WAV + STEMS</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item unlimited">
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released. </span> </div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020) </span> </div>
                                                            </div>
                                                        </div>
                                                        <div class="price">{{ formatPrice(item.cde_price_2, item.cde_price_d_2, true) }}</div>
                                                    </div>
                                                    <!-- BASIC LEASE LICENSE -->
                                                    <div class="n-box" v-else-if="item.cit_lease_license_use === '1' " >
                                                        
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">BASIC LEASE LICENSE</div>
                                                                    <div class="detail">MP3 or WAV</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item basic">
                                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="price">{{ formatPrice(item.cde_price, item.cde_price_d, true) }}</div>
                                                    </div>

                                                    <!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-else-if="item.cit_mastering_license_use === '1' " >
                                                        
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">UNLIMITED STEMS LICENSE</div>
                                                                    <div class="detail">MP3 or WAV + STEMS</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item unlimited">
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released. </span> </div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020) </span> </div>
                                                            </div>
                                                        </div>
                                                        <div class="price">{{ formatPrice(item.cde_price_2, item.cde_price_d_2, true) }}
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                            </div>

                                            <div class="col edit">
                                                <button @click="productEditBtn(item.cit_id)" class="btn-edit"><img src="/assets/images/icon/edit.png"/></button>
                                            </div>
                                            <div class="col genre" v-html="calcTag(item.hashTag)"></div>    
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
                                                        <div class="title">BASIC LEASE</div>
                                                        <div class="detail">MP3 or WAV</div>
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
                                <div id="playerContainer" class="hidden"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <main-player></main-player>
        <Footer/>
    </div>
</template>


<script>
    require('@/assets/js/function')
    import { EventBus } from '*/src/eventbus';
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import moment from "moment";
    import axios from 'axios'
    import WaveSurfer from 'wavesurfer.js';
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'
    import MainPlayer from "@/vue/common/MainPlayer"

    export default {
        components: {
            Header, Footer, VueHotelDatepicker, MainPlayer
        },
        data: function () {
            return {
                isLogin: false,
                isLoading: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                myProduct_list: [],
                isPlay: false,
                currentPlayId: null,
                wavesurfer: null,
                mem_photo: '',
                mem_usertype: '',
                mem_nickname: '',
                mem_address1: '',
                mem_type: '',
                mem_lastname: '',
                search_condition_active_idx: 1,
                search_tabmenu_idx: 1,
                GMT: 0,
                popup_filter:0,
                search_date_option: 0,
                start_date: '',
                end_date: '',
                calcTotalCnt: 0,
                calcSellingCnt: 0,
                calcPendingCnt:0,
                listGenre: window.genre,
                listMoods: window.moods,
                listTrackType: window.trackType,
                selectedGenre: [],
                selectedMood: [],
                selectedTrackType: [],
                dateType: 'Register Date',
                goSearchText:'',
            };
        },
        mounted(){
            // 커스텀 셀렉트 옵션
            $(".custom-select-dropdown").on("click", function() {

                $(this)
                    .siblings(".custom-select-dropdown")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this)
                    .find(".options")
                    .toggle();
            });
            EventBus.$on('main_player_play',r=> {
                this.start();
            });
            EventBus.$on('main_player_stop',r=> {
                this.stop()
            });

        },
        created() {
            this.ajaxItemList().then(()=>{
                this.calcTotalCnt = this.calcFuncTotalCnt();
                this.calcSellingCnt = this.calcFuncSellingCnt();
                this.calcPendingCnt = this.calcFuncPendingCnt();
            });
            this.ajaxUserInfo();
        },
        methods:{
            async ajaxItemList () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/get_user_regist_item_list', {}
                );

                console.log(data);/*
                data.forEach(function(d){
                    console.log(d.cit_datetime);
                    console.log(d.cit_start_datetime);
                });*/
                this.myProduct_list = data;
              } catch (err) {
                console.log('ajaxItemList error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxUserInfo () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/get_user_info', {}
                );
                //console.log(data);
                this.mem_photo = data[0].mem_photo;
                this.mem_usertype = data[0].mem_usertype;
                this.mem_nickname = data[0].mem_nickname;
                this.mem_address1 = data[0].mem_address1;
                this.mem_type = data[0].mem_type;
                this.mem_lastname = data[0].mem_lastname;

                if(this.mem_usertype == 1){
                    this.group_title = "CUSTOMER";
                }else{
                    this.group_title = "SELLER";
                }
              } catch (err) {
                console.log('ajaxUserInfo error');
              } finally {
                this.isLoading = false;
              }
            },
            setPopupFilter: function(idx){
                this.popup_filter = idx;
            },
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            formChange: function(data){
                data = data.replace(/\s/gi, "");
                console.log(data.toLowerCase());
                return data.toLowerCase();
            },
            goSearch: function(e){
                this.ajaxItemList().then(()=>{
                    let list = [];
                    Object.assign(list,this.myProduct_list);
                    if(this.search_condition_active_idx == 1){
                        let rst = list.filter(item => this.formChange(item.cit_name).includes(this.formChange(this.goSearchText)));
                        this.myProduct_list = rst;
                    }
                    else if(this.search_condition_active_idx == 2){
                        let rst = list.filter(item => this.formChange(item.cit_key).includes(this.formChange(this.goSearchText))); 
                        this.myProduct_list = rst; 
                    }
                    else if(this.search_condition_active_idx == 3){
                        let rst = list.filter(item => this.formChange(item.hashTag).includes(this.formChange(this.goSearchText)));
                        this.myProduct_list = rst;
                    }
                });
            },
            callbackdateime: function(val){
                let s = moment(this.start_date);
                let e = moment(this.end_date);
                let t = moment(val.cit_datetime.substr(0,10));
                if(s.diff(t) <= 0 && 0 <= e.diff(t)){
                    return true;
                }else{
                    return false;
                }
            },
            callbackstartdateime: function(val){
                let s = moment(this.start_date);
                let e = moment(this.end_date);
                let t = moment(val.cit_start_datetime.substr(0,10));
                console.log(s);
                console.log(e);
                console.log(t);
                console.log(s.diff(t));
                console.log(e.diff(t));
                if(s.diff(t) <= 0 && 0 <= e.diff(t)){
                    return true;
                }else{
                    return false;
                }
            },
            goSearchDate: function(){
                this.ajaxItemList().then(()=>{
                    let list = [];
                    Object.assign(list,this.myProduct_list);
                    console.log(this.search_date_option);
                    if(this.isEmpty(this.start_date) || this.isEmpty(this.end_date)){
                        this.myProduct_list = list;
                    }else if(this.search_date_option == 0){
                        let rst = list.filter(this.callbackdateime);
                        this.myProduct_list = rst;
                        console.log(rst);
                    }else if(this.search_date_option == 1){
                        let rst = list.filter(this.callbackstartdateime);
                        this.myProduct_list = rst;
                        console.log(rst);
                    }
                    this.calcTotalCnt = this.calcFuncTotalCnt();
                    this.calcSellingCnt = this.calcFuncSellingCnt();
                    this.calcPendingCnt = this.calcFuncPendingCnt();
                });
            },
            goTabMenu: function(menu){
                this.ajaxItemList().then(()=>{
                    let list = [];
                    Object.assign(list,this.myProduct_list);
                    if(menu == 1){
                        this.myProduct_list = list;
                        this.search_tabmenu_idx = 1;
                    }
                    else if(menu == 2){
                        let rst = list.filter(item => item.cit_status === '1'); 
                        this.myProduct_list = rst; 
                        this.search_tabmenu_idx = 2;
                    }
                    else if(menu == 3){
                        let rst = list.filter(item => item.cit_status === '0');
                        this.myProduct_list = rst;
                        this.search_tabmenu_idx = 3;
                    }
                });
            },
            toggleGMT: function(){
                if(this.GMT == 1){
                    this.GMT = 0;
                }else{
                    this.GMT = 1;
                }
            },
            toggleButton: function(e){
                if(e.target.parentElement.parentElement.parentElement.parentElement.className == "n-box"){
                    e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box active";
                }else if(e.target.parentElement.parentElement.parentElement.parentElement.className == "n-box active"){
                    e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box";
                }else{
                    //
                }
            },
            goGMTBtn: function(type){
                if(type=="Apply"){
                    let list = [];
                    let rst = [];
                    Object.assign(list,this.myProduct_list);

                    if(0 < this.selectedGenre.length){
                        console.log("selectedGenre:"+this.selectedGenre);
                        rst = list.filter(item => this.selectedGenre.includes(item.genre));
                    }
                    if(0 < this.selectedMood.length){
                        console.log("selectedMood:"+this.selectedMood);
                        rst = list.filter(item => this.selectedMood.includes(item.moods));
                    }
                    if(0 < this.selectedTrackType.length){
                        console.log("selectedTrackType:"+this.selectedTrackType);
                        rst = list.filter(item => this.selectedTrackType.includes(item.trackType));
                    }
                    console.log(rst);
                    this.myProduct_list = rst;
                }else if(type=="Cancel"){
                    this.selectedGenre = [];
                    this.selectedMood = [];
                    this.selectedTrackType = [];
                    this.ajaxItemList();
                }
                this.GMT = 0;
            },
            goStartDate: function(e){
                this.start_date = e.target.value;

                if(this.start_date == '' || this.end_date == ''){
                    return ;
                }else{
                    this.goSearchDate();
                }
            },
            goEndDate: function(e){
                this.end_date = e.target.value;

                if(this.start_date == '' || this.end_date == ''){
                    return ;
                }else{
                    this.goSearchDate();
                }
            },

            calcSeq: function(size, i){
                return parseInt(size) - parseInt(i);
            },
            removeReg: function(val){
                const regExp = /[~!@#$%^&*()_+|'"<>?:{}]/;
                while(regExp.test(val)){
                    val = val.replace(regExp, "");
                }
                return val
            },
            calcTag: function(hashTag){
                let rst='';
                let tags = hashTag.split(',');
                for ( let i in tags ) {
                    rst = rst + '<span><button >'+ this.removeReg(tags[i]) + '</button></span>';
                }
                return rst;
            },
            calcFuncTotalCnt(){
                return this.myProduct_list.length;
            },
            calcFuncSellingCnt(){
                let list = [];
                Object.assign(list,this.myProduct_list);
                let rst = list.filter(item => item.cit_status === '1');
                return rst.length;
            },
            calcFuncPendingCnt(){
                let list = [];
                Object.assign(list,this.myProduct_list);
                let rst = list.filter(item => item.cit_status === '0');
                return rst.length;
            },
            setSearchCondition: function(idx){
                this.search_condition_active_idx = idx;
            },
            checkToday: function(date){
                const input = new Date(date);
                const today = new Date();
                return input.getDate() === today.getDate() && 
                        input.getMonth() === today.getMonth() &&
                         input.getFullYear() === today.getFullYear();
            },
            funcDateType: function(t){
                if(this.dateType == t){
                    return;
                }else{
                    if(t === "Register Date"){
                        this.search_date_option = 0
                        this.dateType = t;
                    }else{
                        this.search_date_option = 1
                        this.dateType = t;
                    }
                }
            },
            formatPrice: function(kr, en, simbol){
                if(!simbol){
                    if(this.$i18n.locale === 'en'){
                        return en;
                    }else{
                        return kr;
                    }
                }
                if(this.$i18n.locale === 'en'){
                    return '$ '+ Number(en).toLocaleString(undefined, {minimumFractionDigits: 0});
                }else{
                    return '₩ '+ Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
                }
            },
            formatNumber(n){
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
            },
            formatCitName: function(data, limitLth){
                let rst;
                if(limitLth < data.length && data.length <= limitLth*2){
                    rst = data.substring(0,limitLth) + '<br/>' + data.substring(limitLth,limitLth*2);
                }else if(limitLth < data.length && limitLth*2 < data.length){
                    rst = data.substring(0,limitLth) + '<br/>' + data.substring(limitLth,limitLth*2) + '...';
                }else{
                    rst = data
                }
                return rst;
            },
            productEditBtn: function(key){
                console.log("productEditBtn:" +key);
                window.location.href = '/mypage/regist_item/'+key;
            },
            isEmpty: function(str){
                if(typeof str == "undefined" || str == null || str == "")
                    return true;
                else
                    return false ;
            },
            updateSearchDate(date){
                console.log(date);
                if(this.isEmpty(date.start) || this.isEmpty(date.end)){
                    this.goSearchDate();
                }else{
                    this.start_date = date.start
                    this.end_date = date.end
                    this.goSearchDate();
                }
            },
            resetSearchDate(date){
                this.start_date = ''
                this.end_date = ''
                this.goSearchDate();
            },
            getGenre(g1, g2){
                if(this.isEmpty(g2)){
                    return g1;
                }else{
                    return g1 + ', ' + g2;
                }
            },
            playAudio(i) {
                if(!this.isPlay || this.currentPlayId !== i.cit_id) {
                    if (this.currentPlayId !== i.cit_id) {
                        this.setAudioInstance(i)
                    }
                    this.currentPlayId = i.cit_id
                    EventBus.$emit('player_request_start',{'_uid':this._uid,'item':i,'ws':this.wavesurfer});
                    this.start();
                }
                else {
                    EventBus.$emit('player_request_stop',{'_uid':this._uid,'item':i,'ws':this.wavesurfer});
                    this.stop();
                }
            },
            setAudioInstance(item) {
                if (!this.wavesurfer) {
                    this.wavesurfer = WaveSurfer.create({
                        container: "#playerContainer",
                        waveColor: "#696969",
                        progressColor: "#c3ac45",
                        hideScrollbar: true,
                        height: 40,
                    });
                }

                if(item.cde_id) {
                    this.wavesurfer.load(`/cmallact/download_sample/${item.cde_id}`);
                    //this.wavesurfer.load(`/uploads/cmallitemdetail/${item.cde_filename}`);
                }

                this.wavesurfer.on("ready", () => {
                    this.wavesurfer.play();
                });
            },
            stop() {
                if(this.wavesurfer) {
                    this.wavesurfer.pause();
                }
                this.isPlay = false;

            },
            start(isInit) {
                if(this.wavesurfer) {
                    this.wavesurfer.play();
                }
                if(!isInit) {
                    this.isPlay = true;
                }
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    @import '/assets/plugins/flatpickr/flatpickr.css';

    // 임시수정 2020-06-04
    .select-genre .checkbox {
        font-size: 1rem;
    }

    .productList {
        .playList__item {
            .option {
                > div {
                    flex-direction: column;
                }
            }
        }
    }
    .playList__item--button {
        display: flex;
        flex-direction: row;
        color: white;
        text-align: left;
    }
    .mypage.sublist .search-date {
        min-width: 256px;
    }
    .productList .playList__item > * {
        height: auto;
    }

</style>