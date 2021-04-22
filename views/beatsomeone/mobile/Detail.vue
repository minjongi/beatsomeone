<template>
    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container detail">
            <div class="detail__header">
                <div class="wrap">
                    <div class="detail__music">
                        <div class="detail__music-img">
                            <button class="btn-play amplitude-play-pause " v-if="item">
                                <img :src="'/uploads/cmallitem/' + (!!item.cit_file_1 ? item.cit_file_1 : 'cover_default.png')" :alt="item.cit_name"/>
                            </button>
                        </div>

                        <div class="detail__music-info">
                            <h2 class="title" style="font-weight: 600;" v-if="item.cit_name">{{ truncate(item.cit_name, 15) }}</h2>
<!--                            <p class="singer" v-if="item">{{ item.mem_nickname }}</p>-->
                            <div class="state" v-if="item">
                                <div class="state-singer" v-if="item">{{ item.mem_nickname }}</div> <div style="display: flex; align-items: center;"><img class="shop" style="padding-left: 20px;" src="/assets/images/icon/shop.png"/><a :href="helper.langUrl($i18n.locale, '/' + item.mem_nickname)">{{ $t('goToBrandshop') }}</a></div>
<!--                                <span class="song">0{{ item.cde_download }}</span>-->
                                <!--                                <span class="song">120</span>-->
                                <div style="margin-top: 10px" class="registed">{{ item.release_datetime }}</div>
                            </div>
                            <div style="font-size: 12px; margin-top: 10px">
                                <span class="fa fa-share-alt"></span>
                                <span class="share pointer" @click="clickShare('twitter')">{{ $t('lang107') }}</span> /
                                <span class="pointer" @click="clickShare('facebook')">{{ $t('lang108') }}</span> /
                                <span class="pointer" @click="copyLinkToClipboard">{{ $t('lang109') }}</span>
                            </div>
                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a class="buy waves-effect free" @click="addCart" href="javascript:;" 
                                        v-if="is_subscriber && item.cit_type5 === '1' && remainDownloadNumber() > 0">
                                        <span v-if="item.cit_freebeat == 1 && item.detail.LEASE.cde_price == 0">{{$t('free')}} (구독 잔여 {{remain_download_num}})</span>
                                        <span v-else>
                                            {{ formatPrice(0, 0, true) }} (구독 잔여 {{remainDownloadNumber()}})
                                        </span>
                                    </a>
                                    <a class="buy waves-effect" @click="addCart" href="javascript:;" v-else>
                                        <span v-if="item.cit_freebeat == 1 && item.detail.LEASE.cde_price == 0">{{$t('free')}}</span>
                                        <span v-else-if="item.cit_lease_license_use === '1'">
                                            {{ formatPrice(item.detail.LEASE.cde_price, item.detail.LEASE.cde_price_d, true) }}
                                        </span>
                                        <span v-else-if="item.cit_lease_license_use === '0' && item.cit_mastering_license_use === '1'">
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
                                        <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
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
                cit_key: null,
                item: {},
                comment: '',
                music: null,
                currentTab: 1,
                playlist: null,
                player: null,
                isIncreaseMusicCount: false,
                purchaseTypeSelectorPopup: false,
                member: false,
                is_subscriber: false
            }
        },
        computed: {
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
          let params = window.location.pathname.split('/')
          for (let key in params) {
            if (params[key] === 'detail') {
              this.cit_key = params[parseInt(key) + 1]
            }
          }
          axios.get(`/item/ajax/${this.cit_key}`)
              .then(res => res.data)
              .then(data => {
                this.item = data;
                if (this.item.detail.PREVIEW) {
                  Amplitude.init({
                    "songs": [{
                      "name": this.item.cit_name,
                      "artist": this.item.musician,
                      "url": `/cmallact/listen_preview/${this.item.detail.PREVIEW.cde_id}`,
                    }],
                    debug: true,
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
                }
              })
              .catch(error => {
                console.error(error);
              })
        },
        mounted() {
            this.remainDownloadNumber();
            this.member = window.member;
            this.member_group_name = window.member_group_name;
            this.currentTab = _.find(this.tabs, e => {
                return e.path === this.$router.currentRoute.path;
            }).id;
            if (window.member_group_name.indexOf('subscribe') != -1) this.is_subscriber = true;

            // let params = window.location.pathname.split('/');
            // let cit_key = params[1] === 'beatsomeone' ? params[3] : params[2];
            // axios.get(`/item/ajax/${cit_key}`)
            //     .then(res => res.data)
            //     .then(data => {
            //         this.item = data;
            //         if (this.item.detail.PREVIEW) {
            //             Amplitude.init({
            //                 "songs": [{
            //                     "name": this.item.cit_name,
            //                     "artist": this.item.musician,
            //                     "url": `/cmallact/listen_preview/${this.item.detail.PREVIEW.cde_id}`,
            //                 }],
            //                 debug: true,
            //                 callbacks: {
            //                     play: () => {
            //                         if (this.isIncreaseMusicCount === false) {
            //                             this.increaseMusicCount()
            //                             this.isIncreaseMusicCount = true
            //                         }
            //                         // console.log("MAIN played")
            //                         //EventBus.$emit('index_items_stop_all_played', {'_uid':this._uid,'item':this.item});
            //                         EventBus.$emit('stop_main_player', {'_uid': this._uid, 'item': this.item});
            //                     },
            //                     initialized: () => {
            //                         //this.increaseMusicCount();
            //                     }
            //                 },
            //                 waveforms: {
            //                     sample_rate: 3000
            //                 }
            //             });
            //         }
            //     })
            //     .catch(error => {
            //         console.error(error);
            //     })

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
        methods: {
            remainDownloadNumber() {
                this.remain_download_num = localStorage.getItem("remain_download_num");
                // axios.get('/membermodify/mem_remain_downloads_get')
                //     .then(res=>{

                //         this.remain_download_num = res.data;
                //     })
                //     .catch(error => {
                //         console.error(error);
                //     })
                return this.remain_download_num
            },
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
                if (!this.checkLoggedIn()) {
                  return
                }

                if (!this.comment.trim()) {
                  alert(this.$t('writeComment'))
                  return
                }

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

            freeBuy(item_detail) {
                let detail_qty = {};
                detail_qty[item_detail.cde_id] = 1;
                Http.post(`/beatsomeoneApi/itemAction`, {
                    stype: "free",
                    cit_id: this.item.cit_id,
                    chk_detail: [item_detail.cde_id],
                    detail_qty: detail_qty,
                }).then((r) => {
                    if (!r) {
                    log.debug("장바구니 담기 실패");
                    } else {
                    log.debug("장바구니 담기 성공");
                    alert(this.$t("inMyShoppingCart"));
                    this.close();
                    }
                });
            },      
            // 다운로드 증가
            increaseMusicCount() {
                Http.post(`/beatsomeoneApi/increase_music_count`, {cde_id: this.item.cde_id}).then(r => {
                    if (!r) {
                        log.debug('카운트 증가 실패');
                    } else {
                        log.debug('카운트 증가 성공');
                        axios.get('/event/chkAchieve')
                          .then(res => {
                            if (res.data === 'achieve') {
                              alert(this.$t('lang154'))
                            }
                          })
                          .catch(error => {
                            console.error(error);
                          })
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

                var url = 'https://beatsomeone.com' + this.helper.langUrl(this.$i18n.locale, `/detail/${this.item.cit_key}`);
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
                t.value = 'https://beatsomeone.com' + this.helper.langUrl(this.$i18n.locale, `/detail/${this.item.cit_key}`);
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
              if (this.isLogin) {
                return true
              }

              let yn = confirm(this.$t('loginAlert'));
              if (yn === true) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/login?url=' + window.location.href);
              }
              return false
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
