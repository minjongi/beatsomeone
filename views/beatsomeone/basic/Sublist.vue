<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>

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
                                                        type="radio"
                                                        name="filter"
                                                        hidden
                                                        :id="'fillter1'+index"
                                                        :value="f"
                                                        v-model="param.currentGenre"
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
                                                        type="radio"
                                                        name="subgenres"
                                                        hidden
                                                        :id="'fillter2'+index"
                                                        :value="f"
                                                        v-model="param.currentSubgenres"
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
                                        <input type="text" readonly id="bpm-end"/>
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
                                                        type="radio"
                                                        name="moods"
                                                        hidden
                                                        :id="'fillter3'+index"
                                                        :value="f"
                                                        v-model="param.currentMoods"
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
                                                        type="radio"
                                                        name="trackTypes"
                                                        hidden
                                                        :id="'fillter4'+index"
                                                        :value="f"
                                                        v-model="param.currentTrackType"
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
                                <div class="trending__slide-item albumItem" v-for="(i,index) in listTop5" :key="index" @click="selectItem(i)">
                                    <button class="albumItem__cover">
                                        <img :src="'/uploads/cmallitem/' + i.cit_file_1" :alt="i.cit_name" />
                                    </button>
                                    <a href="#//" class="albumItem__link">
                                        <h4 class="albumItem__title">{{ i.cit_name }}</h4>
                                        <p class="albumItem__singer">{{ i.musician }}</p>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <h2 class="section-title">PLAY LIST</h2>
                            <div class="playList">
                                <ul class="playList__list" id="playList__list">
                                    <Index_Items v-for="(item,index) in list" :item="item" :key="index"></Index_Items>
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
    require('@/assets/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Index_Items from "./Index_Items";
    import { EventBus } from '*/src/eventbus';

    export default {
        components: {Header,Footer,Index_Items,},
        data: function() {
            return {
                isLogin: false,
                listFilter: ['All Genre','Hip Hop', 'K-Pop', 'Pop', 'R&B', 'Rock', 'Electronic', 'Reggae', 'Country', 'World'],
                listSubgenres: ['All','Hip Hop', 'K-Pop', 'Pop', 'R&B', 'Rock', 'Electronic', 'Reggae', 'Country', 'World'],
                listMoods: ['All','Accomplished', 'Adored', 'Angry', 'Annoyed', 'Anxious,Bouncy', 'Calm,Confident', 'Crazy', 'Crunk', 'Dark', 'Depressed', 'Determined', 'Dirty', 'Disappointed', 'Eccentric', 'Energetic', 'Enraged', 'Epic', 'Evil', 'Flirty', 'Frantic', 'Giddy', 'Gloomy', 'Grateful', 'Happy', 'Hyper', 'Inspiring', 'Intense', 'Lazy', 'Lonely', 'Loved', 'Mellow', 'Peaceful', 'Rebellious', 'Relaxed', 'Sad', 'Scared', 'Silly', 'Soulful'],
                listTrackType: ['All types','Beats', 'Beats with chorus', 'Vocals', 'Song reference', 'Songs'],

                list: null,
                listTop5: null,
                param: {
                    currentGenre: null,
                    currentSubgenres : null,
                    currentMoods: null,
                    currentTrackType: null,
                    currentBpmFr: 0,
                    currentBpmTo : 120,
                },


            }
        },
        watch: {
            // 검색조건 변경
            param: {
                deep: true,
                handler(n,o) {
                    log.debug({
                        'change param' : n,
                    });
                    if(o) {
                        this.updateAllList();
                    }
                }
            },
        },
        created() {
            this.param.currentGenre = this.listFilter[0];
            this.param.currentSubgenres = this.listSubgenres[0];
            this.param.currentMoods = this.listMoods[0];
            this.param.currentTrackType = this.listTrackType[0];
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
                    onStart: (data) => {
                        $("#bpm-start").val(data.from_pretty);
                        $("#bpm-end").val(data.to_pretty);
                        this.param.currentBpmFr = data.from_pretty;
                        this.param.currentBpmTo = data.to_pretty;
                    },
                    onChange: (data) => {
                        log.debug({
                          'rpm onChange':data,
                        })
                        $("#bpm-start").val(data.from_pretty);
                        $("#bpm-end").val(data.to_pretty);
                        this.param.currentBpmFr = data.from_pretty;
                        this.param.currentBpmTo = data.to_pretty;
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

            this.updateAllList();

        },
        methods: {
            updateAllList:  _.debounce(function() {
                this.getList();
                this.getTopList();
            },100),
            addCart() {

                let detail_qty = {};
                detail_qty[this.item['cde_id']] = 1;
                Http.post( `/beatsomeoneApi/itemAction`,{stype: 'cart',cit_id:this.item.cit_id,chk_detail:[this.item.cde_id],detail_qty:detail_qty,}).then(r=> {
                    if(!r) {
                        log.debug('장바구니 담기 실패');
                    } else {
                        EventBus.$emit('add_cart');
                        log.debug('장바구니 담기 성공');

                    }
                });
            },
            selectItem(i) {
                const path = `/beatsomeone/detail/${i.cit_key}`;
                window.location.href = path;
            },
            getList() {
                const p = {
                    genre: this.param.currentGenre,
                    subgenre: this.param.currentSubgenres,
                    bpmFr: this.param.currentBpmFr,
                    bpmTo: this.param.currentBpmTo,
                    moods: this.param.currentMoods,
                    trackType: this.param.currentTrackType
                }
                Http.post(`/beatsomeoneApi/sublist_list`,p).then(r=> {
                    this.list = r;
                });
            },
            getTopList() {
                const p = {
                    genre: this.param.currentGenre,
                    subgenre: this.param.currentSubgenres,
                    bpmFr: this.param.currentBpmFr,
                    bpmTo: this.param.currentBpmTo,
                    moods: this.param.currentMoods,
                    trackType: this.param.currentTrackType,
                    limit: 5
                }
                Http.post(`/beatsomeoneApi/sublist_top_list`,p).then(r=> {
                    this.listTop5 = r;
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
