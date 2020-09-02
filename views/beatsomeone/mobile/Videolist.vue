<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container">
            <div class="main">
                <section class="main__section1">
                    <div class="BG" style="background-image:url('https://images.unsplash.com/photo-1559060680-36abfac01944?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <!-- <header class="main__section1-title"></header> -->
                        <div class="videolist">
                            <div class="head">
                                <div class="block" v-if="posts.length > 0">
                                    <div>
                                        <img :src="posts[0].thumb_url"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <router-link :to="posts[0].post_id">
                                        <div class="text">
                                            <div class="title">{{ posts[0].post_title }}</div>
                                            <div v-html="posts[0].post_content" class="desc">
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                                <template v-if="posts.length > 1">
                                    <div class="block" v-for="(post, index) in posts" v-bind:key="post.post_id" v-if="index > 0">
                                        <div>
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
                    <Footer></Footer>
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
            $(".custom-select").on("click", function() {

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
                window.location.href = '/mypage/'+page;
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
                window.location.href = 'http://dev.beatsomeone.com/beatsomeone/detail/'+key;
            },
            playAudio(i) {
                this.wavesurfer = WaveSurfer.create({
                    container: document.querySelector('#waveform'),
                });
                // https://nachwon.github.io/waveform/
                this.wavesurfer.load('http://dev.beatsomeone.com/uploads/cmallitemdetail/2020/04/cb40bdf9165462c6351ebd82abedb1d6.mp3');
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
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .main .filter {
        height: 64px;
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