<template>
    <div class="container-fluid my-4">
        <div class="form-group">
            <label>{{$t('username')}}</label>
            <div class="input-group">
                <input class="form-control" v-model="mem_nickname" type="text" :readonly="isUsernameReadonly">
                <div class="input-group-append">
                    <button class="btn btn-primary" v-if="isUsernameReadonly" @click="isUsernameReadonly = false">{{$t('change1')}}</button>
                    <button class="btn btn-primary" v-if="!isUsernameReadonly" @click="isUsernameReadonly = true">{{$t('save')}}</button>
                    <button class="btn btn-primary ml-2" v-if="!isUsernameReadonly" @click="isUsernameReadonly = true">{{$t('cancel2')}}</button>
                </div>
            </div>
            <small class="form-text"><i class="fa fa-exclamation-triangle"></i> {{$t('noteIDChangeMsg')}}</small>
        </div>
        <div class="form-group">
            <label>{{ $t('userGroup') }}</label>
            <div>
                <span :class="member_group_name === 'buyer' ? 'text-primary' : ''">{{ $t(member_group_name) }}</span>
            </div>
        </div>
        <div class="form-group" v-if="member_group_name.includes('seller')">
            <label>{{ $t('sellerClass') }}</label>
            <div>
                <h5>
                    <span class="badge" :class="{'badge-success': member_group_name === 'seller_free', 'badge-primary': member_group_name === 'seller_platinum', 'badge-warning': member_group_name === 'seller_master'}">{{ $t(member_group_name) }}</span>
                    <a :href="helper.langUrl($i18n.locale, '/mypage/upgrade')" class="ml-3 btn btn-warning rounded" style="width: unset;">Upgrade Now</a>
                </h5>
            </div>
        </div>
        <div class="form-group">
            <label>{{ $t('email') }}</label>
            <div class="input-group">
                <input class="form-control" v-model="mem_email" type="email" :readonly="isEmailReadonly">
                <div class="input-group-append">
                    <button class="btn btn-primary" v-if="isEmailReadonly" @click="isEmailReadonly = false">{{$t('change1')}}</button>
                    <button class="btn btn-primary" v-if="!isEmailReadonly">{{$t('save')}}</button>
                    <button class="btn btn-primary ml-2" v-if="!isEmailReadonly" @click="isEmailReadonly = true">{{$t('cancel2')}}</button>
                </div>
            </div>
            <small class="form-text"><i class="fa fa-exclamation-triangle"></i> {{$t('noteChangeEmailMsg')}}</small>
        </div>
        <div class="form-group">
            <label>{{ $t('password') }}</label>
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#change-password-modal">
                {{$t('changePassword')}}
            </button>
        </div>
        <div class="form-group">
            <label>{{ $t('yourType') }}</label>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="music_lover" v-model="mem_type" value="Music Lover" class="custom-control-input">
                    <label class="custom-control-label" for="music_lover">Music Lover</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="recording_artist" v-model="mem_type" value="Recording Artist" class="custom-control-input">
                    <label class="custom-control-label" for="recording_artist">Recording Artist</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="music_producer" v-model="mem_type" value="Music Producer" class="custom-control-input">
                    <label class="custom-control-label" for="music_producer">Music Producer</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="artist_producer" v-model="mem_type" value="Artist/Producer" class="custom-control-input">
                    <label class="custom-control-label" for="artist_producer">Artist/Producer</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>{{ $t('realName') }}</label>
            <div class="row">
                <div class="col-6">
                    <input class="form-control" type="text" v-model="mem_firstname" />
                </div>
                <div class="col-6">
                    <input class="form-control" type="text" v-model="mem_lastname" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>City of Residence, State</label>
            <input class="form-control" type="text" v-model="mem_address1" />
        </div>
        <div class="form-group">
            <label>{{$t('bio')}}</label>
            <textarea class="form-control" type="text" v-model="mem_profile_content"></textarea>
        </div>
        <div class="form-group">
            <label>{{$t('linkedAccount')}}</label>
            <div class="d-flex align-items-center justify-content-between mb-3" v-if="use_sociallogin_facebook === 1">
                <div>
                                <span class="social-icon facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </span>
                    Facebook <span class="text-secondary font-size-12" v-if="social['facebook_update_datetime']">{{ social['facebook_update_datetime'] }}</span>
                </div>
                <div>
                    <button class="btn" :class="{'btn-warning':!social['facebook_id'], 'btn-default':social['facebook_id']}" @click="toggleConnect('facebook')">
                        {{ $t(!social['facebook_id'] ? 'Link' : 'Unlink') }}
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3" v-if="use_sociallogin_twitter === 1">
                <div>
                                <span class="social-icon twitter">
                                    <i class="fab fa-twitter"></i>
                                </span>
                    Twitter <span class="text-secondary font-size-12" v-if="social['twitter_update_datetime']">{{ social['twitter_update_datetime'] }}</span>
                </div>
                <div>
                    <button class="btn" :class="{'btn-warning':!social['twitter_id'], 'btn-default':social['twitter_id']}" @click="toggleConnect('twitter')">
                        {{ $t(!social['twitter_id'] ? 'Link' : 'Unlink') }}
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3" v-if="use_sociallogin_google === 1">
                <div>
                                <span class="social-icon google">
                                    <i class="fab fa-google"></i>
                                </span>
                    Google <span class="text-secondary font-size-12" v-if="social['google_update_datetime']">{{ social['google_update_datetime'] }}</span>
                </div>
                <div>
                    <button class="btn" :class="{'btn-warning':!social['google_id'], 'btn-default':social['google_id']}" @click="toggleConnect('google')">
                        {{ $t(!social['google_id'] ? 'Link' : 'Unlink') }}
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3" v-if="use_sociallogin_naver === 1">
                <div>
                                <span class="social-icon naver">
                                    <i class="fab fa-naver"></i>
                                </span>
                    Naver <span class="text-secondary font-size-12" v-if="social['naver_update_datetime']">{{ social['naver_update_datetime'] }}</span>
                </div>
                <div>
                    <button class="btn" :class="{'btn-warning':!social['naver_id'], 'btn-default':social['naver_id']}" @click="toggleConnect('naver')">
                        {{ $t(!social['naver_id'] ? 'Link' : 'Unlink') }}
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-3" v-if="use_sociallogin_kakao === 1">
                <div>
                                <span class="social-icon kakao">
                                    <i class="fab fa-kakao"></i>
                                </span>
                    Kakao <span class="text-secondary font-size-12" v-if="social['kakao_update_datetime']">{{ social['kakao_update_datetime'] }}</span>
                </div>
                <div>
                    <button class="btn" :class="{'btn-warning':!social['kakao_id'], 'btn-default':social['kakao_id']}" @click="toggleConnect('kakao')">
                        {{ $t(!social['kakao_id'] ? 'Link' : 'Unlink') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-warning" @click="saveData">{{ $t('save') }}</button>
        </div>
        <div class="modal fade" id="change-password-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group">
                            <h4>{{$t('changePassword')}}</h4>
                            <p class="form-text">※ {{$t('passwordCharactersMsg')}}</p>
                        </div>
                        <div class="form-group">
                            <label>{{$t('currentPassword')}}</label>
                            <input class="form-control" v-model="current_password" :class="cur_password_invalid ? 'is-invalid' : ''" type="password" />
                            <span class="invalid-feedback">{{ cur_password_invalid_feedback }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{$t('newPassword')}}</label>
                            <input class="form-control" :class="new_password_invalid ? 'is-invalid' : ''" v-model="new_password" type="password" />
                            <span class="invalid-feedback">{{ new_password_invalid_feedback }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{$t('newPasswordConfirm')}}</label>
                            <input class="form-control" :class="new_password_re_invalid ? 'is-invalid' : ''" v-model="new_password_confirm" type="password" />
                            <span class="invalid-feedback">{{ new_password_re_invalid_feedback }}</span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-default btn-lg btn-block" data-dismiss="modal">{{$t('cancel2')}}</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary btn-lg btn-block" @click="changePassword">{{$t('save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "MemberModify",
        data: function () {
            return {
                mem_nickname: '',
                isUsernameReadonly: true,
                member_group_name: '',
                mem_email: '',
                isEmailReadonly: true,
                mem_type: '',
                mem_firstname: '',
                mem_lastname: '',
                mem_address1: '',
                mem_profile_content: '',
                social: {},

                current_password: '',
                new_password: '',
                new_password_confirm: '',
                cur_password_invalid: false,
                cur_password_invalid_feedback: '',
                new_password_invalid: false,
                new_password_invalid_feedback: '',
                new_password_re_invalid: false,
                new_password_re_invalid_feedback: '',
                use_sociallogin_facebook: 0,
                use_sociallogin_twitter: 0,
                use_sociallogin_google: 0,
                use_sociallogin_naver: 0,
                use_sociallogin_kakao: 0,
            }
        },
        mounted() {
            this.mem_nickname = window.member.mem_nickname;
            this.member_group_name = window.member_group_name;
            this.mem_email = window.member.mem_email;
            this.mem_type = window.member.mem_type;
            this.mem_firstname = window.member.mem_firstname;
            this.mem_lastname = window.member.mem_lastname;
            this.mem_address1 = window.member.mem_address1;
            this.mem_profile_content = window.member.mem_profile_content;
            this.use_sociallogin_facebook = window.use_sociallogin_facebook;
            this.use_sociallogin_twitter = window.use_sociallogin_twitter;
            this.use_sociallogin_google = window.use_sociallogin_google;
            this.use_sociallogin_naver = window.use_sociallogin_naver;
            this.use_sociallogin_kakao = window.use_sociallogin_kakao;
            this.social = window.member.social;

        },
        methods: {
            changePassword() {
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
            social_connect_on(social_type) {

                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }
                var winObj = window.open('/social/' + social_type + '_login', social_type + '-on', 'width=600,height=600');
                winObj.onunload = function(){
                    window.location.reload();
                }

            },
            social_connect_off(social_type) {

                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }

                if ( ! confirm('연동을 해제하시겠습니까?')) {
                    return false;
                }
                let formData = new FormData();
                formData.append('is_submit', '1');
                axios.post('/social/social_connect_off/' + social_type, formData)
                    .then(res => res.data)
                    .then(data => {
                        this.social[social_type + '_id'] = null;
                    });
            },
            toggleConnect(social_type) {
                if(this.social[social_type + '_id']) {
                    this.social_connect_off(social_type);
                } else {
                    this.social_connect_on(social_type);
                }
            },
            saveData() {
                let formData = new FormData();
                formData.append('mem_nickname', this.mem_nickname);
                formData.append('mem_email', this.mem_email)
                formData.append('mem_type', this.mem_type);
                formData.append('mem_firstname', this.mem_firstname);
                formData.append('mem_lastname', this.mem_lastname);
                formData.append('mem_address1', this.mem_address1);
                formData.append('mem_profile_content', this.mem_profile_content);

                axios.post('/membermodify/ajax_modify', formData)
                    .then(res => res.data)
                    .then(data => {
                        alert(data.message);
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .btn:not(.btn-block) {
        width: 75px;
    }

    .custom-control-label:before {
        border: solid 1px white;
        background: none;
    }

    .social-icon {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        margin-right: 10px;

        &.facebook {
            background-color: #4267B2;
        }

        &.google {
            background-color: #4d90fe;
        }

        &.twitter {
            background-color: #32a7e0;
        }

        &.naver {
            background-color: #03cf5d;
        }

        &.kakao {
            background-color: #ffe812;
        }
    }

    .rounded {
        border-radius: 30px !important;
    }
</style>