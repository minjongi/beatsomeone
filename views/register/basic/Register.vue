<template>

    <div class="provision">
        <div class="table-box">
            <div class="table-heading">회원 유형 선택</div>
            <div class="table-body">
                <ol>
                    <li>
                        <a class="btn btn-default btn-sm" href="/register/register_user">일반 회원</a>
                    </li>
                    <li>
                        <a class="btn btn-default btn-sm" href="/register/register_musician">뮤지션 회원</a>
                    </li>
                </ol>
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
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    arrows: true,
                    dots: true
                });
            },
            moveMore() {
                const path = `/beatsomeone/sublist?genre=${this.currentGenre}`;
                window.location.href = path;
            },
            selectItem(i) {
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
