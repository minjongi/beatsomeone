<template>
    <div class="sublist__content">
        <div class="row">
            <div class="row" style="margin-bottom:30px;">
                <div class="title-content">
                    <div class="title">
                        <div>{{$t('support1')}}</div>
                        <button class="btn btn--gray">{{$t('back')}}</button>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:30px;">
                <div class="content-header">
                    <div>
                        <div>
                            <div class="category">Title</div>
                            <div class="body">testestestestestestestestesteststestesttestestestestsest</div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <div class="category">Status</div>
                            <div class="body action active">Wait...</div>
                        </div>
                        <div>
                            <div class="category">Date</div>
                            <div class="body">0000-00-00 00:00:00</div>
                        </div>
                    </div>
                    <div>
                        <div class="category">Attachment</div>
                        <div class="flie_list">
                            <button class="btn--file">
                                <img src="/assets/images/icon/file.png"/>
                                <span>musicsong1.mp3</span>
                            </button>
                            <button class="btn--file">
                                <img src="/assets/images/icon/file.png"/>
                                <span>musicsong2.mp3</span>
                            </button>
                            <button class="btn--file">
                                <img src="/assets/images/icon/file.png"/>
                                <span>musicsong3.mp3</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:30px;">
                <div class="playList array inquiryview">

                    <ul>
                        <li class="playList__itembox">
                            <div class="playList__item playList__item--title nowrap question stay">
                                <div class="row">
                                    <div class="mark">Q</div>
                                    <div class="answer">
                                        When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                        If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                         BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                         <br/>
                                        After the changes have been made, the rights for sale will be opened.<br/>
                                        From this point on, you can sell the beats you have made.<br/>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="playList__itembox">
                            <div class="playList__item playList__item--title nowrap question">
                                <div class="row">
                                    <div class="mark"></div>
                                    <div class="answer">
                                        Hi, KKOMA<br/>
                                        We will respond to you after checking the contents.<br/>
                                        <br/>
                                        Beat someone Team.
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="playList__itembox">
                            <div class="playList__item playList__item--title nowrap question complete">
                                <div class="row">
                                    <div class="mark">A</div>
                                    <div class="answer">
                                        Hi, KKOMA<br/>
                                        We fixed an error after checking the file.<br/>
                                        It may be cumbersome, but please upload it again.<br/>
                                        <br/>
                                        Beat someone Team.
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                <button class="btn btn--gray" @clikc="goInquiryenroll">Cancel</button>
                <button type="submit" class="btn btn--submit" @click="goInquirymod">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";

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
        },
        created() {
        },
        methods:{
            goInquiryview() {
                this.$router.push({path: '/inquiryview'});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
            goInquiryenroll() {
                this.$router.push({path: '/inquiryenroll'});
            },
        },
    }
</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>