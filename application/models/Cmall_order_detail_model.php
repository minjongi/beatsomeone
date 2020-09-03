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

		$this->db->select('cmall_item_detail.*, cmall_order_detail.cod_count, cmall_order_detail.cod_download_days, cmall_order_detail.cod_status');
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
        $where = array(
            'd.mem_id' => $mem_id,
        );

        $this->db
            ->select('d.mem_id, d.cit_id, i.cit_key, i.cit_name, p.musician, i.cit_file_1 as coverImg, DATE_ADD(NOW(), INTERVAL 4 HOUR) as expireTm')
            ->join('cb_cmall_item as i','i.cit_id = d.cit_id','inner')
            ->join('cb_cmall_item_meta_v as p','p.cit_id = d.cit_id','left')
            ->where($where)
            ->limit(3);

        $qry = $this->db->get('cmall_order_detail as cb_d');

        $result = $qry->result_array();
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
}
