<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container">
            <div class="main terms">
                <section class="section1">
                    <div class="filter"></div>
                    <div class="wrap">
                        <header class="main__section1-title">
                            <h1>Terms of Service</h1>
                            <p><br/></p>
                        </header>
                        <div class="main__media">
                            <div class="tab">
                                <button :class="tab == 0 ? 'active' : ''" @click="tab = 0">이용약관</button>
                                <button :class="tab == 1 ? 'active' : ''" @click="tab = 1">유료사용자이용약관</button>
                            </div>
                        </div>
                        <div class="tab_container">
                            <div class="tab_content" :class="tab == 0 ? 'active' : ''">
                                <div v-html="provisionTerms">
                                </div>
                            </div>

                            <div class="tab_content" :class="tab == 1 ? 'active' : ''">
                                <div v-html="premiumTerms" class="terms-of-service">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>
<script>
    import {EventBus} from '*/src/eventbus';
    import axios from 'axios';

    export default {
        data: function () {
            return {
                info: {},
                isLogin: false,
                tab: 0,
                provisionTerms: '',
                premiumTerms: ''
            }
        },
        created() {
        },
        mounted() {
            axios.get('/document/provision')
                .then(res => res.data)
                .then(data => {
                    this.provisionTerms = data.doc_content;
                });
            axios.get('/document/premium')
                .then(res => res.data)
                .then(data => {
                    this.premiumTerms = data.doc_content;
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
</style>
<style lang="css">
    .tab_container > .tab_content {
        left: 30px;
        right: 30px;
        overflow: auto;
    }

    ul.tabs {
        display: flex;
        margin-top: 5em;
        margin-bottom: 5em;
    }

    .tabs li {
        display: inline-block;
        width: 20%;
        padding: 15px;
        text-align: center;
        box-sizing: border-box;
        border-bottom: 1px solid #ccc;
        background-color: #eee;
        color: #999;
    }

    .tabs li.active {
        background-color: #045FB4;
        color: #fff;
    }
</style>