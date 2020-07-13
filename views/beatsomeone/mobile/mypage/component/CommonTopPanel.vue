<template>
    <div>
        <CommonProfile :info="userinfo"> </CommonProfile>
        <CommonMenu :current="current" :groupType="groupType"></CommonMenu>
    </div>
</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import CommonProfile from "./CommonProfile";
    import CommonMenu from "./CommonMenu";

    export default {
        props: ['userinfo','current'],
        components: {CommonMenu, CommonProfile},
        data: function () {
            return {
                // userinfo: null,
            }
        },
        computed: {
            groupType() {
                return this.userinfo ? (this.userinfo.mem_usertype === '1' ? 'CUSTOMER' : 'SELLER') : null;
            },
        },
        created() {
            // this.fetchInfo();
        },
        mounted() {

        },
        methods: {
            // fetchInfo: function () {
            //     Http.post('/BeatsomeoneMypageApi/getUserInfo').then(r => {
            //        this.userinfo = r;
            //     });
            // },
        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
