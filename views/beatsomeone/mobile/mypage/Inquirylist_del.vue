<template>
  <div class="wrapper">
    <Header :is-login="isLogin" />

    <div class="container sub">
      <div class="mypage sublist">
        <div class="wrap">
          <div class="sublist__filter sticky">
            <div class="row center">
              <div class="profile">
                <div class="portrait">
                  <img
                    v-if="mem_photo === ''"
                    src="/assets/images/portait.png"
                  />
                  <img
                    v-else
                    :src="
                      'http://dev.beatsomeone.com/uploads/member_photo/' +
                        mem_photo
                    "
                    alt=""
                  />
                </div>
                <div class="info">
                  <div class="group">
                    <div class="group_title" :class="group_title">
                      {{ group_title }}
                    </div>
                  </div>
                  <div class="username">
                    {{ mem_nickname }}
                  </div>
                  <div class="bio">
                    Music Lover, KKOMA
                  </div>
                </div>
              </div>
              <div class="profile__footer">
                <div class="location">
                  <img class="site" src="/assets/images/icon/position.png" />
                  <div>Seoul, South Korea</div>
                </div>
                <div class="brandshop">
                  <img class="shop" src="/assets/images/icon/shop.png" /><a
                    href="#"
                    >{{ $t('goToBrandshop') }} ></a
                  >
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
              <li
                @click="goPage('saleshistory')"
                v-show="group_title == 'SELLER'"
              >
                {{$t('salesHistory')}}
              </li>
              <li v-show="group_title == 'SELLER'">{{$t('settlementHistory')}}</li>
              <li @click="goPage('message')">{{$t('chat')}}</li>
              <li @click="goPage('sellerreg')" v-show="group_title == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
              <li class="active" @click="goPage('inquiry')">
                Support
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
                  <div class="active" @click="goPage('inquiry')">
                    {{$t('supportCase')}}
                  </div>
                  <div @click="goPage('faq')">FAQ</div>
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:20px;">
              <button class="btn btn--submit">To ask question</button>
            </div>

            <div class="row">
              <div class="board">
                <ul>
                  <li class="n-box">
                    <div class="n-flex setween">
                      <span class="subject"
                        >I have some question about using service.</span
                      >
                      <span class="action yellow"> Wait... </span>
                    </div>
                  </li>
                  <li class="n-box">
                    <div class="n-flex setween">
                      <span class="subject"
                        >I have some question about using service.</span
                      >
                      <span class="action"> nswer complete </span>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="row">
              <div class="pagination">
                <div>
                  <button class="prev active">
                    <img src="/assets/images/icon/chevron_prev.png" />
                  </button>
                  <button class="active">1</button>
                  <button>2</button>
                  <button>3</button>
                  <button class="next active">
                    <img src="/assets/images/icon/chevron_next.png" />
                  </button>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="n-flex search-wrap">
                <div class="custom-select">
                  <button class="selected-option">Total</button>
                  <div class="options">
                    <button data-value="" class="option">Title</button>
                    <button data-value="" class="option">Content</button>
                  </div>
                </div>
                <div class="input_wrap line">
                  <input type="text" :placeholder="$t('enterYourSearchword')" />
                  <button>
                    <img src="/assets/images/icon/searchicon.png" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="waveform"></div>
    <!--
        <main-player></main-player>
        -->
    <Footer />
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
  data: function () {
    return {
      isLogin: false,
      group_title: 'SELLER',
      product_status: 'PENDING',
      myProduct_list: [],
      popup_filter: 0,
      ws: null,
      isPlay: false,
      isReady: false,
      wavesurfer: null,
    };
  },
  mounted () {
    // 커스텀 셀렉트 옵션
    $(".custom-select").on("click", function () {

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
  created () {
    Http.get('/beatsomeoneApi/get_user_regist_item_list').then(r => {
      console.log(r.data);
      this.myProduct_list = r.data;
    });
  },
  methods: {
    goPage: function (page) {
      window.location.href = '/mypage/' + page;
    },
    goInquiryview () {
      this.$router.push({ path: '/inquiryview' });
    },
    goInquirymod () {
      this.$router.push({ path: '/inquirymod' });
    },

  },
}
</script>


<style lang="scss">
@import "@/assets_m/scss/App.scss";
</style>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

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

.board {
  .n-box {
    > div {
      background-color: #1b1b1e;
      padding: 16px;
      align-items: center;
      span {
        font-size: 12px;
        line-height: 14px;
        & + span {
          margin-left: 18px;
        }
        &:first-child {
          // width: calc(100% - 54px -18px);
          flex: auto;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          color: rgba(white, 0.7);
        }
        &:last-child {
          text-align: center;
          color: rgba(white, 0.3);
          min-width: 54px;
          max-width: 54px;
        }
      }
    }
  }
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

.search-wrap {
  margin-top: 20px;
  .custom-select {
    flex: 1;
    margin-right: 10px;
    min-width: 100px;
    max-width: 100px;
    height: 40px;
    border: 1px solid #414143;
    border-radius: 4px;
    .selected-option {
      width: 100px;
      height: 38px;
      text-align: left;
    }
  }
  .input_wrap {
    flex: 3;
    height: 40px;
    border: 1px solid #414143;
    border-radius: 4px;
  }
}
</style>