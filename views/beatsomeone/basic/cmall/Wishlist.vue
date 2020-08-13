<template>
    <div class="wrapper">
        <div class="smtm9-top">
            <a href="/smtm9"><img src="/assets/images/event/smtm9/top.jpg"></a>
        </div>
        <div class="page-wrapper">
            <Header :is-login="isLogin"></Header>
            <div class="container">
                <div class="main">
                    <section style="margin-bottom:160px;">
                        <div class="BG"></div>
                        <div class="wrap">
                            <header class="main__section1-title">
                                <h1 class="title">FAVORITES</h1>
                            </header>
                            <div class="row">
                                <div class="title-content">
                                    <div class="title" style="justify-content: space-between;">
                                        <label for="checkAll" class="checkbox">
                                            <input type="checkbox" hidden="hidden" id="checkAll" v-model="checkedAll" @change="toggleCheckAll"/>
                                            <span></span>
                                            <div style="font-weight:600">
                                                {{$t('selectAll')}} ({{ cntSelectedItems }}/ {{ totalRows }})
                                            </div>
                                        </label>
                                        <button class="btn btn--red" :class="disableDelete ? 'disable' : ''" style="width:100px; height:40px; margin-bottom:20px; font-size: 14px; font-weight: normal">
                                            <img src="/assets/images/icon/bin.png" style="margin-top:-4px;"/>
                                            {{$t('delete')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <ul class="playList">
                                    <template v-for="item in listItems">
                                        <KeepAliveGlobal :key="item.cit_key">
                                            <WishlistItem :item="item" :key="item.cit_key" v-on:toggleSelected="onCheckClicked"></WishlistItem>
                                        </KeepAliveGlobal>
                                    </template>
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
    import WishlistItem from "./WishlistItem";
    import axios from "axios";

    export default {
        name: "Wishlist",
        components: {
            Header,
            WishlistItem,
            KeepAliveGlobal
        },
        data: function () {
            return {
                isLogin: false,
                totalRows: 0,
                cntSelectedItems: 0,
                listItems: [],
                checkedAll: false,
                disableDelete: true,

            }
        },
        mounted() {
            axios.get('/cmall/wishlist')
                .then(res => res.data)
                .then(data => {
                    this.listItems = data.list;
                    this.listItems.forEach(item => {
                        item.is_selected = false;
                    })
                    this.totalRows = data.total_rows;

                })
                .catch(error => {
                    console.log(error);
                })
        },
        methods: {
            toggleCheckAll: function() {
                if (this.checkedAll) {
                    this.disableDelete = false;
                } else {
                    this.disableDelete = true;
                }
                this.listItems.forEach(item => {
                    item.is_selected = this.checkedAll;
                });
                this.cntSelectedItems = 0;
                this.listItems.forEach(item => {
                    if (item.is_selected) {
                        this.cntSelectedItems++;
                    }
                });
            },
            onCheckClicked: function () {
                this.cntSelectedItems = 0;
                this.listItems.forEach(item => {
                    if (item.is_selected) {
                        this.cntSelectedItems++;
                    }
                })
            }
        },
        watch: {
            listItems: {
                deep: true,
                handler() {
                    this.cntSelectedItems = 0;
                    this.listItems.forEach(item => {
                        if (item.is_selected) {
                            this.cntSelectedItems ++;
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
<style scoped>
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
        margin-left:40px;
        margin-bottom:30px;
        width: auto;
    }
</style>