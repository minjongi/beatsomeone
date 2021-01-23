<template>
    <div class="row menu__wraper">
        <ul class="menu">
            <li :class="{'active':current === 'dashboard'}" @click="goRoute('dashboard')">{{$t('dashboard')}}</li>
            <li :class="{'active':current === 'profilemod'}" @click="goRoute('profilemod')">{{$t('manageInformation')}}</li>
            <li :class="{'active':current === 'list_item'}" @click="goRoute('list_item')" v-if="isSeller">{{$t('productList')}}</li>
            <li :class="{'active':current === 'regist_item'}" @click="goPage('regist_item')" v-if="isSeller">{{$t('registrationOfBeat')}}</li>
            <li :class="{'active':current === 'mybilling'}" @click="goRoute('mybilling')">{{$t('orderHistory')}}</li>
            <li :class="{'active':current === 'saleshistory'}" @click="goRoute('saleshistory')" v-if="isSeller">{{$t('salesHistory')}}</li>
            <li :class="{'active':current === 'message'}" @click="goRoute('message')" v-if="false">{{$t('chat')}}</li>
            <li :class="{'active':current === 'seller'}" @click="goRoute('seller')" v-if="isSeller && false">{{$t('settlementHistory')}}</li>
            <li :class="{'active':current === 'sellerregister'}" v-if="isCustomer" @click="goSellerReg">{{$t('sellerRegister')}}</li>
            <li :class="{'active':current === 'inquiry'}" @click="goRoute('inquiry')">{{$t('support1')}}</li>
        </ul>
    </div>

</template>


<script>

    import { EventBus } from '*/src/eventbus';

    export default {
        data: function () {
            return {
                current: 'dashboard',
                member_group_name: ''
            }
        },
        created() {
            this.current = this.parseRoute(this.$router.currentRoute.path);
        },
        mounted() {
            this.member_group_name = window.member_group_name;
        },
        methods: {
            goPage: function(page){
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/'+page);
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
            goSellerReg() {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/upgrade');
            }
        },
        computed: {
            isSeller() {
                return this.member_group_name.includes('seller');
            },
            isCustomer() {
                return this.member_group_name === 'buyer';
            }
        }

    }

</script>

<style scoped="scoped" lang="sass">

</style>
