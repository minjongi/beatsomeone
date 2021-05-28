<template>
    <div class="row">
        <ul class="menu">
            <li :class="{'active':current === 'dashboard'}" @click="goRoute('dashboard')">{{$t('dashboard')}}</li>
            <li :class="{'active':current === 'profilemod'}" @click="goRoute('profilemod')">{{$t('manageInformation')}}</li>
            <li :class="{'active':current === 'list_item'}" @click="goRoute('list_item')" v-show="groupType == 'SELLER'">{{$t('productList')}}</li>
            <li :class="{'active':current === 'regist_item'}" @click="goPage('regist_item')" v-show="groupType == 'SELLER'">{{$t('registrationOfBeat')}}</li>
            <li :class="{'active':current === 'mybilling'}" @click="goRoute('mybilling')">{{$t('orderHistory')}}</li>
            <li :class="{'active':current === 'saleshistory'}" @click="goRoute('saleshistory')" v-show="groupType == 'SELLER'">{{$t('salesHistory')}}</li>
            <li :class="{'active':current === 'message'}" @click="goRoute('message')" v-if="false">{{$t('chat')}}</li>
            <li :class="{'active':current === 'seller'}" @click="goRoute('seller')" v-if="false" v-show="groupType == 'SELLER'">{{$t('settlementHistory')}}</li>
            <li @click="goUpgrade()" v-show="groupType == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
            <li @click="goUpgrade('sub')">{{$t('lang156')}}</li>
            <li :class="{'active':current === 'faq'}" @click="goRoute('faq')">FAQ</li>
<!--            <li :class="{'active':(current === 'inquiry' || current === 'faq')}" @click="openSubmenu($event)">{{$t('support1')}}-->
<!--                <ul class="menu">-->
<!--                    <li :class="{'active':current === 'inquiry'}" @click="goRoute('inquiry')">{{$t('supportCase')}}</li>-->
<!--                    <li :class="{'active':current === 'faq'}" @click="goRoute('faq')">FAQ</li>-->
<!--                </ul>-->
<!--            </li>-->
        </ul>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                current: 'dashboard',
                member_group_name: ''
            }
        },
        created() {
            this.current = this.parseRoute(this.$router.currentRoute.path);
            this.member_group_name = window.member_group_name;
        },
        mounted() {
        },
        methods: {
            goPage: function (page) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/' + page)
            },
            goRoute: function (page) {
                this.current = page

                let p = null;
                switch (page) {
                    case 'dashboard':
                    case '':
                        p = '/'
                        break
                    default:
                        p = '/' + page
                        break
                }
                this.$router.push({path: p})
            },
            goUpgrade(type = null) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/upgrade' + (type ? '?type=' + type : ''))
            },
            parseRoute(r) {
                let p = null;
                switch (r) {
                    case '/':
                        p = 'dashboard'
                        break
                    default:
                        p = r.replace('/', '')
                        break
                }
                return p
            },
            openSubmenu($event) {
                let element = $event.currentTarget;
                let path = this.parseRoute(this.$router.currentRoute.path);
                if (path !== 'inquiry' && path !== 'faq') {
                    this.goRoute('inquiry');
                }
            }
        },
        computed: {
            groupType() {
                if (this.member_group_name === 'buyer') {
                    return 'CUSTOMER';
                } else if (this.member_group_name.includes('seller')) {
                    return 'SELLER';
                } else {
                    return 'CUSTOMER';
                }
            }
        }
    }
</script>
