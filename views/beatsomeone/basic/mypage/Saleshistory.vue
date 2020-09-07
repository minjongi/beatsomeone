<template>
    <div>
        <div class="row" style="display:flex; margin-bottom:10px;">
            <div class="search condition">
                <div class="filter">
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">{{$t('all')}}</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">{{$t('months3')}}</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">{{$t('months6')}}</div>
                    <div class="condition" :class="{ 'active': search_condition_active_idx === 4 }" @click="setSearchCondition(4)">{{$t('year1')}}</div>
                </div>
            </div>
            <div style="margin-left:auto; ">
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
                <!--
                <div>
                    <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
                        <input type="date" :placeholder="$t('startDate')" @change="goStartDate"/>
                        <span>─</span>
                        <input type="date" :placeholder="$t('endDate')" @change="goEndDate"/>
                        <button><img src="/assets/images/icon/calendar-white.png" /></button>
                    </div>
                </div>
                -->
            </div>
        </div>

        <div class="row" style="margin-bottom:10px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:96px;">
                    <div class="splitboard">
                        <div class="green">&#8361; {{watingDepositKr }} <br/>$ {{ watingDepositDr }}
                            <span>{{$t('waitingDeposit')}}</span>
                        </div>
                        <div class="blue">&#8361; {{orderCompleteKr }} <br/>$ {{ orderCompleteDr }}
                            <span>{{$t('orderComplete')}}</span>
                        </div>
                        <div class="red">&#8361; {{refundCompleteKr }} <br/>$ {{ refundCompleteDr }}
                            <span>{{$t('refundComplete')}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="display:flex; margin-bottom:30px;">
            <div class="tabmenu">
                <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">{{$t('total1')}} ({{calcTotalCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">{{$t('wait')}} ({{calcWaitCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">{{$t('payComplete1')}} ({{calcCompleteCnt}})</div>
                <div :class="{ 'active': search_tabmenu_idx === 4 }" @click="goTabMenu(4)">{{$t('refundComplete')}} ({{calcRefundCnt}})</div>
            </div>
            <div class="sort" style="text-align:right">
                <div class="bs-select">
                    <button class="selected-option">
                        {{ downType }}
                    </button>
                    <div class="options">
                        <button data-value="" class="option" @click="funcDownType('All')"> {{$t('all')}} </button>
                        <button data-value="" class="option" @click="funcDownType('Download Complete')"> {{$t('downloadComplete')}} </button>
                        <button data-value="" class="option" @click="funcDownType('Not Downloaded')"> {{$t('notDownloaded')}} </button>
                    </div>
                </div>

                <div class="bs-select" style="min-width:max-content;">
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

        <div class="row" style="margin-bottom:10px;">
            <div class="main__media board mybillinglist saleshistory">
                <div class="tab nowrap">
                    <div class="index">{{$t('orderNumber')}}</div>
                    <div class="date">{{$t('date')}}</div>
                    <div class="cover">{{$t('cover')}}</div>
                    <div class="product">{{$t('product')}}</div>
                    <div class="totalprice">{{$t('totalPrice')}}</div>
                    <div class="status">{{$t('status')}}</div>
                    <div class="user">{{$t('buyer')}}</div>
                    <div class="download">{{$t('expirePeriod')}}</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board mybillinglist saleshistory">
                <ul>
                    <li v-for="(item, i) in paging()" v-bind:key="item.cor_id + item.cit_id" class="playList__itembox" :id="'slist'+ item.cor_id + item.cit_id">
                        <div class="playList__item playList__item--title nowrap active">
                            <!--<div class="index" v-html="formatCitName(item.cor_id,10)"> </div>-->
                            <div class="index">{{ mySalesList.length - ((currPage - 1) * perPage) - i }}</div>
                            <div class="date">
                                {{ item.cor_datetime }}
                            </div>
                             <div class="col name">
                                <figure>
                                    <span class="playList__cover">
                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                        <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt="">
                                        <!-- <i ng-if="item.isNew" class="label new">N</i> -->
                                    </span>
                                </figure>
                            </div>
                            <div class="subject" v-html="formatCitName(item.cit_name,50)">
                            </div>
                            <div class="totalprice" v-html="formatPr(item.cor_memo,item.cor_total_money)"></div>
                            <div class="status">
                                <div :class="{ 'green': item.cor_status === '0', 'blue': item.cor_status === '1', 'red': item.cor_status === '2' }"> {{ $t(funcStatus(item.cor_status)) }} </div>
                            </div>
                            <div class="user"> {{ item.mem_userid }} </div>
                            <div v-if="item.cor_status === '1' && item.cit_lease_license_use === '1'  && caclLeftDay(item.cor_datetime) <= 0 " class="download">
                                <span class="red">{{$t('unavailable')}}</span>
                            </div>
                            <div v-else-if="item.cor_status === '1' && item.cit_lease_license_use === '1' && 0 < caclLeftDay(item.cor_datetime)" class="download">
                                <span>{{ caclLeftDay(item.cor_datetime) }} {{$t('daysLeft')}}</span>
                                <span class="gray">(~ {{ caclTargetDay(item.cor_datetime) }})</span>
                            </div>
                            <div v-else-if="item.cor_status === '1' && item.cit_lease_license_use === '0' && item.cit_mastering_license_use === '1'" class="download">
                                <span>{{ caclLeftDay(item.cor_datetime) }} {{$t('daysLeft')}}</span>
                                <span class="gray">(~ {{ caclTargetDay(item.cor_datetime) }})</span>
                            </div>
                            <div v-else class="download">
                                <span class="red">{{$t('unavailable')}}</span>
                            </div>
                        </div>
                    </li>
                    <!--
                    <li class="playList__itembox">
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
                                <div class="blue">Deposit Waiting</div>
                            </div>
                            <div class="user">User_001</div>
                            <div class="download">
                                <span>37 {{$t('daysLeft')}}</span>
                                <span class="gray">(~2020.06.24 12:30:34)</span>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox">
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
                                <div class="blue">Deposit Waiting</div>
                            </div>
                            <div class="user">User_001</div>
                            <div class="download">
                                <span>37 {{$t('daysLeft')}}</span>
                                <span class="gray">(~2020.06.24 12:30:34)</span>
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
                group_title: 'SELLER',
                product_status: 'PENDING',
                mySalesList: [],
                search_condition_active_idx: 1,
                search_tabmenu_idx: 1,
                orderType: 'Recent',
                downType: 'All',
                calcTotalCnt: 0,
                calcWaitCnt: 0,
                calcCompleteCnt: 0,
                calcRefundCnt: 0,
                start_date: '',
                end_date: '',
                totalpage: 0,
                currPage: 1,
                perPage: 10,
                watingDepositKr: '',
                orderCompleteKr: '',
                refundCompleteKr: '',
                watingDepositDr: '',
                orderCompleteDr: '',
                refundCompleteDr: '',
                currDate: new Date().toISOString().substring(0, 10),

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
        created(){
            this.ajaxSalesList().then(()=>{
                this.calcTotalCnt = this.calcFuncTotalCnt();
                this.calcWaitCnt = this.calcFuncWaitCnt();
                this.calcCompleteCnt = this.calcFuncCompleteCnt();
                this.calcRefundCnt = this.calcFuncRefundCnt();
                this.calcFUncWaitingDeposit();
                this.calcFUncOrderComplete();
                this.calcFUncRefundComplete();
            });
            this.ajaxUserInfo();
        },
        computed:{

        },
        filters:{
        },
        methods:{
            async ajaxUserInfo () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/get_user_info', {}
                );
                //console.log(data);
                this.mem_photo = data[0].mem_photo;
                this.mem_usertype = data[0].mem_usertype;
                this.mem_nickname = data[0].mem_nickname;
                this.mem_address1 = data[0].mem_address1;
                this.mem_type = data[0].mem_type;
                this.mem_lastname = data[0].mem_lastname;

                if(this.mem_usertype == 1){
                    this.group_title = "CUSTOMER";
                }else{
                    this.group_title = "SELLER";
                }
              } catch (err) {
                console.log('ajaxUserInfo error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxSalesList() {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/musician_sales_history', {}
                );
                this.mySalesList = data.sp_list.reverse();
                if(this.mySalesList.length == 0){
                    this.totalpage = 1;
                }else{
                    this.totalpage = Math.ceil(this.mySalesList.length / this.perPage);    
                }
                console.log(this.mySalesList);
              } catch (err) {
                console.log('ajaxSalesList error');
              } finally {
                this.isLoading = false;
              }
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
            formatPr: function(m, price){
                if(this.isEmpty(m)){
                    m = '';
                }
                if(m == '$'){
                    return m + this.formatNumberEn(price);
                }else{
                    return m + this.formatNumber(price);
                }
            },
            formatSub: function(data, genre, bpm){
                return data + " (" + genre + " / " + bpm + "bpm)";
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
            caclLeftDay: function(orderDate){
                var tDate = new Date(orderDate);
                var nDate = new Date();
                tDate.setDate(tDate.getDate() + 60);
                var diff = tDate.getTime() - nDate.getTime();
                diff = Math.ceil(diff / (1000 * 3600 * 24));
                return diff;
            },
            caclTargetDay: function(orderDate){
                var tDate = new Date(orderDate);
                tDate.setDate(tDate.getDate() + 60);
                return moment(tDate).format('YYYY-MM-DD HH:mm:ss');
            },
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            goSearch: function(){
                this.ajaxSalesList().then(()=>{
                    let list = [];
                    Object.assign(list,this.mySalesList);
                    if(this.search_condition_active_idx == 1){
                        //all
                    }
                    else if(this.search_condition_active_idx == 2){
                        let m3 = moment(new Date().getTime()).add("-3", "M");
                        let rst = list.filter(item => moment(item.cor_datetime).isAfter(m3)); 
                        this.mySalesList = rst; 
                    }
                    else if(this.search_condition_active_idx == 3){
                        let m6 = moment(new Date().getTime()).add("-6", "M");
                        let rst = list.filter(item => moment(item.cor_datetime).isAfter(m6)); 
                        this.mySalesList = rst;
                    }
                    else if(this.search_condition_active_idx == 4){
                        let m12 = moment(new Date().getTime()).add("-1", "y");
                        let rst = list.filter(item => moment(item.cor_datetime).isAfter(m12)); 
                        this.mySalesList = rst;
                    }
                });
            },
            goTabMenu: function(menu){
                this.ajaxSalesList().then(()=>{
                    let list = [];
                    Object.assign(list,this.mySalesList);
                    if(menu == 1){
                        this.mySalesList = list;
                        this.search_tabmenu_idx = 1;
                    }
                    else if(menu == 2){
                        let rst = list.filter(item => item.cor_status === '0'); 
                        this.mySalesList = rst; 
                        this.search_tabmenu_idx = 2;
                    }
                    else if(menu == 3){
                        let rst = list.filter(item => item.cor_status === '1');
                        this.mySalesList = rst;
                        this.search_tabmenu_idx = 3;
                    }
                    else if(menu == 4){
                        let rst = list.filter(item => item.cor_status === '2');
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
                this.ajaxSalesList().then(()=>{
                    let list = [];
                    Object.assign(list,this.mySalesList);
                    if(this.isEmpty(this.start_date) || this.isEmpty(this.end_date)){
                        this.mySalesList = list;
                    }else{
                        let rst = list.filter(item => this.start_date <= item.cor_datetime.substr(0,10) 
                                                    && item.cor_datetime.substr(0,10) <= this.end_date);
                        this.mySalesList = rst;
                    }
                });
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
            calcFuncTotalCnt(){
                return this.mySalesList.length;
            },
            calcFuncWaitCnt(){
                let list = [];
                Object.assign(list,this.mySalesList);
                let rst = list.filter(item => item.cor_status === '0');
                return rst.length;
            },
            calcFuncCompleteCnt(){
                let list = [];
                Object.assign(list,this.mySalesList);
                let rst = list.filter(item => item.cor_status === '1');
                return rst.length;
            },
            calcFuncRefundCnt(){
                let list = [];
                Object.assign(list,this.mySalesList);
                let rst = list.filter(item => item.cor_status === '2');
                return rst.length;
            },
            formatNumber(n){
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
            },
            formatNumberEn(n){
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
            },
            calcFUncWaitingDeposit(){
                let sumPriceKr = 0;
                let sumPriceDr = 0;
                for( let item in this.mySalesList){
                    if(this.mySalesList[item].cor_status == '0'){
                        if(this.mySalesList[item].cor_memo == '₩'){
                            sumPriceKr += parseInt(this.mySalesList[item].cor_total_money);
                        }else if(this.mySalesList[item].cor_memo == '$'){
                            sumPriceDr += parseInt(this.mySalesList[item].cor_total_money);
                        }
                    }
                }
                this.watingDepositKr = this.formatNumber(sumPriceKr);
                this.watingDepositDr = this.formatNumber(sumPriceDr);
            },
            calcFUncOrderComplete(){
                let sumPriceKr = 0;
                let sumPriceDr = 0;
                for( var item in this.mySalesList){
                    if(this.mySalesList[item].cor_status == '1'){
                        if(this.mySalesList[item].cor_memo == '₩'){
                            sumPriceKr += parseInt(this.mySalesList[item].cor_total_money);
                        }else if(this.mySalesList[item].cor_memo == '$'){
                            sumPriceDr += parseInt(this.mySalesList[item].cor_total_money);
                        }
                    }
                }
                this.orderCompleteKr = this.formatNumber(sumPriceKr);
                this.orderCompleteDr = this.formatNumber(sumPriceDr);
            },
            calcFUncRefundComplete(){
                let sumPriceKr = 0;
                let sumPriceDr = 0;
                for( let item in this.mySalesList){
                    if(this.mySalesList[item].cor_status == '2'){
                        if(this.mySalesList[item].cor_memo == '₩'){
                            sumPriceKr += parseInt(this.mySalesList[item].cor_total_money);
                        }else if(this.mySalesList[item].cor_memo == '$'){
                            sumPriceDr += parseInt(this.mySalesList[item].cor_total_money);
                        }
                    }
                }
                this.refundCompleteKr = this.formatNumber(sumPriceKr);
                this.refundCompleteDr = this.formatNumber(sumPriceDr);
            },
            makePageList(n){
                return [...Array(n).keys()].map(x => x=x+1);
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
            paging() {
                let list = [];
                Object.assign(list,this.mySalesList);
                if(this.mySalesList.length == 0){
                    this.totalpage = 1;
                }else{
                    this.totalpage = Math.ceil(this.mySalesList.length / this.perPage);    
                }
                return list.slice((this.currPage - 1) * this.perPage , this.currPage * this.perPage);
            },
            funcOrderType(od){
                if(this.orderType == od){
                    return;
                }else{
                    this.orderType = od;    
                    this.mySalesList.reverse();
                }
            },
            checkDownload(dt, d, q){
                console.log(dt + ',' + d +',' + q);
                if(dt == "Download Complete"){
                    //console.log(d==q);
                    if(d == q) return true;
                }else if(dt == "Not Downloaded"){
                    //console.log(d<q); 
                    if(d < q) return true;
                }else if(dt == "All"){
                    return true;
                }
                return false;
            },
            funcDownType(dt){
                if(this.downType == dt){
                    return;
                }else{
                    this.ajaxSalesList().then(()=>{
                        let list = [];
                        let rst = [];
                        Object.assign(list,this.mySalesList);
                        rst = list.filter(item => this.checkDownload(dt, item.cde_download, item.cde_quantity) );
                        this.downType = dt;
                        this.mySalesList = rst;
                    });
                }
            }
        }
    }
</script>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    .sublist .col.name figure {
        min-width: auto;
    }
</style>