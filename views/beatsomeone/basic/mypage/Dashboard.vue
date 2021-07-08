<template>
    <div>
        <div class="row double">
            <Dashboard_OrderDetails :data="order_summary"></Dashboard_OrderDetails>
            <Dashboard_ExpiredSoon :data="expired_soon_items"></Dashboard_ExpiredSoon>
            <Dashboard_ProductDetails :data="product_summary" v-if="isSeller"></Dashboard_ProductDetails>
        </div>

        <div class="row">
            <Dashboard_RecentlyListen :data="recently_listen_items"></Dashboard_RecentlyListen>
        </div>

        <div class="row double" style="margin-bottom:100px;" v-if="false">
            <Dashboard_Message :data="messages"></Dashboard_Message>
            <Dashboard_SupportCase :data="inquiries"></Dashboard_SupportCase>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    import Dashboard_OrderDetails from "./component/Dashboard_OrderDetails";
    import Dashboard_ExpiredSoon from "./component/Dashboard_ExpiredSoon";
    import Dashboard_ProductDetails from "./component/Dashboard_ProductDetails";
    import Dashboard_SettlementOverview from "./component/Dashboard_SettlementOverview";
    import Dashboard_Header from "./component/Dashboard_Header";
    import Dashboard_RecentlyListen from "./component/Dashboard_RecentlyListen";
    import Dashboard_Message from "./component/Dashboard_Message";
    import Dashboard_SupportCase from "./component/Dashboard_SupportCase";

    export default {
        components: {
            Dashboard_SupportCase,
            Dashboard_Message,
            Dashboard_RecentlyListen,
            Dashboard_Header,
            Dashboard_SettlementOverview,
            Dashboard_ProductDetails,
            Dashboard_ExpiredSoon,
            Dashboard_OrderDetails,
        },
        data: function() {
            return {
                isLogin: false,
                member: {},
                member_group_name: '',
                settlement_summary: {},
                chart_data: null,
                expired_soon_items: [],
                order_summary: {},
                product_summary: {},
                recently_listen_items: [],
                messages: [],
                inquiries: []
            };
        },
        computed: {
            isCustomer: function () {
                return this.member_group_name === 'buyer';
            },
            isSeller: function () {
                return this.member_group_name.includes('seller');
            },
        },
        mounted(){
            this.member = window.member;
            this.member_group_name = window.member_group_name;

            axios.get('/mypage/ajax_info')
                .then(res => res.data)
                .then(data => {
                    this.$set(this.order_summary, 'order_deposit_count', data.order_deposit_count);
                    this.$set(this.order_summary, 'order_order_count', data.order_order_count);
                    this.$set(this.order_summary, 'order_cancel_count', data.order_cancel_count);
                    this.expired_soon_items = data.expired_soon_items;
                    this.recently_listen_items = data.recently_listen_items;
                    this.messages = data.messages;
                    this.inquiries = data.inquiries;
                    if (this.isSeller) {
                        this.$set(this.settlement_summary, 'total_sale_funds', data.total_sale_funds);
                        this.$set(this.settlement_summary, 'total_sale_funds_d', data.total_sale_funds_d);
                        this.$set(this.settlement_summary, 'total_last_sale_funds', data.total_last_sale_funds);
                        this.$set(this.settlement_summary, 'total_last_sale_funds_d', data.total_last_sale_funds_d);
                        this.$set(this.settlement_summary, 'total_settle_funds', data.total_settle_funds);
                        this.$set(this.settlement_summary, 'total_settle_funds_d', data.total_settle_funds_d);
                        this.$set(this.settlement_summary, 'total_last_settle_funds', data.total_last_settle_funds);
                        this.$set(this.settlement_summary, 'total_last_settle_funds_d', data.total_last_settle_funds_d);
                        this.$set(this.settlement_summary, 'total_lastlast_settle_funds', data.total_lastlast_settle_funds);
                        this.$set(this.settlement_summary, 'total_lastlast_settle_funds_d', data.total_lastlast_settle_funds_d);
                        this.$set(this.product_summary, 'total_product_count', data.total_product_count);
                        this.$set(this.product_summary, 'selling_product_count', data.selling_product_count);
                        this.$set(this.product_summary, 'pending_product_count', data.pending_product_count);
                        this.chart_data = data.saleData;
                    }
                })
                .catch(error => {
                    console.error(error);
                })
        },
        created() {
            // this.fetchData();
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