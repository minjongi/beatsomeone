<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>

        <div class="container sub">
            <div class="mypage sublist">
                <div class="wrap inquiryview-wrap">
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
                            <li @click="goPage('')">Dashboard</li>
                            <li @click="goPage('profilemod')">Manage Information</li>
                            <li @click="goPage('list_item')">Product List</li>
                            <li @click="goPage('mybilling')">Order History</li>
                            <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">Sales History</li>
                            <li v-show="group_title == 'SELLER'">Settlement History</li>
                            <li @click="goPage('message')">Message</li>
                            <li v-show="group_title == 'CUSTOMER'">Seller Register</li>
                            <li class="active" @click="goPage('inquiry')">Support
                                <!-- <ul class="menu">
                                    <li @click="goPage('inquiry')">Support Case</li>
                                    <li @click="goPage('faq')">FAQ</li>
                                </ul> -->
                            </li>
                        </ul>
                    </div>

                    <div class="sublist__content">

                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board inquirylist">
                                <div class="tab" style="height:48px;">
                                    <div class="active" @click="goPage('inquiry')">Support Case</div>
                                    <div @click="goPage('faq')">FAQ</div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px;">
                            <button class="btn btn--gray">Back</button>
                        </div>

                        <div class="row" style="margin-bottom:30px;">
                            <div class="content-header">
                                <div class="n-flex column">
                                    <h4 class="category">Title</h4>
                                    <p class="body">I have some question about using service.</p>
                                </div> 

                                <div class="n-flex">
                                    <span class="category">Status</span>
                                    <span class="body action active">Wait...</span>
                                </div>
                                <div class="n-flex">
                                    <span class="category">Date</span>
                                    <span class="body">0000-00-00 00:00:00</span>
                                </div>
                                <div class="n-flex column">
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

                        <div class="row">
                            <div>
                                <button class="btn btn--gray">Cancel</button>
                                <!-- <button type="submit" class="btn btn--submit">Edit</button> -->
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
            // Header, Footer
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
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .sub .sublist .row {
        margin-bottom: 0;
        }
        .sub .sublist .tab {
        align-items: center;
        background-color: #2b2c30;
        border-bottom: none;
        > div {
            flex: 1;
            text-align: center;
            font-size: 12px;
            line-height: 14px;
            color: rgb(white, 0.7);
            padding: 0 20px;
            &.active {
            color: #ffda2a;
            }
        }
        }
        .sub .playList .playList__item .index {
        color: rgba(white, 0.7);
        }
        .sublist .sort {
        > div {
            + div {
            margin-left: 10px;
            }
        }
        }
        .sub .playList .playList__item .subject {
        font-weight: normal;
        }

        .category {
            min-width: 130px;
            max-width: 130px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .n-flex {
            &+.n-flex {
                margin-top: 20px;
                line-height: 16px;
            }
            .body.active {
                color: #ffda2a;
            }
        }
        
        .flie_list {
            button {
                float: left;
                margin-right: 16px;
                color: rgba(white, 0.7);
                display: flex;
                margin-bottom: 5px;
                align-items: center;
                font-size: 14px;
                >img {
                    margin-right: 4px;
                }
            }
        }

        .inquiryview {
            margin-right: -16px;
            margin-left: -16px;
        }

        .question {
            background-color: #2B2C30;
            padding: 16px;
            .row {
                position: relative;
                .mark {
                    position: absolute;
                    font-size: 32px;
                    line-height: 1;
                    font-weight: 600;
                    
                }
                .answer {
                    font-size: 14px;
                    line-height: 1.6;
                    padding-left: 40px;
                }
            }
            &.stay {
                background-color: #203040;
                .row {
                    .mark {
                        color: #4890FF;
                    }
                }
            }
            &.complete {
                background-color: #383020;
                .row {
                    .mark {
                        color: #FFDA2A;
                    }
                }
            } 
        }
</style>