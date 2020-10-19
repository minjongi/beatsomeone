<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title nowrap" :class="isOpen ? 'active' : ''">
            <div>
                <div class="subject" @click="toggleOpen" v-html="faq.faq_title"></div>
                <div class="answer fold" v-html="faq.faq_content">
                </div>
            </div>
            <div class="btn--fold" @click="toggleOpen">
                <div></div>
                <div></div>
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

</style>