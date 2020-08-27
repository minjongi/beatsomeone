<template>
    <div>
        <div class="row">
            <div class="col-6">
                <h5 class="mb-3 title">
                    {{$t('orderDetails')}}
                    <a href="javascript:;" class="float-right" onclick='location.href = "/mypage#/mybilling"'>
                        <span>more <i class="fal fa-chevron-right"></i></span>
                    </a>
                </h5>
                <div class="split-board row">
                    <div class="col text-center">{{ buyCnt }}<span>{{$t('buy')}}</span></div>
                    <div class="col text-center">{{ cancelCnt }}<span>{{$t('cancel1')}}</span></div>
                    <div class="col text-center">{{ refundCnt }}<span>{{$t('refund')}}</span></div>
                </div>
            </div>
            <div class="col-6">
                <h5></h5>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data: function () {
            return {
                member_group_name: '',
                buyCnt: 0,
                cancelCnt: 0,
                refundCnt: 0,
            }
        },
        mounted() {
            this.member_group_name = window.member_group_name;
        }
    }
</script>

<style scoped>

</style>