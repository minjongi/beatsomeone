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
        $this->output->set_content_type('text/json');

        include(FCPATH . 'plugin/pg/allat/allatutil.php');
        $at_cross_key = $this->cbconfig->item('pg_allat_crosskey');    //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/support/sp_install_guide_scriptapi.jsp#shop]
        $at_shop_id = $this->cbconfig->item('pg_allat_shop_id');        //설정필요
        $at_amt = $_POST['allat_amt'];                        //결제 금액을 다시 계산해서 만들어야 함(해킹방지), ( session, DB 사용 )

        // 요청 데이터 설정
        //----------------------
        $at_data = "allat_shop_id=" . $at_shop_id .
            "&allat_amt=" . $at_amt .
            "&allat_enc_data=" . $_POST["allat_enc_data"] .
            "&allat_cross_key=" . $at_cross_key;
        // 올앳 결제 서버와 통신 : ApprovalReq->통신함수, $at_txt->결과값
        //----------------------------------------------------------------
        // PHP5 이상만 SSL 사용가능
        $at_txt = ApprovalReq($at_data, "SSL");
        // $at_txt = ApprovalReq($at_data, "NOSSL"); // PHP5 이하버전일 경우
        // 이 부분에서 로그를 남기는 것이 좋습니다.
        // (올앳 결제 서버와 통신 후에 로그를 남기면, 통신에러시 빠른 원인파악이 가능합니다.)
        log_message('info', $at_txt);

        // 결제 결과 값 확인
        //------------------
        $REPLYCD = getValue("reply_cd", $at_txt);        //결과코드
        $REPLYMSG = getValue("reply_msg", $at_txt);       //결과 메세지

        // 결과값 처리
        //--------------------------------------------------------------------------
        // 결과 값이 '0000'이면 정상임. 단, allat_test_yn=Y 일경우 '0001'이 정상임.
        // 실제 결제   : allat_test_yn=N 일 경우 reply_cd=0000 이면 정상
        // 테스트 결제 : allat_test_yn=Y 일 경우 reply_cd=0001 이면 정상
        //--------------------------------------------------------------------------
        if (!strcmp($REPLYCD, "0000") && !strcmp($REPLYCD, "0001")) {
            // reply_cd "0000" 일때만 성공
            $ORDER_NO = getValue("order_no", $at_txt);
            $AMT = getValue("amt", $at_txt);
            $PAY_TYPE = getValue("pay_type", $at_txt);
            $APPROVAL_YMDHMS = getValue("approval_ymdhms", $at_txt);
            $SEQ_NO = getValue("seq_no", $at_txt);
            $APPROVAL_NO = getValue("approval_no", $at_txt);
            $CARD_ID = getValue("card_id", $at_txt);
            $CARD_NM = getValue("card_nm", $at_txt);
            $SELL_MM = getValue("sell_mm", $at_txt);
            $ZEROFEE_YN = getValue("zerofee_yn", $at_txt);
            $CERT_YN = getValue("cert_yn", $at_txt);
            $CONTRACT_YN = getValue("contract_yn", $at_txt);
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

            echo "결과코드              : " . $REPLYCD . "<br>";
            echo "결과메세지            : " . $REPLYMSG . "<br>";
            echo "주문번호              : " . $ORDER_NO . "<br>";
            echo "승인금액              : " . $AMT . "<br>";
            echo "지불수단              : " . $PAY_TYPE . "<br>";
            echo "승인일시              : " . $APPROVAL_YMDHMS . "<br>";
            echo "거래일련번호          : " . $SEQ_NO . "<br>";
            echo "에스크로 적용 여부    : " . $ESCROW_YN . "<br>";
            echo "=============== 신용 카드 ===============================<br>";
            echo "승인번호              : " . $APPROVAL_NO . "<br>";
            echo "카드ID                : " . $CARD_ID . "<br>";
            echo "카드명                : " . $CARD_NM . "<br>";
            echo "할부개월              : " . $SELL_MM . "<br>";
            echo "무이자여부            : " . $ZEROFEE_YN . "<br>";   //무이자(Y),일시불(N)
            echo "인증여부              : " . $CERT_YN . "<br>";      //인증(Y),미인증(N)
            echo "직가맹여부            : " . $CONTRACT_YN . "<br>";  //3자가맹점(Y),대표가맹점(N)
            echo "세이브 결제 금액      : " . $SAVE_AMT . "<br>";
            echo "포인트할인 결제 금액  : " . $CARD_POINTDC_AMT . "<br>";
            echo "=============== 계좌 이체 / 가상계좌 ====================<br>";
            echo "은행ID                : " . $BANK_ID . "<br>";
            echo "은행명                : " . $BANK_NM . "<br>";
            echo "현금영수증 일련 번호  : " . $CASH_BILL_NO . "<br>";
            echo "=============== 가상계좌 ================================<br>";
            echo "계좌번호              : " . $ACCOUNT_NO . "<br>";
            echo "입금계좌명            : " . $INCOME_ACC_NM . "<br>";
            echo "입금자명              : " . $ACCOUNT_NM . "<br>";
            echo "입금기한일            : " . $INCOME_LIMIT_YMD . "<br>";
            echo "입금예정일            : " . $INCOME_EXPECT_YMD . "<br>";
            echo "현금영수증신청 여부   : " . $CASH_YN . "<br>";
            echo "=============== 휴대폰 결제 =============================<br>";
            echo "이동통신사구분        : " . $HP_ID . "<br>";
            echo "=============== 상품권 결제 =============================<br>";
            echo "상품권 ID             : " . $TICKET_ID . "<br>";
            echo "상품권 이름           : " . $TICKET_NAME . "<br>";
            echo "결제구분              : " . $TICKET_PAY_TYPE . "<br>";

            echo "부분취소가능여부 : " . $PARTCANCEL_YN . "<br>";

        } else {
            $this->output->set_status_header('400');
            $this->output->set_output(json_encode([
                'reply_cd' => $REPLYCD,
                'reply_msg' => $REPLYMSG
            ], JSON_UNESCAPED_UNICODE));
        }
    }
}