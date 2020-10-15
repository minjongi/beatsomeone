<template>
    <div>
        <div class="feature">
            <div class="playbtn">
                <button class="btn-play" @click="playAudio(item, $event)">재생</button>
                <span class="timer"><span class="current">0:00 /</span><span class="duration">0:00</span></span>
            </div>
            <div class="price yellow">
                {{ formatPrice(item.itemdetail[0].cde_price, item.itemdetail[0].cde_price_d, pg) }}
            </div>
        </div>
        <div class="option">
            <div class="n-box" v-if="item.itemdetail[0].cde_title === 'LEASE'">
                <div>
                    <button class="playList__item--button">
                        <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                        <div>
                            <div class="title" @click.self="toggleButton">
                                {{ $t('lang23') }}
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
                                {{$t('lang25')}}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info1.png" alt/>
                                </i>
                                {{$t('lang26')}}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info3.png" alt/>
                                </i>
                                {{$t('lang27')}}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info2.png" alt/>
                                </i>
                                {{$t('lang28')}}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info7.png" alt/>
                                </i>
                                {{$t('lang29')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="n-box" v-else-if="item.itemdetail[0].cde_title === 'STEM'">
                <div>
                    <button class="playList__item--button">
                        <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                        <div>
                            <div class="title" @click.self="toggleButton">
                                {{ $t('lang30') }}
                            </div>
                            <div class="detail">{{ $t('lang31') }}
                                <span class="copytransfer" v-if="item.item.cit_include_copyright_transfer === '1'">{{ $t('lang32') }}</span>
                            </div>
                        </div>
                    </button>
                    <div class="option_item basic">
                        <div class="purchase-description">
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info6.png" alt/>
                                </i>
                                {{ $t('lang33') }}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info8.png" alt/>
                                </i>
                                {{$t('lang34')}}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info9.png" alt/>
                                </i>
                                {{$t('lang35')}}
                            </p>
                            <p>
                                <i>
                                    <img src="/assets/images/icon/parchase-info4.png" alt/>
                                </i>
                                {{$t('lang36')}}
                            </p>
                            <p v-if="item.item.cit_include_copyright_transfer !== '1'">
                                <i>
                                    <img src="/assets/images/icon/parchase-info10.png" alt/>
                                </i>
                                {{$t('lang41')}}
                            </p>
                            <p v-else>
                                <i>
                                    <img src="/assets/images/icon/parchase-info10.png" alt/>
                                </i>
                                {{$t('lang42')}}
                            </p>
                            <div class="copybox" v-if="item.item.cit_include_copyright_transfer !== '1'">
                                <span>{{ $t('lang21') }}</span>
                                <span>{{ $t('lang22') }}</span>
                            </div>
                            <div class="copybox" v-else>
                                <span>{{ $t('lang43') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ItemDetail",
    props: [
        'item',
        'pg'
    ],
    methods: {
        toggleButton: function (e) {
            if (e.target.parentElement.parentElement.parentElement.parentElement.className === "n-box") {
                e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box active";
            } else if (e.target.parentElement.parentElement.parentElement.parentElement.className === "n-box active") {
                e.target.parentElement.parentElement.parentElement.parentElement.className = "n-box";
            } else {
                //
            }
        },
        formatPrice: function (kr, en, pg) {
            if (pg === 'paypal') {
                return '$' + this.formatNumberEn(en);
            } else if (pg === 'allat') {
                return '₩' + this.formatNumber(kr);
            } else {
                return ''
            }
        },
        formatNumber(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 0});
        },
        formatNumberEn(n) {
            //Number(n).toLocaleString('en', {minimumFractionDigits: 3});
            return Number(n).toLocaleString(undefined, {minimumFractionDigits: 2});
        },
        playAudio(i, e) {

        }
    }
}
</script>

<style lang="scss" scoped>
.n-box .playbtn {
    padding: 0;

    button {
        width: 20px;
        height: 20px;
    }

    .timer {
        margin-left: 15px;
    }
}
</style>