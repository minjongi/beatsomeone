<template>
    <div>
        <ul class="nav nav-pills nav-fill align-items-center">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:;" @click="$router.push('/inquiry')">{{$t('supportCase')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:;" @click="$router.push('/faq')">FAQ</a>
            </li>
        </ul>
        <div>
            <div class="p-3">
                <button class="btn btn-block btn-warning font-weight-bold" @click="goInquiryenroll">To ask question</button>
            </div>
            <div class="mb-3">
                <ul class="list-group">
                    <li class="list-group-item" v-for="inquiry in inquiry_list" :key="inquiry.post_id" @click="goInquiryview(inquiry)">
                        <div class="d-flex">
                            <div>{{ inquiry.post_title }}</div>
                            <div class="text-center ml-auto w-25">
                                <span class="text-warning" v-if="inquiry.replies.list.length === 0">Wait...</span>
                                <span class="text-secondary" v-else>Answer Complete...</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="paging mb-3" v-html="paging_html" v-show="paging_html">
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <select class="custom-select mr-2" v-html="search_select_html" v-model="search_field">
                        </select>
                    </div>
                    <div class="col-8">
                        <div class="input-group">
                            <input class="form-control" type="text" v-model="search_keyword"
                                   :placeholder="$t('enterYourSearchword')">
                            <div class="input-group-append">
                                <button class="btn btn-default" v-on:click="searchClicked">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import $ from "jquery";
    import axios from "axios";

    export default {
        name: 'InquiryList',
        components: {},
        data: function () {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                inquiry_list: [],
                total_rows: 0,
                popup_filter: 0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
                search_field: 'post_title',
                search_keyword: '',
                search_select_html: '',
                custom_options_html: '',
                selected_option_html: '',
                paging_html: '',
                query_string: '',
            };
        },
        mounted() {
            $('.custom-select .options').on('click', '.option', this.optionClicked);
            $('.paging').on('click', 'a', this.pageClicked);
        },
        created() {
            this.fetchData('');
        },
        methods: {
            goInquiryview(inquiry) {
                this.$router.push({path: '/inquiry/' + inquiry.post_id});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
            goInquiryenroll() {
                this.$router.push({path: '/inquiryenroll'});
            },
            fetchData(q) {
                axios.get('/board/ajax/support?' + q)
                    .then(res => res.data)
                    .then(resBody => {
                        this.total_rows = resBody.data.total_rows;
                        this.inquiry_list = resBody.data.list;
                        this.search_select_html = resBody.search_option;
                        let optionsHtml = $(this.search_select_html);
                        let customOptionsHtml = '';
                        let selected_option_html = '';
                        optionsHtml.each(function (index) {
                            if (index === 0) {
                                selected_option_html = $(this).html();
                            }
                            $(this).attr('selected') ? selected_option_html = $(this).html() : '';
                            customOptionsHtml += '<button data-value="' + $(this).attr('value') + '" class="option ' + ($(this).attr('selected') ? 'selected' : '') + '">' + $(this).html() + '</button>';
                        });
                        this.custom_options_html = customOptionsHtml;
                        this.selected_option_html = selected_option_html;
                        this.paging_html = resBody.paging;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            optionClicked(event) {
                this.search_field = $(event.target).data('value');
                this.selected_option_html = $(event.target).html();
            },
            pageClicked(event) {
                event.preventDefault();
                let page = $(event.target).data('ci-pagination-page');
                this.query_string = `sfield=${this.search_field}&skeyword=${this.search_keyword}&page=${page}`;
                this.fetchData(this.query_string);
                // 'sfield=post_title&skeyword=10';
            },
            searchClicked(event) {
                this.query_string = `sfield=${this.search_field}&skeyword=${this.search_keyword}`;
                this.fetchData(this.query_string);
            },
        },
    }
</script>

<style scoped="scoped" lang="scss">
    .nav {
        background-color: #141418;
        border: solid 1px #333640;
    }

    .nav-pills .nav-link {
        color: #b8b8b9;
        font-weight: 600;
        padding: 1rem;

        &.active {
            background-color: unset;
            color: #ffda2a;
        }
    }

    .list-group-item {
        background-color: #1b1b1e;
    }

</style>