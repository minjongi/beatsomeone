<template>

    <div class="wrapper">

        <Header :is-login="isLogin"></Header>
        <div class="container accounts">
            <div class="accounts__title">
                <h1>
                    {{ $t('findYourIDAndPassword') }}
                </h1>
                <p>
                    {{ $t('enterRegisteredMsg') }}
                </p>
                <p v-if="message" v-html="message">
                </p>
            </div>
            <div class="login accounts__defaultLayout">
                <form action="/findaccount" method="post">
                    <input type="hidden" name="findtype" value="findidpw" />
                    <div class="accounts__form">
                        <div class="row">
                            <label for="">
                                <p class="form-title">{{ $t('email') }}</p>
                                <div class="input">
                                    <input type="email" name="idpw_email" placeholder="{{ $t('typeYourEmail1') }}" />
                                </div>
                                <div v-if="errorMsg" v-html="errorMsg" class="errortext"></div>
                            </label>
                        </div>
                    </div>
                    <div class="accounts__btnbox">
                        <button type="submit" class="btn btn--submit" >
                            {{ $t('send1') }}
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
                errorMsg: null,
                message: null,
                isLogin: false,
            }
        },
        mounted() {

        },
        watch: {

        },
        methods: {


        },

    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';


</style>

<style lang="css">
body, html {
    background:#111214 !important;
}
.errortext p{
    font-size: 14px;
    margin-top: 5px;
    opacity: .5;
}
.errortext p:before {
    content:'- ';
}
</style>
