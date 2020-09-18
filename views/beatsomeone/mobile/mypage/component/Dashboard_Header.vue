<template>
    <header class="main__section1-title" >
        <div class="banner">
            <h3 v-html="$t('togetherWithBeatsomeone')"></h3>
            <p v-html="$t('makeRelationshipWithPeopleMsg')"></p>
            <button class="btn btn--yellow round" @click="goSellerReg">{{$t('startSelling1')}}</button>
        </div>
    </header>
</template>


<script>

    import { EventBus } from '*/src/eventbus';

    export default {
        props: ['item'],
        data: function () {
            return {
                member_group_name: ''
            }
        },
        created() {

        },
        mounted() {
            this.member_group_name = window.member_group_name;
        },
        methods: {
            goSellerReg() {
                if (this.member_group_name === 'buyer') {
                    window.location.href = '/mypage/upgrade';
                } else if (this.member_group_name.includes('seller')) {
                    window.location.href = '/mypage/regist_item';
                }
            }
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
