<template>
    <div>
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab n-flex" style="height:48px;">
                    <div class="active">{{$t('orderHistory')}} ({{calcTotalCnt}})</div>
                    <div @click="gocancellist">Cancellation / Refund History(0)</div>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="n-flex between filter">
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">{{$t('all')}}</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">{{$t('months3')}}</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">{{$t('months6')}}</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 4 }" @click="setSearchCondition(4)">{{$t('year1')}}</div>
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
                    :maxDate="currDate"
                    :endingDateValue="currDate"
                    @update="updateSearchDate"
                    @reset="resetSearchDate"
                />
            </div>
        </div>

        <div class="row" style="margin-bottom: 10px;">
            <div class="sort">
                <div class="custom-select" style="flex: 3;">
                    <button class="selected-option">
                        {{ downType }}
                    </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcDownType('All')"> {{$t('total1')}} </button>
                        <button data-value="" class="option" @click="funcDownType('Download Complete')"> {{$t('downloadComplete')}} </button>
                        <button data-value="" class="option" @click="funcDownType('Not Downloaded')"> {{$t('notDownloaded')}} </button>
                    </div>
                </div>

                <div class="custom-select" style="flex: 2;">
                    <button class="selected-option">
                        {{ orderType }}
                    </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcOrderType('Recent')"> {{$t('recent')}} </button>
                        <button data-value="" class="option" @click="funcOrderType('Past')"> {{$t('past')}} </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tabmenu">
                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">{{$t('total1')}} ({{calcTotalCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">{{$t('wait')}} ({{calcWaitCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">{{$t('payComplete1')}} ({{calcCompleteCnt}})</div>
            </div>
        </div>

        <!-- <div class="row" style="margin-bottom:20px;">
            <div class="main__media board mybillinglist">
                <div class="tab nowrap">
                    <div class="index">{{$t('orderNumber')}}</div>
                    <div class="date">{{$t('date')}}</div>
                    <div class="product">{{$t('product')}}</div>
                    <div class="totalprice">{{$t('totalPrice')}}</div>
                    <div class="status">{{$t('status')}}</div>
                    <div class="download">{{$t('download1')}}</div>
                </div>
            </div>
        </div> -->

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist">

                <ul>
                    <li v-for="(item, i) in paging()" v-bind:key="item['id']" class="playList__itembox" :id="'slist'+ item['id']" @click="goOrderDetail(item['id'], myOrderList.length - ((currPage - 1) * perPage) - i )" >
                        <div class="playList__item playList__item--title nowrap active">

                            <div class="n-flex between">
                                <div class="index">{{ myOrderList.length - ((currPage - 1) * perPage) - i }} </div>
                                <div class="date"> {{ item['items'][0].cor_datetime }} </div>
                            </div>

                            <div class="n-flex between">
                                <div class="status">
                                    <div :class="{ 'green': item['items'][0].cor_status === '0', 'blue': item['items'][0].cor_status === '1', 'red': item['items'][0].cor_status === '2' }"> {{ $t(funcStatus(item['items'][0].cor_status)) }} </div>
                                </div>
                                <div class="totalprice" v-html="formatPr(item['items'][0].cor_memo,item['items'][0].cor_total_money)"></div>
                            </div>

                            <div class="subject" v-html="formatSub(formatCitName(item['items'][0].cit_name,50), item['size'])"> </div>

                            <div class="download">
                                <div v-if="item['items'][0].cit_lease_license_use === '1' && caclLeftDay(item['items'][0].cor_datetime) <= 0 && item['items'][0].cor_status === '1' " class="download">
                                    <span class="gray">{{$t('expired')}}</span>
                                </div>
                                <div v-else-if="item['items'][0].cit_mastering_license_use === '1' " class="download">
                                    <span class="green">{{$t('possible')}}</span>
                                </div>
                                <div v-else-if="item['items'][0].cit_lease_license_use === '1' && 0 < caclLeftDay(item['items'][0].cor_datetime) && item['items'][0].cor_status === '1' " class="download">
                                    <span class="green">{{$t('possible')}}</span>
                                </div>
                                <div v-else-if="item['items'][0].cit_lease_license_use === '1' && 0 < caclLeftDay(item['items'][0].cor_datetime) && item['items'][0].cor_status === '1' && item['items'][0].cde_download === 0 " class="download">
                                    <span class="red">{{$t('payComplete1')}}</span>
                                </div>
                                <div v-else class="download">
                                    <span class="red">{{$t('impossible')}}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_009</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="blue">Order Complete</div>
                            </div>
                            <div class="download">
                                <span class="green">Possible 2</span>
                                <span class="gray">Expired 2</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_008</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="green">Deposit Waiting</div>
                            </div>
                            <div class="download">
                                <span class="red">Impossible 2</span>
                                <span class="gray">Expired 2</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">Order_007</div>
                            <div class="date">
                                0000-00-00 00:00:00
                            </div>
                            <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
                            <div class="totalprice">$ 10.00</div>
                            <div class="status">
                                <div class="blue">Order Complete</div>
                            </div>
                            <div class="download">
                                <span class="green">Possible 2</span>
                                <span class="red">Impossible 2</span>
                            </div>
                        </div>
                    </li>
                    -->
                </ul>

            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="pagination">
                <div>
                    <button class="prev active" @click="prevPage"><img src="/assets/images/icon/chevron_prev.png"/></button>

                    <button v-for="n in makePageList(this.totalpage)" v-bind:key="n" :class="{ 'active': currPage === n }" @click="currPage = n">{{n}}</button>
                    <button class="next active" @click="nextPage"><img src="/assets/images/icon/chevron_next.png"/></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import moment from "moment";
    import $ from "jquery";
    import VueHotelDatepicker from '@northwalker/vue-hotel-datepicker'

    export default {
        components: {
            VueHotelDatepicker
        },
        data: function() {
            return {
                isLogin: false,
                mem_photo: '',
                mem_usertype: '',
                mem_nickname: '',
                mem_address1: '',
                mem_type: '',
                mem_lastname: '',
                myOrderList: [],
                search_condition_active_idx: 1,
                search_tabmenu_idx: 1,
                orderType: 'Recent',
                downType: 'All',
                calcTotalCnt: 0,
                calcWaitCnt: 0,
                calcCompleteCnt:0,
                calcRefundCnt: 0,
                start_date: '',
                end_date: '',
                totalpage: 0,
                currPage: 1,
                perPage: 10,
                currDate: new Date().toISOString().substring(0, 10),
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
                if($(this).hasClass("active")){
                    $(this).addClass("active");
                    $(this).find(".options").show();
                }else{
                    $(this).removeClass("active");
                    $(this).find(".options").hide();
                }
            });
        },
        created() {
            this.ajaxOrderList().then(()=>{
                this.calcTotalCnt = this.calcFuncTotalCnt();
                this.calcWaitCnt = this.calcFuncWaitCnt();
                this.calcCompleteCnt = this.calcFuncCompleteCnt();
                this.calcRefundCnt = this.calcFuncRefundCnt();
            });
        },
        methods:{
            async ajaxOrderList() {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/user_order_history', {}
                );
                this.myOrderList = data.sp_list.reverse();
                if(this.myOrderList.length == 0){
                    this.totalpage = 1;
                }else{
                    this.totalpage = Math.ceil(this.myOrderList.length / this.perPage);    
                }
                console.log(this.myOrderList);
              } catch (err) {
                console.log('ajaxOrderList error');
              } finally {
                this.isLoading = false;
              }
            },
            formatPr: function(m, price){
                if(this.isEmpty(m)){
                    m = '';
                }
                return m + this.formatNumber(price);
            },
            formatNumber(n){
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
            },
            formatCitName: function(data, limitLth){
                let rst;
                if(limitLth < data.length && data.length <= limitLth*2){
                    rst = data.substring(0,limitLth) + '<br/>' + data.substring(limitLth,limitLth*2);
                }else if(limitLth < data.length && limitLth*2 < data.length){
                    rst = data.substring(0,limitLth) + '<br/>' + data.substring(limitLth,limitLth*2) + '...';
                }else{
                    rst = data
                }
                return rst;
            },
            formatSub: function(data, size){
                if(1 < size){
                    return data + " 외 " + (size-1) + "건"; 
                }
                return data;
            },
            calcFuncTotalCnt(){
                return this.myOrderList.length;
            },
            calcFuncWaitCnt(){
                let list = [];
                Object.assign(list,this.myOrderList);
                let rst = list.filter(item => item['items'][0].cor_status === '0');
                return rst.length;
            },
            calcFuncCompleteCnt(){
                let list = [];
                Object.assign(list,this.myOrderList);
                let rst = list.filter(item => item['items'][0].cor_status === '1');
                return rst.length;
            },
            calcFuncRefundCnt(){
                let list = [];
                Object.assign(list,this.myOrderList);
                let rst = list.filter(item => item['items'][0].cor_status === '2');
                return rst.length;
            },
            caclLeftDay: function(orderDate){
                var tDate = new Date(orderDate);
                var nDate = new Date();
                tDate.setDate(tDate.getDate() + 60);
                var diff = Math.abs(tDate.getTime() - nDate.getTime());
                diff = Math.ceil(diff / (1000 * 3600 * 24));
                return diff;
            },
            caclTargetDay: function(orderDate){
                var tDate = new Date(orderDate);
                tDate.setDate(tDate.getDate() + 60);
                return moment(tDate).format('YYYY-MM-DD HH:mm:ss');
            },
            isEmpty: function(str){
                if(typeof str == "undefined" || str == null || str == "")
                    return true;
                else
                    return false ;
            },
            updateSearchDate(date){
                if(this.isEmpty(date.start) || this.isEmpty(date.end)){
                    this.goSearchDate();
                }else{
                    this.start_date = date.start
                    this.end_date = date.end
                    this.goSearchDate();
                }
            },
            resetSearchDate(date){
                this.start_date = ''
                this.end_date = ''
                this.goSearchDate();
            },
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            goSearch: function(){
                this.ajaxOrderList().then(()=>{
                    let list = [];
                    Object.assign(list,this.myOrderList);
                    if(this.search_condition_active_idx == 1){
                        //all
                    }
                    else if(this.search_condition_active_idx == 2){
                        let m3 = moment(new Date().getTime()).add("-3", "M");
                        let rst = list.filter(item => moment(item['items'][0].cor_datetime).isAfter(m3)); 
                        this.myOrderList = rst; 
                    }
                    else if(this.search_condition_active_idx == 3){
                        let m6 = moment(new Date().getTime()).add("-6", "M");
                        let rst = list.filter(item => moment(item['items'][0].cor_datetime).isAfter(m6)); 
                        this.myOrderList = rst;
                    }
                    else if(this.search_condition_active_idx == 4){
                        let m12 = moment(new Date().getTime()).add("-1", "y");
                        let rst = list.filter(item => moment(item['items'][0].cor_datetime).isAfter(m12)); 
                        this.myOrderList = rst;
                    }
                });
            },
            goTabMenu: function(menu){
                this.ajaxOrderList().then(()=>{
                    let list = [];
                    Object.assign(list,this.myOrderList);
                    if(menu == 1){
                        this.myOrderList = list;
                        this.search_tabmenu_idx = 1;
                    }
                    else if(menu == 2){
                        let rst = list.filter(item => item['items'][0].cor_status === '0'); 
                        this.myOrderList = rst; 
                        this.search_tabmenu_idx = 2;
                    }
                    else if(menu == 3){
                        let rst = list.filter(item => item['items'][0].cor_status === '1');
                        this.myOrderList = rst;
                        this.search_tabmenu_idx = 3;
                    }
                    else if(menu == 4){
                        let rst = list.filter(item => item['items'][0].cor_status === '2');
                        this.mySalesList = rst;
                        this.search_tabmenu_idx = 4;
                    }
                });
            },
            goStartDate: function(e){
                console.log(e.target.value);
                this.start_date = e.target.value;
                if(this.start_date == '' || this.end_date == ''){
                    return ;
                }else{
                    this.goSearchDate();
                }
            },
            goEndDate: function(e){
                console.log(e.target.value);
                this.end_date = e.target.value;
                if(this.start_date == '' || this.end_date == ''){
                    return ;
                }else{
                    this.goSearchDate();
                }
            },
            goSearchDate: function(){
                this.ajaxOrderList().then(()=>{
                    let list = [];
                    Object.assign(list,this.myOrderList);
                    if(this.isEmpty(this.start_date) || this.isEmpty(this.end_date)){
                        this.myOrderList = list;
                    }else{
                        let rst = list.filter(item => this.start_date <= item['items'][0].cor_datetime.substr(0,10) 
                                                    && item['items'][0].cor_datetime.substr(0,10) <= this.end_date);
                        this.myOrderList = rst;
                    }
                });
            },
            goOrderDetail: function(cid, n){
                window.location.href = '/mypage/mybillingView?cid='+cid+'&n='+n;
            },
            prevPage: function(){
                if(this.currPage == 1) return
                this.currPage -= 1; 
            },
            nextPage: function(){
                if(this.currPage == this.totalpage) return
                this.currPage += 1; 
            },
            setSearchCondition: function(idx){
                this.search_condition_active_idx = idx;
                this.goSearch();
            },
            makePageList(n){
                return [...Array(n).keys()].map(x => x=x+1);
            },
            paging() {
                let list = [];
                Object.assign(list,this.myOrderList);
                if(this.myOrderList.length == 0){
                    this.totalpage = 1;
                }else{
                    this.totalpage = Math.ceil(this.myOrderList.length / this.perPage);    
                }
                return list.slice((this.currPage - 1) * this.perPage , this.currPage * this.perPage);
            },
            funcStatus(s){
                if(s == '0'){
                    return "depositWaiting";
                }else if(s == '1'){
                    return "orderComplete";
                }else{
                    return "refundComplete";
                }
            },
            funcOrderType(od){
                if(this.orderType == od){
                    return;
                }else{
                    this.orderType = od;    
                    this.myOrderList.reverse();
                }
            },
            checkDownType(dt,i) {
                if(dt == "Download Complete"){
                    if(i.cit_lease_license_use == "1"
                        && i.cde_quantity <= i.cde_download){
                        return true;
                    }
                }else if(dt == "Not Download"){
                    if(i.cit_lease_license_use == "1"
                        && i.cde_quantity > i.cde_download){
                        return true;
                    }
                    if(i.cit_mastering_license_use == "1"){
                        return true;
                    }
                }
            },
            funcDownType(dt){
                if(this.downType == dt){
                    return;
                }else{
                    this.ajaxOrderList().then(()=>{
                        let list = [];
                        let rst = [];
                        Object.assign(list,this.myOrderList);
                        if(dt == "Download Complete"){
                            rst = list.filter(item => this.checkDownType(dt, item['items'][0]) );
                        }else if(dt == "Not Download"){
                            rst = list.filter(item => this.checkDownType(dt, item['items'][0]) );
                        }else{
                            rst = list;
                        }
                        this.downType = dt;
                        this.myOrderList = rst;
                    });
                }
            },
            gocancellist() {
                window.location.href = '/mypage/mycancelList';
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
</style>