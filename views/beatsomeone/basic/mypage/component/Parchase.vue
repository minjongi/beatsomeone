<template>
  <div class="option_item basic">
    <div class="parchase-description">
      <p>
        <i>
          <img src="/assets/images/icon/parchase-info6.png" alt />
        </i>
        {{$t('lang10')}}
      </p>
      <p></p>
      <p>
        <i>
          <img src="/assets/images/icon/parchase-info1.png" alt />
        </i>
        {{$t('lang11')}}
      </p>
      <p>
        <i>
          <img src="/assets/images/icon/parchase-info3.png" alt />
        </i>
        {{$t('lang12')}}
      </p>
      <p>
        <i>
          <img src="/assets/images/icon/parchase-info2.png" alt />
        </i>
        {{$t('lang13')}}
      </p>
      <p>
        <i>
          <img src="/assets/images/icon/parchase-info7.png" alt />
        </i>
        {{$t('lang14')}}
      </p>
      <div class="copybox">
        <span>{{$t('lang21')}}</span>
        <span>{{$t('lang22')}}</span>
      </div>
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
