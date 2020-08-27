<template>
    <div>
        <Header />
        <Banner v-if="member_group_name === 'buyer'" />
        <div class="container-fluid" :class="member_group_name === 'buyer' ? 'mt--5' : ''">
            <Profile />
        </div>
        <Menu />
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <router-view />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Header from "./component/Header";
    import Banner from "./component/Banner";
    import Profile from "./component/Profile";
    import Menu from "./component/Menu";

    export default {
        name: "App",
        components: {
            Header,
            Banner,
            Profile,
            Menu
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

    html, body {
        font-family: "Raleway", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Noto Sans KR";
        background: #000000;
        color: #fff;
        font-size: 14px;
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
</style>