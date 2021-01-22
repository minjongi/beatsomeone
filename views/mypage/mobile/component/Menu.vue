<template>
    <ul class="nav">
        <li class="nav-item">
            <router-link to="/" class="nav-link">{{$t('dashboard')}}</router-link>
        </li>
        <li class="nav-item">
            <router-link to="/membermodify" class="nav-link">{{$t('manageInformation')}}</router-link>
        </li>
        <li class="nav-item" v-if="member_group_name.includes('seller')">
            <router-link to="/list_item" class="nav-link">{{$t('productList')}}</router-link>
        </li>
        <li class="nav-item" v-if="member_group_name.includes('seller')">
            <a :href="helper.langUrl($i18n.locale, '/mypage/regist_item')" class="nav-link">{{$t('registrationOfBeat')}}</a>
        </li>
        <li class="nav-item">
            <router-link to="/orders" class="nav-link">{{$t('orderHistory')}}</router-link>
        </li>
        <li class="nav-item" v-if="member_group_name.includes('seller')">
            <router-link to="/saleshistory" class="nav-link">{{$t('salesHistory')}}</router-link>
        </li>
        <li class="nav-item">
            <router-link to="/message" class="nav-link">{{$t('chat')}}</router-link>
        </li>
        <li class="nav-item" v-if="member_group_name.includes('seller')">
            <router-link to="/settlement" class="nav-link">{{$t('settlementHistory')}}</router-link>
        </li>
        <li class="nav-item" v-if="member_group_name === 'buyer'">
            <a :href="helper.langUrl($i18n.locale, '/mypage/upgrade')" class="nav-link">{{$t('sellerRegister')}}</a>
        </li>
        <li class="nav-item">
            <router-link to="/inquiry" class="nav-link">{{$t('support1')}}</router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "Menu",
        data : function () {
            return {
                member_group_name: ''
            }
        },
        mounted() {
            this.member_group_name = window.member_group_name;
            this.member = window.member;
        }
    }
</script>

<style lang="scss" scoped>
    .nav {
        flex-wrap: nowrap;
        overflow-x: auto;
        background-color: #1c1d23;

        .nav-item {
            > .nav-link {
                white-space: nowrap;
                padding-top: 15px;
                padding-bottom: 15px;
                color: #babbbd;
                font-weight: bold;

                &.router-link-exact-active {
                    color: #fbd62a;
                    border-bottom: solid 4px #ffda2a;
                }
            }
        }
    }
</style>