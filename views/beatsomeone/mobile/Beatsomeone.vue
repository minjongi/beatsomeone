<template>
    <div>
<!--        <div v-if="popup">-->
<!--          <div class="noti-wrap"></div>-->
<!--          <div class="noti-content">-->
<!--            <div>-->
<!--              <a @click="goEvent" style="cursor:pointer;"><img :src="'/assets_m/images/popup/210312/1.png'"></a>-->
<!--            </div>-->
<!--            <div>-->
<!--              <img :src="'/assets_m/images/popup/210312/2.png'" @click="closePopup(true)" style="width:50%;"><img :src="'/assets_m/images/popup/210312/3.png'" @click="closePopup()" style="width:50%;">-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div v-if="popup1">-->
<!--          <div class="noti-wrap"></div>-->
<!--          <div class="noti-content">-->
<!--            <div>-->
<!--              <a :href="helper.langUrl($i18n.locale, '/event/join')"><img :src="'/assets_m/images/event/2101241/' + $i18n.locale + '/1.png'"></a>-->
<!--            </div>-->
<!--            <div>-->
<!--              <img :src="'/assets_m/images/event/2101241/' + $i18n.locale + '/2.png'" @click="closePopup1(true)" style="width:50%;"><img :src="'/assets_m/images/event/2101241/' + $i18n.locale + '/3.png'" @click="closePopup1()" style="width:50%;">-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
        <div class="wrapper">
            <Header :is-login="isLogin"></Header>
            <div class="container">
                <div class="main">
                    <section class="main__section1">
                        <video
                                id="videoBG"
                                poster="/assets/images/main-section1-visual.png"
                                autoplay
                                muted
                                @ended="endVideoBG"
                                ref="videoBG"
                        >
                            <source src type="video/mp4"/>
                        </video>
                        <header class="main__section1-title">
                            <div class="wrap">
                <h1>{{ $t('MainTitleMsg') }}</h1>
                                <p>
                  {{ $t('findingMusicMsg') }}<br/>
                                    {{ $t('mainMsg2') }}
                                </p>
                            </div>
                        </header>
                        <div class="main__media" style="position:relative;z-index: 100;">
                            <div class="tab">
                                <div class="tab__scroll">
                                    <button
                                            v-for="(g, i) in listGenre"
                                            :key="g"
                                            :class="{active:currentGenre === g}"
                                            @click="currentGenre = g"
                                    >{{ listGenreName[i] }}
                                    </button>
                                </div>
                            </div>

                            <!-- <div class="col more">
                                <button :class="{'js-active' : isOpenSubmenu}" @click="openSubmenu">{{ $t('more') }}</button>
                                <span class="tooltip">
                                    <a @click="clickShare('twitter')">{{ $t('lang107') }}</a><a @click="clickShare('facebook')">{{ $t('lang108') }}</a><a
                                            @click="copyLinkToClipboard()">{{ $t('lang109') }}</a>
                                </span>
                            </div> -->

                            <div class="icon__group">
                                <button :class="{'js-active' : isOpenSubmenu}" @click="openSubmenu">
                                    <i class="far fa-question-circle" style="color: #ffffff; width: 10px; margin-right: 5px;"></i>
                                </button>
                                <span class="tooltip">
                                    <div>
                                        <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_1.png"/>
                                        <span> {{ $t('lang121') }}</span>
                                    </div>
                                    <div>
                                        <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_2.png"/>
                                        <span> {{ $t('lang122') }}</span>
                                    </div>
                                    <div>
                                        <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_3.png"/>
                                        <span> {{ $t('lang123') }}</span>
                                    </div>
                                    <div>
                                        <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_4.png"/>
                                        <span> {{ $t('lang124') }}</span>
                                    </div>
                                    <div>
                                        <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_5.png"/>
                                        <span> {{ $t('lang125') }}</span>
                                    </div>
                                </span>
                                <div style="align-items: center; display:flex ">
                                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_1.png"/>
                                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_2.png"/>
                                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_3.png"/>
                                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_4.png"/>
                                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_5.png"/>
                                </div>
                                
                            </div>
                            <!-- <div class="col more">
                <button :class="{'js-active' : isOpenSubmenu}" @click="openSubmenu">{{ $t('more') }}</button>
                <span class="tooltip">
                    <a @click="clickShare('twitter')">{{ $t('lang107') }}</a><a @click="clickShare('facebook')">{{ $t('lang108') }}</a><a
                            @click="copyLinkToClipboard()">{{ $t('lang109') }}</a>
                </span>
            </div> -->
                            <div class="playList">
                              <ul>
                                <template v-for="item in list">
                                  <KeepAliveGlobal :key="item.cit_key">
                                    <Index_Items :item="item" :key="item.cit_key"></Index_Items>
                                  </KeepAliveGlobal>
                                </template>
                              </ul>
                                <div class="playList__btnbox">
                                    <a class="playList__more pointer" :href="moreList">{{ $t('mainMore') }}</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="main__section2">
                        <header class="main__section2-title1">
                            <div class="wrap">
                                <h2>
                                    {{ $t('backgroundMusicMessage1') }}<br/>
                                    {{ $t('backgroundMusicMessage2') }}
                                </h2>
                                <a class="startSelling" @click="goSubscribe()">
                                    {{ $t('buyerLogin') }}
                                </a>
                            </div>
                        </header>
                        <header class="main__section2-title">
                            <div class="wrap">
                                <h2>
                                    {{ $t('bitTradingMessage1') }}
                                    <br/>
                                    {{ $t('bitTradingMessage2') }}
                                </h2>
                                <a :href="moveStartSelling">{{ $t('lendOrSellMyBeat') }}</a>
                            </div>
                        </header>
                        <!-- 트렌딜 슬라이드 부분 -->
                        <div class="trending">
                            <h2 class="trending__title">{{ $t('trendingMusic') }}</h2>
                            <div class="trending__slider">
                                <div class="slider">
                                    <div class="trending__slide-item albumItem" v-for="(i,index) in listTrending" :key="index">
                                      <a :href="helper.langUrl($i18n.locale, '/detail/' + i.cit_key)">
                                        <button class="albumItem__cover">
                                          <img :src="'/uploads/cmallitem/' + i.thumb" :alt="i.cit_name"/>
                                        </button>
                                        <a class="albumItem__link">
                                          <h4 class="albumItem__title">{{ i.cit_name }}</h4>
                                          <p class="albumItem__singer">{{ i.mem_nickname }}</p>
                                        </a>
                                      </a>
                                  </div>
                                </div>
                            </div>
                            <!-- 트렌드 슬라이드 끝 -->
                            <!-- 제휴 업체 로그 이미지  -->
                            <div class="alliance">
                                <img src="@/assets_m/images/partner/partner-total1.png" alt="alliance" href="#"/>
                            </div>
                            <!-- 제휴업체 로그 이미지 끝 -->
                            <div class="testimonials">
                                <div class="wrap">
                                    <article class="testimonials__title">
                                        <h2>{{ $t('testimonials') }}</h2>
                                        <p>{{ $t('bestTeamMember') }}</p>
                                    </article>
                                    <article class="testimonials__lists">
                                        <figure class="card card--testimonials" v-for="(post, index) in listTestimonials" :key="index">
                                            <a :href="helper.langUrl($i18n.locale, '/video#' + post.post_id)">
                                                <div class="img" v-if="post.files.length === 1">
                                                    <img
                                                            :src="'/uploads/post/' + post.files[0].pfi_filename"
                                                            :alt="post.post_title"
                                                    />
                                                </div>
                                                <div class="img" v-else>
                                                    <img
                                                        :src="'/uploads/post/' + post.files[1].pfi_filename"
                                                        :alt="post.post_title"
                                                    />
                                                </div>
                                                <figcaption>
                                                    <h3>{{ post.dp_title || post.post_title }}</h3>
                                                    <p>{{ post.dp_sub_title || post.post_nickname }}</p>
                                                </figcaption>
                                                <button class="play">play</button>
                                            </a>
                                        </figure>
                                    </article>
                                    <div class="testimonials__btnbox">
                                        <a :href="moveStartSelling">{{ $t('startSelling') }}</a>
                                        <a :href="helper.langUrl($i18n.locale, '/sublist')" class="beats">{{ $t('browseBeats') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="main__desc">
                                <h2>
                                    {{ $t('musicWorldMsg1') }}
                                    <br/>
                                    {{ $t('musicWorldMsg2') }}
                                    <br/>
                                    {{ $t('areYouReady') }}
                                </h2>
                                <a :href="moveStartSelling">{{ $t('trustOurTeamMsg') }}</a>
                            </div>
                        </div>
                        <Footer></Footer>
                    </section>
                </div>
            </div>
        </div>
        <main-player></main-player>
    </div>
</template>

<script>
    require("@/assets_m/js/function");

    import $ from "jquery";
    import axios from 'axios';
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Index_Items from "./Index_Items";
    import {EventBus} from "*/src/eventbus";
    import Velocity from "velocity-animate";
    import MainPlayer from "@/vue/common/MobileMainPlayer";
    import KeepAliveGlobal from "vue-keep-alive-global";
    import Vuecookies from 'vue-cookies'

    export default {
        name: "Index",
        components: {Header, Footer, Index_Items, MainPlayer, KeepAliveGlobal},
        data: function () {
            return {
                userInfo: null,
                isLogin: false,
                init: {},
                list: null,
                listTrending: [],
                listTestimonials: [],
                currentGenre: "All Genre",
                listGenre: ["All Genre"].concat(window.genre), // .concat(["Free Beats"])
                videoBGPath: "",
                member: false,
                member_group_name: '',
                popup: false,
                popup1: false,
                isOpenSubmenu: false,
                footerBanner: true
            };
        },
        created() {
            // 메인 리스트 조회
            this.getMainList();

            // Trending List
            this.getTrendingList();

            // Testimonials List
            this.getTestimonialsList();
        },
        mounted() {
            // 메인페이지: 서브 앨범 슬라이드 이벤트
            $(".toggle-subList").on("click", function () {
                var itemLength = $(this)
                    .parents(".playList__itembox")
                    .find(".subPlayList .playList__itembox").length;
                $(this).toggleClass("active");
                $(this).parents(".playList__itembox").toggleClass("is-show-children");

                if ($(this).hasClass("active")) {
                    // active 일때,
                    $(this)
                        .parents(".playList__itembox")
                        .find(".subPlayList")
                        .css("height", 90 * itemLength);
                } else {
                    // 지웟을때,
                    $(this)
                        .parents(".playList__itembox")
                        .find(".subPlayList")
                        .css("height", 0);
                }
            });

            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function () {
                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this).find(".options").toggle();
            });

            this.endVideoBG();

            this.member = window.member;
            this.member_group_name = window.member_group_name;
            if (this.member_group_name) {
                this.remainDownloadNumber();
            }

            // if (Vuecookies.get('popup210312-close') !== 'Y' && this.$i18n.locale !== 'en' && this.member_group_name !== 'subscribe_common') {
            //   this.openPopup()
            // }
            // if (Vuecookies.get('popup2101241-close') !== 'Y' && !this.member) {
            //   this.openPopup1()
            // }
        },
        watch: {
            // 장르가 변경될 때
            currentGenre: function (n, o) {
                if (o && n !== o) {
                    this.getMainList();
                }
            },
        },
        computed: {
            isSeller() {
              return this.member_group_name.includes('seller')
            },
            listGenreName() {
                let list = [],
                    _self = this;
                this.listGenre.forEach(function (val) {
                    list.push(_self.$t("genre" + window.genLangCode(val)));
                });

                return list;
            },
            moreList() {
              return this.helper.langUrl(this.$i18n.locale, '/sublist?genre=' + encodeURIComponent(this.currentGenre))
            },
            moveStartBuyer() {
              localStorage.setItem("UserOffer", "buyer")
              return this.helper.langUrl(this.$i18n.locale, '/register')
            },
            moveStartSelling() {
              let url = '/register';
              if (!this.member) {
                localStorage.setItem("UserOffer", "seller")
                return this.helper.langUrl(this.$i18n.locale, url)
              }

              if (this.member_group_name === 'buyer') {
                url = '/mypage/upgrade'
              } else if (this.member_group_name.includes('seller')) {
                url = '/mypage/regist_item'
              } else {
                url = '/mypage/upgrade'
              }
              return this.helper.langUrl(this.$i18n.locale, url)
            },
        },
        methods: {
            remainDownloadNumber() {
                axios.get('/membermodify/mem_remain_downloads_get')
                .then(res=>{
                    console.log('remain_download_num', res.data);
                    localStorage.setItem('remain_download_num', res.data);
                });
            },
            openPopup() {
              this.popup = true
              document.body.style.overflow = 'hidden'
              window.onload = function () {
                setTimeout(function () {
                  window.scrollTo(0, 0)
                }, 100)
              }
            },
            closePopup(isForever) {
              if (isForever) {
                Vuecookies.set('popup210312-close', 'Y', '1d')
              }
              document.body.style.overflow = ''
              this.popup = false
            },
            openPopup1() {
              this.popup1 = true
              document.body.style.overflow = 'hidden'
              window.onload = function () {
                setTimeout(function () {
                  window.scrollTo(0, 0)
                }, 100)
              }
            },
            closePopup1(isForever) {
              if (isForever) {
                Vuecookies.set('popup2101241-close', 'Y', '1d')
              }
              document.body.style.overflow = ''
              this.popup1 = false
            },
            endVideoBG() {
                const idx = Math.floor(Math.random() * 5) + 1;
                this.videoBGPath = '/assets_m/video/mainbg/2103/' + idx + '.mp4';
                this.$refs.videoBG.src = this.videoBGPath;
                this.$refs.videoBG.play();
            },
            doSlide() {
                // 메인 trend Slider
                $(".trending__slider .slider").slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    swipeToSlide: true,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    centerMode: true,
                    centerPadding: "25px",
                    arrows: false,
                    dots: true,
                });
            },
            selectItem(i) {
                const path = `/detail/${i}`;
                window.location.href = this.helper.langUrl(this.$i18n.locale, path);
            },
            getMainList() {
                Http.get(
                    `/beatsomeoneApi/main_list/${encodeURIComponent(this.currentGenre)}`
                ).then((r) => {
                    this.list = r.data;
                });
            },
            getTrendingList() {
                Http.get(`/beatsomeoneApi/main_trending_list`).then((r) => {
                    this.listTrending = r.data;
                    this.$nextTick(function () {
                        this.doSlide();
                    });
                });
            },
            getTestimonialsList() {
                Http.get(`/beatsomeoneApi/main_testimonials_list`).then((r) => {
                    this.listTestimonials = r.data;
                });
            },
            beforeEnter: function (el) {
                el.style.opacity = 0;
                el.style.height = 0;
            },
            enter: function (el, done) {
                var delay = el.dataset.index * 150;
                setTimeout(function () {
                    Velocity(
                        el,
                        {opacity: 1, height: 70, "margin-bottom": 1},
                        {complete: done}
                    );
                }, delay);
            },
            leave: function (el, done) {
                var delay = el.dataset.index * 150;
                setTimeout(function () {
                    Velocity(
                        el,
                        {opacity: 0, height: 0, "margin-bottom": 0, display: "none"},
                        {complete: done}
                    );
                }, delay);
            },
            openSubmenu() {
                this.isOpenSubmenu = !this.isOpenSubmenu;
            },
            closeFooterBanner() {
              this.footerBanner = false
            },
            goEvent() {
              if (!!this.member && this.member_group_name !== 'subscribe_common') {
                location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/upgrade?type=sub')
              } else {
                localStorage.setItem('UserOffer', 'buyer')
                localStorage.setItem('plan', 'subscribe_common')
                location.href = this.helper.langUrl(this.$i18n.locale, '/register')
              }
            },
            goSubscribe() {
              localStorage.setItem('UserOffer', 'buyer')
              localStorage.setItem('plan', 'subscribe_common')
              location.href = this.helper.langUrl(this.$i18n.locale, '/register')
            }
        },
    };
</script>

<style lang="scss">
    @import "@/assets_m/scss/App.scss";
</style>

<style lang="css">
    @import "/assets_m/plugins/slick/slick.css";
    @import "/assets_m/plugins/rangeSlider/css/ion.rangeSlider.min.css";
</style>
<style scope="scope" lang="scss">
    .playList .playList__item {
        display: flex !important;
    }

    .albumItem .albumItem__link {
        text-align: left !important;
    }

    .main__section2 {
        background: url("/assets_m/images/main-section2-visual.png") no-repeat center top;
        background-size: cover !important;
    }
    .more_shared {
            text-align: center;
            padding: 0 30px 0 0;
        }
    .icon__group {

        display: flex;
        justify-content: flex-end;
        padding: 15px;
        position: relative;
        background-color: black;
        .tooltip {
            bottom: 15px;
            width: 100px;
            background: #2b2c30;
            left: auto;
            right: 34px;
            transform: none;
            visibility: hidden;
            width: 190px;
            padding: 10px 10px 5px 10px;
            color: #9ea1a8;
            border: 1px solid #9ea1a8;
            &:before {
                content: "";
                display: block;
                position: absolute;
                left: 50%;
                bottom: -7px;
                transform: translateX(-50%);
                width: 0;
                height: 0;
                border-top: 6px solid  #9ea1a8;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
            }
            &:after {
                content: "";
                display: block;
                position: absolute;
                left: 50%;
                bottom: -10px;
                transform: translateX(-50%);
                width: 0;
                height: 0;
                border-top: 5px solid #2b2c30;
                border-bottom: 5px solid transparent;
                border-left: 5px solid transparent;
                border-right: 5px solid transparent;
            }
            div {
                margin-bottom: 5px;
            }
        }

        button {
            cursor: pointer;
            width: 20px;
            height: 16px;
            position: relative;
            overflow: initial;
            opacity: .3;
            transition: all .3s;

            &.js-active {
                opacity: 1;
            }

            &.js-active + .tooltip {
                opacity: 1;
                bottom: 44px;
                visibility: initial;

                a {
                    height: 40px;
                }
            }
        }
    }

</style>
