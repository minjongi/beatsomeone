<template>
    <div class="n-box">
        <div>
            <button class="playList__item--button">
                                  <span class="option_fold">
                                    <img
                                        src="/assets/images/icon/togglefold.png"
                                        @click.self="toggleButton"
                                    />
                                  </span>
                <div>
                    <div
                        class="title" style="font-size: 12px;"
                        @click.self="toggleButton" v-if="type === 'lease'"
                    >{{ $t('lang23') }}
                    </div>
                    <div v-if="type === 'mastering'"
                        class="title" style="font-size: 12px;"
                        @click.self="toggleButton"
                    >{{ $t('lang30') }}
                    </div>
                    <div class="detail">{{ $t('lang24') }}</div>
                </div>
            </button>
            <div class="option_item basic">
              <PurchaseDescLease/>
            </div>
        </div>
    </div>
</template>

<script>
import PurchaseDescLease from "./PurchaseDescLease"
import PurchaseDescMastering from "./PurchaseDescMastering"

export default {
    components: {
      PurchaseDescLease,
      PurchaseDescMastering
    },
    name: "ItemDetail",
    props: ['item', 'type'],
    methods: {
        toggleButton: function (e) {
            if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box active";
            } else if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box active"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box";
            } else {
                //
            }
        },
        formatPrice: function (kr, en, symbol) {
            if (!symbol) {
                if (this.$i18n.locale === "ko") {
                  return kr;
                } else {
                  return en;
                }
            }
            if (this.$i18n.locale === "ko") {
              return (
                  "₩ " +
                  Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
              );
            } else {
              return (
                  "$ " +
                  Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
              );
            }
        },
    }
}
</script>

<style scoped>
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