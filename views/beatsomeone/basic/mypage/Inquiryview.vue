<template>
    <div class="sublist__content">
        <div class="row">
            <div class="row" style="margin-bottom:30px;">
                <div class="title-content">
                    <div class="title">
                        <div>{{$t('support1')}}</div>
                        <button class="btn btn--gray" @click="goBack">{{$t('back')}}</button>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:30px;">
                <div class="content-header">
                    <div>
                        <div>
                            <div class="category">Title</div>
                            <div class="body">{{ post.post_title }}</div>
                        </div>
                    </div>

                    <div>
                        <div>
                            <div class="category">Status</div>
                            <div class="body action active" v-if="replies.length > 0">Answer Complete...</div>
                            <div class="body action active" v-else>Wait...</div>
                        </div>
                        <div>
                            <div class="category">Date</div>
                            <div class="body">{{ post.post_datetime }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="category">Attachment</div>
                        <div class="flie_list">
                            <button class="btn--file" v-for="file in files" v-bind:key="file.pfi_id">
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
                            <div class="playList__item playList__item--title nowrap question stay">
                                <div class="row">
                                    <div class="mark">Q</div>
                                    <div class="answer">
                                        {{ post.post_content }}
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="playList__itembox" v-for="comment in comments" v-bind:key="comment.cmt_id">
                            <div class="playList__item playList__item--title nowrap question">
                                <div class="row">
                                    <div class="mark"></div>
                                    <div class="answer" v-html="comment.cmt_content">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="playList__itembox" v-for="reply in replies" v-bind:key="reply.post_id">
                            <div class="playList__item playList__item--title nowrap question complete">
                                <div class="row">
                                    <div class="mark">{{ reply.post_reply }}</div>
                                    <div class="answer" v-html="reply.post_content">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

<!--                    <div v-if="current_user.mem_is_admin === '1'" class="comment-reg">-->
<!--                        <label>댓글 내용</label>-->
<!--                        <textarea  rows="5" v-model="cmt_content"></textarea>-->
<!--                        <button class="btn btn-primary" @click="submitComment">댓글 등록</button>-->
<!--                        <label>답변</label>-->
<!--                        <input type="text" v-model="post_title" style="display: inline-block; background-color: white; width: 100%;" />-->
<!--                        <textarea  rows="5" v-model="post_content"></textarea>-->
<!--                        <button class="btn btn-primary" @click="submitReply">답변</button>-->
<!--                    </div>-->
                </div>
            </div>

            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                <button class="btn btn--gray" @click="goInquiryList">Cancel</button>
                <button type="submit" class="btn btn--submit" @click="goInquirymod">Edit</button>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import axios from 'axios';
    import InquiryPost from "./InquiryPost";

    export default {
        components: {
            InquiryPost
        },
        data: function () {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                popup_filter: 0,
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
            axios.get(`/post/${post_id}`)
                .then(res => res.data)
                .then(data => {
                    this.post = data.post;
                    this.files = data.file;
                    this.replies = data.post.replies.list;

                    axios.get(`/comment_list/lists/${this.post.post_id}`)
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
            submitComment() {
                if (this.cmt_content) {
                    let formData = new FormData();
                    formData.append('mode', 'c');
                    formData.append('post_id', this.post.post_id);
                    formData.append('cmt_content', this.cmt_content);
                    axios.post('/comment_write/update', formData)
                        .then(res => res.data)
                        .then(data => {
                            alert(data.success);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                } else {
                    alert('오류가 발생하였습니다.');
                }
            },
            submitReply() {
                if (this.post_content) {
                    let formData = new FormData();
                    formData.append('post_content', this.post_content);
                    formData.append('post_title', this.post_title);
                    axios.post(`/reply/${this.post.post_id}`, formData)
                        .then(res => res.data)
                        .then(data => {
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        },
    }
</script>

<style scoped="scoped" lang="scss">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .array {
        .playList__item {
            .row {
                width: 100%;
            }
        }
    }

    .comment-reg {
        margin-top: 30px;

        textarea {
            height: 100px;
        }

        .btn {
            color: white;
            border: solid 1px white;
        }
    }
</style>