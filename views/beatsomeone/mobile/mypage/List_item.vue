<template>
    <div>
        <!-- PC용 통합검색 -->
        <!-- <div class="row" style="margin-bottom:10px;">
                <div class="search condition">
                    <div class="filter">
                        <div class="condition" :class="{ 'active': search_condition_active_idx === 1 }" @click="setSearchCondition(1)">{{$t('productName')}}</div>
                        <div class="condition" :class="{ 'active': search_condition_active_idx === 2 }" @click="setSearchCondition(2)">{{$t('productCode')}}</div>
                        <div class="condition" :class="{ 'active': search_condition_active_idx === 3 }" @click="setSearchCondition(3)">{{$t('keyword')}}</div>
                    </div>
                    <div class="wrap">
                        <input type="text" :placeholder="$t('searchingProduct')" @keypress.enter="goSearch">
                        <img src="/assets/images/icon/searchicon.png"/>
                    </div>
                </div>
        </div>-->

        <div class="row">
            <!-- <div class="tabmenu">
                      <div :class="{ 'active': search_tabmenu_idx === 1 }" @click="goTabMenu(1)">{{$t('totalQuantity')}} ({{calcTotalCnt}})</div>
                      <div :class="{ 'active': search_tabmenu_idx === 2 }" @click="goTabMenu(2)">{{$t('selling')}} ({{calcSellingCnt}})</div>
                      <div :class="{ 'active': search_tabmenu_idx === 3 }" @click="goTabMenu(3)">{{$t('pending')}} ({{calcPendingCnt}})</div>
            </div>-->
            <div>
                <div class="sort">
                    <div class="custom-select" :class="GMT == 1 ? 'active' : ''">
                        <button
                            class="selected-option"
                            @click.self="toggleGMT"
                        >{{ $t('genre') }} / {{ $t('mood') }} / {{ $t('trackType') }}
                        </button>
                        <div class="select-genre popup active">
                            <div class="tab">
                                <button :class="popup_filter == 0 ? 'active' : ''" @click="popup_filter = 0">
                                    {{ $t('genre') }}
                                    <div class="count">{{ selectedGenre.length }}</div>
                                </button>
                                <button :class="popup_filter == 1 ? 'active' : ''" @click="popup_filter = 1">
                                    {{ $t('mood') }}
                                    <div class="count">{{ selectedMood.length }}</div>
                                </button>
                                <button :class="popup_filter == 2 ? 'active' : ''" @click="popup_filter = 2">
                                    {{ $t('trackType') }}
                                    <div class="count">{{ selectedTrackType.length }}</div>
                                </button>
                            </div>
                            <div class="tab_container">
                                <div v-show="popup_filter === 0" class="tab_content active">
                                    <ul class="filter__list">
                                        <!-- All Check -->
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    hidden="hidden"
                                                    id="boolIdAllGenre"
                                                    v-model="boolAllGenre"
                                                    @change="funcAll('Genre', $event)"
                                                />
                                                <span></span>
                                                <div>All Genre</div>
                                            </label>
                                        </li>
                                        <li
                                            class="filter__item"
                                            v-for="(item, index) in listGenre"
                                            :key="'genre' + index"
                                        >
                                            <label :for="'genrefillter'+index" class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    hidden="hidden"
                                                    :id="'genrefillter'+index"
                                                    :value="item"
                                                    v-model="selectedGenre"
                                                />
                                                <span></span>
                                                <div>{{ item }}</div>
                                            </label>
                                        </li>
                                        <!--
                                            <li class="filter__item">
                                                <label for="fillter2" class="checkbox">
                                                    <input type="radio" name="filter" hidden="hidden" id="fillter2" value="Hip hop">
                                                    <span></span> Hip hop
                                                </label>
                                            </li>
                                        -->
                                    </ul>
                                </div>

                                <div v-show="popup_filter === 1" class="tab_content active">
                                    <ul class="filter__list">
                                        <!-- All Check -->
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    hidden="hidden"
                                                    id="boolIdAllMood"
                                                    v-model="boolAllMood"
                                                    @change="funcAll('Mood', $event)"
                                                />
                                                <span></span>
                                                <div>All Mood</div>
                                            </label>
                                        </li>

                                        <li
                                            class="filter__item"
                                            v-for="(item, index) in listMoods"
                                            :key="'mood' + index"
                                        >
                                            <label :for="'moodfillter'+index" class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    hidden="hidden"
                                                    :id="'moodfillter'+index"
                                                    :value="item"
                                                    v-model="selectedMood"
                                                />
                                                <span></span>
                                                <div>{{ item }}</div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                                <div v-show="popup_filter === 2" class="tab_content active">
                                    <ul class="filter__list">
                                        <!-- All Check -->
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    hidden="hidden"
                                                    id="boolIdAllTrackType"
                                                    v-model="boolAllTrackType"
                                                    @change="funcAll('TrackType', $event)"
                                                />
                                                <span></span>
                                                <div>All TrackType</div>
                                            </label>
                                        </li>

                                        <li
                                            class="filter__item"
                                            v-for="(item, index) in listTrackType"
                                            :key="'track' + index"
                                        >
                                            <label :for="'trackfillter'+index" class="checkbox">
                                                <input
                                                    type="checkbox"
                                                    hidden="hidden"
                                                    :id="'trackfillter'+index"
                                                    :value="item"
                                                    v-model="selectedTrackType"
                                                />
                                                <span></span>
                                                <div>{{ item }}</div>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="btnbox col">
                                    <button class="btn btn--gray" @click="goGMTBtn('Cancel')">{{ $t('cancel2') }}
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn--submit"
                                        @click="goGMTBtn('Apply')"
                                    >{{ $t('apply') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sort">
                    <div class="custom-select custom-select-dropdown">
                        <button class="selected-option">{{ dateType }}</button>
                        <div class="options">
                            <button
                                v-show="dateType === 'Launch Date'"
                                class="option"
                                @click="funcDateType('Register Date')"
                            >{{ $t('registerDate') }}
                            </button>
                            <button
                                v-show="dateType === 'Register Date'"
                                data-value
                                class="option"
                                @click="funcDateType('Launch Date')"
                            >{{ $t('launchDate') }}
                            </button>
                        </div>
                    </div>
                </div>
                <VueHotelDatepicker
                    class="search-date"
                    format="YYYY-MM-DD"
                    :placeholder="$t('startDate') + ' ~ ' + $t('endDate')"
                    :startDate="start_date"
                    :endDate="end_date"
                    minDate="1970-01-01"
                    @update="updateSearchDate"
                    @reset="resetSearchDate"
                />
            </div>
        </div>

        <div class="row">
            <div class="playList productList">
                <div v-if="!showDelete" class="no-text">
                    <p>{{ msgEmptyCart }}</p>
                </div>
                <ul>
                    <li
                        v-for="(item, i) in paging()"
                        v-bind:key="item.cde_id"
                        class="playList__itembox"
                        :id="'playList__item'+ item.cit_id"
                    >
                        <!-- 2가지 동시에 있는경우 other클래스 추가. -->
                        <div class="playList__item other">
                            <div class="row">
                                <div class="col index">{{ calcSeq(myProduct_list.length, i) }}</div>
                                <div class="col code">{{ item.cit_key }}</div>
                                <!-- <div class="price" style="color: #ffda2a">{{ formatPrice(item.detail.LEASE.cde_price, item.detail.LEASE.cde_price_d, true) }}</div> -->
                            </div>

                            <div class="row">
                                <div class="col playList__cover">
                                    <img v-if="!item.cit_file_1" :src="'/assets/images/cover_default.png'" alt/>
                                    <img v-else :src="'/uploads/cmallitem/' + item.cit_file_1" alt/>
                                    <i v-show="checkToday(item.cit_datetime)" class="label new">N</i>
                                </div>

                                <div class="col pointer">
                                    <h3 class="playList__title" v-html="truncate(item.cit_name,20)" style="font-weight: 300"></h3>
                                </div>

                                <!-- Comment -->
                                <div class="col edit">
                                   
                                    <button @click="productEditBtn(item.cit_id)" class="btn-edit">
                                        <img src="/assets/images/icon/edit.png"/>
                                    </button>
                                </div>
                            </div>
                            <div class="col n-option">
                                <!-- Option -->
                                <div class="option" v-if="item.detail.LEASE && item.cit_lease_license_use === '1'">
                                    <!-- BASIC LEASE LICENSE -->
                                    <!-- UNLIMITED STEMS LICENSE -->
                                    <div
                                        class="n-box"
                                    >
                                        <div class="feature">
                                            <!-- <div class="listen">
                                                <div class="playbtn">
                                                    <button
                                                        class="btn-play"
                                                        @click="playAudio(item, $event)"
                                                        :data-action="'playAction' + item.cit_id "
                                                    >재생
                                                    </button>
                                                    <span class="timer">
                                                        <span class="current">0:00 /</span>
                                                        <span class="duration">0:00</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div
                                                class="amount"
                                            >
                                                <img src="/assets/images/icon/cd.png"/>
                                                <div>
                                                    <span>{{ item.detail.LEASE.cde_quantity }}</span>
                                                    {{ $t('left') }}
                                                </div>
                                            </div> -->
                                            
                                        </div>
                                        <div>
                                            <button class="playList__item--button">
                                                <span class="option_fold">
                                                <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/>
                                                </span>
                                                <div>
                                                    <div class="title" style="margin-bottom: 3px" @click.self="toggleButton">{{ $t('lang23') }}
                                                    </div>
                                                    <p style="margin-top: 3px">{{ $t('lang24') }}</p>
                                                </div>
                                                <div class="price" style="color: #ffda2a">{{ formatPrice(item.detail.LEASE.cde_price, item.detail.LEASE.cde_price_d, true) }}</div>
                                                <!-- <div class="price">{{ formatPrice(item.cde_price, item.cde_price_d, true) }}</div> -->
                                            </button>
                                            <ParchaseComponent :item="item" :type="'basic'"></ParchaseComponent>
                                        </div>
                                    </div>
                                    <!-- BASIC LEASE LICENSE -->
                                    <!-- UNLIMITED STEMS LICENSE -->
                                </div>
                                <div class="option" v-if="item.detail.STEM && item.cit_mastering_license_use === '1'">
                                    <div
                                        class="n-box"
                                    >
                                        <div class="feature">
                                            <!-- <div class="listen">
                                                <div class="playbtn">
                                                    <button
                                                        class="btn-play"
                                                        @click="playAudio(item, $event)"
                                                        :data-action="'playAction' + item.cit_id "
                                                    >재생
                                                    </button>
                                                    <span class="timer">
                                                        <span data-v-27fa6da0 class="current">0:00 /</span>
                                                        <span class="duration">0:00</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="amount">
                                                <img src="/assets/images/icon/cd.png"/>
                                                <div>
                                                    <span>{{ item.detail.STEM.cde_quantity }}</span>
                                                    {{ $t('left') }}
                                                </div>
                                            </div> -->
                                              
                                            <!-- <div class="price">{{ formatPrice(item.detail.STEM.cde_price, item.detail.STEM.cde_price_d, true) }}</div> -->
                                        </div>
                                        <div>
                                            <button class="playList__item--button">
                                                <span class="option_fold">
                                                    <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/>
                                                </span>
                                                <div>
                                                    <div class="title" @click.self="toggleButton">
                                                        {{ $t('lang30') }}

                                                    </div>
                                                    <p class="detail">{{ $t('lang15') }}<span class="copytransfer" v-if="item.cit_include_copyright_transfer === '1'">{{ $t('lang32') }}</span></p>
                                                </div>
                                                <div class="price" style="color: #ffda2a">{{ formatPrice(item.detail.STEM.cde_price, item.detail.STEM.cde_price_d, true) }}</div>
                                            </button>
                                            <ParchaseComponent :item="item" :type="'mastering'"></ParchaseComponent>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tag -->
                            <div class="col genre" v-html="calcTag(item.hashTag)"></div>
                        </div>
                    </li>
                </ul>
                <div class="row" style="margin-bottom:30px;">
                    <div class="pagination">
                        <div>
                            <button class="prev active" @click="prevPage">
                                <img src="/assets/images/icon/chevron_prev.png"/>
                            </button>

                            <button
                                v-for="n in makePageList()"
                                v-bind:key="n"
                                :class="{ 'active': currPage === n }"
                                @click="currPage = n"
                            >{{ n }}
                            </button>
                            <button class="next active" @click="nextPage">
                                <img src="/assets/images/icon/chevron_next.png"/>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="playerContainer" class="hidden"></div>
            </div>
        </div>
        <main-player></main-player>
    </div>
</template>

<script>
import {EventBus} from "*/src/eventbus";
import moment from "moment";
import axios from "axios";
import WaveSurfer from "wavesurfer.js";
import $ from "jquery";
import VueHotelDatepicker from "@northwalker/vue-hotel-datepicker";
import MainPlayer from "@/vue/common/MainPlayer";
import ParchaseComponent from "./component/Parchase";

export default {
    components: {
        VueHotelDatepicker,
        MainPlayer,
        ParchaseComponent,
    },
    data: function () {
        return {
            isLogin: false,
            isLoading: false,
            myProduct_list: [],
            isPlay: false,
            currentPlayId: null,
            wavesurfer: null,
            mem_photo: "",
            mem_usertype: "",
            mem_nickname: "",
            mem_address1: "",
            mem_type: "",
            mem_lastname: "",
            search_condition_active_idx: 1,
            search_tabmenu_idx: 1,
            GMT: 0,
            popup_filter: 0,
            search_date_option: 0,
            start_date: "",
            end_date: "",
            calcTotalCnt: 0,
            calcSellingCnt: 0,
            calcPendingCnt: 0,
            listGenre: window.genre,
            listMoods: window.moods,
            listTrackType: window.trackType,
            selectedGenre: [],
            selectedMood: [],
            selectedTrackType: [],
            dateType: "Register Date",
            totalpage: 0,
            currPage: 1,
            perPage: 10,
            showDelete: false,
            msgEmptyCart: "There is no registered product.",
            boolAllGenre: false,
            boolAllMood: false,
            boolAllTrackType: false,
        };
    },
    mounted() {
        // 커스텀 셀렉트 옵션
        $(".custom-select-dropdown").on("click", function () {
            $(this)
                .siblings(".custom-select-dropdown")
                .removeClass("active")
                .find(".options")
                .hide();
            if ($(this).hasClass("active")) {
                $(this).addClass("active");
                $(this).find(".options").show();
            } else {
                $(this).removeClass("active");
                $(this).find(".options").hide();
            }
            /*
                      $(this).toggleClass("active");
                      $(this)
                          .find(".options")
                          .toggle();
                          */
        });
        EventBus.$on("main_player_play", (r) => {
            this.start();
        });
        EventBus.$on("main_player_stop", (r) => {
            this.stop();
        });
    },
    created() {
        this.ajaxItemList().then(() => {
            this.calcTotalCnt = this.calcFuncTotalCnt();
            this.calcSellingCnt = this.calcFuncSellingCnt();
            this.calcPendingCnt = this.calcFuncPendingCnt();
        });
    },
    methods: {
        async ajaxItemList() {
            try {
                this.isLoading = true;
                const {data} = await axios.get(
                    "/beatsomeoneApi/get_user_regist_item_list",
                    {}
                );

                this.myProduct_list = data;
                if (this.myProduct_list.length == 0) {
                    this.showDelete = false;
                    this.totalpage = 1;
                } else {
                    this.showDelete = true;
                    this.totalpage = Math.ceil(this.myProduct_list.length / this.perPage);
                }
            } catch (err) {
                console.log("ajaxItemList error");
            } finally {
                this.isLoading = false;
            }
        },
        paging() {
            let list = [];
            Object.assign(list, this.myProduct_list);
            if (this.myProduct_list.length == 0) {
                this.totalpage = 1;
            } else {
                this.totalpage = Math.ceil(this.myProduct_list.length / this.perPage);
            }
            return list.slice(
                (this.currPage - 1) * this.perPage,
                this.currPage * this.perPage
            );
        },
        prevPage: function () {
            if (this.currPage == 1) return;
            this.currPage -= 1;
        },
        nextPage: function () {
            if (this.currPage == this.totalpage) return;
            this.currPage += 1;
        },
        makePageList() {
          let pagination = [],
              startPage = this.currPage - 2,
              endPage = this.currPage + 2

          if (startPage < 1) {
            endPage += 1 - startPage
            startPage = 1
          }
          endPage = (endPage > this.totalpage) ? this.totalpage : endPage

          for (let iLoop = startPage; iLoop <= endPage; iLoop++) {
            pagination.push(iLoop)
          }

          return pagination
        },
        setPopupFilter: function (idx) {
            this.popup_filter = idx;
        },
        goPage: function (page) {
            window.location.href = this.helper.langUrl(this.$i18n.locale, "/mypage/" + page);
        },
        goSearch: function (e) {
            this.ajaxItemList().then(() => {
                let list = [];
                Object.assign(list, this.myProduct_list);
                if (this.search_condition_active_idx == 1) {
                    let rst = list.filter((item) =>
                        item.cit_name.includes(e.target.value)
                    );
                    this.myProduct_list = rst;
                } else if (this.search_condition_active_idx == 2) {
                    let rst = list.filter((item) =>
                        item.cit_key.includes(e.target.value)
                    );
                    this.myProduct_list = rst;
                } else if (this.search_condition_active_idx == 3) {
                    let rst = list.filter((item) =>
                        item.hashTag.includes(e.target.value)
                    );
                    this.myProduct_list = rst;
                }
            });
        },
        callbackdateime: function (val) {
            let s = moment(this.start_date);
            let e = moment(this.end_date);
            let t = moment(val.cit_datetime.substr(0, 10));
            if (s.diff(t) <= 0 && 0 <= e.diff(t)) {
                return true;
            } else {
                return false;
            }
        },
        callbackstartdateime: function (val) {
            let s = moment(this.start_date);
            let e = moment(this.end_date);
            let t = moment(val.cit_start_datetime.substr(0, 10));
            if (s.diff(t) <= 0 && 0 <= e.diff(t)) {
                return true;
            } else {
                return false;
            }
        },
        goSearchDate: function () {
            this.ajaxItemList().then(() => {
                let list = [];
                Object.assign(list, this.myProduct_list);
                if (this.isEmpty(this.start_date) || this.isEmpty(this.end_date)) {
                    this.myProduct_list = list;
                } else if (this.search_date_option == 0) {
                    let rst = list.filter(this.callbackdateime);
                    this.myProduct_list = rst;
                } else if (this.search_date_option == 1) {
                    let rst = list.filter(this.callbackstartdateime);
                    this.myProduct_list = rst;
                }
                this.calcTotalCnt = this.calcFuncTotalCnt();
                this.calcSellingCnt = this.calcFuncSellingCnt();
                this.calcPendingCnt = this.calcFuncPendingCnt();
            });
        },
        goTabMenu: function (menu) {
            this.ajaxItemList().then(() => {
                let list = [];
                Object.assign(list, this.myProduct_list);
                if (menu == 1) {
                    this.myProduct_list = list;
                    this.search_tabmenu_idx = 1;
                } else if (menu == 2) {
                    let rst = list.filter((item) => item.cit_status === "1");
                    this.myProduct_list = rst;
                    this.search_tabmenu_idx = 2;
                } else if (menu == 3) {
                    let rst = list.filter((item) => item.cit_status === "0");
                    this.myProduct_list = rst;
                    this.search_tabmenu_idx = 3;
                }
            });
        },
        toggleGMT: function () {
            if (this.GMT == 1) {
                this.GMT = 0;
            } else {
                this.GMT = 1;
            }
            this.$nextTick(() => {
                console.log(this.GMT);
            });
        },
        toggleButton: function (e) {
            if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box active";
            } else if (
                e.target.parentElement.parentElement.parentElement.parentElement
                    .className == "n-box active"
            ) {
                e.target.parentElement.parentElement.parentElement.parentElement.className =
                    "n-box";
            } else {
                //
            }
        },
        checkInclude: function (g, sg, m, t) {
            if (0 < this.selectedGenre.length) {
                if (this.selectedGenre.length == 1) {
                    if (this.selectedGenre.includes(g) || this.selectedGenre.includes(sg))
                        return true;
                } else {
                    for (var i in this.selectedGenre) {
                        if (
                            this.selectedGenre[i].includes(g) ||
                            this.selectedGenre[i].includes(sg)
                        )
                            return true;
                    }
                }
            }
            if (0 < this.selectedMood.length) {
                if (this.selectedMood.includes(m)) return true;
            }
            if (0 < this.selectedTrackType.length) {
                if (this.selectedTrackType.includes(t)) return true;
            }
            return false;
        },
        goGMTBtn: function (type) {
            if (type == "Apply") {
                this.ajaxItemList().then(() => {
                    let list = [];
                    let rst = [];
                    Object.assign(list, this.myProduct_list);
                    rst = list.filter((item) =>
                        this.checkInclude(
                            item.genre,
                            item.subgenre,
                            item.moods,
                            item.trackType
                        )
                    );
                    this.myProduct_list = rst;
                });
            } else if (type == "Cancel") {
                this.selectedGenre = [];
                this.selectedMood = [];
                this.selectedTrackType = [];
                this.boolAllGenre = false;
                this.boolAllMood = false;
                this.boolAllTrackType = false;
                this.ajaxItemList();
            }
            this.GMT = 0;
        },
        goStartDate: function (e) {
            this.start_date = e.target.value;

            if (this.start_date == "" || this.end_date == "") {
                return;
            } else {
                this.goSearchDate();
            }
        },
        goEndDate: function (e) {
            this.end_date = e.target.value;

            if (this.start_date == "" || this.end_date == "") {
                return;
            } else {
                this.goSearchDate();
            }
        },

        calcSeq: function (size, i) {
            return parseInt(size) - (this.currPage - 1) * this.perPage - parseInt(i);
        },
        removeReg: function (val) {
            const regExp = /[~!@#$%^&*()_+|'"<>?:{}]/;
            while (regExp.test(val)) {
                val = val.replace(regExp, "");
            }
            return val;
        },
        calcTag: function (hashTag) {
            if (hashTag==null) return
            let rst = "";
            let tags = hashTag.split(",");
            for (let i in tags) {
                rst =
                    rst +
                    "<span><button >" +
                    this.removeReg(tags[i]) +
                    "</button></span>";
            }
            return rst;
        },
        calcFuncTotalCnt() {
            return this.myProduct_list.length;
        },
        calcFuncSellingCnt() {
            let list = [];
            Object.assign(list, this.myProduct_list);
            let rst = list.filter((item) => item.cit_status === "1");
            return rst.length;
        },
        calcFuncPendingCnt() {
            let list = [];
            Object.assign(list, this.myProduct_list);
            let rst = list.filter((item) => item.cit_status === "0");
            return rst.length;
        },
        setSearchCondition: function (idx) {
            this.search_condition_active_idx = idx;
        },
        checkToday: function (date) {
            const input = new Date(date);
            const today = new Date();
            return (
                input.getDate() === today.getDate() &&
                input.getMonth() === today.getMonth() &&
                input.getFullYear() === today.getFullYear()
            );
        },
        funcDateType: function (t) {
            if (this.dateType == t) {
                return;
            } else {
                if (t === "Register Date") {
                    this.search_date_option = 0;
                    this.dateType = t;
                } else {
                    this.search_date_option = 1;
                    this.dateType = t;
                }
            }
        },
        formatPrice: function (kr, en, simbol) {
            if (!simbol) {
                if (this.$i18n.locale === "ko") {
                  return kr;
                } else {
                  return en;
                }
            }
            if (this.$i18n.locale === "ko") {
              return (
                  "₩ " +
                  Number(kr).toLocaleString("ko-KR", {minimumFractionDigits: 0})
              );
            } else {
              return (
                  "$ " +
                  Number(en).toLocaleString(undefined, {minimumFractionDigits: 2})
              );
            }
        },
        formatCitName: function (data, limitLth) {
            let rst;
            if (limitLth < data.length && data.length <= limitLth * 2) {
                rst =
                    data.substring(0, limitLth) +
                    "<br/>" +
                    data.substring(limitLth, limitLth * 2);
            } else if (limitLth < data.length && limitLth * 2 < data.length) {
                rst =
                    data.substring(0, limitLth) +
                    "<br/>" +
                    data.substring(limitLth, limitLth * 2) +
                    "...";
            } else {
                rst = data;
            }
            return rst;
        },
        productEditBtn: function (key) {
            window.location.href = this.helper.langUrl(this.$i18n.locale, "/mypage/regist_item/" + key);
        },
        isEmpty: function (str) {
            if (typeof str == "undefined" || str == null || str == "") return true;
            else return false;
        },
        updateSearchDate(date) {
            if (this.isEmpty(date.start) || this.isEmpty(date.end)) {
                this.goSearchDate();
            } else {
                this.start_date = date.start;
                this.end_date = date.end;
                this.goSearchDate();
            }
        },
        resetSearchDate(date) {
            this.start_date = "";
            this.end_date = "";
            this.goSearchDate();
        },
        playAudio(i, e) {
            if (!this.isPlay || this.currentPlayId !== i.cit_id) {
                if (this.currentPlayId !== i.cit_id) {
                    this.setAudioInstance(i);
                }
                this.currentPlayId = i.cit_id;
                EventBus.$emit("player_request_start", {
                    _uid: this._uid,
                    item: i,
                    ws: this.wavesurfer,
                });
                e.target.className = "btn-play playing";
                this.start();
            } else {
                EventBus.$emit("player_request_stop", {
                    _uid: this._uid,
                    item: i,
                    ws: this.wavesurfer,
                });
                e.target.className = "btn-play paused";
                this.stop();
            }
        },
        setAudioInstance(item) {
            if (!this.wavesurfer) {
                this.wavesurfer = WaveSurfer.create({
                    container: "#playerContainer",
                    waveColor: "#696969",
                    progressColor: "#c3ac45",
                    hideScrollbar: true,
                    height: 40,
                });
            }

            if (item.detail.PREVIEW) {
                this.wavesurfer.load(
                    `/cmallact/download_sample/${item.detail.PREVIEW.cde_id}`
                );
            }

            this.wavesurfer.on("ready", () => {
                this.wavesurfer.play();
            });
        },
        stop() {
            if (this.wavesurfer) {
                this.wavesurfer.pause();
            }
            this.isPlay = false;
        },
        start(isInit) {
            if (this.wavesurfer) {
                this.wavesurfer.play();
            }
            if (!isInit) {
                this.isPlay = true;
            }
        },
        funcAll(t, e) {
            if (t == "Genre") {
                if (this.boolAllGenre) {
                    for (let g in this.listGenre) {
                        this.selectedGenre.push(this.listGenre[g]);
                    }
                } else {
                    this.selectedGenre = [];
                }
            } else if (t == "Mood") {
                if (this.boolAllMood) {
                    for (let m in this.listMoods) {
                        this.selectedMood.push(this.listMoods[m]);
                    }
                } else {
                    this.selectedMood = [];
                }
            } else {
                if (this.boolAllTrackType) {
                    for (let m in this.listTrackType) {
                        this.selectedTrackType.push(this.listTrackType[m]);
                    }
                } else {
                    this.selectedTrackType = [];
                }
            }
        },
        truncate(str, n) {
            return (str.length > n) ? str.substr(0, n-1) + '...' : str;
        },
    },
};
</script>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";
</style>