<template>
    <div class="privacy-policy">
        <h2 class="title">Privacy Policy</h2>
        <div v-html="privacyContent">
        </div>
    </div>
</template>
<script>
    import {EventBus} from '*/src/eventbus';
    import axios from "axios";

    export default {
        data: function () {
            return {
                info: {},
                isLogin: false,
                privacyContent: '',
            }
        },
        created() {

        },
        mounted() {
            axios.get('/document/privacy')
                .then(res => res.data)
                .then(data => {
                    if (data.doc_mobile_content) {
                        this.privacyContent = data.doc_mobile_content;
                    } else {
                        this.privacyContent = data.doc_content;
                    }
                })
        },
        watch: {},
        methods: {},

    }
</script>
<style lang="scss">
    .privacy-policy {
        margin-top: 5em;
        margin-bottom: 5em;
        padding: 0 15px;

        .title {
            font-size: 1.5rem;
            margin-bottom: 40px;
        }
    }
</style>
