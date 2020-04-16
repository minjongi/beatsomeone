<template>
    <li v-if="item" class="playList__itembox" :id="'playList__item'+ item.cit_id">

        <div class="playList__item playList__item--title">
            <div class="col favorite" :class="{active : item.is_wish === '1' }" @click="toggleWish">
                <button>즐겨찾기</button>
            </div>
            <div class="col name">
                <figure>
              <span class="playList__cover">
                <img
                        :src="'/uploads/cmallitem/' + item.cit_file_1"
                        alt=""
                />
                <i class="label new" ng-if="item.isNew">N</i>

              </span>
                    <figcaption class="pointer" @click="selectItem(item)">
                        <h3 class="playList__title">
                            {{ item.cit_name }}
                        </h3>
                        <span class="playList__by">{{ item.musician }} ( {{ item.bpm }}Bpm )</span>
                    </figcaption>
                </figure>

                <!-- 서브리스트 토글 버튼 -->
                <button class="toggle-subList" v-if="item.subPlayList && item.subPlayList.length > 0"></button>
            </div>
            <div class="col genre">
                <span v-for="(t,i) in hashtag" :key="i">
                    <button @click="clickHash(t)">{{ t }}</button>
                </span>

            </div>
            <div class="col playbtn">
                <button class="btn-play" @click="playAudio(item)" :data-action="'playAction' + item.cit_id ">재생</button>
                <span class="timer">
              <span class="current">0:00 / </span>
              <span class="duration">0:00</span>
            </span>
            </div>
            <div class="col spectrum">
                <div class="wave"></div>
            </div>

            <div class="col utils">
                <a @click="addCart" class="cart" >
                    &nbsp;
                    <span class="tooltip">{{ item.cde_price }}&#8361;</span>
                </a>

                <a :href="`/cmallact/download_sample/${item.cde_id}`" class="download">다운로드</a>
                <a href="" class="shared">공유하기</a>
            </div>

            <div class="col more">
                <button>
                    more
                    <span class="tooltip">
                <a href="">action1</a>
                <a href="">action2</a>
                <a href="">action3</a>
              </span>
                </button>
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
        // beforeDestroy() {
        //     this.ws.destroy();
        // },
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
                if(this._uid != r.item._uid) {
                    this.stop();
                }

            });
            // 메인 플레이어 재생 시작
            EventBus.$on('main_player_play',r=> {
                log.debug({
                    '_uid':this._uid,
                    'R _uid' : r._uid,
                    'EQ':this._uid == r._uid,
                })
                if(this._uid == r._uid) {
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
                if(this._uid === r._uid) {

                    this.stop();
                }
            });

            // this.setAudioInstance(this.item);


        },
        methods: {
            stop() {
                if(this.ws) {
                    this.ws.pause();
                }

                const el = $('#playList__item'+this.item.cit_id);
                log.debug({
                  'STOP el':el,
                })
                el.removeClass('playing');
                this.isPlay = false;
            },
            start() {
                log.debug('ITEM : start');
                if(this.ws) {
                    this.ws.play();
                }

                // if(this.isReady && !this.ws.isPlaying()) {
                //     this.ws.play();
                // }
                const el = $('#playList__item'+this.item.cit_id);
                log.debug({
                    'START el':el,
                })
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

                    if(!this.ws ) {
                        this.setAudioInstance(this.item);
                    }

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

                    // document
                    //     .querySelector("#playList__item" + item.id)
                    //     .classList.add("playing");
                    //this.start();
                    const el = document.querySelector(
                        "#playList__item" + this.item.cit_id
                    );
                    if(el) {
                        el.classList.add("playing");
                    }
                });

                this.ws.on("audioprocess", (e) => {
                    const el = document.querySelector(
                        "#playList__item" + this.item.cit_id + " .current"
                    );
                    if(el) {
                        el.innerHTML = this.time_convert(parseInt(e, 10)) + " / ";
                    }

                });

                this.ws.on("ready", () => {

                    const el = document.querySelector(
                        "#playList__item" + this.item.cit_id + " .duration"
                    );
                    if(el) {
                        el.innerHTML = this.time_convert(parseInt(this.ws.getDuration(), 10));
                    }




                    if(this.isPlay) {
                        this.ws.play();
                    }

                    this.isReady = true;

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
