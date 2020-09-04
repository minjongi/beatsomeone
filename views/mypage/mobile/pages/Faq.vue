<template>
    <div>
        <ul class="nav nav-pills nav-fill align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="javascript:;" @click="$router.push('/inquiry')">{{$t('supportCase')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="javascript:;" @click="$router.push('/faq')">FAQ</a>
            </li>
        </ul>
        <div class="my-4 container">
            <div class="input-group">
                <input type="text" class="form-control" v-model="skeyword" placeholder="enter your word...">
                <div class="input-group-append">
                    <button class="btn btn-secondary" @click="searchItems"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="accordion" id="faqs">
            <div class="card" v-for="(item, index) in list" :key="index">
                <div class="card-header font-weight-bold">
                    {{ item.faq_title }}
                    <button class="float-right btn btn-sm" data-toggle="collapse" v-bind:data-target="'#faq' + index">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="collapse" :id="'faq' + index" data-parent="#faqs">
                    <div class="card-body text-secondary" v-html="item.faq_content">
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data: function () {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                popup_filter: 0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
                total_rows: 0,
                list: [],
                skeyword: '',
            };
        },
        mounted() {
            axios.get('/faq/faq')
                .then(res => res.data)
                .then(data => {
                    this.total_rows = +data.total_rows;
                    this.list = data.list;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        created() {
        },
        methods: {
            searchItems: function () {
                if (this.skeyword.length < 2) {
                    alert('2글자 이상으로 검색해 주세요');
                    return;
                }
                axios.get(`/faq/faq?skeyword=${this.skeyword}`)
                    .then(res => res.data)
                    .then(data => {
                        console.log(data);
                        this.total_rows = +data.total_rows;
                        this.list = data.list;
                    })
                    .catch(error => {
                        console.log(error);
                    })
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

    .list-group-item {
        background-color: #1b1b1e;
    }

    .card {
        background-color: #1b1b1e;

        .card-header {
            .btn {
                color: #606062;
            }
        }
    }
</style>