<template>
    <div class="information" v-if="info">
        <div class="information__thumb" >
            <img v-if="info.mem_photo" :src="'/uploads/member_photo/' + info.mem_photo">
            <img v-if="!info.mem_photo" src="https://via.placeholder.com/130x130" alt="">
        </div>
        <div class="information__user">
            <h2 class="information__username">{{ info.mem_username }}</h2>
            <p class="information__description" v-html="info.cit_content"></p>

            <a href="javascript:;" class="information__message" @click="sendMessage">{{ $t('chat') }}</a>
        </div>
    </div>
</template>


<script>
    import axios from 'axios';

    export default {
        props: ['item'],
        data: function () {
            return {
                info: null,
                member: false
            }
        },
        watch: {
            item: function (n) {
                this.getList();
            },
        },
        created() {
            this.member = window.member;
            this.getList();
        },
        mounted() {

        },
        methods: {
            getList() {
                if(!this.item) return;
                Http.post(`/beatsomeoneApi/get_item_infomation/${this.item.cit_id}`).then(r=> {
                    this.info = r;
                });
            },
            sendMessage() {
                if (this.member === false) {
                    alert('로그인이 필요합니다');
                    window.location.href = "/login?url=" + window.location.href;
                    return false;
                }
                let formData = new FormData();
                formData.append('userid', this.info.mem_id);
                axios.post('/note/ajax_write_empty', formData)
                    .then(res => res.data)
                    .then(data => {
                        // console.log(data);
                        window.location.href = '/mypage/#/message';
                    })
                    .catch(error => {
                        alert(error.response.data.message);
                    })
            }
        },

    }

</script>

<style scoped="scoped">

</style>
