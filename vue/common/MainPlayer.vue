<template>
    <div class="player" v-show="listPlayer.length > 0">
        <div class="wrap">
            <div class="player__top">
                <div class="player__progress">
                    <div id="waveform">
                        <!-- Here be waveform -->
                    </div>

                    <div id="progress-container">
                        <input type="range" class="amplitude-song-slider" step=".1"/>
                        <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
                        <progress id="song-buffered-progress" class="amplitude-buffered-progress"></progress>
                    </div>
                </div>
            </div>
            <div class="player__bottom">
                <div class="player__favorite">
                    <button></button>
                </div>
                <div class="player__info">
                    <div class="col name">
                        <figure>
                  <span class="playList__cover">
                    <img data-amplitude-song-info="cover_art_url" class="album-art"/>
                  </span>
                            <figcaption>
                                <h3 class="playList__title song-title" data-amplitude-song-info="name">
                                </h3>
                                <span class="playList__by song-artist" data-amplitude-song-info="artist"></span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
                <div id="central-controls" class="player__controller">
                    <div class="amplitude-prev" id="previous"></div>
                    <div class="amplitude-play-pause amplitude-paused" id="play-pause" @click="togglePlay"></div>
                    <div class="amplitude-next" id="next"></div>
                </div>
                <div class="player__util">
                    <div class="player__shuffle amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
                    <div class="player__repeat amplitude-repeat amplitude-repeat-off" id="repeat"></div>
                    <div id="volume-container" class="player__volume">
                        <div class="volume-controls">
                            <div class="amplitude-mute amplitude-not-muted"></div>
                            <input type="range" class="amplitude-volume-slider">
                            <div class="ms-range-fix"></div>
                        </div>
                        <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle-right"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

    import Amplitude from 'amplitudejs';
    import { EventBus } from '*/src/eventbus';
    import $ from "jquery";

    export default {

        data: function() {
            return {
                // listPlayer: [
                //     {
                //         id: 1,
                //         name: "I Came Running",
                //         artist: "Ancient Astronauts",
                //         album: "We Are to Answer",
                //         url: "/assets_m/audio/testfile.mp3",
                //         cover_art_url: "https://521dimensions.com/img/open-source/amplitudejs/album-art/we-are-to-answer.jpg",
                //         isNew: true,
                //     },
                // ],
                listPlayer: [],
            };
        },
        created() {
            EventBus.$on('index_items_stop_all_played',r=> {
                if(!r.item) return;
                const i = {
                    id: r.item.cit_id,
                    name : r.item.cit_name,
                    artist: r.item.musician,
                    url: `/cmallact/download_sample/${r.item.cde_id}`,
                    cover_art_url: `/uploads/cmallitem/${r.item.cit_file_1}`,
                    isNew : true,
                };
                if(!_.find(this.listPlayer,{id:r.item.cit_id})) {
                    this.increaseMusicCount(r);
                    Amplitude.addSong( i);
                    this.listPlayer.unshift(i);
                }
                Amplitude.playNow( i);
                log.debug({
                    'MAIN PLAYER LIST' : this.listPlayer,
                });
            });

            EventBus.$on('stop_main_player',r=> {
                Amplitude.pause();
                $('#play-pause').removeClass('amplitude-playing').addClass('amplitude-paused');
            });
        },
        mounted() {
            this.init();
        },
        methods: {
            init() {
                Amplitude.init({
                    "songs": this.listPlayer,
                    delay: 3000,
                    callbacks: {
                        play: () => {
                            log.debug('MAIN PLAYER PLAY!');
                            EventBus.$emit('index_items_stop_all_played', {'_uid':this._uid});
                        },
                        initialized: () => {
                            //this.increaseMusicCount();
                        }
                    },
                    waveforms: {
                        sample_rate: 3000
                    }
                });
            },
            togglePlay() {
                EventBus.$emit('index_items_stop_all_played', {'_uid':this._uid});
            },
            // 다운로드 증가
            increaseMusicCount(item) {
                Http.post( `/beatsomeoneApi/increase_music_count`,{cde_id:item.cde_id}).then(r=> {
                    if(!r) {
                        log.debug('카운트 증가 실패');
                    } else {
                        log.debug('카운트 증가 성공');
                    }
                });
            }
        },

    }

</script>

<style lang="css">

</style>
