<template>
    <div class="wrapper">
        <Header/>
        <div class="container detail">
            <div class="detail__header">
                <div class="wrap">
                    <div class="detail__music">
                        <div class="detail__music-img" v-if="item">
                            <img :src="'/uploads/cmallitem/' + (!!item.cit_file_1 ? item.cit_file_1 : 'cover_default.png')" :alt="item.cit_name"/>
                        </div>
                        <div class="detail__music-info">
                            <h2 class="title" v-if="item">{{ truncate(item.cit_name, 50) }}</h2>
                            <p class="singer" v-if="item">by {{ item.mem_nickname }}</p>
                            <div class="state" v-if="item">
<!--                                <span class="song">{{ item.cde_download }}</span>-->
                                <!--                                <span class="play">120</span>-->
                                <span class="registed">{{ item.cit_start_datetime }}</span>
                                <!-- <div class="etc" v-if="!!item.info_content" v-html="item.info_content"></div> -->
                            </div>

                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a class="buy waves-effect free" @click="addCart" href="javascript:;" 
                                        v-if="is_subscriber && item.cit_type5 === '1' && remain_download_num > 0">
                                        <span>
                                            {{ formatPrice(0, 0, true) }} (구독 잔여 {{remain_download_num}})
                                        </span>
                                    </a>
                                    <a class="buy waves-effect" @click="addCart" href="javascript:;" v-else>
                                        <span v-if="item.cit_lease_license_use === '1'">
                                            {{ formatPrice(item.detail.LEASE.cde_price, item.detail.LEASE.cde_price_d, true) }}
                                        </span>
                                        <span v-if="item.cit_lease_license_use === '0' && item.cit_mastering_license_use === '1'">
                                            {{ formatPrice(item.detail.STEM.cde_price, item.detail.STEM.cde_price_d, true) }}
                                        </span>
                                    </a>
                                    <!-- <span class="cart pointer" @click="addCart">{{ item.sell_cnt }}</span> -->
                                    <span class="talk pointer" @click="selectTab(tabs[1])">{{ item.cit_review_count }}</span>
                                    <div class="share">
                                        <!-- <span>{{ item.cit_share_count }}</span> / -->
                                        <span class="share pointer" @click="clickShare('twitter')">{{ $t('lang107') }}</span> /
                                        <span class="share pointer" @click="clickShare('facebook')">{{ $t('lang108') }}</span> /
                                        <span class="share pointer" @click="copyLinkToClipboard">{{ $t('lang109') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="utils" v-if="item" style="margin-top: 10px;">
                                <div class="tags">
                                    <button style="color:#3873d3;" v-if="item.cit_freebeat === '1'">{{ $t('lang1') }}
                                    </button>
                                    <button style="color:#ffda2a;" v-if="item.cit_org_content === '1'">{{ $t('lang2') }}
                                    </button>
                                    <button style="color:#fff;" v-if="item.cit_officially_registered === '1'">{{ $t('lang3') }}
                                    </button>
                                </div>
                                <div class="category" v-if="item" style="width: 100%;">
                                    <span
                                            class="pointer"
                                            v-for="(t,i) in hashtag"
                                            :key="i"
                                            @click="clickHash(t)"
                                    >{{ t }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail__player">
                        <button class="detail__player-controller"></button>
                        <div id="detail__player-wave">
                        </div>
                    </div>
                    <div class="detail__comment">
                        <div class="commentForm">
                            <a href class="comment__user"></a>
                            <input
                                    type="text"
                                    :placeholder="$t('writeComment')"
                                    id="comment"
                                    maxlength="200"
                                    v-model="comment"
                                    @click="checkLoggedIn"
                                    @keydown.enter.prevent="sendComment"
                            />
                            <span id="commentLength">{{ comment ? comment.length : '0' }}/200</span>
                            <button @click.prevent="sendComment">{{ $t('send') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail__body">
                <div class="wrap">
                    <div class="tab">
                        <button
                                v-for="t in tabs"
                                :key="t.title"
                                :class="{active: t.id === currentTab }"
                                @click="selectTab(t)"
                        >{{ t.title }}
                        </button>
                    </div>
                    <div class="detail__content">
                        <keep-alive>
                            <router-view :item="item"/>
                        </keep-alive>
                    </div>
                </div>
            </div>
        </div>
        <main-player></main-player>
        <PurchaseTypeSelector :purchaseTypeSelectorPopup.sync="purchaseTypeSelectorPopup"
                              :item="item"></PurchaseTypeSelector>
        <Footer/>
    </div>
</template>

<script>
    require("@/assets/js/function");
    import Header from "./include/Header";
    import Footer from "./include/Footer";

    import {EventBus} from "*/src/eventbus";
    import MainPlayer from "@/vue/common/MainPlayer";
    import PurchaseTypeSelector from "./component/PurchaseTypeSelector";
    import axios from 'axios';
    import WaveSurfer from 'wavesurfer.js'

    export default {
        components: {Header, Footer, MainPlayer, PurchaseTypeSelector},
        data: function () {
            return {
                cit_key: null,
                item: null,
                comment: '',
                music: null,
                currentTab: 1,
                purchaseTypeSelectorPopup: false,
                isIncreaseMusicCount: false,
                is_subscriber: false,
                member_group_name: '',
                remain_download_num: 0
            };
        },
        computed: {
            hashtag() {
                return this.item.hashTag ? this.item.hashTag.split(",") : "";
            },
            tabs() {
                return [
                    {path: "/", id: 1, title: this.$t("similarTrack")},
                    {path: "/comments", id: 2, title: this.$t("comments")},
                    {path: "/infomation", id: 3, title: this.$t("information")},
                ];
            },
            isLogin () {
                return !!this.member;
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
                    console.log('this is important', this.item);
                })
                .catch(error => {
                    console.error(error);
                })
        },
        mounted() {
            this.remainDownloadNumber();
            this.member = window.member;
            this.member_group_name = window.member_group_name;
            if (this.member_group_name.indexOf('subscribe') != -1) this.is_subscriber = true;

            EventBus.$on("player_request_start", (r) => {
                log.debug({
                    "DETAIL : player_request_start": r,
                });

                if (this._uid != r._uid) {
                    this.music.pause();
                }
            });

            EventBus.$on("main_player_play", (r) => {
                log.debug({
                    "DETAIL : main_player_play": r,
                });
                if (this._uid != r._uid) {
                    this.music.pause();
                }
            });

            EventBus.$on("player_request_start", (r) => {
                if (this._uid != r._uid) {
                    this.music.pause();
                }
            });

            this.currentTab = _.find(this.tabs, (e) => {
                return e.path === this.$router.currentRoute.path;
            }).id;

            const playbtn = document.querySelector(".detail__player-controller");

            this.music = WaveSurfer.create({
                container: document.querySelector("#detail__player-wave"),
                waveColor: "#696969",
                progressColor: "#c3ac45",
                hideScrollbar: true,
                barWidth: 5,
                barRadius: 2,
                barGap: 2,
                height: 200,
                drawingContextAttributes: {
                    desynchronized: false,
                },
            });
            this.music.on("ready", () => {
            });
            this.music.on("play", () => {
                if (this.isIncreaseMusicCount === false) {
                    this.increaseMusicCount();
                    this.isIncreaseMusicCount = true;
                }
                playbtn.classList.add("playing");
                //EventBus.$emit('index_items_stop_all_played',{'_uid':this._uid,'item':this.item});
                EventBus.$emit("stop_main_player", {_uid: this._uid, item: this.item});
            });
            this.music.on("pause", () => {
                playbtn.classList.remove("playing");
            });
            playbtn.addEventListener("click", () => {
                this.music.playPause();
            });
        },
        watch: {
            item: function (n) {
                if (n && n.detail.PREVIEW) {
                    this.music.load(`/cmallact/download_sample/${n.detail.PREVIEW.cde_id}`);
                }
            },
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
            },
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

                const p = {
                    cit_id: this.item.cit_id,
                    cqa_title: null,
                    cqa_content: this.comment,
                };
                // 코멘트 저장
                Http.post(`/beatsomeoneApi/add_comment`, p).then((r) => {
                    if (!r) {
                        log.debug("Comment 저장 실패");
                    } else {
                        EventBus.$emit("add_comment");
                        this.item.comment_cnt = Number(this.item.comment_cnt) + 1;
                        log.debug("Comment 저장 성공");
                    }
                });
                // 초기화
                this.comment = null;

                // 탭 이동
                this.selectTab(this.tabs[1]);
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
            // 공유 클릭
            clickShare(sns) {
                Http.post(`/beatsomeoneApi/increase_item_share_count`, {
                    cit_id: this.item.cit_id,
                }).then((r) => {
                    if (!r) {
                        log.debug("공유 카운트 증가 실패");
                    } else {
                        log.debug("공유 카운트 증가 성공");
                    }
                });

                var url = this.helper.langUrl(this.$i18n.locale, `https://beatsomeone.com/detail/${this.item.cit_key}`);
                var txt = `${this.item.cit_name} / ${this.item.musician} / ${this.item.genre}`;

                var o;
                var _url = encodeURIComponent(url);
                var _txt = encodeURIComponent(txt);
                var _br = encodeURIComponent("\r\n");

                switch (sns) {
                    case "facebook":
                        o = {
                            method: "popup",
                            url: "http://www.facebook.com/sharer/sharer.php?u=" + _url,
                        };
                        break;

                    case "twitter":
                        o = {
                            method: "popup",
                            url:
                                "http://twitter.com/intent/tweet?text=" + _txt + "&url=" + _url,
                        };
                        break;

                    case "kakaostory":
                        o = {
                            method: "popup",
                            url: "https://story.kakao.com/share?url=" + _url,
                        };
                        break;

                    case "band":
                        o = {
                            method: "popup",
                            url: "http://www.band.us/plugin/share?body=" + _txt + _br + _url,
                        };
                        break;

                    default:
                        alert("지원하지 않는 SNS입니다.");
                        return false;
                }

                switch (o.method) {
                    case "popup":
                        window.open(
                            o.url,
                            "snspopup",
                            "width=500, height=400, menubar=no, status=no, toolbar=no"
                        );
                        break;

                    case "web2app":
                        if (navigator.userAgent.match(/android/i)) {
                            // Android
                            setTimeout(function () {
                                location.href =
                                    "intent://" + o.param + "#Intent;" + o.g_proto + ";end";
                            }, 100);
                        } else if (navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i)) {
                            // Apple
                            setTimeout(function () {
                                location.href = o.a_store;
                            }, 200);
                            setTimeout(function () {
                                location.href = o.a_proto + o.param;
                            }, 100);
                        } else {
                            alert("이 기능은 모바일에서만 사용할 수 있습니다.");
                        }
                        break;
                }
            },
            // 다운로드 증가
            increaseMusicCount() {
                Http.post(`/beatsomeoneApi/increase_music_count`, {
                    cde_id: this.item.detail.PREVIEW.cde_id,
                }).then((r) => {
                    if (!r) {
                        log.debug("카운트 증가 실패");
                    } else {
                        log.debug("카운트 증가 성공");
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
            // 해쉬 클릭
            clickHash(h) {
                const path = `/sublist?search=${h}`;
                window.location.href = this.helper.langUrl(this.$i18n.locale, path);
            },
            // 링크 복사
            copyLinkToClipboard() {
                var t = document.createElement("textarea");
                document.body.appendChild(t);
                t.value = this.helper.langUrl(this.$i18n.locale, `https://beatsomeone.com/detail/${this.item.cit_key}`);
                t.select();
                document.execCommand("copy");
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
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
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
    };
</script>

<style lang="scss">
    @import "@/assets/scss/App.scss";

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }
</style>

<style lang="scss">
    @import "/assets/plugins/slick/slick.css";
    @import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

    .detail .detail__music .detail__music-info .utils .category span {
        transition: all 0.3s;
    }

    .detail .detail__music .detail__music-info .utils .category span:hover {
        opacity: 1;
    }

    .detail .detail__music .detail__music-info .utils {
        position: relative;
    }

    .detail__header {
        .tags {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex: 1;
            position: absolute;
            top: -35px;
            right: 0;
            z-index: 10;

            button {
                height: 25px;
                padding: 0 1em;
                border: 1px solid #fff;
                opacity: 0.3;
                transition: all 0.3s;
                font-size: 12px;
                border-radius: 2em;

                & + button {
                    margin-left: 5px;
                }

                &:hover {
                    opacity: 1;
                }
            }
        }
    }
</style>
