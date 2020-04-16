<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>

        <div class="container detail">
            <div class="detail__header">
                <div class="wrap">
                    <div class="detail__music">
                        <div class="detail__music-img">
                            <button class="btn-play amplitude-play-pause " v-if="item">
                                <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt=""/>
                            </button>
                        </div>
                        <div class="detail__music-info">
                            <h2 class="title" v-if="item">{{ item.cit_name }}</h2>
                            <p class="singer" v-if="item">{{ item.musician }}</p>
                            <div class="state" v-if="item">
                                <span class="play">{{ item.cde_download }}</span>
<!--                                <span class="song">120</span>-->
                                <span class="registed">{{ releaseDt }}</span>
                            </div>
                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a href="#" class="buy"  @click="addCart"><span>{{ item.cde_price }}&#8361;</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    <div class="wave">-->

<!--                    </div>-->

                    <div class="player player--static">
                        <div class="wrap">
                            <div class="player__top">
                                <div class="player__progress">
                                    <div id="progress-container">
                                        <input type="range" class="amplitude-song-slider" step=".1"/>
                                        <progress id="song-played-progress" class="amplitude-song-played-progress" data-amplitude-song-index="0"></progress>
                                        <progress id="song-buffered-progress" class="amplitude-buffered-progress" data-amplitude-song-index="0"></progress>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail__comment">
                        <form action="">
                            <div class="commentForm">
                                <a href="" class="comment__user"></a>
                                <input
                                        type="text"
                                        placeholder="Write a comment..."
                                        id="comment"
                                        max="200"
                                        v-model="comment"
                                        @keydown.enter.prevent="sendComment"
                                />
                                <span id="commentLength">{{ comment ? comment.length : '0' }}/200</span>
                                <button @click="sendComment">SEND</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="detail__body">
                <div class="tab">
                    <div class="tab__scroll-none">
                        <button v-for="t in tabs" :key="t.title" :class="{active: t.title === currentTab }" @click="selectTab(t)">{{ t.title }}</button>
                    </div>
                </div>
                <div class="detail__content">
                    <transition name="fade" mode="out-in">
                        <keep-alive>
                            <router-view :item="item"/>
                        </keep-alive>
                    </transition>
                </div>
            </div>
        </div>
        <main-player></main-player>
        <Footer/>
    </div>
</template>

<script>

    require('@/assets_m/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import { EventBus } from '*/src/eventbus';
    import MainPlayer from "@/vue/common/MainPlayer";

    export default {
        components: {Header,Footer,MainPlayer},
        data: function() {
            return {
                isLogin : false,
                item: null,
                comment: null,
                music: null,
                listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                tabs: [{path:'/',title:'SIMILAR TRACKS'},{path:'/comments',title:'COMMENTS'},{path:'/infomation',title:'INFORMATION'}],
                currentTab: 'SIMILAR TRACKS',
                playlist: null,
                player: null,
            }
        },
        computed: {
            releaseDt: function() {
                if(!this.item) return null;
                const t = new Date(Date.parse(this.item.cit_start_datetime));

                return `${t.getFullYear()}.${('0' + t.getMonth()).slice(-2)}.${('0' + t.getDate()).slice(-2)}`;
            }
        },
        created() {

        },
        mounted() {

            this.currentTab = _.find(this.tabs, e => {
                return e.path === this.$router.currentRoute.path;
            }).title;

            EventBus.$on('player_request_start',r=> {

                log.debug({
                    'DETAIL : player_request_start':r,
                })

                if(this._uid != r._uid) {
                    Amplitude.pause();
                    var bg = document.querySelector(".btn-play");
                    bg.classList.remove("amplitude-playing");
                    bg.classList.add("amplitude-paused");
                }

            });

            EventBus.$on('main_player_play',r=> {

                log.debug({
                    'DETAIL : main_player_play':r,
                })

                if(this._uid != r._uid) {
                    Amplitude.pause();
                    var bg = document.querySelector(".btn-play");
                    bg.classList.remove("amplitude-playing");
                    bg.classList.add("amplitude-paused");
                }

            });


            // EventBus.$on('index_items_stop_all_played',r=> {
            //     if(this._uid !== r._uid) {
            //         // log.debug({
            //         //     'index_items_stop_all_played MAIN':null,
            //         // })
            //         Amplitude.pause();
            //         var bg = document.querySelector(".btn-play");
            //         bg.classList.remove("amplitude-playing");
            //         bg.classList.add("amplitude-paused");
            //     }
            // });

            // this.music = window.WaveSurfer.create({
            //     container: document.querySelector(".wave"),
            //     waveColor: "#696969",
            //     progressColor: "#c3ac45",
            //     hideScrollbar: true,
            //     height: 90
            // });




        },
        watch: {
            item : function(n){
                if(n) {
                    log.debug({
                        'watch detail' : n,
                    })
                    //this.music.load(`/cmallact/download_sample/${n[0].cde_id}`);
                    this.$nextTick(function() {
                        this.player = Amplitude.init({
                            "songs": [{
                                "name": n.cit_name,
                                "artist": n.musician,
                                "url": `/cmallact/download_sample/${n.cde_id}`,
                            }],
                            callbacks: {
                                play: () => {
                                    //console.log("MAIN played")
                                    //EventBus.$emit('index_items_stop_all_played', {'_uid':this._uid,'item':this.item});
                                    EventBus.$emit('stop_main_player',{'_uid':this._uid,'item':this.item});
                                },
                                initialized: () => {
                                    //this.increaseMusicCount();
                                }
                            },
                            waveforms: {
                                sample_rate: 3000
                            }
                        });
                    });

                }
            },
            // item : function(n){
            //     if(n) {
            //         this.$nextTick(function() {
            //             const playbtn = document.querySelector(".btn-play");
            //             playbtn.addEventListener("click", () => {
            //                 this.music.playPause();
            //             });
            //             this.music.on("play", () => {
            //                 playbtn.classList.add("playing");
            //             });
            //             this.music.on("pause", () => {
            //                 playbtn.classList.remove("playing");
            //             });
            //         });
            //     }
            // },

        },
        methods: {
            stop() {
                Amplitude.pause();
                var bg = document.querySelector(".btn-play");
                bg.classList.remove("amplitude-playing");
                bg.classList.add("amplitude-paused");
            },
            // 탭 선택
            selectTab(t) {
                this.currentTab = t.title;
                this.$router.push({ path: t.path, params: { item: this.item} });
            },
            // 코멘트 입력
            sendComment() {

                if(!this.comment) return;

                // 코멘트 저장
                const p = {
                    cit_id : this.item.cit_id,
                    cqa_title : null,
                    cqa_content : this.comment,
                }
                // 코멘트 저장
                Http.post( `/beatsomeoneApi/add_comment`,p).then(r=> {
                    if(!r) {
                        log.debug('Comment 저장 실패');
                    } else {
                        EventBus.$emit('add_comment');
                        log.debug('Comment 저장 성공');

                    }
                });
                // 초기화
                this.comment = null;

                // 탭 이동
                this.selectTab(this.tabs[1]);
            },
            // 카트 추가
            addCart() {

                let detail_qty = {};
                detail_qty[this.item.cde_id] = 1;
                Http.post( `/beatsomeoneApi/itemAction`,{stype: 'cart',cit_id:this.item.cit_id,chk_detail:[this.item.cde_id],detail_qty:detail_qty,}).then(r=> {
                    if(!r) {
                        log.debug('장바구니 담기 실패');
                    } else {
                        EventBus.$emit('add_cart');
                        log.debug('장바구니 담기 성공');

                    }
                });
            },
            // 다운로드 증가
            increaseMusicCount() {
                Http.post( `/beatsomeoneApi/increase_music_count`,{cde_id:this.item.cde_id}).then(r=> {
                    if(!r) {
                        log.debug('카운트 증가 실패');
                    } else {
                        log.debug('카운트 증가 성공');
                    }
                });
            }
        },

    }


</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>
