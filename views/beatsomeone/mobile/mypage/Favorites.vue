<template>
    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container">
            <div class="nfavorites">
                <div class="nfavorites__header">
                    <div class="wrap">
                        <h2>{{ $t('favorite') }}</h2>
                    </div>
                </div>
                <section class="nfavorites__body">
                    <div class="nfavorites__actions">
                        <div class="left">
                            <label class="checkbox nfavorites__checkbox">
                                <input type="checkbox" hidden v-model="checkedAll" @change="toggleCheckAll">
                                <span style="margin-right: 5px;"></span> &nbsp; {{$t('selectAll')}} ({{ cntSelectedItems }}/ {{ totalRows }})
                            </label>
                        </div>
                        <div class="right">
                            <button class="nfavorites__delete" :disabled="cntSelectedItems === 0" @click="listDelete">
                                <i></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="playList">
                        <ul>
                            <li class="playList__itembox" v-for="(item, index) in listItems" :key="index">
                                <div class="playList__item playList__item--title">
                                    <div class="col favorite">
                                        <label class="checkbox nfavorites__checkbox">
                                            <input type="checkbox" hidden v-model="item.is_selected" @change="checkChanged">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col name">
                                        <figure>
                                            <span class="playList__cover">
                                                <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt/>
                                                <i class="label new">N</i>
                                            </span>
                                            <button class="btn-play">재생</button>
                                            <div class="wave"></div>
                                            <figcaption>
                                                <h3 class="playList__title">{{ item.cit_name }}</h3>
                                                <div class="playList__bottom-info">
                                                    <span class="playList__by">{{ item.mem_nickname }}</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div class="col btns">
                                        <button>
                                            cart
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
        <Footer/>
        <main-player></main-player>
    </div>
</template>

<script>
    import axios from "axios";

    require("@/assets_m/js/function");
    import Header from "../include/Header";
    import Footer from "../include/Footer";
    import MainPlayer from "@/vue/common/MainPlayer";
    import $ from "jquery";

    export default {
        components: {
            Header,
            Footer,
            MainPlayer,
        },
        data: function () {
            return {
                isLogin: false,
                totalRows: 0,
                cntSelectedItems: 0,
                listItems: [],
                checkedAll: false,
                disableDelete: true,
                busy: false,
            };
        },
        created() {
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
        computed: {},
        methods: {
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
            listDelete: function () {
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
    };
</script>

<style lang="scss">
    @import "@/assets_m/scss/App.scss";
</style>

<style lang="scss">
    .nfavorites {
        padding-top: 94px;
        background: url('/assets_m/images/favorites-bg.png') no-repeat left top;
        background-size: 100% auto;

        .nfavorites__header {
            .wrap {
                padding-left: 5px;

                h2 {
                    text-transform: uppercase;
                }
            }
        }
    }

    .nfavorites__header {
        padding-left: 30px;
        margin-bottom: 50px;
    }

    .nfavorites__header h2 {
        font-size: 30px;
    }

    .nfavorites__checkbox {
        justify-content: center;
    }

    .nfavorites__checkbox span {
        margin-right: 0;
        width: 15px;
        height: 15px;
    }

    .nfavorites__checkbox input:checked + span {
        border: none;
        background: url('/assets_m/images/icon/checkbox-on.png') no-repeat center;
        background-size: 15px 15px;
    }

    .nfavorites__actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-left: 18px;
        padding-right: 16px;
    }

    .nfavorites__delete {
        width: 80px;
        height: 30px;
        background: #ff5858;
        color: #fff;
        text-align: center;
        font-weight: 300;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 3px;
        transition: all .3s;
    }

    .nfavorites__delete:disabled {
        opacity: .4;
    }

    .nfavorites__delete i {
        background: url('/assets_m/images/trash.png') no-repeat center;
        width: 16px;
        background-size: auto 16px;
        height: 16px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }

    .nfavorites .playList .playList__item {
        display: flex;
    }

    .nfavorites .playList .playList__item .btns {
        width: 35px;
        margin-left: auto;
        margin-right: 15px;
    }

    .nfavorites .playList .playList__item .btns {
        a,button {
            width: 35px;
            height: 35px;
            background: #4890ff url('/assets_m/images/cart.png') no-repeat center;
            border-radius: 50%;
            display: block;
            text-indent: -9999px;
            overflow: hidden;
        }
    }

    .playList {
        .playList__itembox {
            height: 70px !important;

            .playList__item {
                height: auto;
            }
        }
    }
</style>