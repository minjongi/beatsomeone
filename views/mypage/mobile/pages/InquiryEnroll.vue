<template>
    <div>
        <ul class="nav nav-pills nav-fill align-items-center mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:;" @click="$router.push('/inquiry')">{{$t('supportCase')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:;" @click="$router.push('/faq')">FAQ</a>
            </li>
        </ul>
        <div class="container-fluid">
            <form id="write-form">
                <div class="form-group">
                    <label>{{ $t('title') }}</label>
                    <input v-model="post_title" class="form-control" :class="post_title_invalid ? 'is-invalid' : ''" type="text"
                           placeholder="Please enter your title about problem..."/>
                </div>
                <div class="form-group" v-show="member_group_name.includes('seller')">
                    <label>Writer</label>
                    <div>
                        <span class="mr-3 badge" :class="{'badge-success': member_group_name === 'seller_free', 'badge-primary': member_group_name === 'seller_platinum', 'badge-warning': member_group_name === 'seller_master'}">{{ $t(member_group_name) }}</span>
                        <span class="username">{{ member.mem_firstname + ' ' + member.mem_lastname }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ $t('content') }}</label>
                    <textarea v-model="post_content" class="form-control" :class="post_content_invalid ? 'is-invalid' : ''" rows="10" placeholder="Please decribe your problem detaily..."></textarea>
                </div>
                <div class="form-group" v-show="board_info.use_upload_file === '1'">
                    <label>Attachment</label>
                    <div>
                        <div class="d-flex">
                            <div>
                                <div v-show="attached_files.length === 0">
                                    <span>No attached file.</span>
                                </div>
                                <div v-for="file in attached_files" :key="file.name">
                                    <img src="/assets/images/icon/file.png"/>
                                    <span>{{ file.name }}</span>
                                </div>
                                <small class="text-secondary">
                                    You can upload only jpg, png, gif, doc, and pdf files within {{ board_info.upload_file_max_size }}MB
                                </small>
                            </div>
                            <div class="ml-auto">
                                <label class="btn btn-primary">
                                    <input type="file" style="display:none;" multiple v-on:change="changeFiles">
                                    Attach
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-center mb-4">
                <button class="btn btn-lg btn-secondary px-5 mr-4" form="write-form" type="reset">Cancel</button>
                <button class="btn btn-lg btn-primary px-5" type="button" v-on:click="submitInquiry">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'InquiryEnroll',
        components: {},
        data: function () {
            return {
                isLogin: false,
                member_group_name: '',
                seller_class: 'MARKET PLACE',
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
                post_title_invalid: false,
                post_content_invalid: false,
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
                this.current = page;

                let p = null;
                switch (page) {
                    case 'dashboard':
                    case '':
                        p = '/'
                        break
                    default:
                        p = '/' + page
                        break
                }
                this.$router.push({path: p})
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
                    !this.post_title ? this.post_title_invalid = true : this.post_title_invalid = false;
                    !this.post_content ? this.post_content_invalid = true : this.post_content_invalid = false;
                    return false;
                }
                formData.append('post_title', this.post_title);
                formData.append('post_content', this.post_content);
                for( let i = 0; i < this.attached_files.length; i++ ){
                    let file = this.attached_files[i];
                    formData.append('post_file[' + i + ']', file);
                }
                if (this.post_id) {
                    formData.append('post_id', this.post_id);
                    axios.post(`/modify/${this.post_id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then(res => res.data)
                        .then(data => {
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
                            this.$router.push({path: '/inquiry'})
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            }
        }
    }
</script>

<style scoped="scoped" lang="scss">
    .nav {
        background-color: #141418;
        border: solid 1px #333640;
    }

    .nav-pills .nav-link {
        color: #b8b8b9;
        font-weight: 600;
        padding: 1rem;

        &.active {
            background-color: unset;
            color: #ffda2a;
        }
    }
</style>