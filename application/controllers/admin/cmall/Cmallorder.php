<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PayPal\Api\Amount;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Rest\ApiContext;

/**
 * Cmallorder class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자>컨텐츠몰관리>주문내역 controller 입니다.
 */
class Cmallorder extends CB_Controller
{

    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'cmall/cmallorder';

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Cmall_order', 'Cmall_item', 'Cmall_order_detail');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Cmall_order_model';

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'cmall');

    private $payInfo = [];

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('pagination', 'querystring', 'cmalllib'));
    }

    /**
     * 목록을 가져오는 메소드입니다
     */
    public function index()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_cmall_cmallorder_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * Validation 라이브러리를 가져옵니다
         */
        $this->load->library('form_validation');

        $config = array(
            array(
                'field' => 'cor_id',
                'label' => '구매아이디',
                'rules' => 'trim|required|numeric',
            ),
            array(
                'field' => 'mem_id',
                'label' => '회원아이디',
                'rules' => 'trim|required|numeric|is_natural',
            ),
            array(
                'field' => 'cit_id',
                'label' => '상품아이디',
                'rules' => 'trim|required|numeric|is_natural',
            ),
            array(
                'field' => 'cod_download_days',
                'label' => '다운로드기간',
                'rules' => 'trim|numeric|is_natural',
            ),
        );
        $this->form_validation->set_rules($config);

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         */
        if ($this->form_validation->run() === false) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

        } else {
            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $cod_download_days = $this->input->post('cod_download_days') ? $this->input->post('cod_download_days') : 0;
            $updatedata = array(
                'cod_download_days' => $cod_download_days,
            );
            $where = array(
                'cor_id' => $this->input->post('cor_id'),
                'mem_id' => $this->input->post('mem_id'),
                'cit_id' => $this->input->post('cit_id'),
            );
            $this->Cmall_order_detail_model->update('', $updatedata, $where);

            redirect(current_full_url(), 'refresh');
        }

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $findex = $this->input->get('findex') ? $this->input->get('findex') : 'cor_datetime';
        $forder = $this->input->get('forder', null, 'desc');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $this->{$this->modelname}->allow_search_field = array('cor_id', 'member.mem_nickname', 'member.mem_userid', 'cor_content', 'cor_total_money', 'cor_cash', 'cor_memo', 'cor_admin_memo', 'cor_ip', 'member.mem_id'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array('member.mem_id', 'cor_total_money', 'cor_cash'); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('cor_id', 'cor_approve_datetime'); // 정렬이 가능한 필드

        $where = array();

        if ($this->input->get('cor_pay_type')) {
            $where['cor_pay_type'] = $this->input->get('cor_pay_type');
        }

        $result = $this->{$this->modelname}
            ->get_admin_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['display_name'] = display_username(
                    element('mem_userid', $val),
                    element('mem_nickname', $val),
                    element('mem_icon', $val)
                );
                $result['list'][$key]['num'] = $list_num--;
                $result['list'][$key]['pay_method'] = $this->cmalllib->get_paymethodtype(element('cor_pay_type', $val));
                $result['list'][$key]['order_status'] = cmall_print_stype_names(element('status', $val));

                $orderdetail = $this->Cmall_order_detail_model->get_by_item(element('cor_id', $val));

                if ($orderdetail) {
                    foreach ($orderdetail as $okey => $oval) {
                        $orderdetail[$okey]['item'] = $item
                            = $this->Cmall_item_model->get_one(element('cit_id', $oval));
                        $orderdetail[$okey]['itemdetail'] = $itemdetail
                            = $this->Cmall_order_detail_model->get_detail_by_item(element('cor_id', $val), element('cit_id', $oval));

                        $orderdetail[$okey]['item']['possible_download'] = 1;

                        if (element('cod_download_days', element(0, $itemdetail))) {
                            $endtimestamp = strtotime(element('cor_approve_datetime', $val))
                                + 86400 * element('cod_download_days', element(0, $itemdetail));
                            $orderdetail[$okey]['item']['download_end_date'] = $enddate = cdate('Y-m-d', $endtimestamp);

                            $orderdetail[$okey]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
                        }
                    }
                }
                $result['list'][$key]['orderdetail'] = $orderdetail;
            }
        }
        $view['view']['data'] = $result;


        /**
         * primary key 정보를 저장합니다
         */
        $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        /**
         * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
         */
        $search_option = array('member.mem_nickname' => '회원명', 'cmall_order.mem_realname' => '회원실명', 'member.mem_userid' => '회원아이디', 'cor_content' => '내용', 'cor_total_money' => '결제금액');
        $view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
        $view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['listall_url'] = admin_url($this->pagedir);
        $view['view']['form_url'] = admin_url($this->pagedir . '/form');

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'index');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function form($cor_id)
    {

        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_cmall_cmallorder_form';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * Validation 라이브러리를 가져옵니다
         */
        $this->load->library('form_validation');

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        if (empty($cor_id) or $cor_id < 1) {
            alert('잘못된 접근입니다');
        }

        $order = $this->{$this->modelname}->get_one($cor_id);
        if (!element('cor_id', $order)) {
            alert('해당 주문이 존재하지 않습니다.');
        }

        $config = array(
            array(
                'field' => 'pcase',
                'label' => '액션',
                'rules' => 'trim|required',
            ),
        );
        $this->form_validation->set_rules($config);

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         */
        if ($this->form_validation->run() === false) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

        } else {
            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
            $pcase = $this->input->post('pcase');
            if ($pcase === 'product') {
                $cor_status = $this->input->post('cor_status');
                $pg = $order['cor_pg'];

                $orderdetail = $this->db->query("SELECT * FROM cb_cmall_order_detail cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id WHERE cor_id=?", [$cor_id])->result_array();
                $total_money = 0.0;
                $total_point = 0;
                foreach ($orderdetail as $item) {
                    if ($pg == 'paypal') {
                        $total_money += floatval($item['cde_price_d']);
                    } elseif ($pg == 'allat') {
                        $total_money += intval($item['cde_price']);
                    }
                    $total_point += intval($item['cod_point']);
                }
                // 결제정보 반영
                $updatedata = array(
                    'cor_status' => $cor_status,
                );

                if ($cor_status == '1') {
                    $updatedata['cor_cash_request'] = $total_money - $total_point;
                    $updatedata['cor_cash'] = $total_money - $total_point;
                    $updatedata['cor_refund_price'] = 0;
                    $updatedata['cor_refund_point'] = 0;
                    $where = array(
                        'cor_id' => $cor_id,
                    );
                    $this->Cmall_order_model->update('', $updatedata, $where);

                    $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='order' WHERE cor_id=?", [$cor_id]);
                } elseif ($cor_status == '0') {
                    $updatedata['cor_cash_request'] = $total_money - $total_point;
                    $updatedata['cor_cash'] = 0;
                    $updatedata['cor_refund_price'] = 0;
                    $updatedata['cor_refund_point'] = 0;
                    $where = array(
                        'cor_id' => $cor_id,
                    );
                    $this->Cmall_order_model->update('', $updatedata, $where);
                    $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='deposit' WHERE cor_id=?", [$cor_id]);
                } elseif ($cor_status == '2') {
                    $paytype = $order['cor_pay_type'];
                    
        
                    if ($paytype == 'FREE') {
                        $origin_cor_status = $order['cor_status'];
                        $dt = new DateTime();
                        $kstTimezone = new DateTimeZone('Asia/Seoul');
                        $dt->setTimezone($kstTimezone);
                        $create_time = $dt->format("Y-m-d H:i:s");
                        $updatedata = array();
                        $updatedata['status'] = 'cancel';
                        $updatedata['cor_refund_datetime'] = $create_time;
                        if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                            $updatedata['cor_cancel_datetime'] = $create_time;
                            $updatedata['cor_refund_price'] = 0;
                            $updatedata['cor_refund_point'] = 0;
                            $updatedata['cor_status'] = 2;
                        }
                        $where = array(
                            'cor_id' => $cor_id,
                        );
                        $this->Cmall_order_model->update('', $updatedata, $where);

                        if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                            $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='cancel' WHERE cor_id=?", [$cor_id]);
                        }
                    } else {
                        if ($pg == 'allat') {
                            // 올앳관련 함수 Include
                            //----------------------
                            include(FCPATH . 'plugin/pg/allat/allatutil.php');

                            //Request Value Define
                            //----------------------
                            /*
                            $at_cross_key = "가맹점 CrossKey";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/support/sp_install_guide_scriptapi.jsp#shop]
                            $at_shop_id   = "가맹점 ShopId";       //설정필요
                            */

                            //------------------------ Test Code ---------------------
                            $at_cross_key = $_POST["test_cross_key"];
                            $at_shop_id = $_POST["allat_shop_id"];
                            //--------------------------------------------------------

                            // 요청 데이터 설정
                            //----------------------
                            $at_data   = "allat_shop_id=".$at_shop_id.
                                "&allat_enc_data=".$_POST["allat_enc_data"].
                                "&allat_cross_key=".$at_cross_key;


                            // 올앳 결제 서버와 통신 : CancelReq->통신함수, $at_txt->결과값
                            //----------------------------------------------------------------
                            // PHP5 이상만 SSL 사용가능
                            $at_txt = CancelReq($at_data,"SSL");
                            // $at_txt = CancelReq($at_data, "NOSSL"); // PHP5 이하버전일 경우
                            // 이 부분에서 로그를 남기는 것이 좋습니다.
                            // (올앳 결제 서버와 통신 후에 로그를 남기면, 통신에러시 빠른 원인파악이 가능합니다.)

                            // 결과값
                            //----------------------------------------------------------------
                            $REPLYCD     = getValue("reply_cd",$at_txt);	//결과코드
                            $REPLYMSG    = getValue("reply_msg",$at_txt);	//결과 메세지

                            // 결과값 처리
                            //--------------------------------------------------------------------------
                            // 결과 값이 '0000'이면 정상임. 단, allat_test_yn=Y 일경우 '0001'이 정상임.
                            // 실제 결제   : allat_test_yn=N 일 경우 reply_cd=0000 이면 정상
                            // 테스트 결제 : allat_test_yn=Y 일 경우 reply_cd=0001 이면 정상
                            //--------------------------------------------------------------------------
                            if( strcmp($REPLYCD,"0000") == 0 || strcmp($REPLYCD,"0001") == 0 ){
                                // reply_cd "0000" 일때만 성공
                                $CANCEL_YMDHMS=getValue("cancel_ymdhms",$at_txt);
                                $PART_CANCEL_FLAG=getValue("part_cancel_flag",$at_txt);
                                $REMAIN_AMT=getValue("remain_amt",$at_txt);
                                $PAY_TYPE=getValue("pay_type",$at_txt);

    //                        echo "결과코드		: ".$REPLYCD."<br>";
    //                        echo "결과메세지		: ".$REPLYMSG."<br>";
    //                        echo "취소날짜		: ".$CANCEL_YMDHMS."<br>";
    //                        echo "취소구분		: ".$PART_CANCEL_FLAG."<br>";
    //                        echo "잔액			: ".$REMAIN_AMT."<br>";
    //                        echo "거래방식구분	: ".$PAY_TYPE."<br>";

                                $params = array();
                                $params['REPLYCD'] = $REPLYCD;
                                $params['REPLYMSG'] = $REPLYMSG;
                                $params['ORDER_NO'] = $cor_id;
                                $params['AMT'] = $this->input->post('allat_amt');
                                $params['PAY_TYPE'] = $PAY_TYPE;
                                $params['APPROVAL_YMDHMS'] = $CANCEL_YMDHMS;
                                $params['REPLYCD'] = $REPLYCD;
                                $params['REPLYMSG'] = $REPLYMSG;
                                $params['SAVE_AMT'] = $REMAIN_AMT;
                                $params['PARTCANCEL_YN'] = $PART_CANCEL_FLAG;
                                $params['RAW_DATA'] = $at_txt;

                                $this->Cmall_order_model->allat_log_insert($params);

                                $origin_cor_status = $order['cor_status'];

                                $refund_price = intval($this->input->post('allat_amt'));
                                $refund_point = intval($order['cor_point']);
                                $refund_datetime = DateTime::createFromFormat("YmdHis", $CANCEL_YMDHMS);

                                $updatedata = array();
                                $updatedata['status'] = 'cancel';
                                $updatedata['cor_refund_datetime'] = $refund_datetime->format("Y-m-d H:i:s");
                                if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                    $updatedata['cor_cancel_datetime'] = $refund_datetime->format("Y-m-d H:i:s");
                                    $updatedata['cor_refund_price'] = $refund_price;
                                    $updatedata['cor_refund_point'] = $refund_point;
                                    $updatedata['cor_status'] = 2;
                                }

                                $where = array(
                                    'cor_id' => $cor_id,
                                );
                                $this->Cmall_order_model->update('', $updatedata, $where);

                                if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                    $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='cancel' WHERE cor_id=?", [$cor_id]);
                                }

                                if ($refund_point > 0) {
                                    $this->db->query("INSERT INTO cb_point (mem_id, poi_datetime, poi_content, poi_point, poi_type, poi_related_id, poi_action) VALUES (?, ?, ?, ?, ?, ?, ?)", [
                                        $order['mem_id'],
                                        cdate('Y-m-d H:i:s'),
                                        cdate('Y-m-d H:i:s') . ' 주문취소',
                                        $refund_point,
                                        'refund',
                                        $order['mem_id'],
                                        $order['mem_id'] . '-' . $cor_id
                                    ]);
                                    $this->db->query("UPDATE cb_member SET mem_point=mem_point+? WHERE mem_id=?", [$refund_point, $order['mem_id']]);
                                }
                            } else {
                                // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
                                // reply_msg 가 실패에 대한 메세지
    //                        echo "결과코드		: ".$REPLYCD."<br>";
    //                        echo "결과메세지		: ".$REPLYMSG."<br>";
                                alert($REPLYCD . ':' . $REPLYMSG);
                            }
                        } elseif ($pg == 'payco') {
                            //--------------------------------------------------------------------------------
                            // PAYCO 주문 취소 페이지 샘플 ( PHP )
                            // payco_cancel.php
                            // 2015-03-25	PAYCO기술지원 <dl_payco_ts@nhnent.com>
                            //--------------------------------------------------------------------------------

                            //--------------------------------------------------------------------------------
                            // 이 문서는 json 형태의 데이터를 반환합니다.
                            //--------------------------------------------------------------------------------
                            header('Content-type: text/html; charset: UTF-8');
                            include("application/libraries/pg/payco/payco_util.php");
                            $this->payco_info();

                            $paycoLog = $this->{$this->modelname}->get_payco_log_by_cor_id($cor_id);
                            if (empty($paycoLog)) {
                                alert('페이코 결제취소 중 오류가 발생하였습니다.');
                            }
                            $paycoLogRawData = json_decode($paycoLog['raw_data'], true);

                            //---------------------------------------------------------------------------------
                            // 가맹점 주문 번호로 상품 불러오기
                            // DB에 연결해서 가맹점 주문 번호로 해당 상품 목록을 불러옵니다.
                            //---------------------------------------------------------------------------------
                            $resultValue = array();	//결과 리턴용 JSON 변수 선언

                            $orderCertifyKey				= $paycoLogRawData['result']["orderCertifyKey"];							// 주문완료통보시 내려받은 인증값
                            $cancelTotalAmt					= $paycoLogRawData['result']["totalOrderAmt"];							// 총 주문 금액
                            $requestMemo					= '결제취소';								// 취소처리 요청메모

                            $orderNo						= $paycoLogRawData['result']["orderNo"];									// 주문번호
                            $totalCancelTaxfreeAmt			= $paycoLogRawData['result']['paymentDetails'][0]["taxfreeAmt"];					// 총 취소할 면세금액
                            $totalCancelTaxableAmt			= $paycoLogRawData['result']['paymentDetails'][0]["taxableAmt"];					// 총 취소할 과세금액
                            $totalCancelVatAmt				= $paycoLogRawData['result']['paymentDetails'][0]["vatAmt"];						// 총 취소할 부가세
                            $totalCancelPossibleAmt			= $paycoLogRawData['result']['paymentDetails'][0]["paymentAmt"];					// 총 취소가능금액(현재기준): 취소가능금액 검증(취소요청 전 취소할수있는 총금액)

                            //----------------------------------------------------------------------------------
                            // 상품정보 변수 선언 및 초기화
                            //----------------------------------------------------------------------------------
                            Global $cpId, $productId;

                            //-----------------------------------------------------------------------------------
                            // 취소 내역을 담을 JSON OBJECT를 선언합니다.
                            //-----------------------------------------------------------------------------------
                            $cancelOrder = array();

                            //---------------------------------------------------------------------------------
                            // 설정한 주문정보 변수들로 Json String 을 작성합니다.
                            //---------------------------------------------------------------------------------

                            $cancelOrder["sellerKey"]				= $this->payInfo['sellerKey'];							//가맹점 코드. payco_config.php 에 설정
                            $cancelOrder["orderCertifyKey"]			= $orderCertifyKey;						//주문완료통보시 내려받은 인증값
                            $cancelOrder["requestMemo"]				= urlencode($requestMemo);				//취소처리 요청메모
                            $cancelOrder["cancelTotalAmt"]			= $cancelTotalAmt;						//주문서의 총 금액을 입력합니다. (전체취소, 부분취소 전부다)
//                            $cancelOrder["orderProducts"]			= $orderProducts;						//위에서 작성한 상품목록과 배송비상품을 입력

                            $cancelOrder["orderNo"]					= $orderNo;								// 주문번호
                            $cancelOrder["totalCancelTaxfreeAmt"]	= $totalCancelTaxfreeAmt;				// 총 취소할 면세금액
                            $cancelOrder["totalCancelTaxableAmt"]	= $totalCancelTaxableAmt;				// 총 취소할 과세금액
                            $cancelOrder["totalCancelVatAmt"]		= $totalCancelVatAmt;					// 총 취소할 부가세
                            $cancelOrder["totalCancelPossibleAmt"]	= $totalCancelPossibleAmt;				// 총 취소가능금액(현재기준): 취소가능금액 검증
                            //---------------------------------------------------------------------------------
                            // 주문 결제 취소 가능 여부 API 호출 ( JSON 데이터로 호출 )
                            //---------------------------------------------------------------------------------
                            $Result = payco_cancel($this->payInfo['URL_cancel'], urldecode(stripslashes(json_encode($cancelOrder))));
                            $cancelResult = json_decode($Result, treu);
                            if (empty($cancelResult['code']) || $cancelResult['code'] != 0) {
                                alert('페이코 결제취소 중 오류가 발생하였습니다.\n' . $cancelResult['message'] . '(' . $cancelResult['code'] . ')');
                            }

                            $params = array();
                            $params['code'] = $cancelResult['code'];
                            $params['message'] = $cancelResult['message'];
                            $params['order_no'] = $cancelResult['result']['orderNo'];
                            $params['amt'] = $cancelResult['result']['totalCancelPaymentAmt'];
                            $params['complete_ymdt'] = $cancelResult['result']['cancelYmdt'];
                            $params['raw_data'] = $Result;
                            $this->{$this->modelname}->payco_log_insert($params);

                            $origin_cor_status = $order['cor_status'];
                            $refund_price = intval($params['amt']);
                            $refund_point = intval($order['cor_point']);
                            $refund_datetime = DateTime::createFromFormat("YmdHis", $cancelResult['result']['cancelYmdt']);

                            $updatedata = array();
                            $updatedata['status'] = 'cancel';
                            $updatedata['cor_refund_datetime'] = $refund_datetime->format("Y-m-d H:i:s");
                            if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                $updatedata['cor_cancel_datetime'] = $refund_datetime->format("Y-m-d H:i:s");
                                $updatedata['cor_refund_price'] = $refund_price;
                                $updatedata['cor_refund_point'] = $refund_point;
                                $updatedata['cor_status'] = 2;
                            }

                            $where = array(
                                'cor_id' => $cor_id,
                            );
                            $this->Cmall_order_model->update('', $updatedata, $where);

                            if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='cancel' WHERE cor_id=?", [$cor_id]);
                            }

                            if ($refund_point > 0) {
                                $this->db->query("INSERT INTO cb_point (mem_id, poi_datetime, poi_content, poi_point, poi_type, poi_related_id, poi_action) VALUES (?, ?, ?, ?, ?, ?, ?)", [
                                    $order['mem_id'],
                                    cdate('Y-m-d H:i:s'),
                                    cdate('Y-m-d H:i:s') . ' 주문취소',
                                    $refund_point,
                                    'refund',
                                    $order['mem_id'],
                                    $order['mem_id'] . '-' . $cor_id
                                ]);
                                $this->db->query("UPDATE cb_member SET mem_point=mem_point+? WHERE mem_id=?", [$refund_point, $order['mem_id']]);
                            }
                        } elseif ($pg == 'paypal') {
                            $is_test = $order['is_test'];
                            $sql = "SELECT * FROM cb_paypal_log WHERE invoice_number=?";
                            $paypal_log = $this->db->query($sql, [$cor_id])->row_array();
                            $pay_id = $paypal_log['id'];

                            $refund_price = floatval($order['cor_refund_price']);
                            $refund_point = intval($order['cor_refund_point']);

                            $origin_cor_status = $order['cor_status'];
                            if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                $refund_price = floatval($order['cor_total_money']) - intval($order['cor_point']);
                                $refund_point = intval($order['cor_point']);
                            }

                            try {
                                $apiContext = $this->_get_paypal_api_context($is_test);
                                $payment = Payment::get($pay_id, $apiContext);
                                $transaction = $payment->getTransactions()[0];
                                $relatedResource = $transaction->getRelatedResources()[0];
                                $sale = $relatedResource->getSale();
                                $sale_id = $sale->getId();

                                $amt = new Amount();
                                $amt->setCurrency('USD')->setTotal($refund_price);
                                $refundRequest = new RefundRequest();
                                $refundRequest->setAmount($amt);
                                $sale = new Sale();
                                $sale->setId($sale_id);

                                $refundedSale = $sale->refundSale($refundRequest, $apiContext);
                                $params = array();

                                $params['id'] = $refundedSale->getId();
                                $params['create_time'] = $refundedSale->getCreateTime();
                                $params['update_time'] = $refundedSale->getUpdateTime();
                                $params['state'] = $refundedSale->getState();
                                $params['invoice_number'] = $refundedSale->getInvoiceNumber();
                                $params['amount'] = $refundedSale->getAmount()->getTotal();
                                $params['currency'] = $refundedSale->getAmount()->getCurrency();
                                $params['links'] = json_encode($refundedSale->getLinks());

                                $this->Cmall_order_model->paypal_log_insert($params);

                                $dt = new DateTime($refundedSale->getCreateTime());
                                $kstTimezone = new DateTimeZone('Asia/Seoul');
                                $dt->setTimezone($kstTimezone);
                                $create_time = $dt->format("Y-m-d H:i:s");

                                $updatedata = array();
                                $updatedata['status'] = 'cancel';
                                $updatedata['cor_refund_datetime'] = $create_time;
                                if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                    $updatedata['cor_cancel_datetime'] = $create_time;
                                    $updatedata['cor_refund_price'] = $refund_price;
                                    $updatedata['cor_refund_point'] = $refund_point;
                                    $updatedata['cor_status'] = 2;
                                }

                                $where = array(
                                    'cor_id' => $cor_id,
                                );
                                $this->Cmall_order_model->update('', $updatedata, $where);

                                if ($origin_cor_status == '1' || $origin_cor_status == '0') { // 관리자 취소
                                    $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='cancel' WHERE cor_id=?", [$cor_id]);
                                }

                                if ($refund_point > 0) {
                                    $this->db->query("INSERT INTO cb_point (mem_id, poi_datetime, poi_content, poi_point, poi_type, poi_related_id, poi_action) VALUES (?, ?, ?, ?, ?, ?, ?)", [
                                        $order['mem_id'],
                                        cdate('Y-m-d H:i:s'),
                                        cdate('Y-m-d H:i:s') . ' 주문취소',
                                        $refund_point,
                                        'refund',
                                        $order['mem_id'],
                                        $order['mem_id'] . '-' . $cor_id
                                    ]);
                                    $this->db->query("UPDATE cb_member SET mem_point=mem_point+? WHERE mem_id=?", [$refund_point, $order['mem_id']]);
                                }

                            } catch (Exception $exception) {
                                if ($is_test == '1') {
                                    $paypal_id = $this->cbconfig->item('pg_paypal_sandbox_id');
                                    $paypal_secret = $this->cbconfig->item('pg_paypal_sandbox_secret');
                                } else {
                                    $paypal_id = $this->cbconfig->item('pg_paypal_live_id');
                                    $paypal_secret = $this->cbconfig->item('pg_paypal_live_secret');
                                }

                                alert('paypal 결제취소 중 오류가 발생하였습니다.\n' . $exception->getMessage() . '\n' . $paypal_id . '\n' . $paypal_secret . '\nis test : ' . $is_test);
                                log_message('error', $exception->getMessage());
                            }
                        }
                    }
                }
            } else if ($pcase === 'info') {
                $cor_admin_memo = $this->input->post('cor_admin_memo');
                $cor_memo = $this->input->post('cor_memo');

                // 주문정보
                $info = get_cmall_order_data($cor_id, false);

                if (!$info)
                    alert('주문자료가 존재하지 않습니다.');

                // 결제정보 반영
                $updatedata = array(
                    'cor_admin_memo' => $cor_admin_memo,
                    'cor_memo' => $cor_memo,
                );

                $where = array(
                    'cor_id' => $cor_id,
                );

                $this->Cmall_order_model->update('', $updatedata, $where);
            }

            redirect(current_full_url(), 'refresh');
        }

        if ($this->member->is_admin() === false) {
            alert('잘못된 접근입니다');
        }
        $orderdetail = $this->Cmall_order_detail_model->get_by_item($cor_id);
        if ($orderdetail) {
            foreach ($orderdetail as $key => $value) {
                $orderdetail[$key]['item'] = $item
                    = $this->Cmall_item_model->get_one(element('cit_id', $value));
                $orderdetail[$key]['itemdetail'] = $itemdetail
                    = $this->Cmall_order_detail_model
                    ->get_detail_by_item($cor_id, element('cit_id', $value));

                if (element('cod_status', element(0, $itemdetail)) == 'order') {
                    if (strcasecmp(element('cde_title', element(0, $itemdetail)), "LEASE") == 0) {
                        if (element('cor_approve_datetime', $order)) {
                            $endtimestamp = strtotime(element('cor_approve_datetime', $order))
                                + 86400 * 60;
                            $orderdetail[$key]['item']['download_end_date'] = $enddate
                                = cdate('Y-m-d', $endtimestamp);

                            $orderdetail[$key]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
                        } else {
                            $orderdetail[$key]['item']['possible_download'] = 0;
                        }
                    } elseif(strcasecmp(element('cde_title', element(0, $itemdetail)), "STEM") == 0) {
                        $orderdetail[$key]['item']['possible_download'] = 1;
                    } else {
                        $orderdetail[$key]['item']['possible_download'] = 0;
                    }
                } else {
                    $orderdetail[$key]['item']['possible_download'] = 0;
                }
            }
        }

        $view['view']['data'] = $order;
        $view['view']['orderdetail'] = $orderdetail;

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'form');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));

    }

    public function ajax_cancelorder() {
        // return json_encode([]);
    }

    public function _get_paypal_api_context($is_test)
    {
        if ($is_test == '1') {
            $paypal_sandbox_id = $this->cbconfig->item('pg_paypal_sandbox_id');
            $paypal_sandbox_secret = $this->cbconfig->item('pg_paypal_sandbox_secret');
            return new ApiContext(new OAuthTokenCredential($paypal_sandbox_id, $paypal_sandbox_secret));
        }

        $paypal_live_id = $this->cbconfig->item('pg_paypal_live_id');
        $paypal_live_secret = $this->cbconfig->item('pg_paypal_live_secret');
        $apiContext = new ApiContext(new OAuthTokenCredential($paypal_live_id, $paypal_live_secret));
        $apiContext->setConfig(array(
            'mode' => 'live'
        ));
        return $apiContext;
    }

    public function payco_info()
    {
        //----------------------------------------------------------------------------------------------------------------------
        // 캐릭터셋 지정
        //-----------------------------------------------------------------------------------------------------------------------
        // header("charset=utf8");

        //-----------------------------------------------------------------------------------------------------------------------
        //
        // 환경변수 선언
        //
        //------------------------------------------------------------------------------------------------------------------------
        // 가맹점 코드 선언 ( 가맹점 수정 부분 )
        //------------------------------------------------------------------------------------------------------------------------

        $this->payInfo['sellerKey'] = "V4MTUT";                                    //(필수) 가맹점 코드 - 파트너센터에서 알려주는 값으로, 초기 연동 시 PAYCO에서 쇼핑몰에 값을 전달한다.
        $this->payInfo['cpId'] = "V4MTUT";                                    //(필수) 상점ID, 30자 이내
        $this->payInfo['productId'] = "V4MTUT_EASYP";                                    //(필수) 상품ID, 50자 이내
        $this->payInfo['deliveryId'] = "DELIVERY_PROD";                                    //(필수) 배송비상품ID, 50자 이내
        $this->payInfo['deliveryReferenceKey'] = "DV0001";                                    //(필수) 가맹점에서 관리하는 배송비상품 연동 키, 100자 이내, 고정

        //-------------------------------------------------------------------------------------------------------------------------
        // 가맹점 API 가 호출 당할 경우 도메인 또는 아이피 셋팅하기 위한 변수 ( 도메인이 있을 경우 도메인을 셋팅하시면 됩니다. )
        // 용도 : serviceUrl 및 returnUrl, nonBankbookDepositInformUrl 용.
        // API 호출시 http:// 부터 경로를 전체적으로 써줘야 HttpRequest 통신시 오류발생 안함.
        //--------------------------------------------------------------------------------------------------------------------------

        //	$AppWebPath = "http://xxx.xxx.xxx.xxx/php/easypay/pay2/";
        $this->payInfo['AppWebPath'] = "https://beatsomeone.com/pg/payco/";
//        $this->payInfo['AppWebPath'] = "https://mvp.beatsomeone.com/pg/payco/";

        //--------------------------------------------------------------------------------------------------------------------------
        // 운영/개발 설정
        // Log 사용 여부 설정
        //---------------------------------------------------------------------------------------------------------------------------
        $this->payInfo['appMode'] = "REAL";        // REAL - 실서버 운영, TEST - 개발(테스트)
        $this->payInfo['LogUse'] = false;            // Log 사용 여부 ( True = 사용, False = 미사용 )

        //---------------------------------------------------------------------------------------------------------------------------
        // API 주소 설정 ( 상단 appMode 에 따라 테스트와 실서버로 분기됩니다. )
        //--------------------------------------------------------------------------------------------------------------------------
        if ($this->payInfo['appMode'] == "TEST") {
            $this->payInfo['URL_reserve'] = "https://alpha-api-bill.payco.com/outseller/order/reserve";
            $this->payInfo['URL_approval'] = "https://alpha-api-bill.payco.com/outseller/payment/approval";
            $this->payInfo['URL_cancel_check'] = "https://alpha-api-bill.payco.com/outseller/order/cancel/checkAvailability";
            $this->payInfo['URL_cancel'] = "https://alpha-api-bill.payco.com/outseller/order/cancel";
            $this->payInfo['URL_upstatus'] = "https://alpha-api-bill.payco.com/outseller/order/updateOrderProductStatus";
            $this->payInfo['URL_cancelMileage'] = "https://alpha-api-bill.payco.com/outseller/order/cancel/partMileage";
            $this->payInfo['URL_checkUsability'] = "https://alpha-api-bill.payco.com/outseller/code/checkUsability";
            $this->payInfo['URL_detailForVerify'] = "https://alpha-api-bill.payco.com/outseller/payment/approval/getDetailForVerify"; // alpha(개발) 결제상세 조회(검증용)API URL
        } else {
            $this->payInfo['URL_reserve'] = "https://api-bill.payco.com/outseller/order/reserve";
            $this->payInfo['URL_approval'] = "https://api-bill.payco.com/outseller/payment/approval";
            $this->payInfo['URL_cancel_check'] = "https://api-bill.payco.com/outseller/order/cancel/checkAvailability";
            $this->payInfo['URL_cancel'] = "https://api-bill.payco.com/outseller/order/cancel";
            $this->payInfo['URL_upstatus'] = "https://api-bill.payco.com/outseller/order/updateOrderProductStatus";
            $this->payInfo['URL_cancelMileage'] = "https://api-bill.payco.com/outseller/order/cancel/partMileage";
            $this->payInfo['URL_checkUsability'] = "https://api-bill.payco.com/outseller/code/checkUsability";
            $this->payInfo['URL_detailForVerify'] = "https://api-bill.payco.com/outseller/payment/approval/getDetailForVerify";      // (운영)결제상세 조회(검증용)API URL
        }

        //--------------------------------------------------------------------------------------------------------------------------
        // 로그 파일 선언
        //--------------------------------------------------------------------------------------------------------------------------
        $todate = str_replace("-", "", date("Y-m-d"));
        $Write_LogFile = "log" . DIRECTORY_SEPARATOR . "Payco_Log_" . $todate . "_php.txt";

        //--------------------------------------------------------------------------------------------------------------------------
        // 접속 브라우저 확인
        //--------------------------------------------------------------------------------------------------------------------------
        if (preg_match('/(iPhone|iPod|iPad|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mni|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson|LG|SAMSUNG|Samsung)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $this->payInfo['isMobile'] = 0;
            // echo "모바일 웹 브라우저 입니다.";
        } else {
            // echo "웹 브라우저 입니다.";
            $this->payInfo['isMobile'] = 1;
        }
    }
}
