import $ from 'jquery';
import './../../assets/plugins/slick/slick.js';
import './../../assets/plugins/rangeSlider/js/ion.rangeSlider.js';


$(function() {

});
// 윈도우 스크롤 했을때,
$(window).scroll(function() {
  var t = $("html, body").scrollTop();
  if (t > 10) {
    $(".header").addClass("scrolled");
  } else {
    $(".header").removeClass("scrolled");
  }
});
