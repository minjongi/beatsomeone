<template>
    <div class="wrapper">

        <Header :is-login="isLogin"></Header>
        <router-view/>
        <Footer></Footer>
    </div>

</template>

<script>

    require('@/assets/js/function');

    import axios from 'axios';

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";
    import {EventBus} from '*/src/eventbus';

    export default {
        components: {Header, Footer},
        data: function () {
            return {
                info: {},
                isLogin: false,
            }
        },
        created() {
            EventBus.$on('submit_join_form', d => {
                Object.assign(this.info, d);
                localStorage.setItem('bs_user_info', JSON.stringify(this.info));
                console.log(this.info);
                if (this.$router.currentRoute.path === '/5') {
                    if (this.info.group.mgr_title === 'buyer' || this.info.group.mgr_title === 'seller_free') {
                        this.registerBuyer();
                    } else {
                        this.$router.push({path: '/6'});
                    }
                }
            });
            EventBus.$on('finish_join_form', d => {
                Object.assign(this.info, d);
                this.doJoin();
            });
        },
        mounted() {
            // 중간 리프레시 초기화
            // if (this.$router.currentRoute.path !== '/' && this.$router.currentRoute.path !== '/TermsOfService' && this.$router.currentRoute.path !== '/PrivacyPolicy') {
            //     this.$router.push({path: '/'});
            // }
        },
        watch: {},
        methods: {
            doJoin() {
                const form = {
                    mgr_id: this.info.group.mgr_id,
                    user_type: this.info.userType,
                    mem_userid: this.info.username,
                    mem_nickname: this.info.username,
                    mem_password: this.info.password,
                    mem_username: (this.info.firstname || '') + ' ' + (this.info.lastname || ''),
                    mem_firstname: this.info.firstname || '',
                    mem_lastname: this.info.lastname || '',
                    mem_email: this.info.email,
                    mem_address1: this.info.location,
                    mem_profile_content: this.info.introduce,
                    mem_musician_bank: this.info.mem_musician_bank,
                    mem_musician_account_nm: this.info.mem_musician_account_nm,
                    mem_musician_account: this.info.mem_musician_account,
                    promo_code: this.info.promo_code
                };

                Http.post('/register/ajax_form_user', form).then(r => {
                    alert(this.$t('registerSuccess'))
                    if (this.info.userType == "buyer") {
                        window.location.href = '/'
                    } else {
                        window.location.href = '/register?billTerm=' + (this.info.billTerm || '') + '&plan=' + (this.info.plan || '') + '&planName=' + (this.info.planName || '')
                    }
                }, e => {
                    alert(this.$t('registerFail'))
                });
            },
            goPurchase() {
                if (this.isLogin) {
                    this.$router.push({path: '/6'});
                }
            },
            registerBuyer() {
                let formData = new FormData();
                formData.append('mem_userid', this.info.username);
                formData.append('mem_nickname', this.info.username);
                formData.append('mem_email', this.info.email);
                formData.append('mem_password', this.info.password);
                formData.append('mem_firstname', this.info.firstname || '');
                formData.append('mem_lastname', this.info.lastname || '');
                formData.append('mem_address1', this.info.location || '');
                formData.append('mem_profile_content', this.info.introduce);
                formData.append('mem_type', this.info.type);
                formData.append('mgr_id', this.info.group.mgr_id);

                axios.post('/register/form', formData)
                    .then(res => res.data)
                    .then(data => {
                        if (data.email_auth_message) {
                            alert(data.email_auth_message);
                        } else {
                            alert(data.message);
                            window.location.href = '/';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    })
            }
        },
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style lang="css">

</style>
