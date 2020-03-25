<template>
    <div>
        <h5>음원 검색</h5>
        <div>
            <table class="table">
                <tbody>
                    <tr @keyup.enter="getList">
                        <th>제목</th>
                        <td>
                            <input type="text" v-model="search.title" />
                        </td>
                        <th>뮤지션</th>
                        <td>
                            <input type="text" v-model="search.musician" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" @click="getList()">검색</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table class="table">
            <colgroup>
                <col style="width: 120px;">
                <col>
                <col style="width: 30%;">
                <col style="width: 40px;">
            </colgroup>
            <thead>
            <tr>
                <th>
                </th>
                <th>음원 제목</th>
                <th>뮤지션</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="o in page.listPage" :key="o.cir_id">
                <td class="pointer"><img :src="`/uploads/cmallitem/${ o.cit_file_1 }`" style="width: 80px;"></td>
                <td class="pointer">{{ o.cit_name }}</td>
                <td class="pointer">{{ o.musician }}</td>
                <td>
                    <button type="button" class="btn btn-primary" @click="addRelation(o)">추가</button>
                </td>
            </tr>

            <tr v-if="page.listPage && page.listPage.length == 0">
                <td colspan="5" class="nopost">검색된 음원이 없습니다</td>
            </tr>
            </tbody>
        </table>
        <pagenation :total="page.total" :current="page.current" :per-page="page.perPage" :display="page.display" @move="doMove"/>
    </div>

</template>


<script>

    import pagenation from './Pagenation';

    export default {
        props: ['cit_id'],
        components: {
            pagenation
        },
        data: function() {
            return {
                page: {
                    display: 10,
                    perPage : 2,
                    total : 0,
                    current : 1,
                    list: null,
                    listPage: null,
                },
                search: {},
            };
        },
        mounted() {

        },
        methods: {
            // 연관음원 추가
            addRelation(o) {
                if(!o.cit_id) return;
                Http.post(`/beatsomeoneApi/add_relation`,{cit_id : this.cit_id, cit_id_r : o.cit_id }).then( r => {
                    this.$emit('update');
                    this.getList();
                });
            },
            // 음원 조회
            getList() {
                const p = {
                    cit_id : this.cit_id,
                    title : this.search.title,
                    musician: this.search.musician
                };
                Http.post(`/beatsomeoneApi/search_item_list_for_addRelation`,p).then( r => {
                    this.page.list = r;
                    this.page.total = r.length;
                    this.doMove(1);
                });
            },
            doMove(i) {
                // log.debug({
                //     doMovePagenation: i,
                //     this: this,
                // })
                this.page.current = i;
                const start = (this.page.current-1) * this.page.perPage,
                    end = start + this.page.perPage ;
                this.page.listPage = this.page.list.slice(start, end);
                // log.debug({
                //     start  : start, end : end, page  : this.page,
                // })
            },

        }
    }

</script>

<style scoped="scoped">
    nav > ul > li {
        display: inline-block !important;
        margin-right: 5px !important;
    }
</style>
