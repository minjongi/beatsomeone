<template>
  <div class="option_item" :class="{'basic': type === 'basic', 'unlimited': type === 'mastering'}">
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
};
</script>

<style scoped="scoped" lang="scss">
.playList__item.other .active .option_item.basic {
  height: auto !important;
  margin-top: 20px !important;
  margin-bottom: 0 !important;
}

.playList__item.other .option .active .option_item {
  height: auto !important;
  margin-top: 20px !important;
  margin-bottom: 0 !important;
}

.purchase-description {
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
