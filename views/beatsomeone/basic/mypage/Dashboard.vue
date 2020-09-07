<template>
    <div class="info">
        <section v-if="isSeller">
            <Dashboard_SettlementOverview :data="settlement_summary"></Dashboard_SettlementOverview>
        </section>

        <section v-if="isSeller">
            <Dashboard_Chart :data="chart_data" v-if="chart_data"></Dashboard_Chart>
        </section>

        <section class="row">
            <div class="col">
                <Dashboard_OrderDetails :data="order_summary"></Dashboard_OrderDetails>
            </div>
            <div class="col" v-if="isCustomer">
                <Dashboard_ExpiredSoon :data="expired_soon_items"></Dashboard_ExpiredSoon>
            </div>
            <div class="col" v-if="isSeller">
                <Dashboard_ProductDetails :data="product_summary"></Dashboard_ProductDetails>
            </div>
        </section>

        <section>
            <Dashboard_RecentlyListen :data="recently_listen_items"></Dashboard_RecentlyListen>
        </section>

        <section class="row">
            <div class="col">
                <Dashboard_Message :data="messages" v-if="messages"></Dashboard_Message>
            </div>
            <div class="col">
                <Dashboard_SupportCase :data="inquiries"></Dashboard_SupportCase>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
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
                user: {},
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
            isSeller() {
                return this.member_group_name.includes('seller');
            },
            isCustomer() {
                return this.member_group_name === 'buyer';
            }
        },
        mounted(){
            this.member_group_name = window.member_group_name;

            axios.get('/mypage/ajax_info')
                .then(res => res.data)
                .then(data => {
                    this.$set(this.order_summary, 'order_buy_count', data.order_buy_count);
                    this.$set(this.order_summary, 'order_cancel_count', data.order_cancel_count);
                    this.$set(this.order_summary, 'order_refund_count', data.order_refund_count);
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
        },
        methods:{
        }
    }
</script>


<style lang="scss">

</style>

<style scoped="scoped" lang="scss">
    section {
        margin-bottom: 50px;
    }
</style>