<template>
    <div class="modal">
        <div class="modal__content">
            <div class="modal__body" style="padding-bottom:50px;">
                <div class="title" style="font-size: 1.5rem; margin-bottom: 10px;">Request Refund</div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <div class="title">{{ $t('orderNumber') }}</div>
                        <div>{{ order.cor_id }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <div class="title">{{ $t('date') }}</div>
                        <div>{{ order.cor_datetime }}</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <div class="title">{{ $t('status') }}</div>
                        <div :class="{ 'green': order.status === 'order', 'red': order.status === 'deposit' }">
                            {{ $t(order.status) }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="title-content">
                        <div class="title">
                            <label class="checkbox">
                                <input
                                    type="checkbox"
                                    hidden="hidden"
                                    v-model="checkedAll"
                                />
                                <span></span>
                                <div style="font-weight:600">{{ $t('selectAll') }} ({{ countSelected }}/{{
                                        items.length
                                    }})
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="playList productList cart">
                        <ul>
                            <RefundItemDetail v-for="(item, idx) in items" v-model="item.item.is_selected" :item="item"
                                              :key="idx" :pg="order.cor_pg"/>
                        </ul>
                    </div>
                </div>

                <div class="btnbox col">
                    <button class="btn btn--gray" @click="dismissModal">{{ $t('cancel1') }}</button>
                    <button type="submit" class="btn btn--blue" @click="doSubmit">Request Refund</button>
                </div>
            </div>
        </div>
        <form name="fm" hidden>
            <input type=text name="test_cross_key" v-model="allat_crosskey" size="19" maxlength=200>
            <input type=text name="allat_shop_id" v-model="allat_shop_id" size="19" maxlength=20>
            <input type=text name="allat_order_no" v-model="order.cor_id" size="19" maxlength=80>
            <input type=text name="allat_amt" v-model="refundAmount" size="19" maxlength=10>
            <input type=text name="allat_pay_type" v-model="order.cor_pay_type" size="19" maxlength=6>
            <input type=text name="shop_receive_url" value="http://localhost/pg/allat/proc" size="19">
            <input type=hidden name=allat_enc_data value=''>
            <input type="hidden" name="allat_opt_pin" value="NOUSE" size="19">
            <input type="hidden" name="allat_opt_mod" value="APP" size="19">
            <input type=text name="allat_seq_no" value="" size="19" maxlength="10">
            <input type=text name="allat_test_yn" v-model="isAllatTest" size="19" maxlength="1">
        </form>
        <div id='ALLAT_PLUS_PAY'
             style='left:0px; top:0px; width:0px; height:0px; position:absolute; z-index:1000; display:block; background-color:white;'>
            <iframe id='ALLAT_PLUS_FRAME' name='ALLAT_PLUS_FRAME' src='https://tx.allatpay.com/common/iframe_blank.jsp'
                    frameborder=0 width=0px height=0px scrolling=no></iframe>
        </div>
    </div>
</template>

<script>
import RefundItemDetail from "./RefundItemDetail";
import axios from "axios";

export default {
    name: "RefundModal",
    components: {
        RefundItemDetail
    },
    props: [
        'order',
        'items',
    ],
    data: function () {
        return {
            checkedAll: false,
            countSelected: 0,
            allat_shop_id: '',
            allat_crosskey: '',
            refundAmount: 0,
            refundAmountD: 0,
        }
    },
    mounted() {
        axios.get('/payment/pg_config')
            .then(res => res.data)
            .then(data => {
                this.allat_shop_id = data.allat_shop_id;
                this.allat_crosskey = data.allat_crosskey;
            })
            .catch(error => {
                console.error(error);
            });
        this.items.forEach(item => {
            this.$set(item.item, 'is_selected', false);
        });
        console.log(this.items);
    },
    computed: {
        isAllatTest() {
            if (this.order.is_test === '1') {
                return 'Y'
            } else {
                return 'N'
            }
        }
    },
    methods: {
        dismissModal() {
            this.$emit('dismissModal');
        },
        doSubmit() {
            if (this.refundAmount > 0) {
                window.Allat_Plus_Api(document.fm);
            } else {
                alert('취소할 비트를 선택해주세요.');
            }
        },
        procCompletePay(result_cd, result_msg, enc_data) {
            if (result_cd !== '0000' && result_cd !== '0001') {
                window.setTimeout(function () {
                    alert(result_cd + " : " + result_msg);
                }, 1000);
            } else {
                document.fm.allat_enc_data.value = enc_data;
                let formData = new FormData(document.fm);
                formData.append('cor_id', this.order.cor_id);
                formData.append('pg', 'allat');
                let cde_ids = [];
                this.items.forEach(item => {
                    if (item.item.is_selected === true) {
                        cde_ids.push(item.itemdetail[0].cde_id);
                    }
                })
                formData.append('cde_ids[]', cde_ids);
                axios.post('/cmall/ajax_cancel', formData)
                    .catch(res => res.data)
                    .then(data => {
                        alert('결제가 취소되었습니다.')
                        this.$emit('submitModal');
                    })
            }
        }
    },
    watch: {
        checkedAll(val) {
            this.countSelected = 0;
            this.items.forEach(item => {
                if (item.item.possible_refund === 1) {
                    this.$set(item.item, 'is_selected', val);
                    if (val === true) {
                        this.countSelected++;
                    }
                }
            });
        },
        items: {
            deep: true,
            handler(items) {
                this.countSelected = 0;
                this.refundAmount = 0;
                this.refundAmountD = 0;
                items.forEach(item => {
                    if (item.item.is_selected === true) {
                        this.countSelected++;
                        this.refundAmount += (+item.itemdetail[0].cde_price)
                        this.refundAmountD = (+item.itemdetail[0].cde_price_d)
                    }
                });
                // this.checkedAll = this.countSelected === items.length;
            }
        }
    }
}
</script>

<style>

</style>