<template>

    <div class="wrapper">

        <Header :is-login="isLogin"></Header>
        <div class="player">
            <div class="wrap">
                <div class="player__top">
                    <div class="player__progress">
                        <div id="waveform">
                            <!-- Here be waveform -->
                        </div>

                        <div id="progress-container">
                            <input type="range" class="amplitude-song-slider" step=".1"/>
                            <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
                            <progress id="song-buffered-progress" class="amplitude-buffered-progress"></progress>
                        </div>
                    </div>
                </div>
                <div class="player__bottom">
                    <div class="player__favorite">
                        <button></button>
                    </div>
                    <div class="player__info">
                        <div class="col name">
                            <figure>
                  <span class="playList__cover">
                    <img data-amplitude-song-info="cover_art_url" class="album-art"/>
                  </span>
                                <figcaption>
                                    <h3 class="playList__title song-title" data-amplitude-song-info="name" >
                                    </h3>
                                    <span class="playList__by song-artist" data-amplitude-song-info="artist"></span>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                    <div id="central-controls" class="player__controller">
                        <div class="amplitude-prev" id="previous"></div>
                        <div class="amplitude-play-pause amplitude-paused" id="play-pause"></div>
                        <div class="amplitude-next" id="next"></div>
                    </div>
                    <div class="player__util">
                        <div class="player__shuffle amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
                        <div class="player__repeat amplitude-repeat amplitude-repeat-off" id="repeat"></div>
                        <div id="volume-container" class="player__volume">
                            <div class="volume-controls">
                                <div class="amplitude-mute amplitude-not-muted"></div>
                                <input type="range" class="amplitude-volume-slider">
                                <div class="ms-range-fix"></div>
                            </div>
                            <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="main">
                <section class="main__section1">
                    <video id="videoBG" poster="/assets/images/main-section1-visual.png" autoplay muted loop style="position:absolute;">
                        <source src="/uploads/data/video_bg.mp4" type="video/mp4">
                    </video>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>HOLIDAY GIVEAWAY</h1>
<!--                            <h2>-->
<!--                                {{ list }}-->
<!--                            </h2>-->
                            <p>
                                Finding incredible music & connecting with amazing artists
                                and<br/>
                                producers to collaborate with have never been easier.
                            </p>
                        </header>
                        <div class="main__media">
                            <div class="tab">
                                <button v-for="g in listGenre" :key="g" :class="{active:currentGenre === g}" @click="currentGenre = g">
                                    {{ g }}
                                </button>
                            </div>
                            <div class="filter">
                                <label for="voice" class="switch">
                                    Voice
                                    <input type="checkbox" hidden id="voice"/>
                                    <span></span>
                                </label>
                                <div class="custom-select ">
                                    <button class="selected-option">
                                        Sort By Staff Picks
                                    </button>
                                    <div class="options">
                                        <button class="option" data-value="">
                                            Top Downloads
                                        </button>
                                        <button class="option" data-value="">
                                            Sort By Staff Picks
                                        </button>
                                        <button class="option" data-value="">
                                            Top Downloads
                                        </button>
                                        <button class="option" data-value="">Newest</button>
                                    </div>
                                </div>
                                <div class="custom-select ">
                                    <button class="selected-option">
                                        BPM
                                    </button>
                                    <div class="options">
                                        <button class="option" data-value="">
                                            80 - 90
                                        </button>
                                        <button class="option" data-value="">
                                            90 - 100
                                        </button>
                                        <button class="option" data-value="">
                                            100 - 110
                                        </button>
                                        <button class="option" data-value="">110 - 120</button>
                                    </div>
                                </div>
<!--                                <div class="custom-select ">-->
<!--                                    <button class="selected-option">-->
<!--                                        Any Duration-->
<!--                                    </button>-->
<!--                                </div>-->
                            </div>
                            <div class="playList">
                                <!-- 아래 템플릿 문자열로 붙임 -->
                                <ul class="playList__list" id="playList__list">
                                    <Index_Items v-for="(item,index) in list" :item="item" :key="index"></Index_Items>
                                </ul>
                                <div class="playList__btnbox">
                                    <a class="playList__more" @click="moveMore">more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="main__section2">
                    <div class="wrap">
                        <header class="main__section2-title">
                            <h1>
                                ANYONE CAN BORROW
                                <br/>
                                OR SELL BEATS EASILY!
                            </h1>
                            <a href="/register">
                                I want to lend or sell my beat
                            </a>
                        </header>


                        <!-- 트렌딜 슬라이드 부분 -->
                        <div class="trending" >
                            <h2 class="trending__title">TRENDING MUSIC</h2>
                            <div class="trending__slider">
                                <div class="slider">
<!--                                slider의 버그로 인해 Vue OnClick 이벤트가 새로 생성되는 Element 에서 인식되지 않는 문제가 있어 @click 을 사용하지 않고 직접 vm에서 메서드 호출 방식으로 변경 하였음-->
                                    <div v-for="(i,index) in listTrending" :key="index" class="trending__slide-item albumItem" :onclick="`window.vm.$children[0].selectItem('${i.cit_key}')`" >

                                        <button class="albumItem__cover" >
                                            <img  :src="'/uploads/cmallitem/' + i.cit_file_1" :alt="i.cit_name"/>
                                        </button>
                                        <a  class="albumItem__link" >
                                            <h4 class="albumItem__title">{{ i.cit_name }}</h4>
                                            <p class="albumItem__singer">{{ i.musician }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 트렌드 슬라이드 끝 -->

                        <!-- 제휴 업체 로그 이미지  -->
                        <div class="alliance" @click="selectItem">
                            <img src="@/assets/images/alliance.png" alt="" href="#"/>
                        </div>
                        <!-- 제휴업체 로그 이미지 끝 -->

                        <div class="testimonials">
                            <article class="testimonials__title">
                                <h1>TESTIMONIALS</h1>
                                <p>Partner with the best team members!</p>
                            </article>
                            <article class="testimonials__lists">
                                <figure class="card card--testimonials" >
                                    <a href="">
                                        <div class="img">
                                            <img
                                                    src="@/assets/images/dummy/testimonials1.png"
                                                    alt=""
                                            />
                                            <button class="card--testimonials_play"></button>
                                        </div>
                                        <figcaption>
                                            <h3>WAITING (Indie Rock Type Beat)</h3>
                                            <p>by Fantom</p>
                                        </figcaption>
                                    </a>
                                </figure>
                                <figure class="card card--testimonials">
                                    <a href="">
                                        <div class="img">
                                            <img
                                                    src="@/assets/images/dummy/testimonials2.png"
                                                    alt=""
                                            />
                                            <button class="card--testimonials_play"></button>
                                        </div>
                                        <figcaption>
                                            <h3>WAITING (Indie Rock Type Beat)</h3>
                                            <p>by Fantom</p>
                                        </figcaption>
                                    </a>
                                </figure>
                                <figure class="card card--testimonials">
                                    <a href="">
                                        <div class="img">
                                            <img
                                                    src="@/assets/images/dummy/testimonials3.png"
                                                    alt=""
                                            />
                                            <button class="card--testimonials_play"></button>
                                        </div>
                                        <figcaption>
                                            <h3>WAITING (Indie Rock Type Beat)</h3>
                                            <p>by Fantom</p>
                                        </figcaption>
                                    </a>
                                </figure>
                            </article>
                            <div class="testimonials__btnbox">
                                <a href="/register">START SELLING</a>
                                <a href="/beatsomeone/sublist?genre=All%20Genre" class="beats">BROWSE BEATS</a>
                            </div>
                        </div>

                        <div class="main__desc">
                            <h1>
                                NOW IT'S TIME FOR YOUR BEATS AND<br/>
                                MUSIC TO BE SHOWN ALL OVER THE WORKLD,<br/>
                                ARE YOU READY?
                            </h1>
                            <a href="">
                                Trust our best team members and join us!
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

    require('@/assets/js/function');

    import $ from "jquery";
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Index_Items from "./Index_Items";
    import { EventBus } from '*/src/eventbus';

    export default {
        name: 'Index',
        components: {Header,Footer,Index_Items},
        data: function() {
            return {
                isLogin: false,
                init : {},
                list: null,
                listTrending: null,
                listTestimonials: null,
                currentGenre : 'All Genre',
                listGenre: ['All Genre','Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop','Free Beats'],
                listPlayer : [
                    {
                        id: 1,
                        name: "I Came Running",
                        artist: "Ancient Astronauts",
                        album: "We Are to Answer",
                        url: "/assets_m/audio/testfile.mp3",
                        cover_art_url: "https://521dimensions.com/img/open-source/amplitudejs/album-art/we-are-to-answer.jpg",
                        isNew: true,
                    },
                ],
            }
        },
        mounted() {


            // 메인페이지: 서브 앨범 슬라이드 이벤트
            $(".toggle-subList").on("click", function() {
                var itemLength = $(this)
                    .parents(".playList__itembox")
                    .find(".subPlayList .playList__itembox").length;
                $(this).toggleClass("active");
                $(this)
                    .parents(".playList__itembox")
                    .toggleClass("is-show-children");

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

            // 메인 리스트 조회
            this.getMainList();

            // Trending List
            this.getTrendingList();

            // Testimonials List
            this.getTestimonialsList();

            Amplitude.init({
                "songs": this.listPlayer,
                delay: 3000,
                waveforms: {
                    sample_rate: 3000
                }
            });
        },
        watch: {
            // 장르가 변경될 때
            currentGenre: function (n,o) {
                if(o && n !== o) {
                    this.getMainList();
                }
            }
        },
        methods: {
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
                });
            },
            moveMore() {
                const path = `/beatsomeone/sublist?genre=${this.currentGenre}`;
                window.location.href = path;
            },
            selectItem(i) {
                if(typeof(i) !== 'string') return;
                const path = `/beatsomeone/detail/${i}`;
                window.location.href = path;
            },
            getMainList() {
                Http.get(`/beatsomeoneApi/main_list/${encodeURIComponent(this.currentGenre)}`).then(r=> {
                    this.list = r.data;
                });
            },
            getTrendingList() {
                Http.get(`/beatsomeoneApi/main_trending_list`).then(r=> {
                    this.listTrending = r.data;
                    this.$nextTick(function() {
                        this.doSlide();
                    });
                });
            },
            getTestimonialsList() {
                Http.get(`/beatsomeoneApi/main_testimonials_list`).then(r=> {
                    this.listTestimonials = r.data;
                });
            },

        },

    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';


</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>
