<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settlement extends CB_Controller
{
    /**
     * 관리자 페이지 상의 현재 디렉토리입니다
     * 페이지 이동시 필요한 정보입니다
     */
    public $pagedir = 'cmall/settlement';

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Cmall_settlement_history');

    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Cmall_settlement_history_model';

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

    public function index()
    {
        $view = array();
        $view['view'] = array();

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
        $forder = $this->input->get('forder', null, 'desc');
        $sfield = $this->input->get('sfield', null, '');
        $skeyword = $this->input->get('skeyword', null, '');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $this->{$this->modelname}->allow_search_field = array('mll_id', 'mll_userid', 'mll_success', 'member_login_log.mem_id', 'mll_datetime', 'mll_ip', 'mll_reason', 'mll_log_agent', 'mll_url', 'mll_referer'); // 검색이 가능한 필드
        $this->{$this->modelname}->search_field_equal = array('mll_id', 'member_login_log.mem_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
        $this->{$this->modelname}->allow_order_field = array('mll_id'); // 정렬이 가능한 필드
        $result = array();
        $sql = "SELECT COUNT(*) as total_rows FROM cb_cmall_order_detail AS cod
         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id";
        $total_rows = ($this->db->query($sql)->row_array())['total_rows'];
        $result['total_rows'] = $total_rows;
//        $result = $this->{$this->modelname}
//            ->get_admin_list($per_page, $offset, '', '', $findex, $forder, $sfield, $skeyword);
        $sql = "SELECT cod.cod_id, co.cor_datetime,
       co.mem_nickname                                          as buyer_nickname,
       m.mem_nickname                                           as seller_nickname,
       ci.cit_file_1,
       CONCAT(ci.cit_name, '(', cid.cde_title, ')')             as item_name,
       co.cor_pg,
       CASE
           WHEN co.cor_pg = 'allat' THEN cid.cde_price
           WHEN co.cor_pg = 'paypal' THEN cid.cde_price_d
           ELSE cid.cde_price END                               as total_money,
       cod.cod_status,
       csh.csh_datetime,
       IFNULL(csh.csh_settle_money, CASE
                                        WHEN co.cor_pg = 'allat' THEN cid.cde_price
                                        WHEN co.cor_pg = 'paypal' THEN cid.cde_price_d
                                        ELSE cid.cde_price END) * (100 - mg.mgr_commission) / 100.0 as csh_settle_money,
       csh.csh_status,
       mg.mgr_description,
       mg.mgr_commission
FROM cb_cmall_order_detail AS cod
         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id";
        $result['list'] = $this->db->query($sql)->result_array();
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['num'] = $list_num--;
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
        $search_option = array('csh_datetime' => '날짜', 'csh_status' => '상태');
        $view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
        $view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['listall_url'] = admin_url($this->pagedir);
        $view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());

        /**
         * 어드민 레이아웃을 정의합니다
         */
        $layoutconfig = array('layout' => 'layout', 'skin' => 'index');
        $view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function settle()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_cmall_settlement_settle';
        $this->load->event($eventname);

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
            foreach ($this->input->post('chk') as $cod_id) {
                if ($cod_id) {
                    $sql = "SELECT * FROM cb_cmall_settlement_history WHERE cod_id = ?";
                    $row = $this->db->query($sql, [$cod_id])->row_array();
                    $sql2 = "SELECT cod.cod_id, co.cor_datetime,
                                   co.mem_nickname                                          as buyer_nickname,
                                   m.mem_nickname                                           as seller_nickname,
                                   ci.cit_file_1,
                                   CONCAT(ci.cit_name, '(', cid.cde_title, ')')             as item_name,
                                   co.cor_pg,
                                   CASE
                                       WHEN co.cor_pg = 'allat' THEN cid.cde_price
                                       WHEN co.cor_pg = 'paypal' THEN cid.cde_price_d
                                       ELSE cid.cde_price END                               as total_money,
                                   cod.cod_status,
                                   csh.csh_datetime,
                                   IFNULL(csh.csh_settle_money, CASE
                                                                    WHEN co.cor_pg = 'allat' THEN cid.cde_price
                                                                    WHEN co.cor_pg = 'paypal' THEN cid.cde_price_d
                                                                    ELSE cid.cde_price END) * (100 - mg.mgr_commission) / 100.0 as csh_settle_money,
                                   csh.csh_status,
                                   mg.mgr_description,
                                   mg.mgr_commission
                            FROM cb_cmall_order_detail AS cod
                                     LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                                     LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                                     LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                                     LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                                     LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                                     LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                                     LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id WHERE cod.cod_id = ?";
                    $row2 = $this->db->query($sql2, [$cod_id])->row_array();
                    $total_money = $row2['total_money'];
                    $pg = $row2['cor_pg'];
                    if ($row) {
                        $sql3 = "UPDATE cb_cmall_settlement_history SET pg=?, csh_datetime=NOW(), csh_settle_money=?, csh_status=1 WHERE cod_id=?";
                        $this->db->query($sql3, [$pg, $total_money, $cod_id]);
                    } else {
                        $sql3 = "INSERT INTO cb_cmall_settlement_history (cod_id, pg, csh_datetime, csh_settle_money, csh_status) VALUES (?, ?, NOW(), ?, 1)";
                        $this->db->query($sql3, [$cod_id, $pg, $total_money]);
                    }
                }
            }
        }

        // 이벤트가 존재하면 실행합니다
        Events::trigger('after', $eventname);

        /**
         * 삭제가 끝난 후 목록페이지로 이동합니다
         */
        $this->session->set_flashdata(
            'message',
            '정상적으로 삭제되었습니다'
        );
        redirect(admin_url($this->pagedir));
    }
}