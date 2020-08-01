<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container">
            <div class="main">
                <section class="main__section1" style="margin-bottom:160px;">
                    <div class="BG" style="background-image:url('/assets/images/order_complete.png')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title" style="text-align:center;">
                            <h1>{{$t('payComplete')}}<br/>{{$t('forYourorder')}}</h1><!--
                            <div class="step" style="margin-top:30px;">
                                <div class="stage active done">
                                    <span>1</span>Cart
                                </div>
                                <div class="stage active done">
                                    <span>2</span>Pay
                                </div>
                                <div class="stage active">
                                    <span>3</span>Complete
                                </div>
                            </div> -->
                        </header>
                        <div class="row">
                            <div class="checkbox" style="margin-left:20px; margin-bottom:30px; font-weight:600; cursor: auto;"> {{$t('ordered')}} <div class="number" style="margin-left:8px;">{{ cntOrderItems }}</div> {{$t('items')}}</div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <li v-for="(rst, i) in orderResultList" v-bind:key="rst.cor_id" class="playList__itembox" :id="'playList__item'+ rst.cor_id">
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <img v-if="!rst.item[0].cit_file_1" :src="'/assets/images/cover_default.png'" alt="">
                                                        <img v-else :src="'/uploads/cmallitem/' + rst.item[0].cit_file_1" alt="">
                                                        <i v-show="checkToday(orderResult.cor_datetime)" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"> {{ formatCitName(rst.item[0].cit_name) }} </h3>
                                                        <span class="playList__by">by {{ rst.item[0].mem_nickname }}</span>
                                                    </figcaption>
                                                </figure>
                                            </div>

                                            <div class="col n-option">

                                                <!-- Option -->
                                                <div class="option">
                                                    <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-if="rst.item[0].cit_lease_license_use === '1' && rst.item[0].cit_mastering_license_use === '1' ">
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">{{$t('basicLeaseLicense')}}</div>
                                                                    <div class="detail">{{$t('mp3Orwav')}}</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item basic">
                                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>{{$t('available60Days')}}</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>{{$t('unableToEditArbitrarily')}}</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="price"> {{ formatPrice2(rst.item[0].cde_price, rst.item[0].cde_price_d, true) }} </div>
                                                    </div>
                                                    <!-- BASIC LEASE LICENSE --><!-- UNLIMITED STEMS LICENSE --><!-- 
                                                    <div class="n-box" v-if="rst.item[0].cit_lease_license_use === '1' && rst.item[0].cit_mastering_license_use === '1' ">
                                                        {{$t('unlimitedStemsLicense')}}
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">{{$t('unlimitedStemsLicense')}}</div>
                                                                    <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item unlimited">
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"><span>{{$t('unlimited1')}}</span></div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> {{$t('unlimitedMsg1')}} </span> </div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> {{$t('unlimitedMsg2')}} </span> </div>
                                                            </div>
                                                        </div>
                                                        <div class="price"> {{ formatPrice(rst.item[0].cde_price_2, rst.item[0].cde_price_d_2, true) }} </div>
                                                    </div>-->
                                                    <!-- BASIC LEASE LICENSE -->
                                                    <div class="n-box" v-else-if="rst.item[0].cit_lease_license_use === '1' && rst.item[0].cit_mastering_license_use === '0'" >

                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">{{$t('basicLeaseLicense')}}</div>
                                                                    <div class="detail">{{$t('mp3Orwav')}}</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item basic">
                                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>{{$t('available60Days')}}</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>{{$t('unableToEditArbitrarily')}}</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span></div>
                                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="price"> {{ formatPrice2(rst.item[0].cde_price, rst.item[0].cde_price_d, true) }} </div>
                                                    </div>

                                                    <!-- UNLIMITED STEMS LICENSE -->
                                                    <div class="n-box" v-else-if="rst.item[0].cit_mastering_license_use === '1' && rst.item[0].cit_lease_license_use === '0'" >
                                                        <div>
                                                            <button class="playList__item--button" >
                                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                                <div>
                                                                    <div class="title" @click.self="toggleButton">{{$t('unlimitedStemsLicense')}}</div>
                                                                    <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                                </div>
                                                            </button>
                                                            <div class="option_item unlimited">
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"><span>{{$t('unlimited1')}}</span></div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> {{$t('unlimitedMsg1')}} </span> </div>
                                                                <div> <img src="/assets/images/icon/parchase-info4.png"> <span> {{$t('unlimitedMsg2')}} </span> </div>
                                                            </div>
                                                        </div>
                                                        <div class="price"> {{ formatPrice2(rst.item[0].cde_price_2, rst.item[0].cde_price_d_2, true) }} </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col feature">
                                                <div class="price" v-if="rst.item[0].cit_lease_license_use === '1'">
                                                    {{ formatPrice(rst.item[0].cde_price, rst.item[0].cde_price_d, true) }}
                                                </div>
                                                <div class="price" v-if="rst.item[0].cit_mastering_license_use === '1'" >
                                                    {{ formatPrice(rst.item[0].cde_price_2, rst.item[0].cde_price_d_2, true) }}
                                                </div>
                                            </div> -->
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
                                                        <div class="title">{{$t('unlimitedStemsLicense')}} PRICE</div>
                                                        <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>{{$t('unlimited')}}</span></div>
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
                                                        <div class="detail">{{$t('mp3Orwav')}}</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>{{$t('available60Days')}}</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>{{$t('unableToEditArbitrarily')}}</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info5.png"><span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span></div>
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
                                                        <div class="title">{{$t('unlimitedStemsLicense')}} PRICE</div>
                                                        <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>{{$t('unlimited')}}</span></div>
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
                            <div class="title">{{$t('yourOrderInformation')}}</div>
                            <div class="payment_box" style="max-width:initial!important;padding-top:0; padding-bottom:30px; margin-top:0; border:0;">
                                <div class="tab">
                                    <div>
                                        <div class="title">{{$t('payMethod1')}}</div>
                                        <div>{{ $t('creditCard') }}</div>
                                    </div>
                                    <div>
                                        <div class="title">{{$t('paySubtotal')}}</div>
                                        <div>{{ formatPrice(totalPrice, true) }}</div>
                                    </div>
                                    <div>
                                        <div class="title">{{$t('usePoints')}}</div>
                                        <div>0 P</div>
                                    </div>
                                    <div class="total">
                                        <div>{{$t('payTotal')}}</div>
                                        <div>{{ formatPrice(totalPrice - point, true) }}</div>
                                    </div>
                                </div>
                            </div>
                            <p class="desc">
                                <img src="/assets/images/icon/info_blue.png">If the download period has expired, the purchased bit cannot be downloaded
                            </p>
                        </div>

                        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
                            <button class="btn btn--gray" @click="goMain">{{$t('goToMain')}}</button>
                            <button type="submit" class="btn btn--submit" @click="goOrderHistory">{{$t('orderHistory')}}</button>
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
    import Loader from '*/vue/common/Loader'
    import axios from 'axios'

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                orderResult: [],
                orderResultList: [],
                cor_id: '',
                cntOrderItems: 0,
                totalPrice: '',
                point: 0,
            };
        },
        mounted(){

        },
        created() { 
            this.getCorId();
            this.ajaxOrderResultList();

        },
        methods:{
            async ajaxOrderResultList () {
              try {
                this.isLoading = true;
                var param = new FormData();
                param.append('cor_id', JSON.stringify(this.cor_id));
                const { data } = await axios.post(
                  '/beatsomeoneApi/user_order_result', param,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(data);
                this.orderResult = data.order;
                this.orderResultList = data.orderdetail;
                this.cntOrderItems = this.orderResultList.length;
                this.calcTotalPrice();
              } catch (err) {
                console.log('ajaxOrderCompleteList error');
              } finally {
                this.isLoading = false;
              }
            },
            getCorId: function(){
                let uri = window.location.search.substring(1); 
                let params = new URLSearchParams(uri);
                this.cor_id = params.get('cor_id');
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
            formatPrice2: function (kr, en, simbol) {
                if (!simbol) {
                    if (this.$i18n.locale === 'en') {
                        return en;
                    } else {
                        return kr;
                    }
                }
                if (this.$i18n.locale === 'en') {
                    return '$ ' + Number(en).toLocaleString(undefined, {minimumFractionDigits: 2});
                } else {
                    return '₩ ' + Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
                }
            },
            formatPrice: function(price, simbol){
                if(!simbol){
                    return price;
                }

                if(this.orderResult.cor_memo === '$'){
                    return '$ '+ Number(price).toLocaleString(undefined, {minimumFractionDigits: 2});
                }else{
                    return '₩ '+ Number(price).toLocaleString('ko-KR', {minimumFractionDigits: 0});
                }
            },
            calcTotalPrice: function(){
                /*
                let tp = 0.0;
                for(let i in this.orderResultList){
                    tp += Number(this.orderResultList[i].item.cit_price);
                }
                this.totalPrice = tp;
                */
                this.totalPrice = this.orderResult.cor_total_money;
            },
            goMain: function(e){
                window.location.href = '/';
            },
            goOrderHistory: function(e){
                window.location.href = '/mypage#/mybilling';
            },
            checkToday: function(date){
                const input = new Date(date);
                const today = new Date();
                return input.getDate() === today.getDate() && 
                        input.getMonth() === today.getMonth() &&
                         input.getFullYear() === today.getFullYear();
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
    .playList__item .n-option .n-box:first-child .price {
        margin-top: 0;
    }
    .playList__item .n-option .n-box .price {
        text-align: right;
        color: white;
    }
    .n-box.active .option_item.basic {
        height: 113px;
    }
    .n-box .option_item.basic {
        overflow: hidden;
    }
    .n-box .option_item.unlimited {
        overflow: hidden;
    }
    .n-box.active .option_item.unlimited {
        height: 140px;
    }
</style>