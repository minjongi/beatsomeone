<template>
    <div class="sublist__filter sticky">
        <div class="row center" v-if="info">
            <div class="profile">
                <div class="portait">
                    <img :src="info.mem_photo ? info.mem_photo : '/assets/images/portait.png'">
                </div>
                <div class="info">
                    <div class="group">
                        <div class="group_title" :class="groupType">{{$t(info.mem_group.mgr_title)}}</div>
                    </div>
                    <div class="username">
                        {{ info.mem_nickname }}
                    </div>
                    <div class="bio">
                        {{ info.mem_type}}, {{ info.mem_lastname }} {{ info.mem_firstname }}
                    </div>
                </div>
            </div>
            <div class="profile__footer">
                <div class="location" v-if="info.mem_address1">
                    <img class="site" src="/assets/images/icon/position.png"/>
                    <div>{{ info.mem_address1 }}</div>
                </div>
                <div class="brandshop">
                    <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">{{ $t('goToBrandshop') }} ></a>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    import {EventBus} from '*/src/eventbus';

    export default {
        props: ['info'],
        data: function () {
            return {}
        },
        computed: {
            groupType() {
                return this.info ? (this.info.mem_group.mgr_title === 'buyer' ? 'CUSTOMER' : 'SELLER') : null;
            },
        },
        created() {

        },
        mounted() {

        },
        methods: {},

    }

</script>

<style scoped="scoped" lang="sass">

</style>
