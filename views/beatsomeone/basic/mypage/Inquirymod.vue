<template>
    <div>
        <div class="row">
            <div class="row" style="margin-bottom:30px;">
                <div class="title-content">
                    <div class="title">
                        <div>{{$t('support1')}}</div>
                        <button class="btn btn--gray">{{$t('back')}}</button>
                    </div>
                </div>
            </div>

            <div class="box" style="padding-bottom:50px;">
                <div class="row">
                    <div class="type"><span>Title</span></div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" type="text" placeholder="Please enter your title about problem..." />
                        </div>
                    </div>
                </div>

                <div class="row" v-show="group_title == 'SELLER'">
                    <div class="type"><span>Writer</span></div>
                    <div class="data">
                        <div class="group_title" :class="group_title">{{$t(group_title)}}</div>
                        <div class="seller_class" :class="seller_class">{{seller_class}}</div>
                        <div class="username">KKOMA</div>
                    </div>
                </div>

                <div class="row">
                    <div class="type"><span>Bio</span></div>
                    <div class="data">
                        <textarea class="firstname" type="text" placeholder="Please decribe your problem detaily..." style="height:360px"/>
                    </div>
                </div>

                <div class="row" v-show="group_title == 'SELLER'">
                    <div class="type"><span>Attachment</span></div>
                    <div class="data">
                        <div>
                            <div class="flie_list">
                                <div>
                                    <span>No attached file.</span>
                                </div>
                                <div>
                                    <img src="/assets/images/icon/file.png"/>
                                    <span>musicsong1.mp3</span>
                                    <img src="/assets/images/icon/delete.png"/>
                                </div>
                            </div>
                            <div class="caution">
                                <div>
                                    <img class="caution" src="/assets/images/icon/caution.png"/>
                                    <img class="warning" src="/assets/images/icon/warning.png"/>
                                </div>
                                <span>
                                    {{$t('noteChangeEmailMsg')}}
                                </span>
                            </div>
                        </div>
                        <label class="btn btn--blue" for="attachbtn">
                            <input type="file" id="attachbtn" style="display:none;">
                            <div>Attach</div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                <button class="btn btn--gray">Cancel</button>
                <button type="submit" class="btn btn--submit">Submit</button>
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
                seller_class: 'MARKET PLACE',
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
        }
    }
</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>