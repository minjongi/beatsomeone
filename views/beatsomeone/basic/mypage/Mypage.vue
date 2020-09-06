<template>
    <div class="wrapper">
        <div class="mypage-wrapper">
            <Header :is-login="isLogin"/>
            <div class="main mypage" style="overflow:initial;">
                <section class="main__section1" style="background:none;">
                    <div
                            class="BG"
                            v-if="isDisplayTop"
                            style="background-image:url('https://images.unsplash.com/photo-1513366208864-87536b8bd7b4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80')"
                    ></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <Dashboard_Header v-if="isDisplayTop"></Dashboard_Header>
                        <div class="main__media">
                            <div class="sublist">
                                <div class="wrap" :class="{'addPaddingTop':!isDisplayTop}">
                                    <CommonSidePanel :userinfo="userInfo" :current="'dashboard'"></CommonSidePanel>
                                    <div class="sublist__content">
                                        <router-view/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <Footer/>
        </div>
    </div>
</template>

<script>
    import Header from "./component/Header";
    import Dashboard_Header from "./component/Dashboard_Header";
    import Footer from "../include/Footer";
    import CommonSidePanel from "./component/CommonSidePanel";
    import {EventBus} from "*/src/eventbus";

    export default {
        name: 'Mypage',
        components: {
            Dashboard_Header,
            CommonSidePanel,
            Header,
            Footer,
        },
        data: function () {
            return {
                isLogin: false,
                isDisplayTop: true,
                userInfo: {},
            };
        },
        watch: {
            $route(to, from) {
                log.debug({
                    "CHANGE ROUTE": this.$router.currentRoute.path,
                });
                this.judgeDisplayTop();
            },
            userInfo(n) {
                this.judgeDisplayTop();
            },
        },
        computed: {
            isCustomer: function () {
                return this.groupType === "CUSTOMER";
            },
            isSeller: function () {
                return this.groupType === "SELLER";
            },
            groupType: function () {
                // return 'CUSTOMER';
                if (this.userInfo && this.userInfo.mem_group) {
                    return this.userInfo.mem_group.mgr_title === "buyer" ? "CUSTOMER" : "SELLER";
                } else {
                    return null;
                }
            },
        },
        mounted() {
            this.judgeDisplayTop();
        },
        created() {
            this.judgeDisplayTop();
            EventBus.$on("Profilemod_Updated", (o) => {
                this.userInfo = o;
            });
        },
        methods: {
            judgeDisplayTop: function () {
                this.isDisplayTop =
                    this.$router.currentRoute.path === "/" && this.isCustomer;
            },
        },
    };
</script>

<style lang="scss">
    $theme-colors: (
            "primary": #4890ff,
            "danger": #ff4848,
            "success": #2dad8e,
            "secondary": #4d4d4d,
    );

    $container-max-widths: (
            sm: 540px,
            md: 720px,
            lg: 960px,
            xl: 1140px,
            xxl: 1420px,
    );

    $grid-gutter-width: 16px;

    @import "~bootstrap/scss/bootstrap";
    @import "@/assets/scss/App.scss";
</style>

<style scoped="scoped" lang="css">
    .addPaddingTop {
        padding-top: 100px;
    }

    .info {
        width: 1090px;
    }
</style>