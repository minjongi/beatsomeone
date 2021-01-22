<template>
    <div class="wrapper">
        <div class="container">
            <div class="main">
                <section class="main__section1">
                    <div class="wrap">
                        <div class="videolist">
                            <div class="head">
                                <div class="block" v-if="posts.length > 0">
                                    <div @click="$router.push('/' + posts[0].post_id)">
                                        <img :src="posts[0].thumb_url"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <router-link :to="posts[0].post_id">
                                        <div class="text">
                                            <div class="title">{{ posts[0].post_title }}</div>
                                            <div v-html="posts[0].post_content" class="desc" style="text-overflow: ellipsis;">
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                                <template v-if="posts.length > 1">
                                    <div class="block" v-for="(post, index) in posts" v-bind:key="post.post_id" v-if="index > 0">
                                        <div @click="$router.push('/' + post.post_id)">
                                            <img :src="post.thumb_url" />
                                            <div class="play">
                                                <img src="/assets/images/icon/hover_play.png">
                                            </div>
                                        </div>
                                        <router-link :to="post.post_id">
                                            <div class="text">
                                                <div class="title">{{ post.post_title }}</div>
                                                <div v-html="post.post_content" class="desc">
                                                </div>
                                            </div>
                                        </router-link>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>


<script>
    import axios from "axios";

    require('@/assets_m/js/function')
    import Header from "./include/Header"
    import Footer from "./include/Footer"

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    //import MainPlayer from "@/vue/common/MainPlayer";
    import WaveSurfer from 'wavesurfer.js';

    export default {
        components: {
            // Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                popup_filter:0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
                posts: []
            };
        },
        mounted(){
                        // 커스텀 셀렉트 옵션
            $(".bs-select").on("click", function() {

                $(this)
                    .siblings(".bs-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this)
                    .find(".options")
                    .toggle();
            });

            axios.get('/board/ajax/video')
                .then(res => res.data)
                .then(data => {
                    this.posts = data.data.list;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        created() {
                Http.get('/beatsomeoneApi/get_user_regist_item_list').then(r => {
                    console.log(r.data);
                    this.myProduct_list = r.data;
                });
        },
        methods:{
            goPage: function(page){
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/'+page);
            },
            calcSeq: function(size, i){
                return parseInt(size) - parseInt(i);
            },
            formatCitName: function(data){
                var rst;
                var limitLth = 50
                if(limitLth < data.length && data.length <= limitLth*2){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2);
                }else if(limitLth < data.length && limitLth*2 < data.length){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2) + '...';
                }else{
                    rst = data
                }
                return rst;
            },
            productEditBtn: function(key){
                console.log("productEditBtn:" +key);
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/detail/'+key);
            },
            playAudio(i) {
                this.wavesurfer = WaveSurfer.create({
                    container: document.querySelector('#waveform'),
                });
                // https://nachwon.github.io/waveform/
                this.wavesurfer.load('https://beatsomeone.com/uploads/cmallitemdetail/2020/04/cb40bdf9165462c6351ebd82abedb1d6.mp3');
                this.wavesurfer.on('ready', this.start);
            },
            start(){
                this.wavesurfer.play();
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets_m/scss/App.scss';

    .desc {
        p {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    }
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .main {
        .main__section1 {
            min-height: 60vh;
            background: linear-gradient(0deg, black 0%, rgba(0, 0, 0, 0.25) 75%), url("/assets/images/bg2.jpg") no-repeat;
            background-size: contain;
            padding-top: 40px;
        }
    }

    .main .filter {
        height: 300px;
    }

    .block {
        width: 50%;
        padding-right: 8px;
        padding-left: 8px;
        margin-bottom: 10px;
        >div {
            position: relative;
            .play {
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -12px;
                margin-left: -12px;
                img {
                    width: 24px;
                }
            }
        }
        .text {
            padding: 12px 4px;
            .title {
                font-size: 14px;
                font-weight: 600;
                color: white;
                overflow: hidden;
                height: 18px;
                line-height: 18px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                margin-bottom: 10px;
            }
            .desc {
                font-size: 12px;
                font-weight: normal;
                color: rgba(white,.7);
                line-height: 15px;
                height: 30px;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
    }
    .videolist {
        >div {
            display: flex;
            flex-wrap: wrap;
            margin-right: -8px;
            margin-left: -8px;
        }
    }
    .head {
        .block {
            &:first-child {
                width: 100%;
            }
        }
    }
    .body {
        .block {

        }
    }
</style>