<template>
  <div class="wrapper sublist-wrap">
    <Header :is-login="isLogin"/>
    <div class="container sub">
      <div class="sublist">
        <!-- 필터 -->
        <button class="showFilter" @click="toggleFilter"></button>
        <!-- 필터 끝 -->
        <div class="sublist__content">
          <div class="row">
            <h2 class="section-title">
              <div class="wrap">{{ brand.mem_nickname }}</div>
            </h2>
          </div>
          <div class="icon__group_sub">
            <button :class="{'js-active' : isOpenSubmenu}" @click="openSubmenu">
              <i class="far fa-question-circle" style="color: #ffffff; width: 10px; margin-right: 5px;"></i>
            </button>
            <span class="tooltip">
                <div>
                    <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_1.png"/>
                    <span> {{ $t('lang121') }}</span>
                </div>
                <div>
                    <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_2.png"/>
                    <span> {{ $t('lang122') }}</span>
                </div>
                <div>
                    <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_3.png"/>
                    <span> {{ $t('lang123') }}</span>
                </div>
                <div>
                    <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_4.png"/>
                    <span> {{ $t('lang124') }}</span>
                </div>
                <div>
                    <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_5.png"/>
                    <span> {{ $t('lang125') }}</span>
                </div>
            </span>
            <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_1.png"/>
            <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_2.png"/>
            <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_3.png"/>
            <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_4.png"/>
            <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_5.png"/>
          </div>
          <div class="row">
            <div class="playList" v-infinite-scroll="loading" infinite-scroll-immediate-check="false" v-if="!!randomList.length">
              <transition-group
                  name="staggered-fade"
                  tag="ul"
                  v-bind:css="false"
                  v-on:before-enter="beforeEnter"
                  v-on:enter="enter"
                  v-on:leave="leave">

                <template v-for="item in randomList">
                  <KeepAliveGlobal :key="'randomList' + item.cit_key">
                    <Index_Items :item="item" :key="'randomList' + item.cit_key"></Index_Items>
                  </KeepAliveGlobal>
                </template>

                <template v-for="item in list">
                  <KeepAliveGlobal :key="item.cit_key">
                    <Index_Items :item="item" :key="item.cit_key"></Index_Items>
                  </KeepAliveGlobal>
                </template>
              </transition-group>
              <div v-if="busy" class="loader" style="margin-top: 50px;">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
                <div class="bar4"></div>
                <div class="bar5"></div>
                <div class="bar6"></div>
              </div>
            </div>
            <div v-else style="text-align: center; padding: 30px 0; opacity: 0.7;">
              {{ $t('lang181') }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sublist__filter" v-show="isShowFilter">
      <div class="sublist__filter-content">
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
                    <span></span> {{ listFilterName[index] }}
                  </label>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="filter">
            <h2 class="filter__title">{{ $t('subGenres') }}</h2>
            <div class="filter__content">
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
                    <span></span> {{ listSubgenresName[index] }}
                  </label>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="filter">
            <h2 class="filter__title">BPM</h2>
            <div class="filter__content">
              <div class="bpmRange">
                <input type="text"/>
              </div>
              <div class="bpmRangeInfo">
                <input type="text" readonly id="bpm-start"/>
                <span> - </span>
                <input type="text" readonly id="bpm-end"/>
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
                    <span></span> {{ listMoodsName[index] }}
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
                    <span></span> {{ listTrackTypeName[index] }}
                  </label>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <main-player></main-player>
    <Footer/>
  </div>
</template>

<script>

import $ from "jquery";

require('@/assets_m/js/function');
import Header from "../include/Header";
import Footer from "../include/Footer";
import Index_Items from "../Index_Items";
import {EventBus} from '*/src/eventbus';
import Velocity from "velocity-animate";
import Loader from '*/vue/common/Loader';
import MainPlayer from "@/vue/common/MobileMainPlayer";
import KeepAliveGlobal from 'vue-keep-alive-global';

import {Swiper, SwiperSlide} from 'vue-awesome-swiper';

export default {
  components: {
    Header, Footer, Index_Items, Loader, MainPlayer, KeepAliveGlobal,
    Swiper,
    SwiperSlide
  },
  data: function () {
    return {
      slick: null,
      isShowFilter: false,
      isLogin: false,
      listFilter: ['All Genre'].concat(window.genre), // .concat(['Free Beats'])
      listSubgenres: ['All'].concat(window.genre), // .concat(['Free Beats'])
      listMoods: ['All'].concat(window.moods),
      listTrackType: ['All types'].concat(window.trackType),
      offset: 0,
      last_offset: null,
      last_data: false,
      list: [],
      listTop5: null,
      randomList: [],
      randomListCitId: [],
      param: {
        currentGenre: null,
        currentSubgenres: null,
        currentMoods: null,
        currentTrackType: null,
        currentBpmFr: 0,
        currentBpmTo: 120,
      },
      brand: {
        mem_id: '',
        mem_userid: '',
        mem_username: '',
        mem_nickname: '',
      },
      busy: false,
      swiperOption1: {
        slidesPerView: '2.5',
        loop: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false
        },
      },
      isOpenSubmenu: false
    }
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
      }
    },
  },
  created() {
    this.param.currentGenre = this.listFilter[0];
    this.param.currentSubgenres = this.listSubgenres[0];
    this.param.currentMoods = this.listMoods[0];
    this.param.currentTrackType = this.listTrackType[0];
  },

  mounted() {
    $(".filter__title").on("click", function () {
      $(this).toggleClass("folded");
      $(this)
          .siblings(".filter__content")
          .stop()
          .slideToggle();
    });

    $('.player__util-toggle-btn').on('click', function () {
      $(this).toggleClass('js-active');
      $('.player__util').toggleClass('js-active');
    });
    $(".filter__title").on("click", function () {
      $(this).toggleClass("folded");
      $(this)
          .siblings(".filter__content")
          .stop()
          .slideToggle();
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
          $("#bpm-start").val(data.from);
          $("#bpm-end").val(data.to);
          this.param.currentBpmFr = data.from;
          this.param.currentBpmTo = data.to;
        },
        onChange: (data) => {
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
      $(this)
          .find(".options")
          .toggle();
    });

    this.updateAllList();
  },
  computed: {
    listFilterName() {
      let list = [],
          _self = this

      this.listFilter.forEach(function (val) {
        list.push(_self.$t('genre' + window.genLangCode(val)))
      })

      return list
    },
    listSubgenresName() {
      let list = [],
          _self = this

      this.listSubgenres.forEach(function (val) {
        list.push(_self.$t('genre' + window.genLangCode(val)))
      })

      return list
    },
    listMoodsName() {
      let list = [],
          _self = this

      this.listMoods.forEach(function (val) {
        list.push(_self.$t('moods' + window.genLangCode(val)))
      })

      return list
    },
    listTrackTypeName() {
      let list = [],
          _self = this

      this.listTrackType.forEach(function (val) {
        list.push(_self.$t('trackType' + window.genLangCode(val)))
      })

      return list
    }
  },
  methods: {
    loading() {
      if (
          (!!this.randomList && (!this.randomList.length || this.randomList.length < 10)) ||
          this.busy ||
          (this.last_offset === this.offset) ||
          this.last_data
      ) {
        return false
      }
      this.busy = true;
      this.getListMore();
    },
    updateAllList: _.debounce(function () {
      this.getList();
      this.getTopList();
    }, 100),
    doSlide() {
      this.slick = $(".topFive .topFice__slider").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        swipeToSlide: true,
        autoplay: true,
        autoplaySpeed: 2000,
        centerMode: true,
        centerPadding: "25px",
        arrows: false,
        dots: true
      });
    },
    removeSlide() {
      this.slick.slick('unslick');
    },
    toggleFilter() {
      this.isShowFilter = !this.isShowFilter;

    },
    addCart() {

      let detail_qty = {};
      detail_qty[this.item['cde_id']] = 1;
      Http.post(`/beatsomeoneApi/itemAction`, {
        stype: 'cart',
        cit_id: this.item.cit_id,
        chk_detail: [this.item.cde_id],
        detail_qty: detail_qty,
      }).then(r => {
        if (!r) {
          log.debug('장바구니 담기 실패');
        } else {
          EventBus.$emit('add_cart');
          log.debug('장바구니 담기 성공');

        }
      });
    },
    selectItem(i) {
      const path = `/detail/${i.cit_key}`;
      window.location.href = this.helper.langUrl(this.$i18n.locale, path);
    },
    getList() {
      const p = {
        limit: 10,
        offset: 0,
        sort: (!this.param.sort || this.param.sort === 'Sort By') ? 'random' : this.param.sort,
        genre: this.param.currentGenre,
        subgenre: this.param.currentSubgenres,
        bpmFr: this.param.currentBpmFr,
        bpmTo: this.param.currentBpmTo,
        moods: this.param.currentMoods,
        trackType: this.param.currentTrackType,
        search: this.param.search,
        brand_mem_id: this.brand.mem_id
      }
      Http.post(`/beatsomeoneApi/sublist_list`, p).then(r => {
        if (!this.param.sort || this.param.sort === 'Sort By') {
          this.randomList = r

          if (!!this.randomList && this.randomList.length) {
            for(let iLoop = 0;iLoop < this.randomList.length;iLoop++) {
              this.randomListCitId.push(this.randomList[iLoop].cit_id)
            }
          }
        } else {
          this.randomList = null
          this.list = r
          this.last_offset = this.offset
        }
      });
    },
    getListMore: _.debounce(function () {
      if (this.last_data) {
        this.busy = false;
        return
      }

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
      }
      Http.post(`/beatsomeoneApi/sublist_list`, p).then(r => {
        this.busy = false;

        if (!r || !r.length) {
          this.last_data = true
          return
        }

        let moreList = []
        if (this.randomListCitId.length) {
          for(let iLoop = 0;iLoop < r.length;iLoop++) {
            if (this.randomListCitId.indexOf(r[iLoop].cit_id) !== -1) {
              continue
            }
            moreList.push(r[iLoop])
          }
        }

        this.list = this.list.concat(moreList);
        this.last_offset = this.offset;
        this.offset = this.list.length;
      });
    }, 1000),
    getTopList() {
      const p = {
        genre: this.param.currentGenre,
        subgenre: this.param.currentSubgenres,
        bpmFr: this.param.currentBpmFr,
        bpmTo: this.param.currentBpmTo,
        moods: this.param.currentMoods,
        trackType: this.param.currentTrackType,
        limit: 5
      }
      Http.post(`/beatsomeoneApi/sublist_top_list`, p).then(r => {

        if (this.slick) {
          this.removeSlide();
        }

        this.listTop5 = r;

        this.$nextTick(function () {
          this.doSlide();
        });
      });
    },

    beforeEnter: function (el) {
      el.style.opacity = 0
      el.style.height = 0
    },
    enter: function (el, done) {
      var delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
            el,
            {opacity: 1, height: 55, 'margin-bottom': 1,},
            {complete: done}
        )
      }, delay)
    },
    leave: function (el, done) {
      var delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
            el,
            {opacity: 0, height: 0, 'margin-bottom': 0,},
            {complete: done}
        )
      }, delay)
    },
    openSubmenu() {
      this.isOpenSubmenu = !this.isOpenSubmenu;
    },
  },

}

</script>



<style lang="scss" scope="scope">
@import '@/assets_m/scss/App.scss';
@import "~swiper/swiper.scss";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

html, body {
  background: #111214;
}
.playList .playList__item {
  display: flex !important;
}
.sub .playList .playList__item > div {
  margin-bottom: 0 !important;
}

.playList .playList__itembox {
  height: 70px !important;
}
.icon__group_sub {
  display: flex;
  justify-content: flex-end;
  padding: 15px;
  position: relative;
  background-color: black;
  .tooltip {
    bottom: 15px;
    width: 100px;
    background: #2b2c30;
    left: auto;
    right: 34px;
    transform: none;
    visibility: hidden;
    width: 190px;
    padding: 10px 10px 5px 10px;
    color: #9ea1a8;
    border: 1px solid #9ea1a8;
    &:before {
      content: "";
      display: block;
      position: absolute;
      left: 50%;
      bottom: -7px;
      transform: translateX(-50%);
      width: 0;
      height: 0;
      border-top: 6px solid  #9ea1a8;
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
    }
    &:after {
      content: "";
      display: block;
      position: absolute;
      left: 50%;
      bottom: -10px;
      transform: translateX(-50%);
      width: 0;
      height: 0;
      border-top: 5px solid #2b2c30;
      border-bottom: 5px solid transparent;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
    }
    div {
      margin-bottom: 5px;
    }
  }
  button {
    cursor: pointer;
    width: 20px;
    height: 16px;
    position: relative;
    overflow: initial;
    opacity: .3;
    transition: all .3s;
    &.js-active {
      opacity: 1;
    }

    &.js-active + .tooltip {
      opacity: 1;
      bottom: 44px;
      visibility: initial;

      a {
        height: 40px;
      }
    }
  }
}
</style>