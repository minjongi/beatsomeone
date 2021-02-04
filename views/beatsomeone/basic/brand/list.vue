<template>
  <div class="wrapper">
    <Header />

    <div class="container sub">
      <div class="sublist">
        <div class="wrap">
          <div class="sublist__filter">
            <div class="row">
              <div class="filter">
                <h2 class="filter__title">{{ $t('filter') }}</h2>
                <div class="filter__content">
                  <ul class="filter__list">
                    <li class="filter__item" v-for="(f,index) in listFilter" :key="index">
                      <label :for="'fillter1'+index" class="checkbox">
                        <input
                            type="radio"
                            name="filter"
                            hidden
                            :id="'fillter1'+index"
                            :value="f"
                            v-model="param.currentGenre"
                        />
                        <span></span>
                        {{ listFilterName[index] }}
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="filter">
                <h2 class="filter__title">{{ $t('subGenres') }}</h2>
                <div class="filter__content" style="display: none;">
                  <ul class="filter__list">
                    <li class="filter__item" v-for="(f,index) in listSubgenres" :key="index">
                      <label :for="'fillter2'+index" class="checkbox">
                        <input
                            type="radio"
                            name="subgenres"
                            hidden
                            :id="'fillter2'+index"
                            :value="f"
                            v-model="param.currentSubgenres"
                        />
                        <span></span>
                        {{ listSubgenresName[index] }}
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="filter">
                <h2 class="filter__title folded">BPM</h2>
                <div class="filter__content" style="display: none;">
                  <div class="bpmRange">
                    <input type="text" />
                  </div>
                  <div class="bpmRangeInfo">
                    <input type="text" readonly id="bpm-start" v-model="param.currentBpmFr" />
                    <span>-</span>
                    <input type="text" readonly id="bpm-end" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="filter">
                <h2 class="filter__title folded">{{ $t('moods') }}</h2>
                <div class="filter__content" style="display: none;">
                  <ul class="filter__list">
                    <li class="filter__item" v-for="(f,index) in listMoods" :key="index">
                      <label :for="'fillter3'+index" class="checkbox">
                        <input
                            type="radio"
                            name="moods"
                            hidden
                            :id="'fillter3'+index"
                            :value="f"
                            v-model="param.currentMoods"
                        />
                        <span></span>
                        {{ listMoodsName[index] }}
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="filter">
                <h2 class="filter__title folded">{{ $t('trackType') }}</h2>
                <div class="filter__content" style="display: none;">
                  <ul class="filter__list">
                    <li class="filter__item" v-for="(f,index) in listTrackType" :key="index">
                      <label :for="'fillter4'+index" class="checkbox">
                        <input
                            type="radio"
                            name="trackTypes"
                            hidden
                            :id="'fillter4'+index"
                            :value="f"
                            v-model="param.currentTrackType"
                        />
                        <span></span>
                        {{ listTrackTypeName[index] }}
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="sublist__content">
            <div>
              <h2 class="section-title">
                <span>{{ $t('goToBrandshop') }} {{ brand.mem_nickname }}</span>
                <div class="sort">
                  <span>{{ $t('sortBy') }}</span>
                  <div class="custom-select">
                    <button class="selected-option">{{ listSortParamName }}</button>
                    <div class="options">
                      <button
                          class="option"
                          data-value
                          v-for="(o,i) in listSort"
                          :key="i"
                          @click="param.sort = o;"
                      >{{ listSortName[i] }}</button>
                    </div>
                  </div>
                </div>
              </h2>
            </div>
            <div v-if="!list.length" style="text-align: center; padding: 30px 0; opacity: 0.7;">
              {{ brand.mem_nickname }}님께서 등록한 비트가 없습니다.
            </div>
            <div class="row">
              <div
                  class="playList brandshop-play-list"
                  v-infinite-scroll="loading"
                  infinite-scroll-immediate-check="false"
              >
                <transition-group
                    name="staggered-fade"
                    tag="ul"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave"
                >
                  <template v-for="item in list">
                    <KeepAliveGlobal :key="item.cit_key">
                      <Index_Items :item="item" :key="item.cit_key"></Index_Items>
                    </KeepAliveGlobal>
                  </template>
                </transition-group>

                <Loader v-if="busy" key="loader" style="margin-top: 40px;"></Loader>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <main-player></main-player>
    <Footer />
  </div>
</template>

<script>
import $ from "jquery";
require("@/assets/js/function");
import Header from "../include/Header";
import Footer from "../include/Footer";
import Index_Items from "../Index_Items";
import { EventBus } from "*/src/eventbus";
import Velocity from "velocity-animate";
import Loader from "*/vue/common/Loader";
import MainPlayer from "@/vue/common/MainPlayer";
import KeepAliveGlobal from "vue-keep-alive-global";

export default {
  components: {
    Header,
    Footer,
    Index_Items,
    Loader,
    MainPlayer,
    KeepAliveGlobal,
  },
  data: function () {
    return {
      isLogin: false,
      listSort: window.sortItem,
      listFilter: ["All Genre"].concat(window.genre), // .concat(["Free Beats"])
      listSubgenres: ["All"].concat(window.genre), // .concat(["Free Beats"])
      listMoods: ["All"].concat(window.moods),
      listTrackType: ["All types"].concat(window.trackType),
      list: [],
      listTop5: null,
      randomList: [],
      offset: 0,
      last_offset: null,
      busy: false,
      param: {
        currentGenre: null,
        currentSubgenres: null,
        currentMoods: null,
        currentTrackType: null,
        currentBpmFr: 0,
        currentBpmTo: 120,
        search: null,
        sort: "Sort By",
      },
      brand: {
        mem_id: '',
        mem_userid: '',
        mem_username: '',
        mem_nickname: '',
      }
    };
  },
  watch: {
    // 검색조건 변경
    param: {
      deep: true,
      handler(n, o) {
        // log.debug({
        //     'change param' : n,
        // });
        if (o) {
          this.updateAllList();
        }
      },
    },
  },
  created() {
    this.param.currentGenre = this.listFilter[0];
    this.param.currentSubgenres = this.listSubgenres[0];
    this.param.currentMoods = this.listMoods[0];
    this.param.currentTrackType = this.listTrackType[0];

    this.updateAllList();
  },
  mounted() {
    $(".filter__title").on("click", function () {
      $(this).toggleClass("folded");
      $(this).siblings(".filter__content").stop().slideToggle();
    });

    // BPM range
    if ($(".bpmRange").length) {
      $(".bpmRange input").ionRangeSlider({
        skin: "round",
        type: "double",
        min: 0,
        max: 170,
        from: 0,
        to: 0,
        onStart: (data) => {
          // log.debug({
          //     'rpm onStart':data,
          // })
          $("#bpm-start").val(data.from);
          $("#bpm-end").val(data.to);
          this.param.currentBpmFr = data.from;
          this.param.currentBpmTo = data.to;
        },
        onChange: (data) => {
          // log.debug({
          //   'rpm onChange':data,
          // })
          $("#bpm-start").val(data.from_pretty);
          $("#bpm-end").val(data.to_pretty);
          this.param.currentBpmFr = data.from_pretty;
          this.param.currentBpmTo = data.to_pretty;
        },
      });
    }

    // 커스텀 셀렉트 옵션
    $(".custom-select").on("click", function () {
      $(this)
          .siblings(".custom-select")
          .removeClass("active")
          .find(".options")
          .hide();
      $(this).toggleClass("active");
      $(this).find(".options").toggle();
    });

    //this.onScroll();
  },
  computed: {
    listSortParamName() {
      return this.listSortName[this.listSort.indexOf(this.param.sort)];
    },
    listSortName() {
      let list = [],
          _self = this;

      this.listSort.forEach(function (val) {
        list.push(_self.$t("sortItem" + window.genLangCode(val)));
      });

      return list;
    },
    listFilterName() {
      let list = [],
          _self = this;

      this.listFilter.forEach(function (val) {
        list.push(_self.$t("genre" + window.genLangCode(val)));
      });

      return list;
    },
    listSubgenresName() {
      let list = [],
          _self = this;

      this.listSubgenres.forEach(function (val) {
        list.push(_self.$t("genre" + window.genLangCode(val)));
      });

      return list;
    },
    listMoodsName() {
      let list = [],
          _self = this;

      this.listMoods.forEach(function (val) {
        list.push(_self.$t("moods" + window.genLangCode(val)));
      });

      return list;
    },
    listTrackTypeName() {
      let list = [],
          _self = this;

      this.listTrackType.forEach(function (val) {
        list.push(_self.$t("trackType" + window.genLangCode(val)));
      });

      return list;
    },
  },
  methods: {
    loading() {
      if (this.busy) return;
      if (this.last_offset > 0 && this.last_offset === this.offset) return;
      this.busy = true;
      this.getListMore();
    },
    updateAllList: _.debounce(function () {
      this.getList();
    }, 100),
    selectItem(i) {
      const path = `/detail/${i.cit_key}`;
      window.location.href = this.helper.langUrl(this.$i18n.locale, path);
    },
    getList() {
      const p = {
        limit: 10,
        offset: 0,
        sort: this.param.sort,
        genre: this.param.currentGenre,
        subgenre: this.param.currentSubgenres,
        bpmFr: this.param.currentBpmFr,
        bpmTo: this.param.currentBpmTo,
        moods: this.param.currentMoods,
        trackType: this.param.currentTrackType,
        search: this.param.search,
        brand_mem_id: this.brand.mem_id
      };
      Http.post(`/beatsomeoneApi/sublist_list`, p).then((r) => {
        this.list = r;
        this.last_offset = this.offset;
        this.offset = this.list.length;
      });
    },
    getListMore: _.debounce(function () {
      this.busy = true;
      const p = {
        limit: 10,
        offset: this.offset,
        sort: this.param.sort,
        genre: this.param.currentGenre,
        subgenre: this.param.currentSubgenres,
        bpmFr: this.param.currentBpmFr,
        bpmTo: this.param.currentBpmTo,
        moods: this.param.currentMoods,
        trackType: this.param.currentTrackType,
        search: this.param.search,
        brand_mem_id: this.brand.mem_id
      };
      Http.post(`/beatsomeoneApi/sublist_list`, p).then((r) => {
        this.list = this.list.concat(r);
        this.last_offset = this.offset;
        this.offset = this.list.length;
        this.busy = false;
      });
    }, 1000),
    beforeEnter: function (el) {
      el.style.opacity = 0;
      el.style.height = 0;
    },
    enter: function (el, done) {
      var delay = el.dataset.index * 150;
      setTimeout(function () {
        Velocity(
            el,
            { opacity: 1, height: 90, "margin-bottom": 1 },
            { complete: done }
        );
      }, delay);
    },
    leave: function (el, done) {
      var delay = el.dataset.index * 150;
      setTimeout(function () {
        Velocity(
            el,
            { opacity: 0, height: 0, "margin-bottom": 0 },

            { complete: done }
        );
      }, delay);
    },
  },
};
</script>

<style lang="scss">
@import "@/assets/scss/App.scss";
</style>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

.albumItem {
  width: 20%;

  .albumItem__cover {
    img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 100%;
    }
  }
}
</style>
