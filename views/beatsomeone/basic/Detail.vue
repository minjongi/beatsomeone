<template>

    <div class="wrapper">
        <Header/>
        <div class="container detail">
            <div class="detail__header">
                <div class="wrap">
                    <div class="detail__music">
                        <div class="detail__music-img">
                            <img v-if="item" :src="'/uploads/cmallitem/' + item.cit_file_1" alt=""/>
                        </div>
                        <div class="detail__music-info" >
                            <h2 class="title" v-if="item">{{ item.cit_name }}</h2>
                            <p class="singer" v-if="meta">{{ meta.info_content_3 }}</p>
                            <div class="state" v-if="item">
                                <span class="play">{{ item.cit_hit }}</span>
                                <span class="song">120</span>
                                <span class="registed">{{ releaseDt }}</span>
                                <span class="etc">{{ item.cit_summary }}</span>
                            </div>
                            <div class="utils" v-if="item">
                                <div class="utils__info">
                                    <a href="" class="buy"><span>{{ item.cit_price }}&#8361;</span></a>
                                    <span class="cart">700</span>
                                    <span class="talk">412</span>
                                    <span class="share">179</span>
                                    <span class="atob">91</span>
                                </div>
                                <div class="category" v-if="meta">
                                    <span v-for="genre in listGenre" :key="genre" :class="{'active' : meta.info_content_1 === genre }">{{ genre }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail__player">
                        <button class="detail__player-controller"></button>
                        <div id="detail__player-wave">
                            <!-- wave 들어가는 부분-->
                        </div>
                    </div>
                    <div class="detail__comment">
                        <form action="">
                            <div class="comment">
                                <a href="" class="comment__user"></a>
                                <input
                                        type="text"
                                        placeholder="Write a comment..."
                                        id="comment"
                                        max="200"
                                        v-model="comment"
                                />
                                <span id="commentLength">{{ comment ? comment.length : '0' }}/200</span>
                                <button @click="sendComment">SEND</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="detail__body">
                <div class="wrap">
                    <div class="tab">
                        <button v-for="t in tabs" :key="t" :class="{active: t === currentTab }" @click="selectTab(t)">{{ t }}</button>
                    </div>

                    <div class="detail__content">
                        <Detail_SimilarTracks v-if="currentTab === tabs[0]"/>
                        <Detail_Comments v-if="currentTab === tabs[1]" />
                        <Detail_Infomation v-if="currentTab === tabs[2]" />
                    </div>


                </div>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>

    require('@/js/function');
    import Header from "./include/Header";
    import Footer from "./include/Footer";
    import Detail_SimilarTracks from "./Detail_SimilarTracks";
    import Detail_Comments from "./Detail_Comments";
    import Detail_Infomation from "./Detail_Infomation";
    import $ from "jquery";


    export default {
        components: {Header,Footer,Detail_SimilarTracks,Detail_Comments,Detail_Infomation},
        data: function() {
            return {
                item: null,
                meta : null,
                detail : null,
                comment: null,
                music: null,
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
                        audioFile: "/dist/audio/testfile.mp3",
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
                                audioFile: "/dist/audio/testfile.mp3"
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
                                audioFile: "/dist/audio/testfile.mp3"
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
                                audioFile: "/dist/audio/testfile.mp3"
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
                        audioFile: "/dist/audio/testfile.mp3",
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
                        audioFile: "/dist/audio/testfile.mp3",
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
                        audioFile: "/dist/audio/testfile.mp3",
                        subPlayList: []
                    }
                ],
                listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                tabs: ['SIMILAR TRACKS','COMMENTS','INFORMATION'],
                currentTab: 'SIMILAR TRACKS',
            }
        },
        computed: {
            releaseDt: function() {
                if(!this.item) return null;
                const t = new Date(Date.parse(this.item.cit_datetime));

                return `${t.getMonth()} / ${t.getFullYear()}`;
            }
        },
        mounted() {

            const playbtn = document.querySelector(".detail__player-controller");
            this.music = window.WaveSurfer.create({
                container: document.querySelector("#detail__player-wave"),
                waveColor: "#696969",
                progressColor: "#c3ac45",
                hideScrollbar: true,
                barWidth: 5,
                barRadius: 2,
                barGap: 2,
                height: 200
            });

            this.music.on("play", () => {
                playbtn.classList.add("playing");
            });
            this.music.on("pause", () => {
                playbtn.classList.remove("playing");
            });
            playbtn.addEventListener("click", () => {
                this.music.playPause();
            });

        },
        watch: {
            detail : function(n){
                if(n) {
                    this.music.load(`/cmallact/download_sample/${n[0].cde_id}`);
                }

            },
        },
        methods: {
            // 탭 선택
            selectTab(t) {
                this.currentTab = t;
            },
            // 코멘트 입력
            sendComment() {
                // 코멘트 저장

                // 초기화
                this.comment = null;
            },
        },

    }


</script>

<style lang="scss">
    @import './../../../assets/scss/App.scss';


</style>

<style lang="css">
    @import './../../../assets/plugins/slick/slick.css';
    @import './../../../assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>
