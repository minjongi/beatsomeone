<template>
    <li class="n-itembox" :class="isOpen ? 'active' : ''">
        <div class="n-item">
            <div class="title">
                <h4 v-html="faq.faq_title" @click="toggleOpen"></h4>
                <div class="btn--fold" @click="toggleOpen"><span></span><span></span></div>
            </div>
            <div class="answer" v-html="faq.faq_content">
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: "FaqItem",
        props: [
            'faq'
        ],
        data: function () {
            return {
                isOpen: false,
            }
        },
        methods: {
            toggleOpen: function () {
                this.isOpen = !this.isOpen;
            }
        }
    }
</script>

<style scoped>
    .btn--fold {
        margin-left: auto;
    }
</style>