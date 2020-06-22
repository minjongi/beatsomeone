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
                                </div>
                            </div>
                            <div class="profile__footer">
                                <div class="location">
                                        <img class="site" src="/assets/images/icon/position.png"/><div>{{mem_address1}}</div>
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
                            <li @click="goPage('list_item')" v-show="group_title == 'SELLER'">Product List</li>
                            <li @click="goPage('mybilling')">Order History</li>
                            <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">Sales History</li>
                            <li @click="goPage('seller')" v-show="group_title == 'SELLER'">Settlement History</li>
                            <li class="active">Message</li>
                            <li v-show="group_title == 'CUSTOMER'">Seller Register</li>
                            <li @click="goPage('inquiry')">Support
                                <!-- <ul class="menu">
                                    <li @click="goPage('inquiry')">Support Case</li>
                                    <li @click="goPage('faq')">FAQ</li>
                                </ul> -->
                            </li>
                        </ul>
                    </div>

                    <div class="sublist__content">

                        <div class="row" style="margin-bottom:20px;">

                            <div class="message">
                                <div>
                                    <div class="sort" style="margin-bottom: 20px;">
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
                                        <!-- <div class="input_wrap line">
                                            <input class="inputbox" type="text" placeholder="Enter your searchword..." :value="searchUser" @input="searchUser=$event.target.value" @keypress.enter="goSearchUser">
                                            <button @click="goSearchUser">
                                                <img src="/assets/images/icon/searchicon.png">
                                            </button>
                                        </div> -->
                                    </div>
                                    <div>
                                        <div class="playList board fold messageList">
                                            <ul>
                                                <li v-for="(m, i) in messageList" v-bind:key="i" class="playList__itembox" @click="goMChat($event, m)">
                                                    <div class="playList__item playList__item--title nowrap">
                                                        <div class="portait">
                                                            <img v-if="m.mem_photo === ''" src="/assets/images/member_default.png"/>
                                                            <img v-else :src="'/uploads/member_photo/' + m.mem_photo" alt="">
                                                        </div>
                                                        <div style="max-width: calc(100% - 64px);">
                                                            <div class="n-flex between">
                                                                <div class="user">{{ m.mem_nickname }}</div>
                                                                <div class="date">{{ m.nte_datetime }}</div>
                                                            </div>
                                                            <div class="n-flex between">
                                                                <div class="body">
                                                                    <p>
                                                                        {{ formatConName(m.nte_content, 50) }}
                                                                    </p>
                                                                </div>
                                                                <div v-show="m.unread != 0" class="noti">{{ m.unread }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- 챗팅창 -->
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
                                    <div class='body' id="messageDisplay">
                                        <div id="message-list">
                                            <div v-for="(m, i) in messageDetail" v-bind:key="m.nte_id" class="chatBalloon" :class="mem_id === m.send_mem_id ? 'me' : ''">
                                                <div>{{m.nte_content}}
                                                    <button v-if="m.nte_filename != ''" class="btn btn--glass" @click="filedown(m.nte_filename, m.nte_originname)">
                                                        <img src="/assets/images/icon/file.png"/>{{ m.nte_originname }}
                                                    </button>
                                                </div>
                                                <div class="date">
                                                    <span v-if="m.nte_read_datetime != '' && mem_id != m.send_mem_id" class="active">Seen</span>
                                                    {{ m.nte_datetime }}
                                                    <span v-if="mem_id === m.send_mem_id"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="attached" :class="attfilename != '' ? 'active' : ''">
                                            <div class="btn btn--glass">
                                                <img src="/assets/images/icon/file.png"/>{{attfilename}}
                                                <button class="close" @click="attfilename = ''">
                                                    <img src="/assets/images/icon/x-white.png"/>
                                                </button>
                                            </div>
                                        </div> -->
                                    </div>

                                    <div class="foot">
                                        <label class="btn btn--glass" for="file">
                                            <input type="file" id="file" ref="file" style="display:none;" @change="attfile" @drop="attfile">
                                            <img style="height:24px;" src="/assets/images/icon/file.png"/>
                                        </label>

                                        <div class="n-flex">
                                            <div class="input_wrap inputbox unit">
                                                <input type="text" placeholder="Enter your message..." :value="goMessText" @input="goMessText=$event.target.value" @keypress.enter="sendMess">
                                            </div>
                                            <button class="btn btn--blue" style="width:64px;margin-left:-10px;">
                                                <img src="/assets/images/icon/send.png" @click="sendMess"/>
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
    require('@/assets_m/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import moment from "moment";
    import axios from 'axios'
    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    import FileUpload from 'vue-simple-upload/dist/FileUpload'

    export default {
        components: {
            Header, Footer, FileUpload
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
                goMessText: '',
                search_date_option: 0,
                searchword: 0,
                messageList: [],
                messageDetail: [],
                mchat: 'none',
                mid: '',
                mchatUser: '',
                mchatUserPhoto: '',
                mchatUserBio: '',
                attfilename: '',
                attfileurlname: '',
                searchUser: '',
            };
        },
        watch:{
            messageList:()=>{
                let ele = document.getElementById('message-list');
                ele.scrollTop = ele.scrollHeight;
            }
        },
        mounted(){
                        // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function() {

                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                if($(this).hasClass("active")){
                    $(this).addClass("active");
                    $(this).find(".options").show();
                }else{
                    $(this).removeClass("active");
                    $(this).find(".options").hide();
                }
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
                        this.ajaxMessageList();
                    }else if(t === "Read"){
                        this.search_date_option = 1
                        this.dateType = t;
                        this.ajaxMessageList().then(()=>{
                            this.messageList = this.messageList.filter(item => item.unread == 0);
                        });
                    }else{
                        this.search_date_option = 2
                        this.dateType = t;
                        this.ajaxMessageList().then(()=>{
                            this.messageList = this.messageList.filter(item => item.unread > 0);
                        });
                    }
                }
            },
            goMChat: function(e, m){
                if(this.mchat == "none"){
                    this.mchat = "flex";
                }
                this.ajaxMessageDetail(m.mem_id).then(()=>{
                    this.mid = m.mem_id;
                    this.mchatUser = m.mem_nickname;
                    this.mchatUserPhoto = m.mem_photo;
                    if(this.isEmpty(m.mem_type) && this.isEmpty(m.mem_lastname)){
                        this.mchatUserBio = '';
                    }else{
                        this.mchatUserBio = m.mem_type + ', ' + m.mem_lastname;
                    }

                    var messageDisplay = document.getElementById("messageDisplay");
                    messageDisplay.scrollTop = messageDisplay.scrollHeight;
                });
                this.ajaxMessageRead(m.mem_id).then((data)=>{
                    if(data){
                        this.ajaxMessageList().then(()=>{
                            console.log(this.tempList.length);
                            for(let i in this.tempList){
                                this.messageList.push(this.tempList[i]);
                            }
                            this.tempList = [];
                        });
                    }
                });
                //console.log(e);
            },
            attfile: function(e){
                //console.log(e);
                this.attfilename = e.target.files[0].name;
                const formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);
                const url = "/beatsomeoneApi/upload_message_file";
                axios.post(url, formData).then(r => {
                    console.log(r.data);
                    if(0 < r.data.filesize){
                        //
                    }else{
                        alert('파일을 다시 확인해주세요');
                    }
                    this.attfileurlname = r.data.filename;
                })
            },
            sendMess: function(e){
                let fn = '';
                let fnurl = '';
                if(!this.isEmpty(this.attfilename)){
                    fn = this.attfilename;
                    fnurl = this.attfileurlname;
                }
                const formData = new FormData();
                formData.append('rmid', JSON.stringify(this.mid));
                formData.append('message', JSON.stringify(this.goMessText));
                formData.append('filename', JSON.stringify(fn));
                formData.append('fileurlname', JSON.stringify(fnurl));
                const url = "/beatsomeoneApi/message_send";
                axios.post(url, formData).then(r => {
                    console.log(r);
                    if(r.data.message == 'ok'){
                        this.attfilename = '';
                        this.attfileurlname = '';
                        this.goMessText = '';
                        this.ajaxMessageDetail(this.mid);
                        this.ajaxMessageList();
                    }
                });
            },
            isEmpty: function(str){
                if(typeof str == "undefined" || str == null || str == "")
                    return true;
                else
                    return false;
            },
            forceFileDownload(r, on){
                const blob = new Blob([r.data], { type: 'application/octet-stream' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = on;
                link.click();
                URL.revokeObjectURL(link.href);
            },
            filedown : function(fn, on){
                let param = {"fn":fn, "on":on};
                axios.get('/cmallact/download_messfile', {params: param, responseType: 'arraybuffer'})
                .then(r => {
                    console.log(r);
                    this.forceFileDownload(r, on);
                })
                .catch((e) => console.log(e));
            },
            goSearchUser : function(){
                console.log(this.searchUser);

                for(let l in this.messageList){
                    if(this.messageList[l].mem_nickname == this.searchUser){
                        this.goMChat('', this.messageList[l]);
                        return;
                    }
                }

                let param = {'searchUser': JSON.stringify(this.searchUser)};
                axios.get('/beatsomeoneApi/get_userid_info', {params: param})
                .then(r => {
                    console.log(r.data.length);
                    if(r.data.length == 0){
                        alert('유저 아이디를 다시 확인해주세요');
                    }else{
                        let data = {'mem_id':r.data[0].mem_id,'mem_nickname':r.data[0].mem_nickname,
                            'nte_content':'','nte_datetime':'','unread':0};
                        this.tempList.push(data);
                        this.messageList.push(data);
                    }
                })
                .catch((e) => console.log(e));

            },
        },
        updated(){
          let ele = document.getElementById('message-list');
          ele.scrollTop = ele.scrollHeight;
        }
    }
</script>


<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .input_wrap {
        display: flex !important;
        align-items: center;
        font-weight: bolder;

        > * {
            vertical-align: middle;
        }

        & + button {
            margin-left: -4px;
        }

        &.line {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
        }

        &.round {
            border-radius: 100px;
        }

        &.col {
            flex-direction: column;
        }

        input {
            width: 100%;
            color: white;
            font-size: 14px;

            & ~ * {
            color: white;
            }

            & + button {
            opacity: 0.3;
            transition: 0.3s ease;

            > * {
                vertical-align: middle;
            }

            &:hover {
                opacity: 1;
            }
            }
        }

        .inputbox,
        textarea {
            width: 100%;
            font-size: 14px;
            height: 20px;
            padding: 20px 10px;
            border-radius: 4px;
            color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            transition: 0.3s ease;

            &::placeholder {
            color: rgba(255, 255, 255, 0.3);
            }

            &:hover {
            background: rgba(255, 255, 255, 0.3);
            }

            &:focus {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 1);
            }

            & + .btn {
            margin-left: -4px;
            }

            & + .caution {
            width: 100%;
            margin-top: 10px;
            }
        }
    }

.sub .mypage .portait {
    width: 48px;
    height: 48px;
}
.sub .board .playList__item {
    display: flex;
    .user {
        font-size: 16px;
        line-height: 19px;
        color: white;
    }
    .portait {
        flex: none;
    }
    >div {
        flex: auto;
        margin-bottom: 0;
    }
    .n-flex {
        &+.n-flex {
            margin-top: 10px;
        }
        .body {
            width: calc(100% - 48px);
            p {
                line-break: anywhere;
                font-size: 12px;
                line-height: 14px;
                color: rgba(white,.7);
                height: 28px;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
        .noti {
            // display: block !important;
            width: auto;
            padding-right: 8px;
            padding-left: 8px;
            height: 24px;
            border-radius: 24px;
            background-color: #FFDA2A;
            color: #1B1B1E;
            text-align: center;
            font-size: 14px;
            line-height: 22px;
            box-sizing: border-box;
        }
    }
}

/* 챗팅창 */
.messageChat {
    padding-top: 14px;
    flex-direction: column;
    // display: flex !important;
    .head {
        display: flex;
        margin-bottom: 10px;
        .user {
            font-size: 16px;
            line-height: 19px;
            margin-bottom: 5px;
        }
        .bio {
            font-size: 12px;
            color: rgba(white,.7);
        }
    }
    .body {
        background-color: rgba(white,.1);
        border-radius: 8px;
        height: 420px;
        >div {
            height: 420px;
            overflow-y: scroll;
            padding: 16px 12px;
        }
        .chatBalloon {
            max-width: max-content;
            >*:first-child {
                position: relative;
                background-color: rgba(255, 255, 255, 0.1);
                padding: 8px;
                border-radius: 4px;
                font-size: 12px;
                line-height: 14px;
                color: rgba(white,.7);
                margin-left: 16px;
                // width: calc(100% - 48px);
                &::after {
                    content: "";
                    position: absolute;
                    right: 100%;
                    bottom: 0;
                    border-right: 8px solid rgba(255, 255, 255, 0.1);
                    border-bottom: 8px solid rgba(255, 255, 255, 0.1);
                    border-top: 8px solid transparent;
                    border-left: 8px solid transparent;
                }
            }
            &.me {
                margin-left: auto;
                >*:first-child {
                    margin-right: 16px;
                    &::after {
                        left: 100%;
                        right: initial;
                        border-right: 8px solid transparent;
                        border-bottom: 8px solid rgba(255, 255, 255, 0.1);
                        border-top: 8px solid transparent;
                        border-left: 8px solid rgba(255, 255, 255, 0.1);
                    }
                }
            }
            .date {
                font-size: 10px;
                margin-top: 4px;
                margin-bottom: 10px;
                color: rgba(white,.3);
                span {
                    margin-right: 8px;
                    color: white;
                }
            }
            .btn {
                padding: 8px;
                background-color: rgba(white,.1);
                border-radius: 4px;
                font-size: 12px;
                color: rgba(white,.7);
                display: flex;
                text-align: left;
                opacity: 1;
                margin-top: 10px;
                img {
                    width: 12px;
                    margin-right: 4px;
                }
            }
        }
    }

    .foot {
        height: 40px;
        display: flex;
        margin-top: 10px;
        .btn {
            flex: none;
            height: 40px;
            width: 40px;
            margin-right: 10px;
            background: rgba(white,.1);
            opacity: 1;
            display: inherit;
            justify-content: center;
            align-items: center;
        }
        .input_wrap {
            width: 100%;
            border-radius: 4px;
            padding-left: 10px;
            padding-left: 20px;
            box-sizing: border-box;
            background-color: rgba(white,.1);
        }
        .btn.btn--blue {
            background-color: #4890ff;
        }
    }
}
</style>