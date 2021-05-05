<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title other">
            <div class="n-flex between">
                <div class="info">
                    <div class="code">{{ item.item.cit_key }}</div>
                </div>
                <div class="edit" style="margin-right: 80px">
                    <div
                        class="download_status"
                        :class="getDownStatusColor(item.item)"
                    >{{ $t(funcDownStatus(item.item)) }}
                    </div>
                </div>
                <div class="price" style="color: #ffda2a;">
                    {{
                        formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, pg)
                    }}
                </div>
            </div>

            <div class="name"  style="margin-right: 0; padding:0">
                <div style="display:flex; justify-content: space-between; width: 100%;">
                    <div style="display:flex;">
                        <div class="playList__cover">
                          <img src="/assets/images/cover_default.png" :alt="item.item.cit_name" v-if="!item.item.cit_file_1"/>
                          <img :src="'/uploads/cmallitem/' + item.item.cit_file_1" :alt="item.item.cit_name" v-else/>
                          <i v-if="item.item.is_new" class="label new">N</i>
                        </div>
                        <figcaption class="pointer">
                            <h3 class="playList__title">{{ formatCitName(item.item.cit_name,25) }}</h3>
                            <span class="playList__by">by {{ item.item.mem_nickname }}</span>
                            <!-- <span style="margin-top: 5px; display: block;" v-if="item.item.bpm" class="playList__bpm">{{ getGenre(item.item.genre, item.item.subgenre) }} | {{ item.item.bpm }}BPM</span>
                            <span style="margin-top: 5px; display: block;" v-else class="playList__bpm">{{ getGenre(item.item.genre, item.item.subgenre) }}</span> -->
                        </figcaption>
                    </div>
                    <button v-if="item.item.possible_download === 1"
                            @click="downloadWithAxios(item.itemdetail[0])" class="btn-edit">
                        <img src="/assets/images/icon/down.png"/>
                    </button>
                    <button v-else class="btn-edit unable">
                        <img src="/assets/images/icon/down.png"/>
                    </button>
                </div>
            </div>
            <div class="col n-option">
                <div class="option">
                    <div class="n-box" v-if="item.itemdetail[0].cde_title === 'STEM'">
                        <div>
                            <button class="playList__item--button">
                                    <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                                    @click.self="toggleButton"/></span>
                                <div>
                                    <div class="title" @click.self="toggleButton">{{ $t('lang30') }}
                                    </div>
                                    <div class="detail">{{ $t('lang31') }}
                                        <span class="copytransfer" v-if="item.item.cit_include_copyright_transfer === '1'">{{ $t('lang32') }}</span>
                                    </div>
                                </div>
                            </button>
                            <ParchaseComponent :item="item" :type="'mastering'"></ParchaseComponent>
                        </div>
                    </div>
                    <div class="n-box" v-else-if="item.itemdetail[0].cde_title === 'LEASE'">
                        <div>
                            <button class="playList__item--button">
                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                                                               @click.self="toggleButton"/></span>
                                <div>
                                    <div class="title" @click.self="toggleButton">{{ $t('lang23') }}
                                    </div>
                                    <div class="detail">{{ $t('lang24') }}</div>
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
    mounted() {
        console.log(this.item);
    },
    methods: {
        formatCitName: function (data, limitLth) {
            return this.truncate(data, limitLth);
        },
        truncate(str, n) {
            return (str.length > n) ? str.substr(0, n-1) + '...' : str;
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
                if (item.possible_refund == 1) {
                    return "blue";
                } else {
                    return 'green'
                }
            }
        },
        funcDownStatus: function (item) {
            if (item.possible_download === 0) {
                return "unavailable1";
            } else {
                if (item.possible_refund == 1) {
                    return "downloadAvailable";
                } else {
                    return 'downloadComplete'
                }
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
            alert(this.$t('lang166'))
            window.open(`/cmallact/download/${this.cor_id}/${item.cde_id}`)

            // axios({
            //     method: "get",
            //     url: `/cmallact/download/${this.cor_id}/${item.cde_id}`,
            //     responseType: "blob",
            // })
            // .then((response) => {
            //     const url = window.URL.createObjectURL(new Blob([response.data], {type: 'application/mp3'}));
            //     const link = document.createElement('a');
            //     link.href = url;
            //     link.setAttribute('download', item.cde_originname);
            //     document.body.appendChild(link);
            //     link.click();
            // })
            // .catch((error) => {
            //     if (error.message == "Request failed with status code 405") {
            //         alert('이번달 다운로드 횟수가 모두 소진 되었습니다.');
            //     }
            //     console.error(error)
            // });
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
.cover_image{
    width: 32px;
    height: 32px;
    margin-right: 10px;
    border-radius: 5px;
}
</style>