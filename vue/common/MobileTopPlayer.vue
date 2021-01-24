<template>
    <div class="player player--static">
        <div class="wrap">
            <div class="player__top">
                <div class="player__progress">
                    <div id="progress-container">
                        <input type="range" class="amplitude-song-slider" step=".1"/>
                        <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
                        <progress id="song-buffered-progress" class="amplitude-buffered-progress"></progress>
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
    import axios from "axios";

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
            // EventBus.$on('index_items_stop_all_played',r=> {
            //     if(!r.item) return;
            //     const i = {
            //         id: r.item.cit_id,
            //         name : r.item.cit_name,
            //         artist: r.item.musician,
            //         url: `/cmallact/download_sample/${r.item.cde_id}`,
            //         cover_art_url: `/uploads/cmallitem/${r.item.cit_file_1}`,
            //         isNew : true,
            //     };
            //     if(!_.find(this.listPlayer,{id:r.item.cit_id})) {
            //         this.increaseMusicCount(r);
            //         this.listPlayer.unshift(i);
            //         if(this.listPlayer.length === 1) {
            //             this.$nextTick(function() {
            //                 this.init();
            //             })
            //         }
            //         this.$nextTick(function() {
            //             Amplitude.addSong(i);
            //         });
            //     }
            //     this.$nextTick(function() {
            //         Amplitude.playNow(i);
            //     });
            //     log.debug({
            //         'MAIN PLAYER LIST' : this.listPlayer,
            //     });
            // });
            //
            // EventBus.$on('stop_main_player',r=> {
            //     Amplitude.pause();
            //     $('#play-pause').removeClass('amplitude-playing').addClass('amplitude-paused');
            // });
        },
        mounted() {
            this.init();
        },
        methods: {
            init() {
                // Amplitude.init({
                //     "songs": this.listPlayer,
                //     delay: 3000,
                //     callbacks: {
                //         play: () => {
                //             log.debug('MAIN PLAYER PLAY!');
                //             EventBus.$emit('index_items_stop_all_played', {'_uid':this._uid});
                //         },
                //         initialized: () => {
                //             //this.increaseMusicCount();
                //         }
                //     },
                //     waveforms: {
                //         sample_rate: 3000
                //     }
                // });
            },

            // 다운로드 증가
            increaseMusicCount(item) {
                Http.post( `/beatsomeoneApi/increase_music_count`,{cde_id:item.cde_id}).then(r=> {
                    if(!r) {
                        log.debug('카운트 증가 실패');
                    } else {
                        log.debug('카운트 증가 성공');
                        axios.get('/event/chkAchieve')
                          .then(res => {
                            if (res.data === 'achieve') {
                              alert(this.$t('lang154'))
                            }
                          })
                          .catch(error => {
                            console.error(error);
                          })
                    }
                });
            }
        },

    }

</script>

<style lang="css">
    .player {
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
