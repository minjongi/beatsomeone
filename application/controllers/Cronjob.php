<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cronjog class
 * @author redsunset
 */

class cronjob extends CB_Controller
{
    protected $models = array('');
    protected $helpers = array('form', 'array');

    function __contrunct()
    {
        parent::__construct();

        $this->load->library(array('pagination', 'querystring'));
    }
    function cronjob()
    {
        // echo "cron job-------------1-----------\n";
        $this->load->model(array('Cron_log_model', 'Member_group_model', 'Cmall_order_model', 'Member_group_member_model', 'Beatsomeone_model', 'Member_model'));
        $this->Cron_log_model->cron_log();

        $res_membership_purchase_logs = $this->Beatsomeone_model->get_membership_purchase_log_for_allat();
        foreach($res_membership_purchase_logs as $res_membership_purchase_log) {
            $end_date = $res_membership_purchase_log['end_date'];
            if (strtotime($end_date) < time()) {
                // 구독사용이 만료되였습니다.
                if ($res_membership_purchase_log['pay_method'] == "allat") {
                    $mem_id = $res_membership_purchase_log['mem_id'];
                    $userinfo = $this->Member_model->get_by_memid($mem_id);
                    $member_group = $this->Member_group_model->get_by_title($res_membership_purchase_log['plan_name']);
                    include(FCPATH . 'plugin/pg/allat/subscribe/allatutil.php');

                    $at_enc       = "";
                    $at_data      = "";
                    $at_txt       = "";
                
                    echo time();
                    // 필수 항목
                    $at_cross_key = "11e9e1458ad968ccbc4db73c16c1341f";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/helpinfo/hi_install_guide.jsp#shop]
                    $at_shop_id   = "dumdumfix";        //설정필요
            
                    $at_fix_key        = $res_membership_purchase_log['card_key'];   //카드키(최대 24자)
                    $at_sell_mm        = "00";   //할부개월값(최대  2자)
                    $at_amt            = $member_group['mgr_monthly_cost_w'];   //금액(최대 10자)

                    $at_shop_member_id = element('mem_id', $userinfo);   //회원ID(최대 20자)               : 쇼핑몰회원ID
                    $at_order_no       = time();   //주문번호(최대 80자)             : 쇼핑몰 고유 주문번호
                    $at_product_cd     = $member_group['mgr_title'];   //상품코드(최대 1000자)           : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
                    $at_product_nm     = $member_group['mgr_title'];   //상품명(최대 1000자)             : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
                    $at_cardcert_yn    = "N";   //카드인증여부(최대 1자)          : 인증(Y),인증사용않음(N),인증만사용(X)
                    $at_zerofee_yn     = "N";   //일반/무이자 할부 사용 여부(최대 1자) : 일반(N), 무이자 할부(Y)
                    $at_buyer_nm       = element('mem_userid', $userinfo);   //결제자성명(최대 20자)
                    $at_recp_nm        = element('mem_userid', $userinfo);   //수취인성명(최대 20자)
                    $at_recp_addr      = element('mem_userid', $userinfo);   //수취인주소(최대 120자)
                    $at_buyer_ip       = "Unknown";   //결제자 IP(최대15자) - BuyerIp를 넣을수 없다면 "Unknown"으로 세팅
                    $at_email_addr     = element('mem_email', $userinfo);   //결제자 이메일 주소(50자)
                    $at_bonus_yn       = "N";   //보너스포인트 사용여부(최대1자)  : 사용(Y), 사용않음(N)
                
                    $at_enc = setValue($at_enc,"allat_card_key"         ,   $at_fix_key        );
                    $at_enc = setValue($at_enc,"allat_sell_mm"          ,   $at_sell_mm        );
                    $at_enc = setValue($at_enc,"allat_amt"              ,   $at_amt            );
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
                        
                        $termDays = ($res_membership_purchase_log['bill_term'] == 'yearly') ? '365' : '30';
                        $startDate = date('Y-m-d');
                        $endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));
                        $params = [
                            'mem_id' => element('mem_id', $userinfo),
                            'bill_term' => 'monthly',
                            'plan' => $member_group['mgr_description'],
                            'plan_name' => $member_group['mgr_title'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'pay_method' => 'allat',
                            'amount' => intval($member_group["mgr_monthly_cost_w"]),
                            'card_key' => $res_membership_purchase_log['card_key']
                        ];
                        $this->Beatsomeone_model->insert_membership_purchase_log($params);
                        $downloaddata = array();
                        $downloaddata['mem_remain_downloads'] = $member_group['mgr_monthly_download_limit'];
                        $this->Member_model->update(element('mem_id', $userinfo), $downloaddata);
                                        
                        // echo "결과코드              : ".$REPLYCD."<br>";
                        // echo "결과메세지            : ".$REPLYMSG."<br>";
                        // echo "주문번호              : ".$ORDER_NO."<br>";
                        // echo "승인금액              : ".$AMT."<br>";
                        // echo "지불수단              : ".$PAY_TYPE."<br>";
                        // echo "승인일시              : ".$APPROVAL_YMDHMS."<br>";
                        // echo "거래일련번호          : ".$SEQ_NO."<br>";
                        // echo "승인번호              : ".$APPROVAL_NO."<br>";
                        // echo "카드ID                : ".$CARD_ID."<br>";
                        // echo "카드명                : ".$CARD_NM."<br>";
                        // echo "할부개월              : ".$SELL_MM."<br>";
                        // echo "무이자여부            : ".$ZEROFEE_YN."<br>";   //무이자(Y),일시불(N)
                        // echo "인증여부              : ".$CERT_YN."<br>";      //인증(Y),미인증(N)
                        // echo "직가맹여부            : ".$CONTRACT_YN."<br>";  //3자가맹점(Y),대표가맹점(N)
                    }else{
                        // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
                        // reply_msg 는 실패에 대한 메세지
                        echo "결과코드  : ".$REPLYCD."<br>";
                        echo "결과메세지: ".$REPLYMSG."<br>";
                        var_dump($at_txt);
                    }
                }
            }
        }

    }
}
?>