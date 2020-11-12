<template>
    <div class="sublist__content">

        <div class="row" style="margin-bottom:20px;">
            <div class="main__media board inquirylist">
                <div class="tab" style="height:48px;">
                    <div class="active" @click="goPage('/inquiry')">{{$t('supportCase')}}</div>
                    <div @click="goPage('/faq')">FAQ</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:20px;">
            <button class="btn btn--gray" @click="goPage('/inquiry')">{{$t('back')}}</button>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="content-header">
                <div class="n-flex column">
                    <h4 class="category">{{ $t('lang93') }}</h4>
                    <h3 class="body" style="word-break: break-all;">{{ post.post_title }}</h3>
                </div>

                <div class="n-flex">
                    <span class="category">{{ $t('lang94') }}</span>
                    <div class="body action" v-if="replies.length > 0">{{ $t('lang112') }}...</div>
                    <div class="body action active" v-else>{{ $t('lang111') }}...</div>
                </div>
                <div class="n-flex">
                    <span class="category">{{ $t('lang95') }}</span>
                    <span class="body">{{ post.post_datetime }}</span>
                </div>
                <div class="n-flex column">
                    <div class="category">{{ $t('lang96') }}</div>
                    <div class="flie_list">
                        <button class="btn--file" v-for="file in files" v-bind:key="file.pfi_id" @click="downloadAxios(file)">
                            <img src="/assets/images/icon/file.png"/>
                            <span>{{ file.pfi_originname }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-bottom:30px;">
            <div class="playList array inquiryview">

                <ul>
                    <li class="playList__itembox">
                        <div class="playList__item playList__item--title nowrap question stay" style="min-height: 60px;">
                            <div class="row">
                                <div class="mark">Q</div>
                                <div class="answer" style="word-break: break-all;" v-html="contentToHtml(post.post_content)">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" v-for="comment in comments" v-bind:key="comment.cmt_id">
                        <div class="playList__item playList__item--title nowrap question">
                            <div class="row">
                                <div class="mark"></div>
                                <div class="answer" style="word-break: break-all;" v-html="contentToHtml(comment.cmt_content)">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="playList__itembox" v-for="reply in replies" v-bind:key="reply.post_id">
                        <div class="playList__item playList__item--title nowrap question complete" style="min-height: 60px;">
                            <div class="row">
                                <div class="mark">{{ reply.post_reply }}</div>
                                <div class="answer" style="word-break: break-all;" v-html="reply.post_content">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div>
                <button class="btn btn--gray" style="margin-bottom: 16px;" @click="goPage('/inquiry')">{{ $t('back') }}</button>
                 <button type="submit" class="btn btn--submit" @click="goInquirymod">{{ $t('lang98') }}</button>
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
                group_title: 'SELLER',
                product_status: 'PENDING',
                popup_filter:0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
                post: {},
                files: [],
                mem_is_admin: false,
                cmt_content: '',
                current_user: {},
                comments: [],
                replies: [],
                post_content: '',
                post_title: ''
            };
        },
        mounted() {
            const post_id = this.$route.params.post_id;
            axios.get(`/post/ajax/${post_id}`)
                .then(res => res.data)
                .then(data => {
                    this.post = data.post;
                    this.files = data.file;
                    this.replies = data.post.replies.list;

                    axios.get(`/comment_list/ajax_lists/${this.post.post_id}`)
                        .then(res => res.data)
                        .then(data => {
                            this.comments = data.list;
                        })
                        .catch(error => {
                            console.log(error);
                        })
                })
                .catch(error => {
                    console.error(error);
                });
            axios.get('/mypage/current_user')
                .then(res => res.data)
                .then(data => {
                    this.current_user = data;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        created() {
        },
        methods: {
            goPage: function (page) {
                this.$router.push(page);
            },
            goInquiryview() {
                this.$router.push({path: '/inquiryview'});
            },
            goInquirymod() {
                const post_id = this.$route.params.post_id;
                this.$router.push({path: `/inquiry/${post_id}/edit`});
            },
            goInquiryList() {
                this.$router.push({path: '/inquiry'});
            },
            goBack() {
                this.$router.go(-1);
            },
            downloadAxios(file) {

                axios({
                    method: "get",
                    url: `/uploads/post/${file.pfi_filename}`,
                    responseType: "blob",
                })
                    .then((response) => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', file.pfi_originname);
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch((error) => console.error(error));
                console.log(file);
            },
            contentToHtml(post_content) {
                if (post_content) {
                    var paragraphs = post_content.split('\n');
                    var html = "";
                    paragraphs.forEach(paragraph => {
                        html += `<p>${paragraph}</p>`;
                    });
                    return html;
                } else {
                    return ""
                }
            }
        },
    }
</script>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

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

    .category {
        min-width: 130px;
        max-width: 130px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .n-flex {
        & + .n-flex {
            margin-top: 20px;
            line-height: 16px;
        }

        .body.active {
            color: #ffda2a;
        }
    }

    .flie_list {
        button {
            float: left;
            margin-right: 16px;
            color: rgba(white, 0.7);
            display: flex;
            margin-bottom: 5px;
            align-items: center;
            font-size: 14px;

            > img {
                margin-right: 4px;
            }
        }
    }

    .inquiryview {
        margin-right: -16px;
        margin-left: -16px;
    }

    .question {
        background-color: #2B2C30;
        padding: 16px;

        .row {
            position: relative;

            .mark {
                position: absolute;
                font-size: 32px;
                line-height: 1;
                font-weight: 600;

            }

            .answer {
                font-size: 14px;
                line-height: 1.6;
                padding-left: 40px;
            }
        }

        &.stay {
            background-color: #203040;

            .row {
                .mark {
                    color: #4890FF;
                }
            }
        }

        &.complete {
            background-color: #383020;

            .row {
                .mark {
                    color: #FFDA2A;
                }
            }
        }
    }
</style>