<template>

    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container accounts accounts--start">
            <div style="padding: 0 15px;">
                <h2 class="title">Privacy Policy</h2>
            </div>
            <div class="tab_container">
                <div class="tab_content active">
                    <div v-html="policyContent">
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>
<script>
    import axios from 'axios';
    require('@/assets_m/js/function');

    import Header from "@/views/beatsomeone/mobile/include/Header";
    import Footer from "@/views/beatsomeone/mobile/include/Footer";

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
                    if (data.doc_mobile_content) {
                        this.policyContent = data.doc_mobile_content;
                    } else {
                        this.policyContent = data.doc_content;
                    }
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
    @import '@/assets_m/scss/App.scss';
</style>
<style lang="scss" scoped>
    .title {
        font-size: 1.5rem;
        margin-bottom: 40px;
    }

    .tab_container > .tab_content {
        height: calc(100% - 60px);
        line-height: 2em !important;
        display: none;
        -webkit-transition: 0.3s ease;
        transition: 0.3s ease;
        pointer-events: none;
        left: 15px;
        right: 15px;
        overflow: auto;

        > div {
            padding: 15px;
        }

        &.active {
            pointer-events: initial;
            display: block;
        }
    }
</style>
