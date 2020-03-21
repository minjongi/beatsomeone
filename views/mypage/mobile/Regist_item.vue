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
                <p class="help-block">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요</p>
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

                <input type="file" name="cover_image" id="cover_image" ref="cover_image" @change="onConverFileSelected"  />
            </div>
        </li>
        <li>
            <span>음원파일</span>
            <div class="form-text text-primary group">
                <div v-if="item.cde_originname">
                    <a>{{ item.cde_originname }}</a>
                </div>
                <input type="file" name="music_file_1" id="music_file_1" />
            </div>
        </li>
<!--        <li>-->
<!--            <span>데이터 </span>-->
<!--            <pre>{{ item }}</pre>-->
<!--        </li>-->
        <li>
            <span></span>
            <button type="submit" class="btn btn-success" @click="doSubmit">등록</button>
        </li>
    </ol>

</template>


<script>

    import axios from 'axios';

    export default {

        data: function() {
            return {
                cit_id: null,
                item : {


                },

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
                }

            },
        },
        methods: {
            // 커버 선택시
            onConverFileSelected() {
                log.debug({
                    'onConverFileSelected': this.$refs.cover_image.files[0],
                })
                this.item.coverImage = this.$refs.cover_image.files[0];
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
                 log.debug(k,v);
                  f.append(k,v);
              });

              axios.post('/beatsomeoneApi/merge_item',f,{
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
              }).then(r=> {
                  this.item = {};
                  alert('등록 되었습니다');
              }, e=> {
                  log.debug('ERROR',e);
              })

            },
        }
    }

</script>

<style scoped="scoped">

</style>
