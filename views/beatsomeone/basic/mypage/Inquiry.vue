<template>
    <div class="sublist__content" style="margin-bottom:100px;">
        <div class="row" style="margin-bottom:30px;">
            <div class="title-content">
                <div class="title">
                    <div>{{$t('support1')}}</div>
                    <button class="btn btn--submit" @click="goInquiryenroll">{{ $t('lang78') }}</button>
                </div>
                <p>
                    Total <span>{{ total_rows }}</span> cases.
                </p>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab nowrap">
                    <div class="index">{{ $t('lang79') }}</div>
                    <div class="subject">{{ $t('lang80') }}</div>
                    <div class="date">{{ $t('lang81') }}</div>
                    <div class="action">{{ $t('lang82') }}</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList board inquirylist">

                <ul>
                    <li class="playList__itembox" v-for="(inquiry, index) in inquiry_list" :key="inquiry.post_id" @click="goInquiryview(inquiry)">
                        <div class="playList__item playList__item--title nowrap active">
                            <div class="index">{{ index + 1 }}</div>
                            <div class="subject">{{ truncate(inquiry.post_title, 30) }}</div>
                            <div class="date">
                                {{ inquiry.post_datetime }}
                            </div>
                            <div class="action active" v-if="inquiry.replies.list.length === 0">
                                Wait...
                            </div>
                            <div class="action" v-else>
                                Answer Complete...
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row paging" style="margin-bottom:30px;" v-html="paging_html" v-show="paging_html">
        </div>

        <div class="row">
            <div class="sort" style="display:flex; width:50%; margin:auto; flex-flow:row nowrap">
                <div class="custom-select">
                    <button class="selected-option">
                        {{ $t(search_field) }}
                    </button>
                    <div class="options">
                        <button class="option" @click="search_field = 'post_title'"> {{$t('post_title')}}</button>
                        <button class="option" @click="search_field = 'post_content'"> {{$t('post_content')}}</button>
                    </div>
                </div>
                <div class="input_wrap line" style="margin-left:20px; width:100%;">
                    <input type="text" v-model="search_keyword">
                    <button @click="searchClicked"><img src="/assets/images/icon/searchicon.png"/></button>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import $ from "jquery"

    export default {
        components: {
        },
        data: function() {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                inquiry_list: [],
                popup_filter:0,
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
                total_rows: 0,
            }
        },
        mounted(){
            // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function() {
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
            $('.paging').on('click', 'a', this.pageClicked);
        },
        created() {
            this.fetchData('');
        },
        methods:{
            goInquiryview(inquiry) {
                this.$router.push({path: '/inquiry/' + inquiry.post_id });
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
            goInquiryenroll() {
                this.$router.push({path: '/inquiryenroll'});
            },
            fetchData(q) {
                Http.get('/board/ajax/support?' + q)
                    .then(r => r.data)
                    .then(resBody => {
                        this.total_rows = resBody.data.total_rows;
                        this.inquiry_list = resBody.data.list;
                        this.search_select_html = resBody.search_option;
                        let optionsHtml = $(this.search_select_html);
                        let customOptionsHtml = '';
                        let selected_option_html = '';
                        optionsHtml.each(function(index) {
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
            truncate(str, n) {
                return (str.length > n) ? str.substr(0, n-1) + '...' : str;
            },
        },
    }
</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>