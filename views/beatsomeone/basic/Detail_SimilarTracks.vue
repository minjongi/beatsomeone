<template>
    <div class="playList">
        <ul id="playList__list" class="playList__list">
            <!-- 플레이리스트 들어감 -->
            <Index_Items v-for="(item,index) in list" :item="item" :key="index"></Index_Items>

        </ul>
    </div>
</template>


<script>

    import $ from "jquery";

    import Index_Items from "./Index_Items";


    export default {
        props: ['item'],
        components: {Index_Items},
        data: function() {
            return {
                list: null,
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
                Http.post(`/beatsomeoneApi/detail_similartracks_list/${this.item.cit_id}`).then(r=> {
                    this.list = r;
                });
            },
        },

    }

</script>

<style scoped="scoped">

</style>
