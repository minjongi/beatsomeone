<template>

    <div class="row" v-if="info">

        <div class="box"  >
            <Profilemod_UserName :username="info.mem_userid" @updatedUserName="updateUserName"></Profilemod_UserName>
            <div class="row">
                <div class="type"><span>{{$t('userGroup')}}</span></div>
                <div class="data">
                   <div class="group_title" :class="groupType">{{ groupType }} &nbsp;&nbsp; {{ $t(groupType_subscribe) }}</div>
                </div>
            </div>


            <div class="row" v-if="isSeller">
                <div class="type"><span>{{$t('sellerClass')}}</span></div>
                <div class="n-flex between data" style="margin-top: -10px; margin-bottom: -10px;">
                    <div class="seller_class " :class="sellerClass">{{ $t(sellerClass) }}</div>

                    <div class="active">
                        <button @click="goToUpgrade" class="btn btn--yellow round"> Upgrade Now </button>
                    </div>
                </div>

            </div>

            <Profilemod_Email :email="info.mem_email" @updatedEmail="updateEmail"></Profilemod_Email>
            <Profilemod_Password></Profilemod_Password>

            <div class="row">
                <div class="type"><span>{{$t('yourType')}}</span></div>
                <div class="data radio-grop">
                    <label for="type1" class="checkbox">
                        <input type="radio" name="type" hidden="hidden" id="type1" value="Music Lover" v-model="info.mem_type">
                        <span></span><div> Music Lover</div>
                    </label>
                    <label for="type2" class="checkbox">
                        <input type="radio" name="type" hidden="hidden" id="type2" value="Recording Artist" v-model="info.mem_type">
                        <span></span><div> Recording Artist</div>
                    </label>
                    <label for="type3" class="checkbox">
                        <input type="radio" name="type" hidden="hidden" id="type3" value="Music Producer" v-model="info.mem_type">
                        <span></span><div> Music Producer</div>
                    </label>
                    <label for="type4" class="checkbox">
                        <input type="radio" name="type" hidden="hidden" id="type4" value="Artist/Producer" v-model="info.mem_type">
                        <span></span><div> Artist/Producer</div>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="type"><span>{{$t('realName')}}</span></div>
                <div class="data input_wrap">
                    <input class="inputbox firstname" type="text" v-model="info.mem_firstname" :placeholder="$t('enterYourFirstname1')" >
                    <input class="inputbox lastname" style="margin-left: 10px;" type="text" v-model="info.mem_lastname" :placeholder="$t('enterYourLastname1')" >
                </div>
                <div></div>
            </div>

            <div class="row">
                <div class="type"><span>{{$t('cityOfResidenceState')}}</span></div>
                <div class="data input_wrap">
                    <input class="inputbox" type="text" v-model="info.mem_address1" :placeholder="$t('enterYourLocation')">
                </div>
                <div></div>
            </div>

            <div class="row">
                <div class="type"><span>{{$t('bio')}}</span></div>
                <div class="data input_wrap">
                    <textarea class="firstname" style="height: 128px;" type="text" v-model="info.mem_profile_content" :placeholder="$t('enterYourBio')" />
                </div>
                <div></div>
            </div>

            <Profilemod_SocialLink></Profilemod_SocialLink>

        </div>

        <div class="n-flex" style="margin-top: 30px;">
            <button type="submit" class="btn btn--submit" @click="updateUserInfo">{{$t('save')}}</button>
        </div>

<!--        <div class="btnbox col" style="width:50%; margin:30px auto 100px;">-->
<!--            <button class="btn btn&#45;&#45;gray" @click="moveDashboard">Cancel</button>-->
<!--            <button type="submit" class="btn btn&#45;&#45;submit" @click="updateUserInfo">Save</button>-->
<!--        </div>-->
    </div>


</template>


<script>

    import Profilemod_UserName from "./component/Profilemod_UserName";
    import Profilemod_Email from "./component/Profilemod_Email";
    import Profilemod_Password from "./component/Profilemod_Password";
    import Profilemod_SocialLink from "./component/Profilemod_SocialLink";

    import { EventBus } from '*/src/eventbus';


    export default {
        components: {
            Profilemod_SocialLink,
            Profilemod_Password,
            Profilemod_Email,
            Profilemod_UserName,

        },
        data: function() {
            return {
                isLogin: false,
                info: null,
                csrfHash: null,
                member_group_name: ''
            };
        },
        computed: {
            isCustomer: function () {
                return this.groupType === 'CUSTOMER';
            },
            isSeller: function () {
                return this.groupType === 'SELLER';
            },
            groupType: function() {
                if (this.member_group_name === 'buyer') {
                    return 'CUSTOMER';
                } else if (this.member_group_name.includes('seller')) {
                    return 'SELLER';
                } else {
                    return 'CUSTOMER';
                }
            },
            groupType_subscribe() {
                if (this.member_group_name.includes('subscribe_common')) {
                    return 'subscribe_common';
                } else if (this.member_group_name.includes('subscribe_creater')) {
                    return 'subscribe_creater';
                } else {
                    return ''
                }
            },
            sellerClass: function() {
                if (this.member_group_name.includes('seller')) {
                    if (this.member_group_name.includes('free')) {
                        return 'FREE';
                    } else if (this.member_group_name.includes('platinum')) {
                        return 'Platinum';
                    } else if (this.member_group_name.includes('master')) {
                        return 'Master';
                    }
                }
                return '';
            }
        },
        mounted(){
            this.info = window.member;
            this.member_group_name = window.member_group_name;
        },
        created() {
            // this.fetchInfo();
        },
        methods:{
            fetchInfo: function () {
                Http.post('/BeatsomeoneMypageApi/getUserInfo').then(r => {
                    this.info = r;
                });
            },
            updateUserName: function(d) {
                log.debug('UPDATE USER NAME');
                this.info.mem_userid = d;
                EventBus.$emit('Profilemod_Updated',_.cloneDeep(this.info));
            },
            updateEmail: function(d) {
                log.debug('UPDATE EMAIL');
                this.info.mem_email = d;
                EventBus.$emit('Profilemod_Updated',_.cloneDeep(this.info));
            },
            updateUserInfo() {
                Http.post('/BeatsomeoneMypageApi/updateUserInfo',this.info).then(r => {
                    alert(this.$t('dashboard_profilemod_save_ok'));
                    EventBus.$emit('Profilemod_Updated',_.cloneDeep(this.info));
                });
            },
            moveDashboard() {
              window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage');
            },
            goToUpgrade() {
                window.location.href = this.helper.langUrl(this.$i18n.locale, '/mypage/upgrade')
            }
        }
    }
</script>


<style lang="scss">

</style>

