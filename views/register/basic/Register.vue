<template>
    <div class="wrapper">

        <Header :is-login="isLogin"></Header>
        <div style="margin-top: 100px;">
            <pre>{{ info }}</pre>
<!--            <a type="button" @click="doJoin">가입</a>-->
        </div>


        <router-view />
        <Footer></Footer>
    </div>

</template>

<script>

    require('@/assets/js/function');

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";
    import { EventBus } from '*/src/eventbus';

    export default {
        components: {Header,Footer},
        data: function() {
            return {
                info: {},
                isLogin: false,
            }
        },
        created() {
            EventBus.$on('submit_join_form', d => {
               Object.assign(this.info,d);
            });
            EventBus.$on('finish_join_form', d => {
                Object.assign(this.info,d);
                this.doJoin();
            });

            // this.info = {
            //     "userType": "user",
            //     "accountType": "email",
            //     "username": "222",
            //     "email": "333",
            //     "password": "444",
            //     "type": "Recording Artist"
            // };
        },
        mounted() {
            // 중간 리프레시 초기화
            if(this.$router.currentRoute.path != '/') {
                this.$router.push({path: '/'});
            }

        },
        watch: {

        },
        methods: {
            doJoin() {

                const form = {
                    user_type: this.info.userType,
                    mem_userid : this.info.username,
                    mem_nickname : this.info.username,
                    mem_password : this.info.password,
                    mem_username : this.info.firstname + this.info.lastname,
                    mem_email : this.info.email,
                    mem_address1 : this.info.location,
                    mem_profile_content : this.info.introduce,

                };

                Http.post('/register/ajax_form_user',form).then(r => {
                    alert('가입 되었습니다') ;
                    window.location.href = '/';
                },e => {
                    alert('실패');
                });

            },
        },

    }




</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';


</style>

<style lang="css">

</style>
