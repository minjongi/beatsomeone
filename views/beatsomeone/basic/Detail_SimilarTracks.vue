<template>
    <div class="playList" 
        v-infinite-scroll="loading"
        infinite-scroll-immediate-check="false">
        <ul id="playList__list" class="playList__list">
            <transition-group
                    name="staggered-fade"
                    tag="ul"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave">
            <!-- <Index_Items v-for="(item) in list" :item="item" :key="item.cit_id"></Index_Items> -->
                 <template v-for="item in randomList">
                    <KeepAliveGlobal :key="'randomList' + item.cit_id">
                        <Index_Items :item="item" :key="'randomList' + item.cit_id"></Index_Items>
                    </KeepAliveGlobal>
                </template>
                <template v-for="item in list">
                    <KeepAliveGlobal :key="item.cit_id">
                        <Index_Items :item="item" :key="item.cit_id"></Index_Items>
                    </KeepAliveGlobal>
                </template>
            </transition-group>
        </ul>
        <!-- <div v-if="busy">
            <Loader key="loader" ></Loader>
        </div>
         -->
         <div class="loader" v-if="busy" style="margin-top: 40px;">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
            <div class="bar6"></div>
        </div>
        <!-- <div v-if="randomList.length === 0" class="no-playLost__list">
            <p>{{ $t('detailSimilarTracksNotexists') }}</p>
        </div> -->
    </div>
</template>

<script>
    import $ from "jquery";
    import Loader from '*/vue/common/Loader';
    require("@/assets/js/function");
    import Index_Items from "./Index_Items";
    import Velocity from "velocity-animate";
    import KeepAliveGlobal from "vue-keep-alive-global";

    export default {
        props: ['item'],
        components: {Index_Items,Loader, KeepAliveGlobal},
        data: function() {
            return {
                offset: 0,
                list: [],
                randomList: [],
                busy: false,
                currentCitId: null,
                last_offset: null,
                last_data: false,
            }
        },
        watch: {
            item: function (n) {
                if (!!n.cit_id && this.currentCitId !== n.cit_id) {
                  this.currentCitId = n.cit_id
                  this.getList()
                }
            },
        },
        mounted() {
            this.getList()
        },
        methods: {
            loading() {
                if (!this.randomList.length || this.randomList.length < 10) {
                    return false
                }
                if (this.busy) return;
                if (this.last_offset === this.offset) return;
                if (this.last_data) return;
                this.busy = true;
                this.getListMore();
            },
            updateAllList: _.debounce(function () {
                this.getList();
            }, 100),

            getList() {
                if(!this.item) return;
                this.busy = true;
                const p = {
                    limit: 10,
                    offset: this.offset
                }
                Http.post(`/beatsomeoneApi/detail_similartracks_list/${this.item.cit_id}`,p).then(r=> {
                    this.randomList = r;
                    this.offset = this.randomList.length;
                    this.busy = false;
                });
            },
            getListMore: _.debounce(function () {
                if (this.last_data) {
                  this.busy = false;
                  return
                }

                this.busy = true;
                const p = {
                    limit: 20,
                    offset: this.offset,
                };
                Http.post(`/beatsomeoneApi/detail_similartracks_list/${this.item.cit_id}`,p).then((r) => {
                    if (!r || !r.length) {
                      this.last_data = true
                    }
                    this.list = this.list.concat(r);
                    this.last_offset = this.offset;
                    this.offset = this.list.length+this.randomList.length;
                    this.busy = false;
                });
            }, 1000),
            beforeEnter: function (el) {
                el.style.opacity = 0
                el.style.height = 0
            },
            enter: function (el, done) {
                var delay = el.dataset.index * 150
                setTimeout(function () {
                    Velocity(
                        el,
                        { opacity: 1, height: 90, 'margin-bottom': 1,  },
                        { complete: done }
                    )
                }, delay)
            },
            leave: function (el, done) {
                var delay = el.dataset.index * 150
                setTimeout(function () {
                    Velocity(
                        el,
                        { opacity: 0, height: 0, 'margin-bottom': 0,  },
                        { complete: done }
                    )
                }, delay)
            }
        },

    }

</script>

<style scoped="scoped">

.no-playLost__list {
    padding: 80px 0;
    text-align: center;
}
.no-playLost__list p {
    font-size: 14px;
    color:#fff;
}
</style>
