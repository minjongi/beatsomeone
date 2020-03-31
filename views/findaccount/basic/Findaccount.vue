<template>

    <div class="wrapper">

        <Header :is-login="isLogin"></Header>
        <div class="container accounts">
            <div class="accounts__title">
                <h1>
                    We will find your ID and password
                </h1>
                <p>
                    If you enter the registered email when you sign up, your ID and
                    password will be emailed to you
                </p>
            </div>
            <div class="login accounts__defaultLayout">
                <form action="">
                    <div class="accounts__form">
                        <div class="row">
                            <label for="">
                                <p class="form-title">Email</p>
                                <div class="input">
                                    <input type="text" placeholder="Type your email" />
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="accounts__btnbox">
                        <button type="submit" class="btn btn--submit" @click="doSendEmail">
                            send
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>


    require('@/assets/js/function');

    import Header from "@/views/beatsomeone/basic/include/Header";
    import Footer from "@/views/beatsomeone/basic/include/Footer";

    import { EventBus } from '*/src/eventbus';

    export default {
        components: {Header,Footer},
        data: function() {
            return {
                isLogin: false,
            }
        },
        mounted() {

        },
        watch: {

        },
        methods: {

            doSendEmail() {
                // TODO : 이메일 인증은 구현되지 않았음
                alert('이메일 인증은 구현되지 않았음')
            },

        },

    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';


</style>

<style lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>
