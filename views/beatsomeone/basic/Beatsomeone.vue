<template>
    <div class="wrapper">
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
                            <h1>{{ $t('holidayGiveaway') }}</h1>
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
                                        <button class="option" data-value="" v-for="(o,i) in listSort" :key="i"
                                                @click="param.sort = o">
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
                                    <a class="playList__more" @click="moveMore" style="cursor: pointer !important;">{{ $t('more') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="main__section2">
                    <div class="filter reverse"></div>
                    <div class="wrap">
                        <header class="main__section2-title">
                            <h1>
                                {{ $t('bitTradingMessage1') }}<br/>
                                {{ $t('bitTradingMessage2') }}
                            </h1>
                            <a class="startSelling" @click="moveAction('startSelling')">
                                {{ $t('lendOrSellMyBeat') }}
                            </a>
                        </header>
                        <!-- 트렌딜 슬라이드 부분 -->
                        <div class="trending">
                            <h2 class="trending__title">{{ $t('trendingMusic') }}</h2>
                            <div class="trending__slider">
                                <div class="slider">
                                    <!--                                slider의 버그로 인해 Vue OnClick 이벤트가 새로 생성되는 Element 에서 인식되지 않는 문제가 있어 @click 을 사용하지 않고 직접 vm에서 메서드 호출 방식으로 변경 하였음-->
                                    <div v-for="(i,index) in listTrending" :key="index"
                                         class="trending__slide-item albumItem"
                                         :onclick="`window.vm.$children[0].selectItem('${i.cit_key}')`">

                                        <button class="albumItem__cover">
                                            <img :src="'/uploads/cmallitem/' + i.cit_file_1" :alt="i.cit_name"/>
                                        </button>
                                        <a class="albumItem__link">
                                            <h4 class="albumItem__title">{{ i.cit_name }}</h4>
                                            <p class="albumItem__singer">{{ i.mem_nickname }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 트렌드 슬라이드 끝 -->
                        <!-- 제휴 업체 로그 이미지  -->
                        <div class="alliance" @click="selectItem">
                            <img src="@/assets/images/alliance.png" alt="" href="#" style="opacity: .3"/>
                        </div>
                        <!-- 제휴업체 로그 이미지 끝 -->
                        <div class="testimonials">
                            <article class="testimonials__title">
                                <h1>{{ $t('testimonials') }}</h1>
                                <p>{{ $t('bestTeamMember') }}</p>
                            </article>
                            <article class="testimonials__lists">
                                <figure class="card card--testimonials">
                                    <a href="https://youtu.be/0khjIlr6Avw" target="_blank">
                                        <div class="img">
                                            <img
                                                    src="@/assets/images/testimonials/testimonials_001.png"
                                                    alt=""
                                            />
                                            <button class="card--testimonials_play"></button>
                                        </div>
                                        <figcaption>
                                            <h3>글로벌 Spinnin’ Records 1위 & Splice 리믹스 2위</h3>
                                            <p>by Rothchild</p>
                                        </figcaption>
                                    </a>
                                </figure>
                                <figure class="card card--testimonials">
                                    <a href="https://youtu.be/mMxhVtF3qFA" target="_blank">
                                        <div class="img">
                                            <img
                                                    src="@/assets/images/testimonials/testimonials_002.png"
                                                    alt=""
                                            />
                                            <button class="card--testimonials_play"></button>
                                        </div>
                                        <figcaption>
                                            <h3>TXT 작사, 유재하 음악경연대회 수상</h3>
                                            <p>by 수경(빨간의자)</p>
                                        </figcaption>
                                    </a>
                                </figure>
                                <figure class="card card--testimonials">
                                    <a href="https://youtu.be/_tPZc-MsIwE" target="_blank">
                                        <div class="img">
                                            <img
                                                    src="@/assets/images/testimonials/testimonials_003.png"
                                                    alt=""
                                            />
                                            <button class="card--testimonials_play"></button>
                                        </div>
                                        <figcaption>
                                            <h3>정규앨범 ‘Gang Byeon Buk-Ro Drive’ 발매</h3>
                                            <p>by NOP.K</p>
                                        </figcaption>
                                    </a>
                                </figure>
                            </article>
                            <div class="testimonials__btnbox">
                                <a class="startSelling" @click="moveAction('startSelling')">{{ $t('startSelling') }}</a>
                                <a href="/beatsomeone/sublist?genre=All%20Genre" class="beats">{{ $t('browseBeats') }}</a>
                            </div>
                        </div>
                        <div class="main__desc">
                            <h1>
                                {{ $t('musicWorldMsg1') }}<br/>
                                {{ $t('musicWorldMsg2') }}<br/>
                                {{ $t('areYouReady') }}

                            </h1>
                            <a class="startSelling" @click="moveAction('startSelling')">
                                {{ $t('trustOurTeamMsg') }}
                            </a>
                        </div>
                    </div>
                    <Footer></Footer>
                </section>
            </div>
        </div>
    </div>
</template>

<script>

    require('@/assets/js/function')

    import $ from "jquery"
    import Header from "./include/Header"
    import Footer from "./include/Footer"
    import Index_Items from "./Index_Items"
    import {EventBus} from '*/src/eventbus'
    import Velocity from 'velocity-animate'
    import MainPlayer from "@/vue/common/MainPlayer"
    import KeepAliveGlobal from 'vue-keep-alive-global'

    export default {
        name: 'Index',
        components: {Header, Footer, Index_Items, MainPlayer, KeepAliveGlobal},
        data: function () {
            return {
                userInfo: null,
                isLogin: false,
                init: {},
                list: null,
                listTrending: null,
                listTestimonials: null,
                currentGenre: 'All Genre',
                listGenre: ['All Genre'].concat(window.genre).concat(['Free Beats']),
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
                videoBGPath: ''
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

            this.endVideoBG()
        },
        computed: {
            listSortParamName() {
                return this.listSortName[this.listSort.indexOf(this.param.sort)]
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
            }
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
            endVideoBG() {
                const idx = Math.floor(Math.random() * 6) + 1
                this.videoBGPath = '/uploads/data/bgvideo/pc/202006/bg' + idx + '.mp4'
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
            moveMore() {
                const path = `/beatsomeone/sublist?genre=${this.currentGenre}`
                window.location.href = path
            },
            selectItem(i) {
                if (typeof (i) !== 'string') return
                const path = `/beatsomeone/detail/${i}`
                window.location.href = path
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
                Http.get(`/beatsomeoneApi/main_testimonials_list`).then(r => {
                    this.listTestimonials = r.data
                })
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
            moveAction(o) {
                let url = null;
                // 로그인시
                if(this.userInfo) {
                    switch(o) {
                        case 'startSelling': {
                            switch (this.userInfo.mem_usertype) {
                                case '1':
                                    url = '/mypage/sellerreg';
                                    break;
                                case '2':
                                    url = '/mypage/regist_item';
                                    break;
                                case '3':
                                    url = '/mypage/regist_item';
                                    break;
                                case '4':
                                    url = '/mypage/regist_item';
                                    break;

                            }
                            break;
                        }
                    }
                }
                // 비로그인시
                else {
                    url = '/register';
                }

                // 이동
                window.location.href = url;
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

    .startSelling {
        cursor: pointer;
    }

</style>
