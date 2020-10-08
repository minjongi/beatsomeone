<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

defined('BASEPATH') or exit('No direct script access allowed');

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
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $mem_id = $this->member->item('mem_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $offset = ($page - 1) * 20;
        $result = $this->_get_settlement_data($mem_id, $start_date, $end_date);

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
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $mem_id = $this->member->item('mem_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $offset = ($page - 1) * 20;

        $result = $this->_get_complete_data($mem_id, $start_date, $end_date);

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

    public function _get_settlement_data($mem_id, $start_date, $end_date)
    {
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
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 ) AND co.cor_datetime >= ? AND co.cor_datetime <=?
                ORDER BY co.cor_datetime DESC";

        $sql_total_stay_rows = "SELECT COUNT(*) as rownum 
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 )";

        $sql_total_complete_rows = "SELECT COUNT(*) as rownum 
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND csh_status = 1";

        $sql_total_money = "SELECT SUM(total_money) as total FROM (SELECT 
                       CASE
                           WHEN co.cor_pg = 'allat' THEN cid.cde_price
                           WHEN co.cor_pg = 'paypal' THEN cid.cde_price_d
                           ELSE cid.cde_price END                               as total_money
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 ) AND co.cor_datetime >= ? AND co.cor_datetime <=? AND cid.cde_title LIKE ? AND co.cor_pg = ?) as settle_data";

        $sql_total_settle = "SELECT SUM(csh_settle_money) as total FROM (SELECT 
                       IFNULL(csh.csh_settle_money, CASE
                                                        WHEN co.cor_pg = 'allat' THEN cid.cde_price
                                                        WHEN co.cor_pg = 'paypal' THEN cid.cde_price_d
                                                        ELSE cid.cde_price END) * (100 - mg.mgr_commission) / 100.0 as csh_settle_money
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 ) AND co.cor_datetime >= ? AND co.cor_datetime <=? AND cid.cde_title LIKE ? AND co.cor_pg = ?) as settle_data";

        $sql_total_amount = "SELECT COUNT(*) as rownum
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 ) AND co.cor_datetime >= ? AND co.cor_datetime <=? AND cid.cde_title = ?";
        $sql_mgr_commission = "SELECT mgr_commission FROM cb_member as m 
                LEFT JOIN cb_member_group_member mgm on m.mem_id = mgm.mem_id
                LEFT JOIN cb_member_group mg on mgm.mgr_id = mg.mgr_id WHERE m.mem_id=?";

        $result['list'] = $this->db->query($sql, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59'])->result_array();
        $result['total_stay_rows'] = ($this->db->query($sql_total_stay_rows, [$mem_id])->row_array())['rownum'];
        $result['total_complete_rows'] = ($this->db->query($sql_total_complete_rows, [$mem_id])->row_array())['rownum'];
        $result['total_lease_money'] = ($this->db->query($sql_total_money, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', 'LEASE', 'allat'])->row_array())['total'];
        $result['total_lease_money_d'] = ($this->db->query($sql_total_money, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', 'LEASE', 'paypal'])->row_array())['total'];
        $result['total_stem_money'] = ($this->db->query($sql_total_money, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', 'STEM', 'allat'])->row_array())['total'];
        $result['total_stem_money_d'] = ($this->db->query($sql_total_money, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', 'STEM', 'paypal'])->row_array())['total'];
        $result['total_lease_amount'] = ($this->db->query($sql_total_amount, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', 'LEASE'])->row_array())['rownum'];
        $result['total_stem_amount'] = ($this->db->query($sql_total_amount, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', 'STEM'])->row_array())['rownum'];
        $result['total_money'] = ($this->db->query($sql_total_money, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', '%%', 'allat'])->row_array())['total'];
        $result['total_money_d'] = ($this->db->query($sql_total_money, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', '%%', 'paypal'])->row_array())['total'];
        $result['total_settle_money'] = ($this->db->query($sql_total_settle, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', '%%', 'allat'])->row_array())['total'];
        $result['total_settle_money_d'] = ($this->db->query($sql_total_settle, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59', '%%', 'paypal'])->row_array())['total'];
        $result['mgr_commission'] = ($this->db->query($sql_mgr_commission, [$mem_id])->row_array())['mgr_commission'];
        return $result;
    }

    public function _get_complete_data($mem_id, $start_date, $end_date)
    {
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
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND csh_status = 1 AND co.cor_datetime >= ? AND co.cor_datetime <=?";
        $sql2 = "SELECT COUNT(*) as rownum 
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND (csh_status IS NULL OR csh_status = 0 )";

        $sql3 = "SELECT COUNT(*) as rownum 
                FROM cb_cmall_order_detail AS cod
                         LEFT JOIN cb_cmall_settlement_history AS csh ON csh.cod_id = cod.cod_id
                         LEFT JOIN cb_cmall_order as co ON co.cor_id = cod.cor_id
                         LEFT JOIN cb_cmall_item as ci ON cod.cit_id = ci.cit_id
                         LEFT JOIN cb_cmall_item_detail as cid ON cid.cde_id = cod.cde_id
                         LEFT JOIN cb_member as m ON m.mem_id = ci.mem_id
                         LEFT JOIN cb_member_group_member as mgm ON m.mem_id = mgm.mem_id
                         LEFT JOIN cb_member_group as mg ON mg.mgr_id = mgm.mgr_id 
                WHERE ci.mem_id = ? AND csh_status = 1";

        $result['list'] = $this->db->query($sql, [$mem_id, $start_date . ' 00:00:00', $end_date . ' 23:59:59'])->result_array();
        $result['total_stay_rows'] = ($this->db->query($sql2, [$mem_id])->row_array())['rownum'];
        $result['total_complete_rows'] = ($this->db->query($sql3, [$mem_id])->row_array())['rownum'];
        return $result;
    }

    public function save_account()
    {
        ajax_required_user_login();

        $mem_id = $this->member->item('mem_id');

        $bank_name = $this->input->post('bank_name');
        $account_number = $this->input->post('account_number');
        $recipient = $this->input->post('recipient');
        $file = $_FILES['file_attach'];

        $this->db->query('UPDATE cb_member SET mem_bank_name=?, mem_account_number=?, mem_recipient=? WHERE mem_id=?', [
            $bank_name,
            $account_number,
            $recipient,
            $mem_id
        ]);

        $result = [
            'message' => 'Success'
        ];
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function ajax_download()
    {
        ajax_required_user_login();

        $mem_id = $this->member->item('mem_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $result = $this->_get_settlement_data($mem_id, $start_date, $end_date);
        $rows = $result['list'];

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

// Set document properties
        $spreadsheet->getProperties()->setCreator('Beatsomeone')
            ->setLastModifiedBy('Beatsomeone')
            ->setTitle('Beatsomeone Settlement History')
            ->setSubject('')
            ->setDescription('');

// Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Date')
            ->setCellValue('C1', 'Product')
            ->setCellValue('D1', 'Total Price')
            ->setCellValue('E1', 'Order Status')
            ->setCellValue('F1', 'Settlement')
            ->setCellValue('G1', 'Status');
        foreach ($rows as $i => $row) {
            $total_money = $row['total_money'];
            $pg = $row['cor_pg'];
            if ($pg == 'allat') {
                $formatted_total = '₩ ' . number_format(floatval($total_money));
            } else {
                $formatted_total = '$ ' . number_format(floatval($total_money), 2);
            }
            $cod_status = $row['cod_status'];
            if ($cod_status == 'order') {
                $status = 'Order Complete';
            } elseif ($cod_status == 'deposit') {
                $status = 'Deposit Waiting';
            } else {
                $status = 'Cancelled';
            }
            $settle_money = $row['csh_settle_money'];
            if ($pg == 'allat') {
                $formatted_settle = '₩ ' . number_format(floatval($settle_money));
            } else {
                $formatted_settle = '$ ' . number_format(floatval($settle_money), 2);
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+2), $row['cor_id'].' ')
                ->setCellValue('B'.($i+2), $row['cor_datetime'])
                ->setCellValue('C'.($i+2), $row['item_name'])
                ->setCellValue('D'.($i+2), $formatted_total)
                ->setCellValue('E'.($i+2), $status)
                ->setCellValue('F'.($i+2), $formatted_settle)
                ->setCellValue('G'.($i+2), 'Stay');
        }

        $spreadsheet->getActiveSheet()->setTitle('Settlement History');

        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="settlement_history.xls"');
        header('Cache-Control: max-age=0');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function ajax_download_complete()
    {
        ajax_required_user_login();

        $mem_id = $this->member->item('mem_id');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $result = $this->_get_complete_data($mem_id, $start_date, $end_date);
        $rows = $result['list'];

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

// Set document properties
        $spreadsheet->getProperties()->setCreator('Beatsomeone')
            ->setLastModifiedBy('Beatsomeone')
            ->setTitle('Beatsomeone Settlement History(Complete)')
            ->setSubject('')
            ->setDescription('');

// Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Date')
            ->setCellValue('C1', 'Order Total')
            ->setCellValue('D1', 'Fee')
            ->setCellValue('E1', 'Total Settlement')
            ->setCellValue('F1', 'Status');
        foreach ($rows as $i => $row) {
            $total_money = $row['total_money'];
            $pg = $row['cor_pg'];
            if ($pg == 'allat') {
                $formatted_total = '₩ ' . number_format(floatval($total_money));
            } else {
                $formatted_total = '$ ' . number_format(floatval($total_money), 2);
            }
            $cod_status = $row['cod_status'];
            if ($cod_status == 'order') {
                $status = 'Order Complete';
            } elseif ($cod_status == 'deposit') {
                $status = 'Deposit Waiting';
            } else {
                $status = 'Cancelled';
            }
            $settle_money = $row['csh_settle_money'];
            if ($pg == 'allat') {
                $formatted_settle = '₩ ' . number_format(floatval($settle_money));
            } else {
                $formatted_settle = '$ ' . number_format(floatval($settle_money), 2);
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+2), $row['cor_id'].' ')
                ->setCellValue('B'.($i+2), $row['cor_datetime'])
                ->setCellValue('C'.($i+2), $formatted_total)
                ->setCellValue('D'.($i+2), $row['mgr_commission'] . '%')
                ->setCellValue('E'.($i+2), $formatted_settle)
                ->setCellValue('F'.($i+2), 'Complete');
        }

        $spreadsheet->getActiveSheet()->setTitle('Settlement History(Complete)');

        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="settlement_history.xls"');
        header('Cache-Control: max-age=0');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }
}