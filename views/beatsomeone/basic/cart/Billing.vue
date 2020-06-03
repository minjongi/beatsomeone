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
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!--
                                                        <img src="/assets/images/cover_default.png" alt="">
                                                        -->
                                                        <img :src="'http://dev.beatsomeone.com/uploads/cmallitem/' + item.cit_file_1" alt="">
                                                        <i ng-if="item.isNew" class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"> {{ formatCitName(item.cit_name) }} </h3>
                                                        <span class="playList__by"> ( {{ item.bpm }} ) BPM</span>
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
                                                    $ {{ item.cit_price }}
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
                                        <div>$ {{ totalPrice }}</div>
                                    </div>
                                    <div>
                                        <div class="title">Points</div>
                                        <div>{{ usePoint }} P</div>
                                    </div>
                                    <div class="total">
                                        <div>Total</div>
                                        <div>$ {{ totalPrice - usePoint}}</div>
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
    import Loader from '*/vue/common/Loader'
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
                totalPrice: "00.00",
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
                console.log(data);
                /*
                data.forEach(function(d){
                    console.log(d.cit_datetime);
                    console.log(d.cit_start_datetime);
                });*/
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
                param.append('total_price_sum', JSON.stringify(this.totalPrice));
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
                let tp = 0.0;
                for(let i in this.myOrder_list){
                    tp += Number(this.myOrder_list[i].cit_price);
                }
                this.totalPrice = tp;
            },
            calcPoint: function(e){
                this.usePoint = Number(e.target.value);
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