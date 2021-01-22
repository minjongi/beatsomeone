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
                        <header class="main__section1-title" style="margin-bottom:-80px;"></header>
                        <div class="videolist">
                            <div class="head">
                                <div class="block" @click="govideoview">
                                    <div style="padding-bottom:66.666666%;">
                                        <img src="https://images.unsplash.com/photo-1522536421511-14c9073df899?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1471565661762-b9dfae862dbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1529518969858-8baa65152fc8?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/flagged/photo-1568967010765-40b6ec2b5fa5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1581503589702-b21c6a3f0879?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1577205341591-846f4dfe6d8c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1368&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1560258629-d26e9fa12ae3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="title">[비트썸바디] 비트메이커 KKOMA 인터뷰</div>
                                        <div class="desc">
                                            Beat someone에서 만난 비트메이커 KKOMA!<br/>
                                            그의 비트에 대한 철학과 아끼는 비트 BEST 3를 만나보세요.
                                        </div>
                                    </div>
                                </div>
                                <div class="block" @click="govideoview">
                                    <div>
                                        <img src="https://images.unsplash.com/photo-1525439979024-1df959dde396?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1353&q=80"/>
                                        <div class="play">
                                            <img src="/assets/images/icon/hover_play.png">
                                        </div>
                                    </div>
                                    <div>
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
    require('@/assets/js/function')

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    //import MainPlayer from "@/vue/common/MainPlayer";
    import WaveSurfer from 'wavesurfer.js';

    export default {
        components: {
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
            govideoview() {
                this.$router.push({path: '/videoview'});
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>