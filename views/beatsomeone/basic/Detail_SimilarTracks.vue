<template>
    <div class="playList" v-infinite-scroll="getListMore" infinite-scroll-immediate-check="false"  v-if="list">
        <ul id="playList__list" class="playList__list">
            <transition-group
                    name="staggered-fade"
                    tag="ul"
                    v-bind:css="false"
                    v-on:before-enter="beforeEnter"
                    v-on:enter="enter"
                    v-on:leave="leave">
            <Index_Items v-for="(item,index) in list" :item="item" :key="item.cit_id" :disabledWave="true"></Index_Items>
            </transition-group>
        </ul>
        <div v-if="busy">
            <Loader key="loader" ></Loader>
        </div>
        
        <div v-if="list.length === 0" class="no-playLost__list">
            <p>{{ $t('detailSimilarTracksNotexists') }}</p>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import Loader from '*/vue/common/Loader';

    import Index_Items from "./Index_Items";
    import Velocity from "velocity-animate";

    export default {
        props: ['item'],
        components: {Index_Items,Loader},
        data: function() {
            return {
                offset: 0,
                list: null,
                busy: false,
            }
        },
        watch: {
            item: function (n) {
                this.getList();
            },
        },
        mounted() {


            // 메인페이지: 서브 앨범 슬라이드 이벤트
            $(".toggle-subList").on("click", function() {
                var itemLength = $(this)
                    .parents(".playList__itembox")
                    .find(".subPlayList .playList__itembox").length;
                $(this).toggleClass("active");
                $(this)
                    .parents(".playList__itembox")
                    .toggleClass("is-show-children");

                if ($(this).hasClass("active")) {
                    // active 일때,
                    $(this)
                        .parents(".playList__itembox")
                        .find(".subPlayList")
                        .css("height", 90 * itemLength);
                } else {
                    // 지웟을때,
                    $(this)
                        .parents(".playList__itembox")
                        .find(".subPlayList")
                        .css("height", 0);
                }
            });

            this.getList();
        },
        methods: {
            getList() {
                if(!this.item) return;
                this.busy = true;
                const p = {
                    limit: 20,
                    offset: this.offset,
                }
                Http.post(`/beatsomeoneApi/detail_similartracks_list/${this.item.cit_id}`,p).then(r=> {
                    this.list = r;
                    this.offset = this.list.length;
                    this.busy = false;
                });
            },
            getListMore: _.debounce(function() {
                const p = {
                    limit: 10,
                    offset: this.offset,
                }
                this.busy = true;
                Http.post(`/beatsomeoneApi/detail_similartracks_list/${this.item.cit_id}`,p).then(r=> {
                    this.list = this.list.concat(r);
                    this.offset = this.list.length;
                    this.busy = false;
                });
            },1000),
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
