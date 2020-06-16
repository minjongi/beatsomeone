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
                                        <div class="custom-select custom-select-dropdown">
                                            <button class="selected-option">
                                                {{ dateType }}
                                            </button>
                                            <div class="options" >
                                            <button v-show="dateType != 'All'" class="option" @click="funcDateType('All')"> All </button>
                                            <button v-show="dateType != 'Read'" class="option" @click="funcDateType('Read')"> Read </button>
                                            <button v-show="dateType != 'Unread'" data-value="" class="option" @click="funcDateType('Unread')"> Unread  </button>
                                            </div>
                                        </div>
                                        <div class="input_wrap line" style="visibility:hidden">
                                            <input type="text" placeholder="Enter your searchword...">
                                            <button>
                                                <img src="/assets/images/icon/searchicon.png">
                                            </button>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="playList board fold messageList">
                                            <ul>
                                                <li v-for="(m, i) in messageList" v-bind:key="i" class="playList__itembox" @click="goMChat($event, m)">
                                                    <div class="playList__item playList__item--title nowrap">
                                                        <div class="portait">
                                                            <img v-if="m.mem_photo === ''" src="/assets/images/portait.png"/>
                                                            <img v-else :src="'/uploads/member_photo/' + m.mem_photo" alt="">
                                                        </div>
                                                        <div>
                                                            <div>
                                                                <div class="user">{{ m.mem_nickname }}</div>
                                                                <div class="date">{{ m.nte_datetime }}</div>
                                                            </div>
                                                            <div>
                                                                <div class="body">{{ formatConName(m.nte_content, 50) }}</div>
                                                                <div v-show="m.unread != 0" class="noti">{{ m.unread }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <!--
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
                                                -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="messageChat" :style="'display: '+mchat">
                                    <div class="head">
                                        <div class="portait">
                                            <img v-if="mchatUserPhoto === ''" src="/assets/images/member_default.png"/>
                                            <img v-else :src="'/uploads/member_photo/' + mchatUserPhoto" alt="">
                                         </div>
                                        <div>
                                            <div class="user">{{ mchatUser }}</div>
                                            <div class="bio">{{ mchatUserBio }}</div>
                                        </div>
                                    </div>
                                    <div class='body'>
                                        <div>
                                            <div v-for="(m, i) in messageDetail" v-bind:key="m.nte_id" class="chatBalloon" :class="mem_id === m.send_mem_id ? 'me' : ''">
                                                <div v-html="m.nte_content">
                                                    <button v-if="m.nte_filename != ''" class="btn btn--glass">
                                                        <img src="/assets/images/icon/file.png"/>{{ m.nte_filename }}
                                                    </button>
                                                </div>
                                                <div class="date">
                                                    <span v-if="m.nte_read_datetime != '' && mem_id != m.send_mem_id" class="active">Seen</span>
                                                    {{ m.nte_datetime }}
                                                    <span v-if="mem_id === m.send_mem_id"></span>
                                                }
                                                </div>
                                            </div>
                                        </div>

                                        <div class="attached" :class="attfilename != '' ? 'active' : ''">
                                            <div class="btn btn--glass">
                                                <img src="/assets/images/icon/file.png"/>{{attfilename}}
                                                <button class="close">
                                                    <img src="/assets/images/icon/x-white.png"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="foot">
                                        <label class="btn btn--glass" for="attachbtn">
                                            <input type="file" id="attachbtn" style="display:none;" @change="attfile">
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
        <Footer/>
    </div>
</template>


<script>
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import moment from "moment";
    import axios from 'axios'
    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                isLoading: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                mem_id: '',
                mem_photo: '',
                mem_usertype: '',
                mem_nickname: '',
                mem_address1: '',
                mem_type: '',
                mem_lastname: '',
                popup_filter:0,
                dateType: 'All',
                search_date_option: 0,
                searchword: 0,
                messageList: [],
                messageDetail: [],
                mchat: 'none',
                mchatUser: '',
                mchatUserPhoto: '',
                mchatUserBio: '',
                attfilename: '',
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
            this.ajaxMessageList();
            this.ajaxUserInfo();
        },
        methods:{
            async ajaxUserInfo () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/get_user_info', {}
                );
                //console.log(data);
                this.mem_id = data[0].mem_id;
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
            async ajaxMessageList () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/message_list', {}
                );
                console.log(data);
                this.messageList = data.result;
              } catch (err) {
                console.log('ajaxMessageList error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxMessageDetail(mid) {
              try {
                this.isLoading = true;
                var param = new FormData();
                param.append('mid', JSON.stringify(mid));
                const { data } = await axios.post(
                  '/beatsomeoneApi/message_detail', param,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(data);
                this.messageDetail = data.result;
              } catch (err) {
                console.log('ajaxMessageDetail error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxMessageRead(mid) {
              try {
                this.isLoading = true;
                var param = new FormData();
                param.append('mid', JSON.stringify(mid));
                const { data } = await axios.post(
                  '/beatsomeoneApi/message_read', param,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(data);
                return data.result;
              } catch (err) {
                console.log('ajaxMessageRead error');
              } finally {
                this.isLoading = false;
              }
            },
            formatConName: function(data, limitLth){
                let rst;
                if(limitLth < data.length){
                    rst = data.substring(0,limitLth)  + '...';
                }else{
                    rst = data
                }
                return rst;
            },
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
            funcDateType: function(t){
                if(this.dateType == t){
                    return;
                }else{
                    if(t === "All"){
                        this.search_date_option = 0
                        this.dateType = t;
                    }else if(t === "Read"){
                        this.search_date_option = 1
                        this.dateType = t;
                    }else{
                        this.search_date_option = 2
                        this.dateType = t;
                    }
                }
            },
            goMChat: function(e, m){
                if(this.mchat == "none"){
                    this.ajaxMessageDetail(m.mem_id).then(()=>{
                        this.mchatUser = m.mem_nickname;
                        this.mchatUserPhoto = m.mem_photo;
                        if(this.isEmpty(m.mem_type) && this.isEmpty(m.mem_lastname)){
                            this.mchatUserBio = '';
                        }else{
                            this.mchatUserBio = m.mem_type + ', ' + m.mem_lastname;
                        }
                        this.mchat = "flex"
                    });
                    this.ajaxMessageRead(m.mem_id).then((data)=>{
                        if(data){
                            this.ajaxMessageList();
                        }
                    });
                }else{
                    this.mchat = "none"
                }
                //console.log(e);
            },
            attfile: function(e){
                console.log(e.target.files[0].name);
                this.attfilename = e.target.files[0].name;
            },
            isEmpty: function(str){
                if(typeof str == "undefined" || str == null || str == "")
                    return true;
                else
                    return false;
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets/scss/App.scss';

    .message_list_title{
        display: inline-block;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width: 150px;
        
        > * {
            display: inline-block;
            margin-left: 5px;
        }
    }
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>