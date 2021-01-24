<template>
  <div class="wrapper">
    <div v-if="popup">
      <div class="noti-wrap"></div>
      <div class="noti-content">
        <div>
          <a :href="helper.langUrl($i18n.locale, '/event')"><img :src="'/assets/images/event/210124/' + $i18n.locale + '/1.png'"></a>
        </div>
        <div>
          <img :src="'/assets/images/event/210124/' + $i18n.locale + '/2.png'" @click="closePopup(true)" style="width:50%;cursor:pointer;"><img :src="'/assets/images/event/210124/' + $i18n.locale + '/3.png'" @click="closePopup()" style="width:50%;cursor:pointer;">
        </div>
      </div>
    </div>
    <div v-if="popup1">
      <div class="noti-wrap"></div>
      <div class="noti-content">
        <div>
          <a :href="helper.langUrl($i18n.locale, '/event/join')"><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/1.png'"></a>
        </div>
        <div>
          <img :src="'/assets/images/event/2101241/' + $i18n.locale + '/2.png'" @click="closePopup1(true)" style="width:50%;cursor:pointer;"><img :src="'/assets/images/event/2101241/' + $i18n.locale + '/3.png'" @click="closePopup1()" style="width:50%;cursor:pointer;">
        </div>
      </div>
    </div>
    <Header :is-login="isLogin"></Header>
    <main-player></main-player>
    <div class="container">
      <div class="main">
        <section class="main__section1">
          <video id="videoBG" poster="/assets/images/main-section1-visual.png" autoplay muted @ended="endVideoBG" ref="videoBG">
            <source src="" type="video/mp4">
          </video>
          <div class="filter"></div>
          <div class="wrap">
            <header class="main__section1-title">
              <h1>{{ $t('MainTitleMsg') }}</h1>
              <p>
                {{ $t('findingMusicMsg') }}<br/>
                {{ $t('mainMsg2') }}
              </p>
            </header>
            <div class="main__media">
              <div class="tab">
                <button v-for="(g, i) in listGenre" :key="g" :class="{active:currentGenre === g}"
                        @click="currentGenre = g">
                  {{ listGenreName[i] }}
                </button>
              </div>
              <div class="filter">
                <label for="voice" class="switch">
                  {{ $t('voice') }}
                  <input type="checkbox" hidden id="voice" v-model="param.voice"/>
                  <span></span>
                </label>
                <div class="custom-select ">
                  <button class="selected-option">
                    {{ listSortParamName }}
                  </button>
                  <div class="options">
                    <button class="option" data-value="" v-for="(o,i) in listSort" :key="i" @click="param.sort = o">
                      {{ listSortName[i] }}
                    </button>
                  </div>
                </div>
                <div class="custom-select ">
                  <button class="selected-option">
                    {{ param.bpm.t }}
                  </button>
                  <div class="options">
                    <button class="option" data-value="" v-for="(o,i) in listBpm" :key="i"
                            @click="param.bpm = o">
                      {{ o.t }}
                    </button>
                  </div>
                </div>
              </div>
              <div class="playList">
                <!-- 아래 템플릿 문자열로 붙임 -->
                <transition-group
                    name="staggered-fade"
                    tag="ul"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave">
                  <template v-for="item in list">
                    <KeepAliveGlobal :key="item.cit_key">
                      <Index_Items :item="item" :key="item.cit_key"></Index_Items>
                    </KeepAliveGlobal>
                  </template>
                </transition-group>
                <div class="playList__btnbox">
                  <a class="playList__more" :href="moreList" style="cursor: pointer !important;">{{ $t('mainMore') }}</a>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="main__section2">
          <div class="filter reverse"></div>
          <div class="wrap">
            <header class="main__section2-title-login" v-if="false">
                <h2>
                    {{ $t('backgroundMusicMessage1') }}<br/>
                    {{ $t('backgroundMusicMessage2') }}
                </h2>
                <a class="startSelling" :href="moveStartBuyer">
                    {{ $t('buyerLogin') }}
                </a>
            </header>
            <header class="main__section2-title">
              <h2>
                {{ $t('bitTradingMessage1') }}<br/>
                {{ $t('bitTradingMessage2') }}
              </h2>
              <a class="startSelling" :href="moveStartSelling">
                {{ $t('lendOrSellMyBeat') }}
              </a>
            </header>
            <!-- 트렌딜 슬라이드 부분 -->
            <div class="trending">
              <h2 class="trending__title">{{ $t('trendingMusic') }}</h2>
              <div class="trending__slider">
                <div class="slider">
                  <!--                                slider의 버그로 인해 Vue OnClick 이벤트가 새로 생성되는 Element 에서 인식되지 않는 문제가 있어 @click 을 사용하지 않고 직접 vm에서 메서드 호출 방식으로 변경 하였음-->
                  <div v-for="(i,index) in listTrending" :key="index" class="trending__slide-item albumItem">
                    <a :href="helper.langUrl($i18n.locale, '/detail/' + i.cit_key + '#/')">
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
            </div>
            <!-- 트렌드 슬라이드 끝 -->
            <!-- 제휴 업체 로그 이미지  -->
            <div class="alliance" @click="selectItem">
              <img src="@/assets/images/alliance1.png" alt="" href="#" style="opacity: .3"/>
            </div>
            <!-- 제휴업체 로그 이미지 끝 -->
            <div class="testimonials">
              <article class="testimonials__title">
                <h2>{{ $t('testimonials') }}</h2>
                <p>{{ $t('bestTeamMember') }}</p>
              </article>
              <article class="testimonials__lists">
                <figure class="card card--testimonials" v-for="(post, index) in listTestimonials" :key="index">
                  <a :href="helper.langUrl($i18n.locale, '/video#/' + post.post_id)">
                    <div class="img">
                      <img :src="'/uploads/post/' + post.files[0].pfi_filename" alt=""/>
                      <button class="card--testimonials_play"></button>
                    </div>
                    <figcaption>
                      <h3>{{ post.dp_title || post.post_title }}</h3>
                      <p>{{ post.dp_sub_title || post.post_nickname }}</p>
                    </figcaption>
                  </a>
                </figure>
              </article>
              <div class="testimonials__btnbox">
                <a class="startSelling" :href="moveStartSelling">{{ $t('startSelling') }}</a>
                <a :href="helper.langUrl($i18n.locale, '/sublist')" class="beats">{{ $t('browseBeats') }}</a>
              </div>
            </div>
            <div class="main__desc">
              <h2>
                {{ $t('musicWorldMsg1') }}<br/>
                {{ $t('musicWorldMsg2') }}<br/>
                {{ $t('areYouReady') }}
              </h2>
              <a class="startSelling" :href="moveStartSelling">
                {{ $t('trustOurTeamMsg') }}
              </a>
            </div>
          </div>
          <Footer :footerBannerDisabled="true"></Footer>
        </section>
      </div>
    </div>
    <FooterBanner :footerBanner="footerBanner"/>
  </div>
</template>

<script>
    require('@/assets/js/function')

    import $ from "jquery";
    import axios from 'axios';
    import Header from "./include/Header"
    import Footer from "./include/Footer"
    import FooterBanner from "./component/FooterBanner"
    import Index_Items from "./Index_Items"
    import {EventBus} from '*/src/eventbus'
    import Velocity from 'velocity-animate'
    import MainPlayer from "@/vue/common/MainPlayer"
    import KeepAliveGlobal from 'vue-keep-alive-global'
    import Vuecookies from 'vue-cookies'

    export default {
        name: 'Index',
        components: {Header, Footer, FooterBanner, Index_Items, MainPlayer, KeepAliveGlobal},
        data: function () {
            return {
                userInfo: null,
                isLogin: false,
                init: {},
                list: [],
                listTrending: null,
                listTestimonials: [],
                currentGenre: 'All Genre',
                listGenre: ['All Genre'].concat(window.genre), // .concat(['Free Beats'])
                listSort: window.sortItem,
                listBpm: [
                    {t: 'BPM', v: null},
                    {t: '80-90', v: 90},
                    {t: '90-100', v: 100},
                    {t: '100-110', v: 110},
                    {t: '110-120', v: 120},
                ],
                param: {
                    voice: false,
                    sort: 'Sort By Staff Picks',
                    bpm: {t: 'BPM', v: null},
                },
                videoBGPath: '',
                member: null,
                member_group_name: '',
                popup: false,
                popup1: false,
                footerBanner: true
            }
        },
        mounted() {
            // 메인페이지: 서브 앨범 슬라이드 이벤트
            $(".toggle-subList").on("click", function () {
                var itemLength = $(this)
                    .parents(".playList__itembox")
                    .find(".subPlayList .playList__itembox").length
                $(this).toggleClass("active")
                $(this)
                    .parents(".playList__itembox")
                    .toggleClass("is-show-children")

                if ($(this).hasClass("active")) {
                    // active 일때,
                    $(this)
                        .parents(".playList__itembox")
                        .find(".subPlayList")
                        .css("height", 90 * itemLength)
                } else {
                    // 지웟을때,
                    $(this)
                        .parents(".playList__itembox")
                        .find(".subPlayList")
                        .css("height", 0)
                }
            })

            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function () {
                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide()
                $(this).toggleClass("active")
                $(this)
                    .find(".options")
                    .toggle()
            })

            // 메인 리스트 조회
            this.getMainList()

            // Trending List
            this.getTrendingList()

            // Testimonials List
            this.getTestimonialsList()

            // Amplitude.init({
            //     "songs": this.listPlayer,
            //     delay: 3000,
            //     waveforms: {
            //         sample_rate: 3000
            //     }
            // })

            this.endVideoBG();

            this.member = window.member;
            this.member_group_name = window.member_group_name;
            if (this.member_group_name) {
              this.remainDownloadNumber();
            }
            if (Vuecookies.get('popup210124-close') !== 'Y' && this.isSeller) {
              this.openPopup()
            }
            if (Vuecookies.get('popup2101241-close') !== 'Y' && !this.member) {
              this.openPopup1()
            }
        },
        computed: {
            isSeller() {
              return this.member_group_name.includes('seller')
            },
            listSortParamName() {
                let idx = this.listSort.indexOf(this.param.sort) < 0 ? 0 : this.listSort.indexOf(this.param.sort)
                return this.listSortName[idx]
            },
            listGenreName() {
                let list = [],
                    _self = this

                this.listGenre.forEach(function (val) {
                    list.push(_self.$t('genre' + window.genLangCode(val)))
                })

                return list
            },
            listSortName() {
                let list = [],
                    _self = this

                this.listSort.forEach(function (val) {
                    list.push(_self.$t('sortItem' + window.genLangCode(val)))
                })

                return list
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
        watch: {
            // 장르가 변경될 때
            currentGenre: function (n, o) {
                if (o && n !== o) {
                    this.getMainList()
                }
            },
            // 검색조건 변경
            param: {
                deep: true,
                handler() {
                    this.getMainList()
                }
            }
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
              setTimeout(function () {
                window.scrollTo(0, 0)
              }, 1000)

            },
            closePopup(isForever) {
              if (isForever) {
                Vuecookies.set('popup210124-close', 'Y', '1d')
              }
              document.body.style.overflow = ''
              this.popup = false
            },
            openPopup1() {
              this.popup1 = true
              document.body.style.overflow = 'hidden'
              setTimeout(function () {
                window.scrollTo(0, 0)
              }, 1000)

            },
            closePopup1(isForever) {
              if (isForever) {
                Vuecookies.set('popup2101241-close', 'Y', '1d')
              }
              document.body.style.overflow = ''
              this.popup1 = false
            },
            endVideoBG() {
                const idx = Math.floor(Math.random() * 4) + 1
                this.videoBGPath = '/assets/video/mainbg/' + idx + '.mp4'
                this.$refs.videoBG.src = this.videoBGPath
                this.$refs.videoBG.play()
            },
            doSlide() {
                // 메인 trend Slider
                $(".trending__slider .slider").slick({
                    slidesToShow: 6,
                    slidesToScroll: 6,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    arrows: true,
                    dots: true
                    // slidesToShow: 6,
                    // slidesToScroll: 1,
                    // autoplay: true,
                    // autoplaySpeed: 2000,
                    // arrows: true,
                    // dots: true
                })
            },
            selectItem(i) {
                if (typeof (i) !== 'string') return
                const path = `/detail/${i}`
                window.location.href = this.helper.langUrl(this.$i18n.locale, path)
            },
            getMainList() {
                var p = {
                    bpm: this.param.bpm.v,
                    voice: this.param.voice,
                    sort: this.param.sort
                }
                Http.get(`/beatsomeoneApi/main_list/${encodeURIComponent(this.currentGenre)}?${$.param(p)}`).then(r => {
                    this.list = r.data
                })
            },
            getTrendingList() {
                Http.get(`/beatsomeoneApi/main_trending_list`).then(r => {
                    this.listTrending = r.data
                    this.$nextTick(function () {
                        this.doSlide()
                    })
                })
            },
            getTestimonialsList() {
                axios.get('/beatsomeoneApi/main_testimonials_list')
                    .then(res => res.data)
                    .then(data => this.listTestimonials = data)
                    .catch(error => console.error(error))
            },
            beforeEnter: function (el) {
                el.style.opacity = 0
                el.style.height = 0
            },
            enter: function (el, done) {
                var delay = el.dataset.index * 150
                setTimeout(function () {
                    Velocity(
                        el,
                        {opacity: 1, height: 90, 'margin-bottom': 1,},
                        {complete: done}
                    )
                }, delay)
            },
            leave: function (el, done) {
                var delay = el.dataset.index * 150
                setTimeout(function () {
                    Velocity(
                        el,
                        {opacity: 0, height: 0, 'margin-bottom': 0,},
                        {complete: done}
                    )
                }, delay)
            },
            goToDetail(cit_key) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/detail/' + cit_key);
            },
            closeFooterBanner() {
              this.footerBanner = false
            },
        },

    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';


</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .startSelling {
        cursor: pointer;
    }

    .card.card--testimonials .img {
        position: relative;
        height: 230px;

        img {
            position: absolute;
            top: 50%;
            left: 50%;
            height: 100%;
            transform: translate(-50%, -50%);
        }
    }

</style>
