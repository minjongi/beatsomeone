<template>
    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container sub">
            <div class="main mypage sublist" style="overflow:initial;">
                <section class="main__section1" style="background:none;">
                    <div
                            class="BG"
                            v-if="isDisplayTop"
                            style="background-image:url('/assets/images/bg1.jpg?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80')"
                    ></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <Dashboard_Header v-if="isDisplayTop"></Dashboard_Header>
                        <div class="main__media">
                            <div class="sublist">
                                <div class="wrap" :class="{'addPaddingTop':!isDisplayTop}">
                                    <CommonSidePanel />
                                    <div class="sublist__content">
                                        <router-view/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>
    import Dashboard_Header from "./component/Dashboard_Header";

    require("@/assets/js/function");
    import Header from "../include/Header";
    import Footer from "../include/Footer";
    import CommonSidePanel from "./component/CommonSidePanel";
    import {EventBus} from "*/src/eventbus";

    export default {
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
                userInfo: null,
                member_group_name: ''
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
                return this.member_group_name === "buyer";
            },
            isSeller: function () {
                return this.member_group_name.includes('seller');
            },
        },
        mounted() {
            this.member_group_name = window.member_group_name;
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
                this.isDisplayTop = this.$route.path === "/";
            },
        },
    };
</script>

<style lang="scss">
    @import "@/assets/scss/App.scss";
</style>

<style scoped="scoped" lang="css">
    .addPaddingTop {
        padding-top: 100px;
    }

    .container.sub {
        padding-top: 0;
    }

    .sublist {
        padding-top: 0;
    }

    .sublist .wrap {
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
    }
</style>