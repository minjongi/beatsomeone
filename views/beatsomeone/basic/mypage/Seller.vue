<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:64px;">
                    <div class="active">Settlement Status (123)</div>
                    <div @click="goPage('seller#/sellerbill')">Settlement Complete (32)</div>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="filter">
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">All</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">3 months</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">6 months</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">1 year</div>
                </div>
            </div>
            <div style="margin-left:auto; ">
                <div>
                    <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
                        <input type="date" :placeholder="$t('startDate')" />
                        <span>─</span>
                        <input type="date" :placeholder="$t('endDate')" />
                        <button><img src="/assets/images/icon/calendar-white.png" /></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; margin-bottom:30px;">
            <div class="title-content">
                <div class="title"></div>
                <p>
                    ※ The search period is based on the date and time of purchase. <br/>
                    ※ You can see not only the amount of sales, but also the amount of settlement that has occurred.
                </p>
            </div>
            <div class="sort" style="text-align:right; margin:auto 0px 0px auto;">
                <button class="btn btn--green" style="width:200px; height:40px;" @click="goDelete"><img src="/assets/images/icon/excel.png" style="margin-top:-4px;" />Download as Excel</button>
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="main__media board mybillinglist saleshistory">
                <div class="tab nowrap">
                    <div class="index">No</div>
                    <div class="date">Date</div>
                    <div class="cover">Cover</div>
                    <div class="product">Product</div>
                    <div class="totalprice">Total price</div>
                    <div class="status">Order Status</div>
                    <div class="totalprice">Settlement</div>
                    <div class="status" style="padding:0">Settlement<br/>Status</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory">

                <ul>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="blue">Order Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="blue">Order Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="blue">Order Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="red">Refund Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" @click="gosellerbill">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_010</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <img class="cover" src="/assets/images/cover_default.png" alt="">
                                        <i ng-if="item.isNew" class="label new">N</i>
                                    </span>
                                </figure>
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="blue">Order Complete</div>
                            </div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <span class="green">Stay</span>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row" style="margin-bottom:60px;">
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
            <div class="payment_box" style="padding-top:0; padding-bottom:10px; margin-top:0; border:0;">
                <div class="tab row">
                    <div>
                        <div>
                            <div class="title big">Settlement detail</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                            <div class="title">Total rental (VAT included)</div>
                            <div>$ 120.00</div>
                        </div>
                        <div>
                            <div class="subtitle">- Rent amount</div>
                            <div>200</div>
                        </div>
                        <div>
                            <div class="title">Total sales (VAT included)</div>
                            <div>$ 120.00</div>
                        </div>
                        <div>
                            <div class="subtitle">- Sales amount</div>
                            <div>300</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                            <div class="title">Order total (VAT Included)</div>
                            <div>$ 440.00</div>
                        </div>
                        <div>
                            <div class="title">VAT (10%)</div>
                            <div class="red">- $ 40.00</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                            <div class="title">Settlement</div>
                            <div style="opacity:.7; font-weight:300;">$ 400.00</div>
                        </div>
                        <div>
                            <div class="title">Fee (10%)</div>
                            <div class="red">- $ 40.00</div>
                        </div>
                        <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                            <div class="title big">Total settlement</div>
                            <div class="blue big">$ 365.00</div>
                        </div>
                    </div>
                    <div>
                        <div class="col">
                            <div class="title big">Help</div>
                            <div>
                                <ul>
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
                    </div>
                </div>
            </div>
            <div class="title-content">
                <p>
                    - Settlement will be made on the <strong>10th of the following month</strong> based on the downloaded items from the 1st to the last day.<br/>
                    - If the user did not proceed with the download after purchase, <strong>both rentals and sales are included in the settlement details <span>after 60 days from the purchase date</span></strong>.
                </p>
            </div>
        </div>
        <!-- 정산내역 팝업 -->
        <div class="panel" :class="popupActive">
            <div class="popup payment_popup active">
                <div class="popup close" @click="popupActive = false">
                    <span></span>
                    <span></span>
                </div>
                <h3><span class="blue">3월</span> 정산내역</h3>
                <div class="payment_box_head">
                    <div class="n-flex">
                        <div class="n-flex between">
                            <span>정산기간</span>
                            <span>2020.03.01~2020.03.31</span>
                        </div>
                        <div class="n-flex between">
                            <span>정산일시</span>
                            <span>2020.04.10 12:00:00</span>
                        </div>
                    </div>
                </div>
                <div class="payment_box" style="padding-top:0; padding-bottom:10px; margin-top:0; border:0;">
                    <div class="tab row">
                        <div>
                            <div>
                                <div class="title big">Settlement detail</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title">Total rental (VAT included)</div>
                                <div>$ 120.00</div>
                            </div>
                            <div>
                                <div class="subtitle">- Rent amount</div>
                                <div>200</div>
                            </div>
                            <div>
                                <div class="title">Total sales (VAT included)</div>
                                <div>$ 120.00</div>
                            </div>
                            <div>
                                <div class="subtitle">- Sales amount</div>
                                <div>300</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title">Order total (VAT Included)</div>
                                <div>$ 440.00</div>
                            </div>
                            <div>
                                <div class="title">VAT (10%)</div>
                                <div class="red">- $ 40.00</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title">Settlement</div>
                                <div style="opacity:.7; font-weight:300;">$ 400.00</div>
                            </div>
                            <div>
                                <div class="title">Fee (10%)</div>
                                <div class="red">- $ 40.00</div>
                            </div>
                            <div style="padding-top:30px; margin-top:20px; border-top:1px solid rgba(255,255,255,.3);">
                                <div class="title big">Total settlement</div>
                                <div class="blue big">$ 365.00</div>
                            </div>
                        </div>
                        <div>
                            <div class="col">
                                <div class="title big">Help</div>
                                <div>
                                    <ul>
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
                        </div>
                    </div>
                </div>
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
                search_condition_active_idx: 1,
                popupActive: true
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
            gosellerbill() {
                this.$router.push({path: '/sellerbill'});
            },
        }
    }
</script>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';


    /* 정산내역 팝업 CSS */
    .panel {
        .popup {
            &.payment_popup {
                border-radius: 8px;
                position: relative;
                background: #2B2C30;
                h3 {
                    margin-top: 40px;
                    margin-bottom: 10px;
                    padding: 0 40px;
                    font-size: 24px;
                    line-height: 28px;
                }
            }
            .close {
                position: absolute;
                opacity: 1;
                top: 22px;
                right: 22px;
                width: 12px;
                height: 12px;
                display: block;
                cursor: pointer;
                pointer-events: auto;
                span {
                    display: block;
                    position: absolute;
                    width: 17px;
                    height: 2px;
                    transform: rotate(45deg);
                    background-color: white;
                    border-radius: 2px;
                    &:last-child {
                        transform: rotate(-45deg);
                    }
                }
            }
            .payment_box_head {
                padding: 30px 40px 0px;
                h4 {
                    margin-bottom: 10px;
                    font-size: 16px;
                    font-weight: 600;
                }
                >.n-flex {
                    border-bottom: 1px solid rgba(255,255,255, .3);
                    padding-bottom: 30px;
                }
                .n-flex {
                    display: flex;
                    > div {
                        flex: 1;
                        padding: 0 32px;
                        &:first-child {
                            padding-left: 0;
                        }
                    }
                    &.between {
                        justify-content: space-between;
                    }
                    span {
                        font-weight: 600;
                        font-size: 16px;
                        &:last-child {
                            font-weight: normal;
                            color: rgba(white,.7);
                        }
                    }
                }

            }
            .payment_box {
                .tab {
                    background: #2B2C30;
                    border: none;
                    margin: 0;
                    > * .title + * {
                        margin-right: 0;
                        font-weight: 600;
                    }
                }
            }
        }
    }
</style>