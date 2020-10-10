<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmall order detail model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Cmall_order_detail_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cmall_order_detail';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cod_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}


	public function get_by_item($cor_id = 0)
	{
		$cor_id = preg_replace('/[^0-9]/', '', $cor_id);
		if (empty($cor_id) OR $cor_id < 1) {
			return;
		}

		$this->db->select('cit_id');
		$this->db->where('cor_id', $cor_id);
		$this->db->group_by('cit_id');
		$qry = $this->db->get($this->_table);
		$result = $qry->result_array();

		return $result;
	}


	public function get_detail_by_item($cor_id = 0, $cit_id = 0)
	{
		$cor_id = preg_replace('/[^0-9]/', '', $cor_id);
		if (empty($cor_id) OR $cor_id < 1) {
			return;
		}
		$cit_id = preg_replace('/[^0-9]/', '', $cit_id);
		if (empty($cit_id) OR $cit_id < 1) {
			return;
		}

		$this->db->select('cmall_item_detail.*, cmall_order_detail.cod_id, cmall_order_detail.cod_count, cmall_order_detail.cod_download_days, cmall_order_detail.cod_status, cmall_order_detail.cod_point');
		$this->db->from('cmall_order_detail');
		$this->db->join('cmall_item_detail', 'cmall_order_detail.cde_id = cmall_item_detail.cde_id', 'inner');
		$this->db->where('cmall_order_detail.cor_id', $cor_id);
		$this->db->where('cmall_order_detail.cit_id', $cit_id);
		$qry = $this->db->get();
		$result = $qry->result_array();

		return $result;
	}

	public function get_expired_items($mem_id)
    {
        $sql = "SELECT *
                FROM (SELECT cb_d.mem_id,
                             cb_d.cit_id,
                             i.cit_key,
                             i.cit_name,
                             p.mem_nickname,
                             i.cit_file_1                                                       as coverImg,
                             i.cit_type3,
                             DATE_ADD(o.cor_approve_datetime, INTERVAL 60 DAY)                  as expired_date,
                             DATEDIFF(DATE_ADD(o.cor_approve_datetime, INTERVAL 60 DAY), NOW()) as remain_days
                      FROM cb_cmall_order_detail as cb_d
                               LEFT JOIN cb_cmall_item_detail as id ON id.cde_id = cb_d.cde_id
                               LEFT JOIN cb_cmall_item as i ON i.cit_id = id.cit_id
                               LEFT JOIN cb_member as p ON p.mem_id = i.mem_id
                               LEFT JOIN cb_cmall_order as o ON o.cor_id = cb_d.cor_id
                      WHERE cb_d.mem_id = ?
                        AND id.cde_title = 'LEASE') as cdipo WHERE remain_days <= 7 LIMIT 6";
        $result = $this->db->query($sql, [$mem_id])->result_array();
        return $result;
    }

    public function totalSaleFundsCurrentMonth($mem_id)
    {
        $start_date = cdate('Y-m-01');

        $this->db->select('sum(cde.cde_price * cod.cod_count) as total, sum(cde.cde_price_d * cod.cod_count) as total_d');
        $this->db->from('cmall_order_detail as cod');
        $this->db->join('cmall_item_detail as cde', 'cod.cde_id = cde.cde_id', 'left');
        $this->db->join('cmall_order as co', 'cod.cor_id = co.cor_id', 'left');
        $this->db->where('co.cor_datetime >= ', $start_date . ' 00:00:00');
        $this->db->where('cde.mem_id = '. $mem_id);
        $qry = $this->db->get();
        $result = $qry->row_array();
        return $result;
    }

    public function totalSaleFundsLastMonth($mem_id)
    {
        $start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1, +1, date('Y')));
        $end_date = date('Y-m-t', mktime(0, 0, 0, date('m'), 0, date('Y')));

        $this->db->select('sum(cde.cde_price * cod.cod_count) as total, sum(cde.cde_price_d * cod.cod_count) as total_d');
        $this->db->from('cmall_order_detail as cod');
        $this->db->join('cmall_item_detail as cde', 'cod.cde_id = cde.cde_id', 'left');
        $this->db->join('cmall_order as co', 'cod.cor_id = co.cor_id', 'left');
        $this->db->where('co.cor_datetime >= ', $start_date . ' 00:00:00');
        $this->db->where('co.cor_datetime >= ', $end_date . ' 23:59:59');
        $this->db->where('cde.mem_id = '. $mem_id);
        $qry = $this->db->get();
        $result = $qry->row_array();
        return $result;
    }

    public function totalSaleFundsLastLastMonth($mem_id)
    {
        $start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-2, +1, date('Y')));
        $end_date = date('Y-m-t', mktime(0, 0, 0, date('m')-1, 0, date('Y')));

        $this->db->select('sum(cde.cde_price * cod.cod_count) as total, sum(cde.cde_price_d * cod.cod_count) as total_d');
        $this->db->from('cmall_order_detail as cod');
        $this->db->join('cmall_item_detail as cde', 'cod.cde_id = cde.cde_id', 'left');
        $this->db->join('cmall_order as co', 'cod.cor_id = co.cor_id', 'left');
        $this->db->where('co.cor_datetime >= ', $start_date . ' 00:00:00');
        $this->db->where('co.cor_datetime >= ', $end_date . ' 23:59:59');
        $this->db->where('cde.mem_id = '. $mem_id);
        $qry = $this->db->get();
        $result = $qry->row_array();
        return $result;
    }

    public function get_sale_data($mem_id)
    {
        $start_date = date('Y-m-d', mktime(0, 0, 0, date('m') , date('d')-28, date('Y')));
	    $sql = "SELECT sum(cod.cod_count * cid.cde_price) as total, sum(cod.cod_count * cid.cde_price_d) as total_d, CAST(co.cor_datetime AS DATE ) AS cor_date FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id WHERE cid.mem_id = ? AND co.cor_datetime >= ? GROUP BY cor_date;";
        $result = $this->db->query($sql, [$mem_id, $start_date])->result_array();
	    return $result;
    }

    public function get_settlement_data($mem_id, $start_date, $end_date, $offset = '', $limit = 0)
    {
        $result = array();
        if (empty($start_date) && empty($end_date)) {
            $sql = "SELECT co.cor_id, cor_datetime, cit_file_1, cit_name, cde_price_d, cde_price, cod_count, cod_status, csh_datetime, IF(csh_settle_money IS NULL, 0, csh_settle_money) as csh_settle_money, IF(csh_settle_money_d IS NULL, 0, csh_settle_money_d) as csh_settle_money_d, IF(csh_status IS NULL, 0, csh_status) as csh_status FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ?  ORDER BY cor_datetime DESC LIMIT ?, ?";
            $result['list'] = $this->db->query($sql, [$mem_id, $offset, $limit])->result_array();
        } else {
            $sql = "SELECT co.cor_id, cor_datetime, cit_file_1, cit_name, cde_price_d, cde_price, cod_count, cod_status, csh_datetime, IF(csh_settle_money IS NULL, 0, csh_settle_money) as csh_settle_money, IF(csh_settle_money_d IS NULL, 0, csh_settle_money_d) as csh_settle_money_d, IF(csh_status IS NULL, 0, csh_status) as csh_status FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND cor_datetime >= ? AND cor_datetime <= ? ORDER BY cor_datetime DESC LIMIT ?,?";
            $result['list'] = $this->db->query($sql, [$mem_id, $start_date, $end_date, $offset, $limit])->result_array();
        }

        if (empty($start_date) && empty($end_date)) {
            $sql = "SELECT COUNT(*) as rownum FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? ORDER BY cor_datetime DESC";
            $rows = $this->db->query($sql, [$mem_id])->row_array();
            $result['total_rows'] = $rows['rownum'];
        } else {
            $sql = "SELECT COUNT(*) as rownum FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND cor_datetime >= ? AND cor_datetime <= ? ORDER BY cor_datetime DESC";
            $rows = $this->db->query($sql, [$mem_id, $start_date, $end_date])->row_array();
            $result['total_rows'] = $rows['rownum'];
        }

        $sql = "SELECT SUM(cde_price_d * cod_count) as total_d, SUM(cde_price * cod_count) as total, SUM(cod_count) as count FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND cit_lease_license_use = 1;";
        $rows = $this->db->query($sql, [$mem_id])->row_array();
        $result['total_lease_money'] = $rows['total'];
        $result['total_lease_money_d'] = $rows['total_d'];
        $result['total_lease_amount'] = $rows['count'];

        $sql = "SELECT SUM(cde_price_d * cod_count) as total_d, SUM(cde_price * cod_count) as total, SUM(cod_count) as count FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND cit_mastering_license_use = 1;";
        $rows = $this->db->query($sql, [$mem_id])->row_array();
        $result['total_sale_money'] = $rows['total'];
        $result['total_sale_money_d'] = $rows['total_d'];
        $result['total_sale_amount'] = $rows['count'];

        $sql = "SELECT SUM(cde_price_d * cod_count) as total_d, SUM(cde_price * cod_count) as total, SUM(cod_count) as count FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ?";
        $rows = $this->db->query($sql, [$mem_id])->row_array();
        $result['total_money'] = $rows['total'];
        $result['total_money_d'] = $rows['total_d'];
        $result['total_amount'] = $rows['count'];

        return $result;
    }

    public function get_settlement_complete_data($mem_id, $start_date, $end_date, $offset = '', $limit = 0)
    {
        $result = array();
        if (empty($start_date) && empty($end_date)) {
            $sql = "SELECT co.cor_id, cor_datetime, cit_file_1, cit_name, cde_price_d, cde_price, cod_count, cod_status, csh_datetime, IF(csh_settle_money IS NULL, 0, csh_settle_money) as csh_settle_money, IF(csh_settle_money_d IS NULL, 0, csh_settle_money_d) as csh_settle_money_d, IF(csh_status IS NULL, 0, csh_status) as csh_status FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND csh_status = 1 ORDER BY cor_datetime DESC LIMIT ?, ?";
            $result['list'] = $this->db->query($sql, [$mem_id, $offset, $limit])->result_array();
        } else {
            $sql = "SELECT co.cor_id, cor_datetime, cit_file_1, cit_name, cde_price_d, cde_price, cod_count, cod_status, csh_datetime, IF(csh_settle_money IS NULL, 0, csh_settle_money) as csh_settle_money, IF(csh_settle_money_d IS NULL, 0, csh_settle_money_d) as csh_settle_money_d, IF(csh_status IS NULL, 0, csh_status) as csh_status FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? csh_status = 1 AND cor_datetime >= ? AND cor_datetime <= ? ORDER BY cor_datetime DESC LIMIT ?,?";
            $result['list'] = $this->db->query($sql, [$mem_id, $start_date, $end_date, $offset, $limit])->result_array();
        }

        if (empty($start_date) && empty($end_date)) {
            $sql = "SELECT COUNT(*) as rownum FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND csh_status = 1 ORDER BY cor_datetime DESC";
            $rows = $this->db->query($sql, [$mem_id])->row_array();
            $result['total_rows'] = $rows['rownum'];
        } else {
            $sql = "SELECT COUNT(*) as rownum FROM cb_cmall_order_detail as cod LEFT JOIN cb_cmall_item_detail cid on cod.cde_id = cid.cde_id LEFT JOIN cb_cmall_order co on cod.cor_id = co.cor_id LEFT JOIN cb_cmall_item ci on ci.cit_id = cid.cit_id LEFT JOIN cb_cmall_settlement_history csh on cod.cod_id = csh.cod_id WHERE cid.mem_id = ? AND cor_datetime >= ? AND cor_datetime <= ? AND csh_status = 1 ORDER BY cor_datetime DESC";
            $rows = $this->db->query($sql, [$mem_id, $start_date, $end_date])->row_array();
            $result['total_rows'] = $rows['rownum'];
        }

        return $result;
    }
}
