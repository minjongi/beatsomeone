<template>
    <div class="wrapper">
        <Header />
        <div class="container">
            <div class="main complate-wrap">
                <section class="main__section1" style="margin-bottom:160px;">
                    <div class="BG" style="background-image:url('/assets/images/order_complete.png')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>{{$t('payComplete')}}<br/>{{$t('forYourorder')}}</h1>
                        </header>
                        <div class="row">
                            <div class="checkbox" style="margin-bottom:30px; font-weight:600"> {{$t('ordered')}} <div class="number" style="margin-left:8px; color: #ffda2a">{{ orderItems.length }}</div> {{$t('items')}}</div>
                        </div>
                        <div class="row">
                            <div class="playList productList cart">
                                <ul>
                                    <OrderItem v-for="(item, i) in orderItems" v-bind:key="item.cor_id" :item="item" :pg="order.cor_pg" />
                                </ul>
                            </div>
                        </div>
                        <div class="row fluid n-total">
                            <div class="title">{{$t('yourOrderInformation')}}</div>
                            <div class="payment_box" style="max-width:initial!important;padding-top:0; margin-top:0; border:0;">
                                <div class="tab">
                                    <div class="n-flex between">
                                        <div class="title">{{ $t('payMethod1') }}</div>
                                        <div>{{ $t(paymentMethod) }}</div>
                                    </div>
                                    <div class="n-flex between">
                                        <div class="title">{{$t('paySubtotal')}}</div>
                                        <div>{{ formatPrice(order.cor_total_money, true) }}</div>
                                    </div>
                                    <div class="n-flex between">
                                        <div class="title">{{$t('usePoints')}}</div>
                                        <div>{{ order.cor_point }} P</div>
                                    </div>
                                    <div class="n-flex between total">
                                        <div>{{$t('payTotal')}}</div>
                                        <div>{{ formatPrice(order.cor_total_money - order.cor_point) }}</div>
                                    </div>                           
                                </div>
                            </div>
                            <p class="desc">
                                <img src="/assets/images/icon/info_blue.png">
                                {{$t('downloadAtOrderHistoryMsg')}}
                            </p>
                        </div>

                        <div class="n-flex btnbox" style="margin-top: 12px;">
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
    import ItemDetail from "../component/ItemDetail";
    require('@/assets_m/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import axios from 'axios'
    import OrderItem from "./OrderItem";

    export default {
        components: {
            OrderItem,
            ItemDetail,
            Header, Footer
        },
        data: function() {
            return {
                order: {},
                cor_id: '',
                orderItems: []
            };
        },
        mounted(){
            let path = window.location.pathname;
            this.cor_id = path.split('/')[3];
            axios.get(`/cmall/ajax_orderresult/${this.cor_id}`)
                .then(res => res.data)
                .then(data => {
                    this.order = data.data;
                    this.orderItems = data.orderdetail;
                    this.orderItems.forEach(item => {
                        if (item.item.cit_type3 === '0') {
                            this.$set(item.item, 'is_new', false);
                            let now = new Date();
                            let startDateTime = new Date(item.item.cit_start_datetime);
                            if ((now - startDateTime) < 1000 * 3600 * 24 * 7) this.$set(item.item, 'is_new', true);
                        } else if (item.item.cit_type3 === '1') {
                            this.$set(item.item, 'is_new', true);
                        }
                    })
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods:{
            formatPrice: function(price, simbol){
                if (this.$i18n.locale === "en") { //this.order.cor_pg === 'paypal'
                    return '$ ' + Number(price).toLocaleString(undefined, {minimumFractionDigits: 2});
                } else { //if (this.order.cor_pg === 'allat')
                    return '₩ ' + Number(price).toLocaleString('ko-KR', {minimumFractionDigits: 0});
                }
            },
            goMain: function(e){
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/');
            },
            goOrderHistory: function(e){
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage#/mybilling');
            },
        },
        computed: {
            paymentMethod() {
                if (this.order.cor_pay_type === '3D' || this.order.cor_pay_type === 'NOR') {
                    return 'creditCard'
                } else if (this.order.cor_pay_type === 'ABANK') {
                    return 'realtimeBankTransfer';
                } else if (this.order.cor_pay_type === 'paypal') {
                    return 'paypal';
                } else {
                    return '';
                }
            }
        }
    }
</script>


<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>