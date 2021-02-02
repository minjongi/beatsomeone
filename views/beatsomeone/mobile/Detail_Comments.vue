<template>
    <div class="commentsbox">

        <div class="commentsbox__row" >
            <div class="comment" v-for="c in listComments" :key="c.cqa_id" v-if="listComments">
                <div class="comment__author-img">
                    <img v-if="!c.mem_photo" src="/assets/images/portrait.png" alt="portrait">
                    <img v-if="c.mem_photo" :src="c.mem_photo" alt="portrait">
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
                            <button @click="deleteComment(c)" v-if="member.mem_nickname === c.mem_nickname" class="red" style="margin-top: 5px; font-size: 12px;">{{ $t('delete') }}</button>
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

            <div class="no-comment"  v-if="listComments.length === 0" >
                <p>{{ $t('detailCommentsNotexists') }}</p>
            </div>
        </div>
    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import * as timeago from 'timeago.js';
    import axios from 'axios';

    export default {
        props: ['item'],
        data: function () {
            return {
                member: false,
                listComments: [],
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
                    this.listComments = !r.data.length ? [] : r.data;
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
        padding: 40px 0;
        text-align: center;
    }
    .no-comment p {
        color:#fff;
        font-size: 14px;
    }

</style>
