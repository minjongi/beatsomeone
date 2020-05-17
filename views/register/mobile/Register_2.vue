<template>
    <div class="container accounts">
        <div class="accounts__title">
            <h1>
                {{ $t('signup') }}
            </h1>
            <p>
                {{ $t('createMsg') }}
            </p>
        </div>
        <div class="login accounts__defaultLayout">
            <div class="accounts__btnbox border-none">
                <button type="submit" class="btn btn--white" @click="doNext('email')">
                    <img src="@/assets/images/icon/email.png" alt="" />
                    {{ $t('signupWithEmail') }}
                </button>
            </div>

            <div class="accounts__social">
                <h2>{{ $t('snsLogin') }}</h2>
                <a href="#" @click="social_connect_on('facebook')"><img
                        src="@/assets/images/accounts-facebook.png"
                        :alt="$t('loginFacebook')"
                /></a>
                <a href="#"  @click="social_connect_on('twitter')"
                ><img
                        src="@/assets/images/accounts-twitter.png"
                        :alt="$t('loginTwitter')"
                /></a>
                <a href="#"  @click="social_connect_on('google')"
                ><img src="@/assets/images/accounts-google.png" :alt="$t('loginGoogle')"
                /></a>
                <a href="#"  @click="social_connect_on('naver')"
                ><img src="@/assets/images/accounts-naver.png" :alt="$t('loginNaver')"
                /></a>
                <a href="#"  @click="social_connect_on('kakao')"
                ><img src="@/assets/images/accounts-kakao.png" :alt="$t('loginKakao')"
                /></a>
            </div>

            <div class="accounts__etc">
                {{ $t('alreadyAccount') }} <a href="/login">{{ $t('login') }}</a>
            </div>
        </div>
    </div>
</template>

<script>

    import { EventBus } from '*/src/eventbus';

    export default {

        data: function() {
            return {

            }
        },
        created() {

        },
        mounted() {


        },
        watch: {

        },
        methods: {
            doNext(type) {
                EventBus.$emit('submit_join_form',{ accountType: type });
                this.$router.push({path: '/3'});
            },
            social_connect_on(social_type) {
                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }
                window.open('/social/' + social_type + '_login', social_type + '-on', 'width=600,height=600');
            },
            social_connect_on_done(social_type) {
                //$('.social-' + social_type + '-on').css('display', 'inline-block');
                //$('.social-' + social_type + '-off').css('display', 'none');
                alert('연동되었습니다');
            },
            social_connect_off(social_type) {
                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }

                if ( ! confirm('정말로 연동을 해제하시겠습니까?')) {
                    return false;
                }
                /*
                $.ajax({
                    url : '/social/social_connect_off/' + social_type,
                    type : 'post',
                    data : {
                        is_submit : '1',
                        csrf_test_name : cb_csrf_hash
                    },
                    dataType : 'json',
                    success : function(data) {
                        if (data.error) {
                            alert(data.error);
                            return false;
                        } else if (data.success) {
                            $('.social-' + social_type + '-on').css('display', 'none');
                            $('.social-' + social_type + '-off').css('display', 'inline-block');
                        }
                    }
                });
                */
            },
        },
    }




</script>

<style lang="scss">


</style>

<style lang="css">

</style>
