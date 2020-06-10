<template>

    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container">
            <div class="main">
                <section class="main__section1" style="margin-bottom:160px;">
                    <div class="BG" style="background-image:url('/assets/images/cart.png')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>PLACE AN ORDER</h1>
                            <div class="step" style="margin-top:30px;">
                                <div class="stage active">
                                    <span>1</span>Cart
                                </div>
                                <div class="stage">
                                    <span>2</span>Pay
                                </div>
                                <div class="stage">
                                    <span>3</span>Complete
                                </div>
                            </div>
                        </header>
                        <div class="row">
                            <div class="title-content">
                                <div class="title">
                                    <label for="checkAll" class="checkbox" style="margin-left:20px; margin-bottom:30px;">
                                        <input type="checkbox" hidden="hidden" id="checkAll" v-model="checkedAll" @change="setCheckAll">
                                        <span></span><div style="font-weight:600">Select All ({{ cntSelectedItems }}/ {{ cntTotalItems }})</div>
                                    </label>
                                    <button class="btn btn--red disable" style="width:100px; height:40px; margin-bottom:20px;" @click="goDelete"><img src="/assets/images/icon/bin.png" style="margin-top:-4px;" />Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <li v-for="(item, i) in myCart_list" v-bind:key="item.cct_id" class="playList__itembox" :id="'playList__item'+ item.cct_id">
                                        <div class="playList__item playList__item--title">
                                            <div class="col check">
                                                <label :for="'cartItem'+ i" class="checkbox">
                                                    <input type="checkbox" hidden="hidden" :id="'cartItem'+ i" :value="item.cit_id" v-model="checkedItem" @change="setCheck">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img v-if="!item.cit_file_1" :src="'http://dev.beatsomeone.com/assets/images/cover_default.png'" alt="">
                                                        <img v-else :src="'http://dev.beatsomeone.com/uploads/cmallitem/' + item.cit_file_1" alt="">
                                                        <i v-show="checkToday(item.cct_datetime)" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"> {{ formatCitName(item.cit_name) }} </h3>
                                                        <span class="playList__by">by {{item.detail[0].mem_userid}}</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col n-option">

                                                <!-- Option -->
                                                <div class="option">
                                                    <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' ">
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">BASIC LEASE LICENSE</div>
                                                                    <div class="detail">MP3 or WAV</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item basic">
                                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' ">
                                                        <!-- UNLIMITED STEMS LICENSE -->
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">UNLIMITED STEMS LICENSE</div>
                                                                    <div class="detail">MP3 or WAV + STEMS</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item unlimited">
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released. </span> </div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020) </span> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- BASIC LEASE LICENSE -->
                                                    <div class="n-box" v-else-if="item.detail[0].cit_lease_license_use === '1' " >
                                                        
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">BASIC LEASE LICENSE</div>
                                                                    <div class="detail">MP3 or WAV</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item basic">
                                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-else-if="item.detail[0].cit_mastering_license_use === '1' " >
                                                        
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">UNLIMITED STEMS LICENSE</div>
                                                                    <div class="detail">MP3 or WAV + STEMS</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item unlimited">
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released. </span> </div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020) </span> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                    {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                </div>
                                                <div class="price" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                    {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button class="btn btn--blue round" style="height:40px; padding:0 16px;" @click="goBuy(item.cit_id)" >Buy NOW</button>
                                            </div>
                                        </div>
                                    </li>
                                    <!--
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col check">
                                                <label for="type2" class="checkbox">
                                                    <input type="checkbox" hidden="hidden" id="type2" value="Music Lover">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img src="/assets/images/cover_default.png" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                        <span class="playList__by"> ( Bpm )</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>UNLIMITED</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button class="btn btn--blue round" style="height:40px; padding:0 16px;">Buy NOW</button>
                                            </div>
                                        </div>
                                    </li>

                                    --> 
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="bottom_bar tab" v-if="0 < cntTotalItems">
            <div class="wrap">
                <div>
                    <div class="total">Subtotal</div>
                </div>
                <div>
                    <div class="price">{{ totalPrice }}</div>
                    <button class="btn btn--submit" @click="goOrder" >Order</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import Loader from '*/vue/common/Loader'
    import axios from 'axios'

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                isLoading: false,
                myCart_list: [],
                totalPrice: "00.00",
                selectedItem: null,
                checkedAll:false,
                checkedItem:[],
                cntTotalItems: 0,
                cntSelectedItems: 0,
            };
        },
        mounted(){

        },
        created() {
            this.ajaxCartList();

        },
        watch: {
            uudidl(){
                //console.log(this.$parent);

            },
        },
        methods:{
            async ajaxCartList () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/get_user_cart_list', {}
                );
                console.log(data);
                /*
                data.forEach(function(d){
                    console.log(d.cit_datetime);
                    console.log(d.cit_start_datetime);
                });*/
                this.myCart_list = data;
                this.cntTotalItems = this.myCart_list.length;
              } catch (err) {
                console.log('ajaxCartList error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxDeleteCart () {
              try {
                this.isLoading = true;
                var param = new FormData();
                param.append('chk', JSON.stringify(this.checkedItem));
                const { data } = await axios.post(
                  '/beatsomeoneApi/delete_user_cart', param,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(data);
                this.totalPrice = 0.0;
              } catch (err) {
                console.log('ajaxDeleteCart error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxCartToOrder (items) {
              try {
                this.isLoading = true;
                var param = new FormData();
                param.append('chk', JSON.stringify(items));
                const { data } = await axios.post(
                  '/beatsomeoneApi/user_cart_to_order', param,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(data);
              } catch (err) {
                console.log('ajaxCartToOrder error');
              } finally {
                this.isLoading = false;
              }
            },
            formatNumber(n){
                //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
                return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
            },
            formatPrice: function(kr, en){
                if(this.$i18n.locale === 'en'){
                    return '$ '+ Number(en).toLocaleString(undefined, {minimumFractionDigits: 0});
                }else{
                    return '₩ '+ Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
                }
            },
            formatCitName: function(data){
                var rst;
                var limitLth = 50
                if(limitLth < data.length && data.length <= limitLth*2){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2);
                }else if(limitLth < data.length && limitLth*2 < data.length){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2) + '...';
                }else{
                    rst = data
                }
                return rst;
            },
            setCheckAll: function(e){
                this.checkedItem = [];
                //console.log(this.checkedAll);
                if(this.checkedAll){
                    for(var i in this.myCart_list){
                        //console.log(i);
                        this.checkedItem.push(this.myCart_list[i].cit_id);
                    }
                }
                this.calcTotalPrice();
            },
            setCheck: function() {
                this.checkedAll = false;
                this.calcTotalPrice();
            },
            toggleButton: function(e){
                if(e.target.parentElement.parentElement.parentElement.parentElement.className == "n-box"){
                    e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box active";
                }else if(e.target.parentElement.parentElement.parentElement.parentElement.className == "n-box active"){
                    e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box";
                }else{
                    //
                }
            },
            calcTotalPrice: function(){
                let tpkr = 0.0;
                let tpen = 0.0;
                let cnt = 0;
                if(this.checkedAll){
                    for(let i in this.myCart_list){
                        tpkr += Number(this.myCart_list[i].detail[0].cde_price);
                        tpen += Number(this.myCart_list[i].detail[0].cde_price_d);
                        cnt++;
                    }
                }else{
                    for(let i in this.myCart_list){
                        if(this.checkedItem.includes(this.myCart_list[i].cit_id)){
                            tpkr += Number(this.myCart_list[i].detail[0].cde_price);
                            tpen += Number(this.myCart_list[i].detail[0].cde_price_d);
                            cnt++;
                        }
                    }
                }
                this.totalPrice = this.formatPrice(tpkr, tpen);
                this.cntSelectedItems = cnt;
            },
            goDelete: function(){
                if(this.checkedItem.length == 0){
                    alert("삭제할 대상을 선택해주세요");
                    return;
                }else{
                    if(confirm("정말로 삭제하시겠습니까?")){
                        this.ajaxDeleteCart().then(()=>{
                            this.ajaxCartList();
                        });    
                    }
                }
            },
            checkToday: function(date){
                const input = new Date(date);
                const today = new Date();
                return input.getDate() === today.getDate() && 
                        input.getMonth() === today.getMonth() &&
                         input.getFullYear() === today.getFullYear();
            },
            goBuy: function(id){
                let items = [];
                console.log(id);
                items.push(id);
                this.ajaxCartToOrder(items).then(()=>{
                    window.location.href = '/cmall/billing';
                });
            },
            goOrder: function(id){
                if(this.checkedItem.length == 0){
                    alert("주문할 대상을 선택해주세요");
                    return;
                }else{
                    if(confirm("정말로 주문하시겠습니까?")){
                        this.ajaxCartToOrder(this.checkedItem).then(()=>{
                        window.location.href = '/cmall/billing';
                        });    
                    }
                }
            }
        }
    }
</script>


<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    @import '/assets/plugins/flatpickr/flatpickr.css';
</style>