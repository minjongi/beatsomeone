<template>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>음원 제목</th>
            <th>Musician</th>
            <th>가격</th>
            <th>Genre</th>
            <th>Bpm</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="o in list" :key="o.cit_key">
                <td class="pointer" @click="moveDetail(o)"><img :src="`/uploads/cache/thumb-noimage_60x60.gif`"></td>
                <td class="pointer" @click="moveDetail(o)">{{ o.cit_name }}</td>
                <td>{{ o.musician }}</td>
                <td>{{ o.cde_price }}</td>
                <td>{{ o.genre }}</td>
                <td>{{ o.bpm }}</td>
                <td>
                    <button type="button" class="btn btn-success" @click="doEdit(o)">수정</button>
                </td>
            </tr>

            <tr v-if="list && list.length == 0">
                <td colspan="5" class="nopost">등록된 음반이 없습니다</td>
            </tr>
        </tbody>
    </table>

</template>


<script>


    export default {
        data: function() {
            return {
                list: null,
            };
        },
        mounted() {
            this.getList();
        },
        methods: {
            getList() {
                Http.get(`/beatsomeoneApi/get_user_regist_item_list`).then(r=> {
                    this.list = r.data;
                });
            },
            doEdit(item) {
                window.location.href = `/mypage/regist_item/${item.cit_id}`;
            },
            moveDetail(item) {
                window.location.href = `/beatsomeone/detail/${item.cit_key}`;
            },
        }
    }

</script>

<style scoped="scoped">
    .pointer {
        cursor: pointer !important;
    }

</style>
