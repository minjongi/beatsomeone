<template>
    <div class="row center" v-if="info">
        <div class="profile">
            <label for="avatar_file" class="avatar-wrapper">
                <i class="fa fa-pencil"></i>
                <input type="file" id="avatar_file" accept="image/*" :name="uploadFieldName" :disabled="isAvatarSaving" v-on:change="avatarChange($event.target.name, $event.target.files)">
            </label>
            <div class="portait" >
                <img :src="info.mem_photo ? info.mem_photo : '/assets/images/portait.png'">
            </div>
            <div class="info">
                <div class="group">
                    <div class="group_title" :class="groupType">{{$t(groupType)}}</div>
                </div>
                <div class="username">
                    {{ info.mem_nickname }}
                </div>
                <div class="bio">
                    {{ info.mem_type}}, {{ info.mem_lastname }} {{ info.mem_firstname }}
                </div>
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
    import * as axios from 'axios';

    const BASE_URL = 'http://192.168.0.182';

    const AVATAR_SAVING = 1, AVATAR_SUCCESS = 2, AVATAR_FAILED = 3;

    export default {
        props: ['info'],
        data: function () {
            return {
                avatarStatus: null,
                uploadFieldName: 'mem_photo',
                avatarUrl: null,
            }
        },
        computed: {
            groupType() {
                return this.info ? (this.info.mem_usertype === '1' ? 'CUSTOMER' : 'SELLER') : null;
            },
            isAvatarSaving() {
                return this.avatarStatus === AVATAR_SAVING;
            }
        },
        created() {

        },
        mounted() {

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
                        this.info.mem_photo = x;
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
    .profile {
        position: relative;
    }

    .portait {
        display: flex;

        img {
            width: 100%;
        }
    }

    .avatar-wrapper {
        position: absolute;
        width: 30px;
        height: 30px;
        right: 30px;
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
