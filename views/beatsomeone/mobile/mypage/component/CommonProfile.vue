<template>
    <div class="sublist__filter sticky">
    <div class="row center" v-if="member">
        <div class="profile">
            <label for="avatar_file" class="file-wrapper">
                <i class="fa fa-camera"></i>
                <input type="file" id="avatar_file" accept="image/*" :name="uploadFieldName" :disabled="isAvatarSaving" v-on:change="avatarChange($event.target.name, $event.target.files)">
            </label>
            <div class="portrait">
                <img :src="member.mem_photo ? member.mem_photo : '/assets/images/portrait.png'">
            </div>
            <div class="info">
                <div class="group">
                    <div class="group_title" :class="groupType">{{$t(groupType)}}</div>
                </div>
                <div class="username">
                    {{ member.mem_nickname }}
                </div>
                <div class="bio">
                    {{ memBio }}
                </div>
            </div>
        </div>
        <div class="profile__footer">
            <div class="location" v-if="member.mem_address1">
                <img class="site" src="/assets/images/icon/position.png"/><div>{{ member.mem_address1 }}</div>
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
    import axios from "axios";

    const AVATAR_SAVING = 1, AVATAR_SUCCESS = 2, AVATAR_FAILED = 3;

    export default {
        data: function () {
            return {
                member: {},
                member_group_name: '',
                avatarStatus: null,
                uploadFieldName: 'mem_photo',
                avatarUrl: null,
            }
        },
        computed: {
            groupType() {
                if (this.member_group_name === 'buyer') {
                    return 'customer';
                } else if (this.member_group_name.includes('seller')) {
                    return 'seller';
                } else {
                  return 'customer';
                }
            },
            memBio() {
                if (this.$i18n.locale === 'en') {
                    return (this.member.mem_type ? this.member.mem_type + ', ' : '') + (this.member.mem_firstname ?? '') + ' ' + (this.member.mem_lastname ?? '');
                } else if (this.$i18n.locale === 'ko') {
                    return (this.member.mem_type ? this.member.mem_type + ', ' : '') + (this.member.mem_lastname ?? '') + ' ' + (this.member.mem_firstname ?? '');
                }
                return '';
            },
            isAvatarSaving() {
                return this.avatarStatus === AVATAR_SAVING;
            },
        },
        created() {

        },
        mounted() {
            this.member = window.member;
            this.member_group_name = window.member_group_name;
        },
        methods: {
            uploadAvatar(formData) {
                const url = `/BeatsomeoneMypageApi/updateAvatar`;
                return axios.post(url, formData)
                    .then(x => x.data)
                    .then(x => x.avatar);
            },
            saveAvatar(formData) {
                this.avatarStatus = AVATAR_SAVING;
                this.uploadAvatar(formData)
                    .then(x => {
                        this.member.mem_photo = x;
                        this.avatarStatus = AVATAR_SUCCESS;
                    })
                    .catch(err => {
                        this.avatarStatus = AVATAR_FAILED;
                    });

            },
            avatarChange(fieldName, fileList) {
                const formData = new FormData();

                if (!fileList.length) return;

                formData.append(fieldName, fileList[0], fileList[0].name);

                this.saveAvatar(formData);
            }
        },

    }

</script>

<style scoped="scoped" lang="scss">
.file-wrapper {
    position: absolute;
    z-index: 2;
    top: 18px;
    left: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #4890ff;
    text-align: center;
    line-height: 20px;
    font-size: 12px;

    input[type=file] {
        display: none;
    }
}

.portrait {
    img {
        width: 100%;
        height: 100%;
    }
}
</style>
