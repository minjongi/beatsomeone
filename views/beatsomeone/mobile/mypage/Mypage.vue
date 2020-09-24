<template>


    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container sub">
            <div class="mypage " :class="cssWrap">
                <section class="main__section1" style="background:none;">
                    <div class="BG" v-if="isDisplayTop" style="background-image:url('/assets/images/bg1.jpg')"></div>
                    <div class="filter"></div>
                    <div class="wrap">
                        <Dashboard_Header v-if="isDisplayTop"></Dashboard_Header>
                        <div class="main__media">
                            <div class="sublist">
                                <div>
                                    <CommonTopPanel />
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
            Header,
            Footer
        },
        data: function () {
            return {
                isLogin: false,
                isDisplayTop: true,
                userInfo: null,
                cssWrap: null,
                member_group_name: ''
            };
        },
        watch:{
            $route (to, from){
                log.debug({
                    'CHANGE ROUTE':this.$router.currentRoute.path,
                });
                this.judgeDisplayTop();
            },
            userInfo(n) {
                this.judgeDisplayTop();
            },
        },
        computed: {
            isCustomer: function () {
                return this.member_group_name === 'buyer';
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
            EventBus.$on('Profilemod_Updated', o => {
                this.userInfo = o;
            })
        },
        methods: {
            judgeDisplayTop: function () {
                this.isDisplayTop = this.$router.currentRoute.path === '/';

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