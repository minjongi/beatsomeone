<template>
    <div class="sublist__content" style="margin-bottom:100px;">
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>FAQ</div>
                </div>
                <div class="input_wrap line round" style="width:50%; margin:0 auto; padding:10px 20px;">
                    <input type="text" placeholder="enter your word..." style="font-size:16px;">
                    <img src="/assets/images/icon/searchicon.png" style="margin:10px;"/>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board fold faq">
                <ul>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap ">
                            <div>
                                <div class="subject">What information do I need to sell music?</div>
                                <div class="answer fold">
                                    When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                    If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                     BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                     <br/>
                                    After the changes have been made, the rights for sale will be opened.<br/>
                                    From this point on, you can sell the beats you have made.<br/>
                                </div>
                            </div>
                            <div class="btn--fold"><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap ">
                            <div>
                                <div class="subject">What information do I need to sell music?</div>
                                <div class="answer fold">
                                    When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                    If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                     BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                     <br/>
                                    After the changes have been made, the rights for sale will be opened.<br/>
                                    From this point on, you can sell the beats you have made.<br/>
                                </div>
                            </div>
                            <div class="btn--fold"><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div>
                                <div class="subject">What information do I need to sell music?</div>
                                <div class="answer fold">
                                    When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                    If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                     BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                     <br/>
                                    After the changes have been made, the rights for sale will be opened.<br/>
                                    From this point on, you can sell the beats you have made.<br/>
                                </div>
                            </div>
                            <div class="btn--fold"><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap ">
                            <div>
                                <div class="subject">What information do I need to sell music?</div>
                                <div class="answer fold">
                                    When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                    If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                     BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                     <br/>
                                    After the changes have been made, the rights for sale will be opened.<br/>
                                    From this point on, you can sell the beats you have made.<br/>
                                </div>
                            </div>
                            <div class="btn--fold"><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap ">
                            <div>
                                <div class="subject">What information do I need to sell music?</div>
                                <div class="answer fold">
                                    When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                    If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                     BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                     <br/>
                                    After the changes have been made, the rights for sale will be opened.<br/>
                                    From this point on, you can sell the beats you have made.<br/>
                                </div>
                            </div>
                            <div class="btn--fold"><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap ">
                            <div>
                                <div class="subject">What information do I need to sell music?</div>
                                <div class="answer fold">
                                    When selling a sound source (beat), it is necessary to change the authority to the seller first.<br/>
                                    If you are a current general member, please go through <span>My Page > Seller Registration</span> to change the permission first.<br/>
                                     BitSumOne will review the seller member's information and proceed to change the seller member authority.<br/>
                                     <br/>
                                    After the changes have been made, the rights for sale will be opened.<br/>
                                    From this point on, you can sell the beats you have made.<br/>
                                </div>
                            </div>
                            <div class="btn--fold"><div></div><div></div></div>
                        </div>
                    </li>
                </ul>
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
        },
        methods:{
        }
    }
</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>