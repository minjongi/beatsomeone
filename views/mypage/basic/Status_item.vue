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

        </tr>
        </thead>
        <tbody>
            <tr v-for="o in list" :key="o.cit_key">
                <td class="pointer" @click="moveDetail(o)"><img style="width: 60px;" :src="o.cit_file_1 ? '/uploads/cmallitem/' + o.cit_file_1 : `/uploads/cache/thumb-noimage_60x60.gif`"></td>
                <td class="pointer" @click="moveDetail(o)">{{ o.cit_name }}</td>
                <td>{{ o.musician }}</td>
                <td>{{ o.cde_price }}</td>
                <td>{{ o.genre }}</td>
                <td>{{ o.bpm }}</td>

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
                Http.get(`/beatsomeoneApi/get_status_item_list`).then(r=> {
                    this.list = r.data;
                });
            },

            moveDetail(item) {
                window.location.href = this.helper.langUrl(this.$i18n.locale, `/detail/${item.cit_key}`);
            },
        }
    }

</script>

<style scoped="scoped">
    .pointer {
        cursor: pointer !important;
    }

</style>
