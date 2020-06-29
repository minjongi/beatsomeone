<template>

    <div class="wrapper">
        <Header :is-login="isLogin"/>

        <div class="container detail">
            <div class="detail__header">

<!--                <div>-->
<!--                    <pre>{{ item }}</pre>-->
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
                                    <span class="share pointer" @click="clickShare('twitter')">Twitter</span>
                                    <span class="share pointer" @click="clickShare('facebook')">Facebook</span>
                                    <span class="share pointer" @click="copyLinkToClipboard">CopyLink</span>

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
                                        :placeholder="$t('writeComment')"
                                        id="comment"
                                        max="200"
                                        v-model="comment"
                                        @keydown.enter.prevent="sendComment"
                                />
                                <span id="commentLength">{{ comment ? comment.length : '0' }}/200</span>
                                <button @click.prevent="sendComment">{{ $t('send') }}</button>
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
        <main-player></main-player>
        <PurchaseTypeSelector :purchaseTypeSelectorPopup.sync="purchaseTypeSelectorPopup" :item="item"></PurchaseTypeSelector>
        <Footer/>
    </div>
</template>

<script>

    require('@/assets/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";

    import { EventBus } from '*/src/eventbus';
    import MainPlayer from "@/vue/common/MainPlayer";
    import PurchaseTypeSelector from "./component/PurchaseTypeSelector";

    export default {
        components: {Header, Footer, MainPlayer, PurchaseTypeSelector},
        data: function() {
            return {
                isLogin: false,
                item: null,
                comment: null,
                music: null,
                currentTab: 'SIMILAR TRACKS',
                purchaseTypeSelectorPopup: false
            }
        },
        computed: {
            releaseDt: function() {
                if(!this.item) return null;
                const t = new Date(Date.parse(this.item.cit_start_datetime));

                return `${t.getFullYear()}.${('0' + (t.getMonth() + 1)).slice(-2)}.${('0' + t.getDate()).slice(-2)}`;
            },
            hashtag() {
                return this.item.hashTag ? this.item.hashTag.split(',') : '';
            },
            tabs() {
                return [
                    {path: '/', title: this.$t('similarTrack')},
                    {path: '/comments', title: this.$t('comments')},
                    {path: '/infomation', title: this.$t('information')}
                ]
            }
        },

        mounted() {
            EventBus.$on('player_request_start',r=> {

                log.debug({
                    'DETAIL : player_request_start':r,
                })

                if(this._uid != r._uid) {
                    this.music.pause();
                }

            });

            EventBus.$on('main_player_play',r=> {
                log.debug({
                    'DETAIL : main_player_play':r,
                })
                if(this._uid != r._uid) {
                    this.music.pause();
                }
            });

            EventBus.$on('player_request_start',r=> {
                if(this._uid != r._uid) {
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
                //EventBus.$emit('index_items_stop_all_played',{'_uid':this._uid,'item':this.item});
                EventBus.$emit('stop_main_player',{'_uid':this._uid,'item':this.item});
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
                this.purchaseTypeSelectorPopup = true
            },
            // 공유 클릭
            clickShare(sns) {
                Http.post( `/beatsomeoneApi/increase_item_share_count`,{cit_id:this.item.cit_id}).then(r=> {
                    if(!r) {
                        log.debug('공유 카운트 증가 실패');
                    } else {
                        log.debug('공유 카운트 증가 성공');
                    }
                });

                var url = `http://mvp.beatsomeone.com/beatsomeone/detail/${this.item.cit_key}`;
                var txt = `${this.item.cit_name} / ${this.item.musician} / ${this.item.genre}`;

                var o;
                var _url = encodeURIComponent(url);
                var _txt = encodeURIComponent(txt);
                var _br = encodeURIComponent('\r\n');

                switch(sns) {
                    case 'facebook':
                        o = {
                            method:'popup',
                            url:'http://www.facebook.com/sharer/sharer.php?u=' + _url
                        };
                        break;

                    case 'twitter':
                        o = {
                            method:'popup',
                            url:'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
                        };
                        break;

                    case 'kakaostory':
                        o = {
                            method:'popup',
                            url:'https://story.kakao.com/share?url=' + _url
                        };
                        break;

                    case 'band':
                        o = {
                            method:'popup',
                            url:'http://www.band.us/plugin/share?body=' + _txt + _br + _url
                        };
                        break;

                    default:
                        alert('지원하지 않는 SNS입니다.');
                        return false;
                }

                switch(o.method) {
                    case 'popup':
                        window.open(o.url,'snspopup','width=500, height=400, menubar=no, status=no, toolbar=no');
                        break;

                    case 'web2app':
                        if (navigator.userAgent.match(/android/i))
                        {
                            // Android
                            setTimeout(function(){ location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'}, 100);
                        }
                        else if (navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i))
                        {
                            // Apple
                            setTimeout(function(){ location.href = o.a_store; }, 200);
                            setTimeout(function(){ location.href = o.a_proto + o.param }, 100);
                        }
                        else
                        {
                            alert('이 기능은 모바일에서만 사용할 수 있습니다.');
                        }
                        break;
                }
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
            },
            // 링크 복사
            copyLinkToClipboard() {
                var t = document.createElement("textarea");
                document.body.appendChild(t);
                t.value = `http://mvp.beatsomeone.com/beatsomeone/detail/${this.item.cit_key}`;
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
                alert(`복사되었습니다\nCtrl + V 를 눌러 확인해보세요`);
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
