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
                                <li @click="goPage('')">Dashboard</li>
                                <li @click="goPage('profilemod')">Manage Information</li>
                                <li @click="goPage('list_item')">Product List</li>
                                <li @click="goPage('mybilling')">Order History</li>
                                <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">Sales History</li>
                                <li @click="goPage('seller')" v-show="group_title == 'SELLER'">Settlement History</li>
                                <li class="active">Message</li>
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
                        

                        <div class="row" style="margin-bottom:30px;">
                            
                            <div class="title-content">
                                <div class="title">
                                    <div>Message</div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-bottom:30px;">

                            <div class="message">
                                <div>
                                    <div class="sort">
                                        <div class="custom-select">
                                            <button class="selected-option">All</button>
                                            <div class="options" style="display: block;">
                                                <button data-value="" class="option"> Read </button>
                                                <button data-value="" class="option"> Unread </button>
                                            </div>
                                        </div>
                                        <div class="input_wrap line">
                                            <input type="text" placeholder="Enter your searchword...">
                                            <button>
                                                <img src="/assets/images/icon/searchicon.png">
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="playList board fold messageList">
                                            <ul>
                                                <li class="playList__itembox">
                                                    <div class="playList__item playList__item--title nowrap active">
                                                        <div class="portait">
                                                            <img src="/assets/images/member_default.png"/>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <div class="user">User_001</div>
                                                                <div class="date">0000-00-00 00:00:00</div>
                                                            </div>
                                                            <div>
                                                                <div class="body">You recieved a message.</div>
                                                                <div class="noti">1</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="playList__itembox">
                                                    <div class="playList__item playList__item--title nowrap ">
                                                        <div class="portait">
                                                            <img src="/assets/images/member_default.png"/>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <div class="user">User_001</div>
                                                                <div class="date">0000-00-00 00:00:00</div>
                                                            </div>
                                                            <div>
                                                                <div class="body">You recieved a message.</div>
                                                                <div class="noti">1</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="playList__itembox">
                                                    <div class="playList__item playList__item--title nowrap ">
                                                        <div class="portait">
                                                            <img src="/assets/images/member_default.png"/>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <div class="user">User_001</div>
                                                                <div class="date">0000-00-00 00:00:00</div>
                                                            </div>
                                                            <div>
                                                                <div class="body">You recieved a message.</div>
                                                                <div class="noti">1</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="playList__itembox">
                                                    <div class="playList__item playList__item--title nowrap ">
                                                        <div class="portait">
                                                            <img src="/assets/images/member_default.png"/>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <div class="user">User_001</div>
                                                                <div class="date">0000-00-00 00:00:00</div>
                                                            </div>
                                                            <div>
                                                                <div class="body">You recieved a message.</div>
                                                                <div class="noti">1</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="playList__itembox">
                                                    <div class="playList__item playList__item--title nowrap ">
                                                        <div class="portait">
                                                            <img src="/assets/images/member_default.png"/>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <div class="user">User_001</div>
                                                                <div class="date">0000-00-00 00:00:00</div>
                                                            </div>
                                                            <div>
                                                                <div class="body">You recieved a message.</div>
                                                                <div class="noti">1</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="messageChat">
                                    <div class="head">
                                        <div class="portait">
                                            <img src="/assets/images/member_default.png"/>
                                         </div>
                                        <div>
                                            <div class="user">User_001</div>
                                            <div class="bio">DROP THE NEW BEAT!</div>
                                        </div>
                                    </div>
                                    <div class='body'>
                                        <div>
                                            <div class="chatBalloon">
                                                <div>
                                                    Hey! I want make beats with you!
                                                </div>
                                                <div class="date">2020-04-20 15:53:42
                                                    <span></span>
                                                </div>
                                            </div>
                                             <div class="chatBalloon me">
                                                <div>Hi, User1!<br/> I love it and so exciting!<button class="btn btn--glass"><img src="/assets/images/icon/file.png"/>powerfulbeat.mp3</button>
                                                </div>
                                                <div class="date">
                                                    <span class="active">Seen</span>
                                                    2020-04-20 15:53:42
                                                </div>
                                            </div>
                                        </div>

                                        <div class="attached active">
                                            <div class="btn btn--glass">
                                                <img src="/assets/images/icon/file.png"/>powerfulbeat.mp3
                                                <button class="close">
                                                    <img src="/assets/images/icon/x-white.png"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="foot">
                                        <label class="btn btn--glass" for="attachbtn">
                                            <input type="file" id="attachbtn" style="display:none;">
                                            <img style="height:24px;" src="/assets/images/icon/file.png"/>
                                        </label>

                                        <div>
                                            <div class="input_wrap inputbox unit">
                                                <input type="text" placeholder="Enter your message...">
                                            </div>
                                            <button class="btn btn--blue" style="width:64px;margin-left:-10px;">
                                                <img src="/assets/images/icon/send.png"/>
                                            </button>
                                        </div>

                                    </div>

                                </div>
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