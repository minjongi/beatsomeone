<template>
    <div class="position-relative">
        <Header />
        <Banner v-if="member_group_name === 'buyer'" />
        <div class="container pb-5" :class="member_group_name === 'buyer' ? 'mt--5' : 'pt-140'">
            <div class="main">
                <Sidebar />
                <div class="main-content">
                    <router-view />
                </div>
            </div>
        </div>
<!--        <Music />-->
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
            "secondary": #4d4d4d,
    );

    $container-max-widths: (
            sm: 540px,
            md: 720px,
            lg: 960px,
            xl: 1140px,
            xxl: 1420px,
    );

    $grid-gutter-width: 16px;

    @import "~bootstrap/scss/bootstrap";
    @import "~swiper/swiper";
    @import "~vue-select/src/scss/vue-select";

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

    .pt-140 {
        padding-top: 140px;
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

    .order-history {
        .vhd-container {
            height: 100%;

            .vhd-input {
                line-height: 14px;
                font-size: 14px;
                height: 100%;
                border: solid 1px #414143;
                border-radius: 4px;
                background-color: transparent;
            }

            .vhd-picker {
                left: unset;
                right: 0;
                margin-top: 10px;
                background-color: #2b2c30;
            }

            .vhd-calendar {
                .calendar-month-title {
                    color: white;
                }

                .calendar-date .week .day .in-date-range span {
                    color: black;
                }
            }
        }

        .pagination {
            justify-content: center;

            li {
                width: 50px;
                height: 50px;
                a {
                    color: white;
                }

                &.active {
                    a {
                        color: #ffda2a;
                    }
                }
            }
        }
    }

    .card {
        border: 1px solid #131315;
        border-radius: 10px;
        background-color: #131315;
    }

    .table {
        thead {
            background-color: #1c1d23;
            margin-bottom: 3px;

            tr {
                th {
                    color: white;
                    border-bottom: solid 1px #333640;
                    border-top: solid 1px #333640;

                    &:first-child {
                        border-left: solid 1px #333640;
                    }

                    &:last-child {
                        border-right: solid 1px #333640;
                    }
                }
            }
        }

        tbody {
            tr {
                td {
                    vertical-align: middle;
                    background-color: #1b1b1e;
                    color: #a3a3a5;
                    border-top: solid 1px black;

                    &:first-child {
                        word-break: break-all;
                    }
                }

                &:hover {
                    background-color: #2b2c30;
                    cursor: pointer;

                    td {
                        background-color: transparent;
                    }
                }
            }

            &:before {
                content: "-";
                display: block;
                line-height: 5px;
                color: transparent;
            }
        }
    }

    .tooltip {
        margin-top: 10px;

        &.show {
            opacity: 1;
        }

        .tooltip-inner {
            background-color: #2b2c30;
            color: #8f9097;
        }
    }
    .bs-tooltip-bottom {
        .arrow {

            &::before {
                border-bottom-color: #2b2c30;
            }
        }
    }

    .btn-circle {
        border-radius: 100px;
    }

    hr {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .v-select {
        .vs__dropdown-toggle {
            border: solid 1px #414143;
        }

        .vs__dropdown-menu {
            top: calc(100% + 5px);
            background: #2b2c30;

            .vs__dropdown-option {
                color: #9ea1a8;
            }
        }

        .vs__selected {
            color: white;
            margin: 6px;
        }

        .vs__search, .vs__search:focus {
            margin: 6px;
        }

        .vs__actions {
            padding: 6px;
        }
    }

    .main {
        position: relative;

        .sidebar {
            position: absolute;
            width: 250px;
        }

        .main-content {
            padding-left: 320px;
        }
    }
</style>