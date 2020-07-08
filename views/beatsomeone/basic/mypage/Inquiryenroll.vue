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
                                        <div class="group_title" :class="group_title">{{$t(group_title)}}</div>
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
                                        <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">{{ $t('goToBrandshop') }} ></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ul class="menu">
                                <li @click="goPage('')">{{$t('dashboard')}}</li>
                                <li @click="goPage('#/profilemod')">{{$t('manageInformation')}}</li>
                                <li @click="goPage('list_item')">{{$t('productList')}}</li>
                                <li @click="goPage('mybilling')">{{$t('orderHistory')}}</li>
                                <li @click="goPage('regist_item')" v-show="group_title == 'SELLER'">{{$t('registrationOfBeat')}}</li>
                                <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">{{$t('salesHistory')}}</li>
                                <li @click="goPage('seller')" v-show="group_title == 'SELLER'">{{$t('settlementHistory')}}</li>
                                <li @click="goPage('message')">{{$t('chat')}}</li>
                                <li @click="goPage('sellerreg')" v-show="group_title == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
                                <li class="active">{{$t('support1')}}
                                    <ul class="menu">
                                        <li class="active">{{$t('supportCase')}}</li>
                                        <li @click="goPage('faq')">FAQ</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="sublist__content">
                        <div class="row">

                            <div class="row" style="margin-bottom:30px;">
                                
                                <div class="title-content">
                                    <div class="title">
                                        <div>{{$t('support1')}}</div>
                                        <button class="btn btn--gray">{{$t('back')}}</button>
                                    </div>
                                </div>

                            </div>

                            <div class="box" style="padding-bottom:50px;">
                                <div class="row">
                                    <div class="type"><span>Title</span></div>
                                    <div class="data">
                                        <div class="input_wrap col">
                                            <input class="inputbox" type="text" placeholder="Please enter your title about problem..." />
                                        </div>
                                    </div>
                                </div>

                                <div class="row" v-show="group_title == 'SELLER'">
                                    <div class="type"><span>Writer</span></div>
                                    <div class="data">
                                        <div class="group_title" :class="group_title">{{$t(group_title)}}</div>
                                        <div class="seller_class" :class="seller_class">{{seller_class}}</div>
                                        <div class="username">KKOMA</div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="type"><span>Bio</span></div>
                                    <div class="data">
                                        <textarea class="firstname" type="text" placeholder="Please decribe your problem detaily..." style="height:360px"/>
                                    </div>
                                </div>


                                <div class="row" v-show="group_title == 'SELLER'">
                                    <div class="type"><span>Attachment</span></div>
                                    <div class="data">
                                        <div>
                                            <div class="flie_list">
                                                <div>
                                                    <span>No attached file.</span>
                                                </div>
                                                <div>
                                                    <img src="/assets/images/icon/file.png"/>
                                                    <span>musicsong1.mp3</span>
                                                    <img src="/assets/images/icon/delete.png"/>
                                                </div>
                                            </div>
                                            <div class="caution">
                                                <div>
                                                    <img class="caution" src="/assets/images/icon/caution.png"/>
                                                    <img class="warning" src="/assets/images/icon/warning.png"/>
                                                </div>
                                                <span>
                                                    {{$t('noteChangeEmailMsg')}}
                                                </span>
                                            </div>
                                        </div>
                                        <label class="btn btn--blue" for="attachbtn">
                                            <input type="file" id="attachbtn" style="display:none;">
                                            <div>Attach</div>
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                                <button class="btn btn--gray" @click="goPage('inquiry')">Cancel</button>
                                <button type="submit" class="btn btn--submit">Submit</button>
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
                seller_class: 'MARKET PLACE',
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
            goInquiryview() {
                this.$router.push({path: '/inquiryview'});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
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