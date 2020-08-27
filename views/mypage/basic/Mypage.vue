<template>
    <div>
        <Header />
        <Banner v-if="member_group_name === 'buyer'" />
        <div class="container" :class="member_group_name === 'buyer' ? 'mt--5' : ''">
            <div class="row">
                <div class="col-3">
                    <Sidebar />
                </div>
                <div class="col-9">
                    <router-view />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Header from "./component/Header.vue";
    import Footer from "./component/Footer.vue";
    import Banner from "./component/Banner.vue";
    import Sidebar from "./component/Sidebar.vue";
    export default {
        name: "Mypage",
        components: {
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
    );
    @import "~bootstrap/scss/bootstrap";

    html, body {
        min-width: 1420px;
        font-family: "Raleway", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Noto Sans KR";
        background: #000000;
        color: #fff;
    }

    .title {
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
</style>