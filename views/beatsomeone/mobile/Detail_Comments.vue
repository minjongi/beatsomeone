<template>
    <div class="commentsbox">

        <div class="commentsbox__row" >
            <div class="comment" v-for="c in listComments" :key="c.cqa_id" v-if="listComments">
                <div class="comment__author-img">
                    <img v-if="!c.mem_photo" src="https://via.placeholder.com/35x35" alt="">
                    <img v-if="c.mem_photo" :src="'/uploads/member_photo/' + c.mem_photo" alt="">
                </div>
                <div class="comment__content">
                    <div class="comment__info">
                        <div class="writer">
                            <span>{{ c.mem_nickname }}</span>
<!--                            <a href="">{{ $t('report') }}</a>-->
                        </div>

<!--                        <span class="comment__created-at">8 day ago</span>-->
                        <span class="comment__created-at">{{ timeago(c.cqa_datetime) }}</span>
                    </div>
                    <div class="comment__description">
                        <p>
                            {{ c.cqa_content }}
                        </p>
<!--                        <span class="comment__sub-count">200</span>-->
                    </div>
                </div>
            </div>

            <div class="no-comment"  v-if="!listComments" >
                <p>{{ $t('detailCommentsNotexists') }}</p>
            </div>
        </div>
    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import * as timeago from 'timeago.js';

    export default {
        props: ['item'],
        data: function () {
            return {

                listComments: null,
            }
        },
        watch: {
            item: function (n) {
                this.getList();
            },
        },
        created() {
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
