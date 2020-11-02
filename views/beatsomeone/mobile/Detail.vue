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
                            <h2 class="title" style="font-weight: 600;" v-if="item">{{ truncate(item.cit_name, 15) }}</h2>
<!--                            <p class="singer" v-if="item">{{ item.mem_nickname }}</p>-->
                            <div class="state" v-if="item">
                                <span class="state-singer" v-if="item">{{ item.mem_nickname }}</span>
<!--                                <span class="song">0{{ item.cde_download }}</span>-->
                                <!--                                <span class="song">120</span>-->
                                <span class="registed">{{ releaseDt }}</span>
                            </div>
                            <div style="font-size: 12px; margin-top: 10px">
                                <span class="fa fa-share-alt"></span>
                                <span class="share pointer" @click="clickShare('twitter')">{{ $t('lang107') }}</span> /
                                <span class="pointer" @click="clickShare('facebook')">{{ $t('lang108') }}</span> /
                                <span class="pointer" @click="copyLinkToClipboard">{{ $t('lang109') }}</span>
                            </div>
                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a href="#" class="buy"
                                       @click="addCart">
                                        <span v-if="item.cit_lease_license_use === '1' && item.cit_mastering_license_use === '0'">
                                            {{ formatPrice(item.detail.LEASE.cde_price, item.detail.LEASE.cde_price_d, true) }}
                                        </span>
                                        <span v-if="item.cit_lease_license_use === '0' && item.cit_mastering_license_use === '1'">
                                            {{ formatPrice(item.detail.STEM.cde_price, item.detail.STEM.cde_price_d, true) }}
                                        </span>
                                        <span v-if="item.cit_lease_license_use === '1' && item.cit_mastering_license_use === '1'">
                                            {{ formatPrice(item.detail.STEM.cde_price, item.detail.STEM.cde_price_d, true) }}
                                        </span>
                                    </a>

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
                                        <progress id="song-played-progress" class="amplitude-song-played-progress"
                                                  data-amplitude-song-index="0"></progress>
                                        <progress id="song-buffered-progress" class="amplitude-buffered-progress"
                                                  data-amplitude-song-index="0"></progress>
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
                                        maxlength="200"
                                        v-model="comment"
                                        @click="checkLoggedIn"
                                        @keydown.enter.prevent="sendComment"
                                />
                                <span id="commentLength">{{ comment ? comment.length : '0' }}/200</span>
                                <button @click="sendComment">{{ $t('send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="detail__body">
                <div class="tab">
                    <div class="tab__scroll-none">
                        <button v-for="t in tabs" :key="t.title" :class="{active: t.id === currentTab }"
                                @click="selectTab(t)">{{ t.title }}
                        </button>
                    </div>
                </div>
                <div class="detail__content">
                    <!--                    <transition name="fade" mode="out-in">-->
                    <keep-alive>
                        <router-view :item="item"/>
                    </keep-alive>
                    <!--                    </transition>-->
                </div>
            </div>
        </div>
        <main-player></main-player>
        <Footer/>
        <PurchaseTypeSelector :purchaseTypeSelectorPopup.sync="purchaseTypeSelectorPopup"
                              :item="item"></PurchaseTypeSelector>
    </div>
</template>

<script>

    import axios from "axios";

    require('@/assets_m/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import {EventBus} from '*/src/eventbus';
    import MainPlayer from "@/vue/common/MobileMainPlayer";
    import PurchaseTypeSelector from "./component/PurchaseTypeSelector";

    export default {
        components: {Header, Footer, MainPlayer, PurchaseTypeSelector},
        data: function () {
            return {
                item: {},
                comment: null,
                music: null,
                currentTab: 1,
                playlist: null,
                player: null,
                isIncreaseMusicCount: false,
                purchaseTypeSelectorPopup: false,
                member: false,
            }
        },
        computed: {
            releaseDt: function () {
                if (!this.item) return null;
                const t = new Date(Date.parse(this.item.cit_start_datetime));

                return `${t.getFullYear()}.${('0' + t.getMonth()).slice(-2)}.${('0' + t.getDate()).slice(-2)}`;
            },
            tabs() {
                return [
                    {path: "/", id: 1, title: this.$t("similarTrack")},
                    {path: "/comments", id: 2, title: this.$t("comments")},
                    {path: "/infomation", id: 3, title: this.$t("information")}
                ]
            },
            isLogin () {
                return this.member !== false;
            }
        },
        created() {
            let params = window.location.pathname.split('/');
            let cit_key = params[1] === 'beatsomeone' ? params[3] : params[2];
            console.log(params);
            axios.get(`/item/ajax/${cit_key}`)
                .then(res => res.data)
                .then(data => {
                    console.log(data);
                    this.item = data;
                })
                .catch(error => {
                    console.error(error);
                })
            console.log(cit_key);
        },
        mounted() {
            this.member = window.member;
            this.currentTab = _.find(this.tabs, e => {
                return e.path === this.$router.currentRoute.path;
            }).id;

            EventBus.$on('player_request_start', r => {

                log.debug({
                    'DETAIL : player_request_start': r,
                })

                if (this._uid != r._uid) {
                    Amplitude.pause();
                    var bg = document.querySelector(".btn-play");
                    bg.classList.remove("amplitude-playing");
                    bg.classList.add("amplitude-paused");
                }

            });

            EventBus.$on('main_player_play', r => {

                log.debug({
                    'DETAIL : main_player_play': r,
                })

                if (this._uid != r._uid) {
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
            item: function (n) {
                if (n) {
                    log.debug({
                        'watch detail': n,
                    })
                    //this.music.load(`/cmallact/download_sample/${n[0].cde_id}`);
                    this.$nextTick(function () {
                        this.player = Amplitude.init({
                            "songs": [{
                                "name": n.cit_name,
                                "artist": n.musician,
                                "url": `/cmallact/download_sample/${n.detail.PREVIEW.cde_id}`,
                            }],
                            callbacks: {
                                play: () => {
                                    if (this.isIncreaseMusicCount === false) {
                                        this.increaseMusicCount()
                                        this.isIncreaseMusicCount = true
                                    }
                                    // console.log("MAIN played")
                                    //EventBus.$emit('index_items_stop_all_played', {'_uid':this._uid,'item':this.item});
                                    EventBus.$emit('stop_main_player', {'_uid': this._uid, 'item': this.item});
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
                this.currentTab = t.id;
                this.$router.push({path: t.path, params: {item: this.item}});
            },
            // 코멘트 입력
            sendComment() {

                if (!this.comment) return;

                if (!this.isLogin) {
                    let yn = confirm(this.$t('loginAlert'));
                    if (yn === true) {
                        window.location.href = '/login?url=' + window.location.href;
                    } else {
                        return;
                    }
                }

                // 코멘트 저장
                const p = {
                    cit_id: this.item.cit_id,
                    cqa_title: null,
                    cqa_content: this.comment,
                }
                // 코멘트 저장
                Http.post(`/beatsomeoneApi/add_comment`, p).then(r => {
                    if (!r) {
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
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
            // 카트 추가
            addCart() {
                this.purchaseTypeSelectorPopup = true;
            },
            // 다운로드 증가
            increaseMusicCount() {
                Http.post(`/beatsomeoneApi/increase_music_count`, {cde_id: this.item.cde_id}).then(r => {
                    if (!r) {
                        log.debug('카운트 증가 실패');
                    } else {
                        log.debug('카운트 증가 성공');
                    }
                });
            },
            // 공유 클릭
            clickShare(sns) {
                Http.post(`/beatsomeoneApi/increase_item_share_count`, {cit_id: this.item.cit_id}).then(r => {
                    if (!r) {
                        log.debug('공유 카운트 증가 실패');
                    } else {
                        log.debug('공유 카운트 증가 성공');
                    }
                });

                var url = `https://beatsomeone.com/detail/${this.item.cit_key}`;
                var txt = `${this.item.cit_name} / ${this.item.member.mem_nickname} / ${this.item.genre}`;

                var o;
                var _url = encodeURIComponent(url);
                var _txt = encodeURIComponent(txt);
                var _br = encodeURIComponent('\r\n');

                switch (sns) {
                    case 'facebook':
                        o = {
                            method: 'web2app',
                            url: 'http://www.facebook.com/sharer/sharer.php?u=' + _url
                        };
                        break;

                    case 'twitter':
                        o = {
                            method: 'web2app',
                            url: 'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
                        };
                        break;

                    case 'kakaostory':
                        o = {
                            method: 'web2app',
                            url: 'https://story.kakao.com/share?url=' + _url
                        };
                        break;

                    case 'band':
                        o = {
                            method: 'web2app',
                            url: 'http://www.band.us/plugin/share?body=' + _txt + _br + _url
                        };
                        break;

                    default:
                        alert('지원하지 않는 SNS입니다.');
                        return false;
                }

                switch (o.method) {
                    case 'popup':
                        window.open(o.url, 'snspopup', 'width=500, height=400, menubar=no, status=no, toolbar=no');
                        break;

                    case 'web2app':
                        if (navigator.userAgent.match(/android/i)) {
                            // Android
                            setTimeout(function () {
                                location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'
                            }, 100);
                        } else if (navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i)) {
                            // Apple
                            setTimeout(function () {
                                location.href = o.a_store;
                            }, 200);
                            setTimeout(function () {
                                location.href = o.a_proto + o.param
                            }, 100);
                        } else {
                            alert('이 기능은 모바일에서만 사용할 수 있습니다.');
                        }
                        break;
                }
            },
            // 링크 복사
            copyLinkToClipboard() {
                var t = document.createElement("textarea");
                document.body.appendChild(t);
                t.value = `https://beatsomeone.com/detail/${this.item.cit_key}`;
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
                alert(`복사되었습니다\nCtrl + V 를 눌러 확인해보세요`);
            },
            formatPrice: function (kr, en, simbol) {
                if (!simbol) {
                    if (this.$i18n.locale === "en") {
                        return en;
                    } else {
                        return kr;
                    }
                }
                if (this.$i18n.locale === "en") {
                    return (
                        "$ " +
                        Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
                    );
                } else {
                    return (
                        "₩ " +
                        Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
                    );
                }
            },
            checkLoggedIn() {
                if (!this.isLogin) {
                    let yn = confirm(this.$t('loginAlert'));
                    if (yn === true) {
                        window.location.href = '/login?url=' + window.location.href;
                    } else {
                        return true;
                    }
                }
            }
        },

    }


</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }

    .share {
        margin-left: 10px;
    }
</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .player__progress wave {
        background: none !important;
    }

    .container.detail {
        margin-top: 75px;
    }
</style>
