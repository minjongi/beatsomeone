<template>
    <ol class="member_modify">

        <li>
            <span>음원 제목</span>
            <div class="form-text text-primary group"><input type="text" id="cit_name" name="cit_name" class="form-control input" minlength="3" v-model="item.cit_name" />
                <p class="help-block">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요</p>
            </div>
        </li>
        <li>
            <span>Musician</span>
            <div class="form-text text-primary group"><input type="text" id="musician" name="musician" class="form-control input" minlength="3" v-model="item.musician" />
                <p class="help-block">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요</p>
            </div>
        </li>
        <li>
            <span>설명</span>
            <div class="form-text text-primary group"><textarea rows="5" type="text" id="cit_content" name="cit_content" class="form-control input" minlength="3" v-model="item.cit_content" />
                <p class="help-block">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요</p>
            </div>
        </li>
        <li>
            <span>가격</span>
            <div class="form-text text-primary group"><input type="number" id="cit_price" name="cit_price" class="form-control input" minlength="3" v-model="item.cit_price" />
                <p class="help-block">금액을 입력 하세요</p>
            </div>
        </li>
        <li>
            <span>Genre </span>
            <div class="form-text text-primary group"><input type="text" id="genre" name="genre" class="form-control input" minlength="3" v-model="item.genre" />
                <p class="help-block">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요</p>
            </div>
        </li>
        <li>
            <span>Bpm</span>
            <div class="form-text text-primary group"><input type="number" id="bpm" name="bpm" class="form-control input" minlength="3" v-model="item.bpm" />
                <p class="help-block">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요</p>
            </div>
        </li>
        <li>
            <span>커버 이미지</span>
            <div class="form-text text-primary group">
                <div v-if="item.cit_file_1">

                    <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt="커버 이미지" title="커버 이미지" />
                </div>

                <input type="file" name="cit_file_1" id="cit_file_1" ref="cit_file_1" @change="onConverFileSelected"  />
            </div>
        </li>
        <li>
            <span>음원파일</span>
            <div class="form-text text-primary group">
                <div v-if="item.cde_originname">
                    <a>{{ item.cde_originname }}</a>
                </div>
                <input type="file" name="music_file_1" id="music_file_1" ref="music_file_1" @change="onMusicFileSelected"/>
            </div>
        </li>
        <li>
            <span></span>
            <button type="submit" class="btn btn-success" style="width: 400px;" @click="doSubmit">음원 {{ cit_id ? '수정' : '등록'}}하기</button>
        </li>

        <li v-if="cit_id">
            <span>연관음원</span>
            <div class="form-text text-primary group">
                <add-relation :cit_id="cit_id" @update="updatedRelation"></add-relation>
                <table class="table">
                    <thead>
                    <tr>
                        <th>

                        </th>
                        <th>음원 제목</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="o in listRelation" :key="o.cir_id">
                        <td class="pointer"><img :src="`/uploads/cmallitem/${ o.img }`" style="width: 80px;"></td>
                        <td class="pointer">{{ o.cit_name }}</td>
                        <td>
                            <button type="button" class="btn btn-danger" @click="removeRelation(o)">삭제</button>
                        </td>
                    </tr>

                    <tr v-if="listRelation && listRelation.length == 0">
                        <td colspan="5" class="nopost">등록된 연관음원이 없습니다</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </li>
    </ol>

</template>


<script>

    import axios from 'axios';
    import addRelation from './Regist_item_addRelation';

    export default {
        components: {
            addRelation : addRelation,
        },
        data: function() {
            return {
                cit_id: null,
                item : {


                },
                listRelation: null,
                cit_id_r : null,
            };
        },
        mounted() {

        },
        watch: {
            cit_id: function (n) {
                log.debug( {
                        'cit_id': n,
                    }
                )
                if(n) {
                    this.getItem();
                    this.getRelationList();
                }

            },
        },
        methods: {
            updatedRelation() {
                this.getRelationList();
            },
            removeRelation(item) {
                Http.post(`/beatsomeoneApi/remove_relation`,{cir_id : item.cir_id}).then( r => {
                    this.getRelationList();
                });
            },

            // 연관음원 조회
            getRelationList() {
                Http.post(`/beatsomeoneApi/list_relation`,{cit_id : this.cit_id}).then( r => {
                    this.listRelation = r;
                });
            },
            // 커버 선택시
            onConverFileSelected() {
                log.debug({
                    'onConverFileSelected': this.$refs.cit_file_1.files[0],
                })
                this.item.cover_image = this.$refs.cit_file_1.files[0];
                log.debug({
                    'this.item.cit_file_1':this.item.cit_file_1,
                })
            },
            // 음악파일 선택시
            onMusicFileSelected() {
                log.debug({
                    'onMusicFileSelected': this.$refs.music_file_1.files[0],
                })
                this.item.music_file_1 = this.$refs.music_file_1.files[0];
                log.debug({
                    'this.item.music_file_1':this.item.music_file_1,
                })
            },
            // 데이터 로딩
            getItem() {
                Http.get(`/beatsomeoneApi/get_item/${this.cit_id}`).then( r => {
                    this.item = r.data;
                });
            },
            // 저장
            doSubmit() {
                const f = new FormData();

                _.forEach(this.item, (v,k)=> {
                    f.append(k,v);
                });

                if(this.cit_id){
                    f.append('cit_id',this.cit_id);
                }
                axios.post('/beatsomeoneApi/merge_item',f,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(r=> {
                    log.debug(
                        {
                            'MERGE SUCCESS':r.data,
                        }
                    )
                    alert(`${ this.cit_id ? '수정' : '등록'} 되었습니다`);
                    window.location.href = `/mypage/regist_item/${ r.data }`

                }, e=> {
                    alert(`${ this.cit_id ? '수정' : '등록'} 실패 하였습니다. 관리자에게 연락 주시기 바랍니다.`);
                    log.debug('ERROR',e);
                })

            },
        }
    }


</script>

<style scoped="scoped">

</style>
