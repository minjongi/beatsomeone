<template>
    <div class="mx-3">
        <div class="row mb-3">
            <div class="col-auto">
                <div class="avatar">
                    <label for="avatar_file" class="avatar-file">
                        <i class="fa fa-pencil"></i>
                        <input type="file" class="d-none" id="avatar_file" accept="image/*" :name="uploadFieldName" :disabled="isAvatarSaving" v-on:change="avatarChange($event.target.name, $event.target.files)">
                    </label>
                    <img :src="member.mem_photo ? member.mem_photo : '/assets/images/portait.png'">
                </div>
            </div>
            <div class="col">
                <div class="badge" :class="member_group_name.includes('buyer') ? 'badge-primary' : 'badge-danger'">
                    {{$t(member_group_name)}}
                </div>
                <h5 class="nickname mb-0 font-weight-bold">
                    {{ member.mem_nickname }}
                </h5>
                <p class="font-weight-normal mb-0">
                    {{ member.mem_type}}, {{ member.mem_lastname }} {{ member.mem_firstname }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <p><i class="far fa-map-marker-alt mr-1"></i>{{ member.mem_address1 }}</p>
            </div>
            <div class="col text-center">
                <p><i class="fas fa-store-alt mr-1"></i><a class="text-light" href="#">{{ $t('goToBrandshop') }} ></a></p>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    const AVATAR_SAVING = 1, AVATAR_SUCCESS = 2, AVATAR_FAILED = 3;

    export default {
        name: "Sidebar",
        data: function () {
            return {
                member: {},
                avatarStatus: null,
                uploadFieldName: 'mem_photo',
                avatarUrl: null,
                member_group_name: '',
                current: 'dashboard',
            }
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
        mounted() {
            this.member_group_name = window.member_group_name;
            this.member = window.member;
        },
        computed: {
            isAvatarSaving() {
                return this.avatarStatus === AVATAR_SAVING;
            }
        },
    }
</script>

<style lang="scss" scoped>
    p {
        opacity: 0.7;
        font-size: 12px;
    }
    .avatar {
        img {
            width: 75px;
            border-radius: 75px;
            box-shadow: 0 0 32px hsla(0,0%,100%,.5);
        }
    }

    .avatar-file {
        position: absolute;
        width: 20px;
        height: 20px;
        right: 0;
        background-color: #4890ff;
        border-radius: 50%;
        line-height: 20px;
        text-align: center;
        font-size: 12px;

        input[type=file] {
            display: none;
        }
    }
</style>