<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title other">
            <div class="n-flex between">
                <div class="info">
                    <div class="code">{{ item.item.cit_key }}</div>
                </div>
                <div class="edit">
                    <div
                        class="download_status"
                        :class="getDownStatusColor(item.item)"
                    >{{ $t(funcDownStatus(item.item)) }}
                    </div>
                </div>
                <div class="price" style="color: white;">
                    {{
                        formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, pg)
                    }}
                </div>
            </div>

            <div class="name">
                <figure class="n-flex" style="margin-right: 0;">
                    <div class="playList__cover">
                        <img
                            v-if="!item.item.cit_file_1"
                            :src="'/assets/images/cover_default.png'"
                            alt
                        />
                        <img v-else :src="'/uploads/cmallitem/' + item.item.cit_file_1" alt/>
                        <i v-if="item.item.is_new" class="label new">N</i>
                    </div>
                    <figcaption class="pointer">
                        <h3 class="playList__title"
                            v-html="formatCitName(item.item.cit_name,50)"></h3>
                        <div class="n-flex">
                            <div class="listen">
                                <div class="playbtn">
                                    <button
                                        class="btn-play"
                                        @click="playAudio(item.item, $event)"
                                        :data-action="'playAction' + item.item.cit_id "
                                    >재생
                                    </button>
                                    <span class="timer"><span class="current">0:00 /</span><span
                                        class="duration">0:00</span></span>
                                </div>
                            </div>
                        </div>
                    </figcaption>

                    <button v-if="item.item.possible_download === 1"
                            @click="downloadWithAxios(item.itemdetail[0])" class="btn-edit">
                        <img src="/assets/images/icon/down.png"/>
                    </button>
                    <button v-else class="btn-edit unable">
                        <img src="/assets/images/icon/down.png"/>
                    </button>
                </figure>
            </div>
            <div class="col n-option">
                <div class="option">
                    <div class="n-box" v-if="item.item.cit_mastering_license_use === '1'">
                        <div>
                            <button class="playList__item--button">
                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                                               @click.self="toggleButton"/></span>
                                <div>
                                    <div class="title" @click.self="toggleButton">{{ $t('lang30') }}
                                    </div>
                                </div>
                            </button>
                            <ParchaseComponent :item="item" :type="'mastering'"></ParchaseComponent>
                        </div>
                    </div>
                    <div class="n-box" v-if="item.item.cit_mastering_license_use === '0' && item.item.cit_lease_license_use === '1'">
                        <div>
                            <button class="playList__item--button">
                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                                               @click.self="toggleButton"/></span>
                                <div>
                                    <div class="title" @click.self="toggleButton">{{ $t('lang23') }}
                                    </div>
                                </div>
                            </button>
                            <ParchaseComponent :item="item" :type="'basic'"></ParchaseComponent>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col genre" v-html="calcTag(item.item.hashTag)"></div>
        </div>
    </li>
</template>

<script>
import ParchaseComponent from "./component/Parchase";
import axios from "axios";

export default {
    name: "OrderDetailItem",
    props: ['item', 'pg', 'cor_id'],
    components: {
        ParchaseComponent
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
        getGenre(g1, g2) {
            if (this.isEmpty(g2)) {
                return g1;
            } else {
                return g1 + ", " + g2;
            }
        },
        isEmpty: function (str) {
            return typeof str == "undefined" || str == null || str === "";
        },
        formatPrice: function (kr, en, pg) {
            if (pg === 'paypal') {
                return '$' + this.formatNumberEn(en);
            } else if (pg === 'allat') {
                return '₩' + this.formatNumber(kr);
            } else {
                return ''
            }
        },
        formatNumber(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
        },
        formatNumberEn(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
        },
        getDownStatusColor: function (item) {
            if (item.possible_download === 0) {
                return "red";
            } else {
                if (item.cit_lease_license_use == "1") {
                    return "blue";
                }
                if (item.cit_lease_license_use == "1") {
                    return "green";
                }
                if (item.cit_mastering_license_use == "1") {
                    return "green";
                }
            }
        },
        funcDownStatus: function (item) {
            if (item.possible_download === 0) {
                return "unavailable1";
            } else {
                return "downloadAvailable";
            }
        },
        calcTag: function (hashTag) {
            let rst = "";
            let tags = hashTag.split(",");
            for (let i in tags) {
                rst =
                    rst +
                    "<span><button >" +
                    this.removeReg(tags[i]) +
                    "</button></span>";
            }
            return rst;
        },
        removeReg: function (val) {
            const regExp = /[~!@#$%^&*()_+|'"<>?:{}]/;
            while (regExp.test(val)) {
                val = val.replace(regExp, "");
            }
            return val;
        },
        downloadWithAxios: function (item) {
            axios({
                method: "get",
                url: `/cmallact/download/${this.cor_id}/${item.cde_id}`,
                responseType: "blob",
            })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data], {type: 'application/mp3'}));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', item.cde_originname);
                    document.body.appendChild(link);
                    link.click();
                })
                .catch((error) => console.error(error));
        },
        caclLeftDay: function (orderDate) {
            var tDate = new Date(orderDate);
            var nDate = new Date();
            tDate.setDate(tDate.getDate());
            var diff = tDate.getTime() - nDate.getTime();
            diff = Math.ceil(diff / (1000 * 3600 * 24));
            return diff;
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