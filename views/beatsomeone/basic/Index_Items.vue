<template>
  <li v-if="item" class="playList__itembox" :id="'playList__item'+ item.cit_id">
    <div class="playList__item playList__item--title">
      <div
        class="col favorite"
        :class="{active : item.is_wish === '1' }"
        @click="toggleWish"
        v-if="!hideFav"
      >
        <button>{{ $t('favorite') }}</button>
      </div>
      <div class="col name">
        <figure>
          <span class="playList__cover">
            <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt />
            <i class="label new" ng-if="item.isNew">N</i>
          </span>
          <figcaption class="pointer" @click="selectItem(item)">
            <h3 class="playList__title">{{ item.cit_name }}</h3>
            <span class="playList__by">by {{ item.mem_nickname }}</span>
          </figcaption>
        </figure>

        <!-- 서브리스트 토글 버튼 -->
        <button class="toggle-subList" v-if="item.subPlayList && item.subPlayList.length > 0"></button>

        <div class="tags">
          <div>
            <button style="color:#3873d3;">FREE</button>
            <button style="color:#ffda2a;">Original</button>
          </div>
          <div>
            <button style="color:#fff;">Copyright Registered</button>
          </div>
        </div>
      </div>

      <div class="col genre">
        <span v-for="(t,i) in hashtag" :key="i">
          <button @click="clickHash(t)" v-hover="'active'">{{ t }}</button>
        </span>
      </div>
      <div class="col playbtn">
        <button
          class="btn-play"
          @click="playAudio(item)"
          :data-action="'playAction' + item.cit_id "
        >재생</button>
        <span class="timer">
          <span class="current">0:00 /</span>
          <span class="duration">0:00</span>
        </span>
      </div>
      <div class="col spectrum">
        <div class="wave"></div>
      </div>
      <div class="col buybtn">
        <button @click="addCart">구매하기</button>
      </div>
      <div class="col utils" v-if="false">
        <a :href="`/cmallact/download_sample/${item.cde_id}`" class="download">{{ $t('download') }}</a>
      </div>
      <div class="col more_shared">
        <button>
          {{ $t('share') }}
          <span class="tooltip">
            <a @click="clickShare('twitter')">Twitter</a>
            <a @click="clickShare('facebook')">Facebook</a>
            <a @click="copyLinkToClipboard()">CopyLink</a>
          </span>
        </button>
      </div>
    </div>
    <PurchaseTypeSelector :purchaseTypeSelectorPopup.sync="purchaseTypeSelectorPopup" :item="item"></PurchaseTypeSelector>
  </li>
</template>

<script>
import { EventBus } from "*/src/eventbus";
import $ from "jquery";
import WaveSurfer from "wavesurfer.js";
import PurchaseTypeSelector from "./component/PurchaseTypeSelector";

export default {
  components: {
    PurchaseTypeSelector,
  },
  props: ["item", "hideFav"],
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
  },
  directives: {
    hover: {
      bind(el, binding, vnode) {
        const { value = "" } = binding;
        el.addEventListener("mouseenter", () => {
          el.classList.add(value);
        });
        el.addEventListener("mouseleave", () => {
          el.classList.remove(value);
        });
      },
      unbind(el, binding, vnode) {
        el.removeEventListener("mouseenter");
        el.removeEventListener("mouseleave");
      },
    },
  },
  mounted() {
    EventBus.$on("index_items_open_submenu", (r) => {
      if (this._uid !== r) {
        this.isOpenSubmenu = false;
      }
    });
    EventBus.$on("player_request_start", (r) => {
      log.debug({
        "ON ITEM: player_request_start": r,
        R: this.item.cit_id === r.item.cit_id,
        "this.item.cit_id": this.item.cit_id,
      });
      if (this._uid != r.item._uid) {
        this.stop();
      }
    });
    // 메인 플레이어 재생 시작
    EventBus.$on("main_player_play", (r) => {
      log.debug({
        _uid: this._uid,
        "R _uid": r._uid,
        EQ: this._uid == r._uid,
      });
      if (this._uid == r._uid) {
        this.start();
      } else {
        this.stop();
      }
    });
    // 메인 플레이어 재생 종료
    EventBus.$on("main_player_stop", (r) => {
      log.debug({
        "ON ITEM: main_player_stop": r,
        R: this.item.cit_id === r.item.id,
        "this.item.cit_id": this.item.cit_id,
      });
      if (this._uid === r._uid) {
        this.stop();
      }
    });
  },
  methods: {
    stop() {
      if (this.ws) {
        this.ws.pause();
      }

      const el = $("#playList__item" + this.item.cit_id);
      el.removeClass("playing");
      this.isPlay = false;
    },
    start(isInit) {
      // log.debug('ITEM : start');
      if (this.ws) {
        this.ws.play();
      }

      const el = $("#playList__item" + this.item.cit_id);
      el.addClass("playing");
      if (!isInit) {
        this.isPlay = true;
      }
    },
    openSubmenu() {
      this.isOpenSubmenu = !this.isOpenSubmenu;
      EventBus.$emit("index_items_open_submenu", this._uid);
    },
    toggleWish() {
      Http.post(`/beatsomeoneApi/toggle_wish_item/${this.item.cit_id}`).then(
        (r) => {
          if (r === true) {
            this.item.is_wish = this.item.is_wish === "1" ? "0" : "1";
          }
        }
      );
    },
    addCart() {
      this.item.detail = {
        LEASE: {
          cde_id: this.item.cde_id || null,
          cde_price: this.item.cde_price || null,
          cde_price_d: this.item.cde_price_d || null,
        },
        STEM: {
          cde_id: this.item.cde_id_2 || null,
          cde_price: this.item.cde_price_2 || null,
          cde_price_d: this.item.cde_price_d_2 || null,
        },
      };
      this.purchaseTypeSelectorPopup = true;
    },
    selectItem(i) {
      const path = `/beatsomeone/detail/${i.cit_key}`;
      window.location.href = path;
    },
    playAudio(i) {
      // 재생 시작
      if (!this.isPlay) {
        if (!this.ws) {
          this.setAudioInstance(this.item);
        }

        EventBus.$emit("player_request_start", {
          _uid: this._uid,
          item: this.item,
          ws: this.ws,
        });
        this.start();
      }
      // 중지
      else {
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
        height: 40,
        backgroundColor: "transparent",
        drawingContextAttributes: {
          desynchronized: false,
        },
      });
      if (item.preview_cde_id) {
        this.ws.load(`/cmallact/download_sample/${item.preview_cde_id}`);
      }

      this.ws.on("play", () => {
        const el = document.querySelector("#playList__item" + this.item.cit_id);
        if (el) {
          el.classList.add("playing");
        }
        this.increaseMusicCount();
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
          this.start(true);
        }

        this.isReady = true;
      });
      this.ws.on("pause", () => {});
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

      var url = `http://mvp.beatsomeone.com/beatsomeone/detail/${this.item.cit_key}`;
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
      t.value = `http://mvp.beatsomeone.com/beatsomeone/detail/${this.item.cit_key}`;
      t.select();
      document.execCommand("copy");
      document.body.removeChild(t);
      alert(`복사되었습니다\nCtrl + V 를 눌러 확인해보세요`);
    },
  },
};
</script>

<style scoped="scoped" lang="scss">
.timer {
  margin-left: 20px !important;
  width: 63px;
}
.sublist .col.playbtn {
  flex: none;
}
.playList .playList__item .spectrum {
  width: 200px;
  flex: none;
}
.playList .playList__item .name {
  flex: 1;
  width: auto;
  figure {
    width: auto;
    flex: 1;
    width: calc(100% - 150px);
    margin-right: 5px;
    figcaption {
      width: calc(100% - 85px);
    }
  }

  .tags {
    padding-right: 30px;
    width: 150px;
    flex: none;
    div {
      display: flex;
      align-items: center;
      justify-content: flex-end;

      &:first-child {
        margin-bottom: 5px;
      }
    }
    button {
      height: 20px;
      padding: 0 8px;
      border: 1px solid #fff;
      opacity: 0.3;
      transition: all 0.3s;
      font-size: 10px;
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

.sublist {
  .col.playbtn {
    width: 180px;
    flex: none;
  }
  .col.spectrum {
    width: 100px !important;
  }
  .col.more_shared {
    width: 50px;
    flex: none;
  }
  .buybtn {
    width: 145px;
    flex: none;
  }
}
</style>
