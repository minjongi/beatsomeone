<template>
    <div class="position-relative">
        <Header />
        <Banner v-if="member_group_name === 'buyer'" />
        <div class="container pb-5" :class="member_group_name === 'buyer' ? 'mt--5' : 'pt-85'">
            <div class="row">
                <div class="col-3">
                    <Sidebar />
                </div>
                <div class="col-9">
                    <router-view />
                </div>
            </div>
        </div>
        <Music />
    </div>
</template>

<script>
    import Header from "./component/Header.vue";
    import Footer from "./component/Footer.vue";
    import Banner from "./component/Banner.vue";
    import Sidebar from "./component/Sidebar.vue";
    import Music from "./component/Music";
    export default {
        components: {
            Music,
            Sidebar,
            Footer,
            Header,
            Banner
        },
        data: function () {
            return {
                member_group_name: '',
            }
        },
        mounted() {
            this.member_group_name = window.member_group_name;
        }
    }
</script>

<style lang="scss">
    $theme-colors: (
            "primary": #4890ff,
            "danger": #ff4848,
            "success": #2dad8e,
    );
    @import "~bootstrap/scss/bootstrap";
    @import "~swiper/swiper";

    html, body {
        min-width: 1420px;
        font-family: "Raleway", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Noto Sans KR";
        background: #000000;
        color: #fff;
    }

    .section-title {
        span {
            color: #ffda2a;
            text-decoration: underline;
        }
    }

    .btn.btn-yellow{
        background: #ffda2a;
        color: #000;
    }

    .round {
        border-radius:100px;
    }

    .font-size-12 {
        font-size: 12px !important;
    }

    .mt--5 {
        margin-top: -5rem;
    }

    .pt-85 {
        padding-top: 85px;
    }

    .form-group {
        label {
            opacity: 0.7;
        }

        .form-text {
            color: hsla(0,0%,100%,.3);
        }
    }

    .form-control {
        background: hsla(0,0%,100%,.1);
        color: #fff;
        border: solid 1px rgba(255, 255, 255, 0.1);

        &:focus {
            color: #fff;
            background-color: #2b2b2d;
            border: solid 1px rgba(255, 255, 255, 0.1);
        }

        &:hover {
            color: #fff;
            background: hsla(0,0%,100%,.3);
            border: solid 1px rgba(255, 255, 255, 0.1);
        }

        &:disabled, &[readonly] {
            background: hsla(0,0%,100%,.1);
            border: solid 1px rgba(255, 255, 255, 0.1);
        }
    }

    .modal-content {
        background-color: #2b2c30;
    }

    .btn-default {
        background-color: #404040;
        color: #fff;

        &:hover {
            color: #b1b1b1;
        }
    }
</style>