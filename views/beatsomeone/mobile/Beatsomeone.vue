<template>
    <div>
<!--        <div id="noti-popup" ref="noti-popup" v-if="popup && $i18n.locale !== 'en'">-->
<!--          <div class="noti-content">-->
<!--            <div style="position: absolute;right: 5px;width: 30px;height: 30px;margin-top: 8px;" @click="closePopup"></div>-->
<!--            <div style="background-color: #000000">-->
<!--              <img src="/assets_m/images/event/20201207/1.png" style="display:block;">-->
<!--            </div>-->
<!--            <div>-->
<!--              <img src="/assets_m/images/event/20201207/2.png" style="display:block;" @click="goEvent">-->
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
                            <div class="playList">
                                <transition-group
                                        name="staggered-fade"
                                        tag="ul"
                                        v-bind:css="false"
                                        v-on:before-enter="beforeEnter"
                                        v-on:enter="enter"
                                        v-on:leave="leave"
                                >
                                    <template v-for="item in list">
                                        <KeepAliveGlobal :key="item.cit_key">
                                            <Index_Items :item="item" :key="item.cit_key"></Index_Items>
                                        </KeepAliveGlobal>
                                    </template>
                                </transition-group>
                                <div class="playList__btnbox">
                                    <a class="playList__more pointer" @click="moveMore">{{ $t('mainMore') }}</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="main__section2">
                        <header class="main__section2-title">
                            <div class="wrap">
                                <h1>
                                    {{ $t('bitTradingMessage1') }}
                                    <br/>
                                    {{ $t('bitTradingMessage2') }}
                                </h1>
                                <a @click="moveAction('startSelling')">{{ $t('lendOrSellMyBeat') }}</a>
                            </div>
                        </header>
                        <!-- 트렌딜 슬라이드 부분 -->
                        <div class="trending">
                            <h2 class="trending__title">{{ $t('trendingMusic') }}</h2>
                            <div class="trending__slider">
                                <div class="slider">
                                    <div
                                            class="trending__slide-item albumItem"
                                            v-for="(i,index) in listTrending"
                                            :key="index"
                                            @click="goToDetail(i.cit_key)"
                                    >
                                        <button class="albumItem__cover">
                                            <img :src="'/uploads/cmallitem/' + i.thumb" :alt="i.cit_name"/>
                                        </button>
                                        <a href="javascript:;" class="albumItem__link">
                                            <h4 class="albumItem__title">{{ i.cit_name }}</h4>
                                            <p class="albumItem__singer">{{ i.mem_nickname }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- 트렌드 슬라이드 끝 -->
                            <!-- 제휴 업체 로그 이미지  -->
                            <div class="alliance">
                                <img src="@/assets_m/images/partner/partner-total1.png" alt href="#"/>
                            </div>
                            <!-- 제휴업체 로그 이미지 끝 -->
                            <div class="testimonials">
                                <div class="wrap">
                                    <article class="testimonials__title">
                                        <h1>{{ $t('testimonials') }}</h1>
                                        <p>{{ $t('bestTeamMember') }}</p>
                                    </article>
                                    <article class="testimonials__lists">
                                        <figure class="card card--testimonials" v-for="(post, index) in listTestimonials" :key="index">
                                            <a :href="'/video#/' + post.post_id">
                                                <div class="img" v-if="post.files.length === 1">
                                                    <img
                                                            :src="'/uploads/post/' + post.files[0].pfi_filename"
                                                            alt=""
                                                    />
                                                </div>
                                                <div class="img" v-else>
                                                    <img
                                                        :src="'/uploads/post/' + post.files[1].pfi_filename"
                                                        alt=""
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
                                        <a @click="moveAction('startSelling')">{{ $t('startSelling') }}</a>
                                        <a
                                                href="/beatsomeone/sublist?genre=All%20Genre"
                                                class="beats"
                                        >{{ $t('browseBeats') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="main__desc">
                                <h1>
                                    {{ $t('musicWorldMsg1') }}
                                    <br/>
                                    {{ $t('musicWorldMsg2') }}
                                    <br/>
                                    {{ $t('areYouReady') }}
                                </h1>
                                <a @click="moveAction('startSelling')">{{ $t('trustOurTeamMsg') }}</a>
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
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Index_Items from "./Index_Items";
    import {EventBus} from "*/src/eventbus";
    import Velocity from "velocity-animate";
    import MainPlayer from "@/vue/common/MobileMainPlayer";
    import KeepAliveGlobal from "vue-keep-alive-global";

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
                popup: true
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
            listGenreName() {
                let list = [],
                    _self = this;

                this.listGenre.forEach(function (val) {
                    list.push(_self.$t("genre" + window.genLangCode(val)));
                });

                return list;
            },
        },
        methods: {
            goEvent() {
              location.href = '/event'
            },
            closePopup() {
              this.popup = false
            },
            endVideoBG() {
                const idx = Math.floor(Math.random() * 6) + 1;
                this.videoBGPath = "/uploads/data/bgvideo/mobile/bg" + idx + ".mp4";
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
            moveMore() {
                const path = `/beatsomeone/sublist?genre=${this.currentGenre}`;
                window.location.href = path;
            },
            selectItem(i) {
                const path = `/detail/${i}`;
                window.location.href = path;
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
            moveAction(o) {
                let url = null;
                // 로그인시
                if (this.userInfo) {
                    switch (o) {
                        case "startSelling": {
                            if (this.member_group_name === 'buyer') {
                                url = '/mypage/upgrade';
                            } else if (this.member_group_name.includes('seller')) {
                                url = '/mypage/regist_item';
                            } else {
                                url = '/mypage/upgrade';
                            }
                            break;
                        }
                    }
                }
                // 비로그인시
                else {
                    url = "/register";
                }

                // 이동
                window.location.href = url;
            },
            goToDetail(cit_key) {
                window.location.href = '/detail/' + cit_key;
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
<style scope="scope" lang="css">
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
</style>
