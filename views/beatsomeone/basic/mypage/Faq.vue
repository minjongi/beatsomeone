<template>
    <div class="sublist__content" style="margin-bottom:100px;">
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>FAQ</div>
                </div>
                <div class="input_wrap line round" style="width:50%; margin:0 auto; padding:10px 20px;">
                    <input type="text" :placeholder="$t('lang99') + '...'" style="font-size:16px;">
                    <img src="/assets/images/icon/searchicon.png" style="margin:10px;" @click="searchItems"/>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board fold faq">
                <ul>
                    <FaqItem v-for="listItem in list" v-bind:key="listItem.faq_id" v-bind:faq="listItem"/>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import axios from 'axios';
    import FaqItem from "./FaqItem";

    export default {
        components: {
            FaqItem
        },
        data: function () {
            return {
                total_rows: 0,
                list: [],
                skeyword: '',
            };
        },
        mounted() {
            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function () {
                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this)
                    .find(".options")
                    .toggle();
            });

            axios.get('/faq/faq')
                .then(res => res.data)
                .then(data => {
                    this.total_rows = +data.total_rows;
                    this.list = data.list;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        created() {
        },
        methods: {
            searchItems: function () {
                if (this.skeyword.length < 2) {
                    alert('2글자 이상으로 검색해 주세요');
                    return;
                }
                axios.get(`/faq/faq?skeyword=${this.skeyword}`)
                    .then(res => res.data)
                    .then(data => {
                        console.log(data);
                        this.total_rows = +data.total_rows;
                        this.list = data.list;
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>