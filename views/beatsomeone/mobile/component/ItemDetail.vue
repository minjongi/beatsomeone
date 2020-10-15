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
                <div class="purchase-description">
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                        </i>
                        <!-- {{$t('available60Days')}} -->
                        Profits from performances and can be used in broadcasting
                    </p>
                    <p></p>
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info1.png" alt/>
                        </i>
                        <!-- {{$t('available60Days')}} -->
                        Available for 60 days
                    </p>
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info3.png" alt/>
                        </i>
                        <!-- {{$t('rentedMembersCannotBeRerentedToOthers')}} -->
                        Unable to register commercial music copyrights
                    </p>
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info2.png" alt/>
                        </i>
                        <!-- {{$t('unableToEditArbitrarily')}} -->
                        Only simple cutting editing is possible
                    </p>
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info7.png" alt/>
                        </i>
                        <!-- {{$t('noOtherActivitiesNotAuthorizedByThePlatform')}} -->
                        Will continue to be sold to the majority other than this buyer
                    </p>
                    <div class="copybox">
                        <span>Seller's copyright must also be partially recognized when registering music copyrights.</span>
                        <span>If you wish to transfer copyrights, you need to contact the customer center.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
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
                if (this.$i18n.locale === "en") {
                    return en;
                } else {
                    return kr;
                }
            }
            if (this.$i18n.locale === "en") {
                return (
                    "$ " +
                    Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
                );
            } else {
                return (
                    "₩ " +
                    Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
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