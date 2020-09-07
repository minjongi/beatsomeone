<template>
    <div class="sidebar">

        <CommonProfile />
        <CommonMenu :current="current" :groupType="groupType"></CommonMenu>
    </div>
</template>


<script>

    import {EventBus} from '*/src/eventbus';
    import CommonProfile from "./CommonProfile";
    import CommonMenu from "./CommonMenu";

    export default {
        props: ['userinfo', 'current'],
        components: {CommonMenu, CommonProfile},
        data: function () {
            return {
                // userinfo: null,
            }
        },
        computed: {
            groupType() {
                return this.userinfo ? (this.userinfo.mem_group ? (this.userinfo.mem_group.mgr_title.includes('buyer') ? 'CUSTOMER' : 'SELLER'): null) : null;
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

<style scoped="scoped" lang="scss">
    .sidebar {
        width: 250px;
        position: absolute;
    }
</style>
