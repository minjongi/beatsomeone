<template>

    <div class="row" v-if="info">

        <div class="title-content">
            <div class="title">
                <div>{{$t('manageInformation')}}</div>
            </div>
        </div>
        <div class="box" style="padding-bottom:50px;" >
            <Profilemod_UserName :username="info.mem_userid" @updatedUserName="updateUserName"></Profilemod_UserName>
            <div class="row">
                <div class="type"><span>{{$t('userGroup')}}</span></div>
                <div class="data">
                   <div class="group_title" :class="groupType">{{ $t(groupType) }}</div>
                </div>
            </div>
            <div class="row" v-if="isSeller">
                <div class="type"><span>{{$t('sellerClass')}}</span></div>
                <div class="data">
                    <div class="seller_class" :class="sellerClass">{{ sellerClass }}</div>
                </div>
                <div class="active">
                    <button class="btn btn--yellow round">
                        Upgrade Now
                    </button>
                </div>
            </div>

            <Profilemod_Email :email="info.mem_email" @updatedEmail="updateEmail"></Profilemod_Email>
            <Profilemod_Password></Profilemod_Password>

            <div class="row">
                <div class="type"><span>{{$t('yourType')}}</span></div>
                <div class="data">
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
                <div class="data">
                    <input class="inputbox firstname" type="text" v-model="info.mem_firstname" :placeholder="$t('enterYourFirstname1')" >
                    <input class="inputbox lastname" type="text" v-model="info.mem_lastname" :placeholder="$t('enterYourLastname1')" >
                </div>
                <div></div>
            </div>

            <div class="row">
                <div class="type"><span>City of Residence, State</span></div>
                <div class="data">
                    <input class="inputbox" type="text" v-model="info.mem_address1" :placeholder="$t('enterYourLocation')">
                </div>
                <div></div>
            </div>

            <div class="row">
                <div class="type"><span>{{$t('bio')}}</span></div>
                <div class="data">
                    <textarea class="firstname" type="text" v-model="info.mem_profile_content" :placeholder="{{$t('enterYourBio')}}" />
                </div>
                <div></div>
            </div>

            <Profilemod_SocialLink></Profilemod_SocialLink>

        </div>

        <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
            <button class="btn btn--gray" @click="moveDashboard">{{$t('cancel1')}}</button>
            <button type="submit" class="btn btn--submit" @click="updateUserInfo">{{$t('save')}}</button>
        </div>
    </div>


</template>


<script>

    import Profilemod_UserName from "./Profilemod_UserName";
    import Profilemod_Email from "./Profilemod_Email";
    import Profilemod_Password from "./Profilemod_Password";
    import Profilemod_SocialLink from "./Profilemod_SocialLink";

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
                // return 'CUSTOMER';
                if(this.info) {
                    return this.info.mem_usertype === '1' ? 'CUSTOMER' : 'SELLER';
                } else {
                    return null;
                }
            },
            sellerClass: function() {

                if(this.info) {
                    switch (this.info.mem_usertype) {
                        case '2':
                            return 'FREE';
                        case '3':
                            return 'MARKETPLACE';
                        case '4':
                            return 'PRO';
                        default:
                            return null;
                    }
                } else {
                    return null;
                }
            }
        },
        mounted(){

        },
        created() {
            this.fetchInfo();
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
                    // alert('변경내용이 저장 되었습니다');
                    alert(this.$t('dashboard_profilemod_save_ok'));
                    EventBus.$emit('Profilemod_Updated',_.cloneDeep(this.info));
                });
            },
            moveDashboard() {
              window.location.href = '/mypage';
            },


        }
    }
</script>


<style lang="scss">

</style>

