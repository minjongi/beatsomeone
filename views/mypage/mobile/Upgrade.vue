<template>
    <div>
        <Header />
        <router-view />
    </div>
</template>

<script>
    import Header from "./component/Header";
    export default {
        name: "Upgrade",
        components: {
            Header,
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
        min-height: 100vh;
    }
</style>