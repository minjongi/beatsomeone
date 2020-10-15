<template>
    <div>
        <div class="d-flex">
            <h5>{{$t('support1')}}</h5>
            <div class="ml-auto">
                <button class="btn btn-secondary px-5" @click="goBack">{{$t('back')}}</button>
            </div>
        </div>
        <div class="row border-bottom py-3">
            <div class="col-2">Title</div>
            <div class="col-10 text-secondary">{{ post.post_title }}</div>
        </div>
        <div class="row border-bottom py-3">
            <div class="col-2">Status</div>
            <div class="col-4">
                <span class="text-secondary" v-if="replies.length > 0">Answer Complete...</span>
                <div class="text-warning" v-else>Wait...</div>
            </div>
            <div class="col-2">Date</div>
            <div class="col-4 text-secondary">{{ post.post_datetime }}</div>
        </div>
        <div class="row py-3">
            <div class="col-2">Attachment</div>
            <div class="col-10 d-flex">
                <div class="file" v-for="file in files" v-bind:key="file.pfi_id">
                    <img src="/assets/images/icon/file.png"/>
                    <span>{{ file.pfi_originname }}</span>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <ul class="list-group">
                <li class="list-group-item question">
                    <div class="row">
                        <div class="col-2">
                            <span class="question-mark">Q</span>
                        </div>
                        <div class="col-10">
                            {{ post.post_content }}
                        </div>
                    </div>
                </li>
                <li class="list-group-item comment" v-for="comment in comments" v-bind:key="comment.cmt_id">
                    <div class="row">
                        <div class="col-2">
                        </div>
                        <div class="col-10" v-html="comment.cmt_content">
                        </div>
                    </div>
                </li>
                <li class="list-group-item reply" v-for="reply in replies" v-bind:key="reply.post_id">
                    <div class="row">
                        <div class="col-2">
                            <span class="answer-mark">{{ reply.post_reply }}</span>
                        </div>
                        <div class="col-10" v-html="reply.post_content">
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="form-group text-center">
            <button class="btn btn-secondary px-5 mr-3" @click="goInquiryList">Cancel</button>
            <button class="btn btn-warning px-5" @click="goInquirymod">Edit</button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
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
    .list-group-item {
        margin-bottom: 1px;

        &.question {
            background-color: #203040;

            .question-mark {
                color: #4890ff;
                font-weight: 700;
                font-size: 40px;
            }
        }

        &.comment {
            background-color: #2b2c30;
        }

        &.reply {
            background-color: #383020;

            .answer-mark {
                color: #ffda2a;
                font-weight: 700;
                font-size: 40px;
            }
        }
    }
</style>