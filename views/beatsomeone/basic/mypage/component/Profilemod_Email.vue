<template>
    <div class="row">
        <div class="col-4 type"><span>{{$t('email')}}</span></div>
        <div class="col-6 data">
            <div class="input_wrap col">
                <input class="inputbox" ref="Email" maxlength="50" :disabled="!isEmailEditing" @keydown.enter="doSubmit" type="email" v-model="tempEmail" :placeholder="$t('enterYourNewEmail')" >
                <CommonCaution v-if="!isEmailAreDuplicated && !isEmailFormError">{{$t('noteChangeEmailMsg')}}</CommonCaution>
                <CommonCaution css="red" v-if="isEmailAreDuplicated"> The '{{ this.errrorMsg }}' is already in use. Please change it to another Email.</CommonCaution>
                <CommonCaution css="red" v-if="isEmailFormError"> It does not fit the email format. Please enter the correct e-mail address you are currently using.</CommonCaution>
            </div>
            <button class="btn btn--blue active" v-if="!isEmailEditing" @click="setEmailEdit(true)">
                {{$t('change1')}}
            </button>
            <button class="btn btn--blue active" v-if="isEmailEditing" @click="doSubmit">
                {{$t('save')}}
            </button>
        </div>
        <div class="col-2 active">
            <button class="btn btn--gray" v-if="isEmailEditing"  @click="setEmailEdit(false)">
                {{$t('cancel1')}}
            </button>
        </div>
    </div>
</template>


<script>


    import CommonCaution from "./CommonCaution";
    export default {
        components: {CommonCaution},
        props: ['email'],
        data: function () {
            return {
                isEmailEditing: false,
                tempEmail: null,
                isEmailAreDuplicated: false,
                isEmailFormError: false,
                errrorMsg: null,
            }
        },
        watch: {
            email: function(n) {
              this.tempEmail = n;
          }
        },
        created() {

        },
        mounted() {
            this.tempEmail = this.email;
        },
        methods: {
            setEmailEdit: function(mode) {
                if(!mode) {
                    this.tempEmail = this.email;
                } else {
                    window.requestAnimationFrame(() => this.$refs.Email.focus())
                }
                this.isEmailEditing = mode;
                this.isEmailAreDuplicated = false;
            },
            doSubmit() {
                // Validation
                // 변경 패스워드 안전성
                if(!/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i.test(this.tempEmail)) {
                    this.isEmailFormError = true;
                    return;
                } else {
                    this.isEmailFormError = false;
                }

                this.checkDuplicateEmail();
            },
            checkDuplicateEmail() {
                Http.post('/BeatsomeoneMypageApi/checkDuplicateEmail',{'mem_email' : this.tempEmail}).then(r => {
                    log.debug({
                        'checkDuplicateEmail':r,
                    });
                    if(r.result) {
                        this.isEmailAreDuplicated = true;
                        this.errrorMsg = this.tempEmail;
                    } else {
                        this.isEmailAreDuplicated = false;
                        // 업데이트 프로세스
                        Http.post('/BeatsomeoneMypageApi/updateEmail',{'mem_email' : this.tempEmail}).then(r => {
                            this.$emit('updatedEmail',this.tempEmail);
                            // 종료
                            this.setEmailEdit(false);
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

</style>
