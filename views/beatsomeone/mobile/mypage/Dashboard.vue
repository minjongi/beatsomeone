<template>

    <div v-if="info">
        <div class="row" v-if="isSeller">
            <Dashboard_SettlementOverview :data="info.SettlementOverview"></Dashboard_SettlementOverview>
        </div>

        <div class="row" v-if="isSeller">
            <Dashboard_Chart :data="info.Chart"></Dashboard_Chart>
        </div>

        <div class="row double">
            <Dashboard_OrderDetails :data="info.OrderDetails"></Dashboard_OrderDetails>
            <Dashboard_ExpiredSoon :data="info.ExpiredSoon" v-if="isCustomer"></Dashboard_ExpiredSoon>
            <Dashboard_ProductDetails :data="info.ProductDetails" v-if="isSeller"></Dashboard_ProductDetails>
        </div>

        <div class="row">
            <Dashboard_RecentlyListen :data="info.RecentlyListen"></Dashboard_RecentlyListen>
        </div>

        <div class="row double" style="margin-bottom:100px;">
            <Dashboard_Message :data="info.Message"></Dashboard_Message>
            <Dashboard_SupportCase :data="info.SupportCase"></Dashboard_SupportCase>
        </div>
    </div>

</template>


<script>

    import Dashboard_OrderDetails from "./component/Dashboard_OrderDetails";
    import Dashboard_ExpiredSoon from "./component/Dashboard_ExpiredSoon";
    import Dashboard_ProductDetails from "./component/Dashboard_ProductDetails";
    import Dashboard_Chart from "./component/Dashboard_Chart";
    import Dashboard_SettlementOverview from "./component/Dashboard_SettlementOverview";

    import Dashboard_RecentlyListen from "./component/Dashboard_RecentlyListen";
    import Dashboard_Message from "./component/Dashboard_Message";
    import Dashboard_SupportCase from "./component/Dashboard_SupportCase";

    export default {
        components: {
            Dashboard_SupportCase,
            Dashboard_Message,
            Dashboard_RecentlyListen,

            Dashboard_SettlementOverview,
            Dashboard_Chart,
            Dashboard_ProductDetails,
            Dashboard_ExpiredSoon,
            Dashboard_OrderDetails,

        },
        data: function() {
            return {
                isLogin: false,
                info: null,

            };
        },
        computed: {
            isCustomer: function () {
                return this.groupType === 'CUSTOMER';
            },
            isSeller: function () {
                return this.groupType === 'SELLER';
            },
            groupType: function() {
                // return 'CUSTOMER';
                if(this.info && this.info.UserInfo) {
                    return this.info.UserInfo.mem_usertype === '1' ? 'CUSTOMER' : 'SELLER';
                } else {
                    return null;
                }
            },
        },
        mounted(){

        },
        created() {
            this.fetchData();
        },
        methods:{

            fetchData: function() {
                Http.post('/BeatsomeoneMypageApi/getDashboardInfo').then(r=> {
                    this.info = r;
                });
            },

        }
    }
</script>


<style lang="scss">

</style>

<style scoped="scoped" lang="css">

</style>