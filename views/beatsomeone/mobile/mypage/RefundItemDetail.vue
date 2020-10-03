<template>
    <li class="playList__itembox" v-if="item">
        <div class="playList__item playList__item--title">
            <div class="row">
                <div class="col check">
                    <label class="checkbox" @click="checkRefund(item.item.possible_refund)">
                        <input type="checkbox" :disabled="item.item.possible_refund === 0" hidden="hidden" v-model="checked" />
                        <span></span>
                    </label>
                </div>
                <div class="col name" style="margin-top:0">
                    <figure>
                        <div class="playList__cover">
                            <img :src="item.item.cit_file_1 ? ('/uploads/cmallitem/' + item.item.cit_file_1) : '/assets/images/cover_default.png'" alt/>
                            <i v-if="item.item.is_new" class="label new">N</i>
                        </div>
                        <figcaption class="pointer">
                            <h3 class="playList__title">{{ truncate(item.item.cit_name, 25) }}</h3>
                            <span class="playList__by" v-if="item.item.bpm">( {{ item.item.bpm }} )</span>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="row">
                <div class="col option">
                    <div>
                        <div>
                            <div class="title" v-if="item.itemdetail[0].cde_title == 'LEASE'">BASIC LEASE</div>
                            <div class="title" v-else>MASTERING LICENSE USE</div>
                            <div class="detail">{{ $t('lang24') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col feature" style="align-items: center; justify-content: flex-end">
                    <div class="price">{{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, pg ) }}</div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    name: "RefundItemDetail",
    props: [
        'item',
        'pg',
        'value',
    ],
    computed: {
        checked: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
    methods: {
        truncate(str, n) {
            return (str.length > n) ? str.substr(0, n-1) + '...' : str;
        },
        formatPrice: function (kr, en, pg) {
            if (pg === "paypal") {
                return (
                    "$ " +
                    Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
                );
            } else if (pg === 'allat') {
                return (
                    "₩ " +
                    Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
                );
            } else {
                return (Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0}));
            }
        },
        checkRefund(flag) {
            if (flag === 0) {
                alert('다운로드 이력이 있는 경우 환불신청이 불가합니다.');
            }
        }
    }
}
</script>

<style scoped>

</style>