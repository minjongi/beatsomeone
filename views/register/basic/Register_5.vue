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
                                {{ $t('introYourself') }}
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
                    <button type="submit" class="btn btn--submit" @click="doNext">
                        {{ $t('signup') }}
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
            }
        },
        computed: {
            beandshop: function() {
                return 'https://beatsomeone.com/' + this.$parent.info.username;
            },
            isMusician: function() {
                return this.$parent.info.userType === 'musician';
            },
        },
        created() {

        },
        mounted() {

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
            doNext(type) {
                if(this.doValidation()) {
                    /*
                    if(!this.isMusician || this.$parent.info.plan === 'free') {
                        EventBus.$emit('finish_join_form',this.user);
                    } else {
                        EventBus.$emit('submit_join_form',this.user);
                        this.$router.push({path: '/6'});
                    }*/
                    EventBus.$emit('finish_join_form',this.user);

                }else{
                    type.preventDefault();
                }
            },
        },
    }
</script>

<style lang="scss">

</style>

<style lang="css">

</style>
