<template>
    <header class="main__section1-title" >
        <div class="banner">
            <h3 v-html="$t('togetherWithBeatsomeone')"></h3>
            <p v-html="$t('makeRelationshipWithPeopleMsg')"></p>
            <a href="javascript:;" @click="startSelling" class="btn btn--yellow round">{{$t('startSelling1')}}</a>
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
            startSelling() {
                if (this.member_group_name === 'buyer') {
                    window.location.href = '/mypage/upgrade';
                } else if (this.member_group_name.includes('seller')) {
                    window.location.href = '/mypage/regist_item';
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    .main__section1-title {
        width: 100%;
    }
</style>
