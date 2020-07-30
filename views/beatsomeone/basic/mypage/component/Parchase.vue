<template>
  <div class="parchase-description">
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info6.png" alt />
      </i>
      <!-- {{$t('available60Days')}} -->
      Profits from performances and can be used in broadcasting
    </p>
    <p></p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info1.png" alt />
      </i>
      <!-- {{$t('available60Days')}} -->
      Available for 60 days
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info3.png" alt />
      </i>
      <!-- {{$t('rentedMembersCannotBeRerentedToOthers')}} -->
      Unable to register commercial music copyrights
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info2.png" alt />
      </i>
      <!-- {{$t('unableToEditArbitrarily')}} -->
      Only simple cutting editing is possible
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info7.png" alt />
      </i>
      <!-- {{$t('noOtherActivitiesNotAuthorizedByThePlatform')}} -->
      Will continue to be sold to the majority other than this buyer
    </p>
    <div class="copybox">
      <span>Seller's copyright must also be partially recognized when registering music copyrights.</span>
      <span>If you wish to transfer copyrights, you need to contact the customer center.</span>
    </div>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data: function () {
    return {};
  },
  created() {},
  mounted() {},
  methods: {},
};
</script>

<style scoped="scoped" lang="scss">
.playList__item.other .option .active .option_item {
  height: auto !important;
  margin-top: 20px !important;
  margin-bottom: 0 !important;
}
.parchase-description {
}
.parchase-description p {
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
.parchase-description p:last-child {
  margin-bottom: 0;
}
.parchase-description p i {
  -webkit-box-flex: 0;
  -ms-flex: none;
  flex: none;
  margin-right: 10px;
  width: 20px;
  text-align: center;
  line-height: 20px;
  height: 20px;
}
.parchase-description p {
  margin-bottom: 5px !important;
}
</style>
