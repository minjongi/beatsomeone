<template>
    <div class="modal" id="purchase" v-if="item.toggle_popup" @click.self="close">
        <div class="modal__content">
            <header class="modal__header">
                <h2 class="modal__title">{{ $t('selectPurchaseType') }}</h2>
                <button class="modal__close" @click="close">닫기</button>
            </header>
            <div class="modal__body">
                <div class="album">
                    <div class="album__thumb">
                        <img :src="albumThumb" alt/>
                    </div>
                    <h3>{{ item.cit_name }}</h3>
                    <p>{{ item.musician }}</p>
                </div>
                <div class="purchase-list">
                    <ul>
                        <li class="parchase-item" v-for="(detailItem, index) in item.detail" :key="index">
                            <div class="purchase-info">
                                <div class="purchase-headern">
                                    <div>
                                        <h4 class="purchase-title">{{ detailItem.cde_title }}</h4>
                                        <p class="purchase-desc">
                                            {{ detailItem.cde_type }}
                                        </p>
                                    </div>

                                    <div class="parchase-btnbox">
                                        <button class="buy waves-effect" @click="addCart(detailItem)">
                                            <span>{{ $t('currencySymbol') }} {{ $i18n.locale === 'en' ? formatPrice(detailItem.cde_price_d) : formatPrice(detailItem.cde_price) }}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="purchase-description" v-show="detailItem.toggleDesc">
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                                        </i>
                                        {{$t('lang25')}}
                                    </p>
                                    <p></p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info1.png" alt/>
                                        </i>
                                        {{$t('lang26')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info3.png" alt/>
                                        </i>
                                        {{$t('lang27')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info2.png" alt/>
                                        </i>
                                        {{$t('lang28')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info7.png" alt/>
                                        </i>
                                        {{$t('lang29')}}
                                    </p>
                                </div>
                                <div class="parchase-dropdown">
                                    <button @click="toggleDescription(detailItem)">정보열람</button>
                                    <span>{{ $t('lang40') }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "SelectorModal",
        props: ["item"],
        methods: {
            close() {
                this.$emit("update:togglePopup", false);
            },
            formatPrice: function (price) {
                if (this.$i18n.locale === "en") {
                    return Number(price).toLocaleString(undefined, {minimumFractionDigits: 2});
                } else {
                    return Number(price).toLocaleString("ko-KR", {minimumFractionDigits: 0});
                }
            },
            addCart: function (detailItem) {
                console.log(this.item, detailItem);
                let formData = new FormData();
                formData.append('stype', 'cart');
                formData.append('cit_id', this.item.cit_id);
                formData.append('chk_detail[]', detailItem.cde_id);
                formData.append(`detail_qty[${detailItem.cde_id}]`, 1);
                axios.post(`/item/${this.item.cit_key}`, formData)
                    .then(res => res.data)
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            toggleDescription: function (detailItem) {
                this.$set(detailItem, 'toggleDesc', !detailItem.toggleDesc);
            }
        },
        computed: {
            albumThumb() {
                return !this.item.cit_file_1
                    ? "/assets/images/no_190x190.png"
                    : "/uploads/cmallitem/" + this.item.cit_file_1;
            },
        },
    }
</script>

<style scoped>

</style>