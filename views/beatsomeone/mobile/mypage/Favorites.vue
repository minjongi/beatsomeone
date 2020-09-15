<template>
    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container">
            <div class="nfavorites">
                <div class="nfavorites__header">
                    <div class="wrap">
                        <h2>FAVORITE</h2>
                    </div>
                </div>
                <section class="nfavorites__body">
                    <div class="nfavorites__actions">
                        <div class="left">
                            <label for="c2" class="checkbox nfavorites__checkbox">
                                <input type="checkbox" hidden id="c2" v-model="checkedAll">
                                <span style="margin-right: 5px;"></span> &nbsp; Select All({{ checkedCount }}/{{
                                list.length }})
                            </label>
                        </div>
                        <div class="right">
                            <button class="nfavorites__delete" @click="deleteItems" :disabled="checkedCount === 0">
                                <i></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="playList" v-infinite-scroll="loading" infinite-scroll-immediate-check="false">
                        <transition-group name="staggered-fade" tag="ul" v-bind:css="false"
                                          v-on:before-enter="beforeEnter"
                                          v-on:enter="enter" v-on:leave="leave">
                            <template v-for="item in list">
                                <KeepAliveGlobal :key="item.cit_key">
                                    <Index_Items :item="item" v-model="item.is_selected" :hideFav="true"
                                                 :showCheck="true" :cart="true" :key="item.cit_key"></Index_Items>
                                </KeepAliveGlobal>
                            </template>
                        </transition-group>
                        <Loader v-if="busy" key="loader" style="margin-top: 40px;"></Loader>
                    </div>
                </section>
            </div>
        </div>
        <Footer/>
        <main-player></main-player>
    </div>
</template>

<script>
    import axios from 'axios';

    require("@/assets_m/js/function");
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
                list: [],
                listTop5: null,
                offset: 0,
                last_offset: 0,
                busy: false,
                checkedCount: 0,
                checkedAll: false
            };
        },
        created() {
            this.updateAllList();
        },
        mounted() {
        },
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
                    r.forEach(x => {
                        x.is_selected = false;
                    })
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
                    r.forEach(x => {
                        x.is_selected = false;
                    })
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
                        {opacity: 1, height: 55, "margin-bottom": 1},
                        {complete: done}
                    );
                }, delay);
            },
            leave: function (el, done) {
                var delay = el.dataset.index * 150;
                setTimeout(function () {
                    Velocity(
                        el,
                        {opacity: 0, height: 0, "margin-bottom": 0},

                        {complete: done}
                    );
                }, delay);
            },
            toggleCheckAll: function () {

                this.list.forEach(item => {
                    item.is_selected = false
                })
            },
            deleteItems: function () {
                this.list.forEach(item => {
                    if (item.is_selected) {
                        axios.post(`/cmallact/wishlist_delete/${item.cwi_id}`)
                            .then(res => res.data)
                            .then(data => {
                                this.list = data.list;
                            })
                            .catch(error => {
                                console.error(error);
                            })
                    }
                });
            }
        },
        watch: {
            list: {
                deep: true,
                handler() {
                    this.checkedCount = 0;
                    this.list.forEach(item => {
                        if (item.is_selected) {
                            this.checkedCount++;
                        }
                    })
                }
            },
            checkedAll: function (val) {
                this.list.forEach(item => {
                    item.is_selected = val;
                });
            }
        }
    };
</script>

<style lang="scss">
    @import "@/assets_m/scss/App.scss";
</style>

<style lang="css">
    .nfavorites {
        padding-top: 100px;
        background: url('/assets_m/images/favorites-bg.png') no-repeat left top;
        background-size: 100% auto;;
    }

    .nfavorites__header {
        padding-left: 30px;
        margin-bottom: 50px;
    }

    .nfavorites__header h2 {
        font-size: 30px;
    }

    .nfavorites__checkbox {
        justify-content: center;
    }

    .nfavorites__checkbox span {
        margin-right: 0;
        width: 15px;
        height: 15px;
    }

    .nfavorites__checkbox input:checked + span {
        border: none;
        background: url('/assets_m/images/icon/checkbox-on.png') no-repeat center;
        background-size: 15px 15px;
    }

    .nfavorites__actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-left: 18px;
        padding-right: 16px;
    }

    .nfavorites__delete {
        width: 80px;
        height: 30px;
        background: #ff5858;
        color: #fff;
        text-align: center;
        font-weight: 300;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 3px;
        transition: all .3s;
    }

    .nfavorites__delete:disabled {
        opacity: .4;
    }

    .nfavorites__delete i {
        background: url('/assets_m/images/trash.png') no-repeat center;
        width: 16px;
        background-size: auto 16px;
        height: 16px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }

    .nfavorites .playList .playList__item {
        display: flex;
    }

    .nfavorites .playList .playList__item .btns {
        width: 35px;
        margin-left: auto;
        margin-right: 15px;
    }

    .nfavorites .playList .playList__item .btns a {
        width: 35px;
        height: 35px;
        background: #4890ff url('/assets_m/images/cart.png') no-repeat center;
        border-radius: 50%;
        display: block;
        text-indent: -9999px;
        overflow: hidden;
    }

  .container {
    min-height: 60vh;
  }

</style>