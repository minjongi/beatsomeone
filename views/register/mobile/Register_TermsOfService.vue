<template>
    <div class="container accounts accounts--start">
        <div style="padding: 0 15px;">
            <h2 class="title">Terms of Service</h2>
        </div>
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
                    if (data.doc_mobile_content) {
                        this.provisionTerms = data.doc_mobile_content;
                    } else {
                        this.provisionTerms = data.doc_content;
                    }
                });
            axios.get('/document/premium')
                .then(res => res.data)
                .then(data => {
                    if (data.doc_mobile_content) {
                        this.premiumTerms = data.doc_mobile_content;
                    } else {
                        this.premiumTerms = data.doc_content;
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
</style>
<style lang="scss">
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

    .tab {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
        padding: 0 20px;
    }
</style>