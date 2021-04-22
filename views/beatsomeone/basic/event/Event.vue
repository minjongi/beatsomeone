<template>
    <div class="wrapper">
        <Header :is-login="isLogin"></Header>
        <div class="container sub event-content" style="position: relative;">
            <div><img :src="'/assets/images/event/210422/page/1.png?v=1'"></div>
            <div style="position: absolute;left: 50%;margin-left: -340px;top:1420px;">
                <iframe width="680" height="382" src="https://www.youtube.com/embed/oaChRzEqo24" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div>
                <img :src="'/assets/images/event/210422/page/2.png?v=1'">
                <a href="https://kyh.typeform.com/to/YMaXMWt9" target="_blank"><img :src="'/assets/images/event/210422/page/3.png?v=1'"></a>
                <img :src="'/assets/images/event/210422/page/4.png?v=1'">
            </div>
            <div><img :src="'/assets/images/event/210422/page/5.png?v=1'"></div>
            <div>
                <img :src="'/assets/images/event/210422/page/6.png?v=1'" style="height:118px;">
                <img :src="'/assets/images/event/210422/page/7.png?v=1'" style="height:118px;cursor:pointer;" @click="clickShare('kakao')">
                <img :src="'/assets/images/event/210422/page/8.png?v=1'" style="height:118px;cursor:pointer;" @click="clickShare('facebook')">
                <img :src="'/assets/images/event/210422/page/9.png?v=1'" style="height:118px;cursor:pointer;" @click="copyLinkToClipboard">
                <img :src="'/assets/images/event/210422/page/10.png?v=1'" style="height:118px;">
            </div>
            <div><img :src="'/assets/images/event/210422/page/11.png?v=1'"></div>
        </div>
        <Footer />
    </div>
</template>

<script>
    import axios from "axios";

    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"
    import {EventBus} from '*/src/eventbus';

    export default {
        name: 'Index',
        components: {Header, Footer},
        data: function () {
            return {
                isLogin: false,
                shareLink: ''
            }
        },
        mounted() {
            var qs, js, q, s, d = document, gi = d.getElementById, ce = d.createElement, gt = d.getElementsByTagName,
                id = "typef_orm", b = "https://embed.typeform.com/";
            if (!gi.call(d, id)) {
              js = ce.call(d, "script");
              js.id = id;
              js.src = b + "embed.js";
              q = gt.call(d, "script")[0];
              q.parentNode.insertBefore(js, q)
            }
            this.shareLink = 'https://beatsomeone.com' + this.helper.langUrl(this.$i18n.locale, '/event/sane')
        },
        methods: {
            copyLinkToClipboard() {
                var t = document.createElement("textarea")
                document.body.appendChild(t)
                t.value = this.shareLink
                t.select()
                document.execCommand("copy")
                document.body.removeChild(t)
                alert(`복사되었습니다\nCtrl + V 를 눌러 확인해보세요`)
            },

            clickShare(sns) {
                let url = this.shareLink,
                    txt = '#커버지니어스 #산이 #비트썸원',
                    _url = encodeURIComponent(url),
                    _txt = encodeURIComponent(txt),
                    _br = encodeURIComponent("\r\n"),
                    o


                switch (sns) {
                    case "facebook":
                        o = {
                            method: "popup",
                            url: "http://www.facebook.com/sharer/sharer.php?u=" + _url,
                        };
                        break;

                    case "twitter":
                        o = {
                            method: "popup",
                            url:
                                "http://twitter.com/intent/tweet?text=" + _txt + "&url=" + _url,
                        };
                        break;

                    case "kakaostory":
                        o = {
                            method: "popup",
                            url: "https://story.kakao.com/share?url=" + _url,
                        };
                        break;

                    case "band":
                        o = {
                            method: "popup",
                            url: "http://www.band.us/plugin/share?body=" + _txt + _br + _url,
                        };
                        break;

                    case 'kakao':
                        window.Kakao.Link.sendScrap({
                            requestUrl: _url
                        });
                        return

                    default:
                        alert("지원하지 않는 SNS입니다.");
                        return false;
                }

                switch (o.method) {
                    case "popup":
                        window.open(
                            o.url,
                            "snspopup",
                            "width=500, height=400, menubar=no, status=no, toolbar=no"
                        );
                        break;

                    case "web2app":
                        if (navigator.userAgent.match(/android/i)) {
                            // Android
                            setTimeout(function () {
                                location.href =
                                    "intent://" + o.param + "#Intent;" + o.g_proto + ";end";
                            }, 100);
                        } else if (navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i)) {
                            // Apple
                            setTimeout(function () {
                                location.href = o.a_store;
                            }, 200);
                            setTimeout(function () {
                                location.href = o.a_proto + o.param;
                            }, 100);
                        } else {
                            alert("이 기능은 모바일에서만 사용할 수 있습니다.");
                        }
                        break;
                }
            },
        }
    }

</script>

<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scope="scope" lang="css">
    .event-content {
        text-align:center;
    }
    .event-content img {
      margin: 0 auto;
      max-width:100%;
      /*display: block;*/
        vertical-align: bottom;
    }
</style>
