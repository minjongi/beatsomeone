<template>
    <div>
        <h5>FAQ</h5>
        <div class="mb-4">
            <div class="form-inline justify-content-center">
                <div class="input-group">
                    <input type="text" class="form-control" v-model="skeyword" placeholder="enter your word...">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" @click="searchItems"><i class="fa fa-search"></i></button>
                    </div>
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
</style>