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
                                <label class="form-item">
                                    <p class="form-title required">TITLE</p>
                                    <div class="input">
                                        <input type="text" v-model.trim="item.cit_name" placeholder="New Track" required/>
                                    </div>
                                    <span class="form-info">
                                        9 out of 60 Maximum characters allowed
                                    </span>
                                </label>

                                <label class="form-item">
                                    <p class="form-title">TAGS (10)</p>
                                    <div class="input">
                                        <input type="text" v-model.trim="item.hashTag" placeholder="Tags (,)Comma Separated"
                                               maxlength="200" id="tags" @input="chkHashTag"/>
                                        <span class="form-unit"><span ref="hashTagCount">0</span>/10</span>
                                    </div>
                                </label>

                                <div class="">
                                    <div class="col">
                                        <label class="form-item">
                                            <p class="form-title required">TRACK TYPE</p>
                                            <select v-model="item.trackType" class="custom-select-basic">
                                                <option value="">Select</option>
                                                <option v-for="(item, index) in listTrackType" :key="'trackType' + index"
                                                        :value="item">{{ item }}
                                                </option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="form-item">
                                            <p class="form-title required">RELEASE DATE</p>
                                            <div class="input">
                                                <flat-pickr :config="{enableTime: true, dateFormat: 'Y-m-d H:i'}" v-model="item.cit_start_datetime" placeholder="Date Time" class="datepicker"/>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-item">
                                    <p class="form-title required">AUDIOFILES FOR DOWNLOAD</p>
                                    <label for="unTaggedFile" class="addAudioFile waves-effect ">
                                        <div class="addAudioFile__icon">
                                            <img src="/assets/images/icon/note1.png" alt="">
                                        </div>
                                        <div class="addAudioFile__info">
                                            <FileUpload name="unTaggedFile" id="unTaggedFile" ref="unTaggedFile"
                                                        target="/beatsomeoneApi/upload_item_file" action="POST" hidden
                                                        v-on:progress="unTaggedFileProgressUpload"
                                                        v-on:start="unTaggedFileStartUpload"
                                                        v-on:finish="unTaggedFileFinishUpload"/>
                                            <p>Un-Tagged WAV or MP3</p>
                                            <span class="format">{{ !!item.unTaggedFileName ? item.unTaggedFileName : '.WAV (or.MP3)' }}</span>
                                            <div class="addAudioFile__progress">
                                                <span ref="unTaggedFileProgressBar"></span>
                                            </div>
                                        </div>
                                    </label>
                                    <label for="stemFile" class="addAudioFile waves-effect" style="margin-top: 10px;">
                                        <div class="addAudioFile__icon">
                                            <img src="/assets/images/icon/note2.png" alt="">
                                        </div>
                                        <div class="addAudioFile__info">
                                            <FileUpload name="stemFile" id="stemFile" ref="stemFile"
                                                        target="/beatsomeoneApi/upload_item_file" action="POST" hidden
                                                        v-on:progress="stemFileProgressUpload" v-on:start="stemFileStartUpload"
                                                        v-on:finish="stemFileFinishUpload"/>
                                            <p>Track Stems ZIP or RAR</p>
                                            <span class="format">{{ !!item.stemFileName ? item.stemFileName : '.ZIP (or.RAR)' }}</span>
                                            <div class="addAudioFile__progress">
                                                <span ref="stemFileProgressBar"></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-item">
                                    <p class="form-title">AUDIOFILES FOR STREAMING</p>
                                    <label for="streamingFile" class="addAudioFile waves-effect">
                                        <div class="addAudioFile__icon">
                                            <img src="/assets/images/icon/note3.png" alt="">
                                        </div>
                                        <div class="addAudioFile__info">
                                            <FileUpload name="streamingFile" id="streamingFile" ref="streamingFile"
                                                        target="/beatsomeoneApi/upload_item_file" action="POST" hidden
                                                        v-on:progress="streamingFileProgressUpload"
                                                        v-on:start="streamingFileStartUpload"
                                                        v-on:finish="streamingFileFinishUpload"/>
                                            <p>Custom tagged audio WAV or MP3</p>
                                            <span class="format">{{ !!item.streamingFileName ? item.streamingFileName : '.WAV (or.MP3)' }}</span>
                                            <div class="addAudioFile__progress">
                                                <span ref="streamingFileProgressBar"></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-item">
                                <p class="form-title">Artwork</p>
                                <div class="artwork">
                                    <FileUpload name="artworkFile" id="artworkFile" target="/beatsomeoneApi/upload_artwork_file"
                                                action="POST" hidden v-on:start="artworkStartUpload"
                                                v-on:finish="artworkFinishUpload"/>
                                    <label for="artworkFile" class="artwork-box">
                                        <img :src="'/' + (!!item.artworkPath ? item.artworkPath : 'assets/images/artwork.png')"
                                             alt="" id="artworkImg" ref="artworkImg">
                                    </label>
                                    <div class="artwork__info">
                                        Preferred: 1500x1500px, Minimum: 500x500px<br/><br/>
                                        Got Photoshop? Make your own using our free template.<br/>
                                        <a href="" download>Download PSD Template.</a>
                                    </div>
                                    <label for="artworkFile" class="artwork-upload waves-effect">Upload Artwork</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-item">
                                <p class="form-title">URL OF YOUR TRACK</p>
                                <div class="input">
                                    <input type="text" class="artworkDoemin" placeholder="" readonly v-model="item.url"/>
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
                                <h2>NOTICE</h2>
                                <p>If you enter a dollar or won, the exchange rate will be reflected automatically.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-item">
                                    <div class="form-title">
                                        <label for="c1" class="checkbox">
                                            <input type="checkbox" hidden="" id="c1" v-model="item.licenseLeaseUseYn">
                                            <span></span> BASIC LEASE LICENSE (MP3 or WAV) PRICE
                                        </label>
                                    </div>
                                    <div class="row row--inner">
                                    <span class="col">
                                        <div class="input">
                                            <input type="number" placeholder="KRW" v-model="item.licenseLeasePriceKRW"/>
                                        </div>
                                    </span>
                                        <span class="col">
                                        <div class="input">
                                            <input type="number" placeholder="USD" v-model="item.licenseLeasePriceUSD"/>
                                        </div>
                                    </span>
                                    </div>
                                    <div class="row row--inner">
                                    <span class="col">
                                        <p>Inventory quantity</p>
                                    </span>
                                        <span class="col">
                                        <div class="input">
                                            <input type="number" placeholder="0" v-model="item.licenseLeaseQuantity"/>
                                        </div>
                                    </span>
                                    </div>
                                    <p class="form-info mt-15">
                                        · Leases licenses for uploaded MP3 or WAV files.<br/><br/>
                                        · The terms of lease are limited to 60 days of service /<br/>
                                        no arbitrary editing / Rented members cannot be re-rented to others /<br/>
                                        no other activities not authorized by the platform
                                    </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-item">
                                    <div class="form-title">
                                        <label for="c2" class="checkbox">
                                            <input type="checkbox" hidden="" id="c2" v-model="item.licenseStemUseYn">
                                            <span></span> MASTERING LICENSE (MP3 or WAV and STEMS) PRICE
                                        </label>
                                    </div>
                                    <div class="row row--inner">
                                    <span class="col">
                                        <div class="input">
                                            <input type="number" placeholder="KRW" v-model="item.licenseStemPriceKRW"/>
                                        </div>
                                    </span>
                                        <span class="col">
                                        <div class="input">
                                            <input type="number" placeholder="USD" v-model="item.licenseStemPriceUSD"/>
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
                                                <input type="number" placeholder="1" readonly class="disabled"
                                                       v-model="item.licenseStemQuantity"/>
                                            </div>
                                        </span>
                                    </div>
                                    <p class="form-info mt-15">
                                        · Sell mastering licenses including uploaded MP3 or WAV files and STEMS
                                        configurations.<br/><br/>
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
                                <label class="form-item">
                                    <p class="form-title required">PRIMARY GENRE</p>
                                    <select v-model="item.genre" class="custom-select-basic">
                                        <option value="">Select</option>
                                        <option v-for="(item, index) in listGenre" :key="'genre' + index" :value="item">{{ item
                                            }}
                                        </option>
                                    </select>
                                </label>
                                <label class="form-item">
                                    <p class="form-title ">SUBGENRE</p>
                                    <select v-model="item.subgenre" class="custom-select-basic">
                                        <option value="">Select</option>
                                        <option v-for="(item, index) in listGenre" :key="'subgenre' + index" :value="item">{{
                                            item }}
                                        </option>
                                    </select>
                                </label>
                                <label class="form-item">
                                    <p class="form-title required">PRIMARY MOOD</p>
                                    <select v-model="item.moods" class="custom-select-basic">
                                        <option value="">Select</option>
                                        <option v-for="(item, index) in listMoods" :key="'moods' + index" :value="item">{{ item
                                            }}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div class="col">
                                <label class="form-item">
                                    <p class="form-title ">DESCRIPTION</p>
                                    <div class="input">
                                        <textarea v-model.trim="item.cit_content" placeholder="Enter Description"></textarea>
                                    </div>
                                </label>
                                <label class="form-item">
                                    <p class="form-title ">BPM(Beats per minute)</p>
                                    <div class="input">
                                        <input type="number" v-model.trim="item.bpm"/>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="registered__btnbox">
                <a href="/beatsomeone/sublist" class="btn btn--list waves-effect">List</a>
                <button type="submit" class="btn btn--save waves-effect" @click="doSubmit">Save</button>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>
    require('@/assets_m/js/function');
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import Loader from '*/vue/common/Loader'
    import axios from 'axios'
    import Index_Items from "../Index_Items"
    import KeepAliveGlobal from "vue-keep-alive-global"
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import FileUpload from 'vue-simple-upload/dist/FileUpload'

    export default {
        components: {
            Header, Footer, Index_Items, Loader, KeepAliveGlobal, flatPickr, FileUpload
        },
        data: function () {
            return {
                isLogin: false,
                cit_id: null,
                item: {
                    cit_name: '',
                    hashTag: '',
                    trackType: '',
                    cit_start_datetime: null,
                    url: '',
                    licenseLeaseUseYn: '',
                    licenseLeasePriceKRW: '',
                    licenseLeasePriceUSD: '',
                    licenseLeaseQuantity: '',
                    licenseStemUseYn: '',
                    licenseStemPriceKRW: '',
                    licenseStemPriceUSD: '',
                    licenseStemQuantity: 1,
                    genre: '',
                    subgenre: '',
                    moods: '',
                    bpm: '',
                    cit_content: '',
                    unTaggedFile: '',
                    stemFile: '',
                    streamingFile: '',
                    artwork: '',
                    unTaggedFileName: '',
                    stemFileName: '',
                    streamingFileName: '',
                    artworkPath: ''
                },
                uploadInProgress: {
                    unTaggedFile: false,
                    stemFile: false,
                    streamingFile: false,
                    artwork: false
                },
                listGenre: ['Hip Hop', 'K-Pop', 'Pop', 'R&B', 'Rock', 'Electronic', 'Reggae', 'Country', 'World'],
                listMoods: ['Accomplished', 'Adored', 'Angry', 'Annoyed', 'Anxious,Bouncy', 'Calm,Confident', 'Crazy', 'Crunk', 'Dark', 'Depressed', 'Determined', 'Dirty', 'Disappointed', 'Eccentric', 'Energetic', 'Enraged', 'Epic', 'Evil', 'Flirty', 'Frantic', 'Giddy', 'Gloomy', 'Grateful', 'Happy', 'Hyper', 'Inspiring', 'Intense', 'Lazy', 'Lonely', 'Loved', 'Mellow', 'Peaceful', 'Rebellious', 'Relaxed', 'Sad', 'Scared', 'Silly', 'Soulful'],
                listTrackType: ['Beats', 'Beats with chorus', 'Vocals', 'Song reference', 'Songs'],
            };
        },
        watch: {
            cit_id: function (n) {
                log.debug({
                        'cit_id': n,
                    }
                )
                if (n) {
                    this.getItem();
                }
            },
        },
        methods: {
            unTaggedFileStartUpload(e) {
                this.startUpload('unTaggedFile', e);
            },
            unTaggedFileFinishUpload(e) {
                this.finishUpload('unTaggedFile', e);
            },
            unTaggedFileProgressUpload(e) {
                this.progressUpload('unTaggedFile', e);
            },
            stemFileStartUpload(e) {
                this.startUpload('stemFile', e);
            },
            stemFileFinishUpload(e) {
                this.finishUpload('stemFile', e);
            },
            stemFileProgressUpload(e) {
                this.progressUpload('stemFile', e);
            },
            streamingFileStartUpload(e) {
                this.startUpload('streamingFile', e);
            },
            streamingFileFinishUpload(e) {
                this.finishUpload('streamingFile', e);
            },
            streamingFileProgressUpload(e) {
                this.progressUpload('streamingFile', e);
            },
            startUpload(type, e) {
                this.uploadInProgress[type] = true
                this.$refs[type + 'ProgressBar'].style.width = '0%'
            },
            finishUpload(type, e) {
                let data = JSON.parse(e.target.response)
                this.uploadInProgress[type] = false

                if (!!data.code && data.code === 'error') {
                    alert('파일 업로드 실패\n파일 확인 후 다시 시도해 주세요')
                    return false
                }

                this.item[type] = JSON.parse(e.target.response)
                this.$refs[type + 'ProgressBar'].style.width = '100%'
            },
            progressUpload(type, e) {
                if (!e) {
                    alert('파일 업로드중 오류가 발생하였습니다. 다시 시도해 주세요.')
                    return false
                }
                this.$refs[type + 'ProgressBar'].style.width = e + '%'
            },
            artworkStartUpload(e) {
                this.uploadInProgress['artwork'] = true
            },
            artworkFinishUpload(e) {
                let data = JSON.parse(e.target.response)
                this.uploadInProgress['artwork'] = false

                if (!!data.code && data.code === 'error') {
                    alert('파일 업로드 실패\n파일 확인 후 다시 시도해 주세요')
                    return false
                }

                this.item.artwork = data
                this.$refs['artworkImg'].src = '/' + this.item.artwork.filename
            },
            chkHashTag() {
                let hashTag = this.item.hashTag.split(',')
                if (hashTag.length <= 10) {
                    this.$refs['hashTagCount'].innerText = hashTag.length
                    return false
                }

                alert('태그는 최대 10개까지 등록 가능합니다')
                this.item.hashTag = hashTag.slice(0, 10)
                this.$refs['hashTagCount'].innerText = 10
            },
            // 데이터 로딩
            getItem() {
                Http.get(`/beatsomeoneApi/get_item/${this.cit_id}`).then(r => {
                    // 전처리
                    r.data.cde_id_1 = r.data.cde_id || 0;
                    r.data.cde_id_2 = r.data.cde_id_2 || 0;
                    r.data.cde_id_3 = r.data.cde_id_3 || 0;
                    r.data.url = 'http://beatsomeone.com/beatsomeone/detail/' + r.data.cit_key;
                    r.data.licenseLeasePriceKRW = r.data.cde_price;
                    r.data.licenseLeasePriceUSD = r.data.cde_price_d;
                    r.data.licenseLeaseQuantity = r.data.cde_quantity;
                    r.data.licenseStemPriceKRW = r.data.cde_price_2;
                    r.data.licenseStemPriceUSD = r.data.cde_price_d_2;
                    r.data.licenseStemQuantity = 1;
                    r.data.unTaggedFileName = r.data.cde_originname;
                    r.data.stemFileName = r.data.cde_originname_2;
                    r.data.streamingFileName = r.data.cde_originname_3;
                    r.data.artworkPath = r.data.cit_file_1;
                    r.data.artwork = '';
                    this.item = r.data;
                });
            },
            // 저장
            doSubmit() {
                const f = new FormData();

                if (!this.item.cit_name) {
                    alert('제목을 입력해 주세요')
                    return false
                }
                if (!this.item.trackType) {
                    alert('트랙타입을 선택해 주세요')
                    return false
                }
                if (!this.item.cit_start_datetime) {
                    alert('발매일을 선택해 주세요')
                    return false
                }
                if (!this.item.unTaggedFile && !this.item.unTaggedFileName) {
                    alert('음원을 등록해 주세요')
                    return false
                }
                if (!this.item.stemFile && !this.item.stemFileName) {
                    alert('음원을 선택해 주세요')
                    return false
                }
                if (!this.item.genre) {
                    alert('유형을 선택해 주세요')
                    return false
                }
                if (!this.item.moods) {
                    alert('무드를 선택해 주세요')
                    return false
                }

                for (let key in this.uploadInProgress) {
                    if (this.uploadInProgress[key]) {
                        alert('파일 업로드 중입니다')
                        return false
                    }
                }

                let param
                _.forEach(this.item, (v, k) => {
                    param = (typeof v !== "object") ? v : JSON.stringify(v)
                    f.append(k, param);
                });

                if (this.cit_id) {
                    f.append('cit_id', this.cit_id)
                }
                axios.post('/beatsomeoneApi/merge_item', f, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(r => {
                    log.debug(
                        {
                            'MERGE SUCCESS': r.data,
                        }
                    )
                    alert(`${this.cit_id ? '수정' : '등록'} 되었습니다`);
                    window.location.href = '/mypage/regist_item/' + r.data
                }, e => {
                    alert(`${this.cit_id ? '수정' : '등록'} 실패 하였습니다. 관리자에게 연락 주시기 바랍니다.`)
                    log.debug('ERROR', e)
                })
            },
        }
    }
</script>

<style lang="scss">
    @import '@/assets_m/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
    @import '/assets/plugins/flatpickr/flatpickr.css';
</style>
