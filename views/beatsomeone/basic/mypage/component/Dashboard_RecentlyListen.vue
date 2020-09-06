<template>
    <div class="title-content">
        <div class="title">
            <div>{{$t('recentlyListen')}}</div>
        </div>

        <h3 v-if="data.length === 0">
            {{ $t('dashboard_RecentlyListen_notexists') }}
        </h3>

        <div class="row">
            <div class="col-2 trending__slide-item" v-for="(citem,index) in data" :key="index" @click="goItemPage(citem.cit_key)">
                <div class="img-wrapper">
                    <img :src="'/uploads/cmallitem/' + citem.cit_file_1" :alt="citem.cit_name"/>
                </div>
                <h6 class="albumItem__title">{{ citem.cit_name }}</h6>
                <p class="albumItem__singer">{{ citem.mem_firstname + ' ' + citem.mem_lastname }}</p>
            </div>
        </div>
    </div>
</template>


<script>

    import {EventBus} from '*/src/eventbus';

    export default {
        props: ['data'],
        data: function () {
            return {}
        },
        created() {

        },
        mounted() {

        },
        methods: {
            goItemPage(cit_key) {
                window.location.href='/beatsomeone/detail/' + cit_key;
            }
        },
    }

</script>

<style scoped="scoped" lang="scss">
    .trending__slide-item:hover {
        cursor: pointer;
    }

    .img-wrapper {
        position: relative;
        width: 150px;
        padding-top: 150px;
        margin-bottom: 10px;

        &:hover {
            &:after {
                opacity: 1;
            }

            img {
                box-shadow: 0 0 20px 0 #4c4c4c;
            }
        }

        &:after {
            content: "";
            position: absolute;
            z-index: 2;
            width: 50px;
            height: 50px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            background: url("/assets/images/icon/hover_play.png") no-repeat 50%;
            background-size: 50px 50px;
            transition: all .5s;
        }

        img {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 5px;
            box-shadow: 0 0 10px 0 #4c4c4c;
        }
    }
</style>
