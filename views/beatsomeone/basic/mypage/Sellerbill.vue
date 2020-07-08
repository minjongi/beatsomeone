<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:64px;">
                    <div @click="goPage('seller#/')">Settlement Status (123)</div>
                    <div class="active">Settlement Complete (32)</div>
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
                    <button class="btn btn--blue" style="width:200px; height:40px; margin-left:10px;" @click="goDelete"><img src="/assets/images/icon/bank.png" style="margin-top:-4px;" />Account Setting</button>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board mybillinglist saleshistory set_complete">
                <div class="tab nowrap">
                    <div class="index">No</div>
                    <div class="date">Date</div>
                    <div class="totalprice">Order total</div>
                    <div class="totalprice">Settlement</div>
                    <div class="totalprice">Fee</div>
                    <div class="totalprice">Total Settlement</div>
                    <div class="status">Status</div>
                    <div class="feature">Detail</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory set_complete">

                <ul>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">10</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">9</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">8</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="blue">Settlement Complete</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">7</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">6</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">5</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="blue">Settlement Complete</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">4</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">3</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">2</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="blue">Settlement Complete</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">1</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice">$ 400.00</div>
                            <div class="totalprice red">- $ 10.00</div>
                            <div class="totalprice blue">$ 396.00</div>
                            <div class="status">
                                <div class="green">Earn to Account</div>
                            </div>
                            <div class="feature">
                                <button class="btn btn--blue round">View</button>
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
        <div class="panel">
            <div class="popup active" style="width:1110px;">

                <div class="box" style="padding-bottom:50px;">
                    <div class="title" style="margin-bottom:30px;">ACCOUNT SETTING</div>

                    <div class="row">
                        <div class="type"><span style="margin-top:-4px;">Bank Name<span class="red">*</span></span></div>
                        <div class="data">
                            <div class="input_wrap col">
                                <input class="inputbox" type="mail" placeholder="Enter your bank name...">
                                <div class="caution deactive" style="min-width:100%;">
                                    <div>
                                        <img class="caution" src="/assets/images/icon/caution.png">
                                        <img class="warning" src="/assets/images/icon/warning.png">
                                    </div>
                                    <span>
                                        {{$t('noteChangeEmailMsg')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div></div>
                    </div>

                    <div class="row">
                        <div class="type"><span style="margin-top:-4px;">Account Number<span class="red">*</span></span></div>
                        <div class="data">
                            <div class="input_wrap col">
                                <input class="inputbox" type="mail" placeholder="Enter your account number...">
                                <div class="caution deactive" style="min-width:100%;">
                                    <div>
                                        <img class="caution" src="/assets/images/icon/caution.png">
                                        <img class="warning" src="/assets/images/icon/warning.png">
                                    </div>
                                    <span>
                                        {{$t('noteChangeEmailMsg')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div></div>
                    </div>

                    <div class="row">
                        <div class="type"><span style="margin-top:-4px;">Receipent<span class="red">*</span></span></div>
                        <div class="data">
                            <div class="input_wrap col">
                                <input class="inputbox" type="mail" placeholder="Enter receipent name...">
                                <div class="caution deactive" style="min-width:100%;">
                                    <div>
                                        <img class="caution" src="/assets/images/icon/caution.png">
                                        <img class="warning" src="/assets/images/icon/warning.png">
                                    </div>
                                    <span>
                                        {{$t('noteChangeEmailMsg')}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div></div>
                    </div>

                    <div class="row">
                        <div class="type"><span style="margin-top:-4px;">Copy of Account<span class="red">*</span></span></div>
                        <div class="data">
                            <label class="btn btn--blue" for="attachbtn">
                                <input type="file" id="attachbtn" style="display:none;">
                                <span style="margin:auto; padding:0 15px;">Attach Copy</span>
                            </label>
                            <div class="attached active" style="margin-left:20px;">
                                <div class="btn btn--glass">
                                    <img src="/assets/images/icon/file.png"/>powerfulbeat.mp3
                                    <button class="close">
                                        <img src="/assets/images/icon/x-white.png"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div></div>
                    </div>


                    <div class="row">
                        <div class="title-content">
                            <p>
                                - Please upload a file less than 1mb in size to your account copy.<br/>
                                - Account is only available to the <strong>seller's own account</strong>, and <strong>proof may be required</strong>.
                            </p>
                        </div>
                    </div>

                    <div class="btnbox" style="text-align:center;">
                        <button class="btn btn--gray" style="width:208px">Cancel</button>
                        <button type="submit" class="btn btn--yellow" style="width:208px; margin-left:20px;">Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        components: {
        },
        data: function() {
            return {
                isLogin: false,
            };
        },
        mounted(){
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