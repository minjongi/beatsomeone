<template>

    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container">
            <div class="main">
                <section class="section1">
                    <div class="filter"></div>
                    <div class="wrap">

                        <header class="main__section1-title">
                            <h1>Privacy Policy</h1>
                            <p><br/></p>
                        </header>

                        <div class="tab_container">
                            <div class="tab_content" :class="tab == 0 ? 'active' : ''">
                                <div v-html="policyContent" class="privacy-policy">
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
        <Footer />
    </div>
</template>
<script>
    import axios from 'axios';
    import $ from 'jquery'
    require('@/assets/js/function');

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";

    export default {
        name: "Policy",
        components: {
            Header,
            Footer
        },
        data: function () {
            return {
                info: {},
                isLogin: false,
                tab: 0,
                policyContent: ''
            }
        },
        created() {
        },
        mounted() {
            axios.get('/document/ajax/privacy')
                .then(res => res.data)
                .then(data => {
                    this.policyContent = data.doc_content;
                })
        },
        watch: {},
        methods: {
            onClickTabs(tab) {
                this.selectedTab = tab;
            },
        },

    }
</script>
<style lang="scss">
    @import '@/assets/scss/App.scss';
    .tab_content {
        p {
            margin-left: 32px;
            line-height: 2em;
        }
    }

    .tab_container {
        > .tab_content {
            overflow-y: auto;
        }
    }
</style>
<style lang="scss" scoped>
    .wrapper {
        background: url(/assets/images/signup01-bg.png) no-repeat center -50px;
        background-size: 100% auto;
    }
</style>
