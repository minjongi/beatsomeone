<template>
    <div>
        <div class="row">
            <div class="row" style="margin-bottom:30px;">
                <div class="title-content">
                    <div class="title">
                        <div>{{$t('support1')}}</div>
                        <button class="btn btn--gray" v-on:click="goPage('inquiry')">{{$t('back')}}</button>
                    </div>
                </div>
            </div>

            <div class="box" style="padding-bottom:50px;">
                <div class="row">
                    <div class="type"><span>{{ $t('title') }}</span></div>
                    <div class="data">
                        <div class="input_wrap col">
                            <input v-model="post_title" class="inputbox" type="text"
                                   placeholder="Please enter your title about problem..."/>
                        </div>
                    </div>
                </div>

                <!--                <div class="row" v-show="group_title == 'SELLER'">-->
                <!--                    <div class="type"><span>Writer</span></div>-->
                <!--                    <div class="data">-->
                <!--                        <div class="group_title" :class="group_title">{{$t(group_title)}}</div>-->
                <!--                        <div class="seller_class" :class="seller_class">{{seller_class}}</div>-->
                <!--                        <div class="username">KKOMA</div>-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="row">
                    <div class="type"><span>{{ $t('content') }}</span></div>
                    <div class="data">
                        <textarea v-model="post_content" class="firstname" rows="10"
                                  placeholder="Please decribe your problem detaily..."></textarea>
                    </div>
                </div>

                <div class="row" v-show="board_info.use_upload_file === '1'">
                    <div class="type"><span>Attachment</span></div>
                    <div class="data">
                        <div>
                            <div class="flie_list">
                                <div v-show="attached_files.length === 0">
                                    <span>No attached file.</span>
                                </div>
                                <div v-for="file in attached_files" :key="file.name">
                                    <img src="/assets/images/icon/file.png"/>
                                    <span>{{ file.name }}</span>
                                </div>
                            </div>
                            <div class="caution">
                                <div>
                                    <img class="caution" src="/assets/images/icon/caution.png"/>
                                    <img class="warning" src="/assets/images/icon/warning.png"/>
                                </div>
                                <span>
                                    You can upload only jpg, png, gif, doc, and pdf files within {{ board_info.upload_file_max_size }}MB
                                </span>
                            </div>
                        </div>
                        <label class="btn btn--blue" for="attachbtn">
                            <input type="file" id="attachbtn" style="display:none;" multiple v-on:change="changeFiles">
                            <div>Attach</div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="btnbox col" style="width:50%; margin:30px auto 100px;">
                <button class="btn btn--gray" @click="goPage('inquiry')">Cancel</button>
                <button type="submit" class="btn btn--submit" v-on:click="submitInquiry">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        components: {},
        data: function () {
            return {
                isLogin: false,
                group_title: 'SELLER',
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
            };
        },
        mounted() {
            this.post_id = this.$route.params.post_id;
            if (this.post_id) {
                axios.get(`/post/${this.post_id}`)
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

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

    .data .firstname {
        height: 360px;
    }
</style>