<template>

    <div class="wrapper">

        <Header :is-login="isLogin"/>
        <div class="container sub">
            <div class="sublist">
                <button class="showFilter"></button>

                <div class="sublist__content">
                    <div class="row">
                        <h2 class="section-title">
                            <div class="wrap">TOP <span class="number">5</span></div>
                        </h2>
                        <div class="topFive">
                            <div class="topFice__slider">
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
                    </div>
                    <div class="row">
                        <div class="playList">
                            <!-- 아래 템플릿 문자열로 붙임 -->
                            <ul class="playList__list" id="playList__list"></ul>
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

                list: null,
                listTop5: null,
                currentFilter: null,
                currentSubgenres : null,
                currentMoods: null,
                currentTrackType: null,
            }
        },
        created() {
            this.currentFilter = this.listFilter[0];
            this.currentSubgenres = this.listSubgenres[0];
            this.currentMoods = this.listMoods[0];
            this.currentTrackType = this.listTrackType[0];
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

            this.getList();

            this.getTop5List();

        },
        methods: {
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
                Http.get(`/beatsomeoneApi/sublist_list`).then(r=> {
                    this.list = r.data;
                });
            },
            getTop5List() {
                Http.get(`/beatsomeoneApi/sublist_top5_list`).then(r=> {
                    this.listTop5 = r.data;
                });
            },
        },

    }

</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>
