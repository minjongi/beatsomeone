<template>
    <div class="row">
        <div class="type"><span>{{$t('username')}}</span></div>
        <div class="data">
            <div class="input_wrap col">
                <input class="inputbox" minlength="3" maxlength="30" ref="username" :disabled="!isUserNameEditing" @keydown.enter="checkDuplicateUsername" type="text" v-model="tempUserName" :placeholder="$t('enterYourNewUsername')" >
                <CommonCaution v-if="!isNicknameAreDuplicated && !isNicknameAreInvalid">{{$t('noteIDChangeMsg')}}</CommonCaution>
                <CommonCaution css="red" v-if="isNicknameAreDuplicated"> The '{{ this.errrorMsg }}' is already in use. Please change it to another Username.</CommonCaution>
                <CommonCaution css="red" v-if="isNicknameAreInvalid"> Invalid Username.</CommonCaution>
            </div>
            <button class="btn btn--blue active" v-if="!isUserNameEditing" @click="setUsernameEdit(true)">
                {{$t('change1')}}
            </button>
            <button class="btn btn--blue active" v-if="isUserNameEditing" @click="checkDuplicateUsername">
                {{$t('save')}}
            </button>
        </div>
        <div class="active">
            <button class="btn btn--gray" v-if="isUserNameEditing"  @click="setUsernameEdit(false)">
                {{$t('cancel1')}}
            </button>
        </div>
    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import CommonCaution from "./CommonCaution";

    export default {
        components: {CommonCaution},
        props: ['username'],
        data: function () {
            return {
                isUserNameEditing: false,
                tempUserName: null,
                isNicknameAreDuplicated: false,
                isNicknameAreInvalid: false,
                errrorMsg: null,
            }
        },
        watch: {
          username: function(n) {
              this.tempUserName = n;
          }
        },
        created() {

        },
        mounted() {
            this.tempUserName = this.username;
        },
        methods: {
            setUsernameEdit: function(mode) {
                if(!mode) {
                    this.tempUserName = this.username;
                } else {
                    window.requestAnimationFrame(() => this.$refs.username.focus())
                }
                this.isUserNameEditing = mode;
                this.isNicknameAreDuplicated = false;
                this.isNicknameAreInvalid = false;
            },
            validation() {
                this.isNicknameAreInvalid = false;
                // 변경 패스워드 안전성
                if(!/^[a-zA-Z0-9_]{4,12}$/.test(this.tempUserName)) {
                    log.debug('Validation FALSE');
                    this.isNicknameAreInvalid = true;
                    return false;
                }

                return true;
            },
            checkDuplicateUsername() {

                // Validation Check
                if(!this.validation()) return false;

                Http.post('/BeatsomeoneMypageApi/checkDuplicateMemUsername',{'mem_username' : this.tempUserName}).then(r => {
                    log.debug({
                        'checkDuplicateUsername':r,
                    });
                    if(r.result) {
                        this.isNicknameAreDuplicated = true;
                        this.errrorMsg = this.tempUserName;
                    } else {
                        this.isNicknameAreDuplicated = false;
                        // 업데이트 프로세스
                        Http.post('/BeatsomeoneMypageApi/updateMemUsername',{'mem_username' : this.tempUserName}).then(r => {
                            this.$emit('updatedUserName',this.tempUserName);
                            // 종료
                            this.setUsernameEdit(false);
                        },e=> {
                            alert('업데이트 중 문제가 발생 하였습니다');
                        });
                    }
                });
            }
        },
    }

</script>

<style scoped="scoped" lang="scss">
    .input_wrap {
        align-items: flex-start;
    }

    .caution {
        width: 102%;
    }
</style>
