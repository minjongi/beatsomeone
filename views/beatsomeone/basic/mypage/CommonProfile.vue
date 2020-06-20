<template>
    <div class="row center" v-if="info">
        <div class="profile">
            <div class="portait" >
                <img :src="info.mem_photo ? '/uploads/member_photo/' + info.mem_photo : '/assets/images/member_default.png'">
            </div>
            <div class="info">
                <div class="group">
                    <div class="group_title" :class="groupType">{{groupType}}</div>
                </div>
                <div class="username">
                    {{ info.mem_username }}
                </div>
                <div class="bio">
                    {{ info.mem_type}}, {{ info.mem_nickname }}
                </div>
                <div class="location">
                    <img class="site" src="/assets/images/icon/position.png"/><div>{{ info.mem_location }}</div>
                </div>
                <div class="brandshop">
                    <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">Go to Brandshop ></a>
                </div>
            </div>
        </div>
    </div>

</template>


<script>

    import { EventBus } from '*/src/eventbus';

    export default {
        props: ['info'],
        data: function () {
            return {

            }
        },
        computed: {
            groupType() {
                return this.info ? (this.info.mem_usertype === '2' ? 'SELLER' : 'CUSTOMER') : null;
            },
        },
        created() {

        },
        mounted() {

        },
        methods: {

        },

    }

</script>

<style scoped="scoped" lang="sass">

</style>
