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

        $this->load->model(array('Cmall_order_detail_model'));

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $offset = ($page - 1) * 20;

        $result = $this->Cmall_order_detail_model->get_settlement_data($mem_id, $start_date, $end_date, $offset, 20);

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

        $this->load->model(array('Cmall_order_detail_model'));

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $offset = ($page - 1) * 20;

        $result = $this->Cmall_order_detail_model->get_settlement_complete_data($mem_id, $start_date, $end_date, $offset, 20);

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