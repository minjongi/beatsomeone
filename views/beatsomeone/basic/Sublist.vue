<template>

    <div class="wrapper">

        <Header/>
        <div class="container sub">
            <div class="sublist">
                <div class="wrap">
                    <div class="sublist__filter">
                        <div class="row">
                            <div class="filter">
                                <h2 class="filter__title">FILTER</h2>
                                <div class="filter__content">
                                    <ul class="filter__list">
                                        <li class="filter__item" v-for="(f,index) in listFilter" :key="index">
                                            <label :for="'fillter1'+index" class="checkbox">
                                                <input
                                                        type="checkbox"
                                                        name="filter"
                                                        hidden
                                                        :id="'fillter1'+index"
                                                        :value="f"
                                                />
                                                <span></span> {{ f }}
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="filter">
                                <h2 class="filter__title">Subgenres</h2>
                                <div class="filter__content">
                                    <ul class="filter__list">
                                        <li class="filter__item" v-for="(f,index) in listSubgenres" :key="index">
                                            <label :for="'fillter2'+index" class="checkbox">
                                                <input
                                                        type="checkbox"
                                                        name="subgenres"
                                                        hidden
                                                        :id="'fillter2'+index"
                                                        :value="f"
                                                />
                                                <span></span> {{ f }}
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="filter">
                                <h2 class="filter__title">BPM</h2>
                                <div class="filter__content">
                                    <div class="bpmRange">
                                        <input type="text" />
                                    </div>
                                    <div class="bpmRangeInfo">
                                        <input type="text" readonly id="bpm-start" />
                                        <span> - </span>
                                        <input type="text" readonly id="bpm-end" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="filter">
                                <h2 class="filter__title folded">Moods</h2>
                                <div class="filter__content" style="display: none;">
                                    <ul class="filter__list">
                                        <li class="filter__item" v-for="(f,index) in listMoods" :key="index">
                                            <label :for="'fillter3'+index" class="checkbox">
                                                <input
                                                        type="checkbox"
                                                        name="moods"
                                                        hidden
                                                        :id="'fillter3'+index"
                                                        :value="f"
                                                />
                                                <span></span> {{ f }}
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="filter">
                                <h2 class="filter__title folded">Track Type</h2>
                                <div class="filter__content" style="display: none;">
                                    <ul class="filter__list">
                                        <li class="filter__item" v-for="(f,index) in listTrackType" :key="index">
                                            <label :for="'fillter4'+index" class="checkbox">
                                                <input
                                                        type="checkbox"
                                                        name="trackTypes"
                                                        hidden
                                                        :id="'fillter4'+index"
                                                        :value="f"
                                                />
                                                <span></span> {{ f }}
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sublist__content">
                        <div class="row">
                            <h2 class="section-title">
                                TOP <span class="number">5</span>
                                <div class="sort">
                                    <span>SORT BY</span>
                                    <div class="custom-select ">
                                        <button class="selected-option">
                                            All select
                                        </button>
                                        <div class="options">
                                            <button class="option" data-value="">
                                                sort1
                                            </button>
                                            <button class="option" data-value="">
                                                sort2
                                            </button>
                                            <button class="option" data-value="">
                                                sort3
                                            </button>
                                            <button class="option" data-value="">Newest</button>
                                        </div>
                                    </div>
                                </div>
                            </h2>
                            <div class="topFive">
                                <div class="trending__slide-item albumItem">
                                    <button class="albumItem__cover">
                                        <img src="https://via.placeholder.com/190x190" alt="" />
                                    </button>
                                    <a href="#//" class="albumItem__link">
                                        <h4 class="albumItem__title">Juice Wrld Type Beat</h4>
                                        <p class="albumItem__singer">jonathan mudiayi</p>
                                    </a>
                                </div>
                                <div class="trending__slide-item albumItem">
                                    <button class="albumItem__cover">
                                        <img src="https://via.placeholder.com/190x190" alt="" />
                                    </button>
                                    <a href="#//" class="albumItem__link">
                                        <h4 class="albumItem__title">Juice Wrld Type Beat</h4>
                                        <p class="albumItem__singer">jonathan mudiayi</p>
                                    </a>
                                </div>
                                <div class="trending__slide-item albumItem">
                                    <button class="albumItem__cover">
                                        <img src="https://via.placeholder.com/190x190" alt="" />
                                    </button>
                                    <a href="#//" class="albumItem__link">
                                        <h4 class="albumItem__title">Juice Wrld Type Beat</h4>
                                        <p class="albumItem__singer">jonathan mudiayi</p>
                                    </a>
                                </div>
                                <div class="trending__slide-item albumItem">
                                    <button class="albumItem__cover">
                                        <img src="https://via.placeholder.com/190x190" alt="" />
                                    </button>
                                    <a href="#//" class="albumItem__link">
                                        <h4 class="albumItem__title">Juice Wrld Type Beat</h4>
                                        <p class="albumItem__singer">jonathan mudiayi</p>
                                    </a>
                                </div>
                                <div class="trending__slide-item albumItem">
                                    <button class="albumItem__cover">
                                        <img src="https://via.placeholder.com/190x190" alt="" />
                                    </button>
                                    <a href="#//" class="albumItem__link">
                                        <h4 class="albumItem__title">Juice Wrld Type Beat</h4>
                                        <p class="albumItem__singer">jonathan mudiayi</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h2 class="section-title">PLAY LIST</h2>
                            <div class="playList">
                                <!-- 아래 템플릿 문자열로 붙임 -->
                                <ul class="playList__list" id="playList__list">
                                    <!-- 플레이리스트 들어감 -->
                                    <Index_Items v-for="(item,index) in playList" :item="item" :key="index"></Index_Items>
                                </ul>
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

    import $ from "jquery";
    require('@/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Index_Items from "./Index_Items";

    export default {
        components: {Header,Footer,Index_Items,},
        data: function() {
            return {
                listFilter: ['All Genre'
                    ,'Hip Hop'
                    ,'Pop'
                    ,'R&B'
                    ,'Rock'
                    ,'Electronic'
                    ,'Reggae'
                    ,'World'],
                listSubgenres: ['All'
                    ,'Rock'
                    ,'Hip Hop'
                    ,'Electronic'
                    ,'R&B'
                    ,'Country'
                    ,'K-pop'],
                listMoods: ['All'
                    ,'Accomplished'
                    ,'Adored'
                    ,'Angry'
                    ,'Annoyed'],
                listTrackType: ['All types'
                    ,'Beats'
                    ,'Beats with chorus'
                    ,'Vocals'
                    ,'Song reference'
                    ,'Songs'],

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
                        subPlayList: []
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

            $(".filter__title").on("click", function() {
                $(this).toggleClass("folded");
                $(this)
                    .siblings(".filter__content")
                    .stop()
                    .slideToggle();
            });


            // BPM range
            if ($(".bpmRange").length) {
                $(".bpmRange input").ionRangeSlider({
                    skin: "round",
                    type: "double",
                    min: 0,
                    max: 170,
                    from: 0,
                    to: 125,
                    onStart: function(data) {
                        $("#bpm-start").val(data.from_pretty);
                        $("#bpm-end").val(data.to_pretty);
                    },
                    onChange: function(data) {
                        $("#bpm-start").val(data.from_pretty);
                        $("#bpm-end").val(data.to_pretty);
                    }
                });
            }

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
        methods: {

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
