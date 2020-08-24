<template>
    <div class="container">
        <h4 class="post-title text-center">{{ post.post_title}}</h4>
        <div v-html="post.post_content" class="post-content text-center">
        </div>
        <iframe class="video" v-for="link in links" :key="link.post_id" :src="link.pln_url">
        </iframe>
        <div class="sns-buttons">
            <div class="btn-group mr-4">
                <button class="btn copy_post_url" data-clipboard-text="Welcome"><i class="far fa-share-alt"></i></button>
                <button class="btn" @click="sendSnsVue('facebook')"><i class="fab fa-facebook-f"></i></button>
                <button class="btn" @click="sendSnsVue('twitter')"><i class="fab fa-twitter"></i></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-blue">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "VideoView",
        data: function() {
            return {
                links: [],
                post: {}
            }
        },
        mounted() {
            const post_id = this.$route.params.id;
            axios.get(`/post/${post_id}`)
                .then(res => res.data)
                .then(data => {
                    this.links = data.links;
                    this.links.forEach(link => {
                        if (link.pln_url.includes('youtu.be')) {
                            link.pln_url = link.pln_url.replace('youtu.be', 'www.youtube.com/embed');
                        }
                    });
                    this.post = data.post;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods: {
            sendSnsVue(sns) {
                let currentUrl = window.location.pathname;
                window.sendSns(sns, currentUrl, this.post.post_title);
            }
        }
    }
</script>

<style lang="scss">
    .container {
        max-width: 1100px;
        min-width: 880px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 150px;
    }

    .post-title {
        font-size: 1.5rem;
        margin-bottom: 30px;
    }

    .post-content {
        opacity: 0.7;
        margin-bottom: 50px;
    }

    .video {
        width: 1100px;
        height: 618px;
        margin-bottom: 50px;
    }

    .sns-buttons {
        text-align: center;

        .btn {
            width: 55px;

            &.btn-blue {
                background-color: #4890ff;
            }
        }

        .btn-group {
            position: relative;
            display: inline-flex;
            vertical-align: middle;

            .btn {
                position: relative;
                flex: 1 1 auto;
                color: white;
                border: solid 1px rgba(255,255,255,0.3);
            }

            .btn:not(:first-child) {
                margin-left: -1px;
            }

            .btn:not(:first-child) {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            .btn-group > .btn:not(:last-child) {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
        }
    }

    .mr-4 {
        margin-right: 1.5rem;
    }
</style>