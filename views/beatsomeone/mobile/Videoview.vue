<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container">
            <div class="main">
                <div class="filter"></div>
                <div class="wrap videolist">
                    <div class="videoview">
                        <div class="title">{{ post.post_title}}</div>
                        <div class="desc" v-html="post.post_content">
                        </div>
                    </div>
                    <div class="block">
                        <div>
                            <iframe class="video" style="height: 250px;" v-for="link in links" :key="link.post_id" :src="link.pln_url">
                            </iframe>
                        </div>
                    </div>
                    <div class="sns-box">
                        <div class="iconbtnbox">
                            <button @click="copyUrl"><img src="/assets/images/icon/share.png"/></button>
                            <button @click="sendSnsVue('facebook')"><img src="/assets/images/icon/fb.png"/></button>
                            <button @click="sendSnsVue('twitter')"><img src="/assets/images/icon/tw.png"/></button>
                        </div>
                        <div class="iconbtnbox">
                            <button @click="goPage('/')"><img src="/assets/images/icon/list.png"/></button>
                        </div>
                    </div>
                </div>
                <Footer></Footer>
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
    import WaveSurfer from '../../../node_modules/wavesurfer.js/dist/wavesurfer';

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
                post: {},
                links: [],
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

            const post_id = this.$route.params.id;
            axios.get(`/post/ajax/${post_id}`)
                .then(res => res.data)
                .then(data => {
                    this.links = data.links;
                    this.links.forEach(link => {
                        if (link.pln_url.includes('youtu.be')) {
                            link.pln_url = link.pln_url.replace('youtu.be', 'www.youtube.com/embed');
                        }
                    });
                    this.post = data.post;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        created() {
                Http.get('/beatsomeoneApi/get_user_regist_item_list').then(r => {
                    console.log(r.data);
                    this.myProduct_list = r.data;
                });
        },
        methods:{
            goPage: function(page){
                this.$router.push(page);
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
                window.location.href = 'https://beatsomeone.com/detail/'+key;
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
            sendSnsVue(sns) {
                let currentUrl = window.location.href;
                window.sendSns(sns, currentUrl, this.post.post_title);
            },
            copyUrl() {
                let currentUrl = window.location.href;
                this.$copyText(currentUrl).then(function (e) {
                    alert('링크가 복사 되었습니다.');
                }, function (e) {
                    alert('Can not copy');
                })
            }
        }
    }
</script>


<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '../../../assets/plugins/slick/slick.css';
    @import '../../../assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    .main .filter {
        height: 64px;
    }
    .videoview {
        padding: 12px 4px;
        .title {
            font-size: 14px;
            font-weight: 600;
            color: white;
            line-height: 18px;
            word-break: break-all;
            margin-bottom: 10px;
        }
        .desc {
            font-size: 12px;
            font-weight: normal;
            color: rgba(white,.7);
            line-height: 15px;
            word-break: break-all;
        }
    }
    .sns-box {
        margin-top: 20px;
        text-align: center;
    }
    .iconbtnbox > * {
        padding: 2px;
        width: 32px;
        height: 32px;
    }

    .block .video {
        width: 100%;
    }
</style>