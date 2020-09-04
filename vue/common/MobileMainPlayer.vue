
<template>
    <div class="player" v-show="listPlayer.length > 0">
        <div class="wrap">
            <div class="player__top">
                <div class="player__progress">
                    <div id="progress-container" class="spectrum">
                        <div id="minimap"></div>
                    </div>

                    <!--                    <div id="progress-container">-->
                    <!--                        <input type="range" class="amplitude-song-slider" step=".1" />-->
                    <!--                        <progress id="song-played-progress" class="amplitude-song-played-progress" ></progress>-->
                    <!--                        <progress id="song-buffered-progress" class="amplitude-buffered-progress" ></progress>-->
                    <!--                    </div>-->
                </div>
            </div>
            <div class="player__bottom">
                <div class="player__info">
                    <div class="col name" v-if="currentMusic">
                        <figure>
                          <span class="playList__cover">
                            <img class="album-art" :src="currentMusic.cover_art_url" />
                          </span>
                            <figcaption>
                                <h3 class="playList__title song-title" >
                                    {{ currentMusic.name }}
                                </h3>
                                <span class="playList__by song-artist">
                                    {{ currentMusic.artist }}
                                </span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div id="central-controls" class="player__controller">
                    <div
                        style="cursor: pointer;
                        width: 25px;
                        height: 25px;
                        background: url('/assets_m/images/icon/prev.png') no-repeat center;
                        background-size: 100% 100%;
                        opacity: 0.3;"
                        class="play-prev" id="previous" @click="prev"></div>

                    <div v-if="isPlay"
                         style="cursor: pointer;
                           border: 1px white solid;
                           border-radius: 50%;
                           width: 35px;
                           height: 35px;
                           background: url('/assets_m/images/icon/pause.png') no-repeat center;
                           background-size: 100% 100%;
                           opacity: 1;
                           margin: 0 5px;"
                           class="play-play-pause" id="main-play-pause1" @click="togglePlay"></div>
                    <div v-if="!isPlay"
                         style="
                            border-radius: 50%;
                            border: 1px white solid;
                            width: 35px;
                            height: 35px;
                            margin: 0 5px;
                            background: url('/assets_m/images/icon/play.png') no-repeat center; background-size: 100% 100%;"
                         class="play-play-pause"
                         id="main-play-pause2" @click="togglePlay"></div>


                    <div
                    style=" cursor: pointer;
                    width: 25px;
                    height: 25px;
                    background: url('/assets_m/images/icon/next.png') no-repeat center;
                    background-size: 100% 100%;
                    opacity: 0.3;"
                            class="play-next" id="next" @click="next"></div>
                </div>

            </div>
        </div>
    </div>
</template>



<script>

    import { EventBus } from '*/src/eventbus';
    import $ from "jquery";
    import MinimapPlugin from 'wavesurfer.js/dist/plugin/wavesurfer.minimap.min.js';

    export default {

        data: function() {
            return {
                isPlay: false,
                listPlayer: [],
                //ws: null,
                currentIndex: -1,
                currentSeekTime: 0,
                prevWs: null,

            };
        },
        created() {

            EventBus.$on('player_request_start',r=> {
                log.debug({
                    'ON MAIN : player_request_start':r
                });

                if(!r.item) return;


                const i = {
                    _uid: r._uid,
                    id: r.item.cit_id,
                    name : r.item.cit_name,
                    artist: r.item.musician,
                    url: `/cmallact/download_sample/${r.item.cde_id}`,
                    cover_art_url: `/uploads/cmallitem/${r.item.cit_file_1}`,
                    isNew : true,
                    ws: r.ws,
                };
                // 기존 재생 목록에 없으면 추가
                try{
                    if(!_.find(this.listPlayer,{id:r.item.cit_id})) {
                        this.currentIndex = this.currentIndex + 1;
                        this.listPlayer.push(i);
                        this.initMinimap(r.ws);
                    }
                        // // 기존 재생하던 곡이면
                        // else if(i.id === this.currentMusic.id) {
                        //
                        //     //this.start();
                        // }
                    // 기존 재생 목록에 있으면
                    else {
                        log.debug('MAIN : RESTART ON LIST');
                        this.currentIndex = _.findIndex(this.listPlayer,{id:r.item.cit_id});
                        this.initMinimap(r.ws);
                    }
                }catch(e){
                    console.log('Exception in 144line at MobileMainPlayer at vue/common/MobileMainPlayer.vue', e)
                }

                this.start();
            });

            EventBus.$on('player_request_stop',r=> {
                this.stop();
            });

            EventBus.$on('stop_main_player',r=> {
                if(this.isPlay) {
                    this.stop();
                }

            });
        },
        mounted() {
            this.init();

        },
        computed: {
            currentMusic() {
                return this.currentIndex > -1 ? this.listPlayer[this.currentIndex] : null;
            },
        },
        methods: {
            initMinimap(ws) {

                if(this.prevWs && this.prevWs.getActivePlugins().minimap) {
                    this.prevWs.destroyPlugin('minimap');
                }
                ws.addPlugin(MinimapPlugin.create({
                    container: '#minimap',
                })).initPlugin('minimap');

                this.prevWs = ws;

            },
            prev() {
                if(this.currentIndex > 0) {
                    this.currentIndex = this.currentIndex - 1;
                    this.start();
                    this.initMinimap(this.currentMusic.ws);
                }
            },
            next() {
                if(this.currentIndex + 1 < this.listPlayer.length) {
                    this.currentIndex = this.currentIndex + 1;
                    this.start();
                    this.initMinimap(this.currentMusic.ws);
                }
            },
            stop() {
                this.isPlay = false;
                EventBus.$emit('main_player_stop', {'_uid':this.currentMusic._uid,'item':this.currentMusic});
                $('#main-play-pause').removeClass('play-playing').addClass('play-paused');

            },
            start() {
                log.debug({
                    'EMIT MAIN : start':this.currentMusic,
                    'list':this.listPlayer,
                    'currentIndex':this.currentIndex,
                })
                EventBus.$emit('main_player_play', {'_uid':this.currentMusic._uid,'item':this.currentMusic});

                this.isPlay = true;
                $('#main-play-pause').addClass('play-playing').removeClass('play-paused');

            },

            init() {

            },
            // 플레이/정지 버튼 클릭시
            togglePlay() {

                // 재생중 중지
                if(this.isPlay) {
                    log.debug('MAIN: stop');

                    this.stop();
                }
                // 재생
                else {
                    log.debug('MAIN: play');
                    this.start();
                }
            },
            // 다운로드 증가
            // increaseMusicCount(item) {
            //     Http.post( `/beatsomeoneApi/increase_music_count`,{cde_id:item.cde_id}).then(r=> {
            //         if(!r) {
            //             log.debug('카운트 증가 실패');
            //         } else {
            //             log.debug('카운트 증가 성공');
            //         }
            //     });
            // }
        },

    }

</script>

<style scoped lang="scss">

    .spectrum {
        z-index: 999999;

        wave {
            border-right: 0 !important;
        }
    }

    .player .player__controller .play-prev {
        cursor: pointer;
        width: 25px;
        height: 25px;
        background: url("/assets_m/images/icon/prev.png") no-repeat center;
        background-size: 100% 100%;
        opacity: 0.3;
    }
    .player .player__controller .play-play-pause {
        cursor: pointer;
        width: 35px;
        height: 35px;
        background: url("/assets_m/images/icon/pause.png") no-repeat center;
        background-size: 100% 100%;
        opacity: 1;
        margin: 0 5px;
    }
    .player .player__controller .play-play-pause.play-paused {
        background: url("/assets_m/images/icon/play.png") no-repeat center;
        background-size: 100% 100%;
    }
    .player .player__controller .play-next {
        cursor: pointer;
        width: 25px;
        height: 25px;
        background: url("/assets_m/images/icon/next.png") no-repeat center;
        background-size: 100% 100%;
        opacity: 0.3;
    }
</style>