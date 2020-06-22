<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Allat class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Allat extends CI_Controller
{

	private $CI;

	function __construct()
	{
		$this->CI = & get_instance();
	}

	public function procComplete()
	{
        ini_set('display_errors', '0');
        $this->CI->load->model('Cmall_order_model');
        include(FCPATH . 'plugin/pg/allat/allatutil.php');

        $at_cross_key = "cddf157c4c64d7fd128f124061c89aaa";
        $at_shop_id = "dumdum";
        $at_amt = $this->CI->session->userdata('TOTAL_PRICE');

        $at_data = "allat_shop_id=" . $at_shop_id .
            "&allat_amt=" . $at_amt .
            "&allat_enc_data=" . $_POST["allat_enc_data"] .
            "&allat_cross_key=" . $at_cross_key;

        $at_txt = ApprovalReq($at_data, "SSL");

        $params = [];
        $params['REPLYCD'] = getValue("reply_cd", $at_txt);        //결과코드
        $params['REPLYMSG'] = getValue("reply_msg", $at_txt);       //결과 메세지

        log_message('error', 'REPLYCD : ' . $params['REPLYCD'] . ' / ' . iconv('euc-kr', 'utf-8', $params['REPLYMSG']) . ' / ' . $at_amt . ' / ' . $at_cross_key .' / ' . $at_shop_id);
        log_message('error', $at_txt);

        if (!!strcmp($params['REPLYCD'], "0000") && !!strcmp($params['REPLYCD'], "0001")) {
            return 0;
        }

        log_message('error', '======================== ALLAT SUCCESS ========================');

        // reply_cd "0000" 일때만 성공
        $params['ORDER_NO']         =getValue("order_no",$at_txt);
        $params['AMT']              =getValue("amt",$at_txt);
        $params['PAY_TYPE']         =getValue("pay_type",$at_txt);
        $params['APPROVAL_YMDHMS']  =getValue("approval_ymdhms",$at_txt);
        $params['SEQ_NO']           =getValue("seq_no",$at_txt);
        $params['APPROVAL_NO']      =getValue("approval_no",$at_txt);
        $params['CARD_ID']          =getValue("card_id",$at_txt);
        $params['CARD_NM']          =getValue("card_nm",$at_txt);
        $params['SELL_MM']          =getValue("sell_mm",$at_txt);
        $params['ZEROFEE_YN']       =getValue("zerofee_yn",$at_txt);
        $params['CERT_YN']          =getValue("cert_yn",$at_txt);
        $params['CONTRACT_YN']      =getValue("contract_yn",$at_txt);
        $params['SAVE_AMT']         =getValue("save_amt",$at_txt);
        $params['CARD_POINTDC_AMT'] =getValue("card_pointdc_amt",$at_txt);
        $params['BANK_ID']          =getValue("bank_id",$at_txt);
        $params['BANK_NM']          =getValue("bank_nm",$at_txt);
        $params['CASH_BILL_NO']     =getValue("cash_bill_no",$at_txt);
        $params['ESCROW_YN']        =getValue("escrow_yn",$at_txt);
        $params['ACCOUNT_NO']       =getValue("account_no",$at_txt);
        $params['ACCOUNT_NM']       =getValue("account_nm",$at_txt);
        $params['INCOME_ACC_NM']    =getValue("income_account_nm",$at_txt);
        $params['INCOME_LIMIT_YMD'] =getValue("income_limit_ymd",$at_txt);
        $params['INCOME_EXPECT_YMD']=getValue("income_expect_ymd",$at_txt);
        $params['CASH_YN']          =getValue("cash_yn",$at_txt);
        $params['HP_ID']            =getValue("hp_id",$at_txt);
        $params['TICKET_ID']        =getValue("ticket_id",$at_txt);
        $params['TICKET_PAY_TYPE']  =getValue("ticket_pay_type",$at_txt);
        $params['TICKET_NAME']      =getValue("ticket_nm",$at_txt);
        $params['PARTCANCEL_YN']    =getValue("partcancel_yn",$at_txt);
        $params['RAW_DATA']         =$at_txt;


        log_message('error', '======================== ALLAT allat_log_insert ========================');
        $this->CI->Cmall_order_model->allat_log_insert($params);
        return $at_amt;
    }
}
