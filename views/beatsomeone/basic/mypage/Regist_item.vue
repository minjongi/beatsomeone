<template>
    <div class="wrapper">
        <Header :is-login="isLogin"/>
        <div class="container registered">
            <div class="registered__title">
                <h1>Track Metadata Editor</h1>
            </div>
            <section class="registered__section">
                <div class="wrap">
                    <h2 class="registered__section-title">General Information</h2>
                    <div class="registered__section-content">
                        <div class="row">
                            <div class="col">
                                <label for="" class="form-item">
                                    <p class="form-title required">TITLE</p>
                                    <div class="input">
                                        <input type="text" placeholder="New TrackAS"/>
                                    </div>
                                    <span class="form-info">
                                        9 out of 60 Maximum characters allowed
                                    </span>
                                </label>

                                <label for="" class="form-item">
                                    <p class="form-title">TAGS (3)</p>
                                    <div class="input">
                                        <input type="text" placeholder="Tags (,)Comma Separated" maxlength="25"
                                               id="tags"/>
                                        <span class="form-unit"><span>0</span>/25</span>
                                    </div>
                                </label>


                                <div class="row">
                                    <div class="col">
                                        <label for="" class="form-item">
                                            <p class="form-title required">TRACK TYPE</p>
                                            <div class="custom-select ">
                                                <button class="selected-option" type="button">
                                                    Beat
                                                </button>
                                                <div class="options">
                                                    <button class="option" data-value="" type="button">
                                                        Beat
                                                    </button>
                                                    <button class="option" data-value="" type="button">
                                                        Beat
                                                    </button>
                                                    <button class="option" data-value="" type="button">
                                                        Beat
                                                    </button>
                                                    <button class="option" data-value="" type="button">Beat</button>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label for="" class="form-item">
                                            <p class="form-title required">RELEASE DATE</p>
                                            <div class="input">
                                                <flat-pickr :config="configdateTimePicker" v-model="datetime" placeholder="Date Time" class="datepicker"/>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div for="" class="form-item">
                                    <p class="form-title required">AUDIOFILES FOR DOWNLOAD</p>
                                    <label for="file1" class="addAudioFile waves-effect ">
                                        <div class="addAudioFile__icon">
                                            <img src="/assets/images/icon/note1.png" alt="">
                                        </div>
                                        <div class="addAudioFile__info">
                                            <input type="file" id="file1" hidden>
                                            <p>Un-Tagged WAV or MP3</p>
                                            <span class="format">.WAV (or.MP3)</span>
                                            <div class="addAudioFile__progress">
                                                <span></span>
                                            </div>
                                        </div>
                                    </label>
                                    <label for="file2" class="addAudioFile waves-effect" style="margin-top: 10px;">
                                        <div class="addAudioFile__icon">
                                            <img src="/assets/images/icon/note2.png" alt="">
                                        </div>
                                        <div class="addAudioFile__info">
                                            <input type="file" id="file2" hidden>
                                            <p>Un-Tagged WAV or MP3</p>
                                            <span class="format">.WAV (or.MP3)</span>
                                            <div class="addAudioFile__progress">
                                                <span></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div for="" class="form-item">
                                    <p class="form-title required">AUDIOFILES FOR DOWNLOAD</p>
                                    <label for="file3" class="addAudioFile waves-effect">
                                        <div class="addAudioFile__icon">
                                            <img src="/assets/images/icon/note3.png" alt="">
                                        </div>
                                        <div class="addAudioFile__info">
                                            <input type="file" id="file3" hidden>
                                            <p>Un-Tagged WAV or MP3</p>
                                            <span class="format">.WAV (or.MP3)</span>
                                            <div class="addAudioFile__progress">
                                                <span></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-item">
                                <p class="form-title">URL OF YOUR TRACK</p>
                                <div class="artwork">
                                    <input type="file" id="artwork" hidden>
                                    <label for="artwork" class="artwork-box">
                                        <img src="/assets/images/artwork.png" alt="" id="artworkImg">
                                    </label>
                                    <div class="artwork__info">
                                        Preferred: 1500x1500px, Minimum: 500x500px<br/>
                                        <br/>
                                        Got Photoshop? Make your own using our free template.<br/>
                                        <a href="" download>
                                            Download PSD Template.
                                        </a>
                                    </div>
                                    <label for="artwork" class="artwork-upload waves-effect">
                                        Upload Artwork
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-item">
                                <p class="form-title">Artwork Dimension</p>
                                <div class="input">
                                    <input type="text" placeholder="" readonly
                                           value="https://www.beatstars.com/beat/4377207"/>
                                    <button class="form-copy" type="button">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="registered__section">
                <div class="wrap">
                    <h2 class="registered__section-title">Selling Preferences</h2>
                    <div class="registered__section-content">
                        <div class="row row--notice">
                            <div class="registered__notice">
                                <h2>NOTICE</h2> If you enter a dollar or won, the exchange rate will be reflected
                                automatically.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div for="" class="form-item">
                                    <div class="form-title">
                                        <label for="c1" class="checkbox">
                                            <input type="checkbox" hidden="" id="c1">
                                            <span></span> BASIC LEASE LICENSE (MP3 or WAV) PRICE
                                        </label>
                                    </div>
                                    <div class="row row--inner">
                                        <span class="col">
                                            <div class="input">
                                                <input type="number" placeholder="22,000"/>
                                            </div>
                                        </span>
                                        <span class="col">
                                            <div class="input">
                                                <input type="number" placeholder="19.00"/>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="row row--inner">
                                        <span class="col">
                                            <p>
                                                Inventory quantity
                                            </p>
                                        </span>
                                        <span class="col">
                                            <div class="input">
                                                <input type="number" placeholder="0"/>
                                            </div>
                                        </span>
                                    </div>

                                    <p class="form-info mt-15">
                                        · Leases licenses for uploaded MP3 or WAV files.<br/>
                                        <br/>
                                        · The terms of lease are limited to 60 days of service /<br/>
                                        no arbitrary editing / Rented members cannot be re-rented to others /<br/>
                                        no other activities not authorized by the platform
                                    </p>

                                </div>
                            </div>
                            <div class="col">
                                <div for="" class="form-item">
                                    <div class="form-title">
                                        <label for="c2" class="checkbox">
                                            <input type="checkbox" hidden="" id="c2">
                                            <span></span> BASIC LEASE LICENSE (MP3 or WAV) PRICE
                                        </label>
                                    </div>
                                    <div class="row row--inner">
                                        <span class="col">
                                            <div class="input">
                                                <input type="number" placeholder="22,000"/>
                                            </div>
                                        </span>
                                        <span class="col">
                                            <div class="input">
                                                <input type="number" placeholder="19.00"/>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="row row--inner">
                                        <span class="col">
                                            <p>
                                                Inventory quantity
                                            </p>
                                        </span>
                                        <span class="col">
                                            <div class="input">
                                                <input type="number" placeholder="1" readonly class="disabled"/>
                                            </div>
                                        </span>
                                    </div>

                                    <p class="form-info mt-15">
                                        · Sell mastering licenses including uploaded MP3 or WAV files and STEMS
                                        configurations.<br/>
                                        <br/>
                                        · UNLIMITED
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="registered__section">
                <div class="wrap">
                    <h2 class="registered__section-title">Track Details</h2>
                    <div class="registered__section-content">
                        <div class="row">
                            <div class="col">
                                <label for="" class="form-item">
                                    <p class="form-title required">PRIMARY GENRE</p>
                                    <div class="custom-select ">
                                        <button class="selected-option" type="button">
                                            All Genre
                                        </button>
                                        <div class="options">
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                All Genre
                                            </button>
                                        </div>
                                    </div>
                                </label>
                                <label for="" class="form-item">
                                    <p class="form-title ">PRIMARY MOOD</p>
                                    <div class="custom-select ">
                                        <button class="selected-option" type="button">
                                            None
                                        </button>
                                        <div class="options">
                                            <button class="option" data-value="" type="button">
                                                None
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                None
                                            </button>
                                        </div>
                                    </div>
                                </label>
                                <label for="" class="form-item">
                                    <p class="form-title required">SUBGENRE</p>
                                    <div class="custom-select ">
                                        <button class="selected-option" type="button">
                                            None
                                        </button>
                                        <div class="options">
                                            <button class="option" data-value="" type="button">
                                                None
                                            </button>
                                            <button class="option" data-value="" type="button">
                                                None
                                            </button>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="col">
                                <label for="" class="form-item">
                                    <p class="form-title ">DESCRIPTION</p>
                                    <div class="input">
                                        <textarea name="" id="" placeholder="Enter Description"></textarea>
                                    </div>
                                </label>

                                <label for="" class="form-item">
                                    <p class="form-title ">BPM(Beats per minute)</p>
                                    <div class="input">
                                        <input type="number" value="0"/>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="registered__section">
                <div class="wrap">
                    <h2 class="registered__section-title">Collaborators</h2>
                    <div class="registered__section-content">
                        <div class="">
                            <div class="collaborators-table">
                                <table>
                                    <colgroup>
                                        <col width="25%">
                                        <col width="25%">
                                        <col width="25%">
                                        <col width="25%">
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>COLLABORATOR</th>
                                        <th>ROLE</th>
                                        <th>PROFIT SHARE</th>
                                        <th>PUBLISHING %</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>YOU</td>
                                        <td>MAIN COLLABORATOR</td>
                                        <td>100%</td>
                                        <td>100%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="btnbox">
                                <button type="button" class="waves-effect">Add collaborator</button>
                            </div>

                            <div class="collaborators-info">
                                <h4>Before you add Collaborators, please make sure that you & your Collaborators
                                    meet the requirements below:</h4>
                                <div>
                                    - You must be the "Primary Contributor" to add Collaborators<br/>
                                    - Make sure you Follow each other.<br/>
                                    - Your Collaborator has to be a BeatStars Registered Member and at least
                                    subscribed to a "FREE" Subscription Account<br/>
                                    - Needs to have their PayPal Email Address properly Setup<br/>
                                    - You can only add up to Five (5) Collaborators per Track
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="registered__section">
                <div class="wrap">
                    <h2 class="registered__section-title">Related Videos</h2>
                    <div class="registered__section-content">
                        <div class="">
                            <p class="registered__description">
                                Only link videos that are related to this Track. Following examples are: Video
                                Promotions or Official Music Video.
                            </p>
                            <div class="btnbox">
                                <button type="button" class="red waves-effect">Add collaborator</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="registered__btnbox">
                <a href="" class="btn btn--list waves-effect">List</a>
                <button type="submit" class="btn btn--save waves-effect">Save</button>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import Loader from '*/vue/common/Loader'
    import axios from 'axios'
    import moment from 'moment'
    import Index_Items from "../Index_Items"
    import KeepAliveGlobal from "vue-keep-alive-global"
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';


    export default {
        components: {
            Header, Footer, Index_Items, Loader, KeepAliveGlobal, flatPickr
        },
        data: function() {
            return {
                datetime: null,
                configdateTimePicker: {
                    enableTime: true,
                    dateFormat: 'd-m-Y H:i'
                },
                isLogin: false,
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
                    r.data.url = 'http://beatsomeone.com/beatsomeone/detail/' + r.data.cit_key;
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
                  window.location.href = `/mypage/regist_item/${ r.data }`

              }, e=> {
                  alert(`${ this.cit_id ? '수정' : '등록'} 실패 하였습니다. 관리자에게 연락 주시기 바랍니다.`);
                  log.debug('ERROR',e);
              })

            },
        }
    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';


</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    @import '/assets/plugins/flatpickr/flatpickr.css';

</style>
