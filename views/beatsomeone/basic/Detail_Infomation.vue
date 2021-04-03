<template>
    <div class="information" v-if="info">
        <div class="information__thumb" >
            <img v-if="info.mem_photo" :src="'/uploads/member_photo/' + info.mem_photo">
            <img v-if="!info.mem_photo" src="/assets/images/portrait.png" alt="portrait">
        </div>
        <div class="information__user">
            <h2 class="information__username">{{ info.mem_userid }}
            
            <p class="information__description" v-html="info.mem_profile_content" style="position:relative;"></p><div class="user_border"></div></h2>
            <p class="information__description" v-html="info.cit_content"></p>

            <a href="javascript:;" class="information__message" @click="sendMessage" v-if="false">{{ $t('chat') }}</a>
        </div>
    </div>
</template>


<script>
    import axios from 'axios';

    export default {
        props: ['item'],
        data: function () {
            return {
                cit_id: null,
                info: null,
                member: false
            }
        },
        watch: {
            item: function (n) {
              if (this.cit_id === n.cit_id) {
                return
              }
              this.cit_id = n.cit_id
              this.getList();
            },
        },
        created() {
            this.member = window.member;
            this.getList();
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
                    window.location.href = this.helper.langUrl(this.$i18n.locale, "/login?url=" + window.location.href);
                    return false;
                }
                let formData = new FormData();
                formData.append('userid', this.info.mem_id);
                axios.post('/note/ajax_write_empty', formData)
                    .then(res => res.data)
                    .then(data => {
                        window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/#/message');
                    })
                    .catch(error => {
                        alert(error.response.data.message);
                    })
            }
        },

    }

</script>

<style scoped="scoped">
    .user_border{
        position: absolute;
        width: 40px;
        height: 4px;
        background-color: #ffffff;
        opacity: .3;
    }
</style>
