<template>
    <div class="commentsbox">
        <div class="commentsbox__row">
            <div class="comment" v-for="c in listComments" :key="c.cqa_id">
                <div class="comment__author-img">
                    <img src="https://via.placeholder.com/35x35" alt="">
                </div>
                <div class="comment__content">
                    <div class="comment__info">
                        <div class="writer">
                            <span>{{ c.mem_id }}</span>
                            <a href="">신고하기</a>
                        </div>

                        <span class="comment__created-at">8 day ago</span>
                    </div>
                    <div class="comment__description">
                        <p>
                            {{ c.cqa_content }}
                        </p>
                        <span class="comment__sub-count">200</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';

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
                    this.listComments = r.data;
                });
            },

        },

    }

</script>

<style scoped="scoped">

</style>
