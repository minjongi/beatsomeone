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
                                {{ $t('yourEmail') }} <span class="required">*</span>
                            </p>
                            <div class="input">
                                <input
                                        type="email" v-model="user.email" v-on:blur="validateEmail"
                                        :placeholder="$t('typeYourEmail')"
                                        required
                                />
                            </div>
                            <div v-if="errorValidEmail" class="errortext">
                                {{ errorValidEmail }}
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('password') }} <span class="required">*</span>
                            </p>
                            <div class="input">
                                <input
                                        type="password"  v-model="user.password"
                                        :placeholder="$t('typeYourPassword')"
                                        required
                                />
                            </div>
                        </label>
                    </div>
                    <div class="row">
                        <label for="">
                            <p class="form-title">
                                {{ $t('passwordVerify') }} <span class="required">*</span>
                            </p>
                            <div class="input">
                                <input
                                        type="password" v-model="passwordVerify"
                                        :placeholder="$t('typeYourPasswordAgain')"
                                        required
                                />
                            </div>
                        </label>
                    </div>
<!--                    <div class="row" v-if="isMusician">-->
<!--                        <label for="">-->
<!--                            <p class="form-title">-->
<!--                                Your Bank-->
<!--                                <span class="required">*</span>-->
<!--                            </p>-->
<!--                            <div class="input">-->
<!--                                <input-->
<!--                                        type="text" v-model="user.mem_musician_bank"-->
<!--                                        placeholder="Set a Bank"-->
<!--                                        required-->
<!--                                />-->
<!--                            </div>-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="row" v-if="isMusician">-->
<!--                        <label for="">-->
<!--                            <p class="form-title">-->
<!--                                Your Bank Account-->
<!--                                <span class="required">*</span>-->
<!--                            </p>-->
<!--                            <div class="input">-->
<!--                                <input-->
<!--                                        type="text" v-model="user.mem_musician_account"-->
<!--                                        placeholder="Set a BankAccount"-->
<!--                                        required-->
<!--                                />-->
<!--                            </div>-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="row" v-if="isMusician">-->
<!--                        <label for="">-->
<!--                            <p class="form-title">-->
<!--                                Your Bank Accounts Owner Name-->
<!--                                <span class="required">*</span>-->
<!--                            </p>-->
<!--                            <div class="input">-->
<!--                                <input-->
<!--                                        type="text" v-model="user.mem_musician_account_nm"-->
<!--                                        placeholder="Set a BankAccount Owner Name"-->
<!--                                        required-->
<!--                                />-->
<!--                            </div>-->
<!--                        </label>-->
<!--                    </div>-->
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
            if (window.location.search === '?t=pr') {
              localStorage.setItem("UserOffer", "seller");
              localStorage.setItem('mgr_id', 4);
              localStorage.setItem('bill_term', 'yearly');

              this.$store.dispatch('setUserInfo', {
                group: {
                  mgr_commission: "0",
                  mgr_datetime: "2020-12-18 11:51:57",
                  mgr_description: "판매자(Master)",
                  mgr_id: "4",
                  mgr_is_default: "0",
                  mgr_monthly_cost_d: "2.04",
                  mgr_monthly_cost_w: "300",
                  mgr_monthly_discount: "0",
                  mgr_monthly_download_limit: null,
                  mgr_monthly_msg_limit: "0",
                  mgr_monthly_upload_limit: "0",
                  mgr_order: "4",
                  mgr_title: "seller_master",
                  mgr_year_cost_d: "2.00",
                  mgr_year_cost_w: "1000",
                  mgr_year_discount: "0",
                  mgr_year_download_limit: null,
                  mgr_year_msg_limit: "0",
                  mgr_year_upload_limit: "0"
                },
                billTerm: 'yearly',
              })
            }
            if (window.location.search === '?t=event') {
              localStorage.setItem("UserOffer", "seller");
              localStorage.setItem('mgr_id', 2);
              localStorage.setItem('bill_term', 'yearly');

              this.$store.dispatch('setUserInfo', {
                group: {
                  mgr_commission: "30",
                  mgr_datetime: "2020-12-31 14:52:15",
                  mgr_description: "판매자(Free)",
                  mgr_id: "2",
                  mgr_is_default: "0",
                  mgr_monthly_cost_d: "0.00",
                  mgr_monthly_cost_w: "0",
                  mgr_monthly_discount: "0",
                  mgr_monthly_download_limit: null,
                  mgr_monthly_msg_limit: "10",
                  mgr_monthly_upload_limit: "10",
                  mgr_order: "2",
                  mgr_title: "seller_free",
                  mgr_year_cost_d: "0.00",
                  mgr_year_cost_w: "0",
                  mgr_year_discount: "0",
                  mgr_year_download_limit: null,
                  mgr_year_msg_limit: "10",
                  mgr_year_upload_limit: "10"
                },
                billTerm: 'yearly',
              })
            }
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            doValidation() {

                if(!this.user.username) {
                    alert(this.$t('enterUserAccount'));
                    return false;
                }

                if(this.user.username.length < 3) {
                  alert(this.$t('lang148'));
                  return false;
                }

                if(this.errorValidUserId) {
                    alert(this.errorValidUserId);
                    return false;
                }
                if(this.errorValidEmail) {
                    alert(this.errorValidEmail);
                    return false;
                }

                if(!this.user.email) {
                    alert(this.$t('typeYourEmail'));
                    return false;
                }

                if(!this.user.password) {
                    alert(this.$t('typeYourPassword'));
                    return false;
                }

                if(this.user.password.length < 4) {
                  alert(this.$t('passwordCharactersMsg'));
                  return false;
                }

                if(this.user.password !== this.passwordVerify) {
                    alert(this.$t('enterSamePassword'));
                    return false;
                }

                // if(this.isMusician && !this.user.mem_musician_bank) {
                //     alert('은행을 입력해 주세요');
                //     return false;
                // }
                //
                // if(this.isMusician && !this.user.mem_musician_account) {
                //     alert('계좌번호를 입력해 주세요');
                //     return false;
                // }
                //
                // if(this.isMusician && !this.user.mem_musician_account_nm) {
                //     alert('계좌주를 입력해 주세요');
                //     return false;
                // }


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
                    let userInfo = this.$store.getters.getUserInfo;
                    console.log("3333333333", userInfo);
                    userInfo.mem_userid = this.user.username;
                    userInfo.mem_email = this.user.email;
                    userInfo.mem_password = this.user.password;
                    userInfo.mem_type = this.user.type;
                    this.$store.dispatch('setUserInfo', userInfo);
                    this.$router.push({path: '/4'});
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
