<template>
    <div class="wrapper">
        <Header />
        <div class="main mypage">
            <section class="main__section1" style="background:none;">
                <div
                        class="BG"
                        v-if="isDisplayTop"
                        style="background-image:url('https://images.unsplash.com/photo-1513366208864-87536b8bd7b4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80')"
                ></div>
                <div class="filter"></div>
            </section>
            <Banner v-if="member_group_name === 'buyer' && $route.path === '/'"></Banner>
            <div class="container pt-6">
                <div class="position-relative">
                    <CommonSidePanel :userinfo="userInfo" :current="'dashboard'"></CommonSidePanel>
                    <div class="main-content">
                        <router-view/>
                    </div>
                </div>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>
    import Header from "./component/Header";
    import Banner from "./component/Banner";
    import Footer from "../include/Footer";
    import CommonSidePanel from "./component/CommonSidePanel";
    import {EventBus} from "*/src/eventbus";

    export default {
        name: 'Mypage',
        components: {
            Banner,
            CommonSidePanel,
            Header,
            Footer,
        },
        data: function () {
            return {
                isLogin: false,
                isDisplayTop: true,
                userInfo: {},
                member_group_name: '',
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
            this.member_group_name = window.member_group_name;
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

    .text-decoration-underline {
        text-decoration: underline;
    }
</style>

<style scoped="scoped" lang="scss">
    .addPaddingTop {
        padding-top: 100px;
    }

    .info {
        width: 1090px;
    }

    .main-content {
        padding-left: 300px;
        min-height: 950px;
    }

    .pt-6 {
        padding-top: 6rem;
    }
</style>