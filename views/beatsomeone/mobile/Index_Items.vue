<template>
    <li v-if="item" class="playList__itembox" :id="'playList__item'+ item.cit_id">
        <div class="playList__item playList__item--title">
            <div v-if="!showCheck" :class="{active : item.is_wish === '1' }" class="col favorite" @click="toggleWish">
                <button>{{ $t('favorite') }}</button>
            </div>
            <div v-if="showCheck" class="col favorite">
                <label class="checkbox nfavorites__checkbox">
                    <input v-model="checkVal" hidden type="checkbox">
                    <span></span>
                </label>
            </div>
            <div class="col name">
                <figure>
                    <div class="playList__cover" @click="selectItem(item)">
                        <img :src="'/uploads/cmallitem/' + item.thumb" alt/>
                        <i v-if="item.is_new" class="label new">N</i>
                    </div>

                    <button
                        :data-action="'playAction' + item.cit_id "
                        class="btn-play"
                        @click="playAudio(item)"
                    >재생
                    </button>
                    <div class="wave"></div>
                    <a :href="'/detail/' + item.cit_key + '#/'">
                    <figcaption>
                      <h3 class="playList__title">{{ subName }}</h3>
                      <div class="playList__bottom-info">
                        <span class="playList__by">by {{ item.mem_nickname }}</span>
                        <div class="">
                          <img style="margin-right: 5px; width:10px;" v-if="item.cit_freebeat === '1'" src="/assets/images/icon/icon_1.png"/>
                          <img style="margin-right: 5px; width:10px;" v-if="item.cit_type5 === '1'" src="/assets/images/icon/icon_2.png"/>
                          <img style="margin-right: 5px; width:10px;" v-if="item.cit_officially_registered === '1'" src="/assets/images/icon/icon_3.png"/>
                          <img style="margin-right: 5px; width:10px;" v-if="item.cit_include_copyright_transfer === '1'" src="/assets/images/icon/icon_4.png"/>
                          <img style="margin-right: 5px; width:10px;" v-if="item.cit_org_content === '1'" src="/assets/images/icon/icon_5.png"/>
                        </div>
                      </div>
                    </figcaption>
                  </a>
                </figure>
            </div>
            <div class="col buybtn">
                <button @click="addCart">
                    <i class="fa fa-shopping-cart" style="color: #ffda2a;"></i>
                </button>
            </div>
            <div class="col more">
                <button :class="{'js-active' : isOpenSubmenu}" @click="openSubmenu">{{ $t('more') }}</button>
                <span class="tooltip">
                    <a @click="clickShare('twitter')">{{ $t('lang107') }}</a><a @click="clickShare('facebook')">{{ $t('lang108') }}</a><a
                            @click="copyLinkToClipboard()">{{ $t('lang109') }}</a>
                </span>
            </div>
        </div>
        <PurchaseTypeSelector :item="item"
                              :purchaseTypeSelectorPopup.sync="purchaseTypeSelectorPopup"></PurchaseTypeSelector>
    </li>
</template>

<script>
import {EventBus} from "*/src/eventbus";
import $ from "jquery";
import WaveSurfer from "wavesurfer.js";
import PurchaseTypeSelector from "./component/PurchaseTypeSelector";

export default {
    props: ["item", "showCheck", "cart", "value"],
    components: {
        PurchaseTypeSelector,
    },
    data: function () {
        return {
            isOpenSubmenu: false,
            ws: null,
            isPlay: false,
            isReady: false,
            purchaseTypeSelectorPopup: false,
        };
    },
    computed: {
        hashtag() {
            return this.item.hashTag ? this.item.hashTag.split(",") : "";
        },
        checkVal: {
            get() {
                return this.value
            },
            set(val) {
                this.$emit('input', val);
            }
        },
        subName() {
            if (this.item.cit_name.length < 20) {
                return this.item.cit_name;
            } else {
                return this.item.cit_name.substr(0, 20) + '...';
            }
        }
    },
    // beforeDestroy() {
    //     this.ws.destroy();
    // },
    mounted() {
        EventBus.$on("index_items_open_submenu", (r) => {
            if (this._uid !== r) {
                this.isOpenSubmenu = false;
            }
        });

        EventBus.$on("player_request_start", (r) => {
            // log.debug({
            //     'ON ITEM: player_request_start':r,
            //     'R' : this.item.cit_id === r.item.cit_id,
            //     'this.item.cit_id':this.item.cit_id,
            // })
            if (this._uid != r.item._uid) {
                this.stop();
            }
        });
        // 메인 플레이어 재생 시작
        EventBus.$on("main_player_play", (r) => {
            // log.debug({
            //     '_uid':this._uid,
            //     'R _uid' : r._uid,
            //     'EQ':this._uid == r._uid,
            // })
            if (this._uid == r._uid) {
                this.start();
            } else {
                this.stop();
            }
        });
        // 메인 플레이어 재생 종료
        EventBus.$on("main_player_stop", (r) => {
            // log.debug({
            //     'ON ITEM: main_player_stop':r,
            //     'R' : this.item.cit_id === r.item.id,
            //     'this.item.cit_id':this.item.cit_id,
            // })
            if (this._uid === r._uid) {
                this.stop();
            }
        });

        if (this.item.cit_type3 === '0') {
            this.$set(this.item, 'is_new', false);
            let now = new Date();
            let startDateTime = new Date(this.item.cit_start_datetime);
            if ((now - startDateTime) < 1000 * 3600 * 24 * 7) this.$set(this.item, 'is_new', true);
        } else if (this.item.cit_type3 === '1') {
            this.$set(this.item, 'is_new', true);
        }

        // this.setAudioInstance(this.item);
    },
    methods: {
        stop() {
            if (this.ws) {
                this.ws.pause();
            }

            const el = $("#playList__item" + this.item.cit_id);
            // log.debug({
            //     'STOP el':el,
            // })
            el.removeClass("playing");
            this.isPlay = false;
        },
        start() {
            log.debug("ITEM : start");
            if (this.ws) {
                this.ws.play();
            }

            // if(this.isReady && !this.ws.isPlaying()) {
            //     this.ws.play();
            // }
            const el = $("#playList__item" + this.item.cit_id);
            // log.debug({
            //     'START el':el,
            // })
            el.addClass("playing");
            this.isPlay = true;
        },
        openSubmenu() {
            this.isOpenSubmenu = !this.isOpenSubmenu;
            EventBus.$emit("index_items_open_submenu", this._uid);
        },
        toggleWish() {
            Http.post(`/beatsomeoneApi/toggle_wish_item/${this.item.cit_id}`).then(
                (r) => {
                    if (r === true) {
                        // log.debug({
                        //     'toggleWish':this.item,
                        // })
                        this.item.is_wish = this.item.is_wish === "1" ? "0" : "1";
                    }
                }
            );
        },
        addCart() {
            // this.item.detail = {
            //   LEASE: {
            //     cde_id: this.item.cde_id || null,
            //     cde_price: this.item.cde_price || null,
            //     cde_price_d: this.item.cde_price_d || null,
            //   },
            //   STEM: {
            //     cde_id: this.item.cde_id_2 || null,
            //     cde_price: this.item.cde_price_2 || null,
            //     cde_price_d: this.item.cde_price_d_2 || null,
            //   },
            // };
            // console.log(this.item.detail);
            this.purchaseTypeSelectorPopup = true;
        },
        playAudio(i) {
            // if(!this.isReady) return;

            // 재생 시작
            if (!this.isPlay) {
                // log.debug({
                //     'EMIT ITEM : item player_request_start':this.item,
                // });

                if (!this.ws) {
                    this.setAudioInstance(this.item);
                }

                EventBus.$emit("player_request_start", {
                    _uid: this._uid,
                    item: this.item,
                    ws: this.ws,
                });
                this.start();
                this.increaseMusicCount();
            }
            // 중지
            else {
                // log.debug({
                //     'EMIT ITEM : item player_request_stop':this.item,
                // });
                EventBus.$emit("player_request_stop", {
                    _uid: this._uid,
                    item: this.item,
                    ws: this.ws,
                });

                this.stop();
            }
        },
        time_convert(num) {
            var minutes = Math.floor(num / 60);
            var seconds = num % 60;
            if (seconds < 10) {
                seconds = "0" + seconds;
            }
            return minutes + ":" + seconds;
        },
        setAudioInstance(item) {
            this.ws = WaveSurfer.create({
                container: "#playList__item" + item.cit_id + " .wave",
                waveColor: "#696969",
                progressColor: "#c3ac45",
                hideScrollbar: true,
                height: 50,
            });
            if (item.preview_cde_id) {
                this.ws.load(`/cmallact/download_sample/${item.preview_cde_id}`);
            }

            this.ws.on("play", () => {
                // document
                //     .querySelector("#playList__item" + item.id)
                //     .classList.add("playing");
                //this.start();
                const el = document.querySelector("#playList__item" + this.item.cit_id);
                if (el) {
                    el.classList.add("playing");
                }
            });

            this.ws.on("audioprocess", (e) => {
                const el = document.querySelector(
                    "#playList__item" + this.item.cit_id + " .current"
                );
                if (el) {
                    el.innerHTML = this.time_convert(parseInt(e, 10)) + " / ";
                }
            });

            this.ws.on("ready", () => {
                const el = document.querySelector(
                    "#playList__item" + this.item.cit_id + " .duration"
                );
                if (el) {
                    el.innerHTML = this.time_convert(parseInt(this.ws.getDuration(), 10));
                }

                if (this.isPlay) {
                    this.ws.play();
                }

                this.isReady = true;
            });
            this.ws.on("pause", () => {
            });
        },
        //다운로드 증가
        increaseMusicCount() {
            Http.post(`/beatsomeoneApi/increase_music_count`, {
                cde_id: this.item.cde_id,
            }).then((r) => {
                if (!r) {
                    log.debug("카운트 증가 실패");
                } else {
                    log.debug("카운트 증가 성공");
                }
            });
        },
        // 해쉬 클릭
        clickHash(h) {
            const path = `/beatsomeone/sublist?search=${h}`;
            window.location.href = path;
        },
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

            var url = `https://beatsomeone.com/detail/${this.item.cit_key}`;
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
        // 링크 복사
        copyLinkToClipboard() {
            var t = document.createElement("textarea");
            document.body.appendChild(t);
            t.value = `https://beatsomeone.com/detail/${this.item.cit_key}`;
            t.select();
            document.execCommand("copy");
            document.body.removeChild(t);
            alert(`복사되었습니다\nCtrl + V 를 눌러 확인해보세요`);
            this.isOpenSubmenu = false;
        },
    },
};
</script>

<style lang="scss">
.playList__bottom-info {
    display: flex;
    align-items: flex-start;
    margin-top: 5px;
    flex-direction: column;
}

.playList .playList__item {
    height: auto !important;
}

.playList .playList__itembox {
    height: 70px !important;

    .buybtn {
        button {
            background: url(/assets/images/icon/cart.png) no-repeat 12px center;
        }
    }
}

.playList .playList__item .name figure {
    margin-right: 0 !important;
}

.playList .playList__item .name figure figcaption {
    padding-right: 10px;

    .playList__by {
        margin-top: 0;
    }
}
</style>
