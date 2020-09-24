<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title other">
            <div class="n-flex">
                <div class="col check">
                    <label class="checkbox">
                        <input
                            type="checkbox"
                            hidden="hidden"
                            :value="item.cit_id"
                            v-model="checked"
                        />
                        <span></span>
                    </label>
                </div>
                <div class="col name">
                    <figure>
                        <div class="playList__cover">
                            <img
                                v-if="!item.cit_file_1"
                                :src="'/assets/images/cover_default.png'"
                                alt
                            />
                            <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1"
                                 alt/>
                            <i v-if="item.is_new" class="label new">N</i>
                        </div>
                        <figcaption class="pointer">
                            <h3 class="playList__title">{{
                                    formatCitName(item.cit_name)
                                }}</h3>
                            <span
                                class="playList__by">by {{
                                    item.mem_nickname
                                }}</span>
                        </figcaption>
                    </figure>
                </div>
                <div class="edit">
                    <button
                        class="btn btn--blue round"
                        style="width: 32px; height:32px; padding:0;"
                        @click="goBuy(item.cit_id)"
                    >
                        <img src="/assets_m/images/icon/buy_now.png" width="12" alt/>
                    </button>
                </div>
            </div>
            <div class="n-flex">
                <div class="col n-option">
                    <!-- Option -->
                    <div class="option">
                        <ItemDetail :item="item.detail[0]" :type="'lease'" v-if="item.detail[0].cde_title === 'LEASE'" />
                        <ItemDetail :item="item.detail[0]" :type="'mastering'" v-else-if="item.detail[0].cde_title === 'STEM'" />
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import axios from "axios";
import ItemDetail from "../component/ItemDetail";

export default {
    name: "CartItem",
    props: ['item', "value"],
    components: {
        ItemDetail,
    },
    computed: {
        checked: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    mounted() {
        console.log(this.item);
    },
    methods: {
        formatCitName: function (data) {
            var rst;
            var limitLth = 50;
            if (limitLth < data.length && data.length <= limitLth * 2) {
                rst =
                    data.substring(0, limitLth) +
                    "<br>" +
                    data.substring(limitLth, limitLth * 2);
            } else if (limitLth < data.length && limitLth * 2 < data.length) {
                rst =
                    data.substring(0, limitLth) +
                    "<br>" +
                    data.substring(limitLth, limitLth * 2) +
                    "...";
            } else {
                rst = data;
            }
            return rst;
        },
        formatPrice: function (kr, en) {
            if (this.$i18n.locale === "en") {
                return (
                    "$ " +
                    Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
                );
            } else {
                return (
                    "₩ " +
                    Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
                );
            }
        },
        goBuy: function () {
            let formData = new FormData();
            formData.append('chk[]', this.item.cit_id);
            axios.post('/cmall/ajax_orderstart', formData)
                .then(res => res.data)
                .then(data => {
                    window.location.href = '/cmall/billing';
                })
                .catch(error => {
                    console.error(error.response);
                })
        },
        toggleButton: function (e) {
            if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box active";
            } else if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box active"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box";
            } else {
                //
            }
        },
    }
}
</script>

<style scoped>

</style>