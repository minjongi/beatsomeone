<template>
    <div>
        <Header />
        <Banner v-if="member_group_name === 'buyer'" />
        <div class="container-fluid" :class="member_group_name === 'buyer' ? 'mt--5' : 'pt-85'">
            <Profile />
        </div>
        <Menu />
        <router-view />
    </div>
</template>

<script>
    import Header from "./component/Header";
    import Banner from "./component/Banner";
    import Profile from "./component/Profile";
    import Menu from "./component/Menu";

    export default {
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
    @import '~swiper/swiper';

    html, body {
        font-family: "Raleway", -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Noto Sans KR";
        background: #000000;
        color: #fff;
        font-size: 14px;
        min-height: 100%;
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
        padding-top: 85px !important;
    }

    .btn-default {
        background-color: #404040;
        color: #fff;

        &:hover {
            color: #b1b1b1;
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

    .order-history {
        .vhd-container {
            height: 100%;
            width: 100%;

            .vhd-input {
                line-height: 14px;
                font-size: 14px;
                height: 100%;
                width: 100%;
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
                text-align: center;

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

    hr {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>