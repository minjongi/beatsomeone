<?php

use PayPal\Auth\OAuthTokenCredential;

defined('BASEPATH') or exit('No direct script access allowed');

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
                $total = 0.0;
                foreach ($orderdetail as $item) {
                    if ($pg == 'paypal') {
                        $total += floatval($item['cde_price_d']);
                    } elseif ($pg == 'allat') {
                        $total += intval($item['cde_price']);
                    }
                }
                // 결제정보 반영
                $updatedata = array(
                    'cor_status' => $cor_status,
                );

                if ($cor_status == '1') {
                    $updatedata['cor_cash_request'] = $total;
                    $updatedata['cor_cash'] = $total;
                    $where = array(
                        'cor_id' => $cor_id,
                    );
                    $this->Cmall_order_model->update('', $updatedata, $where);

                    $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='order' WHERE cor_id=?", [$cor_id]);
                } elseif ($cor_status == '0') {
                    $updatedata['cor_cash_request'] = $total;
                    $updatedata['cor_cash'] = 0;
                    $where = array(
                        'cor_id' => $cor_id,
                    );
                    $this->Cmall_order_model->update('', $updatedata, $where);
                    $this->db->query("UPDATE cb_cmall_order_detail SET cod_status='deposit' WHERE cor_id=?", [$cor_id]);
                } elseif ($cor_status == '2') {
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
                            $params['ORDER_NO'] = $cor_id;
                            $params['AMT'] = $this->input->post('allat_amt');
                            $params['PAY_TYPE'] = $PAY_TYPE;
                            $params['APPROVAL_YMDHMS'] = $CANCEL_YMDHMS;
                            $params['SAVE_AMT'] = $REMAIN_AMT;
                            $params['PARTCANCEL_YN'] = $PART_CANCEL_FLAG;
                            $params['RAW_DATA'] = $at_txt;

                            $this->Cmall_order_model->allat_log_insert($params);

                            $updatedata['cor_cash_request'] = $total;
                            $updatedata['cor_cash'] = $REMAIN_AMT;
                            $updatedata['status'] = 'cancel';
                            $updatedata['cor_refund_datetime'] = cdate('Y-m-d H:i:s');
                            $where = array(
                                'cor_id' => $cor_id,
                            );
                            $this->Cmall_order_model->update('', $updatedata, $where);
                        } else {
                            // reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
                            // reply_msg 가 실패에 대한 메세지
//                        echo "결과코드		: ".$REPLYCD."<br>";
//                        echo "결과메세지		: ".$REPLYMSG."<br>";
                            alert($REPLYCD . ':' . $REPLYMSG);
                        }
                    } elseif ($pg == 'paypal') {
//                        $credential = new OAuthTokenCredential($this->cbconfig->item('pg_paypal_'));
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
}
