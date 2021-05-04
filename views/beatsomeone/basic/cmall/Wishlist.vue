<template>
    <div class="wrapper">
        <div class="page-wrapper">
            <Header :is-login="isLogin"></Header>
            <div class="container">
                <div class="main">
                    <section style="margin-bottom:160px;">
                        <div class="BG"></div>
                        <div class="wrap">
                            <header class="main__section1-title">
                                <h1 class="title">{{ $t('favorite') }}</h1>
                            </header>
                            <div class="row">
                                <div class="title-content">
                                    <div class="title" style="justify-content: space-between;">
                                        <label for="checkAll" class="checkbox">
                                            <input type="checkbox" hidden="hidden" id="checkAll" v-model="checkedAll"
                                                   @change="toggleCheckAll"/>
                                            <span></span>
                                            <div style="font-weight:600">
                                                {{$t('selectAll')}} ({{ cntSelectedItems }}/ {{ totalRows }})
                                            </div>
                                        </label>
                                        <button class="btn btn--red" :class="cntSelectedItems === 0 ? 'disable' : ''" style="width:100px; height:40px; margin-bottom:20px; font-size: 14px; font-weight: normal" @click="cartDelete">
                                            <img src="/assets/images/icon/bin.png" style="margin-top:-4px;"/>
                                            {{$t('delete')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="playList">
                                    <!--                                    <template >-->
                                    <!--                                        <KeepAliveGlobal :key="item.cit_key">-->
                                    <li v-for="(item, index) in listItems" v-bind:key="index" class="playList__itembox">
                                        <div class="playList__item playList__item--title">
                                            <div class="col check">
                                                <label class="checkbox">
                                                    <input type="checkbox" hidden="hidden" v-model="item.is_selected" @change="checkChanged" />
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover"><img :src="'/uploads/cmallitem/' + item.cit_file_1" alt/><i class="label new" ng-if="item.isNew">N</i></span>
                                                    <figcaption class="pointer" @click="selectItem(item)">
                                                        <h3 class="playList__title">{{ item.cit_name }}</h3>
                                                        <span class="playList__by">by {{ item.mem_nickname }}</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col genre">
                                                <!--                                                        <span v-for="(t,i) in hashtag" :key="i"><button @click="clickHash(t)" v-hover="'active'">{{ t }}</button></span>-->
                                            </div>
                                            <div class="col playbtn" v-if="item.detail.length > 0">
                                                <button class="btn-play" @click="playAudio(index)">재생</button>
                                                <span class="timer"><span class="current">0:00 / </span><span
                                                        class="duration">{{ item.detail[0].duration }}</span></span>
                                            </div>
                                            <div class="col spectrum">
                                                <div class="wave">
                                                    <VueWaveSurfer ref="surfer" :detail="item.detail[0]" :options="options"></VueWaveSurfer>
                                                </div>
                                            </div>
                                            <div class="col price">
                                                <span>{{ $t('currencySymbol') }} {{ $i18n.locale === 'ko' ? item.detail[0].cde_price : item.detail[0].cde_price_d }}</span>
                                            </div>
                                            <div class="col edit ml-auto">
                                                <button class="btn btn--blue round"
                                                        style="height:40px; padding:0 16px;" @click="togglePopup(item)">
                                                    {{$t('buyNow')}}
                                                </button>
                                            </div>
                                        </div>
                                        <SelectorModal :togglePopup.sync="item.toggle_popup" :item="item"/>
                                    </li>
                                    <!--                                        </KeepAliveGlobal>-->
                                    <!--                                    </template>-->
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    require("@/assets/js/function");
    import Header from "../include/Header";
    import KeepAliveGlobal from "vue-keep-alive-global";
    import VueWaveSurfer from '../component/VueWaveSurfer';
    import axios from "axios";
    import $ from 'jquery';
    import SelectorModal from "../component/SelectorModal";

    export default {
        name: "Wishlist",
        components: {
            SelectorModal,
            Header,
            KeepAliveGlobal,
            VueWaveSurfer,
        },
        data: function () {
            return {
                isLogin: false,
                totalRows: 0,
                cntSelectedItems: 0,
                listItems: [],
                checkedAll: false,
                disableDelete: true,
                options: {
                    height: 90,
                    progressColor: '#ffda2a',
                    cursorWidth: 0,
                },
            }
        },
        mounted() {

            axios.get('/cmall/wishlist')
                .then(res => res.data)
                .then(data => {
                    this.listItems = data.list;
                    this.totalRows = data.total_rows;
                    this.listItems.forEach((item, index) => {
                        item.is_selected = false;
                        for (let i = 0; i < item.detail.length; i++) {
                            let musicUrl = `/uploads/cmallitemdetail/${item.detail[i].cde_filename}`;

                            let au = document.createElement('audio');
                            au.src = musicUrl;
                            au.setAttribute('data-cit_idx', index);
                            au.setAttribute('data-cde_idx', i);
                            au.addEventListener('loadedmetadata', this.getDuration)
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods: {
            toggleCheckAll: function () {
                if (this.checkedAll) {
                    this.disableDelete = false;
                } else {
                    this.disableDelete = true;
                }
                this.listItems.forEach(item => {
                    this.$set(item, 'is_selected', this.checkedAll);
                });
                this.cntSelectedItems = 0;
                this.listItems.forEach(item => {
                    if (item.is_selected) {
                        this.cntSelectedItems++;
                    }
                });
            },
            toMMSS: function (second_num) {
                let minutes = Math.floor(second_num / 60);
                let seconds = Math.floor(second_num - (minutes * 60));
                if (minutes < 10) {
                    minutes = "0" + minutes;
                }
                if (seconds < 10) {
                    seconds = "0" + seconds;
                }
                return minutes + ':' + seconds;
            },
            getDuration: function (event) {
                let idx0 = $(event.target).data('cit_idx');
                let idx1 = $(event.target).data('cde_idx');
                let detailItem = this.listItems[idx0].detail[idx1];
                this.$set(detailItem, 'duration', this.toMMSS(event.target.duration));
            },
            playAudio: function (index) {
                this.$refs.surfer[index].playPause();
            },
            selectItem: function (i) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, `/detail/${i.cit_key}`);
            },
            togglePopup: function (item) {
                this.$set(item, 'toggle_popup', true);
            },
            cartDelete: function () {
                this.listItems.forEach(item => {
                    if (item.is_selected) {
                        axios.post(`/cmallact/wishlist_delete/${item.cwi_id}`)
                            .then(res => res.data)
                            .then(data => {
                                this.listItems = data.list;
                                this.totalRows = data.total_rows;
                            })
                            .catch(error => {
                                console.error(error);
                            })
                    }
                });
            },
            checkChanged: function () {
                this.cntSelectedItems = 0;
                this.listItems.forEach(item => {
                    if (item.is_selected) {
                        this.cntSelectedItems++;
                    }
                });
            }
        },
        watch: {
            listItems: {
                deep: true,
                handler() {
                    this.cntSelectedItems = 0;
                    this.listItems.forEach(item => {
                        if (item.is_selected) {
                            this.cntSelectedItems++;
                        }
                    });
                }
            }
        }
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>
<style lang="scss">
    .BG {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 540px;
        overflow: hidden;
        background-repeat: no-repeat;
        background-image: linear-gradient(#ffffff00 75%, #000), url('/assets/images/wishlist.png');
    }

    .title-content .title .checkbox {
        margin-left: 40px;
        margin-bottom: 30px;
        width: auto;
    }

    .main .main__section1-title .title {
        text-transform: uppercase;
    }

    .playList .playList__item {
        padding: 0 40px;

        .favorite {
            text-align: left;
            width: 45px;
        }

        .playList__title {
            font-size: 16px !important;
        }

        .playbtn:after {
            content: none;
        }

        .price {
            width: 120px;
            text-align: center;
        }

        .spectrum .wave {
            canvas {
                z-index: 3 !important;
            }
        }
    }
</style>