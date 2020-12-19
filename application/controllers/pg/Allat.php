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
        $result_cd  = $_POST["allat_result_cd"];
        $result_msg = $_POST["allat_result_msg"];
        $enc_data   = $_POST["allat_enc_data"];

        if (empty($_POST["allat_enc_data"])) {
            ?>
            <script>
                self.close();
            </script>
            <?php
            exit;
        }

        echo("<script>");
        echo("if(window.opener != undefined) {");
        echo("	opener.result_submit('".$result_cd."','".$result_msg."','".$enc_data."');");
        echo("	window.close();");
        echo("} else {");
        echo("	parent.result_submit('".$result_cd."','".$result_msg."','".$enc_data."');");
        echo("}");
        echo("</script>");
    }
    public function proc2()
    {
        include(FCPATH . 'plugin/pg/allat/allatutil.php');
          //Request Value Define
        //----------------------
        $at_cross_key = "8572772462c1d68354644eb4cf74ab5d";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/helpinfo/hi_install_guide.jsp#shop]
        $at_shop_id   = "allat_fixtest77";       //설정필요

        // 요청 데이터 설정
        //----------------------
        $at_data   = "allat_shop_id=".$at_shop_id.
                    "&allat_enc_data=".$_POST["allat_enc_data"].
                    "&allat_cross_key=".$at_cross_key;


        // 올앳 서버와 통신 
        //--------------------------
        $at_txt = CertRegReq($at_data,"SSL");

        // 결제 결과 값 확인
        //------------------
        $REPLYCD   =getValue("reply_cd",$at_txt);        //결과코드
        $REPLYMSG  =getValue("reply_msg",$at_txt);       //결과 메세지

        // 결과값 처리
        //--------------------------------------------------------------------------
        if( !strcmp($REPLYCD,"0000") ){
            // reply_cd "0000" 일때만 성공
            $FIX_KEY	= getValue("fix_key",$at_txt);
            $APPLY_YMD	= getValue("apply_ymd",$at_txt);
            
            echo "결과코드	: ".$REPLYCD."<br>";
            echo "결과메세지	: ".$REPLYMSG."<br>";
            echo "인증키	: ".$FIX_KEY."<br>";
            echo "인증일	: ".$APPLY_YMD."<br>";
        }else{
            // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
            // reply_msg 는 실패에 대한 메세지
            echo "결과코드  : ".$REPLYCD."<br>";
            echo "결과메세지: ".$REPLYMSG."<br>";
        }

        var_dump($_POST);
    }
}