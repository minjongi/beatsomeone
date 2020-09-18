<template>
    <div class="sublist__filter sticky">
    <div class="row center" v-if="info">
        <div class="profile">
            <div class="portrait">
                <img :src="info.mem_photo ? info.mem_photo : '/assets/images/portait.png'">
            </div>
            <div class="info">
                <div class="group">
                    <div class="group_title" :class="groupType">{{groupType}}</div>
                </div>
                <div class="username">
                    {{ info.mem_nickname }}
                </div>
                <div class="bio">
                    {{ memBio }}
                </div>
            </div>
        </div>
        <div class="profile__footer">
            <div class="location" v-if="info.mem_address1">
                <img class="site" src="/assets/images/icon/position.png"/><div>{{ info.mem_address1 }}</div>
            </div>
            <div class="brandshop">
                <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">{{ $t('goToBrandshop') }} ></a>
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
                return this.info ? (this.info.mem_usertype === '1' ? 'CUSTOMER' : 'SELLER') : null;
            },
            memBio() {
                if (this.$i18n.locale === 'en') {
                    return this.info.mem_type + ', ' + this.info.mem_firstname + ' ' + this.info.mem_lastname;
                } else if (this.$i18n.locale === 'ko') {
                    return this.info.mem_type + ', ' + this.info.mem_lastname + ' ' + this.info.mem_firstname;
                }
                return '';
            }
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
