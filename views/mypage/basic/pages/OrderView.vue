<template>
    <div>
        <h5 class="mb-3">{{$t('orderDetail')}}</h5>
        <div class="mb-4">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item">
                    <span class="text-white font-weight-bold mr-3">{{$t('orderNumber')}}</span>
                    <span class="text-secondary">{{ order.cor_id }}</span>
                </li>
                <li class="list-group-item">
                    <span class="text-white font-weight-bold mr-3">{{$t('date')}}</span>
                    <span class="text-secondary">{{ order.cor_datetime }}</span>
                </li>
                <li class="list-group-item">
                    <span class="text-white font-weight-bold mr-3">{{$t('status')}}</span>
                    <span :class="{ 'text-success': order.cor_status === '0', 'text-primary': order.cor_status === '1', 'text-danger': order.cor_status === '2' }">{{ $t(funcStatus(order.cor_status)) }}</span>
                </li>
            </ul>
        </div>
        <h5><span class="text-warning mr-2">{{ orderItems.length }}</span>{{$t('orderedItems')}}</h5>
        <ul class="list-group">
            <li class="list-group-item" v-for="(citem, index) in orderItems" :key="index">
                <div class="d-flex">
                    <div class="item-wrapper">
                        <div class="image-wrapper mb-3">
                            <img :src="'/uploads/cmallitem/' + citem.item.cit_file_1" />
                        </div>
                        <h6 class="cit-name">{{ citem.item.cit_name }}</h6>
                        <p class="mem-name">{{ citem.item.mem_firstname + ' ' + citem.item.mem_lastname }}</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "OrderView",
        data: function () {
            return {
                order: {},
                orderItems: [],
                cor_id: '',
            }
        },
        mounted() {
            this.cor_id = this.$route.params.cor_id;
            axios.get(`/cmall/ajax_orderresult/${this.cor_id}`)
                .then(res => res.data)
                .then(data => {
                    console.log(data);
                    this.order = data.data;
                    this.orderItems = data.orderdetail;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods: {
            funcStatus: function (s) {
                if (s === '0') {
                    return "depositWaiting";
                } else if (s === '1') {
                    return "orderComplete";
                } else {
                    return "refundComplete";
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .list-group {
        background-color: #1c1d23;
        border: solid 1px #333640;
        border-radius: 0;

        .list-group-item {
            background-color: unset;
            border: 0;
        }
    }
</style>