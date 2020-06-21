<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Allat class
 *
 * Copyright (c)
 *
 * @author
 */
class Allat extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array();

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'cmall');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring', 'email'));
    }

    public function proc()
    {
        // 올앳관련 함수 Include
        //----------------------
        include(FCPATH . 'plugin/pg/allat/allatutil.php');

        //Request Value Define
        //----------------------
//        $at_cross_key = "cddf157c4c64d7fd128f124061c89aaa";    //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/support/sp_install_guide_scriptapi.jsp#shop]
//        $at_shop_id = "dumdum";        //설정필요
//        $at_amt = $this->session->userdata('TOTAL_PRICE');                        //결제 금액을 다시 계산해서 만들어야 함(해킹방지), ( session, DB 사용 )

        if (empty($_POST["allat_enc_data"])) {
            ?>
            <script>
                self.close();
            </script>
            <?php
            exit;
        }

        ?>
        <script>
            if(!!opener) {
                opener.result_submit('0000', '', '<?= $_POST["allat_enc_data"] ?>');
                self.close();
            } else {
                parent.result_submit('0000', '', '<?= $_POST["allat_enc_data"] ?>');
            }
        </script>
        <?php
    }
}