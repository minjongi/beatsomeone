<template>
    <div class="panel active">
        <div class="popup active" style="width:1110px;">

            <div class="box" style="padding-bottom:50px;">
                <div class="title" style="margin-bottom:30px;">ACCOUNT SETTING</div>

                <div class="row">
                    <div class="type"><span style="margin-top:-4px;">Bank Name<span class="red">*</span></span>
                    </div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" type="text" v-model="bank_name" placeholder="Enter your bank name...">
                            <div class="caution deactive" style="min-width:100%;">
                                <div>
                                    <img class="caution" src="/assets/images/icon/caution.png">
                                    <img class="warning" src="/assets/images/icon/warning.png">
                                </div>
                                <span>
                                        {{ $t('noteChangeEmailMsg') }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>

                <div class="row">
                    <div class="type"><span style="margin-top:-4px;">Account Number<span class="red">*</span></span>
                    </div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" type="text" v-model="account_number" placeholder="Enter your account number...">
                            <div class="caution deactive" style="min-width:100%;">
                                <div>
                                    <img class="caution" src="/assets/images/icon/caution.png">
                                    <img class="warning" src="/assets/images/icon/warning.png">
                                </div>
                                <span>
                                        {{ $t('noteChangeEmailMsg') }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>

                <div class="row">
                    <div class="type"><span style="margin-top:-4px;">Recipient<span class="red">*</span></span>
                    </div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" type="text" v-model="recipient" placeholder="Enter receipent name...">
                            <div class="caution deactive" style="min-width:100%;">
                                <div>
                                    <img class="caution" src="/assets/images/icon/caution.png">
                                    <img class="warning" src="/assets/images/icon/warning.png">
                                </div>
                                <span>
                                        {{ $t('noteChangeEmailMsg') }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>

                <div class="row" v-if="false">
                    <div class="type"><span style="margin-top:-4px;">Copy of Account<span
                        class="red">*</span></span></div>
                    <div class="data">
                        <label class="btn btn--blue" for="attachbtn">
                            <input type="file" id="attachbtn" style="display:none;">
                            <span style="margin:auto; padding:0 15px;">Attach Copy</span>
                        </label>
                        <div class="attached active" style="margin-left:20px;">
                            <div class="btn btn--glass">
                                <img src="/assets/images/icon/file.png"/>powerfulbeat.mp3
                                <button class="close">
                                    <img src="/assets/images/icon/x-white.png"/>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>


                <div class="row">
                    <div class="title-content">
                        <p>
                            - Please upload a file less than 1mb in size to your account copy.<br/>
                            - Account is only available to the <strong>seller's own account</strong>, and <strong>proof
                            may be required</strong>.
                        </p>
                    </div>
                </div>

                <div class="btnbox" style="text-align:center;">
                    <button class="btn btn--gray" style="width:208px" @click="dismissModal">Cancel</button>
                    <button type="button" class="btn btn--yellow" style="width:208px; margin-left:20px;"
                            @click="doSubmit">Save
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "AccountSettingModal",
    data: function () {
        return {
            bank_name: '',
            account_number: '',
            recipient: '',
            file_attach: null
        }
    },
    methods: {
        dismissModal() {
            this.$emit('dismissModal');
        },
        doSubmit() {
            let formData = new FormData();
            if (!this.bank_name) {
                return false;
            }
            if (!this.account_number) {
                return false;
            }
            if (!this.recipient) {
                return false;
            }
            // if (!this.file_attach) {
            //     return false;
            // }
            formData.append('bank_name', this.bank_name);
            formData.append('account_number', this.account_number);
            formData.append('recipient', this.recipient);
            // formData.append('file', this.file_attach, this.file_attach.name);

            axios.post('/settlement/save_account', formData)
                .then(res => res.data)
                .then(data => {
                    this.$emit('submitModal');
                })
                .catch(error => {
                    console.log(error);
                })
        },
    }
}
</script>

<style scoped>

</style>