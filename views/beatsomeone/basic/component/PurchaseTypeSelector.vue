<template>
<div class="modal" id="purchase" v-if="purchaseTypeSelectorPopup" @click.self="close">
    <div class="modal__content">
        <header class="modal__header">
            <h2 class="modal__title">PLEASE SELECT A PURCHASE TYPE</h2>
            <button class="modal__close" @click="close">닫기</button>
        </header>
        <div class="modal__body">
            <div class="album">
                <div class="album__thumb">
                    <img :src="albumThumb" alt="">
                </div>
                <h3>{{ item.cit_name }}</h3>
                <p>{{ item.musician }}</p>
            </div>
            <div class="purchase-list">
                <ul>
                    <li class="parchase-item" v-if="!!item.detail['LEASE']">
                        <div class="parchase-info">
                            <h4 class="parchase-title">BASIC LEASE</h4>
                            <p class="parchase-desc">MP3 or WAV</p>
                            <div class="parchase-description">
                                <p><i><img src="/assets/images/icon/parchase-info1.png" alt=""></i> Available for 60 days</p>
                                <p><i><img src="/assets/images/icon/parchase-info2.png" alt=""></i> Unable to edit arbitrarily</p>
                                <p><i><img src="/assets/images/icon/parchase-info3.png" alt=""></i> Rented members cannot be re-rented to others</p>
                                <p><i><img src="/assets/images/icon/parchase-info5.png" alt=""></i> no other activities not authorized by the platform</p>
                            </div>
                            <div class="parchase-dropdown">
                                <button class="">정보열람</button>
                            </div>
                        </div>
                        <div>
                            <a class="buy waves-effect" @click="addCart(item.detail['LEASE'].cde_id)">
                                <span>{{ formatPrice(item.detail['LEASE'].cde_price, item.detail['LEASE'].cde_price_d, true) }}</span>
                            </a>
                        </div>
                    </li>
                    <li class="parchase-item" v-if="!!item.detail['STEM']">
                        <div class="parchase-info">
                            <h4 class="parchase-title">MASTERING LICENSE</h4>
                            <p class="parchase-desc">MP3 or WAV + STEMS</p>
                            <div class="parchase-description">
                                <p><i><img src="/assets/images/icon/parchase-info4.png" alt=""></i> UNLIMITED</p>
                                <p><i><img src="/assets/images/icon/parchase-info4.png"></i> We encourage you to recognize a total of 30% of the copyright shares (composition 20% + arrangement 10% recommended) in the name of the seller when the song is officially released.</p>
                                <p><i><img src="/assets/images/icon/parchase-info4.png"></i> Note: Korean Music Copyright Association (KOMCA) Copyright Standards, 41.67% for lyrics, 41,67% for composition, 16,66% for arrangement (Music Copyright Association, May 2020)</p>
                            </div>
                            <div class="parchase-dropdown">
                                <button class="">정보열람</button>
                            </div>
                        </div>
                        <div>
                            <a class="buy waves-effect" @click="addCart(item.detail['STEM'].cde_id)">
                                <span>{{ formatPrice(item.detail['STEM'].cde_price, item.detail['STEM'].cde_price_d, true) }}</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</template>


<script>
    require('@/assets/js/function')

    import { EventBus } from '*/src/eventbus'
    import $ from "jquery"
    import 'jquery.nicescroll'

    export default {
        props: ['purchaseTypeSelectorPopup', 'item'],
        data: function() {
            return {
            }
        },
        mounted(){
            console.log('mounted purchase : ' + this.item)
            $('body').on('click', '.parchase-dropdown button', function(){
                $(this).toggleClass('active')
                $(this).parents('.parchase-item').find('.parchase-description').toggle()
            })
        },
        watch: {
            item : function(n){
                console.log(n)
            },
        },
        computed: {
            albumThumb() {
                return !this.item.cit_file_1 ? '/assets/images/no_190x190.png' : '/uploads/cmallitem/' + this.item.cit_file_1
            },
        },
        methods: {
            addCart(cde_id) {
                let detail_qty = {};
                detail_qty[cde_id] = 1;
                Http.post( `/beatsomeoneApi/itemAction`,{stype: 'cart',cit_id:this.item.cit_id,chk_detail:[cde_id],detail_qty:detail_qty,}).then(r=> {
                    if(!r) {
                        log.debug('장바구니 담기 실패');
                    } else {
                        EventBus.$emit('add_cart');
                        log.debug('장바구니 담기 성공');
                        this.close()
                    }
                });
            },
            close(){
                this.$emit('update:purchaseTypeSelectorPopup', false)
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
                    return '$ '+ Number(en).toLocaleString(undefined, {minimumFractionDigits: 2});
                }else{
                    return '₩ '+ Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
                }
            },
        },
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    /* width */
    .purchase-list::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .purchase-list::-webkit-scrollbar-track {
        background: none;
    }

    /* Handle */
    .purchase-list::-webkit-scrollbar-thumb {
        background: #414349;
    }

    /* Handle on hover */
    .purchase-list::-webkit-scrollbar-thumb:hover {
        background: #414349;
    }
</style>
