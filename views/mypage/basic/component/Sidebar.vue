<template>
    <div>
        <div class="text-center">
            <div class="avatar mb-3">
                <label for="avatar_file" class="avatar-file">
                    <i class="fa fa-camera"></i>
                    <input type="file" class="d-none" id="avatar_file" accept="image/*" :name="uploadFieldName" :disabled="isAvatarSaving" v-on:change="avatarChange($event.target.name, $event.target.files)">
                </label>
                <img :src="member.mem_photo ? member.mem_photo : '/assets/images/portait.png'">
            </div>
            <div class="info">
                <div class="badge" :class="member_group_name.includes('buyer') ? 'badge-primary' : 'badge-danger'">
                    {{$t(member_group_name)}}
                </div>
                <h4 class="nickname font-weight-bold">
                    {{ member.mem_nickname }}
                </h4>
                <h5 class="mb-3 font-weight-normal">
                    {{ member.mem_type}}, {{ member.mem_lastname }} {{ member.mem_firstname }}
                </h5>
                <p>
                    <span class="far fa-map-marker-alt mr-1"></span>{{ member.mem_address1 }} <br>
                    <span class="fas fa-store-alt mr-1"></span><a class="text-light" href="#">{{ $t('goToBrandshop') }} ></a>
                </p>
            </div>
        </div>
        <div class="side-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link to="/" class="nav-link">{{$t('dashboard')}}</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/membermodify" class="nav-link">{{$t('manageInformation')}}</router-link>
                </li>
                <li class="nav-item" v-if="member_group_name.includes('seller')">
                    <router-link to="/list_item" class="nav-link">{{$t('productList')}}</router-link>
                </li>
                <li class="nav-item" v-if="member_group_name.includes('seller')">
                    <router-link to="/register_item" class="nav-link">{{$t('registrationOfBeat')}}</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/mybilling" class="nav-link">{{$t('orderHistory')}}</router-link>
                </li>
                <li class="nav-item" v-if="member_group_name.includes('seller')">
                    <router-link to="/saleshistory" class="nav-link">{{$t('salesHistory')}}</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/message" class="nav-link">{{$t('chat')}}</router-link>
                </li>
                <li class="nav-item" v-if="member_group_name.includes('seller')">
                    <router-link to="/seller" class="nav-link">{{$t('settlementHistory')}}</router-link>
                </li>
                <li class="nav-item" v-if="member_group_name === 'buyer'">
                    <a href="/mypage/upgrade" class="nav-link">{{$t('sellerRegister')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="($route.path === '/inquiry' || $route.path === '/faq') ? 'router-link-exact-active' : ''" href="javascript:;" data-toggle="collapse" data-target="#support">{{$t('support1')}}</a>
                    <div class="collapse" :class="($route.path === '/inquiry' || $route.path === '/faq') ? 'show' : ''" id="support">
                        <ul class="nav flex-column pl-5 submenu">
                            <li class="nav-item">
                                <router-link to="/inquiry" class="nav-link">{{$t('supportCase')}}</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/faq" class="nav-link">FAQ</router-link>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
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
    .avatar {
        img {
            width: 160px;
            border-radius: 160px;
            box-shadow: 0 0 32px hsla(0,0%,100%,.5);
        }
    }

    .avatar-file {
        position: absolute;
        width: 30px;
        height: 30px;
        right: 65px;
        top: 125px;
        background-color: #4890ff;
        border-radius: 50%;
        line-height: 30px;
        text-align: center;
        font-size: 15px;

        input[type=file] {
            display: none;
        }
    }

    .info {
        p, h5 {
            opacity: 0.3;
        }

        p {
            font-size: 13px;
        }
    }

    .side-menu {
        margin-top: 50px;

        .nav-item {
            font-size: 16px;
            font-weight: 600;

            > .nav-link {
                color: #b2b2b2;

                &.router-link-exact-active {
                    color: #ffda2a;
                }
            }
        }

        .submenu {
            list-style: disc;

            .nav-item {
                font-size: 13px;

                > .nav-link {
                    padding-left: 0;
                }
            }
        }
    }
</style>