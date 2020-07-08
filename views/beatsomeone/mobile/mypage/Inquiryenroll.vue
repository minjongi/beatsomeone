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
                                    <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">{{ $t('goToBrandshop') }} ></a>
                                </div>
                            </div>
                        </div>                        
                    </div>

                    <div class="row menu__wraper">
                        <ul class="menu">
                            <li @click="goPage('')">{{$t('dashboard')}}</li>
                            <li @click="goPage('profilemod')">{{$t('manageInformation')}}</li>
                            <li @click="goPage('list_item')">{{$t('productList')}}</li>
                            <li @click="goPage('mybilling')">{{$t('orderHistory')}}</li>
                            <li @click="goPage('saleshistory')" v-show="group_title == 'SELLER'">{{$t('salesHistory')}}</li>
                            <li v-show="group_title == 'SELLER'">{{$t('settlementHistory')}}</li>
                            <li @click="goPage('message')">{{$t('chat')}}</li>
                            <li v-show="group_title == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
                            <li class="active" @click="goPage('inquiry')">{{$t('support1')}}
                                <!-- <ul class="menu">
                                    <li @click="goPage('inquiry')">{{$t('supportCase')}}</li>
                                    <li @click="goPage('faq')">FAQ</li>
                                </ul> -->
                            </li>
                        </ul>
                    </div>

                    <div class="sublist__content">

                        <div class="row" style="margin-bottom:20px;">
                            <div class="main__media board inquirylist">
                                <div class="tab" style="height:48px;">
                                    <div class="active" @click="goPage('inquiry')">{{$t('supportCase')}}</div>
                                    <div @click="goPage('faq')">FAQ</div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px;">
                            <button class="btn btn--gray">{{$t('back')}}</button>
                        </div>

                        <div class="row inquiry-mod">
                            <div class="box">
                                <div class="row">
                                    <div class="type"><span>Title</span></div>
                                    <div class="data">
                                        <div class="input_wrap col">
                                            <input class="inputbox" type="text" placeholder="Please enter your title about problem..." />
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 30px;" v-show="group_title == 'SELLER'">
                                    <div class="type"><span>Writer</span></div>
                                    <div class="n-flex data">
                                        <div class="group_title" :class="group_title">{{group_title}}</div>
                                        <div class="seller_class" :class="seller_class">{{seller_class}}</div>
                                        <div class="username">KKOMA</div>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top: 30px;">
                                    <div class="type"><span>Content</span></div>
                                    <div class="data">
                                        <textarea class="firstname" type="text" placeholder="Please decribe your problem detaily..." style="height:360px"/>
                                    </div>
                                </div>


                                <div class="row" style="margin-top: 30px;" v-show="group_title == 'SELLER'">
                                    <div class="type"><span>Attachment</span></div>
                                    <div class="data">
                                        <label class="btn btn--blue" for="attachbtn">
                                            <input type="file" id="attachbtn" style="display:none;">
                                            <div>Add</div>
                                        </label>
                                        <div>
                                            <div class="caution">
                                                <!-- <div>
                                                    <img class="caution" src="/assets/images/icon/caution.png"/>
                                                    <img class="warning" src="/assets/images/icon/warning.png"/>
                                                </div> -->
                                                <p> You can upload only jpg, png, gif, doc, and pdf files within 00mb. </p>
                                            </div>
                                            <!-- <div class="file_list">
                                                <div>
                                                    <img src="/assets/images/icon/file.png"/>
                                                    <span>musicsong1.mp3</span>
                                                </div>
                                                <div>
                                                    <img src="/assets/images/icon/file.png"/>
                                                    <span>musicsong2.mp3</span>
                                                </div>
                                                <div>
                                                    <img src="/assets/images/icon/file.png"/>
                                                    <span>musicsong3.mp3</span>
                                                </div>
                                            </div> -->

                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="btnbox-wrap n-flex">
                                <button class="btn btn--gray">Cancel</button>
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
.inquiry-mod {
    .type {
        margin-bottom: 10px;
        span {
            font-size: 14px;
            line-height: 16px;
            font-weight: 600;
            color: rgba(white, 0.7);
        }
    }
    .n-flex {
        align-items: center;
        >div+div {
            margin-left: 10px;
        }
        .group_title {
            font-size: 12px !important;
            .SELLER {
            }
        }
        .seller_class {
            font-size: 12px;
        }
        .username {
            font-size: 1px;
        }
        &.data {
            >div {
                margin-top: 0;
            }
             .MARKET.PLACE {
                 color: #4890FF;
             }
             
        }
    }
    .data {
        .firstname {
            height: 256px;
            width: 100%;
            background-color: rgba(white,.1);
            border-radius: 2px;
            padding: 12px 16px;
            color: white;
        }
    }
    .caution {
        margin-top: 10px;
        margin-bottom: 20px;
        p {
            font-size: 10px;
            color: rgba(white,.3);
        }
    }
    
}
.file_list {
    overflow: hidden;
    height: auto;
    div {
        float: left;
        margin-right: 16px;
        color: rgba(white, 0.7);
        display: flex;
        margin-bottom: 5px;
        align-items: center;
        font-size: 14px;
        overflow: hidden;
        >img {
            margin-right: 4px;
        }
    }
}
.btnbox-wrap.n-flex {
    margin-top: 30px;
    border: none;
    button {
        &+button {
            margin-left: 20px;
        }
    }
}

.btn.btn--blue {
    width: 96px;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>