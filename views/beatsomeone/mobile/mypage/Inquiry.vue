<template>
    <div class="sublist__content">
        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div :class="$route.path === '/inquiry' ? 'active' : ''" @click="goPage('inquiry')">
                        {{$t('supportCase')}}
                    </div>
                    <div @click="goPage('faq')">FAQ</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <button class="btn btn--submit" @click="goInquiryEnroll()">To ask question</button>
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
                            <span class="action" v-else>
                                Answer Complete...
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row" v-html="paging_html" v-show="paging_html">
        </div>

<!--        <div class="row">-->
<!--            <div class="pagination">-->
<!--                <div>-->
<!--                    <button class="prev active">-->
<!--                        <img src="/assets/images/icon/chevron_prev.png"/>-->
<!--                    </button>-->
<!--                    <button class="active">1</button>-->
<!--                    <button>2</button>-->
<!--                    <button>3</button>-->
<!--                    <button class="next active">-->
<!--                        <img src="/assets/images/icon/chevron_next.png"/>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div class="row">
            <div class="n-flex search-wrap">
                <div class="custom-select">
                    <button class="selected-option" :data-value="search_field">
                        {{ selected_option_html }}
                    </button>
                    <div class="options" v-html="custom_options_html">
                    </div>
                    <select v-html="search_select_html" v-model="search_field">
                    </select>
                </div>
                <div class="input_wrap line">
                    <input type="text" v-model="search_keyword" :placeholder="$t('enterYourSearchword')"/>
                    <button v-on:click="searchClicked">
                        <img src="/assets/images/icon/searchicon.png"/>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import axios from 'axios';

    export default {
        components: {},
        data: function () {
            return {
                isLogin: false,
                popup_filter: 0,
                inquiry_list: [],
                total_rows: 0,
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
            // 커스텀 셀렉트 옵션
            // $(".custom-select").on("click", function () {
            //     $(this)
            //         .siblings(".custom-select")
            //         .removeClass("active")
            //         .find(".options")
            //         .hide();
            //     $(this).toggleClass("active");
            //     $(this)
            //         .find(".options")
            //         .toggle();
            // });
            $('.custom-select .options').on('click', '.option', this.optionClicked);
            $('.paging').on('click', 'a', this.pageClicked);
        },
        created() {
            this.fetchData('');
        },
        methods: {
            goPage: function (page) {
                this.$router.push({
                    path: page
                })
            },
            goInquiryview: function(inquiry) {
                this.$router.push({path: `/inquiry/${inquiry.post_id}`});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
            goInquiryEnroll() {
                this.$router.push({path: '/inquiryenroll'});
            },
            fetchData(q) {
                axios.get('/board/support?' + q)
                    .then(res => res.data)
                    .then(data => {
                        this.total_rows = data.data.total_rows;
                        this.inquiry_list = data.data.list;
                        this.search_select_html = data.search_option;
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
                        this.paging_html = data.paging;
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

            select {
                display: none;
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