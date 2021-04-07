<template>
  <div class="wrapper ">
    <div class="brand-section">
      <Header />
      <div class="brand-container">
        <div class="title"><div>BRAND SHOP</div></div>
        <div class="brand-logo-section">
          <div v-for="(item,index) in brandList" :key="index" class="brand-logo-item"> 
             <a v-bind:href ="item.ban_url" v-bind:target="item.ban_target"><img :src="item.thumb_url" :style="bannerStyle(item)"></a>
          </div>
        </div>
        <div class="header__search">
            <div style="position: relative;">
                <input type="text" v-model="searchText" @keyup.enter="search"/>
                <button @click="search"></button>
            </div>
        </div>
      </div>
    </div>  
    <div class="filter-section">
      <div class="filter-alpa">
        <div class="select-item" style="margin-right: 30px" :class="selectAl == 'All'?'select-item-click':''" @click="selectCapital('All')">A~Z</div>
        <div v-for="(item, index) in selectAlBe" :key="index" >
          <div class="select-item" :class="item==selectAl?'select-item-click':''" @click="selectCapital(item, index)">{{item}}</div>
        </div>
      </div>
      <div v-for="(item,index1) in showSelectAlBe" :key="index1">
        <div v-if="showNewMemberList[index1].length != 0" class="filter-content">
          <div class="filter-result" >
            <div style="display: flex" >
              <div  class="filter-result-col2 filter-result-alpa">
                {{item}}
              </div>
              <div class="filter-result-row">
                <div v-for ="(member, index) in showNewMemberList[index1]" :key="index" class="filter-result-row3" :style="(index+1)%3==1?'border: none':''">
                  <!-- <div class="filter-result-item content truncate-overflow">{{member.mem_nickname}}</div> --> 
                    <a  class="filter-result-item content truncate-overflow" :href="helper.langUrl($i18n.locale, '/' + member.mem_nickname)">{{member.mem_nickname}}</a>
                    <div class="filter-result-item-name">{{member.mem_address1}}</div>
                </div>
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
    <Footer />
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
import _ from 'lodash'

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
      tempNewMemberList: [],
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
        ban_device:'pc',
        limit: 10
      };
      Http.post(`/beatsomeoneApi/banner_list`, p).then((r) => {
        this.brandList = _.cloneDeep(r);
        console.log('this is important', this.brandList)
      });
    },
    search(){
      let kk = 0
      let flag 
      let tempNewMemberList = []
      this.selectAl = "All"
      this.tempNewMemberList = _.cloneDeep(this.newMemberList)
      let newList = []
      this.searchTextList = this.searchText.split(' ');

      for (let i=0; i<this.tempNewMemberList.length; i++){
        newList[i] = []
        if ( this.tempNewMemberList[i].length != 0){
          for (let j=0; j<this.tempNewMemberList[i].length; j++){         
            flag = true
            for (let k=0; k<this.searchTextList.length; k++){
              kk =  this.tempNewMemberList[i][j].mem_nickname.indexOf(this.searchTextList[k]);
              if (kk >= 0){flag = false} else {flag = true; break;} 
            }
            if (!flag){
              newList[i].push(this.tempNewMemberList[i][j]);   
            } 
          }
        }
      }
      this.showNewMemberList = _.cloneDeep(newList)
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
      let height 
      if (item.ban_width=='' || parseInt(item.ban_width)=="0"){
        return "width:"+ "100% " +"height:"+"auto;";
      }
             
      if (item.ban_height=='' || parseInt(item.ban_height)=="0"){
        return "width:"+ "auto " +"height:"+"100%";
      }
      return "width:"+ item.ban_width+"px; " +"height:"+ item.ban_height+"px;";
    
    },
    brandLayout(){
      let width = parseInt(this.imageWidth)*5+150
      return "width:"+width+"px;"
    },

  },
};
</script>

<style lang="scss">
@import "@/assets/scss/App.scss";
</style>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

.albumItem {
  width: 20%;

  .albumItem__cover {
    img {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 100%;
    }
  }
}
.brand-section{
  
  background-image:url('/assets/images/banner/bannershop.png');
  background-size: cover;
  // height: 854px;
  background-position: 0 -375px;
  background-repeat: no-repeat;
  padding: 65px 35px 100px;
  
  // margin: 0 50px;
}
.brand-container{
  
  
}
.title{
  font-size: 26px;
  text-align: center;
  padding-top: 32px;
  padding-bottom: 32px;
  font-weight: bold;
}
.brand-logo-section{
  display: flex;
  flex-wrap: wrap;
  max-width: 1420px;
  min-width: 880px;
  margin: auto;
}
.brand-logo-item{
  width: 20%;
  padding: 15px;
  min-height: 250px;
  height: auto;
  box-sizing: border-box;
  img{
    width: 100%;
    height: 100%;
  }
}
.header__search {
  position: relative;
  display: flex;
  justify-content: center;
  margin-top: 50px;
  input {
    width: 460px;
    height: 47px;
    color: #fff;
    background: #292a2c;
    border-radius: 2em;
    font-size: 15px;
    font-weight: 600;
    padding: 0 35px 0 35px;
    transition: all 0.3s;
    // &:focus {
    //   width: 190px;
    // }
  }
  button {
    position: absolute;
    right: 12px;
    top: 11px;
    background: url("/assets/images/icon/searchicon.png") no-repeat center center;
    width: 25px;
    height: 25px;
    outline-style: none;
    border: 0;
    cursor: pointer;
  }
}
.filter-section{
  border-top: 1px solid #ffffff;
  border-bottom: 1px solid #ffffff;
  padding: 40px 0 60px;
  margin: 0 50px;
  position: relative;
}
.mark{
  font-size: 30pt;
  margin-right: 60px;
}
.filter-alpa{
  display: flex;
  font-size: 26pt;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  margin-bottom: 40px;
}
.select-item{
  color: #a1a1a1;
  padding: 0 8px;
  cursor: pointer;
}
.select-item:hover{
  color: #ffda2a;
}
.select-item-click{
  color: #ffffff;
}

.filter-content{
  border-top: 1px solid #1a1a1a;

}
.filter-result{
  margin-top: 70px;
  width: 1010px;
  margin-right: auto;
  margin-left: auto;
  margin-bottom: 30px;
  
}
.filter-result-alpa{
  font-size: 80pt;
  margin-right: 30px; 
  font-weight: 600;
  width: 77px;
}
.filter-result-item{
  font-size: 14pt;
  font-weight: 600;
  line-height: 1.2;
  color: #ffffff;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;  
  word-break:break-all;
  margin-bottom: 14px;
}
.filter-result-item-name{
  font-size: 13pt;
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
  width: 300px;
  border-left:1px solid #838383;
  padding-right: 50px;
  padding-left: 40px;
  height: 100px;
}
.button-top{
  border-radius: 100px;
  border: 1px solid #ffffff;
  height: 50px;
  width: 140px;
  color: #ffffff;
  font-size: 16pt;
  position: absolute;
  left: calc( 50% - 70px );
  bottom: -25px;
  background-color: #000000;
}
</style>
