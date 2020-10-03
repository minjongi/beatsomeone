<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settlement extends CB_Controller
{
    protected $helpers = array('form', 'array');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('pagination', 'querystring'));
    }

    public function index()
    {
        ajax_required_user_login();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

        $mem_id = $this->member->item('mem_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $offset = ($page - 1) * 20;

        $result = array();
        $sql = "SELECT cod.cod_id, cod.cor_id, co.cor_datetime,
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
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 )";
        $sql2 = "SELECT COUNT(*) as total_rows 
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 )";

        //        $result = $this->Cmall_order_detail_model->get_settlement_data($mem_id, $start_date, $end_date, $offset, 20);

        $result['total_rows'] = ($this->db->query($sql2, [$mem_id])->row_array())['total_rows'];
        $result['list'] = $this->db->query($sql, [$mem_id])->result_array();

        /**
         * 페이지네이션을 생성합니다
         */

        $config['base_url'] = '/settlement' . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = 20;
        if ($this->cbconfig->get_device_view_type() === 'mobile') {
            $config['num_links'] = 3;
        } else {
            $config['num_links'] = 5;
        }
        $this->pagination->initialize($config);
        $result['paging'] = $this->pagination->create_links();
        $result['page'] = $page;

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function complete_list()
    {
        ajax_required_user_login();

        $param =& $this->querystring;
        $page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;

        $mem_id = $this->member->item('mem_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $offset = ($page - 1) * 20;

        $result = array();
        $sql = "SELECT cod.cod_id, cod.cor_id, co.cor_datetime,
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
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id WHERE ci.mem_id = ? AND csh_status = 1";
        $sql2 = "SELECT COUNT(*) as total_rows 
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id WHERE ci.mem_id = ? AND csh_status = 1";

        //        $result = $this->Cmall_order_detail_model->get_settlement_data($mem_id, $start_date, $end_date, $offset, 20);

        $result['total_rows'] = ($this->db->query($sql2, [$mem_id])->row_array())['total_rows'];
        $result['list'] = $this->db->query($sql, [$mem_id])->result_array();

        /**
         * 페이지네이션을 생성합니다
         */

        $config['base_url'] = '/settlement' . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = 20;
        if ($this->cbconfig->get_device_view_type() === 'mobile') {
            $config['num_links'] = 3;
        } else {
            $config['num_links'] = 5;
        }
        $this->pagination->initialize($config);
        $result['paging'] = $this->pagination->create_links();
        $result['page'] = $page;

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function save_account()
    {
        $bank_name = $this->input->post('bank_name');
        $account_number = $this->input->post('account_number');
        $receipent = $this->input->post('receipent');
        $file = $_FILES['file_attach'];



        $result = [
            'message' => 'Success'
        ];
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }
}