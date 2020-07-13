<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div @click="goPage('seller#/sellerlist')">Settlement Status (123)</div>
                    <div class="active">Settlement Complete (32)</div>
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
        </div>

        <div class="row">
            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                    <button class="btn btn--green" style="display: flex;height: 40px; margin-bottom: 10px; justify-content: center;align-items: center;" @click="goDelete"><img src="/assets/images/icon/excel.png" style="margin-top:-4px; margin-right: 4px;" />Download as Excel</button>
                    <button class="btn btn--blue" style="display: flex;height: 40px;justify-content: center;align-items: center;" @click="goDelete"><img src="/assets/images/icon/bank.png" style="margin-top:-4px; margin-right: 4px;" />Account Setting</button>
            </div>
            <div class="title-content">
                <div class="title"></div>
                <p style="line-height: 1.2;">- The settlement amount will be credited to the registered account.</p>
                <p style="margin-top: 5px; line-height: 1.2;">- If the account is not registered, the settlement amount will be credited to the account without additional settlement instructions.</p>
            </div>

        </div>

        <div class="row" style="margin-top:30px;">
            <div class="n-swiper-wrap">
                <ul class="n-swiper">
                    <li>
                        <h4>{{$t('estimatedSettlementAmount')}}</h4>
                        <div class="date">2020-08</div>
                        <div class="num blue">₩ 337,282,172 </div>
                    </li>
                    <li>
                        <h4>Earn to Account</h4>
                        <div class="date">2020-07</div>
                        <div class="num green">₩ 337,282,172 </div>
                    </li>
                    <li>
                        <h4>{{$t('estimatedSettlementAmount')}}</h4>
                        <div class="date">2020-06</div>
                        <div class="num blue">₩ 337,282,172 </div>
                    </li>
                </ul>
                <a class="slidenav-prev" href="#">
                    <img src="/assets_m/images/icon/chevron-left.png" alt="">
                </a>
                <a class="slidenav-next" href="#">
                    <img src="/assets_m/images/icon/chevron-right.png" alt="">
                </a>
                <ul class="">
                    <li><span class="dot active"></span></li>
                    <li><span class="dot"></span></li>
                    <li><span class="dot"></span></li>
                </ul>
            </div>
        </div>

        <div class="row payment-box">
            <h4 class="title">Last Month Settlement Detail</h4>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Total Items</span>
                    <span>10</span>
                </div>
                <div class="n-flex between">
                    <span>Earn to Account</span>
                    <span class="green">7</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement Complete</span>
                    <span class="blue">3</span>
                </div>
            </div>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Order total</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Fee</span>
                    <span class="red">- $ 10.00</span>
                </div>
            </div>
            <div class="n-box total">
                <div class="n-flex between">
                    <span>Profit</span>
                    <span class="blue">$ 396.00</span>
                </div>
            </div>
        </div>

        <div class="row payment-box">
            <h4 class="title"> Today Settlement Detail</h4>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Total Items</span>
                    <span>10</span>
                </div>
                <div class="n-flex between">
                    <span>Earn to Account</span>
                    <span class="green">7</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement Complete</span>
                    <span class="blue">3</span>
                </div>
            </div>
            <div class="n-box">
                <div class="n-flex between">
                    <span>Order total</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Settlement</span>
                    <span>$ 400.00</span>
                </div>
                <div class="n-flex between">
                    <span>Fee</span>
                    <span class="red">- $ 10.00</span>
                </div>
            </div>
            <div class="n-box total">
                <div class="n-flex between">
                    <span>Profit</span>
                    <span class="blue">$ 396.00</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import WaveSurfer from 'wavesurfer.js';

    export default {
        components: {
        },
        data: function() {
            return {
                isLogin: false,
                popup_filter:0,
            };
        },
        mounted(){
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

    .n-swiper-wrap {
        margin: 30px -16px;
        height: 192px;
        width: 100vw;
        overflow: hidden;
        position: relative;
        background-color: #1b1b1e;
        [class^="slidenav"] {
            position: absolute;
            top: 50%;
            margin-top: -12px;
            img {
                opacity: .3;
                width: 24px;
            }
        }
        .slidenav-prev {
            // margin-left: 8px;
            left: 8px;
        }
        .slidenav-next {
            right: 8px;
            // margin-right: 8px;
        }
    }

    .n-swiper {
        position: relative;
        display: flex;
        width: auto;
        float: left;
        li {
            margin: 0;
            padding: 24px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100vw;
            height: 192px;

            h4 {
                height: 25px;
                font-weight: 600;
                margin-bottom: 24px;
            }
        }
        .date {
            font-size: 14px;
            line-height: 1.2;
            margin-bottom: 10px;
        }
        .num {
            font-size: 32px;
            line-height: 1.2;
        }
    }

    .payment-box {
        h4.title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 600;
        }
        .n-box {
            background-color: #1B1B1E;
            padding: 16px;
            margin-right: -16px;
            margin-left: -16px;
            &+.n-box {
                margin-top: 1px;
            }
            &.total {
                margin-top: 0;
                padding-top: 0;
                >div {
                    padding-top: 16px;
                    border-top: 1px solid rgba(white,.3);
                }
            }
            span {
                font-size: 14px;
                font-weight: 600;
                &:last-child {
                    font-weight: normal;
                }
            }
            >div {

                &+div {
                margin-top: 10px;
            }
            }
        }
    }
</style>