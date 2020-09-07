<template>
    <div class="sublist__content">

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div class="active">Settlement<br>Status (123)</div>
                    <div @click="goPage('seller#/sellerbill')">Settlement<br>Complete (32)</div>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="n-flex between filter">
                    <div class="condition active" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">All</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">3 months</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">6 months</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 4 }" @click="setSearchCondition(4)">1 year</div>
                </div>
            </div>
        </div>

        <!-- <div style="margin-left:auto; ">
            <div>
                <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
                    <input type="date" :placeholder="$t('startDate')" />
                    <span>─</span>
                    <input type="date" :placeholder="$t('endDate')" />
                    <button><img src="/assets/images/icon/calendar-white.png" /></button>
                </div>
            </div>
        </div> -->
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

        <div class="row" style="margin-bottom: 10px;">
            <div class="sort">
                <div class="bs-select" style="flex: 3;">
                    <button class="selected-option"> All </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcDownType('All')"> All </button>
                        <button data-value="" class="option" @click="funcDownType('Download Complete')"> Download Complete </button>
                        <button data-value="" class="option" @click="funcDownType('Not Downloaded')"> Not Downloaded </button>
                    </div>
                </div>

                <div class="bs-select" style="flex: 2;">
                    <button class="selected-option"> Recent </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcOrderType('Recent')"> Recent </button>
                        <button data-value="" class="option" @click="funcOrderType('Past')"> Past </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                <button class="btn btn--green" style="display: flex;height: 40px;justify-content: center;align-items: center;" @click="goDelete"><img src="/assets/images/icon/excel.png" style="margin-top:-4px;" />Download as Excel</button>
            </div>

            <div class="title-content">
                <div class="title"></div>
                <p style="line-height: 1.2;">- The search period is based on the date and time of purchase. </p>
                <p style="margin-top: 5px; line-height: 1.2;">- You can see not only the amount of sales, but also the amount of settlement that has occurred.</p>
            </div>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="playList board mybillinglist saleshistory">

                <ul>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="n-flex between">
                                <div class="index">Order_010</div>
                                <div class="date"> 0000-00-00 00:00:00 </div>
                            </div>
                            <div class="n-flex none">
                                <div class="col name" style="width: 32px; margin-right: 16px;">
                                    <figure>
                                        <span class="playList__cover">
                                            <img class="cover" src="/assets/images/cover_default.png" alt="">
                                            <i ng-if="item.isNew" class="label new">N</i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="subject">
                                    <p>The Flow Buy 1 Get 3 F</p>
                                    <p>(HipHop / 108Bpm)</p>
                                </div>
                            </div>
                            <div class="n-flex">
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="red">Refund Complete</span>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="green">Stay</span>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="n-flex between">
                                <div class="index">Order_010</div>
                                <div class="date"> 0000-00-00 00:00:00 </div>
                            </div>
                            <div class="n-flex none">
                                <div class="col name" style="width: 32px; margin-right: 16px;">
                                    <figure>
                                        <span class="playList__cover">
                                            <img class="cover" src="/assets/images/cover_default.png" alt="">
                                            <i ng-if="item.isNew" class="label new">N</i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="subject">
                                    <p>The Flow Buy 1 Get 3 F</p>
                                    <p>(HipHop / 108Bpm)</p>
                                </div>
                            </div>
                            <div class="n-flex">
                                <div style="flex: 1;">
                                    <div class="status">
                                        <div class="blue">Order Complete</div>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="green">Stay</span>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="n-flex between">
                                <div class="index">Order_010</div>
                                <div class="date"> 0000-00-00 00:00:00 </div>
                            </div>
                            <div class="n-flex none">
                                <div class="col name" style="width: 32px; margin-right: 16px;">
                                    <figure>
                                        <span class="playList__cover">
                                            <img class="cover" src="/assets/images/cover_default.png" alt="">
                                            <i ng-if="item.isNew" class="label new">N</i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="subject">
                                    <p>The Flow Buy 1 Get 3 F</p>
                                    <p>(HipHop / 108Bpm)</p>
                                </div>
                            </div>
                            <div class="n-flex">
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="red">Refund Complete</span>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="green">Stay</span>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="n-flex between">
                                <div class="index">Order_010</div>
                                <div class="date"> 0000-00-00 00:00:00 </div>
                            </div>
                            <div class="n-flex none">
                                <div class="col name" style="width: 32px; margin-right: 16px;">
                                    <figure>
                                        <span class="playList__cover">
                                            <img class="cover" src="/assets/images/cover_default.png" alt="">
                                            <i ng-if="item.isNew" class="label new">N</i>
                                        </span>
                                    </figure>
                                </div>
                                <div class="subject">
                                    <p>The Flow Buy 1 Get 3 F</p>
                                    <p>(HipHop / 108Bpm)</p>
                                </div>
                            </div>
                            <div class="n-flex">
                                <div style="flex: 1;">
                                    <div class="status">
                                        <div class="blue">Order Complete</div>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                                <div style="flex: 1;">
                                    <div class="status">
                                        <span class="green">Stay</span>
                                    </div>
                                    <div class="totalprice">$ 10.00</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <!-- Paganation -->
        <div class="row">
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


        <div class="row">
            <div class="payment_box">
                <div class="n-box">
                    <h4 class="title big">Settlement detail</h4>

                    <div>
                        <div class="n-flex between">
                            <span>
                                Total rental (VAT included)
                                <img src="/assets_m/images/icon/info.png"/>
                            </span>
                            <span>$ 120.00</span>
                        </div>
                        <div class="n-flex between">
                            <span class="subtitle">- Rent amount<img src="/assets_m/images/icon/info.png"/></span>
                            <span>200</span>
                        </div>
                        <div class="n-flex between">
                            <span>Total sales (VAT included)<img src="/assets_m/images/icon/info.png"/></span>
                            <span>$ 120.00</span>
                        </div>
                        <div class="n-flex between">
                            <span class="subtitle">- Sales amount<img src="/assets_m/images/icon/info.png"/></span>
                            <span>300</span>
                        </div>
                    </div>

                    <div>
                        <div class="n-flex between">
                            <span>Order total (VAT Included)<img src="/assets_m/images/icon/info.png"/></span>
                            <span>$ 440.00</span>
                        </div>

                        <div class="n-flex between">
                            <span>VAT (10%)</span>
                            <span class="red">- $ 40.00</span>
                        </div>
                    </div>

                    <div>
                        <div class="n-flex between">
                            <span>Settlement<img src="/assets_m/images/icon/info.png"/></span>
                            <span>$ 400.00</span>
                        </div>
                        <div class="n-flex between">
                            <span>Fee (10%)<img src="/assets_m/images/icon/info.png"/></span>
                            <span class="red">- $ 40.00</span>
                        </div>
                    </div>

                    <div class="n-flex between large">
                        <span>Total settlement</span>
                        <span class="blue">$ 365.00</span>
                    </div>
                </div>

                <div class="n-box" style="margin-top: 1px;">
                    <h4 class="title">Help</h4>
                    <ul class="text">
                        <li>
                            <strong>Total rental: </strong>It means the total purchase amount of the bit registered by the seller with the 'Rental' option. <span class="red">(At this time, the total is calculated as VAT included.)</span>
                        </li>
                        <li>
                            <strong>Rental amount: </strong>It refers to the number of bit purchases registered with the 'Rental' option.
                        </li>
                        <li>
                            <strong>Total Sales: </strong>It refers to the total purchase amount of the bits registered by the seller with the ‘Sale’ option. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                        </li>
                        <li>
                            <strong>Sales volume: </strong>It means the number of purchases of the bit registered with the ‘Sale’ option.
                        </li>
                        <li>
                            <strong>Total purchase: </strong>Total sum of rentals and total sales. <span class="red">(In this case, the total is calculated as VAT included.)</span>
                        </li>
                        <li>
                            <strong>Settlement Amount: </strong>Total purchase price minus VAT.
                        </li>
                        <li>
                            <strong>Fee: </strong>A portion of the fee is deducted based on the settlement amount.
                        </li>
                        <li>
                            <strong>Total settlement: </strong>The amount of the settlement amount minus the fee.
                        </li>
                    </ul>
                </div>

            </div>
            <div class="title-content">
                <p>
                    - Settlement will be made on the <strong>10th of the following month</strong> based on the downloaded items from the 1st to the last day.<br/>
                    - If the user did not proceed with the download after purchase, <strong>both rentals and sales are included in the settlement details <span>after 60 days from the purchase date</span></strong>.
                </p>
            </div>
        </div>
        <div style="margin-top: 30px;">
            <button class="btn btn--gray"> {{$t('backToList')}} </button>
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
                popup_filter:0,
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

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .sub .sublist .row {
        margin-bottom: 0;
    }
    .sub .sublist .tab {
        align-items: center;
        background-color: #2B2C30;
        border-bottom: none;
        >div {
            flex: 1;
            text-align: center;
            font-size: 12px;
            line-height: 14px;
            color: rgb(white,.7);
            padding: 0 20px;
            &.active {
                color: #ffda2a;
            }
        }
    }
    .sub .playList .playList__item .index {
        color: rgba(white,.7);
    }
    .sublist .sort {
        >div {
            +div {
                margin-left: 10px;
            }
        }
    }
    .playList .playList__item {
        display: block;
    }
    .sub .playList .playList__item {
        .status {
            font-weight: 600;
        }
        .download {
            >div {
                font-size: 12px;
            }
        }
    }
    .sub .search.condition {
        width: 100%;
        .filter {
            display: flex;
        }
    }
    .playList .playList__item {
        .name {
            figure .playList__cover {
                width: 32px;
                height: 32px;
                img {
                    width: 100%;
                }
            }
        }
        .subject {
            font-weight: normal;
            line-height: 16px;
        }
    }
    .sub .playList .playList__item .subject {
        font-weight: normal;
    }


    .payment_box {
        .title {
            line-height: 19px;
            padding-bottom: 20px;
            margin-bottom: 20px;
            font-size: 16px;
            border-bottom: 1px solid rgba(white,.3);
        }
        .n-box {
            >div {
                +div {
                    border-top: 1px solid rgba(white,.3);
                    padding-top: 20px;
                }
            }
            .n-flex {
                span {
                    font-size: 12px;
                    line-height: 14px;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    img {
                        width: 16px;
                        height: 16px;
                        margin-left: 4px;
                    }
                }
                .subtitle {
                    font-weight: normal;
                    color: rgba(white,.7);
                }
                &+.n-flex {
                    margin-top: 20px;
                }
                &.large {
                    span {
                        font-size: 14px;
                        line-height: 16px;
                    }
                }
            }
            ul.text {
                font-size: 12px;
                li {
                    line-height: 1.6;
                    +li {
                        margin-top: 20px;
                    }
                }
            }
        }
    }
</style>