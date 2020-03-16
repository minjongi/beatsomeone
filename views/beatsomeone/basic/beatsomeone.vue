<template>

    <div class="wrapper">

        <Header></Header>

        <div class="container">
            <div class="main">
                <section class="main__section1">
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>HOLIDAY GIVEAWAY</h1>
                            <h2>
                                {{ list }}
                            </h2>
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
                                <div class="custom-select ">
                                    <button class="selected-option">
                                        Any Duration
                                    </button>
                                </div>
                            </div>
                            <div class="playList">
                                <!-- 아래 템플릿 문자열로 붙임 -->
                                <ul class="playList__list" id="playList__list">
                                    <Index_Items v-for="(item,index) in list" :item="item" :key="index"></Index_Items>
                                </ul>
                                <div class="playList__btnbox">
                                    <a href="#//" class="playList__more">more</a>
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
                            <a href="">
                                I want to lend or sell my beat
                            </a>
                        </header>

                        <!-- 트렌딜 슬라이드 부분 -->
                        <div class="trending">
                            <h2 class="trending__title">TRENDING MUSIC</h2>
                            <div class="trending__slider">
                                <div class="slider">
                                    <div v-for="index in 10" :key="index" class="trending__slide-item albumItem" @click="selectItem(index)">
                                        <button class="albumItem__cover">
                                            <img src="https://via.placeholder.com/190x190" alt=""/>
                                        </button>
                                        <a href="#//" class="albumItem__link">
                                            <h4 class="albumItem__title">Juice Wrld Type Beat</h4>
                                            <p class="albumItem__singer">jonathan mudiayi</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 트렌드 슬라이드 끝 -->

                        <!-- 제휴 업체 로그 이미지  -->
                        <div class="alliance">
                            <img src="./../../../assets/images/alliance.png" alt=""/>
                        </div>
                        <!-- 제휴업체 로그 이미지 끝 -->

                        <div class="testimonials">
                            <article class="testimonials__title">
                                <h1>TESTIMONIALS</h1>
                                <p>Partner with the best team members!</p>
                            </article>
                            <article class="testimonials__lists">
                                <figure class="card card--testimonials">
                                    <a href="">
                                        <div class="img">
                                            <img
                                                    src="./../../../assets/images/dummy/testimonials1.png"
                                                    alt=""
                                            />
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
                                                    src="@/images/dummy/testimonials2.png"
                                                    alt=""
                                            />
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
                                                    src="./../../../assets/images/dummy/testimonials3.png"
                                                    alt=""
                                            />
                                        </div>
                                        <figcaption>
                                            <h3>WAITING (Indie Rock Type Beat)</h3>
                                            <p>by Fantom</p>
                                        </figcaption>
                                    </a>
                                </figure>
                            </article>
                            <div class="testimonials__btnbox">
                                <a href="">START SELLING</a>
                                <a href="" class="beats">BROWSE BEATS</a>
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

    require('@/js/function');
    require('@/audio/testfile.mp3');

    import $ from "jquery";
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Index_Items from "./Index_Items";
    import axios from 'axios';

    export default {
        name: 'Index',
        components: {Header,Footer,Index_Items},
        data: function() {
            return {
                init : {},
                list: null,
                currentGenre : 'All Genre',
                listGenre: ['All Genre','Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop','Free Beats'],
                playList : [
                    {
                        id: 1,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "Celebration (Buy 1 Get 3 FR...",
                        singer: "by Diamond Style",
                        genres: [
                            {
                                active: true,
                                title: "All Genre"
                            },
                            {
                                active: true,
                                title: "Jaz"
                            },
                            {
                                active: false,
                                title: "Amb"
                            },
                            {
                                active: false,
                                title: "Fol"
                            },
                            {
                                active: false,
                                title: "Singer-Songwriter"
                            }
                        ],
                        audioFile: "/dist/audio/testfile.mp3",
                        subPlayList: [
                            {
                                id: 8,
                                coverImg: "https://via.placeholder.com/55x55",
                                isNew: true,
                                title: "Sky Red",
                                singer: "by Ant Chamberlain",
                                genres: [
                                    {
                                        active: true,
                                        title: "K-Pop"
                                    },
                                    {
                                        active: true,
                                        title: "Country"
                                    },
                                    {
                                        active: false,
                                        title: "Amb"
                                    },
                                    {
                                        active: false,
                                        title: "K-Pop"
                                    },
                                    {
                                        active: false,
                                        title: "Singer-Songwriter"
                                    }
                                ],
                                audioFile: "/dist/audio/testfile.mp3"
                            },
                            {
                                id: 13,
                                coverImg: "https://via.placeholder.com/55x55",
                                isNew: true,
                                title: "Malibu",
                                singer: "by Mvrio",
                                genres: [
                                    {
                                        active: false,
                                        title: "Fol"
                                    },
                                    {
                                        active: false,
                                        title: "Singer-Songwriter"
                                    }
                                ],
                                audioFile: "/dist/audio/testfile.mp3"
                            },
                            {
                                id: 24,
                                coverImg: "https://via.placeholder.com/55x55",
                                isNew: true,
                                title: "Sky Red_breathe-no bac...",
                                singer: "by Ant Chamberlain",
                                genres: [
                                    {
                                        active: true,
                                        title: "Reggae"
                                    },
                                    {
                                        active: true,
                                        title: "R&B"
                                    },
                                    {
                                        active: false,
                                        title: "Amb"
                                    },
                                    {
                                        active: false,
                                        title: "Fol"
                                    },
                                    {
                                        active: false,
                                        title: "Singer-Songwriter"
                                    }
                                ],
                                audioFile: "/dist/audio/testfile.mp3"
                            }
                        ]
                    },
                    {
                        id: 2,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "EMOTIONS",
                        singer: "by Mvrio",
                        genres: [
                            {
                                active: true,
                                title: "Acoustic Folk"
                            },
                            {
                                active: true,
                                title: "Electronic"
                            },
                            {
                                active: false,
                                title: "Amb"
                            },
                            {
                                active: false,
                                title: "Fol"
                            },
                            {
                                active: false,
                                title: "Singer-Songwriter"
                            }
                        ],
                        audioFile: "/dist/audio/testfile.mp3",
                        subPlayList: []
                    },
                    {
                        id: 3,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "Aishiteru (Dean Lo-Fi Inst...",
                        singer: "by Roko Tensei",
                        genres: [
                            {
                                active: true,
                                title: "Hip Hop"
                            },
                            {
                                active: false,
                                title: "Jaz"
                            },
                            {
                                active: false,
                                title: "Amb"
                            },
                            {
                                active: false,
                                title: "Fol"
                            },
                            {
                                active: false,
                                title: "World"
                            }
                        ],
                        audioFile: "/dist/audio/testfile.mp3",
                        subPlayList: []
                    },
                    {
                        id: 4,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "Sad Acoustic Guitar",
                        singer: "Ryini Beats",
                        genres: [
                            {
                                active: true,
                                title: "Acoustic Folk"
                            },
                            {
                                active: false,
                                title: "Jaz"
                            },
                            {
                                active: false,
                                title: "Free Beats"
                            }
                        ],
                        audioFile: "/dist/audio/testfile.mp3",
                        subPlayList: []
                    }
                ],
            }
        },
        mounted() {

            // 메인 trend Slider
            $(".trending__slider .slider").slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: true,
                dots: true
            });
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
            selectItem(i) {
                const path = `/beatsomeone/detail?id=${i.id}`;
                window.location.href = path;
            },
            getMainList() {
                console.log('query');
                //axios.get(`/beatsomeone/main_list?genre=${this.currentGenre}`).then(r=> {
                axios.get(`/beatsomeone/main_list/${encodeURIComponent(this.currentGenre)}`).then(r=> {
                    this.list = r.data;
                });
            },

        },

    }

</script>

<style lang="scss">
    @import './../../../assets/scss/App.scss';


</style>

<style lang="css">
    @import './../../../assets/plugins/slick/slick.css';
    @import './../../../assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>
