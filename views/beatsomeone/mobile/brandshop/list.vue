<template>

  <div class="wrapper">
    <div class="brand-section">
      <Header :is-login="isLogin"/>
      <div class="container sub">
        <div class="title"><div>BRAND SHOP</div></div>
        <div class="brand-logo-section">
          <div v-for="(item,index) in brandList" :key="index" class="brand-logo-item" style="margin-right:10px;"> 
            <a v-bind:href ="item.ban_url" v-bind:target="item.ban_target"><img :src="item.thumb_url" :style="bannerStyle(item)" style="max-width: none !important;"></a>
          </div>
        </div>
        <div class="search">
            <div style="position: relative;">
                <input type="text" v-model="searchText" @keyup.enter="search"/>
                <button @click="search"></button>
            </div>
        </div>
      </div>
    </div>
    <div class="filter-section">
      <div class="filter-alpa">
        <div style="padding: 0 10px; border-right: 1px solid #525252;">
          <div v-for="(item, index) in selectAlBe" :key="index" >
            <div v-if="index <=12" class="select-item" :class="item==selectAl?'select-item-click':''" @click="selectCapital(item, index)">{{item}}</div>
          </div>
        </div>
        <div style="padding: 0 20px 0 10px">
           <div v-for="(item, index) in selectAlBe" :key="index" >
              <div v-if="index >12" class="select-item" :class="item==selectAl?'select-item-click':''" @click="selectCapital(item, index)">{{item}}</div>
          </div>
        </div>
       
      </div>
      <div v-for="(item,index1) in showSelectAlBe" :key="index1">
        <div v-if="showNewMemberList[index1].length != 0" class="filter-content">
          <div class="filter-result" >
              <div class="filter-result-col2 filter-result-alpa">
                {{item}}
              </div>
              <div class="filter-result-row">
                <div v-for ="(member, index) in showNewMemberList[index1]" :key="index" class="filter-result-row3" style="cursor:pointer">
                  <!-- <div class="filter-result-item content truncate-overflow">{{member.mem_nickname}}</div> -->
                  <a  class="filter-result-item content truncate-overflow" :href="helper.langUrl($i18n.locale, '/brandshop/' + member.mem_nickname)">{{member.mem_nickname}}</a>
                  <div class="filter-result-item-name">{{member.mem_address1}}</div>
                </div>
              </div> 
            
          </div>
        </div>
      </div>
      
      <div>
        <button class="button-top" @click="movePageTop">
          <i class="fa fa-arrow-up"></i> TOP
        </button>
      </div>
    </div>
      <main-player></main-player>
      <Footer/>
  </div>
</template>

<script>
import $ from "jquery";
require("@/assets/js/function");
import Header from "../include/Header";
import Footer from "../include/Footer";
import Index_Items from "../Index_Items";
import { EventBus } from "*/src/eventbus";
import Velocity from "velocity-animate";
import Loader from "*/vue/common/Loader";
import MainPlayer from "@/vue/common/MainPlayer";
import KeepAliveGlobal from "vue-keep-alive-global";
import _ from "lodash";
export default {
  components: {
    Header,
    Footer,
    Index_Items,
    Loader,
    MainPlayer,
    KeepAliveGlobal,
  },
  data: function () {
    return {
      isLogin: false,
      listSort: window.sortItem,
      listFilter: ["All Genre"].concat(window.genre), // .concat(["Free Beats"])
      listSubgenres: ["All"].concat(window.genre), // .concat(["Free Beats"])
      listMoods: ["All"].concat(window.moods),
      listTrackType: ["All types"].concat(window.trackType),
      list: [],
      listTop5: null,
      randomList: [],
      offset: 0,
      last_offset: null,
      selectAl: "All",
      busy: false,
      searchText: "",
      selectAlBe:['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'],
      showSelectAlBe: [],
      param: {
        currentGenre: null,
        currentSubgenres: null,
        currentMoods: null,
        currentTrackType: null,
        currentBpmFr: 0,
        currentBpmTo: 120,
        search: null,
        sort: "Sort By",
      },
      brandList:[],
      brand: {
        mem_id: '',
        mem_userid: '',
        mem_username: '',
        mem_nickname: '',
      },
      newMemberList:[],
      searchTextList: []
    };
  },
  
  created() {
    this.param.currentGenre = this.listFilter[0];
    this.param.currentSubgenres = this.listSubgenres[0];
    this.param.currentMoods = this.listMoods[0];
    this.param.currentTrackType = this.listTrackType[0];
    this.getBannerList();
    this.getList();
  },
  mounted() {
    $(".filter__title").on("click", function () {
      $(this).toggleClass("folded");
      $(this).siblings(".filter__content").stop().slideToggle();
    });

    // BPM range
    if ($(".bpmRange").length) {
      $(".bpmRange input").ionRangeSlider({
        skin: "round",
        type: "double",
        min: 0,
        max: 170,
        from: 0,
        to: 0,
        onStart: (data) => {
          // log.debug({
          //     'rpm onStart':data,
          // })
          $("#bpm-start").val(data.from);
          $("#bpm-end").val(data.to);
          this.param.currentBpmFr = data.from;
          this.param.currentBpmTo = data.to;
        },
        onChange: (data) => {
          // log.debug({
          //   'rpm onChange':data,
          // })
          $("#bpm-start").val(data.from_pretty);
          $("#bpm-end").val(data.to_pretty);
          this.param.currentBpmFr = data.from_pretty;
          this.param.currentBpmTo = data.to_pretty;
        },
      });
    }
    
    // 커스텀 셀렉트 옵션
    $(".custom-select").on("click", function () {
      $(this)
          .siblings(".custom-select")
          .removeClass("active")
          .find(".options")
          .hide();
      $(this).toggleClass("active");
      $(this).find(".options").toggle();
    });

    //this.onScroll();
  },
  computed: {
    listSortParamName() {
      return this.listSortName[this.listSort.indexOf(this.param.sort)];
    },
    listSortName() {
      let list = [],
          _self = this;

      this.listSort.forEach(function (val) {
        list.push(_self.$t("sortItem" + window.genLangCode(val)));
      });

      return list;
    },
    listFilterName() {
      let list = [],
          _self = this;

      this.listFilter.forEach(function (val) {
        list.push(_self.$t("genre" + window.genLangCode(val)));
      });

      return list;
    },
    listSubgenresName() {
      let list = [],
          _self = this;

      this.listSubgenres.forEach(function (val) {
        list.push(_self.$t("genre" + window.genLangCode(val)));
      });

      return list;
    },
    listMoodsName() {
      let list = [],
          _self = this;

      this.listMoods.forEach(function (val) {
        list.push(_self.$t("moods" + window.genLangCode(val)));
      });

      return list;
    },
    listTrackTypeName() {
      let list = [],
          _self = this;

      this.listTrackType.forEach(function (val) {
        list.push(_self.$t("trackType" + window.genLangCode(val)));
      });

      return list;
    },
  },
  methods: {
    
    getList() {
      const p = {
        search_text: this.searchText,
      };
      Http.post(`/beatsomeoneApi/register_member`, p).then((r) => {
        let tempMemberLIst = r
          for (let i=0; i<this.selectAlBe.length; i++){
            this.newMemberList[i] = []
            Object.keys(tempMemberLIst).map(item=>{
              if (tempMemberLIst[item].mem_nickname.charAt(0) == (this.selectAlBe[i]).toLowerCase()) { 
                this.newMemberList[i].push(tempMemberLIst[item]);
              }
            })
          }
          this.showNewMemberList = _.cloneDeep(this.newMemberList);
          this.showSelectAlBe = _.cloneDeep(this.selectAlBe);
      });
    },

    getBannerList() {
      const p = {
        ban_device:'mobile',
        limit: 10
      };
      Http.post(`/beatsomeoneApi/banner_list`, p).then((r) => {
        this.brandList = _.cloneDeep(r);
      });
    },
    search(){
      let kk = 0
      let flag 
      let tempNewMemberList = []
      this.showNewMemberList = _.cloneDeep(this.newMemberList)
      this.searchTextList = this.searchText.split(' ');

      for (let i=0; i<this.showNewMemberList.length; i++){
        if ( this.showNewMemberList[i].length != 0){
          for (let j=0; j<this.showNewMemberList[i].length; j++){
             flag = true
            for (let k=0; k<this.searchTextList.length; k++){
              kk =  this.showNewMemberList[i][j].mem_nickname.indexOf(this.searchTextList[k]);
              if (kk >= 0){flag = false}
            }
            if (flag){
              this.showNewMemberList[i].splice(j, 1);   
              
            } 
          }
        }
      }
      
      this.showNewMemberList = _.cloneDeep(this.showNewMemberList)
      this.showSelectAlBe = _.cloneDeep(this.selectAlBe);
    },
    beforeEnter: function (el) {
      el.style.opacity = 0;
      el.style.height = 0;
    },
    enter: function (el, done) {
      var delay = el.dataset.index * 150;
      setTimeout(function () {
        Velocity(
            el,
            { opacity: 1, height: 90, "margin-bottom": 1 },
            { complete: done }
        );
      }, delay);
    },
    leave: function (el, done) {
      var delay = el.dataset.index * 150;
      setTimeout(function () {
        Velocity(
            el,
            { opacity: 0, height: 0, "margin-bottom": 0 },

            { complete: done }
        );
      }, delay);
    },
    selectCapital(item, index){
      this.selectAl = item
       this.showNewMemberList = [];
       this.showSelectAlBe = []
      if (item == 'All'){
        this.showNewMemberList = _.cloneDeep(this.newMemberList);
        this.showSelectAlBe = _.cloneDeep(this.selectAlBe);
      }else{
        this.showNewMemberList[0] = _.cloneDeep(this.newMemberList[index]);
        this.showSelectAlBe[0] = _.cloneDeep(this.selectAlBe[index]); 
      }
      
    },
    movePageTop(){
      window.scrollTo(0, 0)
    },
    bannerStyle(item){
      console.log('this is item___________!!!', item);
      item.ban_width=='' ||  item.ban_width==0?item.ban_width ="100%":item.ban_width;
      item.ban_height=='' ||  item.ban_height==0?item.ban_height ="100%":item.ban_height;
      return "width:"+item.ban_width+"px; " +"height:"+item.ban_height+"px;";
    }
  },
};
</script>

<style lang="scss">
@import '@/assets_m/scss/App.scss';
@import "~swiper/swiper.scss";
</style>

<style lang="css">
@import '/assets/plugins/slick/slick.css';
@import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';

.playList .playList__item {
  display: flex !important;
}

</style>

<style scope="scope" lang="scss" >

html, body {
  background: #111214;
}

.sub .playList .playList__item > div {
  margin-bottom: 0 !important;
}


.brand-section{
  
  background-image:url('/assets/images/banner/bannershop.png');
  background-size: cover;
  background-repeat: no-repeat;
  border-bottom: 1px solid #ffffff;
}
.title{
  font-size: 19pt;
  text-align: left;
  padding-top: 10px;
  padding-bottom: 10px;
  padding-left: 20px;
}
.brand-logo-section{
  display: flex;
  // flex-wrap: wrap;
  // justify-content: center;
  width: 100%;
  overflow: auto;
  
}
.brand-logo-item{
  // width: 18%;
}
.search {
  position: relative;
  display: flex;
  justify-content: center;
   padding: 20px 0 30px 0;
  input {
    min-width: 320px;
    width: 90%;
    height: 47px;
    color: #fff;
    background: #292a2c;
    border-radius: 2em;
    font-size: 12px;
    padding: 0 35px 0 10px;
    transition: all 0.3s;
    // &:focus {
    //   width: 190px;
    // }
  }
  button {
    position: absolute;
    right: 10px;
    top: 15px;
    background: url("/assets/images/icon/search.png") no-repeat center center;
    background-size: cover;
    width: 20px;
    height: 20px;
    cursor: pointer;
  }

}
  .filter-result{
  margin-top: 40px;
  margin-right: auto;
  margin-left: auto;
  margin-bottom: 20px;
  padding: 0 20px;

}
.filter-result-alpa{
  font-size: 60pt;
  margin-bottom: 10px; 
  width: 77px;
}
.filter-result-item{
  font-size: 12pt;
  color: #ffffff;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;  
  word-break:break-all;
  width: 70%;
}


.filter-result-item-name{
  font-size: 9pt;
  color: #525252;
  margin-bottom: 40px;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;  
  word-break:break-all;
  margin-bottom: 20px;  
  height: 18px;
}
.filter-result-row{
  
  display: flex;
  flex-wrap: wrap;
  
}
.filter-result-row3{
  width: 100%;
  height: fit-content;
}
.filter-section{
  border-bottom: 1px solid #ffffff; 
  position: relative;
  min-height: 435px;
}
.button-top{
  border-radius: 100px;
   border: 1px solid #ffffff;
  height: 30px;
  width: 130px;
  color: #ffffff;
  font-size: 10pt;
  position: absolute;
  left: calc( 50% - 65px );
  bottom: -15px;
  background-color: #000000;
}
.select-item{
  color: #a1a1a1;
  padding: 0 10px;
  cursor: pointer;
  font-size: 9pt;
  padding: 10px 0;
}
.select-item1:hover{
  color: #ffda2a;
}
.select-item-click{
  color: #ffffff;
}
.filter-alpa{
  position: absolute;
  display: flex;
  right: 0px;
}
.select-item1{
  color: #a1a1a1;
  padding: 0 10px;
  cursor: pointer;
  font-size: 9pt;
  padding: 15px 0;
  position: absolute;
}
.select-item1:hover{
  color: #ffda2a;
}
</style>
