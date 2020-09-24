<template>
    <div class="row">
        <ul class="menu">
            <li :class="{'active':current === 'dashboard'}" @click="goRoute('dashboard')">{{$t('dashboard')}}</li>
            <li :class="{'active':current === 'profilemod'}" @click="goRoute('profilemod')">{{$t('manageInformation')}}</li>
            <li :class="{'active':current === 'list_item'}" @click="goRoute('list_item')" v-show="groupType == 'SELLER'">{{$t('productList')}}</li>
            <li :class="{'active':current === 'regist_item'}" @click="goPage('regist_item')" v-show="groupType == 'SELLER'">{{$t('registrationOfBeat')}}</li>
            <li :class="{'active':current === 'mybilling'}" @click="goRoute('mybilling')">{{$t('orderHistory')}}</li>
            <li :class="{'active':current === 'saleshistory'}" @click="goRoute('saleshistory')" v-show="groupType == 'SELLER'">{{$t('salesHistory')}}</li>
            <li :class="{'active':current === 'message'}" @click="goRoute('message')">{{$t('chat')}}</li>
            <li :class="{'active':current === 'seller'}" @click="goRoute('seller')" v-show="groupType == 'SELLER' && false">{{$t('settlementHistory')}}</li>
            <li @click="goUpgrade()" v-show="groupType == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
            <li :class="{'active':(current === 'inquiry' || current === 'faq')}" @click="openSubmenu($event)">{{$t('support1')}}
                <ul class="menu">
                    <li :class="{'active':current === 'inquiry'}" @click="goRoute('inquiry')">{{$t('supportCase')}}</li>
                    <li :class="{'active':current === 'faq'}" @click="goRoute('faq')">FAQ</li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['groupType'],
        data: function () {
            return {
                current: 'dashboard'
            }
        },
        created() {
            this.current = this.parseRoute(this.$router.currentRoute.path)
        },
        mounted() {
        },
        methods: {
            goPage: function (page) {
                window.location.href = '/mypage/' + page
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
            goUpgrade() {
                window.location.href = '/mypage/upgrade'
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
    }
</script>
