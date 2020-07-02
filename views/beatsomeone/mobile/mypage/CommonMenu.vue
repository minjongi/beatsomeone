<template>
    <div class="row menu__wraper">
        <ul class="menu">
            <li :class="{'active':current === 'dashboard'}" @click="goRoute('dashboard')">Dashboard</li>
            <li :class="{'active':current === 'profilemod'}" @click="goRoute('profilemod')">Manage Information</li>
            <li :class="{'active':current === 'list_item'}" @click="goPage('list_item')">Product List</li>
            <li :class="{'active':current === 'mybilling'}" @click="goPage('mybilling')">Order History</li>
            <li :class="{'active':current === 'saleshistory'}" @click="goPage('saleshistory')" v-show="groupType == 'SELLER'">Sales History</li>
            <li :class="{'active':current === 'seller'}" @click="goPage('seller')" v-show="groupType == 'SELLER'">Settlement History</li>
            <li :class="{'active':current === 'message'}" @click="goPage('message')">Message</li>
            <li :class="{'active':current === 'sellerregister'}" v-show="groupType == 'CUSTOMER'">Seller Register</li>
            <li :class="{'active':current === 'inquiry'}" @click="goPage('inquiry')">Support
                <ul class="menu">
                    <li @click="goPage('inquiry')">Support Case</li>
                    <li @click="goPage('faq')">FAQ</li>
                </ul>
            </li>
        </ul>
    </div>

</template>


<script>

    import { EventBus } from '*/src/eventbus';

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
