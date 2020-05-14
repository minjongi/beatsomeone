<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Promo_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'promo';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $meta_code = 'code';


	function __construct()
	{
		parent::__construct();
	}

	public function get_code($code = '', $select = '')
	{
		if (empty($code)) {
			return false;
		}
		$where = array('code' => $code);
		return $this->get_one('', $select, $where);
	}

	public function use_code($code = '')
	{
		if (empty($code)) {
			return false;
		}
		$update = array('useyn' => 'y');
        $where = array('code' => $code);
        #return $this->db->update('cb_promo', $update, $where);
        return $this->update('', $update, $where);
	}

}
