<template>
    <ol class="member_modify">

        <li>
            <h4><span>General Infomation</span></h4>
        </li>
        <li v-if="item.url">
            <span>URL OF YOUR TRACK</span>
            <div class="form-text text-primary group">
                {{ item.url }}
            </div>
        </li>
        <li>
            <span>TITLE</span>
            <div class="form-text text-primary group">
                <input type="text" id="cit_name" name="cit_name" class="form-control input" minlength="3" v-model="item.cit_name" />
            </div>
        </li>
        <li>
            <span>TAGS</span>
            <div class="form-text text-primary group">
                <input type="text" id="hashTag" name="hashTag" class="form-control input" v-model="item.hashTag" />
            </div>
        </li>
        <li>
            <span>TRACK TYPE</span>
            <div class="form-text text-primary group">
                <select type="text" id="trackType" name="trackType" class="form-control input" v-model="item.trackType">
                    <option v-for="(o,i) in listTrackType" :key="i">{{ o }}</option>
                </select>
            </div>
        </li>
        <li>
            <span>RELEASE DATE</span>
            <div class="form-text text-primary group">
                <input type="date" id="releaseDate" name="releaseDate" class="form-control input" v-model="item.releaseDate" />
                <input type="time" id="releaseTime" name="releaseTime" class="form-control input" v-model="item.releaseTime" />
            </div>
        </li>
        <li>
            <span>{{$t('lang24')}} (.MP3 or .WAV) 첨부</span>
            <div class="form-text text-primary group">
                <div v-if="item.cde_originname">
                    <a>{{ item.cde_originname }}</a>
                </div>
                <input type="file" name="music_file_1" id="music_file_1" ref="music_file_1" @change="onMusicFileSelected('music_file_1')"/>
            </div>
        </li>
        <li>
            <span>Track Stems (.ZIP or .RAR) 첨부</span>
            <div class="form-text text-primary group">
                <div v-if="item.cde_originname_2">
                    <a>{{ item.cde_originname_2 }}</a>
                </div>
                <input type="file" name="music_file_2" id="music_file_2" ref="music_file_2" @change="onMusicFileSelected('music_file_2')"/>
            </div>
        </li>
        <li>
            <span>OR Link URL (Dropbox 등) | Password</span>
            <div class="form-text text-primary group">
                <input type="text" id="linkURL" name="linkURL" class="form-control input" v-model="item.linkURL" />
                <input type="text" id="linkURLPassword" name="linkURLPassword" class="form-control input" v-model="item.linkURLPassword" />
            </div>
        </li>
        <li>
            <span>Tagged Audio (.MP3 or .WAV) 첨부</span>
            <div class="form-text text-primary group">
                <div v-if="item.cde_originname_3">
                    <a>{{ item.cde_originname_3 }}</a>
                </div>
                <input type="file" name="music_file_3" id="music_file_3" ref="music_file_3" @change="onMusicFileSelected('music_file_3')"/>
            </div>
        </li>
        <li>
            <span>Artwork image (.jpg or .png) 첨부</span>
            <div class="form-text text-primary group">
                <div v-if="item.cit_file_1">
                    <img :src="'/uploads/cmallitem/' + item.cit_file_1" alt="Artwork image" title="Artwork image" />
                </div>

                <input type="file" name="cit_file_1" id="cit_file_1" ref="cit_file_1" @change="onConverFileSelected"  />
            </div>
        </li>

        <li>
            <h4><span>Selling Preferences</span></h4>
        </li>

        <li>
            <span>{{$t('lang23')}} ({{$t('lang24')}}) PRICE</span>
            <div class="form-text text-primary group">
            <input type="text" id="licenseLeasePriceKR" name="licenseLeasePriceKR" class="form-control input" v-model="item.licenseLeasePriceKR" />
            <input type="text" id="licenseLeasePriceDL" name="licenseLeasePriceDL" class="form-control input" v-model="item.licenseLeasePriceDL" />
            <input type="text" id="licenseLeasePriceQuantity" name="licenseLeasePriceQuantity" class="form-control input" v-model="item.licenseLeasePriceQuantity" />
            </div>
        </li>
        <li>
            <span>{{$t('unlimitedStemsLicensePrice')}}</span>
            <div class="form-text text-primary group">
            <input type="text" id="licenseStemPriceKR" name="licenseStemPriceKR" class="form-control input" v-model="item.licenseStemPriceKR" />
            <input type="text" id="licenseStemPriceDL" name="licenseStemPriceDL" class="form-control input" v-model="item.licenseStemPriceDL" />
            <input type="text" id="licenseStemPriceQuantity" name="licenseStemPriceQuantity" class="form-control input" v-model="item.licenseStemPriceQuantity" />
            </div>
        </li>

        <li>
            <h4><span>Track Details</span></h4>
        </li>
        <li>
            <span>PRIMARY GENRE</span>
            <div class="form-text text-primary group">
                <select type="text" id="genre" name="genre" class="form-control input" v-model="item.genre">
                    <option v-for="(o,i) in listFilter" :key="i">{{ o }}</option>
                </select>
            </div>
        </li>
        <li>
            <span>SUB GENRE</span>
            <div class="form-text text-primary group">
                <select type="text" id="subgenre" name="subgenre" class="form-control input" v-model="item.subgenre">
                    <option v-for="(o,i) in listFilter" :key="i">{{ o }}</option>
                </select>
            </div>
        </li>
        <li>
            <span>PRIMARY MOOD</span>
            <div class="form-text text-primary group">
                <select type="text" id="moods" name="moods" class="form-control input" v-model="item.moods">
                    <option v-for="(o,i) in listMoods" :key="i">{{ o }}</option>
                </select>
            </div>
        </li>
        <li>
            <span>BPM (Beats per minute)</span>
            <div class="form-text text-primary group"><input type="number" id="bpm" name="bpm" class="form-control input" minlength="3" v-model="item.bpm" />
            </div>
        </li>
        <li>
            <span>DESCRIPTION</span>
            <div class="form-text text-primary group"><textarea rows="5" type="text" id="cit_content" name="cit_content" class="form-control input" minlength="3" v-model="item.cit_content" />
            </div>
        </li>
        <li>
            <span>MUSICIAN</span>
            <div class="form-text text-primary group">
                <input type="text" id="musician" name="musician" class="form-control input" minlength="3" v-model="item.musician" />
            </div>
        </li>
        <li>
            <span>VOICE</span>
            <div class="form-text text-primary group">
                <div class="form-text text-primary group">
                    <select type="text" id="voice" name="voice" class="form-control input" v-model="item.voice">
                        <option value="1">Y</option>
                        <option value="0">N</option>
                    </select>
                </div>
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
                <h5>추가된 목록</h5>
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
    import moment from 'moment';
    import addRelation from './Regist_item_addRelation';

    export default {
        components: {
            addRelation : addRelation,
        },
        data: function() {
            return {
                cit_id: null,
                item : {
                    cit_name                           : '테스트음원'
                    ,hashTag                            : 'test1,test2,test3'
                    ,trackType                          : ''
                    ,releaseDate                        : '2020/04/20'
                    ,releaseTime                        : '12:20'
                    ,linkURL                            : 'http://lionk.url.com/ds231313'
                    ,linkURLPassword                    : 'test11120'
                    ,licenseLeasePriceKR                : '2500'
                    ,licenseLeasePriceDL                : '2.20'
                    ,licenseLeasePriceQuantity          : '20'
                    ,licenseStemPriceKR                 : '350000'
                    ,licenseStemPriceDL                 : '320'
                    ,licenseStemPriceQuantity           : '15'
                    ,genre                              : ''
                    ,subgenre                           : ''
                    ,moods                              : ''
                    ,bpm                                : '120'
                    ,cit_content                        : '테스트 음원 테스트'
                    ,musician                           : '테스트 뮤지션'

                    ,voice : 0
                },
                listRelation: null,
                cit_id_r : null,
                listFilter: ['Hip Hop', 'K-Pop', 'Pop', 'R&B', 'Rock', 'Electronic', 'Reggae', 'Country', 'World'],
                listSubgenres: ['Hip Hop', 'K-Pop', 'Pop', 'R&B', 'Rock', 'Electronic', 'Reggae', 'Country', 'World'],
                listMoods: ['Accomplished', 'Adored', 'Angry', 'Annoyed', 'Anxious,Bouncy', 'Calm,Confident', 'Crazy', 'Crunk', 'Dark', 'Depressed', 'Determined', 'Dirty', 'Disappointed', 'Eccentric', 'Energetic', 'Enraged', 'Epic', 'Evil', 'Flirty', 'Frantic', 'Giddy', 'Gloomy', 'Grateful', 'Happy', 'Hyper', 'Inspiring', 'Intense', 'Lazy', 'Lonely', 'Loved', 'Mellow', 'Peaceful', 'Rebellious', 'Relaxed', 'Sad', 'Scared', 'Silly', 'Soulful'],
                listTrackType: ['Beats', 'Beats with chorus', 'Vocals', 'Song reference', 'Songs'],
            };
        },
        created() {
            this.item.trackType = this.listTrackType[0];
            this.item.moods = this.listMoods[0];
            this.item.genre = this.listFilter[0];
            this.item.subgenre = this.listFilter[0];
            this.item.bpm = 120;
            this.item.releaseDate = moment().format('YYYY-MM-DD');
            this.item.releaseTime = moment().format('HH:mm');
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
            onMusicFileSelected(filename) {
                log.debug({
                    'onMusicFileSelected': this.$refs[filename].files[0],
                })
                this.item[filename] = this.$refs[filename].files[0];
                log.debug({
                    fileName:this.item[filename],
                })
            },
            // 데이터 로딩
            getItem() {
                Http.get(`/beatsomeoneApi/get_item/${this.cit_id}`).then( r => {
                    // 전처리
                    r.data.cde_id_1 = r.data.cde_id;
                    r.data.releaseDate = moment(r.data.cit_start_datetime).format('YYYY-MM-DD');
                    r.data.releaseTime = moment(r.data.cit_start_datetime).format('HH:mm');
                    r.data.url = 'https://beatsomeone.com/detail/' + r.data.cit_key;
                    r.data.licenseLeasePriceKR = r.data.cde_price;
                    r.data.licenseLeasePriceDL = r.data.cde_price_d;
                    r.data.licenseLeasePriceQuantity = r.data.cde_quantity;
                    r.data.licenseStemPriceKR = r.data.cde_price_2;
                    r.data.licenseStemPriceDL = r.data.cde_price_d_2;
                    r.data.licenseStemPriceQuantity = r.data.cde_quantity_2;
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
                    window.location.href = this.helper.langUrl(this.$i18n.locale, `/mypage/regist_item/${ r.data }`)

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
