<template>
    <div>
        <div class="row">
            <div class="row" style="margin-bottom:30px;">
                <div class="title-content">
                    <div class="title">
                        <div>{{$t('support1')}}</div>
                        <button class="btn btn--gray" @click="goPage('inquiry')">{{$t('back')}}</button>
                    </div>
                </div>
            </div>

            <div class="box" style="padding-bottom:50px;">
                <div class="row">
                    <div class="type"><span>{{ $t('lang83') }}</span></div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input class="inputbox" type="text" v-model="post_title"
                                   :placeholder="$t('lang91')"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="type"><span>{{ $t('lang84') }}</span></div>
                    <div class="data">
                        <div class="group_title" :class="group_title">{{$t(group_title)}}</div>
                        <div v-if="group_title === 'SELLER'" class="seller_class" :class="seller_class">{{$t(seller_class)}}</div>
                        <div class="username">{{ member.mem_nickname }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="type"><span>{{ $t('lang85') }}</span></div>
                    <div class="data">
                        <textarea class="firstname" v-model="post_content" type="text"
                                  :placeholder="$t('lang92')" style="height:360px"/>
                    </div>
                </div>

                <div class="row">
                    <div class="type"><span>{{ $t('lang86') }}</span></div>
                    <div class="data">
                        <div>
                            <div v-show="attached_files.length === 0">
                                <span>{{ $t('lang87') }}</span>
                            </div>
                            <div v-for="file in attached_files" :key="file.name">
                                <img src="/assets/images/icon/file.png"/>
                                <span>{{ file.name }}</span>
                            </div>
                            <div class="caution">
                                <div>
                                    <img class="caution" src="/assets/images/icon/caution.png"/>
                                    <img class="warning" src="/assets/images/icon/warning.png"/>
                                </div>
                                <span>
                                    {{ $t('lang113') }}
                                </span>
                            </div>
                        </div>
                        <label class="btn btn--blue" for="attachbtn">
                            <input type="file" multiple id="attachbtn" style="display:none;" @change="changeFiles">
                            <div>{{ $t('lang88') }}</div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                <button class="btn btn--gray" @click="goPage('inquiry')">{{ $t('lang89') }}</button>
                <button type="submit" class="btn btn--submit" @click="submitInquiry">{{ $t('lang90') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from "jquery";
    import axios from 'axios';

    export default {
        components: {},
        data: function () {
            return {
                isLogin: false,
                member_group_name: '',
                product_status: 'PENDING',
                popup_filter: 0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
                attached_files: [],
                post_title: '',
                post_content: '',
                board_info: {},
                post_id: null,
                member: {},
                is_submit: false,
            };
        },
        mounted() {
            this.post_id = this.$route.params.post_id;
            if (this.post_id) {
                axios.get(`/post/ajax/${this.post_id}`)
                    .then(res => res.data)
                    .then(data => {
                        this.post_title = data.post.post_title;
                        if (data.file) {
                            this.attached_files = data.file;
                            this.attached_files.forEach(attached_file => {
                                attached_file.name = attached_file.pfi_originname
                            })
                        }
                        this.post_content = data.post.post_content;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
            this.member_group_name = window.member_group_name;
            this.member = window.member;
        },
        computed: {
            group_title() {
                if (this.member_group_name === 'buyer') {
                    return 'CUSTOMER';
                } else if (this.member_group_name.includes('seller')) {
                    return 'SELLER';
                } else {
                    return 'CUSTOMER';
                }
            },
            seller_class() {
                if (this.member_group_name.includes('seller')) {
                    let names = this.member_group_name.split('_')
                    console.log(names);
                    return names[1];
                } else {
                    return ''
                }
            }
        },
        created() {
            axios.get('/board_info/support')
                .then(res => res.data)
                .then(data => {
                    this.board_info = data;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods: {
            goInquiryview() {
                this.$router.push({path: '/inquiryview'});
            },
            goInquirymod() {
                this.$router.push({path: '/inquirymod'});
            },
            goPage(page) {
                this.$router.push('/' + page);
            },
            changeFiles(event) {
                if (event.target.files.length > +(this.board_info.upload_file_num)) {
                    alert(`You can only upload a maximum of ${this.board_info.upload_file_num} files`);
                    return false;
                }
                this.attached_files = event.target.files;
            },
            submitInquiry() {
                const formData = new FormData();
                if (!this.post_title || !this.post_content) {
                    return false;
                }
                formData.append('post_title', this.post_title);
                formData.append('post_content', this.post_content);
                for( let i = 0; i < this.attached_files.length; i++ ){
                    let file = this.attached_files[i];
                    formData.append('post_file[' + i + ']', file);
                }
                if (this.is_submit === false) {
                    this.is_submit = true;
                    if (this.post_id) {
                        formData.append('post_id', this.post_id);
                        axios.post(`/modify/${this.post_id}`, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(res => res.data)
                            .then(data => {
                                this.is_submit = false;
                                this.$router.push({path: '/inquiry'})
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    } else {
                        axios.post('/write/support', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                            .then(res => res.data)
                            .then(data => {
                                this.is_submit = false;
                                this.$router.push({path: '/inquiry'})
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                }
            }
        }
    }
</script>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>