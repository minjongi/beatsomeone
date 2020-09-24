<template>
  <div class="panel active">
    <div class="popup active" style="width:1000px;">
      <div class="box" style="padding-bottom:50px;">
        <div class="title">Request Refund</div>
        <div class="tab">
          <div>
            <div class="title">{{ $t('orderNumber') }}</div>
            <div>{{ order.cor_id }}</div>
          </div>
          <div>
            <div class="title">{{ $t('date') }}</div>
            <div>{{ order.cor_datetime }}</div>
          </div>
          <div>
            <div class="title">{{ $t('status') }}</div>
            <div :class="{ 'green': order.status === 'order', 'red': order.status === 'deposit' }">
              {{ $t(order.status) }}
            </div>
          </div>
        </div>

        <div class="btnbox col">
          <button class="btn btn--gray" @click="dismissModal">{{$t('cancel1')}}</button>
          <button type="submit" class="btn btn--blue" @click="doSubmit">{{$t('save')}}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "RefundModal",
  props: [
      'order'
  ],
  methods: {
    dismissModal() {
      this.$emit('dismissModal');
    },
    doSubmit() {
      this.$emit('submitModal');
    }
  }
}
</script>

<style >

</style>