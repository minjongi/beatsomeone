<template>
    <div>
        <Header :is-login="isLogin" />
        <router-view />
        <Footer />
    </div>
</template>

<script>

    require('@/assets_m/js/function');

    import Header from "@/views/beatsomeone/mobile/include/Header";
    import Footer from "@/views/beatsomeone/mobile/include/Footer";
    import { EventBus } from '*/src/eventbus';

    export default {
        components: {
            Header, Footer
        },
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
                    mem_musician_bank : this.info.mem_musician_bank,
                    mem_musician_account_nm : this.info.mem_musician_account_nm,
                    mem_musician_account : this.info.mem_musician_account,
                    promo_code : this.info.promo_code
                };

                console.log(form);

                Http.post('/register/ajax_form_user',form).then(r => {
                    alert(this.$t('registerSuccess')) ;
                    //window.location.href = '/';
                    this.$router.push({path: '/6'});
                },e => {
                    alert(this.$t('registerFail'));
                });
            },
        },
    }
</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style lang="css">

</style>
