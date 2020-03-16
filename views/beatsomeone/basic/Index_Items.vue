<template>
    <li class="playList__itembox" :id="'playList__item'+ item.id">
        <div class="playList__item playList__item--title">
            <div class="col favorite">
                <button>즐겨찾기</button>
            </div>
            <div class="col name">
                <figure>
              <span class="playList__cover">
                <img
                        :src="item.coverImg"
                        alt=""
                />
                <i class="label new" ng-if="item.isNew">N</i>

              </span>
                    <figcaption class="pointer" @click="selectItem(item)">
                        <h3 class="playList__title">
                            {{ item.title }}
                        </h3>
                        <span class="playList__by">{{ item.singer }}</span>
                    </figcaption>
                </figure>

                <!-- 서브리스트 토글 버튼 -->
                <button class="toggle-subList" v-if="item.subPlayList.length > 0"></button>
            </div>
            <div class="col genre">
                <button v-for="genre in item.genres" :key="genre.title" :class="{'active' : genre.active }">{{
                    genre.title }}
                </button>
            </div>
            <div class="col playbtn">
                <button class="btn-play" @click="playAudio(item)" :data-action="'playAction' + item.id ">재생</button>
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
                        <button v-for="(genre,index) in playList.genres" :key="index"
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

    export default {
        props: ['item'],
        data: function () {
            return {
                audio: {},
            };
        },
        methods: {
            selectItem(i) {
                const path = `/detail?id=${i.id}`;
                if (this.$route.fullPath !== path) {
                    this.$router.push(path);
                }
                this.$log({
                    'this.$route.fullPath' : this.$route.fullPath,
                    'path' : path,
                });
            },
            playAudio(i) {
                this.$log({
                    i
                });
                if (!this.audio[i.id]) {
                    this.$nextTick(() => {
                        this.setAudioInstance(i);
                    });
                } else {
                    this.audio[i.id].playPause();
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
                this.audio[item.id] = window.WaveSurfer.create({
                    container: "#playList__item" + item.id + " .wave",
                    waveColor: "#696969",
                    progressColor: "#c3ac45",
                    hideScrollbar: true,
                    height: 90
                });
                this.audio[item.id].load(item.audioFile);
                this.audio[item.id].on("play", () => {
                    //console.log(this.audio[item.id].getCurrentTime());
                    document
                        .querySelector("#playList__item" + item.id)
                        .classList.add("playing");
                });
                this.audio[item.id].on("audioprocess", (e) => {
                    // 파일이 재생될때 계속 실행
                    document.querySelector(
                        "#playList__item" + item.id + " .current"
                    ).innerHTML = this.time_convert(parseInt(e, 10)) + " / ";
                });
                this.audio[item.id].on("ready", () => {
                    // 파일이 로드가 다 됐을때,
                    document.querySelector(
                        "#playList__item" + item.id + " .duration"
                    ).innerHTML = this.time_convert(parseInt(this.audio[item.id].getDuration(), 10));
                    this.audio[item.id].playPause();
                });
                this.audio[item.id].on("pause", () => {
                    //  var actionTarget = "playAction" + item.id;
                    document
                        .querySelector("#playList__item" + item.id)
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
