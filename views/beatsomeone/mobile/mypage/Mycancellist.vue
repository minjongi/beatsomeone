<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab n-flex" style="height:48px;">
                    <div @click="goPage('mybilling')">{{$t('orderHistory')}} (123)</div>
                    <div class="active">Cancellation / Refund History(32)</div>
                </div>
            </div>
        </div>


        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="n-flex between filter">
                    <div class="condition active" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">All</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">3 months</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">6 months</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">1 year</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom: 10px;">
            <div>
                <VueHotelDatepicker
                    class="search-date"
                    format="YYYY-MM-DD"
                    :placeholder="$t('startDate') + ' ~ ' + $t('endDate')"
                    :startDate="start_date"
                    :endDate="end_date"
                    minDate="1970-01-01"
                    @update="updateSearchDate"
                    @reset="resetSearchDate"
                />
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="sort">
                <div class="bs-select">
                    <button class="selected-option">
                        Recent
                    </button>
                    <div class="options">
                        <button data-value="" class="option"> Past </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tabmenu">
                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">Total ({{calcTotalCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">Wait ({{calcWaitCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">Complete ({{calcCompleteCnt}})</div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist">

                <ul>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
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
                    <button class="next active"><img src="/assets/images/icon/chevron_next.png"/></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'

    export default {
        components: {
            VueHotelDatepicker
        },
        data: function() {
            return {
                isLogin: false,
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
        },
        created() {
        },
        methods:{
            goPage: function(page){
                window.location.href = '/mypage/'+page;
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
</style>
