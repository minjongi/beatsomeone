<template>
    <div class="playList">
        <ul id="playList__list" class="playList__list">
            <!-- 플레이리스트 들어감 -->
            <Index_Items v-for="(item,index) in playList" :item="item" :key="index"></Index_Items>
        </ul>
    </div>
</template>


<script>

    import $ from "jquery";

    import Index_Items from "./Index_Items";


    export default {
        components: {Index_Items},
        data: function() {
            return {
                playList : [
                    {
                        id: 1,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "Celebration (Buy 1 Get 3 FR...",
                        singer: "by Diamond Style",
                        genres: [
                            {
                                active: true,
                                title: "All Genre"
                            },
                            {
                                active: true,
                                title: "Jaz"
                            },
                            {
                                active: false,
                                title: "Amb"
                            },
                            {
                                active: false,
                                title: "Fol"
                            },
                            {
                                active: false,
                                title: "Singer-Songwriter"
                            }
                        ],
                        audioFile: "/audio/testfile.mp3",
                        subPlayList: [
                            {
                                id: 8,
                                coverImg: "https://via.placeholder.com/55x55",
                                isNew: true,
                                title: "Sky Red",
                                singer: "by Ant Chamberlain",
                                genres: [
                                    {
                                        active: true,
                                        title: "K-Pop"
                                    },
                                    {
                                        active: true,
                                        title: "Country"
                                    },
                                    {
                                        active: false,
                                        title: "Amb"
                                    },
                                    {
                                        active: false,
                                        title: "K-Pop"
                                    },
                                    {
                                        active: false,
                                        title: "Singer-Songwriter"
                                    }
                                ],
                                audioFile: "/audio/testfile.mp3"
                            },
                            {
                                id: 13,
                                coverImg: "https://via.placeholder.com/55x55",
                                isNew: true,
                                title: "Malibu",
                                singer: "by Mvrio",
                                genres: [
                                    {
                                        active: false,
                                        title: "Fol"
                                    },
                                    {
                                        active: false,
                                        title: "Singer-Songwriter"
                                    }
                                ],
                                audioFile: "/audio/testfile.mp3"
                            },
                            {
                                id: 24,
                                coverImg: "https://via.placeholder.com/55x55",
                                isNew: true,
                                title: "Sky Red_breathe-no bac...",
                                singer: "by Ant Chamberlain",
                                genres: [
                                    {
                                        active: true,
                                        title: "Reggae"
                                    },
                                    {
                                        active: true,
                                        title: "R&B"
                                    },
                                    {
                                        active: false,
                                        title: "Amb"
                                    },
                                    {
                                        active: false,
                                        title: "Fol"
                                    },
                                    {
                                        active: false,
                                        title: "Singer-Songwriter"
                                    }
                                ],
                                audioFile: "/audio/testfile.mp3"
                            }
                        ]
                    },
                    {
                        id: 2,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "EMOTIONS",
                        singer: "by Mvrio",
                        genres: [
                            {
                                active: true,
                                title: "Acoustic Folk"
                            },
                            {
                                active: true,
                                title: "Electronic"
                            },
                            {
                                active: false,
                                title: "Amb"
                            },
                            {
                                active: false,
                                title: "Fol"
                            },
                            {
                                active: false,
                                title: "Singer-Songwriter"
                            }
                        ],
                        audioFile: "/audio/testfile.mp3",
                        subPlayList: []
                    },
                    {
                        id: 3,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "Aishiteru (Dean Lo-Fi Inst...",
                        singer: "by Roko Tensei",
                        genres: [
                            {
                                active: true,
                                title: "Hip Hop"
                            },
                            {
                                active: false,
                                title: "Jaz"
                            },
                            {
                                active: false,
                                title: "Amb"
                            },
                            {
                                active: false,
                                title: "Fol"
                            },
                            {
                                active: false,
                                title: "World"
                            }
                        ],
                        audioFile: "/audio/testfile.mp3",
                        subPlayList: []
                    },
                    {
                        id: 4,
                        coverImg: "https://via.placeholder.com/55x55",
                        isNew: true,
                        title: "Sad Acoustic Guitar",
                        singer: "Ryini Beats",
                        genres: [
                            {
                                active: true,
                                title: "Acoustic Folk"
                            },
                            {
                                active: false,
                                title: "Jaz"
                            },
                            {
                                active: false,
                                title: "Free Beats"
                            }
                        ],
                        audioFile: "/audio/testfile.mp3",
                        subPlayList: []
                    }
                ],
            }
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
        },
        methods: {
        },

    }

</script>

<style scoped="scoped">

</style>
