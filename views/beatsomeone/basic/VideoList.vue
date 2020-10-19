<template>
    <div>
        <div class="top-section">
            <div class="container">
                <div class="row">
                    <div class="col-8" v-if="posts.length > 0">
                        <div class="gallery-box">
                            <img :src="posts[0].thumb_url" class="post-thumbnail" @click="$router.push('/' + posts[0].post_id)" />
                            <router-link :to="posts[0].post_id">
                                <h5 class="post-title-h4" style="text-overflow: ellipsis;overflow: hidden;">{{ posts[0].post_title }}</h5>
                                <div v-html="posts[0].post_content" class="post-content">
                                </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="gallery-box" v-if="posts.length > 1">
                            <img :src="posts[1].thumb_url" class="post-thumbnail" @click="$router.push('/' + posts[1].post_id)" />
                            <router-link :to="posts[1].post_id">
                                <h5 class="post-title">{{ posts[1].post_title }}</h5>
                                <div v-html="posts[1].post_content" class="post-content">
                                </div>
                            </router-link>
                        </div>
                        <div class="gallery-box" v-if="posts.length > 2">
                            <img :src="posts[2].thumb_url" class="post-thumbnail" @click="$router.push('/' + posts[2].post_id)" />
                            <router-link :to="posts[2].post_id">
                                <h5 class="post-title">{{ posts[2].post_title }}</h5>
                                <div v-html="posts[2].post_content" class="post-content">
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-section">
            <div class="container" style="padding-top: 0;">
                <div class="row" v-if="posts.length > 3">
                    <div class="col-4" v-for="(post, index) in posts" v-bind:key="post.post_id" v-if="index > 2">
                        <div class="gallery-box" @click="$router.push('/' + post.post_id)">
                            <img :src="post.thumb_url" class="post-thumbnail" />
                            <router-link :to="post.post_id">
                                <h5 class="post-title">{{ post.post_title }}</h5>
                                <div v-html="post.post_content" class="post-content">
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'VideoList',
        data: function () {
            return {
                isLogin: false,
                posts: []
            }
        },
        mounted() {
            axios.get('/board/ajax/video')
                .then(res => res.data)
                .then(data => {
                    this.posts = data.data.list;
                })
                .catch(error => {
                    console.error(error);
                })
        }
    }
</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';

    .footer {
        margin-top: 0;
    }

    .top-section {
        padding-top: 120px;
        background-image: linear-gradient(rgba(0, 0, 0, 0.5) 75%, rgb(0,0,0)), url("/assets/images/bg-video.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-bottom: 60px;
    }

    .container {
        max-width: 1100px;
        min-width: 880px;
        margin-left: auto;
        margin-right: auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -10px;
        margin-right: -10px;
    }

    .col-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
        padding-left: 10px;
        padding-right: 10px;
    }

    .col-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding-left: 10px;
        padding-right: 10px;
    }

    .gallery-box {
        margin-bottom: 30px;

        .post-thumbnail {
            display: block;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .post-title {
            font-size: 1.2rem;
            margin-bottom: 7px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-title-h4 {
            font-size: 1.5rem;
            margin-bottom: 7px;
        }

        .post-content {
            opacity: 0.7;
            word-break: keep-all;

            p {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        a {
            color: #fff;
        }
    }
</style>