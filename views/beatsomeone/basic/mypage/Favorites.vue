<template>
  <div class="wrapper">
    <Header :is-login="isLogin" />
    <div class="container">

      <div class="nfavorites">
        <div class="nfavorites__header">
          <div class="wrap">
            <h2>FAVORITE</h2>
          </div>
        </div>
        <section class="nfavorites__body">
          <div class="wrap">
            <div class="nfavorites__actions">
              <div class="left">
                <label for="c2" class="checkbox nfavorites__checkbox">
                  <input type="checkbox" hidden id="c2">
                  <span style="margin-right: 5px;"></span> Select All(5/5)
                </label>
              </div>
              <div class="right">
                <button class="nfavorites__delete" disabled="disabled">
                  <i></i> Delete
                </button>
              </div>
            </div>
            <div class="playList" v-infinite-scroll="loading" infinite-scroll-immediate-check="false">
              <transition-group name="staggered-fade" tag="ul" v-bind:css="false" v-on:before-enter="beforeEnter"
                                v-on:enter="enter" v-on:leave="leave">
                <template v-for="item in list">
                  <KeepAliveGlobal :key="item.cit_key">
                    <Index_Items :item="item" :hideFav="true" :showCheck="true" :key="item.cit_key"></Index_Items>
                  </KeepAliveGlobal>
                </template>
              </transition-group>
              <Loader v-if="busy" key="loader" style="margin-top: 40px;"></Loader>
            </div>
          </div>
        </section>
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

<style lang="css" scoped="scoped">

.nfavorites {padding-top: 170px;background: url('/assets/images/favorites-bg.png') no-repeat left top;background-size: 100% auto;min-height: 700px;}
.nfavorites__header{padding-left: 75px;margin-bottom: 130px;}
.nfavorites__header h2{font-size: 40px;}

.nfavorites__checkbox{justify-content: center;}
.nfavorites__checkbox span{margin-right: 0;width: 20px; height: 20px;}
.nfavorites__checkbox input:checked + span{border: none;background: url('/assets/images/checkbox-on.png') no-repeat center;background-size: 20px 20px;}

.nfavorites__actions{display: flex;align-items: center;justify-content: space-between;margin-bottom: 20px;padding-left: 30px;}
.nfavorites__delete{width: 100px;height: 40px;background:#ff5858;color:#fff;text-align: center;font-weight: 300;font-size: 12px;display:flex;align-items: center;justify-content: center;border-radius: 3px;transition:all .3s;}
.nfavorites__delete:disabled{opacity: .4}
.nfavorites__delete i{background: url('/assets/images/trash.png') no-repeat center;width:16px;background-size: auto 20px;height: 20px;display:inline-block;vertical-align: middle;margin-right: 5px;}

.nfavorites .playList .playList__item .btns{width: 100px;margin-right: 30px;}
.nfavorites .playList .playList__item .btns a{display: block;line-height: 40px;border-radius: 20px;color:#fff;background:#4890ff;font-size: 12px;text-align: center;width: 100%;}

.nfavorites .playList .playList__item .price{width: 120px;text-align: center;}
.nfavorites .playList .playList__item .price span{white-space: nowrap;font-weight: 600;}

.nfavorites .playList .playList__item .name .toggle-subList.active{border: 1px solid #fff;}

.nfavorites .playList .playList__item .name{width: 460px;}
.nfavorites .playList .playList__item .name figure{flex: 1;}
.nfavorites .playList .playList__item .name figure figcaption{flex: 1;}
</style>