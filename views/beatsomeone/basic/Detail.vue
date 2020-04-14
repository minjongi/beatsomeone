<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>

        <div class="container detail">
            <div class="detail__header">

<!--                <div>-->
<!--                    <pre>{{ detail }}</pre>-->
<!--                </div>-->
                <div class="wrap">
                    <div class="detail__music">
                        <div class="detail__music-img" v-if="item">
                            <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt=""/>
                        </div>
                        <div class="detail__music-info" >
                            <h2 class="title" v-if="item">{{ item.cit_name }}</h2>
                            <p class="singer" v-if="item">{{ item.musician }}</p>
                            <div class="state" v-if="item">
                                <span class="play">{{ item.cde_download }}</span>
<!--                                <span class="song">120</span>-->
                                <span class="registed">{{ releaseDt }}</span>
                                <span class="etc">{{ item.cit_summary }}</span>
                            </div>
                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a href="#" class="buy" v-if="item" @click="addCart"><span>{{ item.cde_price }}&#8361;</span></a>
                                    <span class="cart pointer"  @click="addCart">{{ item.sell_cnt }}</span>
                                    <span class="talk pointer" @click="selectTab(tabs[1])">{{ item.comment_cnt }}</span>
                                    <span class="share pointer" @click="clickShare">{{ item.cit_share_count }}</span>
<!--                                    <span class="atob">91</span>-->
                                </div>

                                <div class="category" v-if="item">
                                     <span class="pointer" v-for="(t,i) in hashtag" :key="i" @click="clickHash(t)">
                                        {{ t }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail__player">
                        <button class="detail__player-controller"></button>
                        <div id="detail__player-wave">
                            <!-- wave 들어가는 부분-->
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
                                <button @click.prevent="sendComment">SEND</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="detail__body">
                <div class="wrap">
                    <div class="tab">
                        <button v-for="t in tabs" :key="t.title" :class="{active: t.title === currentTab }" @click="selectTab(t)">{{ t.title }}</button>
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
        </div>
        <Footer/>
    </div>
</template>

<script>

    require('@/assets/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";

    import { EventBus } from '*/src/eventbus';
    export default {

        components: {Header,Footer},
        data: function() {
            return {

                isLogin : false,
                item: null,

                comment: null,
                music: null,
                //listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                tabs: [{path:'/',title:'SIMILAR TRACKS'},{path:'/comments',title:'COMMENTS'},{path:'/infomation',title:'INFORMATION'}],
                currentTab: 'SIMILAR TRACKS',
            }
        },
        computed: {
            releaseDt: function() {
                if(!this.item) return null;
                const t = new Date(Date.parse(this.item.cit_start_datetime));

                return `${t.getFullYear()}.${('0' + t.getMonth()).slice(-2)}.${('0' + t.getDate()).slice(-2)}`;
            },
            hashtag() {
                return this.item.hashTag ? this.item.hashTag.split(',') : '';
            },
        },

        mounted() {

            EventBus.$on('index_items_stop_all_played',r=> {
                if(this._uid !== r) {
                    log.debug({
                        'index_items_stop_all_played MAIN':null,
                    })
                    // Amplitude.pause();
                    // var bg = document.querySelector(".btn-play");
                    // bg.classList.remove("amplitude-playing");
                    // bg.classList.add("amplitude-paused");
                    this.music.pause();
                }
            });

            this.currentTab = _.find(this.tabs, e => {
                return e.path === this.$router.currentRoute.path;
            }).title;

            const playbtn = document.querySelector(".detail__player-controller");

            this.music = window.WaveSurfer.create({
                container: document.querySelector("#detail__player-wave"),
                waveColor: "#696969",
                progressColor: "#c3ac45",
                hideScrollbar: true,
                barWidth: 5,
                barRadius: 2,
                barGap: 2,
                height: 200
            });

            this.music.on("ready", () => {
                this.increaseMusicCount();
            });
            this.music.on("play", () => {
                playbtn.classList.add("playing");
                EventBus.$emit('index_items_stop_all_played',this._uid);
            });
            this.music.on("pause", () => {
                playbtn.classList.remove("playing");
            });
            playbtn.addEventListener("click", () => {
                this.music.playPause();
            });

        },
        watch: {
            item : function(n){
                if(n) {
                    this.music.load(`/cmallact/download_sample/${n.cde_id}`);
                }

            },
        },
        methods: {

            // 탭 선택
            selectTab(t) {
                this.currentTab = t.title;
                this.$router.push({ path: t.path, params: { item: this.item} });
            },
            // 코멘트 입력
            sendComment() {

                if(!this.comment) return;

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
                        this.item.comment_cnt = Number(this.item.comment_cnt) + 1;
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
            // 공유 클릭
            clickShare() {
                Http.post( `/beatsomeoneApi/increase_item_share_count`,{cit_id:this.item.cit_id}).then(r=> {
                    if(!r) {
                        log.debug('공유 카운트 증가 실패');
                    } else {
                        log.debug('공유 카운트 증가 성공');
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
            },
            // 해쉬 클릭
            clickHash(h) {
                const path = `/beatsomeone/sublist?search=${h}`;
                window.location.href = path;
            }
        },

    }


</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
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
