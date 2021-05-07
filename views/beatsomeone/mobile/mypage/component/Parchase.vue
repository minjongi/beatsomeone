<template>
    <div class="option_item basic">
      <PurchaseDescLease v-if="type === 'basic'"/>
      <PurchaseDescMastering v-else :includeCopyrightTransfer="item.cit_include_copyright_transfer"/>
    </div>
</template>
<script>
import PurchaseDescLease from "../../component/PurchaseDescLease"
import PurchaseDescMastering from "../../component/PurchaseDescMastering"

export default {
  components: {
    PurchaseDescLease,
    PurchaseDescMastering
  },
  props: ['item', 'type'],
  data: function () {
    return {};
  },
  mounted() {
    console.log(this.item);
  }
};
</script>

<style scoped="scoped" lang="scss">
.option_item.basic {
  margin-top: 15px !important;
  margin-bottom: 0 !important;
}

.purchase-description {
  padding-left: 0 !important;
}

.purchase-description p {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  font-size: 14px;
  margin-bottom: 10px;
  line-height: 20px;
}

.purchase-description p:last-child {
  margin-bottom: 0;
}

.purchase-description p i {
  -webkit-box-flex: 0;
  -ms-flex: none;
  flex: none;
  margin-right: 10px;
  width: 20px;
  text-align: center;
  line-height: 20px;
  height: 20px;
}

.purchase-description p {
  margin-bottom: 5px !important;
}
</style>
