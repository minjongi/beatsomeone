<template>
    <div class="container accounts">
        <div class="accounts__title">
            <h1>
                {{ $t('completeSignup') }}
            </h1>
        </div>
        <div class="login accounts__defaultLayout">

                <div class="accounts__form">
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('introYourself') }} <span class="required">*</span>
                            </p>
                            <div class="input">
                                <input
                                        type="text" v-model="user.introduce"
                                        :placeholder="$t('introYourself')"
                                />
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('nameOfMyBrandShop') }}
                            </p>
                            <div class="input">
                                <input
                                        type="text"
                                        :placeholder="beandshop"
                                        disabled
                                />
                            </div>
                        </label>
                    </div>
                </div>
                <div class="accounts__btnbox">
                    <button type="button" class="btn btn--submit" @click="doNext">
                        {{ $t('signup') }}
                    </button>
                </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '*/src/eventbus';
    import axios from "axios";

    export default {
        data: function() {
            return {
                user: {},
            }
        },
        computed: {
            beandshop: function() {
                return 'https://beatsomeone.com/' + this.user.mem_userid;
            },
            isMusician: function() {
                return this.$parent.info.userType === 'musician';
            },
        },
        created() {

        },
        mounted() {
            this.user = this.$store.getters.getUserInfo;
        },
        watch: {

        },
        methods: {
            doValidation() {

                if(!this.user.introduce) {
                    alert(this.$t('enterYourSelfIntroduction'));
                    return false;
                }
                return true;
            },
            doNext() {
                if(this.doValidation()) {
                    let userInfo = this.$store.getters.getUserInfo;
                    userInfo.mem_profile_content = this.user.introduce;
                    const group = userInfo.group;
                    let formData = new FormData();
                    let socialid = "-social_" + window.location.href.split('=')[1];
                    console.log("socialid:  ", socialid);
                    let mgrId = Number(localStorage.getItem('mgr_id'));
                    let billTerm = localStorage.getItem('bill_term');
                    let social_type = localStorage.getItem('social_type');

                    formData.append('social_id', socialid);
                    formData.append('mem_userid', userInfo.mem_userid);
                    formData.append('mem_nickname', userInfo.mem_userid);
                    formData.append('mem_email', userInfo.mem_email);
                    formData.append('mem_password', userInfo.mem_password);
                    formData.append('mem_firstname', userInfo.mem_firstname || '');
                    formData.append('mem_lastname', userInfo.mem_lastname || '');
                    formData.append('mem_address1', userInfo.mem_address1 || '');
                    formData.append('mem_profile_content', userInfo.mem_profile_content);
                    formData.append('mem_type', userInfo.mem_type);
                    formData.append('mem_social_type', social_type);
                    formData.append('mgr_id', mgrId);

                    axios.post('/register/form', formData)
                        .then(res => res.data)
                        .then(data => {
                            window.mobonConversion('회원가입','회원가입')
                            window.gtag_report_conversion()
                            if (mgrId === 0 || mgrId === 1) {
                                alert(this.$t('successfullyRegistered'));
                                window.location.href = this.helper.langUrl(this.$i18n.locale, '/');
                            } else {
                                alert(this.$t('lang110'));
                                window.location.href = this.helper.langUrl(this.$i18n.locale, `/register/purchase?mgr_id=${mgrId}&billTerm=${billTerm}`);
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        })
                }
            },
        },
    }
</script>

<style lang="scss">

</style>

<style lang="css">

</style>
