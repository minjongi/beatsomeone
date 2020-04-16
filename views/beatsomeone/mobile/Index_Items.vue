<template>

    <li v-if="item" class="playList__itembox" :id="'playList__item'+ item.cit_id">
        <div class="playList__item playList__item--title">

            <div class="col favorite" :class="{active : item.is_wish === '1' }" @click="toggleWish">
                <button>즐겨찾기</button>
            </div>
            <div class="col name">
                <figure>
              <span class="playList__cover" @click="selectItem(item)">
                <img
                        :src="'/uploads/cmallitem/' + item.cit_file_1"
                        alt=""
                />
               <i class="label new" ng-if="item.isNew">N</i>
              </span>

                    <button class="btn-play"  @click="playAudio(item)" :data-action="'playAction' + item.cit_id ">재생</button>
                    <div class="wave"></div>
                    <figcaption @click="selectItem(item)">
                        <h3 class="playList__title">
                            {{ item.cit_name }}
                        </h3>
                        <span class="playList__by">{{ item.musician }} ( {{ item.bpm }}Bpm )</span>
                    </figcaption>
                </figure>
            </div>
            <div class="col more">

                <button :class="{'js-active' : isOpenSubmenu}" @click="openSubmenu">
                    more
                </button>
                <span class="tooltip">
                <a href="">action1</a>
                <a href="">action2</a>
                <a href="">action3</a>
              </span>
            </div>
        </div>
    </li>

</template>


<script>

    import { EventBus } from '*/src/eventbus';
    import $ from 'jquery';
    import WaveSurfer from 'wavesurfer.js';

    export default {
        props: ['item'],
        data: function () {
            return {
                isOpenSubmenu: false,
                listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                ws: null,
                isPlay: false,
                isReady: false,

            };
        },
        computed: {
            hashtag() {
                return this.item.hashTag ? this.item.hashTag.split(',') : '';
            },
        },
        mounted() {
            EventBus.$on('index_items_open_submenu',r=> {
                if(this._uid !== r) {
                    this.isOpenSubmenu = false;
                }
            });

            EventBus.$on('player_request_start',r=> {
                log.debug({
                    'ON ITEM: player_request_start':r,
                    'R' : this.item.cit_id === r.item.cit_id,
                    'this.item.cit_id':this.item.cit_id,
                })
                if(this.item.cit_id != r.item.cit_id) {
                    this.stop();
                }

            });
            // 메인 플레이어 재생 시작
            EventBus.$on('main_player_play',r=> {
                log.debug({
                    'ON ITEM: main_player_play':r,
                    'R' : this.item.cit_id === r.item.id,
                    'this.item.cit_id':this.item.cit_id,
                })
                if(this.item.cit_id === r.item.id) {
                    this.start();

                } else {

                    this.stop();
                }
            });
            // 메인 플레이어 재생 종료
            EventBus.$on('main_player_stop',r=> {
                log.debug({
                    'ON ITEM: main_player_stop':r,
                    'R' : this.item.cit_id === r.item.id,
                    'this.item.cit_id':this.item.cit_id,
                })
                if(this.item.cit_id === r.item.id) {

                    this.stop();
                }
            });

            this.setAudioInstance(this.item);
        },
        methods: {
            stop() {
                this.ws.pause();
                const el = $('#playList__item'+this.item.cit_id);
                el.removeClass('playing');
                this.isPlay = false;
            },
            start() {
                log.debug('ITEM : start');
                this.ws.play();
                // if(this.isReady && !this.ws.isPlaying()) {
                //     this.ws.play();
                // }
                const el = $('#playList__item'+this.item.cit_id);
                el.addClass('playing');
                this.isPlay = true;
            },
            openSubmenu() {
                this.isOpenSubmenu = !this.isOpenSubmenu;
                EventBus.$emit('index_items_open_submenu',this._uid);
            },
            toggleWish() {
                Http.post( `/beatsomeoneApi/toggle_wish_item/${this.item.cit_id}`).then(r=> {
                    if(r === true) {
                        // log.debug({
                        //     'toggleWish':this.item,
                        // })
                        this.item.is_wish = this.item.is_wish === '1' ? '0' : '1';
                    }
                });

            },
            addCart() {

                let detail_qty = {};
                detail_qty[this.item['cde_id']] = 1;
                Http.post( `/beatsomeoneApi/itemAction`,{stype: 'cart',cit_id:this.item.cit_id,chk_detail:[this.item.cde_id],detail_qty:detail_qty,}).then(r=> {
                    if(!r) {
                        log.debug('장바구니 담기 실패');
                    } else {
                        EventBus.$emit('add_cart');
                        log.debug('장바구니 담기 성공');

                    }
                });
            },
            selectItem(i) {
                const path = `/beatsomeone/detail/${i.cit_key}`;
                window.location.href = path;
            },
            playAudio(i) {

                // if(!this.isReady) return;

                // 재생 시작
                if(!this.isPlay) {
                    // log.debug({
                    //     'EMIT ITEM : item player_request_start':this.item,
                    // });
                    EventBus.$emit('player_request_start',{'_uid':this._uid,'item':this.item,'ws':this.ws});

                    this.start();
                }
                // 중지
                else {
                    // log.debug({
                    //     'EMIT ITEM : item player_request_stop':this.item,
                    // });
                    EventBus.$emit('player_request_stop',{'_uid':this._uid,'item':this.item,'ws':this.ws});

                    this.stop();
                }

            },
            time_convert(num) {
                var minutes = Math.floor(num / 60);
                var seconds = num % 60;
                if (seconds < 10) {
                    seconds = "0" + seconds;
                }
                return minutes + ":" + seconds;
            },
            setAudioInstance(item) {
                this.ws = WaveSurfer.create({
                    container: "#playList__item" + item.cit_id + " .wave",
                    waveColor: "#696969",
                    progressColor: "#c3ac45",
                    hideScrollbar: true,
                    height: 50,

                });
                if(item.cde_id) {
                    this.ws.load(`/cmallact/download_sample/${item.cde_id}`);
                }

                this.ws.on("play", () => {

                    //this.start();
                });

                this.ws.on("audioprocess", (e) => {
                    // // 파일이 재생될때 계속 실행
                    // document.querySelector(
                    //     "#playList__item" + this.item.cit_id + " .current"
                    // ).innerHTML = this.time_convert(parseInt(e, 10)) + " / ";
                });

                this.ws.on("ready", () => {

                    // document.querySelector(
                    //     "#playList__item" + this.item.cit_id + " .duration"
                    // ).innerHTML = this.time_convert(parseInt(this.ws.getDuration(), 10));
                    // if(!this.ws.isPlaying()) {
                    //
                    // }
                    if(this.isPlay) {
                        this.ws.play();
                    }
                    // if(this.ws.isPlaying()) {
                    //     this.ws.play();
                    // }
                    this.isReady = true;
                    //this.start();


                });
                this.ws.on("pause", () => {

                });

            },
            //다운로드 증가
            increaseMusicCount() {
                Http.post( `/beatsomeoneApi/increase_music_count`,{cde_id:this.item.cde_id}).then(r=> {
                    if(!r) {
                        log.debug('카운트 증가 실패');
                    } else {
                        log.debug('카운트 증가 성공');
                    }
                });
            },
            // 해쉬 클릭
            clickHash(h) {
                const path = `/beatsomeone/sublist?search=${h}`;
                window.location.href = path;
            }
        }
    }



</script>

<style scoped="scoped">

</style>
