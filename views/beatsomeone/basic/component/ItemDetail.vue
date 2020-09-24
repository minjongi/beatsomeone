<template>
    <div class="n-box">
        <div>
            <button class="playList__item--button">
                <span class="option_fold"><img src="/assets/images/icon/togglefold.png"
                                               @click.self="toggleButton"/></span>
                <div>
                    <div class="title" @click.self="toggleButton" v-if="type === 'LEASE'">
                        {{ $t('lang23') }}
                    </div>
                    <div class="title" @click.self="toggleButton" v-if="type === 'STEM'">
                        {{ $t('lang30') }}
                    </div>
                    <div class="detail">{{ $t('lang24') }}</div>
                </div>
            </button>
            <div class="option_item basic">
                <div class="purchase-description" v-if="type === 'LEASE'">
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                        </i>
                        {{$t('lang25')}}
                    </p>
                    <p></p>
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
                <div class="purchase-description" v-else>
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info6.png" alt/>
                        </i>
                        {{ $t('lang33') }}
                    </p>
                    <p></p>
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
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info10.png" alt/>
                        </i>
                        {{$t('lang41')}}
                    </p>
                    <p>
                        <i>
                            <img src="/assets/images/icon/parchase-info10.png" alt/>
                        </i>
                        {{$t('lang42')}}
                    </p>
                </div>
            </div>
        </div>
        <div>
            <div class="playbtn">
                <button class="btn-play" @click="playAudio(item, $event)">재생</button>
                <span class="timer"><span class="current">0:00 /</span><span class="duration">0:00</span></span>
            </div>
            <div class="price yellow">
                {{ formatPrice(item.cde_price, item.cde_price_d, pg) }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ItemDetail",
    props: [
        'type',
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