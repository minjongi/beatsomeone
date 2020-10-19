<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Group Member model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Member_group_member_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'member_group_member';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'mgm_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

    function get_with_group($mem_id)
    {
        $this->db->from('member_group_member as mgm');
        $this->db->join('member_group as mg','mg.mgr_id=mgm.mgr_id','left');
        $this->db->where('mgm.mem_id', $mem_id);
        $qry = $this->db->get();

        $result = $qry->result_array();
        return $result;
    }
}
