<template>


    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container sub">
            <!--            <div class="main mypage dashboard-wrap" style="overflow:initial;">-->
            <div class="mypage " :class="cssWrap">
                <section class="main__section1" style="background:none;">
                    <div class="BG" v-if="isDisplayTop"
                         style="background-image:url('https://images.unsplash.com/photo-1513366208864-87536b8bd7b4?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2134&q=80')"></div>
<!--                    <div class="filter"></div>-->
                    <div class="wrap">
                        <Dashboard_Header v-if="isDisplayTop"></Dashboard_Header>
                        <div class="main__media">

                            <div class="sublist">
                                <div>
                                    <CommonTopPanel :userinfo="userInfo" :current="'dashboard'"></CommonTopPanel>
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

    require('@/assets_m/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import {EventBus} from '*/src/eventbus';
    import CommonTopPanel from "./component/CommonTopPanel";

    export default {
        components: {
            CommonTopPanel,
            Dashboard_Header,
            Header, Footer
        },
        data: function () {
            return {
                isLogin: false,
                isDisplayTop: true,
                userInfo: null,
                cssWrap: null,
            };
        },
        watch: {
            $route(to, from) {
                log.debug({
                    'CHANGE ROUTE': this.$router.currentRoute.path,
                });
                this.judgeDisplayTop();
            },
            userInfo(n) {
                this.judgeDisplayTop();
            },
        },
        computed: {
            isCustomer: function () {
                if (this.userInfo) {
                    return this.userInfo.mem_group.mgr_title === 'buyer';
                } else {
                    return '';
                }
            },
            isSeller: function () {
                return this.userInfo.mem_group.mgr_title.includes('seller');
            },
            groupType: function () {
                // return 'CUSTOMER';
                if (this.userInfo) {
                    return this.userInfo.mem_usertype === '1' ? 'CUSTOMER' : 'SELLER';
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
            EventBus.$on('Profilemod_Updated', o => {
                this.userInfo = o;
            })
        },
        methods: {
            judgeDisplayTop: function () {
                this.isDisplayTop = this.$router.currentRoute.path === '/' && this.isCustomer;

                switch (this.$router.currentRoute.path) {
                    case '/':
                        this.cssWrap = 'dashboard-wrap';
                        break;
                    case '/profilemod':
                        this.cssWrap = 'profilemod-wrap';
                        break;
                }

            },

        }
    }
</script>


<style lang="css">
    div.sublist__content {
        min-height: 500px !important;
    }
</style>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    .addPaddingTop {
        padding-top: 100px;
    }

</style>