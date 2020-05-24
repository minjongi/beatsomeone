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
                                <li class="active" @click="$router.push('');">Dashboard</li>
                                <li @click="$router.push('profilemod');">Manage Information</a></li>
                                <li @click="$router.push('list_item');">Product List</a></li>
                                <li>Order History</li>
                                <li v-show="group_title == 'SELLER'">Sales History</li>
                                <li v-show="group_title == 'SELLER'">Settlement History</li>
                                <li>Message</li>
                                <li v-show="group_title == 'CUSTOMER'">Seller Register</li>
                                <li class="active">Support
                                    <ul class="menu">
                                        <li class="active" @click="$router.push('inquirylist');">Support Case</li>
                                        <li @click="$router.push('/faq');">FAQ</li>
                                    </ul>
                                </li><!-- 
                                <li><a href="/">Inquiry</a></li>
                                <li><a @click="goInquiryview()">Inquiryview</a></li>
                                <li><a @click="goInquirymod()">Inquirymod</a></li> -->
                            </ul>
                        </div>
                    </div>

                    <div class="sublist__content">
                        <div class="row">

                            <div class="row" style="margin-bottom:30px;">
                                
                                <div class="title-content">
                                    <div class="title">
                                        <div>Support</div>
                                        <button class="btn btn--gray">Back</button>
                                    </div>
                                </div>

                            </div>

                            <div class="row" style="margin-bottom:30px;">
                                <div class="content-header">
                                    <div>
                                        <div>
                                            <div class="category">Title</div>
                                            <div class="body">testestestestestestestestesteststestesttestestestestsest</div>
                                        </div>  
                                    </div>

                                    <div>
                                        <div>
                                            <div class="category">Status</div>
                                            <div class="body action active">Wait...</div>
                                        </div>
                                        <div>
                                            <div class="category">Date</div>
                                            <div class="body">0000-00-00 00:00:00</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="category">Attachment</div>
                                        <div class="flie_list">
                                            <button class="btn--file">
                                                <img src="/assets/images/icon/file.png"/>
                                                <span>musicsong1.mp3</span>
                                            </button>
                                            <button class="btn--file">
                                                <img src="/assets/images/icon/file.png"/>
                                                <span>musicsong2.mp3</span>
                                            </button>
                                            <button class="btn--file">
                                                <img src="/assets/images/icon/file.png"/>
                                                <span>musicsong3.mp3</span>
                                            </button>
                                        </div>
                                    </div>                                  
                                </div>
                            </div>

                            <div class="row" style="margin-bottom:30px;">
                                <div class="playList array inquiryview">

                                    <ul>
                                        <li class="playList__itembox">
                                            <div class="playList__item playList__item--title nowrap question stay">
                                                <div class="row">
                                                    <div class="mark">Q</div>
                                                    <div class="answer">
                                                        When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                                        If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                                         BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                                         <br/>
                                                        After the changes have been made, the rights for sale will be opened.<br/>
                                                        From this point on, you can sell the beats you have made.<br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="playList__itembox">
                                            <div class="playList__item playList__item--title nowrap question">
                                                <div class="row">
                                                    <div class="mark"></div>
                                                    <div class="answer">
                                                        Hi, KKOMA<br/>
                                                        We will respond to you after checking the contents.<br/>
                                                        <br/>
                                                        Beat someone Team.
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="playList__itembox">
                                            <div class="playList__item playList__item--title nowrap question complete">
                                                <div class="row">
                                                    <div class="mark">A</div>
                                                    <div class="answer">
                                                        Hi, KKOMA<br/>
                                                        We fixed an error after checking the file.<br/>
                                                        It may be cumbersome, but please upload it again.<br/>
                                                        <br/>
                                                        Beat someone Team.
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                                <button class="btn btn--gray">Cancel</button>
                                <button type="submit" class="btn btn--submit">Edit</button>
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
            goInquiryview() {
                this.$router.push({path: '/inquiryview'});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
        },
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