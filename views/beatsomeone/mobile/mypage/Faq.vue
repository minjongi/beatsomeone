<template>
    <div>

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div @click="goPage('inquiry')">{{$t('supportCase')}}</div>
                    <div class="active" @click="goPage('faq')">FAQ</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">

            <div class="search-wrap">
                <div class="input_wrap line round">
                    <input type="text" placeholder="enter your word...">
                    <img src="/assets/images/icon/searchicon.png" />
                </div>
            </div>

        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board fold faq">

                <ul>
                    <li class="n-itembox">
                        <div class="n-item">
                            <div class="title">
                                <h4>What information do I need to sell music?</h4>
                                <div class="btn--fold"><span></span><span></span></div>
                            </div>
                            <p class="answer fold" height="407px">
                                When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                    BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                    <br/>
                                After the changes have been made, the rights for sale will be opened.<br/>
                                From this point on, you can sell the beats you have made.<br/>
                            </p>
                        </div>
                    </li>
                    <li class="n-itembox">
                        <div class="n-item">
                            <div class="title">
                                <h4>What information do I need to sell music?</h4>
                                <div class="btn--fold"><span></span><span></span></div>
                            </div>
                            <p class="answer fold" height="407px">
                                When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                    BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                    <br/>
                                After the changes have been made, the rights for sale will be opened.<br/>
                                From this point on, you can sell the beats you have made.<br/>
                            </p>
                        </div>
                    </li>
                    <li class="n-itembox active">
                        <div class="n-item">
                            <div class="title">
                                <h4>What information do I need to sell music?</h4>
                                <div class="btn--fold"><span></span><span></span></div>
                            </div>
                            <p class="answer" height="407px">
                                When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                    BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                    <br/>
                                After the changes have been made, the rights for sale will be opened.<br/>
                                From this point on, you can sell the beats you have made.<br/>
                            </p>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

    </div>
</template>

<script>
    import $ from "jquery";
    import WaveSurfer from 'wavesurfer.js';

    export default {
        components: {
        },
        data: function() {
            return {
                isLogin: false,
                popup_filter:0,
            };
        },
        mounted(){
        },
        created() {
        },
        methods:{
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
        }
    }
</script>

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
  .input_wrap {
    // margin-right: 10px;
    // min-width: 100px;
    // max-width: 100px;
    height: 48px;
    border: 1px solid #414143;
    
    input {
        font-size: 14px;
        font-weight: 600;
    }
    img {
        margin-left: 18px;
        opacity: .3;
    }
  }
  &.round {
    border-radius: 48px;
  }
}

</style>