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
                <button>
                    more
                </button>
            </div>
        </div>
    </li>

</template>


<script>

    import { EventBus } from '*/src/eventbus';



    export default {
        props: ['item'],
        data: function () {
            return {
                listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                audio: {},
            };
        },
        methods: {
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
                this.$log({
                    i
                });
                if (!this.audio[i.cit_id]) {
                    this.$nextTick(() => {
                        this.setAudioInstance(i);
                    });
                } else {
                    this.audio[i.cit_id].playPause();
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
                this.audio[item.cit_id] = window.WaveSurfer.create({
                    container: "#playList__item" + item.cit_id + " .wave",
                    waveColor: "#696969",
                    progressColor: "#c3ac45",
                    hideScrollbar: true,
                    height: 90
                });
                this.audio[item.cit_id].load(`/cmallact/download_sample/${item.cde_id}`);
                this.audio[item.cit_id].on("play", () => {
                    //console.log(this.audio[item.id].getCurrentTime());
                    document
                        .querySelector("#playList__item" + item.cit_id)
                        .classList.add("playing");
                });

                this.audio[item.cit_id].on("ready", () => {
                    // 파일이 로드가 다 됐을때,
                    this.audio[item.cit_id].playPause();
                });
                this.audio[item.cit_id].on("pause", () => {
                    //  var actionTarget = "playAction" + item.id;
                    document
                        .querySelector("#playList__item" + item.cit_id)
                        .classList.remove("playing");
                });

                // var actionName = "playAction" + item.id;
                // _GLOBAL_ACTIONS[actionName] = audio;
            },
        }
    }

</script>

<style scoped="scoped">

</style>
