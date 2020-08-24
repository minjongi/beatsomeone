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
                policyContent: ''
            }
        },
        created() {
        },
        mounted() {
            axios.get('/document/privacy')
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
</style>
<style lang="css">
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