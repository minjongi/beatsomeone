<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cmall item relation model class
 *
 * Copyright (c) Inpreter
 *
 * @author Inpreter (empicy@gmail.com)
 */

class
Cmall_item_relation_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cmall_item_relation';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cir_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

    public function get_relation_list($config)
    {

        $where['cb_r.cit_id'] = element('cit_id', $config);

        $this->db->join('cb_cmall_item as i','i.cit_id = r.cit_id_r','left');

        $this->db->select('cb_r.*, i.cit_file_1 as img, i.cit_key, i.cit_name ');
        $this->db->where($where);
        //$this->db->limit($limit);
        $this->db->order_by('cb_r.cit_id_r', 'asc');
        $qry = $this->db->get($this->_table . ' as cb_r');
        $result = $qry->result_array();

        return $result;
    }

    public function add_relation($config)
    {

        $data = array(
            "cit_id" => element('cit_id', $config),
            "cit_id_r" => element('cit_id_r', $config),
        );
        $result = $this->db->insert($this->_table, $data);

        return $result;
    }

    public function remove_relation($config)
    {

        $where = array(
            "cir_id" => element('cir_id', $config),

        );
        $this->db->where($where);
        $result = $this->db->delete($this->_table);

        return $result;
    }

}
