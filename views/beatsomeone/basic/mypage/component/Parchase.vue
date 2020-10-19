<template>
    <div class="option_item" :class="{'basic': type === 'basic', 'unlimited': type === 'mastering'}">
        <div class="purchase-description" v-if="type === 'basic'">
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
            <p v-if="item.cit_include_copyright_transfer !== '1'">
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
            <div class="copybox" v-if="item.cit_include_copyright_transfer !== '1'">
                <span>{{ $t('lang21') }}</span>
                <span>{{ $t('lang22') }}</span>
            </div>
            <div class="copybox" v-else>
                <span>{{ $t('lang43') }}</span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
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
