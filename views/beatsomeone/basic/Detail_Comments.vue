<template>
    <div class="commentsbox"  >
        <div class="commentsbox__row" v-if="listComments">
            <div class="comment" v-for="c in listComments" :key="c.cqa_id">
                <div class="comment__author-img" v-if="c">
                    <img v-if="!c.mem_photo" src="https://via.placeholder.com/50x50" alt="">
                    <img v-if="c.mem_photo" :src="c.mem_photo" alt="">
                </div>
                <div class="comment__content">
                    <div class="comment__info">
                        <div class="writer">
                            <span>{{ c.mem_nickname }}</span>
<!--                            <a href="">{{ $t('report') }}</a>-->
                        </div>

<!--                        <span class="comment__created-at">8 day ago</span>-->
                        <div>
                            <span class="comment__created-at">{{ timeago(c.cqa_datetime) }}</span><br>
                            <button @click="deleteComment(c)" v-if="member.mem_nickname === c.mem_nickname" class="red" style="margin-top: 5px">{{ $t('delete') }}</button>
                        </div>
                    </div>
                    <div class="comment__description">
                        <p>
                            {{ c.cqa_content }}
                        </p>
<!--                        <span class="comment__sub-count">200</span>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="commentsbox__row" v-if="!listComments" >
            <div class="no-comment">
                <p>{{ $t('detailCommentsNotexists') }}</p>
            </div>
        </div>
    </div>
</template>


<script>

    import axios from 'axios';
    import { EventBus } from '*/src/eventbus';
    import * as timeago from 'timeago.js';

    export default {
        props: ['item'],
        data: function () {
            return {
                listComments: [],
                member: false,
            }
        },
        watch: {
            item: function (n) {
                this.getList();
            },
        },
        created() {
            this.member = window.member;
            EventBus.$on('add_comment',() => {
                this.getList();
            });
        },
        mounted() {
            this.getList();
        },
        methods: {
            getList() {
                if(!this.item) return;
                Http.get(`/beatsomeoneApi/list_comment/${this.item.cit_id}`).then(r=> {
                    this.listComments = !r.data.length ? null : r.data;
                });
            },
            timeago(date) {
                return timeago.format(date);
            },
            deleteComment(comment) {
                console.log(comment);
                let formData = new FormData();
                formData.append('cqa_id', comment.cqa_id);
                axios.post('/cmallact/delete_qna', formData)
                    .then(res => res.data)
                    .then(data => {
                        let idx = this.listComments.findIndex(x => x.cqa_id === comment.cqa_id);
                        this.listComments.splice(idx, 1);
                    })
                    .catch(error => console.error(error))
            }

        },

    }

</script>

<style scoped="scoped">
    .no-comment {
        padding: 80px 0;
        text-align: center;
    }
    .no-comment p {
        color:#fff;
        font-size: 14px;
    }
</style>
