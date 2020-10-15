<template>
    <div class="panel active">
        <div class="popup active" style="width:560px;">
            <div class="box" style="padding-bottom:50px;">
                <div class="title">{{$t('changePassword')}}</div>
                <p>※ {{$t('passwordCharactersMsg')}}</p>
                <div class="col">
                    <div class="type"><span>{{$t('currentPassword')}}</span></div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" ref="firstForm" @keydown.enter="doSubmit" v-model="current_password" type="password" :placeholder="$t('enterYourCurrentPassword')">
                            <CommonCaution css="red" v-if="cur_password_invalid">{{cur_password_invalid_feedback}}</CommonCaution>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="type"><span>{{$t('newPassword')}}</span></div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" @keydown.enter="doSubmit" v-model="new_password" type="password" :placeholder="$t('enterYourNewPassword')">
                            <CommonCaution css="red" v-if="new_password_invalid">{{new_password_invalid_feedback}}</CommonCaution>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="type"><span>{{$t('newPasswordConfirm')}}</span></div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" @keydown.enter="doSubmit" v-model="new_password_confirm" type="password" :placeholder="$t('enterYourNewPasswordAgain')">
                            <CommonCaution css="red" v-if="new_password_re_invalid">{{new_password_re_invalid_feedback}}</CommonCaution>
                        </div>
                    </div>
                </div>

                <div class="btnbox col">
                    <button class="btn btn--gray" @click="dismissModal">{{$t('cancel1')}}</button>
                    <button type="submit" class="btn btn--blue" @click="doSubmit">{{$t('save')}}</button>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
    import CommonCaution from "./CommonCaution";
    import axios from 'axios';

    export default {
        components: {CommonCaution},
        props: ['item'],
        data: function () {
            return {
                current_password: '',
                new_password: '',
                new_password_confirm: '',
                cur_password_invalid: false,
                cur_password_invalid_feedback: '',
                new_password_invalid: false,
                new_password_invalid_feedback: '',
                new_password_re_invalid: false,
                new_password_re_invalid_feedback: '',
            }
        },
        created() {
            this.clearError();
        },
        mounted() {
            this.$refs.firstForm.focus();

        },
        methods: {
            dismissModal() {
                this.$emit('dismissModal');
            },
            doSubmit() {
                let formData = new FormData();
                formData.append('cur_password', this.current_password);
                formData.append('new_password', this.new_password);
                formData.append('new_password_re', this.new_password_confirm);

                axios.post('/membermodify/ajax_password_modify',formData)
                    .then(res => res.data)
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        const error_data = error.response.data;
                        if (error_data.cur_password) {
                            this.cur_password_invalid = true;
                            this.cur_password_invalid_feedback = error_data.cur_password;
                        } else {
                            this.cur_password_invalid = false;
                        }
                        if (error_data.new_password) {
                            this.new_password_invalid = true;
                            this.new_password_invalid_feedback = error_data.new_password;
                        } else {
                            this.new_password_invalid = false;
                        }
                        if (error_data.new_password_re) {
                            this.new_password_re_invalid = true;
                            this.new_password_re_invalid_feedback = error_data.new_password_re;
                        } else {
                            this.new_password_re_invalid = false;
                        }
                    })
            },
            doValidation() {
                const p1 = new Promise((resolve, reject) => {

                    this.clearError();

                    // 현재 패스워드 입력 확인
                    if(!this.info.pwdOriginal || this.info.pwdOriginal.trim().length === 0) {
                        this.errors.pwdOriginal = true;
                        reject();
                    }

                    // 변경 패스워드 입력 확인
                    if(!this.info.pwdC1 || this.info.pwdC1.trim().length === 0) {
                        this.errors.pwdC1 = true;
                        reject();
                    }

                    // 변경 패스워드 안전성
                    if(!/^[a-zA-Z0-9]{4,12}$/.test(this.info.pwdC1)) {
                        this.errors.pwdC1 = true;
                        reject();
                    }

                    var checkNumber = this.info.pwdC1.search(/[0-9]/g);
                    var checkEnglish = this.info.pwdC1.search(/[a-z]/ig);

                    if(checkNumber <0 || checkEnglish <0){
                        this.errors.pwdC1 = true;
                        reject();
                    }

                    // 확인 패스워드 입력 확인
                    if(!this.info.pwdC2 || this.info.pwdC2.trim().length === 0) {
                        this.errors.pwdC2 = true;
                        reject();
                    }

                    // 확인 패스워드 입력 확인
                    if(this.info.pwdC1 !== this.info.pwdC2) {
                        this.errors.pwdC2 = true;
                        reject();
                    }

                    log.debug('VALIDATION SUCCESS');

                    resolve();

                });

                // 현재 패스워드 서버 일치 확인
                const p2 = Http.post('/BeatsomeoneMypageApi/checkCompareUserPassword',{'pwdOriginal' : this.info.pwdOriginal}).then(r=> {
                    return new Promise((resolve, reject) => {
                        if(r.result) {
                            resolve();
                        } else {
                            this.errors.pwdOriginal = true;
                            reject('패스워드 서버 확인 실패');
                        }

                    });
                }).catch(e=> {
                    return new Promise((resolve, reject) => {
                       reject('패스워드 서버 확인 오류');
                    });
                });

                return Promise.all([p1,p2]);
            },
            clearError() {
                this.errors = {
                    pwdOriginal: false,
                    pwdC1: false,
                    pwdC2: false,
                };
            },
        },

    }

</script>

<style scoped="scoped" lang="scss">

</style>
