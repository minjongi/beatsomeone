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
                                <li @click="goPage('')">Dashboard</li>
                                <li class="active">Manage Information</li>
                                <li @click="goPage('list_item')">Product List</li>
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
                        <div class="row">

                            <div class="title-content">
                                <div class="title">
                                    <div>Manage Information</div>
                                </div>
                            </div>
                            <div class="box" style="padding-bottom:50px;">
                                <div class="row">
                                    <div class="type"><span>Username</span></div>
                                    <div class="data">
                                        <div class="input_wrap col">
                                            <input class="inputbox" type="text" value="KKOMA" placeholder="Enter your new username..." @click="$event.currentTarget.value = ''" @focusout="$event.currentTarget.value = 'KKOMA'">
                                            <div class="caution">
                                                <div>
                                                    <img class="caution" src="/assets/images/icon/caution.png">
                                                    <img class="warning" src="/assets/images/icon/warning.png">
                                                </div>
                                                <span>
                                                    Please note that the login ID will change when you change your email.
                                                </span>
                                            </div>
                                        </div>
                                        <button class="btn btn--blue active">
                                            Change
                                        </button>    
                                    </div>
                                    <div class="">
                                        <button class="btn btn--gray">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="type"><span>User Group</span></div>
                                    <div class="data">
                                       <div class="group_title" :class="group_title">{{group_title}}</div>  
                                    </div>
                                </div>
                                <div class="row" v-show="group_title == 'SELLER'">
                                    <div class="type"><span>Seller Class</span></div>
                                    <div class="data">
                                       <div class="seller_class" :class="seller_class">{{seller_class}}</div>  
                                       <div class="seller_class FREE">FREE</div>  
                                       <div class="seller_class PRO">PRO</div>  
                                    </div>
                                    <div class="active">
                                        <button class="btn btn--yellow round">
                                            Upgrade Now
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>Email</span></div>
                                    <div class="data">
                                        <div class="input_wrap col">
                                            <input class="inputbox" type="mail" value="jisoo@naver.com" placeholder="Enter your new username..." @click="$event.currentTarget.value = ''" @focusout="$event.currentTarget.value = 'jisoo@naver.com'">
                                            <div class="caution">
                                                <div>
                                                    <img class="caution" src="/assets/images/icon/caution.png">
                                                    <img class="warning" src="/assets/images/icon/warning.png">
                                                </div>
                                                <span>
                                                    Please note that the login ID will change when you change your email.
                                                </span>
                                            </div>
                                        </div>
                                        <button class="btn btn--blue active">
                                            Save
                                        </button>    
                                    </div>
                                    <div class="active">
                                        <button class="btn btn--gray">
                                            Cancel
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>Password</span></div>
                                    <div class="data">
                                        <button class="btn btn--blue">
                                            Change Password
                                        </button>
                                    </div>
                                    <div></div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>Type</span></div>
                                    <div class="data">
                                        <label for="type1" class="checkbox">
                                            <input type="radio" name="type" hidden="hidden" id="type1" value="Music Lover">
                                            <span></span><div> Music Lover</div>
                                        </label>
                                        <label for="type2" class="checkbox">
                                            <input type="radio" name="type" hidden="hidden" id="type2" value="Recording Artist">
                                            <span></span><div> Recording Artist</div>
                                        </label>
                                        <label for="type3" class="checkbox">
                                            <input type="radio" name="type" hidden="hidden" id="type3" value="Music Producer">
                                            <span></span><div> Music Producer</div>
                                        </label>
                                        <label for="type4" class="checkbox">
                                            <input type="radio" name="type" hidden="hidden" id="type4" value="Artist/Producer">
                                            <span></span><div> Artist/Producer</div>
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>Name</span></div>
                                    <div class="data">
                                        <input class="inputbox firstname" type="text" value="Jisoo" placeholder="Enter your firstname..." @click="$event.currentTarget.value = ''" @focusout="$event.currentTarget.value = 'Jisoo'">
                                        <input class="inputbox lastname" type="text" value="Yoo" placeholder="Enter your lastname..." @click="$event.currentTarget.value = ''" @focusout="$event.currentTarget.value = 'Yoo'">
                                    </div>
                                    <div></div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>City of Residence, State</span></div>
                                    <div class="data">
                                        <input class="inputbox" type="text" value="Seoul, South Korea" placeholder="Enter your location..." @click="$event.currentTarget.value = ''" @focusout="$event.currentTarget.value = 'Seoul, South Korea'">
                                    </div>
                                    <div></div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>Bio</span></div>
                                    <div class="data">
                                        <textarea class="firstname" type="text" value="Seoul, South Korea" placeholder="Enter your location..." @click="$event.currentTarget.value = ''" @focusout="$event.currentTarget.value = 'Seoul, South Korea'"/>
                                    </div>
                                    <div></div>
                                </div>

                                <div class="row">
                                    <div class="type"><span>Linked Account</span></div>
                                    <div class="data">
                                        <div class="sns">
                                            <div>
                                                <div><img src="/assets/images/icon/icon_kakao.png"/> Kakao</div>
                                                <button class="btn btn--yellow">Link</button>
                                            </div>
                                            <div>
                                                <div><img src="/assets/images/icon/icon_naver.png"/> Naver</div>
                                                <button class="btn btn--gray">Unlink</button>
                                            </div>
                                            <div>
                                                <div><img src="/assets/images/icon/icon_facebook.png"/> Facebook</div>
                                                <button class="btn btn--yellow">Link</button>
                                            </div>
                                            <div>
                                                <div><img src="/assets/images/icon/icon_twitter.png"/> Twitter</div>
                                                <button class="btn btn--gray">Unlink</button>
                                            </div>
                                            <div>
                                                <div><img src="/assets/images/icon/icon_google.png"/> Google</div>
                                                <button class="btn btn--gray">Unlink</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div></div>
                                </div>

                            </div>

                            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                                <button class="btn btn--gray">Cancel</button>
                                <button type="submit" class="btn btn--submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="waveform" ></div>
        
        <div class="panel active">
            <div class="popup active" style="width:560px;">
                <div class="box" style="padding-bottom:50px;">
                    <div class="title">CHANGE PASSWORD</div>
                    <p>※ Please enter the password within 8 to 12 characters in English (case sensitive) and numeric combination.</p>
                    <div class="col">
                        <div class="type"><span>Current password</span></div>
                        <div class="data">
                            <div class="input_wrap col">
                                <input class="inputbox" type="password" placeholder="Enter your current password...">
                                <div class="caution">
                                    <div>
                                        <img class="caution" src="/assets/images/icon/caution.png">
                                        <img class="warning" src="/assets/images/icon/warning.png">
                                    </div>
                                    <span>
                                        Please note that the login ID will change when you change your email.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="type"><span>New password</span></div>
                        <div class="data">
                            <div class="input_wrap col">
                                <input class="inputbox" type="password" placeholder="Enter your new password...">
                                <div class="caution">
                                    <div>
                                        <img class="caution" src="/assets/images/icon/caution.png">
                                        <img class="warning" src="/assets/images/icon/warning.png">
                                    </div>
                                    <span>
                                        Please note that the login ID will change when you change your email.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="type"><span>New password confirm</span></div>
                        <div class="data">
                            <div class="input_wrap col">
                                <input class="inputbox" type="password" placeholder="Enter your new password again...">
                                <div class="caution">
                                    <div>
                                        <img class="caution" src="/assets/images/icon/caution.png">
                                        <img class="warning" src="/assets/images/icon/warning.png">
                                    </div>
                                    <span>
                                        Please note that the login ID will change when you change your email.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btnbox col">
                        <button class="btn btn--gray">Cancel</button>
                        <button type="submit" class="btn btn--blue">Save</button>
                    </div>
                </div>
            </div>
        </div>
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
                seller_class: 'MARKET PLACE',
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