<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>

        <div class="container detail">
            <div class="detail__header">
                <div class="wrap">
                    <div class="detail__music">
                        <div class="detail__music-img">
                            <button class="btn-play " v-if="item">
                                <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt=""/>
                            </button>
                        </div>
                        <div class="detail__music-info">
                            <h2 class="title" v-if="item">{{ item.cit_name }}</h2>
                            <p class="singer" v-if="meta">{{ meta.info_content_3 }}</p>
                            <div class="state" v-if="item">
                                <span class="play">{{ item.cit_hit }}</span>
                                <span class="song">120</span>
                                <span class="registed">{{ releaseDt }}</span>
                            </div>
                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a href="#" class="buy" v-if="detail" @click="addCart"><span>{{ detail[0].cde_price }}&#8361;</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wave">

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
                    <router-view :item="item"/>
                </div>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>

    require('@/assets_m/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import { EventBus } from '*/src/eventbus';


    export default {
        components: {Header,Footer,},
        data: function() {
            return {
                isLogin : false,
                item: null,
                meta : null,
                detail : null,
                comment: null,
                music: null,
                listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                tabs: [{path:'/',title:'SIMILAR TRACKS'},{path:'/comments',title:'COMMENTS'},{path:'/infomation',title:'INFORMATION'}],
                currentTab: 'SIMILAR TRACKS',
            }
        },
        computed: {
            releaseDt: function() {
                if(!this.item) return null;
                const t = new Date(Date.parse(this.item.cit_datetime));

                return `${t.getMonth()} / ${t.getFullYear()}`;
            }
        },
        mounted() {

            this.currentTab = _.find(this.tabs, e => {
                return e.path === this.$router.currentRoute.path;
            }).title;


            this.music = window.WaveSurfer.create({
                container: document.querySelector(".wave"),
                waveColor: "#696969",
                progressColor: "#c3ac45",
                hideScrollbar: true,
                height: 90
            });




        },
        watch: {
            detail : function(n){
                if(n) {
                    this.music.load(`/cmallact/download_sample/${n[0].cde_id}`);
                }
            },
            item : function(n){
                if(n) {
                    this.$nextTick(function() {
                        const playbtn = document.querySelector(".btn-play");
                        playbtn.addEventListener("click", () => {
                            this.music.playPause();
                        });
                        this.music.on("play", () => {
                            playbtn.classList.add("playing");
                        });
                        this.music.on("pause", () => {
                            playbtn.classList.remove("playing");
                        });
                    });
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
                detail_qty[this.detail[0]['cde_id']] = 1;
                Http.post( `/beatsomeoneApi/itemAction`,{stype: 'cart',cit_id:this.item.cit_id,chk_detail:[this.detail[0].cde_id],detail_qty:detail_qty,}).then(r=> {
                    if(!r) {
                        log.debug('장바구니 담기 실패');
                    } else {
                        EventBus.$emit('add_cart');
                        log.debug('장바구니 담기 성공');

                    }
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
