<template>
    <div class="playList">
        <div class="information" v-if="info">
            <div class="information__thumb">
                <img v-if="info.mem_photo" :src="'/uploads/member_photo/' + info.mem_photo">
                <img v-if="!info.mem_photo" src="https://via.placeholder.com/130x130" alt="">
            </div>
            <div class="information__user">
                <h2 class="information__username">{{ info.mem_username }}</h2>
                <p class="information__description" v-html="info.cit_content"></p>

                <a href="" class="information__message">Message</a>
            </div>
        </div>


    </div>
</template>


<script>

    export default {
        props: ['item'],
        data: function () {
            return {
                info: null,
            }
        },
        watch: {
            item: function (n) {
                this.getList();
            },
        },
        mounted() {
            this.getList();
        },
        methods: {
            getList() {
                if(!this.item) return;
                Http.post(`/beatsomeoneApi/get_item_infomation/${this.item.cit_id}`).then(r=> {
                    this.info = r;
                });
            },
        },

    }

</script>

<style scoped="scoped">

</style>
