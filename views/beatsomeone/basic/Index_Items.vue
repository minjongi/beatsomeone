<template>
    <li v-if="item" class="playList__itembox" :id="'playList__item'+ item.cit_id">
<!--        <div>-->
<!--            {{ item }}-->
<!--        </div>-->
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
              <span class="current"></span>
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
        <!-- 서브 앨범들 -->
        <ul class="subPlayList">
            <li v-for="playList in item.subPlayList" :key="playList.id" :id="'playList__item'+ playList.id "
                class="playList__itembox">
                <div class="playList__item playList__item--sub" id="">
                    <div class="col favorite">
                        <button>즐겨찾기</button>
                    </div>
                    <div class="col name">
                        <figure>
                  <span class="playList__cover">
                    <img
                            :src="playList.coverImg"
                            alt=""
                    />

                    <i class="label new" v-if="playList.isNew">N</i>

                  </span>
                            <figcaption class="pointer" @click="selectItem(playList)">
                                <h3 class="">
                                    {{ playList.title }}
                                </h3>
                                <span class="playList__by">{{ playList.singer }}</span>
                            </figcaption>
                        </figure>
                    </div>
                    <div class="col genre">
                        <button v-for="(genre,index) in hashtag" :key="index"
                                :class="{'active' : genre.active }">{{ genre.title }}
                        </button>
                    </div>
                    <div class="col playbtn">
                        <button class="btn-play" @click="playAudio(playList)" :data-action="'playAction' + playList.id">
                            재생
                        </button>
                        <span class="timer">
                  <span class="current"></span>
                  <span class="duration">0:00</span>
                </span>
                    </div>
                    <div class="col spectrum">
                        <div class="wave"></div>
                    </div>
                    <div class="col utils">
                        <a href="" class="cart">
                            장바구니
                            <span class="tooltip">$20.00</span>
                        </a>
                        <a href="" class="download">다운로드</a>
                        <a href="" class="shared">공유하기</a>
                    </div>
                    <div class="col more">
                        <button>more</button>
                        <span class="tooltip">$20.00</span>
                    </div>
                </div>
            </li>

        </ul>
    </li>
</template>


<script>

    import { EventBus } from '*/src/eventbus';



    export default {
        props: ['item'],
        data: function () {
            return {
                //listGenre: ['Hip Hop','Pop','R&B','ROCK','Electronic','Reggae','Country','World','K-Pop'],
                audio: {},
            };
        },
        computed: {
            hashtag() {
                return this.item.hashTag ? this.item.hashTag.split(' ') : '';
            },
        },
        mounted() {
            EventBus.$on('index_items_stop_all_played',r=> {
                if(this._uid !== r) {
                    // log.debug({
                    //     'index_items_stop_all_played':this.audio[this.item.cit_id],
                    // })
                    if(this.audio[this.item.cit_id]) {
                        this.audio[this.item.cit_id].pause();
                    }

                }
            });
        },
        methods: {
            toggleWish() {
                Http.post( `/beatsomeoneApi/toggle_wish_item/${this.item.cit_id}`).then(r=> {
                    if(r === true) {
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
                // this.$log({
                //     i
                // });
                EventBus.$emit('index_items_stop_all_played',this._uid);
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
                    EventBus.$emit('index_items_stop_all_played',this._uid);
                    document
                        .querySelector("#playList__item" + item.cit_id)
                        .classList.add("playing");
                });
                this.audio[item.cit_id].on("audioprocess", (e) => {
                    // 파일이 재생될때 계속 실행
                    document.querySelector(
                        "#playList__item" + item.cit_id + " .current"
                    ).innerHTML = this.time_convert(parseInt(e, 10)) + " / ";
                });
                this.audio[item.cit_id].on("ready", () => {
                    // 파일이 로드가 다 됐을때,
                    document.querySelector(
                        "#playList__item" + item.cit_id + " .duration"
                    ).innerHTML = this.time_convert(parseInt(this.audio[item.cit_id].getDuration(), 10));
                    this.increaseMusicCount();
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
            // 다운로드 증가
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
