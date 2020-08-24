import $ from 'jquery';
import './../../assets/plugins/slick/slick.js';
import './../../assets/plugins/rangeSlider/js/ion.rangeSlider.js';


$(function () {

});
// 윈도우 스크롤 했을때,
$(window).scroll(function () {
    var t = $("html, body").scrollTop();
    var offset = 0;
    if ($('.smtm9-top')[0]) {
        offset = 100;
    } else {
        offset = 10;
    }
    if (t > offset) {
        $(".header").addClass("scrolled");
    } else {
        $(".header").removeClass("scrolled");
    }
});
