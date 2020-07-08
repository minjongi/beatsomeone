<template>
    <div class="row">

        <div class="type"><span>{{$t('linkedAccount')}}</span></div>
        <div class="data">
            <div class="sns" v-if="info">
                <div class="n-flex between">
                    <div><img src="/assets/images/icon/icon_kakao.png"/> Kakao <span class="linkDt" v-if="info.kakao">{{ info.kakao }} 연결 완료</span></div>
                    <button class="btn" :class="{'btn--yellow':!info.kakao, 'btn--gray':info.kakao}" @click="toggleConnect('kakao')">
                        {{ $t(!info.kakao ? 'Link' : 'Unlink') }}</button>
                </div>
                <div class="n-flex between">
                    <div><img src="/assets/images/icon/icon_naver.png"/> Naver <span class="linkDt" v-if="info.naver">  {{ info.naver }} 연결 완료</span></div>
                    <button class="btn" :class="{'btn--yellow':!info.naver, 'btn--gray':info.naver}" @click="toggleConnect('naver')">
                        {{ $t(!info.naver ? 'Link' : 'Unlink') }}</button>
                </div>
                <div class="n-flex between">
                    <div><img src="/assets/images/icon/icon_facebook.png"/> Facebook <span class="linkDt" v-if="info.facebook">  {{ info.facebook }} 연결 완료</span></div>
                    <button class="btn" :class="{'btn--yellow':!info.facebook, 'btn--gray':info.facebook}" @click="toggleConnect('facebook')">
                        {{ $t(!info.facebook ? 'Link' : 'Unlink') }}</button>
                </div>
                <div class="n-flex between">
                    <div><img src="/assets/images/icon/icon_twitter.png"/> Twitter <span class="linkDt" v-if="info.twitter">  {{ info.twitter }} 연결 완료</span></div>
                    <button class="btn" :class="{'btn--yellow':!info.twitter, 'btn--gray':info.twitter}" @click="toggleConnect('twitter')">
                        {{ $t(!info.twitter ? 'Link' : 'Unlink') }}</button>
                </div>
                <div class="n-flex between">
                    <div><img src="/assets/images/icon/icon_google.png"/> Google <span class="linkDt" v-if="info.google">  {{ info.google }} 연결 완료</span></div>
                    <button class="btn" :class="{'btn--yellow':!info.google, 'btn--gray':info.google}" @click="toggleConnect('google')">
                        {{ $t(!info.google ? 'Link' : 'Unlink') }}</button>
                </div>
            </div>
        </div>
        <div></div>
    </div>
</template>


<script>

    import $ from 'jquery';

    export default {
        props: ['csrfHash'],

        data: function () {
            return {
                info: null,

            }
        },
        watch: {

        },
        created() {
            this.fetchSocialLinkInfo();
        },
        mounted() {

        },
        methods: {
            fetchSocialLinkInfo() {
                Http.post('/BeatsomeoneMypageApi/getSocialLinkInfo').then(r=> {
                    this.info = r;
                });
            },
            toggleConnect(social_type) {
                if(this.info[social_type]) {
                    this.social_connect_off(social_type);
                } else {
                    this.social_connect_on(social_type);
                }
            },
            f(social_type) {
                return _.find(this.info,r => r.soc_type === social_type);
            },
            social_connect_off(social_type) {

                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }

                if ( ! confirm('연동을 해제하시겠습니까?')) {
                    return false;
                }
                $.ajax({
                    url : '/social/social_connect_off/' + social_type,
                    type : 'post',
                    data : {
                        is_submit : '1',
                        csrf_test_name : this.csrfHash
                    },
                    dataType : 'json',
                    success : (data) => {
                        if (data.error) {
                            alert(data.error);
                            return false;
                        } else if (data.success) {
                            this.info[social_type] = null;
                        }
                    }
                });
            },

             social_connect_on(social_type) {

                if (social_type !== 'facebook' && social_type !== 'twitter' && social_type !== 'google' && social_type !== 'naver' && social_type !== 'kakao') {
                    return false;
                }
                var winObj = window.open('/social/' + social_type + '_login', social_type + '-on', 'width=600,height=600');
                winObj.onunload = function(){
                    window.location.reload();
                }

             },
        },

    }

</script>

<style scoped="scoped" lang="scss">
    span.linkDt {
        font-size: 0.7em !important;
        color: lightgrey !important;
        padding-left: 20px;
    }
</style>
