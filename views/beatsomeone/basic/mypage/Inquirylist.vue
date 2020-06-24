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
                                <li @click="goPage('message')">Message</li>
                                <li @click="goPage('sellerreg')" v-show="group_title == 'CUSTOMER'">Seller Register</li>
                                <li class="active">Support
                                    <ul class="menu">
                                        <li class="active">Support Case</li>
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
                                    <div>Support</div>
                                    <button class="btn btn--submit" @click="goInquiryenroll">To ask question</button>
                                </div>
                                <p>
                                    Total <span>100</span> cases.
                                </p>
                            </div>

                        </div>

                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board inquirylist">
                                <div class="tab nowrap">
                                    <div class="index">No</div>
                                    <div class="subject">Title</div>
                                    <div class="date">Date</div>
                                    <div class="action">Status</div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:30px;">
                            <div class="playList board inquirylist">

                                <ul>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action">
                                                Answer Complete
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action">
                                                Answer Complete
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action">
                                                Answer Complete
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox" @click="goInquiryview">
                                        <div class="playList__item playList__item--title nowrap active">
                                            <div class="index">000</div>
                                            <div class="subject">I have some question about using service.</div>
                                            <div class="date">
                                                0000-00-00 00:00:00
                                            </div>
                                            <div class="action active">
                                                Wait...
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>

                        <div class="row" style="margin-bottom:30px;">
                            <div class="pagination">
                                <div>
                                    <button class="prev active"><img src="/assets/images/icon/chevron_prev.png"/></button>
                                    <button class="active">1</button>
                                    <button>2</button>
                                    <button>3</button>
                                    <button>4</button>
                                    <button>5</button>
                                    <button>6</button>
                                    <button>7</button>
                                    <button>8</button>
                                    <button>9</button>
                                    <button>10</button>
                                    <button class="next active"><img src="/assets/images/icon/chevron_next.png"/></button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="sort" style="display:flex; width:50%; margin:auto; flex-flow:row nowrap">
                                <div class="custom-select">
                                    <button class="selected-option">
                                        Total
                                    </button>
                                    <div class="options">
                                        <button data-value="" class="option"> Title </button>
                                        <button data-value="" class="option"> Content </button>
                                    </div>
                                </div>
                                <div class="input_wrap line" style="margin-left:20px; width:100%;">
                                    <input type="text" placeholder="Enter your searchword...">
                                    <button><img src="/assets/images/icon/searchicon.png"/></button>
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
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            goInquiryview() {
                this.$router.push({path: '/inquiryview'});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
            goInquiryenroll() {
                this.$router.push({path: '/inquiryenroll'});
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
</style>