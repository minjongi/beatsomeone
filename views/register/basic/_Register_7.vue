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
                                {{ $t('yourUsername') }}
                                <span class="required">*</span>
                            </p>
                            <div class="input">
                                <input ref="username"
                                        type="text" v-model="user.username" v-on:blur="validateUsername"
                                        :placeholder="$t('setUsername')"
                                        required
                                />
                            </div>

                            <div v-if="errorValidUserId" class="errortext">
                                {{ errorValidUserId }}
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('firstName') }}
                            </p>
                            <div class="input">
                                <input v-model="user.firstname"
                                        type="text"
                                        :placeholder="$t('firstName')"
                                />
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('lastName') }}
                            </p>
                            <div class="input">
                                <input v-model="user.lastname"
                                        type="text"
                                        :placeholder="$t('lastName')"
                                />
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('cityOfResidenceState') }}
                            </p>
                            <div class="input">
                                <input  v-model="user.location"
                                        type="text"
                                        :placeholder="$t('cityOfResidenceState')"
                                />
                            </div>
                        </label>
                    </div>

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
                        <p class="form-title">{{ $t('userType') }}</p>
                        <div class="accounts__check">
                            <label for="type1" class="radio">
                                <input type="radio" id="type1" hidden name="TYPE" v-model="user.type" v-bind:value="'Music Lover'" />
                                <span></span> {{ $t('musicLover') }}
                            </label>
                            <label for="type2" class="radio">
                                <input type="radio" id="type2" hidden name="TYPE" v-model="user.type" v-bind:value="'Recording Artist'" />
                                <span></span> {{ $t('recordingArtist') }}
                            </label>
                            <label for="type3" class="radio">
                                <input type="radio" id="type3" hidden name="TYPE" v-model="user.type" v-bind:value="'Music Producer'" />
                                <span></span> {{ $t('musicProducer') }}
                            </label>
                            <label for="type4" class="radio">
                                <input type="radio" id="type4" hidden name="TYPE" v-model="user.type" v-bind:value="'Artist/Producer'" />
                                <span></span> {{ $t('artist') }}/{{ $t('producer') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="accounts__privacy">
                    <label for="privacy" class="checkbox" >
                        <input type="checkbox" hidden id="privacy" v-model="isCheckTos" />
                        <span></span> {{ $t('agreeToTermMsg') }}
                        <a :href="helper.langUrl($i18n.locale, '/register/terms')" target="_blank">{{ $t('termsOfService') }}</a>
                        &
                        <a :href="helper.langUrl($i18n.locale, '/register/policy')" target="_blank">{{ $t('privacyPolicy') }}.</a>
                    </label>
                </div>
                <div class="accounts__btnbox border-none">
                    <button class="btn btn--submit" @click="doNext">
                        {{ $t('next') }}
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
                errorValidUserId : null,
                errorValidEmail : null,
                isCheckTos: false,
                passwordVerify: null,
            }
        },
        computed: {
            isMusician: function() {
                return this.$parent.info.userType === 'musician';
            },
        },
        created() {

        },
        mounted() {
            const urlParams = new URLSearchParams(window.location.search);
            console.log("*--------------*", window.location.href.split('=')[1]);
            const code = urlParams.get('code');
            console.log("*****************", code);

        },
        watch: {

        },
        methods: {
            doValidation() {

                if(!this.user.username) {
                    alert(this.$t('enterUserAccount'));
                    return false;
                }

                if(!this.user.type) {
                    alert(this.$t('chooseYourType'));
                    return false;
                }

                if(!this.isCheckTos) {
                    alert(this.$t('agreeTermsAndConditionsPrivacyPolicy'));
                    return false;
                }


                return true;
            },
            doNext(type) {
                if(this.doValidation()) {
                    // let userInfo = this.$store.getters.getUserInfo;
                    let userInfo = this.user;
                    console.log(this.user);

                    let mgrId = Number(localStorage.getItem('mgr_id'));
                    
                    let billTerm = localStorage.getItem('bill_term');

                    let formData = new FormData();
                    formData.append('mem_username', userInfo.username);
                    formData.append('mem_nickname', userInfo.username);
                    formData.append('mem_firstname', userInfo.firstname || '');
                    formData.append('mem_lastname', userInfo.lastname || '');
                    formData.append('mem_address1', userInfo.location || '');
                    formData.append('mem_profile_content', userInfo.introduce);
                    formData.append('mem_type', userInfo.type);
                    formData.append('mgr_id', mgrId);

                    console.log("----------->", formData)
                    axios.post('/register/snsform', formData)
                    .then(res => {
                        console.log(res);
                        console.log(mgrId);
                            if (mgrId === 0 || mgrId === 1) {
                                alert(this.$t('successfullyRegistered'));
                                window.location.href = '/';
                            } else {
                                alert(this.$t('lang110'));
                                window.location.href = `/register/purchase?mgr_id=${mgrId}&billTerm=${billTerm}`;
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        })


                    // console.log("3333333333", userInfo);
                    // userInfo.mem_userid = this.user.username;
                    // userInfo.mem_email = this.user.email;
                    // userInfo.mem_password = this.user.password;
                    // userInfo.mem_type = this.user.type;
                    // this.$store.dispatch('setUserInfo', userInfo);
                    // this.$router.push({path: '/4'});
                }

            },
            openPage(path) {
                window.open(path, '_blank')
            },
            validateUsername() {
                if(!this.user.username) return;
                Http.post('/register/ajax_userid_check',{'userid' : this.user.username}).then(r=> {
                    if(r.result !== 'available') {
                        this.errorValidUserId = r.reason;
                        //this.$refs.username.focus();
                        //alert(r.reason);
                    } else {
                        this.errorValidUserId = null;
                    }

                });
            },
            validateEmail() {
                if(!this.user.email) return;
                Http.post('/register/ajax_email_check',{'email' : this.user.email}).then(r=> {
                    if(r.result !== 'available') {
                        this.errorValidEmail = r.reason;
                    } else {
                        this.errorValidEmail = null;
                    }
                });
            }
        },

    }




</script>

<style lang="scss">


</style>

<style lang="css">
body, html {
    background:#111214 !important;
}
.errortext {
    font-size: 14px;
    margin-top: 5px;
    opacity: .5;
}
.errortext:before {
    content:'- ';
}
</style>
