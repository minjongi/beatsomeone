<template>
    <li class="playList__itembox">
        <div class="playList__item playList__item--title other">
            <div class="n-flex h-center">
                <div class="col name">
                    <figure>
                            <span class="playList__cover">
                              <img
                                  v-if="!item.item.cit_file_1"
                                  :src="'/assets/images/cover_default.png'"
                                  alt
                              />
                              <img v-else :src="'/uploads/cmallitem/' + item.item.cit_file_1" alt />
                              <i v-if="item.item.is_new" class="label new">N</i>
                            </span>
                        <figcaption class="pointer">
                            <h3 class="playList__title">{{ formatCitName(item.item.cit_name) }}</h3>
                            <span class="playList__by">by {{item.item.mem_nickname}}</span>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="n-flex">
                <div class="col n-option">
                    <!-- Option -->
                    <div class="option">
                        <ItemDetail :item="item.itemdetail[0]" :type="'lease'" v-if="item.itemdetail[0].cde_title === 'LEASE'" />
                        <ItemDetail :item="item.itemdetail[0]" :type="'mastering'" v-else-if="item.itemdetail[0].cde_title === 'STEM'" />
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import ItemDetail from "../component/ItemDetail";

export default {
    name: "OrderItem",
    props: ['item', 'pg'],
    components: {
        ItemDetail
    },
    mounted() {
        console.log(this.item);
    },
    methods: {
        formatCitName: function (data) {
            var rst;
            var limitLth = 50
            if (limitLth < data.length && data.length <= limitLth * 2) {
                rst = data.substring(0, limitLth) + '<br>' + data.substring(limitLth, limitLth * 2);
            } else if (limitLth < data.length && limitLth * 2 < data.length) {
                rst = data.substring(0, limitLth) + '<br>' + data.substring(limitLth, limitLth * 2) + '...';
            } else {
                rst = data
            }
            return rst;
        },
        formatPrice: function (kr, en) {
            if (this.pg === 'paypal') {
                return '$ ' + Number(en).toLocaleString(undefined, {minimumFractionDigits: 2});
            } else if (this.pg === 'allat') {
                return '₩ ' + Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
            } else {
                return '₩ ' + Number(kr).toLocaleString('ko-KR', {minimumFractionDigits: 0});
            }
        },
    }
}
</script>

<style scoped>

</style>