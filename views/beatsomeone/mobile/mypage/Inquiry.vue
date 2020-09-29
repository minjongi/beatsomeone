<template>
    <div class="sublist__content">
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div class="active" @click="goPage('/inquiry')">
                        {{$t('supportCase')}}
                    </div>
                    <div @click="goPage('/faq')">FAQ</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <button class="btn btn--submit" @click="goInquiryEnroll">To ask question</button>
        </div>

        <div class="row">
            <div class="board">
                <ul>
                    <li class="n-box" v-for="inquiry in inquiry_list" :key="inquiry.post_id" @click="goInquiryview(inquiry)">
                        <div class="n-flex setween">
                            <span class="subject">{{ inquiry.post_title }}</span>
                            <span class="action yellow" v-if="inquiry.replies.list.length === 0">
                                Wait...
                            </span>
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
            <div class="n-flex search-wrap">
                <div class="custom-select">
                    <button class="selected-option">{{ $t(search_field) }}</button>
                    <div class="options">
                        <button class="option" @click="search_field = 'post_title'"> {{$t('post_title')}}</button>
                        <button class="option" @click="search_field = 'post_content'"> {{$t('post_content')}}</button>
                    </div>
                </div>
                <div class="input_wrap line">
                    <input type="text" v-model="search_keyword" />
                    <button @click="searchClicked">
                        <img src="/assets/images/icon/searchicon.png" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";

    export default {
        components: {
        },
        data: function () {
            return {
                isLogin: false,
                popup_filter: 0,
                inquiry_list: [],
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
            };
        },
        mounted () {
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
            this.fetchData('');
        },
        created () {
        },
        methods: {
            goPage: function (page) {
                this.$router.push(page);
            },
            goInquiryview (inquiry) {
                this.$router.push('/inquiry/' + inquiry.post_id );
            },
            goInquiryEnroll () {
                this.$router.push({ path: '/inquiryenroll' });
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
            }
        },
    }
</script>

<style scoped="scoped" lang="scss">
    @import "/assets/plugins/slick/slick.css";
    @import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

    .sub .sublist .row {
        margin-bottom: 0;
    }
    .sub .sublist .tab {
        align-items: center;
        background-color: #2b2c30;
        border-bottom: none;
        > div {
            flex: 1;
            text-align: center;
            font-size: 12px;
            line-height: 14px;
            color: rgb(white, 0.7);
            padding: 0 20px;
            &.active {
                color: #ffda2a;
            }
        }
    }
    .sub .playList .playList__item .index {
        color: rgba(white, 0.7);
    }
    .sublist .sort {
        > div {
            + div {
                margin-left: 10px;
            }
        }
    }
    .sub .playList .playList__item .subject {
        font-weight: normal;
    }

    .board {
        .n-box {
            > div {
                background-color: #1b1b1e;
                padding: 16px;
                align-items: center;
                span {
                    font-size: 12px;
                    line-height: 14px;
                    & + span {
                        margin-left: 18px;
                    }
                    &:first-child {
                        // width: calc(100% - 54px -18px);
                        flex: auto;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        color: rgba(white, 0.7);
                    }
                    &:last-child {
                        text-align: center;
                        color: rgba(white, 0.3);
                        min-width: 54px;
                        max-width: 54px;
                    }
                }
            }
        }
    }

    .input_wrap {
        display: flex !important;
        align-items: center;
        font-weight: bolder;

        > * {
            vertical-align: middle;
        }

        & + button {
            margin-left: -4px;
        }

        &.line {
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
        }

        &.round {
            border-radius: 100px;
        }

        &.col {
            flex-direction: column;
        }

        input {
            width: 100%;
            color: white;
            font-size: 14px;

            & ~ * {
                color: white;
            }

            & + button {
                opacity: 0.3;
                transition: 0.3s ease;

                > * {
                    vertical-align: middle;
                }

                &:hover {
                    opacity: 1;
                }
            }
        }

        .inputbox,
        textarea {
            width: 100%;
            font-size: 14px;
            height: 20px;
            padding: 20px 10px;
            border-radius: 4px;
            color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            transition: 0.3s ease;

            &::placeholder {
                color: rgba(255, 255, 255, 0.3);
            }

            &:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            &:focus {
                background: rgba(255, 255, 255, 0.1);
                color: rgba(255, 255, 255, 1);
            }

            & + .btn {
                margin-left: -4px;
            }

            & + .caution {
                width: 100%;
                margin-top: 10px;
            }
        }
    }

    .search-wrap {
        margin-top: 20px;
        .custom-select {
            flex: 1;
            margin-right: 10px;
            min-width: 100px;
            max-width: 100px;
            height: 40px;
            border: 1px solid #414143;
            border-radius: 4px;
            .selected-option {
                width: 100px;
                height: 38px;
                text-align: left;
            }
        }
        .input_wrap {
            flex: 3;
            height: 40px;
            border: 1px solid #414143;
            border-radius: 4px;
        }
    }
</style>