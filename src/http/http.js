import axios from 'axios';
import log from './../logger';
import _ from 'lodash';
import $ from 'jquery';

export default {
    // Http request open count
    count: 0,

    // log 조회 예외 목록
    logExceptList: [
        '/COM/COMRK/COMRK01_SelectSubMenuItems',
    ],


    get: function(url, disableIndicator) {
        if (!disableIndicator) this.indicator(1);
        return new Promise((resolve, reject) => {
            log.debug('GET => ' + url, null);
            axios
                .get(url)
                .then(res => {
                    this.indicator(-1);
                    log.debug('GET <= ' + url, {
                        status: res.status,
                        data: res.data,
                    });
                    resolve(res);
                })
                .catch(err => {
                    this.indicator(-1);
                    reject(err);
                });
        });
    },


    post: function(path, param ) {
        if (!path) {
            log.error('Http POST: path is invalid', path);
            return;
        }
        var p = _.clone(param);

        // param 에 포한된 Array -> String 으로 join
        // for (var o in p) {
        //     if (p[o] instanceof Array) {
        //         p[o] = p[o].join(',');
        //         if (p[o] === '') p[o] = null;
        //     }
        // }

        return new Promise((resolve, reject) => {
            var url = path
                .replace('vue\\src', '')
                .replace('.js', '')
                .replace('.vue', '')
                .replace(/[.]/gi, '_')
                .replace(/\\/gi, '/');

            axios.defaults.headers.common['X-Requested-With'] =
                'XMLHttpRequest';

            axios
                .post(url, $.param(p), {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        "Access-Control-Allow-Origin": "*"
                    }
                })
                .then(res => {
                    log.debug(
                        'POST : ' + url,
                        {
                            parameter: p,
                            status: res.status,
                            responseData: res.data,
                        },
                        'color:blue'
                    );


                    if (res.status !== 200) {
                        log.error('response error : ', res);
                        var msg = '';
                        switch (res.status) {
                            case 203:
                                msg = '해당 기능의 접근 권한이 없습니다';
                                break;
                            case 409:
                                msg =
                                    '너무 빠르게 재조회 하였습니다. 천천히 조회해 주세요.';
                                break;
                            case 404:
                                msg = '찾을 수 없는 페이지 입니다';
                                break;
                            case 302:
                                msg = '사용자 인증이 중지 되었습니다';
                                break;
                            case 412:
                                msg = '로그인 세션이 종료 되었습니다';
                                break;
                            default:
                                msg =
                                    '서버로 부터 오류 코드를 반환 받았습니다 : ' +
                                    res.status;
                                break;
                        }

                        log.error({
                            Action: 'ServerError',
                            Status: res.status,
                            Url: res.config.url,
                            Response: res,
                            Message: msg,
                        });

                        reject(res);
                    }


                    //log.debug('POST <= ' + url, { status: res.status, data: res.data });
                    this.indicator(-1);
                    resolve(res.data ? res.data : {});
                })
                .catch(err => {
                    this.indicator(-1);

                    switch (err.response.status) {
                        case 412:
                            window.location.href = '/login';
                            break;
                    }

                    reject(err);
                });
        });
    },

    indicator: function(v) {
        if (this.count >= 0) {
            this.count += v;
        }
        //log.debug('HTTP Que', this.count);
        //let timer = null;
        //   let runTime = null;

        if (this.count > 0) {
            $('input').blur();
            // 300ms 이후 로딩창 보이도록 수정
            //timer = setTimeout(() => {
            //    $('#app-loading').fadeIn();
            //  //  runTime = new Date();
            //}, 300);
            //$('#app-loading').show().fadeIn();
            $('#app-loading')
                .show()
                .fadeIn();
            //console.log('### LOADING ###');
        } else {
            //console.log('### END LOADING ###');
            //_.debounce(() => {
            //    clearTimeout(timer);
            //    $('#app-loading').clearQueue().fadeOut();
            //}, 300, { leading: false, trailing: true })();
            $('#app-loading')
                .clearQueue()
                .fadeOut();
        }
    },
};
