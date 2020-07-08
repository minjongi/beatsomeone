<template>
    <div class="row">
        <ul class="menu">
            <li :class="{'active':current === 'dashboard'}" @click="goRoute('dashboard')">{{$t('dashboard')}}</li>
            <li :class="{'active':current === 'profilemod'}" @click="goRoute('profilemod')">{{$t('manageInformation')}}</li>
            <li :class="{'active':current === 'list_item'}" @click="goPage('list_item')">{{$t('productList')}}</li>
            <li :class="{'active':current === 'mybilling'}" @click="goPage('mybilling')">{{$t('orderHistory')}}</li>
            <li :class="{'active':current === 'regist_item'}" @click="goPage('regist_item')" v-show="groupType == 'SELLER'">{{$t('registrationOfBeat')}}</li>
            <li :class="{'active':current === 'saleshistory'}" @click="goPage('saleshistory')" v-show="groupType == 'SELLER'">{{$t('salesHistory')}}</li>
            <li :class="{'active':current === 'seller'}" @click="goPage('seller')" v-show="groupType == 'SELLER'">{{$t('settlementHistory')}}</li>
            <li :class="{'active':current === 'message'}" @click="goPage('message')">{{$t('chat')}}</li>
            <li :class="{'active':current === 'sellerreg'}" @click="goPage('sellerreg')" v-show="groupType == 'CUSTOMER'">{{$t('sellerRegister')}}</li>
            <li :class="{'active':current === 'inquiry'}" @click="goPage('inquiry')">{{$t('support1')}}
                <ul class="menu">
                    <li @click="goPage('inquiry')">{{$t('supportCase')}}</li>
                    <li @click="goPage('faq')">FAQ</li>
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
            log.debug({
                'this.$router.currentRoute' : this.$router.currentRoute.path,
            });
            this.current = this.parseRoute(this.$router.currentRoute.path);
        },
        mounted() {

        },
        methods: {
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            goRoute: function(page){
                this.current = page;

                let p = null;
                switch (page) {
                    case 'dashboard':
                        p = '/';
                        break;
                    case 'profilemod':
                        p = '/profilemod';
                        break;
                    default:
                        p = '/';
                        break;
                }
                this.$router.push({ path: p});
            },
            parseRoute(r) {
                let p = null;
                switch (r) {
                    case '/':
                        p = 'dashboard';
                        break;
                    case '/profilemod':
                        p = 'profilemod';
                        break;
                    default:
                        p = '';
                        break;
                }
                return p;
            },
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
