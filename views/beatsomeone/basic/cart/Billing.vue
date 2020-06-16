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
                                <div class="stage active done">
                                    <span>1</span>Cart
                                </div>
                                <div class="stage active">
                                    <span>2</span>Pay
                                </div>
                                <div class="stage">
                                    <span>3</span>Complete
                                </div>
                            </div>
                        </header>
                        <div class="row">
                            <div class="checkbox" style="margin-left:20px; margin-bottom:30px; font-weight:600"><div class="number">{{ selectedItems }}</div>Selected Items</div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <li v-for="(item, i) in myOrder_list" v-bind:key="item.cct_id" class="playList__itembox" :id="'playList__item'+ item.cct_id" >
                                        <div class="playList__item playList__item--title other">
                                                <div class="col name">
                                                    <figure>
                                                        <span class="playList__cover">
                                                            <img v-if="!item.cit_file_1" :src="'/assets/images/cover_default.png'" alt="">
                                                            <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt="">
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
                                                                    <div class="price 11221122" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                                        {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                                    </div>
                                                                </button>
                                                                <div class="option_item basic">
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info1.png"></span><span>Available for 60 days</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info2.png"></span><span>Unable to edit arbitrarily</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info3.png"></span><span>Rented members cannot be re-rented to others</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info5.png"></span><span>No other activities not authorized by the platform</span></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                        <div class="n-box" v-if="item.detail[0].cit_lease_license_use === '1' && item.detail[0].cit_mastering_license_use === '1' ">
                                                            <div>
                                                                <button class="playList__item--button" >
                                                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                    <div>
                                                                        <div class="title" @click.self="toggleButton">UNLIMITED STEMS LICENSE</div>
                                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                                    </div>
                                                                    <div class="price  1122" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                                            {{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2, true) }}
                                                                        </div>
                                                                </button>
                                                                <div class="option_item unlimited">
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span><span>UNLIMITED</span></div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released. </span> </div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020) </span> </div>
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
                                                                    <div class="price 1111" v-if="item.detail[0].cit_lease_license_use === '1'">
                                                                        {{ formatPrice(item.detail[0].cde_price, item.detail[0].cde_price_d) }}
                                                                    </div>
                                                                </button>
                                                                <div class="option_item basic">
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info1.png"></span><span>Available for 60 days</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info2.png"></span><span>Unable to edit arbitrarily</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info3.png"></span><span>Rented members cannot be re-rented to others</span></div>
                                                                    <div><span class="img-box"><img src="/assets/images/icon/parchase-info5.png"></span><span>No other activities not authorized by the platform</span></div>
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
                                                                        <div class="detail 2222">MP3 or WAV + STEMS</div>
                                                                    </div>
                                                                    <div class="price" v-if="item.detail[0].cit_mastering_license_use === '1'" >
                                                                        {{ formatPrice(item.detail[0].cde_price_2, item.detail[0].cde_price_d_2, true) }}
                                                                    </div>
                                                                </button>
                                                                <div class="option_item unlimited">
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span><span>UNLIMITED</span></div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released. </span> </div>
                                                                    <div><span class="img-box"> <img src="/assets/images/icon/parchase-info4.png"></span> <span> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020) </span> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </li>
                                    <!--
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
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
                                        </div>
                                    </li>

                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
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
                                                        <div class="title">BASIC LEASE</div>
                                                        <div class="detail">MP3 or WAV</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="price">
                                                    $ 10.00
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
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
                                        </div>
                                    </li>
                                    -->
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="payment_box" style="max-width:initial!important">
                                <div>
                                    <div class="title-content">
                                        <div div class="title">
                                            Payment method
                                        </div>
                                        <div>
                                            <label class="checkbox" for="method1">
                                                <input type="radio" name="method" id="method1" hidden="hidden" @change="chgPayMethod(1)">
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon credit"></div><div style="font-size:14px;">Credit</div></div>
                                            </label>
                                            <label class="checkbox" for="method2">
                                                <input type="radio" name="method" id="method2" hidden="hidden" @change="chgPayMethod(2)">
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon wire"></div><div style="font-size:14px;">Wire</div></div>
                                            </label>
                                            <label class="checkbox" for="method3">
                                                <input type="radio" name="method" id="method3" hidden="hidden" @change="chgPayMethod(3)">
                                                <div class="btn btn--yellow" style="height:48px"><div class="icon paypal"></div><div style="font-size:14px;">PayPal</div></div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="title-content">
                                        <div div class="title">
                                            Point
                                        </div>
                                        <div>
                                            <div class="input_wrap inputbox unit" style="height:48px">
                                                <input type="number" value="0" @change="calcPoint">
                                                <span>P</span>
                                            </div>
                                            <button class="btn btn--blue" style="width:100px;height:48px;margin-left:-10px;">Use</button>
                                        </div>
                                        <p style="display:inline-block;">
                                            <span>{{ point - usePoint}}</span> P left
                                        </p>
                                    </div>
                                </div>
                                <div class="tab">
                                    <div>
                                        <div class="title">Subtotal</div>
                                        <div>{{ formatPrice(totalPriceKr, totalPriceEn, true) }}</div>
                                    </div>
                                    <div>
                                        <div class="title">Points</div>
                                        <div>{{ usePoint }} P</div>
                                    </div>
                                    <div class="total">
                                        <div>Total</div>
                                        <div>{{ formatPrice(totalPriceKr - usePoint, totalPriceEn - usePoint, true) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                            <button class="btn btn--gray" @click="goBack">Back</button>
                            <button type="submit" class="btn btn--submit" @click="goPay">Pay</button>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</template>

<script>
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import axios from 'axios'

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                myOrder_list: [],
                myMember: [],
                totalPriceKr: 0,
                totalPriceEn: 0,
                point: 0,
                usePoint: 0,
                payMethod: 0,
                unique_id: 0,
                cor_id:'',
                selectedItems:0,
            };
        },
        mounted(){

        },
        created() {
            this.ajaxOrderList().then(()=>{
                this.calcTotalPrice();
                this.point = this.myMember[0].mem_point;
            });
        },
        methods:{
            async ajaxOrderList () {
              try {
                this.isLoading = true;
                const { data } = await axios.get(
                  '/beatsomeoneApi/user_order_list', {}
                );
                this.myOrder_list = data.result;
                this.selectedItems = this.myOrder_list.length;
                this.myMember = data.mem_result;
                this.unique_id = data.unique_id;
                console.log(this.unique_id);
              } catch (err) {
                console.log('ajaxCartList error');
              } finally {
                this.isLoading = false;
              }
            },
            async ajaxUpdateOrder () {
              try {
                this.isLoading = true;
                var param = new FormData();
                param.append('pay_type', JSON.stringify(this.payMethod));
                param.append('priceType', JSON.stringify(this.getPriceType()));
                param.append('total_price_sum', JSON.stringify(this.formatPrice(this.totalPriceKr, this.totalPriceEn, false)));
                param.append('usePoint', JSON.stringify(this.usePoint));
                param.append('unique_id', JSON.stringify(this.unique_id));

                const { data } = await axios.post(
                  '/beatsomeoneApi/user_order_update', param,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(data);
                if(data.message == 'ok'){
                    this.cor_id = data.cor_id;
                }
              } catch (err) {
                console.log('ajaxUpdateOrder error');
              } finally {
                this.isLoading = false;
              }
            },
            goBack: function(e){
                window.location.href = '/cmall/cart';
            },
            goPay: function(e){
                if((this.totalPrice - this.usePoint) <= 0){
                    alert("결제 금액을 확인해주세요");
                    return;
                }
                if(this.payMethod == 0){
                    alert("결제 방법을 선택해주세요");
                    return;
                }

                this.ajaxUpdateOrder().then(()=>{
                    if(this.cor_id == ''){
                        alert("결제가 실패하였습니다.");
                        return;
                    }else{
                        window.location.href = '/cmall/complete?cor_id='+this.cor_id;
                    }
                });
            },
            chgPayMethod: function(idx){
                this.payMethod = idx;
            },
            calcTotalPrice: function(){
                let tpkr = 0.0;
                let tpen = 0.0;
                for(let i in this.myOrder_list){
                    if(this.myOrder_list[i].detail[0].cit_lease_license_use == '1'){
                        tpkr += Number(this.myOrder_list[i].detail[0].cde_price);
                        tpen += Number(this.myOrder_list[i].detail[0].cde_price_d);
                    }
                    if(this.myOrder_list[i].detail[0].cit_mastering_license_use == '1'){
                        tpkr += Number(this.myOrder_list[i].detail[0].cde_price_2);
                        tpen += Number(this.myOrder_list[i].detail[0].cde_price_d_2);
                    }
                }
                this.totalPriceKr = tpkr;
                this.totalPriceEn = tpen;
            },
            calcPoint: function(e){
                this.usePoint = Number(e.target.value);
            },
            checkToday: function(date){
                const input = new Date(date);
                const today = new Date();
                return input.getDate() === today.getDate() && 
                        input.getMonth() === today.getMonth() &&
                         input.getFullYear() === today.getFullYear();
            },
            formatPrice: function(kr, en, simbol){
                if(!simbol){
                    if(this.$i18n.locale === 'en'){
                        return en;
                    }else{
                        return kr;
                    }
                }
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
            getPriceType: function(){
                if(this.$i18n.locale === 'en'){
                    return '$';
                }else{
                    return '₩';
                }
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
        }
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .cart .playList__item > * {
        height: auto;
    }

    // 
    .cart .playList__item.other .option {
        padding-right: 48px;
    }
    .playList__item .n-option .n-box:first-child .price {
        margin-top: 0;
    }
    .playList__item.other .active .option_item.unlimited {
        height: 140px;
    }
    .cart .playList__item .option {
        margin-top: 6px !important;
    }
    .n-box.active {
        margin-bottom: 0;
    }
    .playList__item .n-option .n-box .price {
        color: white;
    }
</style>