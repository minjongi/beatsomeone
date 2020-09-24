<template>
    <div class="container accounts">
        <div class="accounts__title">
            <h1>
                {{ $t('completeSignup') }}
            </h1>
        </div>
        <div class="login accounts__defaultLayout">
            <form action="">
                <div class="accounts__form">
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
                </div>
                <div class="accounts__btnbox half">
                    <button type="reset" class="btn btn--gray" @click="doSkip">
                        {{ $t('skipping') }}
                    </button>

                    <button type="submit" class="btn btn--submit" @click="doNext">
                        {{ $t('next') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '*/src/eventbus';

    export default {

        data: function() {
            return {
                user: {
                    firstname: '',
                    lastname: '',
                    location: '',
                },
                info: {}
            }
        },
        created() {

        },
        mounted() {
            this.info = JSON.parse(localStorage.getItem('bs_user_info'));
        },
        computed: {
            isCustomer: function () {
                return this.info.group && this.info.group.mgr_title === 'buyer';
            }
        },
        watch: {

        },
        methods: {
            doValidation() {
                if(!this.user.firstname) {
                    alert(this.$t('enterYourFirstName'));
                    return false;
                }

                if(!this.user.lastname) {
                    alert(this.$t('enterYourLastName'));
                    return false;
                }

                if(!this.user.location) {
                    alert(this.$t('enterYourcityOfResidenceState'));
                    return false;
                }

                return true;
            },
            doNext(type) {
                if(this.doValidation()) {
                    let userInfo = this.$store.getters.getUserInfo;
                    userInfo.mem_firstname = this.user.firstname;
                    userInfo.mem_lastname = this.user.lastname;
                    userInfo.mem_address1 = this.user.location;
                    this.$store.dispatch('setUserInfo', userInfo);
                    this.$router.push({path: '/5'});
                }else{
                    type.preventDefault();
                }
            },
            doSkip() {
                this.$router.push({path: '/5'});
            },
        },
    }
</script>

<style lang="scss">

</style>

<style lang="css">

</style>
