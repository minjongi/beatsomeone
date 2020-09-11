<template>
    <div class="sublist__content" style="margin-bottom:100px;">
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>{{$t('support1')}}</div>
                    <button class="btn btn--submit" @click="goInquiryenroll">To ask question</button>
                </div>
                <p>
                    Total <span>100</span> cases.
                </p>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab nowrap">
                    <div class="index">No</div>
                    <div class="subject">Title</div>
                    <div class="date">Date</div>
                    <div class="action">Status</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board inquirylist">

                <ul>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action">
                                Answer Complete
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action">
                                Answer Complete
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action">
                                Answer Complete
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="goInquiryview">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">000</div>
                            <div class="subject">I have some question about using service.</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="action active">
                                Wait...
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="pagination">
                <div>
                    <button class="prev active"><img src="/assets/images/icon/chevron_prev.png"/></button>
                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button>4</button>
                    <button>5</button>
                    <button>6</button>
                    <button>7</button>
                    <button>8</button>
                    <button>9</button>
                    <button>10</button>
                    <button class="next active"><img src="/assets/images/icon/chevron_next.png"/></button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="sort" style="display:flex; width:50%; margin:auto; flex-flow:row nowrap">
                <div class="custom-select">
                    <button class="selected-option">
                        Total
                    </button>
                    <div class="options">
                        <button data-value="" class="option"> Title </button>
                        <button data-value="" class="option"> Content </button>
                    </div>
                </div>
                <div class="input_wrap line" style="margin-left:20px; width:100%;">
                    <input type="text" :placeholder="$t('enterYourSearchword')">
                    <button><img src="/assets/images/icon/searchicon.png"/></button>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import $ from "jquery"

    export default {
        components: {
        },
        data: function() {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                myProduct_list: [],
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