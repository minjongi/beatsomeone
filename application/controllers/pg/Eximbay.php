<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Eximbay class
 *
 * Copyright (c)
 *
 * @author
 */
class Eximbay extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array();

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'cmall');
    private $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI = &get_instance();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring', 'email'));
    }

    public function request()
    {
        /**
         * 아래 설정 된 값은 테스트용 mid: 1849705C64 에 대한 secretKey 입니다.
         * 테스트로만 진행 하시고 발급 받으신 값으로 변경 하셔야 됩니다.
         */
        $secretKey = "289F40E6640124B2628640168C3C5464";//가맹점 secretkey
//        $reqURL = "https://secureapi.test.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST 서버 요청 URL입니다.
        $reqURL = "https://secureapi.eximbay.com/Gateway/BasicProcessor.krp";//EXIMBAY TEST 서버 요청 URL입니다.

        $fgkey = "";//fgkey검증키 관련
        $sortingParams = "";//파라미터 정렬 관련
        $postData = $this->input->post();

        foreach ($postData as $Key => $value) {
            $hashMap[$Key] = $value;
        }
        $size = count($hashMap);
        ksort($hashMap);
        $counter = 0;
        foreach ($hashMap as $key => $val) {
            if ($counter == $size - 1) {
                $sortingParams .= $key . "=" . $val;
            } else {
                $sortingParams .= $key . "=" . $val . "&";
            }
            ++$counter;
        }
        //echo $sortingParams;

        $linkBuf = $secretKey . "?" . $sortingParams;
        $fgkey = hash("sha256", $linkBuf);

        $view = [
            'fgkey' => $fgkey,
            'reqURL' => $reqURL,
            'postData' => $postData
        ];

        $this->load->view('paymentlib/eximbay/request', $view);
    }

    public function return()
    {
        ?>
        <script>
            self.close();
        </script>
        <?php
        exit;
    }
}
