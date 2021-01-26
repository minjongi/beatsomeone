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

    public function subscribe()
    {
        $this->load->model(array('Member_model', 'Member_group_model', 'Cmall_order_model', 'Member_group_member_model', 'Beatsomeone_model'));
        include(FCPATH . 'plugin/pg/allat/subscribe/allatutil.php');
        $at_cross_key = "11e9e1458ad968ccbc4db73c16c1341f";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/helpinfo/hi_install_guide.jsp#shop]
        $at_shop_id   = "dumdumfix";        //설정필요

        // 요청 데이터 설정
        //----------------------
        $at_data   = "allat_shop_id=".$at_shop_id.
        "&allat_enc_data=".$_POST["allat_enc_data"].
        "&allat_cross_key=".$at_cross_key;

        // 올앳 서버와 통신 
        //--------------------------
        $at_txt = CertRegReq($at_data,"SSL");

        // 이 부분에서 로그를 남기는 것이 좋습니다.
        // (올앳 결제 서버와 통신 후에 로그를 남기면, 통신에러시 빠른 원인파악이 가능합니다.)
        log_message('info', 'Allat: ' . $at_txt);

        // 결제 결과 값 확인
        //------------------
        $REPLYCD = getValue("reply_cd", $at_txt);        //결과코드
        $REPLYMSG = getValue("reply_msg", $at_txt);       //결과 메세지

        // 결과값 처리
        //--------------------------------------------------------------------------
        if( !strcmp($REPLYCD,"0000") ){
            // reply_cd "0000" 일때만 성공

            $FIX_KEY	= getValue("fix_key",$at_txt);
            $APPLY_YMD	= getValue("apply_ymd",$at_txt);
            $REGISTRY_NO = getValue("registry_no", $at_txt);
            // echo "카드가 정확히 등록되였습니다.";
            // echo "카드키	: ".$FIX_KEY."<br>";
            // echo "인증일	: ".$APPLY_YMD."<br>";

            $at_enc       = "";
            $at_data      = "";
            $at_txt       = "";
        
        
            // 필수 항목
            $at_fix_key        = $FIX_KEY;   //카드키(최대 24자)
            $at_sell_mm        = "01";   //할부개월값(최대  2자)
            $at_amt            = $_POST["allat_amt"];   //금액(최대 10자)
            // $at_business_type  = "0";   //결제자 카드종류(최대 1자)       : 개인(0),법인(1)
            // $at_registry_no    = $REGISTRY_NO;   //주민번호(최대 13자리)           : szBusinessType=0 일경우
            // $at_biz_no         = "";   //사업자번호(최대 20자리)         : szBusinessType=1 일경우
            $at_shop_member_id = $_POST["allat_pmember_id"];   //회원ID(최대 20자)               : 쇼핑몰회원ID
            $at_order_no       = $_POST["allat_order_no"];   //주문번호(최대 80자)             : 쇼핑몰 고유 주문번호
            $at_product_cd     = $_POST["allat_product_cd"];   //상품코드(최대 1000자)           : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
            $at_product_nm     = $_POST["allat_product_cd"];   //상품명(최대 1000자)             : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
            $at_cardcert_yn    = $_POST['allat_card_yn'];   //카드인증여부(최대 1자)          : 인증(Y),인증사용않음(N),인증만사용(X)
            $at_zerofee_yn     = "N";   //일반/무이자 할부 사용 여부(최대 1자) : 일반(N), 무이자 할부(Y)
            $at_buyer_nm       = $_POST['allat_buyer_nm'];   //결제자성명(최대 20자)
            $at_recp_nm        = $_POST['allat_recp_nm'];   //수취인성명(최대 20자)
            $at_recp_addr      = $_POST['allat_recp_addr'];   //수취인주소(최대 120자)
            $at_buyer_ip       = "Unknown";   //결제자 IP(최대15자) - BuyerIp를 넣을수 없다면 "Unknown"으로 세팅
            $at_email_addr     = $_POST['allat_email_addr'];   //결제자 이메일 주소(50자)
            $at_bonus_yn       = "N";   //보너스포인트 사용여부(최대1자)  : 사용(Y), 사용않음(N)
            // $at_gender         = "";   //구매자 성별(최대 1자)           : 남자(M)/여자(F)
            // $at_birth_ymd      = "";   //구매자의 생년월일(최대 8자)     : YYYYMMDD형식
        
            $at_enc = setValue($at_enc,"allat_card_key"         ,   $at_fix_key        );
            $at_enc = setValue($at_enc,"allat_sell_mm"          ,   $at_sell_mm        );
            $at_enc = setValue($at_enc,"allat_amt"              ,   $at_amt            );
            // $at_enc = setValue($at_enc,"allat_business_type"    ,   $at_business_type  );
            // if( strcmp($at_business_type,"0") == 0 ){
            //     $at_enc = setValue($at_enc,"allat_registry_no"  ,   $at_registry_no    );
            // }else{
            //     $at_enc = setValue($at_enc,"allat_biz_no"       ,   $at_biz_no         );
            // }
            $at_enc = setValue($at_enc,"allat_shop_id"          ,   $at_shop_id        );
            $at_enc = setValue($at_enc,"allat_shop_member_id"   ,   $at_shop_member_id );
            $at_enc = setValue($at_enc,"allat_order_no"         ,   $at_order_no       );
            $at_enc = setValue($at_enc,"allat_product_cd"       ,   $at_product_cd     );
            $at_enc = setValue($at_enc,"allat_product_nm"       ,   $at_product_nm     );
            $at_enc = setValue($at_enc,"allat_cardcert_yn"      ,   $at_cardcert_yn    );
            $at_enc = setValue($at_enc,"allat_zerofee_yn"       ,   $at_zerofee_yn     );
            $at_enc = setValue($at_enc,"allat_buyer_nm"         ,   $at_buyer_nm       );
            $at_enc = setValue($at_enc,"allat_recp_name"        ,   $at_recp_nm        );
            $at_enc = setValue($at_enc,"allat_recp_addr"        ,   $at_recp_addr      );
            $at_enc = setValue($at_enc,"allat_user_ip"          ,   $at_buyer_ip       );
            $at_enc = setValue($at_enc,"allat_email_addr"       ,   $at_email_addr     );
            $at_enc = setValue($at_enc,"allat_bonus_yn"         ,   $at_bonus_yn       );
            // $at_enc = setValue($at_enc,"allat_gender"           ,   $at_gender         );
            // $at_enc = setValue($at_enc,"allat_birth_ymd"        ,   $at_birth_ymd      );
            $at_enc = setValue($at_enc,"allat_pay_type"         ,   "FIX"              );  //수정금지(결제방식 정의)
            $at_enc = setValue($at_enc,"allat_test_yn"          ,   "N"                );  //테스트 :Y, 서비스 :N
            $at_enc = setValue($at_enc,"allat_opt_pin"          ,   "NOUSE"            );  //수정금지(올앳 참조 필드)
            $at_enc = setValue($at_enc,"allat_opt_mod"          ,   "APP"              );  //수정금지(올앳 참조 필드)
        
            $at_data = "allat_shop_id=".$at_shop_id.
                       "&allat_amt=".$at_amt.
                       "&allat_enc_data=".$at_enc.
                       "&allat_cross_key=".$at_cross_key;
        
            // 올앳 결제 서버와 통신 : ApprovalReq->통신함수, $at_txt->결과값
            //----------------------------------------------------------------
            $at_txt = ApprovalReq($at_data,"SSL");
        
            // 결제 결과 값 확인
            //------------------
            $REPLYCD   =getValue("reply_cd",$at_txt);        //결과코드
            $REPLYMSG  =getValue("reply_msg",$at_txt);       //결과 메세지
        
            if( !strcmp($REPLYCD,"0000") ){
                // reply_cd "0000" 일때만 성공
                $ORDER_NO         =getValue("order_no",$at_txt);
                $AMT              =getValue("amt",$at_txt);
                $PAY_TYPE         =getValue("pay_type",$at_txt);
                $APPROVAL_YMDHMS  =getValue("approval_ymdhms",$at_txt);
                $SEQ_NO           =getValue("seq_no",$at_txt);
                $APPROVAL_NO      =getValue("approval_no",$at_txt);
                $CARD_ID          =getValue("card_id",$at_txt);
                $CARD_NM          =getValue("card_nm",$at_txt);
                $SELL_MM          =getValue("sell_mm",$at_txt);
                $ZEROFEE_YN       =getValue("zerofee_yn",$at_txt);
                $CERT_YN          =getValue("cert_yn",$at_txt);
                $CONTRACT_YN      =getValue("contract_yn",$at_txt);
                $SAVE_AMT = getValue("save_amt", $at_txt);
                $CARD_POINTDC_AMT = getValue("card_pointdc_amt", $at_txt);
                $BANK_ID = getValue("bank_id", $at_txt);
                $BANK_NM = getValue("bank_nm", $at_txt);
                $CASH_BILL_NO = getValue("cash_bill_no", $at_txt);
                $ESCROW_YN = getValue("escrow_yn", $at_txt);
                $ACCOUNT_NO = getValue("account_no", $at_txt);
                $ACCOUNT_NM = getValue("account_nm", $at_txt);
                $INCOME_ACC_NM = getValue("income_account_nm", $at_txt);
                $INCOME_LIMIT_YMD = getValue("income_limit_ymd", $at_txt);
                $INCOME_EXPECT_YMD = getValue("income_expect_ymd", $at_txt);
                $CASH_YN = getValue("cash_yn", $at_txt);
                $HP_ID = getValue("hp_id", $at_txt);
                $TICKET_ID = getValue("ticket_id", $at_txt);
                $TICKET_PAY_TYPE = getValue("ticket_pay_type", $at_txt);
                $TICKET_NAME = getValue("ticket_nm", $at_txt);
                $PARTCANCEL_YN = getValue("partcancel_yn", $at_txt);

                $params = array();
                $params['REPLYCD'] = $REPLYCD;
                $params['REPLYMSG'] = $REPLYMSG;
                $params['ORDER_NO'] = $ORDER_NO;
                $params['AMT'] = $AMT;
                $params['PAY_TYPE'] = $PAY_TYPE;
                $params['APPROVAL_YMDHMS'] = $APPROVAL_YMDHMS;
                $params['SEQ_NO'] = $SEQ_NO;
                $params['APPROVAL_NO'] = $APPROVAL_NO;
                $params['CARD_ID'] = $CARD_ID;
                $params['CARD_NM'] = $CARD_NM;
                $params['SELL_MM'] = $SELL_MM;
                $params['ZEROFEE_YN'] = $ZEROFEE_YN;
                $params['CERT_YN'] = $CERT_YN;
                $params['CONTRACT_YN'] = $CONTRACT_YN;
                $params['SAVE_AMT'] = $SAVE_AMT;
                $params['CARD_POINTDC_AMT'] = $CARD_POINTDC_AMT;
                $params['BANK_ID'] = $BANK_ID;
                $params['BANK_NM'] = $BANK_NM;
                $params['CASH_BILL_NO'] = $CASH_BILL_NO;
                $params['ESCROW_YN'] = $ESCROW_YN;
                $params['ACCOUNT_NO'] = $ACCOUNT_NO;
                $params['ACCOUNT_NM'] = $ACCOUNT_NM;
                $params['INCOME_ACC_NM'] = $INCOME_ACC_NM;
                $params['INCOME_LIMIT_YMD'] = $INCOME_LIMIT_YMD;
                $params['INCOME_EXPECT_YMD'] = $INCOME_EXPECT_YMD;
                $params['CASH_YN'] = $CASH_YN;
                $params['HP_ID'] = $HP_ID;
                $params['TICKET_ID'] = $TICKET_ID;
                $params['TICKET_PAY_TYPE'] = $TICKET_PAY_TYPE;
                $params['TICKET_NAME'] = $TICKET_NAME;
                $params['PARTCANCEL_YN'] = $PARTCANCEL_YN;
                $params['RAW_DATA'] = $at_txt;

                $this->Cmall_order_model->allat_log_insert($params);
                $mem_id = intval($_POST["allat_pmember_id"]);
                $deletewhere = array(
                    'mem_id' => $mem_id,
                );
                $this->Member_group_member_model->delete_where($deletewhere);
                if ($_POST["allat_product_cd"] == "subscribe_common") {
                    $mgrid = 5;
                }
                if ($_POST["allat_product_cd"] == "subscribe_creater") {
                    $mgrid = 6;
                }
                $mginsert = array(
                    'mgr_id' => $mgrid,
                    'mem_id' => $mem_id,
                    'mgm_datetime' => cdate('Y-m-d H:i:s'),
                );
                $this->Member_group_member_model->insert($mginsert);

                $startDate = date('Y-m-d');
                $endDate = date("Y-m-d", strtotime($startDate . '+ ' . '30' . ' days'));

                $params = [
                    'mem_id' => $mem_id,
                    'bill_term' => 'monthly',
                    'plan' => $_POST['allat_product_nm'],
                    'plan_name' => $_POST['allat_product_cd'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'pay_method' => "allat",
                    'amount' => $_POST['allat_amt'],
                    'card_key' => $FIX_KEY
                ];
                $this->Beatsomeone_model->insert_membership_purchase_log($params);

                $this->session->set_userdata(
                    'mem_id',
                    $mem_id
                );

                $downloaddata = array();
                $gitem = $this->Member_group_model->item($mgrid);
                $gdownload = element('mgr_monthly_download_limit', $gitem);
                $downloaddata['mem_remain_downloads'] = intval($gdownload);
                $this->Member_model->update($mem_id, $downloaddata);

                // echo "결제정보가 정확히 등록되였습니다.<br/>";
                echo '<script type="text/javascript">';
                echo 'alert("회원가입이 완료 되었습니다.");';
                echo 'window.location.href="' . lang_url('/mypage') . '";';
                echo '</script>';

            }else{
                // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
                // reply_msg 는 실패에 대한 메세지
                echo "결과코드  : ".$REPLYCD."<br>";
                echo "결과메세지: ".$REPLYMSG."<br>";
            }
 
        } else {
            // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
            // reply_msg 는 실패에 대한 메세지
            echo "결과코드  : ".$REPLYCD."<br>";
            echo "결과메세지: ".$REPLYMSG."<br>";
        }    
    }

    public function subscribeM()
    {
        $this->load->model(array('Member_model', 'Member_group_model', 'Cmall_order_model', 'Member_group_member_model', 'Beatsomeone_model'));
        include(FCPATH . 'plugin/pg/allat/subscribe/mobile/allatutil.php');
        $at_cross_key = "11e9e1458ad968ccbc4db73c16c1341f";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/helpinfo/hi_install_guide.jsp#shop]
        $at_shop_id   = "dumdumfix";        //설정필요

        // 요청 데이터 설정
        //----------------------
        $at_data   = "allat_shop_id=".$at_shop_id.
        "&allat_enc_data=".$_POST["allat_enc_data"].
        "&allat_cross_key=".$at_cross_key;

        // 올앳 서버와 통신 
        //--------------------------
        $at_txt = CertRegReq($at_data,"SSL");

        // 이 부분에서 로그를 남기는 것이 좋습니다.
        // (올앳 결제 서버와 통신 후에 로그를 남기면, 통신에러시 빠른 원인파악이 가능합니다.)
        log_message('info', 'Allat: ' . $at_txt);

        // 결제 결과 값 확인
        //------------------
        $REPLYCD = getValue("reply_cd", $at_txt);        //결과코드
        $REPLYMSG = getValue("reply_msg", $at_txt);       //결과 메세지

        // 결과값 처리
        //--------------------------------------------------------------------------
        if( !strcmp($REPLYCD,"0000") ){
            // reply_cd "0000" 일때만 성공

            $FIX_KEY	= getValue("fix_key",$at_txt);
            $APPLY_YMD	= getValue("apply_ymd",$at_txt);
            $REGISTRY_NO = getValue("registry_no", $at_txt);
            // echo "카드가 정확히 등록되였습니다.";
            // echo "카드키	: ".$FIX_KEY."<br>";
            // echo "인증일	: ".$APPLY_YMD."<br>";

            $at_enc       = "";
            $at_data      = "";
            $at_txt       = "";
        
        
            // 필수 항목
            $at_fix_key        = $FIX_KEY;   //카드키(최대 24자)
            $at_sell_mm        = "01";   //할부개월값(최대  2자)
            $at_amt            = $_POST["allat_amt"];   //금액(최대 10자)
            // $at_business_type  = "0";   //결제자 카드종류(최대 1자)       : 개인(0),법인(1)
            // $at_registry_no    = $REGISTRY_NO;   //주민번호(최대 13자리)           : szBusinessType=0 일경우
            // $at_biz_no         = "";   //사업자번호(최대 20자리)         : szBusinessType=1 일경우
            $at_shop_member_id = $_POST["allat_pmember_id"];   //회원ID(최대 20자)               : 쇼핑몰회원ID
            $at_order_no       = $_POST["allat_order_no"];   //주문번호(최대 80자)             : 쇼핑몰 고유 주문번호
            $at_product_cd     = $_POST["allat_product_cd"];   //상품코드(최대 1000자)           : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
            $at_product_nm     = $_POST["allat_product_cd"];   //상품명(최대 1000자)             : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
            $at_cardcert_yn    = $_POST['allat_card_yn'];   //카드인증여부(최대 1자)          : 인증(Y),인증사용않음(N),인증만사용(X)
            $at_zerofee_yn     = "N";   //일반/무이자 할부 사용 여부(최대 1자) : 일반(N), 무이자 할부(Y)
            $at_buyer_nm       = $_POST['allat_buyer_nm'];   //결제자성명(최대 20자)
            $at_recp_nm        = $_POST['allat_recp_nm'];   //수취인성명(최대 20자)
            $at_recp_addr      = $_POST['allat_recp_addr'];   //수취인주소(최대 120자)
            $at_buyer_ip       = "Unknown";   //결제자 IP(최대15자) - BuyerIp를 넣을수 없다면 "Unknown"으로 세팅
            $at_email_addr     = $_POST['allat_email_addr'];   //결제자 이메일 주소(50자)
            $at_bonus_yn       = "N";   //보너스포인트 사용여부(최대1자)  : 사용(Y), 사용않음(N)
            // $at_gender         = "";   //구매자 성별(최대 1자)           : 남자(M)/여자(F)
            // $at_birth_ymd      = "";   //구매자의 생년월일(최대 8자)     : YYYYMMDD형식
        
            $at_enc = setValue($at_enc,"allat_card_key"         ,   $at_fix_key        );
            $at_enc = setValue($at_enc,"allat_sell_mm"          ,   $at_sell_mm        );
            $at_enc = setValue($at_enc,"allat_amt"              ,   $at_amt            );
            // $at_enc = setValue($at_enc,"allat_business_type"    ,   $at_business_type  );
            // if( strcmp($at_business_type,"0") == 0 ){
            //     $at_enc = setValue($at_enc,"allat_registry_no"  ,   $at_registry_no    );
            // }else{
            //     $at_enc = setValue($at_enc,"allat_biz_no"       ,   $at_biz_no         );
            // }
            $at_enc = setValue($at_enc,"allat_shop_id"          ,   $at_shop_id        );
            $at_enc = setValue($at_enc,"allat_shop_member_id"   ,   $at_shop_member_id );
            $at_enc = setValue($at_enc,"allat_order_no"         ,   $at_order_no       );
            $at_enc = setValue($at_enc,"allat_product_cd"       ,   $at_product_cd     );
            $at_enc = setValue($at_enc,"allat_product_nm"       ,   $at_product_nm     );
            $at_enc = setValue($at_enc,"allat_cardcert_yn"      ,   $at_cardcert_yn    );
            $at_enc = setValue($at_enc,"allat_zerofee_yn"       ,   $at_zerofee_yn     );
            $at_enc = setValue($at_enc,"allat_buyer_nm"         ,   $at_buyer_nm       );
            $at_enc = setValue($at_enc,"allat_recp_name"        ,   $at_recp_nm        );
            $at_enc = setValue($at_enc,"allat_recp_addr"        ,   $at_recp_addr      );
            $at_enc = setValue($at_enc,"allat_user_ip"          ,   $at_buyer_ip       );
            $at_enc = setValue($at_enc,"allat_email_addr"       ,   $at_email_addr     );
            $at_enc = setValue($at_enc,"allat_bonus_yn"         ,   $at_bonus_yn       );
            // $at_enc = setValue($at_enc,"allat_gender"           ,   $at_gender         );
            // $at_enc = setValue($at_enc,"allat_birth_ymd"        ,   $at_birth_ymd      );
            $at_enc = setValue($at_enc,"allat_pay_type"         ,   "FIX"              );  //수정금지(결제방식 정의)
            $at_enc = setValue($at_enc,"allat_test_yn"          ,   "N"                );  //테스트 :Y, 서비스 :N
            $at_enc = setValue($at_enc,"allat_opt_pin"          ,   "NOUSE"            );  //수정금지(올앳 참조 필드)
            $at_enc = setValue($at_enc,"allat_opt_mod"          ,   "APP"              );  //수정금지(올앳 참조 필드)
        
            $at_data = "allat_shop_id=".$at_shop_id.
                       "&allat_amt=".$at_amt.
                       "&allat_enc_data=".$at_enc.
                       "&allat_cross_key=".$at_cross_key;
        
            // 올앳 결제 서버와 통신 : ApprovalReq->통신함수, $at_txt->결과값
            //----------------------------------------------------------------
            $at_txt = ApprovalReq($at_data,"SSL");
        
            // 결제 결과 값 확인
            //------------------
            $REPLYCD   =getValue("reply_cd",$at_txt);        //결과코드
            $REPLYMSG  =getValue("reply_msg",$at_txt);       //결과 메세지
        
            if( !strcmp($REPLYCD,"0000") ){
                // reply_cd "0000" 일때만 성공
                $ORDER_NO         =getValue("order_no",$at_txt);
                $AMT              =getValue("amt",$at_txt);
                $PAY_TYPE         =getValue("pay_type",$at_txt);
                $APPROVAL_YMDHMS  =getValue("approval_ymdhms",$at_txt);
                $SEQ_NO           =getValue("seq_no",$at_txt);
                $APPROVAL_NO      =getValue("approval_no",$at_txt);
                $CARD_ID          =getValue("card_id",$at_txt);
                $CARD_NM          =getValue("card_nm",$at_txt);
                $SELL_MM          =getValue("sell_mm",$at_txt);
                $ZEROFEE_YN       =getValue("zerofee_yn",$at_txt);
                $CERT_YN          =getValue("cert_yn",$at_txt);
                $CONTRACT_YN      =getValue("contract_yn",$at_txt);
                $SAVE_AMT = getValue("save_amt", $at_txt);
                $CARD_POINTDC_AMT = getValue("card_pointdc_amt", $at_txt);
                $BANK_ID = getValue("bank_id", $at_txt);
                $BANK_NM = getValue("bank_nm", $at_txt);
                $CASH_BILL_NO = getValue("cash_bill_no", $at_txt);
                $ESCROW_YN = getValue("escrow_yn", $at_txt);
                $ACCOUNT_NO = getValue("account_no", $at_txt);
                $ACCOUNT_NM = getValue("account_nm", $at_txt);
                $INCOME_ACC_NM = getValue("income_account_nm", $at_txt);
                $INCOME_LIMIT_YMD = getValue("income_limit_ymd", $at_txt);
                $INCOME_EXPECT_YMD = getValue("income_expect_ymd", $at_txt);
                $CASH_YN = getValue("cash_yn", $at_txt);
                $HP_ID = getValue("hp_id", $at_txt);
                $TICKET_ID = getValue("ticket_id", $at_txt);
                $TICKET_PAY_TYPE = getValue("ticket_pay_type", $at_txt);
                $TICKET_NAME = getValue("ticket_nm", $at_txt);
                $PARTCANCEL_YN = getValue("partcancel_yn", $at_txt);

                $params = array();
                $params['REPLYCD'] = $REPLYCD;
                $params['REPLYMSG'] = $REPLYMSG;
                $params['ORDER_NO'] = $ORDER_NO;
                $params['AMT'] = $AMT;
                $params['PAY_TYPE'] = $PAY_TYPE;
                $params['APPROVAL_YMDHMS'] = $APPROVAL_YMDHMS;
                $params['SEQ_NO'] = $SEQ_NO;
                $params['APPROVAL_NO'] = $APPROVAL_NO;
                $params['CARD_ID'] = $CARD_ID;
                $params['CARD_NM'] = $CARD_NM;
                $params['SELL_MM'] = $SELL_MM;
                $params['ZEROFEE_YN'] = $ZEROFEE_YN;
                $params['CERT_YN'] = $CERT_YN;
                $params['CONTRACT_YN'] = $CONTRACT_YN;
                $params['SAVE_AMT'] = $SAVE_AMT;
                $params['CARD_POINTDC_AMT'] = $CARD_POINTDC_AMT;
                $params['BANK_ID'] = $BANK_ID;
                $params['BANK_NM'] = $BANK_NM;
                $params['CASH_BILL_NO'] = $CASH_BILL_NO;
                $params['ESCROW_YN'] = $ESCROW_YN;
                $params['ACCOUNT_NO'] = $ACCOUNT_NO;
                $params['ACCOUNT_NM'] = $ACCOUNT_NM;
                $params['INCOME_ACC_NM'] = $INCOME_ACC_NM;
                $params['INCOME_LIMIT_YMD'] = $INCOME_LIMIT_YMD;
                $params['INCOME_EXPECT_YMD'] = $INCOME_EXPECT_YMD;
                $params['CASH_YN'] = $CASH_YN;
                $params['HP_ID'] = $HP_ID;
                $params['TICKET_ID'] = $TICKET_ID;
                $params['TICKET_PAY_TYPE'] = $TICKET_PAY_TYPE;
                $params['TICKET_NAME'] = $TICKET_NAME;
                $params['PARTCANCEL_YN'] = $PARTCANCEL_YN;
                $params['RAW_DATA'] = $at_txt;

                $this->Cmall_order_model->allat_log_insert($params);
                $mem_id = intval($_POST["allat_pmember_id"]);
                $deletewhere = array(
                    'mem_id' => $mem_id,
                );
                $this->Member_group_member_model->delete_where($deletewhere);
                if ($_POST["allat_product_cd"] == "subscribe_common") {
                    $mgrid = 5;
                }
                if ($_POST["allat_product_cd"] == "subscribe_creater") {
                    $mgrid = 6;
                }
                $mginsert = array(
                    'mgr_id' => $mgrid,
                    'mem_id' => $mem_id,
                    'mgm_datetime' => cdate('Y-m-d H:i:s'),
                );
                $this->Member_group_member_model->insert($mginsert);

                $startDate = date('Y-m-d');
                $endDate = date("Y-m-d", strtotime($startDate . '+ ' . '30' . ' days'));

                $params = [
                    'mem_id' => $mem_id,
                    'bill_term' => 'monthly',
                    'plan' => $_POST['allat_product_nm'],
                    'plan_name' => $_POST['allat_product_cd'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'pay_method' => "allat",
                    'amount' => $_POST['allat_amt'],
                    'card_key' => $FIX_KEY
                ];
                $this->Beatsomeone_model->insert_membership_purchase_log($params);

                $this->session->set_userdata(
                    'mem_id',
                    $mem_id
                );

                $downloaddata = array();
                $gitem = $this->Member_group_model->item($mgrid);
                $gdownload = element('mgr_monthly_download_limit', $gitem);
                $downloaddata['mem_remain_downloads'] = intval($gdownload);
                $this->Member_model->update($mem_id, $downloaddata);

                // echo "결제정보가 정확히 등록되였습니다.<br/>";
                echo '<script type="text/javascript">';
                echo 'alert("회원가입이 완료 되었습니다.");';
                echo 'window.location.href="' . lang_url('/mypage') . '";';
                echo '</script>';

            }else{
                // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
                // reply_msg 는 실패에 대한 메세지
                echo "결과코드  : ".$REPLYCD."<br>";
                echo "결과메세지: ".$REPLYMSG."<br>";
            }
 
        } else {
            // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
            // reply_msg 는 실패에 대한 메세지
            echo "결과코드  : ".$REPLYCD."<br>";
            echo "결과메세지: ".$REPLYMSG."<br>";
        }    
    }    
    public function approval()
    {
        include(FCPATH . 'plugin/pg/allat/subscribe/allatutil.php');

        $at_enc       = "";
        $at_data      = "";
        $at_txt       = "";
    
        echo time();
        // 필수 항목
        $at_cross_key = "11e9e1458ad968ccbc4db73c16c1341f";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/helpinfo/hi_install_guide.jsp#shop]
        $at_shop_id   = "dumdumfix";        //설정필요

        $at_cross_key      = "11e9e1458ad968ccbc4db73c16c1341f";   //CrossKey값(최대200자)
        $at_fix_key        = "dumdu_1000045072";   //카드키(최대 24자)
        $at_sell_mm        = "01";   //할부개월값(최대  2자)
        $at_amt            = "33000";   //금액(최대 10자)
        $at_business_type  = "0";   //결제자 카드종류(최대 1자)       : 개인(0),법인(1)
        $at_registry_no    = "810325-1070611"; // "810325";   //주민번호(최대 13자리)           : szBusinessType=0 일경우 810325-1070611
    
        $at_biz_no         = "";   //사업자번호(최대 20자리)         : szBusinessType=1 일경우
        $at_shop_id        = "dumdumfix";   //상점ID(최대 20자)
        $at_shop_member_id = "qq1111";   //회원ID(최대 20자)               : 쇼핑몰회원ID
        $at_order_no       = time();   //주문번호(최대 80자)             : 쇼핑몰 고유 주문번호
        $at_product_cd     = "subscribe_common";   //상품코드(최대 1000자)           : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
        $at_product_nm     = "정기구독(일반)";   //상품명(최대 1000자)             : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
        $at_cardcert_yn    = "N";   //카드인증여부(최대 1자)          : 인증(Y),인증사용않음(N),인증만사용(X)
        $at_zerofee_yn     = "N";   //일반/무이자 할부 사용 여부(최대 1자) : 일반(N), 무이자 할부(Y)
        $at_buyer_nm       = "qq1111";   //결제자성명(최대 20자)
        $at_recp_nm        = "qq1111";   //수취인성명(최대 20자)
        $at_recp_addr      = "qq1111@qqq.com";   //수취인주소(최대 120자)
        $at_buyer_ip       = "Unknown";   //결제자 IP(최대15자) - BuyerIp를 넣을수 없다면 "Unknown"으로 세팅
        $at_email_addr     = "qq1111@qqq.com";   //결제자 이메일 주소(50자)
        $at_bonus_yn       = "N";   //보너스포인트 사용여부(최대1자)  : 사용(Y), 사용않음(N)
        $at_gender         = "M";   //구매자 성별(최대 1자)           : 남자(M)/여자(F)
        $at_birth_ymd      = "19810325";   //구매자의 생년월일(최대 8자)     : YYYYMMDD형식
    
        $at_enc = setValue($at_enc,"allat_card_key"         ,   $at_fix_key        );
        $at_enc = setValue($at_enc,"allat_sell_mm"          ,   $at_sell_mm        );
        $at_enc = setValue($at_enc,"allat_amt"              ,   $at_amt            );
        // $at_enc = setValue($at_enc,"allat_business_type"    ,   $at_business_type  );
        // if( strcmp($at_business_type,"0") == 0 ){
        //     $at_enc = setValue($at_enc,"allat_registry_no"  ,   $at_registry_no    );
        // }else{
        //     $at_enc = setValue($at_enc,"allat_biz_no"       ,   $at_biz_no         );
        // }
        $at_enc = setValue($at_enc,"allat_shop_id"          ,   $at_shop_id        );
        $at_enc = setValue($at_enc,"allat_shop_member_id"   ,   $at_shop_member_id );
        $at_enc = setValue($at_enc,"allat_order_no"         ,   $at_order_no       );
        $at_enc = setValue($at_enc,"allat_product_cd"       ,   $at_product_cd     );
        $at_enc = setValue($at_enc,"allat_product_nm"       ,   $at_product_nm     );
        $at_enc = setValue($at_enc,"allat_cardcert_yn"      ,   $at_cardcert_yn    );
        $at_enc = setValue($at_enc,"allat_zerofee_yn"       ,   $at_zerofee_yn     );
        $at_enc = setValue($at_enc,"allat_buyer_nm"         ,   $at_buyer_nm       );
        $at_enc = setValue($at_enc,"allat_recp_name"        ,   $at_recp_nm        );
        $at_enc = setValue($at_enc,"allat_recp_addr"        ,   $at_recp_addr      );
        $at_enc = setValue($at_enc,"allat_user_ip"          ,   $at_buyer_ip       );
        $at_enc = setValue($at_enc,"allat_email_addr"       ,   $at_email_addr     );
        $at_enc = setValue($at_enc,"allat_bonus_yn"         ,   $at_bonus_yn       );
        // $at_enc = setValue($at_enc,"allat_gender"           ,   $at_gender         );
        // $at_enc = setValue($at_enc,"allat_birth_ymd"        ,   $at_birth_ymd      );
        $at_enc = setValue($at_enc,"allat_pay_type"         ,   "FIX"              );  //수정금지(결제방식 정의)
        $at_enc = setValue($at_enc,"allat_test_yn"          ,   "Y"                );  //테스트 :Y, 서비스 :N
        $at_enc = setValue($at_enc,"allat_opt_pin"          ,   "NOUSE"            );  //수정금지(올앳 참조 필드)
        $at_enc = setValue($at_enc,"allat_opt_mod"          ,   "APP"              );  //수정금지(올앳 참조 필드)
    
        $at_data = "allat_shop_id=".$at_shop_id.
                   "&allat_amt=".$at_amt.
                   "&allat_enc_data=".$at_enc.
                   "&allat_cross_key=".$at_cross_key;
    
        // 올앳 결제 서버와 통신 : ApprovalReq->통신함수, $at_txt->결과값
        //----------------------------------------------------------------
        $at_txt = ApprovalReq($at_data,"SSL");
    
        // 결제 결과 값 확인
        //------------------
        $REPLYCD   =getValue("reply_cd",$at_txt);        //결과코드
        $REPLYMSG  =getValue("reply_msg",$at_txt);       //결과 메세지
    
        if( !strcmp($REPLYCD,"0000") ){
            // reply_cd "0000" 일때만 성공
            $ORDER_NO         =getValue("order_no",$at_txt);
            $AMT              =getValue("amt",$at_txt);
            $PAY_TYPE         =getValue("pay_type",$at_txt);
            $APPROVAL_YMDHMS  =getValue("approval_ymdhms",$at_txt);
            $SEQ_NO           =getValue("seq_no",$at_txt);
            $APPROVAL_NO      =getValue("approval_no",$at_txt);
            $CARD_ID          =getValue("card_id",$at_txt);
            $CARD_NM          =getValue("card_nm",$at_txt);
            $SELL_MM          =getValue("sell_mm",$at_txt);
            $ZEROFEE_YN       =getValue("zerofee_yn",$at_txt);
            $CERT_YN          =getValue("cert_yn",$at_txt);
            $CONTRACT_YN      =getValue("contract_yn",$at_txt);
    
            echo "결과코드              : ".$REPLYCD."<br>";
            echo "결과메세지            : ".$REPLYMSG."<br>";
            echo "주문번호              : ".$ORDER_NO."<br>";
            echo "승인금액              : ".$AMT."<br>";
            echo "지불수단              : ".$PAY_TYPE."<br>";
            echo "승인일시              : ".$APPROVAL_YMDHMS."<br>";
            echo "거래일련번호          : ".$SEQ_NO."<br>";
            echo "승인번호              : ".$APPROVAL_NO."<br>";
            echo "카드ID                : ".$CARD_ID."<br>";
            echo "카드명                : ".$CARD_NM."<br>";
            echo "할부개월              : ".$SELL_MM."<br>";
            echo "무이자여부            : ".$ZEROFEE_YN."<br>";   //무이자(Y),일시불(N)
            echo "인증여부              : ".$CERT_YN."<br>";      //인증(Y),미인증(N)
            echo "직가맹여부            : ".$CONTRACT_YN."<br>";  //3자가맹점(Y),대표가맹점(N)
        }else{
            // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
            // reply_msg 는 실패에 대한 메세지
            echo "결과코드  : ".$REPLYCD."<br>";
            echo "결과메세지: ".$REPLYMSG."<br>";
            var_dump($at_txt);
        }
    }
    public function test()
    {
        $mgrid = 5;
        $this->load->model(array('Member_group_model'));
        $gitem = $this->Member_group_model->item($mgrid);
        $gdownload = element('mgr_monthly_download_limit', $gitem);
        var_dump($gdownload);
    }
}