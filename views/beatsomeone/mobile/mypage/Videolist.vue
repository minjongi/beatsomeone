<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <main-player></main-player>
        <div class="container">
            <div class="main">
                <section class="main__section1">
                    <div class="BG" style="background-image:url('https://images.unsplash.com/photo-1559060680-36abfac01944?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <!-- <header class="main__section1-title"></header> -->
                        <div class="videolist">
                            <div class="head">
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1522536421511-14c9073df899?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1471565661762-b9dfae862dbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1529518969858-8baa65152fc8?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/flagged/photo-1568967010765-40b6ec2b5fa5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1581503589702-b21c6a3f0879?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1577205341591-846f4dfe6d8c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1368&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1560258629-d26e9fa12ae3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1525439979024-1df959dde396?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1353&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div class="text">
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
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
    require('@/assets_m/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"

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