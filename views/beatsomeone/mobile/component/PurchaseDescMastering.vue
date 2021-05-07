<template>
  <div class="purchase-description">
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info4.png" alt/>
      </i>
      {{ $t('lang172') }}
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info6.png" alt/>
      </i>
      {{ $t('lang33') }}
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info6.png"/>
      </i>
      {{ $t('lang34') }}
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info9.png"/>
      </i>
      {{ $t('lang35') }}
    </p>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info8.png"/>
      </i>
      {{ $t('lang36') }}
    </p>
    <div class="copybox">
      <span v-if="includeCopyrightTransfer === '1'">{{ $t('lang180') }}</span>
      <span v-else>{{ $t('lang173') }}</span>
    </div>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info4.png"/>
      </i>
      {{ $t('lang175') }}
    </p>
    <div class="copybox">
      <span v-if="includeCopyrightTransfer === '1'">{{ $t('lang177') }}</span>
      <span v-else>{{ $t('lang176') }}</span>
    </div>
    <p>
      <i>
        <img src="/assets/images/icon/parchase-info10.png"/>
      </i>
      {{ $t('lang41') }}
    </p>
    <div class="copybox">
      <span>{{ $t('lang178') }}</span>
      <span v-if="includeCopyrightTransfer === '1'">{{ $t('lang180') }}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'includeCopyrightTransfer'
  ],
}
</script>
