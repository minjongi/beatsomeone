<template>
  <div class="wrapper">
    <!-- <Header :is-login="isLogin" /> -->
    <div class="container">
      123
      <div class="row">
        <h2 class="section-title">FAVORITES2</h2>
        <div class="playList" v-infinite-scroll="loading" infinite-scroll-immediate-check="false">
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
                <Index_Items :item="item" :hideFav="true" :key="item.cit_key"></Index_Items>
              </KeepAliveGlobal>
            </template>
          </transition-group>
          <Loader v-if="busy" key="loader" style="margin-top: 40px;"></Loader>
        </div>
      </div>
      <main-player></main-player>
    </div>
    <Footer />
  </div>
</template>

<script>
require("@/assets/js/function");
import Header from "../include/Header";
import Footer from "../include/Footer";
import Index_Items from "../Index_Items";
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
      list: null,
      listTop5: null,
      offset: 0,
      last_offset: 0,
      busy: false,
    };
  },
  created() {
    this.updateAllList();
  },
  mounted() {},
  computed: {},
  methods: {
    loading() {
      if (this.busy) return;
      if (this.last_offset === this.offset) return;
      this.busy = true;
      this.getListMore();
    },
    updateAllList: _.debounce(function () {
      this.getList();
    }, 100),
    getList() {
      const p = {
        limit: 10,
        offset: 0,
      };
      Http.post(`/BeatsomeoneMypageApi/get_favorites_list`, p).then((r) => {
        this.list = r;
        this.offset = this.list.length;
      });
    },
    getListMore: _.debounce(function () {
      this.busy = true;
      const p = {
        limit: 10,
        offset: this.offset,
      };
      Http.post(`/BeatsomeoneMypageApi/get_favorites_list`, p).then((r) => {
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