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
        <ul class="list-group mb-3">
            <li class="list-group-item" v-for="(citem, index) in orderItems" :key="index">
                <div class="row">
                    <div class="col-4">
                        <div class="d-flex">
                            <div class="item-wrapper mr-4">
                                <div class="image-wrapper mb-3">
                                    <img v-if="!citem.item.cit_file_1" :src="'/assets/images/cover_default.png'" alt/>
                                    <img v-else :src="'/uploads/cmallitem/' + citem.item.cit_file_1" alt/>
                                </div>
                            </div>
                            <div>
                                <span class="text-secondary d-block mb-2">{{ citem.item.cit_key }}</span>
                                <h6 class="cit-name">{{ citem.item.cit_name }}</h6>
                                <p class="mem-name">{{ citem.item.mem_firstname + ' ' + citem.item.mem_lastname }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="accordion">
                            <div v-if="citem.item.cit_lease_license_use === '1' && citem.item.cit_mastering_license_use === '1' ">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <span class="option_fold" data-toggle="collapse" data-target="#collapse-basic"><img src="/assets/images/icon/togglefold.png"/></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{$t('lang23')}}</h6>
                                        <span class="text-secondary">{{$t('lang24')}}</span>
                                    </div>
                                </div>
                                <div class="collapse pt-2" id="collapse-basic">
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                                        </i>
                                        {{$t('lang25')}}
                                    </p>
                                    <p></p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info1.png" alt/>
                                        </i>
                                        {{$t('lang26')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info3.png" alt/>
                                        </i>
                                        {{$t('lang27')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info2.png" alt/>
                                        </i>
                                        {{$t('lang28')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info7.png" alt/>
                                        </i>
                                        {{$t('lang29')}}
                                    </p>
                                </div>
                            </div>
                            <div v-if="citem.item.cit_lease_license_use === '1' && citem.item.cit_mastering_license_use === '0' ">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <span class="option_fold" data-toggle="collapse" data-target="#collapse-basic2"><img src="/assets/images/icon/togglefold.png"/></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{$t('lang23')}}</h6>
                                        <span class="text-secondary">{{$t('lang24')}}</span>
                                    </div>
                                </div>
                                <div class="collapse pt-2" id="collapse-basic2">
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                                        </i>
                                        {{$t('lang25')}}
                                    </p>
                                    <p></p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info1.png" alt/>
                                        </i>
                                        {{$t('lang26')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info3.png" alt/>
                                        </i>
                                        {{$t('lang27')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info2.png" alt/>
                                        </i>
                                        {{$t('lang28')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info7.png" alt/>
                                        </i>
                                        {{$t('lang29')}}
                                    </p>
                                </div>
                            </div>
                            <div v-if="citem.item.cit_lease_license_use === '0' && citem.item.cit_mastering_license_use === '1' ">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <span class="option_fold" data-toggle="collapse" data-target="#collapse-basic3"><img src="/assets/images/icon/togglefold.png"/></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{$t('lang30')}}</h6>
                                        <span class="text-secondary">{{$t('lang31')}}</span>
                                    </div>
                                </div>
                                <div class="collapse pt-2" id="collapse-basic3">
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                                        </i>
                                        {{$t('lang25')}}
                                    </p>
                                    <p></p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info1.png" alt/>
                                        </i>
                                        {{$t('lang26')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info3.png" alt/>
                                        </i>
                                        {{$t('lang27')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info2.png" alt/>
                                        </i>
                                        {{$t('lang28')}}
                                    </p>
                                    <p>
                                        <i>
                                            <img src="/assets/images/icon/parchase-info7.png" alt/>
                                        </i>
                                        {{$t('lang29')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col">
                                <p>
                                    <i class="fa fa-play-circle"></i>
                                    0:00 / 0:00
                                </p>
                                <h6 class="text-warning">
                                    {{ $t('currencySymbol') }}{{ $i18n.locale === 'en' ? citem.itemdetail[0].cde_price_d : citem.itemdetail[0].cde_price }}
                                </h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-circle btn-primary btn-lg">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">

                    </div>
                </div>
            </li>
        </ul>
        <div class="row mb-4">
            <div class="col-12">
                <p class="text-secondary">
                    ※- {{$t('downloadNotAvailableWhenDepositMsg')}}
                    <br/>
                    ※- {{$t('downloadAvailable60Msg')}}
                </p>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5>{{$t('payMethod1')}}</h5>
                            <h5 class="ml-auto">{{ $t(order.cor_pay_type) }}</h5>
                        </div>
                        <div class="d-flex">
                            <h5>{{$t('payMethodDetail')}}</h5>
                            <h5 class="ml-auto">{{ order.cor_pg }}</h5>
                        </div>
                        <div class="d-flex">
                            <h5>{{$t('paySubtotal')}}</h5>
                            <h5 class="ml-auto">{{ order.cor_total_money }}</h5>
                        </div>
                        <hr>
                        <div class="text-warning d-flex">
                            <h5>{{$t('payTotal')}}</h5>
                            <h5 class="ml-auto">{{ order.cor_total_money }}</h5>
                        </div>
                    </div>
                </div>
                <p class="text-center">
                    <i class="text-primary fa fa-info-circle"></i> If you're in a deposit waiting state or wish to cancel, please request a change through a <a href="javascript:;" @click="$router.push('/inquiries')">Support Case</a> menu
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-secondary mr-3" @click="$router.push('/orders')">{{$t('backToList')}}</button>
                <button v-if="order.cor_status==='1'" data-toggle="modal" data-target="#refund-dialog" type="button" class="btn btn-primary">{{$t('requestRefund')}}</button>
            </div>
        </div>
        <div class="modal fade" id="refund-dialog" v-if="order.cor_status==='1'">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-body p-5">
                        <h5 class="mb-4">Request Refund</h5>
                        <div class="d-flex mb-4">
                            <div class="w-auto mr-2">
                                <span class="text-white font-weight-bold mr-3">{{$t('orderNumber')}}</span>
                                <span class="text-secondary">{{ order.cor_id }}</span>
                            </div>
                            <div class="w-auto mr-2">
                                <span class="text-white font-weight-bold mr-3">{{$t('date')}}</span>
                                <span class="text-secondary">{{ order.cor_datetime }}</span>
                            </div>
                            <div class="w-auto">
                                <span class="text-white font-weight-bold mr-3">{{$t('status')}}</span>
                                <span :class="{ 'text-success': order.cor_status === '0', 'text-primary': order.cor_status === '1', 'text-danger': order.cor_status === '2' }">{{ $t(funcStatus(order.cor_status)) }}</span>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <div class="custom-control ml-3 custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="selectAll">
                                <label class="custom-control-label" for="selectAll">Select All(/{{ orderItems.length }})</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <ul class="list-group mb-3">
                                <li class="list-group-item" v-for="(citem, index) in orderItems" :key="index">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" :id="'refund-checkbox' + index">
                                                        <label class="custom-control-label" :for="'refund-checkbox' + index"></label>
                                                    </div>
                                                </div>
                                                <div class="item-wrapper mr-4">
                                                    <div class="image-wrapper mb-3">
                                                        <img v-if="!citem.item.cit_file_1" :src="'/assets/images/cover_default.png'" alt/>
                                                        <img v-else :src="'/uploads/cmallitem/' + citem.item.cit_file_1" alt/>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="text-secondary d-block mb-2">{{ citem.item.cit_key }}</span>
                                                    <h6 class="cit-name">{{ citem.item.cit_name }}</h6>
                                                    <p class="mem-name">{{ citem.item.mem_firstname + ' ' + citem.item.mem_lastname }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="accordion">
                                                <div v-if="citem.item.cit_lease_license_use === '1' && citem.item.cit_mastering_license_use === '1' ">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <span class="option_fold" data-toggle="collapse" data-target="#collapse-modal"><img src="/assets/images/icon/togglefold.png"/></span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{$t('lang23')}}</h6>
                                                            <span class="text-secondary">{{$t('lang24')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="collapse pt-2" id="collapse-modal">
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info6.png" alt/>
                                                            </i>
                                                            {{$t('lang25')}}
                                                        </p>
                                                        <p></p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info1.png" alt/>
                                                            </i>
                                                            {{$t('lang26')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info3.png" alt/>
                                                            </i>
                                                            {{$t('lang27')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info2.png" alt/>
                                                            </i>
                                                            {{$t('lang28')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info7.png" alt/>
                                                            </i>
                                                            {{$t('lang29')}}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div v-else-if="citem.item.cit_lease_license_use === '1' && citem.item.cit_mastering_license_use === '0' ">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <span class="option_fold" data-toggle="collapse" data-target="#collapse-modal2"><img src="/assets/images/icon/togglefold.png"/></span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{$t('lang23')}}</h6>
                                                            <span class="text-secondary">{{$t('lang24')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="collapse pt-2" id="collapse-modal2">
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info6.png" alt/>
                                                            </i>
                                                            {{$t('lang25')}}
                                                        </p>
                                                        <p></p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info1.png" alt/>
                                                            </i>
                                                            {{$t('lang26')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info3.png" alt/>
                                                            </i>
                                                            {{$t('lang27')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info2.png" alt/>
                                                            </i>
                                                            {{$t('lang28')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info7.png" alt/>
                                                            </i>
                                                            {{$t('lang29')}}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div v-else-if="citem.item.cit_lease_license_use === '0' && citem.item.cit_mastering_license_use === '1' ">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            <span class="option_fold" data-toggle="collapse" data-target="#collapse-modal3"><img src="/assets/images/icon/togglefold.png"/></span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{$t('lang30')}}</h6>
                                                            <span class="text-secondary">{{$t('lang31')}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="collapse pt-2" id="collapse-modal3">
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info6.png" alt/>
                                                            </i>
                                                            {{$t('lang25')}}
                                                        </p>
                                                        <p></p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info1.png" alt/>
                                                            </i>
                                                            {{$t('lang26')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info3.png" alt/>
                                                            </i>
                                                            {{$t('lang27')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info2.png" alt/>
                                                            </i>
                                                            {{$t('lang28')}}
                                                        </p>
                                                        <p>
                                                            <i>
                                                                <img src="/assets/images/icon/parchase-info7.png" alt/>
                                                            </i>
                                                            {{$t('lang29')}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto text-right">
                                            <h5 class="text-warning font-weight-bold">
                                                {{ $t('currencySymbol') }}{{ $i18n.locale === 'en' ? citem.itemdetail[0].cde_price_d : citem.itemdetail[0].cde_price }}
                                            </h5>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">
                                    <span class="text-white font-weight-bold mr-3">{{$t('totalRefund')}}</span>
                                    <span class="text-warning">{{ total_refund }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                total_refund: 0,
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
            formPayType: function (pt) {
                if (pt === 1) {
                    return "creditCard";
                } else if (pt === 2) {
                    return "realtimeBankTransfer";
                } else {
                    return "paypal";
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .list-group {
        background-color: #1c1d23;

        &.list-group-horizontal {
            border: solid 1px #333640;
            border-radius: 0;
        }

        .list-group-item {
            background-color: unset;
            border: 0;
        }
    }

    .item-wrapper {
        width: 200px;
    }

    .image-wrapper {
        padding-top: 100%;
        position: relative;

        img {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 4px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>