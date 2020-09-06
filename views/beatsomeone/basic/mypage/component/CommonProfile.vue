<template>
    <div class="profile">
        <div class="d-flex justify-content-center mb-3">
            <div class="avatar">
                <img :src="member.mem_photo ? member.mem_photo : '/assets/images/portait.png'" alt="">
                <label for="avatar_file" class="avatar-wrapper">
                    <i class="fa fa-camera"></i>
                    <input type="file" id="avatar_file" accept="image/*" :name="uploadFieldName" :disabled="isAvatarSaving" v-on:change="avatarChange($event.target.name, $event.target.files)">
                </label>
            </div>
        </div>
        <div class="info text-center">
            <div class="group mb-2">
                <div class="badge" :class="member_group_name.includes('buyer') ? 'badge-primary' : 'badge-danger'">
                    {{$t(member_group_name)}}
                </div>
            </div>
            <div class="username">
                {{ member.mem_nickname }}
            </div>
            <div class="bio">
                {{ member.mem_type}}, {{ member.mem_lastname }} {{ member.mem_firstname }}
            </div>
            <div class="location" v-if="member.mem_address1">
                <img class="site" src="/assets/images/icon/position.png"/><div>{{ member.mem_address1 }}</div>
            </div>
            <div class="brandshop">
                <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">{{ $t('goToBrandshop') }} ></a>
            </div>
        </div>
    </div>
</template>


<script>

    import axios from 'axios';

    const AVATAR_SAVING = 1, AVATAR_SUCCESS = 2, AVATAR_FAILED = 3;

    export default {
        data: function () {
            return {
                avatarStatus: null,
                uploadFieldName: 'mem_photo',
                avatarUrl: null,
                member: {},
                member_group_name: '',
            }
        },
        computed: {
            isAvatarSaving() {
                return this.avatarStatus === AVATAR_SAVING;
            }
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
    .avatar {
        position: relative;
        width: 160px;
        padding-top: 160px;

        img {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 160px;
            box-shadow: 0 0 32px rgba(255, 255, 255, 0.5);
        }
    }
    .avatar-wrapper {
        position: absolute;
        width: 30px;
        height: 30px;
        right: 10px;
        bottom: 10px;
        background-color: #4890ff;
        border-radius: 50%;
        line-height: 30px;
        text-align: center;
        font-size: 15px;

        input[type=file] {
            display: none;
        }
    }
</style>
